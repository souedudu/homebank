<?
/**************************************************************************************** 
Autor: Rondomar Silva França
Empresa: PMTraining
Data: 8 de novembro de 2005
Alterado por: Gelson
*****************************************************************************************


A classe ETL tem o objetivo de seguir o processo ETL - Extração, Transformação e Carga de Dados.
Foi criado um diretório (txt/) onde deverão ser salvo os aquivos ".txt".
para atualização da base de dados do "sistema homebank" do site http://www.crediembrapa.com.br/.

A lógica primitiva é:
- Lê diretório;
- Conferir nome do arquivo .txt com o mesmo no sistema;
- Abrir arquivo de texto;
- Verificar estrutura e máscaras dos registros;
- Abre banco MySQL;
- Lê estrutura da tabela;
- Valida estrutura da tabela com as máscaras do registro;
- Montar QUERY SQL;
- Procurar por relacionamentos;
- Inserir FK (chave estrangeiro se existir);
- Fechar conexão
*/

class ETL{
	/* Variáveis para manipulação do arquivo TXT */
	var $TxtDiretorio;
	var $TxtNomeConf;
	var $TxtArquivo;
	var $TxtRegistros;
	var $TxtRegistrosTotal;
	
	
	/* Dados de conexão com o banco */
	var $DbHost;
	var $DbUser;
	var $DbPass;
	var $DbDataBase;
	var $DbTabela;
	var $tiposql;
	var $campochave01;
	
	/*
	Variáveis Arrays passadas pelo arquivo que contém as informações do arquivo de texto,
	incluindo: Linha Inicial, Tamanho Registro, Nome Tabela, Tipo de Arquivo(S=string,N=numero,D=data).
	*/
	var $ArrayDetalhe;
	var $ArrayDetalheTotal;
	
	// Flag Booleano
	var $FlagResultado = false;
	
	// Construtor da Classe ETL, executa verificaões básicas.
	function ETL($Detalhe,$ArrayConf)
	{		
		/* Valida diretório e nome do arquivo txt */
		if(is_array($ArrayConf))
		{
			
			if(is_array($Detalhe))
			{
				
				// Não impõe limite no tempo de execução do script
				set_time_limit(0);
				
				ini_set('mysql.connect_timeout',0);
				
				
				// Atribui valores as variáveis do tipo TXT
				$this->TxtDiretorio = $ArrayConf['diretorio'];
				$this->TxtNomeConf = $ArrayConf['nome'];
				$this->DbTabela = $ArrayConf['tabela'];
				$this->tiposql = $ArrayConf['tiposql'];
				$this->campochave01 = $ArrayConf['campochave01'];
				
				
				// Atribui valores as variáveis do tipo Detalhe
				$this->ArrayDetalheTotal = count($Detalhe);

				$this->ArrayDetalhe = $Detalhe;
				
				if($this->ListaDiretorio())
				{ // Valida diretório 				 
					if($this->ListaRegistros())
					{ // Valida arquivo txt, verifica se existe.					  
						
						if($this->TrataRegistros())
						{// Trata registros do arquivo txt
							return $this->FlagResultado = true;
						}else{$this->Mensagem("O arquivo está vazio.");}
						
					}else{echo "teste3";}
				}else{$this->Mensagem("O diretório ou arquivo especificado não existe.");} 
			}else{$this->Mensagem("As variáveis do tipo 'detalhe' não foram setadas.");	}
		}else{$this->Mensagem("As variáveis do tipo 'arquivo' não foram setadas.");}
		
		// Se não retornar verdadeiro, mata processo.
		return $this->FlagResultado = false;
	}
	
	// Função responsável pelo processo de inserção de registros no DB
	function CarregaRegistro()
	{		
		if($this->FlagResultado)
		{
			if($this->Conexao('open'))
			{
				$IdRegInseridos = 0;
				$IdRegNaoInseridos = 0;
				$LogNaoInseridos = '';
				$endercocli = '';
				
				for($r=0; $r < $this->TxtRegistrosTotal-1; $r++)
				{
					if($this->ArrayDetalheTotal > 0)
					{
						$resDados = "";
						$sqlupdate = "";
						$whereupdate = "";
						
						for($w=1; $w <= $this->ArrayDetalheTotal; $w++)
						{							 																					
							// Coleta o tamanho da linha do registro no arquivo .txt
							$tamanhoRegistro = strlen($this->TxtRegistros[$r]);
							
							// Variaveis responsáveis pela inserção no DB
							$ini = $this->ArrayDetalhe[$w]['incial']-1;
							$fim = $this->ArrayDetalhe[$w]['tamanho'];
							$campo = $this->ArrayDetalhe[$w]['campo'];
							$tipo = $this->ArrayDetalhe[$w]['tipo'];
							$registro = substr($this->TxtRegistros[$r],$ini,$fim);
							
							// Critica na tabela de endereço
							if ($this->DbTabela == "cliente")
						    {
                             // echo "campo: ".$campo." ".$registro."<BR>";
							  if ($campo == "tipoendereco")
                              {
                                if ($registro == 0)
                                  $endercocli = $registro;
								  
                              }
                            }
							
                            // Verifica se o campo da tabela é um valor (17 posições) e formata o valor.
							if ($this->ArrayDetalhe[$w]['tipo']=='n')
  							  if (strlen($registro) == 17)
							  {
							     $registro = substr($registro, 0, -2).".".substr($registro, -2);
							  }
							  
							// Verifica se o campo da tabela é um valor (12 posições) e formata o valor.  
							if ($this->ArrayDetalhe[$w]['tipo']=='n')
  							  if (strlen($registro) == 12)
							  {
							     $registro = substr($registro, 0, -4).".".substr($registro, -4);
							  }							  
						   																		
							// Tratamento de campo, coloca aspas no tipo string 
							if($this->ArrayDetalhe[$w]['tipo']=='s')
							{
								$resDados.="'".$registro."'";
							}elseif($this->ArrayDetalhe[$w]['tipo']=='n')
							{
								// tipos de campo inteiro ficam sem aspas
								$resDados.=$registro;
							}elseif($this->ArrayDetalhe[$w]['tipo']=='d')
							{
								// Regra especial para datas, formata a data no formato EN(yyyy-mm-dd)
								if(!empty($registro))
								{
									$resDados.=$this->TrataData($registro);
								}else
								{
									$resDados.='0000-00-00';
								}
							}																				
							
							// Monta Sql para Update
							if ($this->tiposql == 2)
							{
							   $sqlupdate = $sqlupdate.$campo." = "."'".$registro."', ";
							   
							   if ($campo == $this->campochave01)
							   {
							     $whereupdate = $whereupdate.$campo." = "."'".$registro."' and ";
							   }
							}

							// Critica na tabela de conta corrente
							if ($this->DbTabela == "contacorrente")
						    {
                              
							  //VERIFICA SE O CAMPO É DO TIPO DATA "d"					   
						  	  if ($this->ArrayDetalhe[$w]['tipo']=='d'){
							   		$registro=$this->TrataData($registro);
									$registro=substr($registro, 1,10);
									//echo "registro: ".$registro."<BR>";							   
							  }
							  
							  // Critica na tabela de movcontacorrente
							  if ($count7 == "")
						    	{
							 	 $sqldelete = "delete from movcontacorrente";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count7=1;                          		  
                            	}
							  							  							  
							  if ($campo == "numcontacorrente")
                                $numcontacorrente1 = $registro;
								

                              if ($campo == "datultmovconta"){
                                $datultmovconta1 = $this->TrataData($registro);								
								}
								
                              if ($campo == "vlsaldodispatual")
                                $vlsaldodispatual1 = $registro;

							   $sqlupdate = $sqlupdate.$campo." = "."'".$registro."', ";
							   
							   if ($campo == $this->campochave01)
							   {
							     $whereupdate = $whereupdate.$campo." = ".$registro." and ";
							   }
                            }
								
							// Critica na tabela de cliente
							if ($this->DbTabela == "cliente")
						    {
							   
							   //VERIFICA SE O CAMPO É DO TIPO DATA "d"					   
							   if ($this->ArrayDetalhe[$w]['tipo']=='d'){
							   		$registro=$this->TrataData($registro);
									$registro=substr($registro, 1,10);
									//echo "registro: ".$registro."<BR>";
							   
							   }
							   $sqlupdate = $sqlupdate.$campo." = "."'".$registro."', ";
							   if ($campo == $this->campochave01)
							   {
							     $codcliente1 = $registro;
							     $whereupdate = $whereupdate.$campo." = ".$registro." and ";
							   }
							   
							   if ($campo == "numcpfcnpj")
							     $numcpfcnpj1 = $registro;
                            }
							
							// Critica na tabela de lancamentosccapital
							
							if ($this->DbTabela == "lancamentosccapital" && $count != 1)
						    {
							 	 
								 $sqldelete = "delete from lancamentosccapital";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count=1;                          		  
                            }																																																
							
							// Critica na tabela de aplicacaocaprem
							if ($this->DbTabela == "aplicacaocaprem" && $count2 == "")
						    {
							 	 $sqldelete = "delete from aplicacaocaprem";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count2=1;                          		  
                            }
							
							// Critica na tabela de lancamentocaprem
							if ($this->DbTabela == "lancamentocaprem" && $count3 == "")
						    {
							 	 $sqldelete = "delete from lancamentocaprem";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count3=1;                          		  
                            }																										
							
							// Critica na tabela de contratocredito
							if ($this->DbTabela == "contratocredito" && $count5 == "")
						    {
							 	 $sqldelete = "delete from contratocredito";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count5=1;                          		  
                            }
							
							// Critica na tabela de lancamentocaprem
							if ($this->DbTabela == "contacapital" && $count8 == "")
						    {
							 	 $sqldelete = "delete from contacapital";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $count8=1;                          		  
                            }
																					
							if ($this->DbTabela == "contacapitalremunerada" && $countAux == "")
						    {							 	 								 
								 $sqldelete = "delete from contacapitalremunerada";
                          		 $qrydelete = @mysql_query($sqldelete);
								 $countAux=1;                          		  
                            }																												
																					
							// Coloca sepador "," nos valores ou se chegar no fim coloca parentese ")"
							if(($w+1) > $this->ArrayDetalheTotal)
							{
								$resDados.=")";
							}else
							{
								$resDados.=",";
							}
							// Fim separador
						}

						// Monta Query SQL para inserir no registro	
					    $InsertReg = $this->MontaQuery();	
   				        $QueryRefinada = $InsertReg.$resDados.";";
						
						if ($this->tiposql == 2)
						{											
  						  // Monta Query SQL para update no registro
						  $whereupdate = "where ".substr($whereupdate, 0, -4);
						  $sqlupdate = "update ".$this->DbTabela." set ".$sqlupdate; 
						  $sqlupdate = substr($sqlupdate, 0, -2);
						
						  $sqlupdate = $sqlupdate." ".$whereupdate;
						  $QueryRefinada = $sqlupdate;
						  
						  $aux = 1;
						}
						
						// Verificar se o cliente existe, Se existir atualizar os dados do cliente
						if ($this->DbTabela == "cliente")
						{
						  if (! $aux == 1){
						  
						  	$whereupdate = "where ".substr($whereupdate, 0, -4);
						  	$sqlupdate = "update ".$this->DbTabela." set ".$sqlupdate; 
						  	$sqlupdate = substr($sqlupdate, 0, -2);						
						  	$sqlupdate = $sqlupdate." ".$whereupdate;
						  
						  }
						  
						  
						  
						  // Verifica se o cliente já existe.
						  $sqlexist = "select codcliente from cliente where codcliente = $codcliente1";
                          $qry1 = @mysql_query($sqlexist);
                          $rc1 = @mysql_fetch_array($qry1);						  						  
						  
						  if (!($rc1 == 0))
					        $QueryRefinada = $sqlupdate;	
							 
						  // Verifica se o cliente já tem senha
						  $sqlsenha = "select codcliente from senhacliente where codcliente = $codcliente1";
                          $qry1senha = @mysql_query($sqlsenha);
                          $rc1senha = @mysql_fetch_array($qry1senha);						  						  
						  
						  if ($rc1senha == 0)
						  {
						    // Inclui senha
							$dessenha = substr($numcpfcnpj1, 0, 6);
							$sqlincsenha = "insert into senhacliente (codcliente, dessenha) values ('$codcliente1', '$dessenha')";
                            @mysql_query($sqlincsenha);							
						  }
						  						  					
						}
						
						// Verificar se é conta corrente e inserir o valor e a data do saldo na tabela de movimentação da conta
						if ($this->DbTabela == "contacorrente")
						{
						    // Grava na tabela de movimentação do saldo da conta corrente
							$sqlinsertcc = "insert into movcontacorrente (numcontacorrente, datultmovconta, vlsaldodispatual) values ('$numcontacorrente1', $datultmovconta1, '$vlsaldodispatual1')";

                          @mysql_query($sqlinsertcc);						  						  
							  
						  $whereupdate = "where ".substr($whereupdate, 0, -4);
						  $sqlupdate = "update ".$this->DbTabela." set ".$sqlupdate; 
						  $sqlupdate = substr($sqlupdate, 0, -2);						
						  $sqlupdate = $sqlupdate." ".$whereupdate;
						  
						  // Verifica se a conta corrente existe.
						  $sqlexist = "select numcontacorrente from contacorrente where numcontacorrente = $numcontacorrente1";
                          $qry1 = @mysql_query($sqlexist);
                          $rc1 = @mysql_fetch_array($qry1);						  						  
						  
						  if (!($rc1 == 0))
						     $QueryRefinada = $sqlupdate;
							 
						}						
						
						
						if ($endercocli == "0")
                        {
                            $endercocli = '';
  						    if($QueRes = @mysql_query($QueryRefinada))
						    {
						  	  $IdRegInseridos++;
						 	  @mysql_free_result($QueRes);
						    }
						    else
						    {
							  $IdRegNaoInseridos++;
							  $LogNaoInseridos.= $QueryRefinada."<br/>";
						    }
						}
						else
                        {
  						  if($QueRes = @mysql_query($QueryRefinada))
						  {
							$IdRegInseridos++;
							@mysql_free_result($QueRes);
						  }
						  else
						  {
							$IdRegNaoInseridos++;
							$LogNaoInseridos.= $QueryRefinada."<br/>";
						  }
						}
						// Fim Query
						
					}else{$this->Mensagem("As variáveis do tipo 'detalhe' não contém valor.");}
				}
						
				// Mensagem do resultado final do processo.
				$msg = "<strong>Total de registros inseridos</strong>: ".$IdRegInseridos."<br/>";
				$msg.= "<strong>Total de registros não inseridos</strong>: ".$IdRegNaoInseridos."<br/>";
				$msg.= "<strong>Log não inseridos</strong>: ".$LogNaoInseridos;
				
				// Mostra mensagem do resultado do processo.
				$this->Mensagem($msg);				

				// Fecha conexão com o DB
				$this->Conexao('close');
				
			}else{$this->Mensagem("Não foi possível estabelecer uma conexão com o Banco de Dados.");}							
 		}
	}
	
	function TrataData($registro){
		// Tamanho do campo DATA
		$TamanhoDt = strlen($registro);

		// Data no formato padrão
		$resDados = "'0000-00-00'";
		
		// Divide a data em partes e monta um Array no padrão MySQL
		if($ExplodeDt = explode("/",$registro)){
			if(count($ExplodeDt)==3){
				$ExpDia = $ExplodeDt[0]; // Dia
				$ExpMes = $ExplodeDt[1]; // Mês
				$ExpAno = $ExplodeDt[2]; // Ano									

				//Por precausão valida se o ano é maior que 4, evitando assim
				//causar erros no tipo de campo DateTime
				if($ExpAno > 4){$ExpAno=substr($ExpAno,0,4);}
				
				// Continua montando a Query...
				$resDados ="'".$ExpAno."-".$ExpMes."-".$ExpDia."'";				
			}
		}
		return $resDados;		
	}
	
	// Monta Query SQL
	function MontaQuery()
	{	    
		$InsertReg = "INSERT INTO ".$this->DbTabela ." (";
		for($q=1; $q <= $this->ArrayDetalheTotal; $q++){
			$InsertReg.=$this->ArrayDetalhe[$q]['campo'];
			if(($q+1) > $this->ArrayDetalheTotal){
				$InsertReg.=")";
			}else{
				$InsertReg.=",";
			}
		}
		return $InsertReg.=" VALUES(";		
	}
	
	// Retorna mensagens ao usuário
	function Mensagem($Msg){
		echo($Msg);
	}
	
	// Verifica se o arquivo .txt contém registro.
	function TrataRegistros(){
		$this->TxtRegistrosTotal = count($this->TxtRegistros);
		if($this->TxtRegistrosTotal > 0){
			return $this->FlagResultado = true;
		}
		return $this->FlagResultado = false;
	}
	
	// Abre e fecha conexão com o banco de dados;
	function Conexao($tipo='close')
	{
		if($tipo=='open')
		{
			// dados de conexão do DB MySQL
			if($conex = @mysql_connect($this->DbHost,$this->DbUser,$this->DbPass))
			{						
				@mysql_select_db($this->DbDataBase,$conex);
				return $this->FlagResultado = true;
			}else
			{
				return $this->FlagResultado = false;
			}
		}else
		{
			@mysql_close($conex);
			return $this->FlagResultado = true;
		}
		return $this->FlagResultado = false;
	}
	
	// Função responsável pela abertura do arquivo .txt.
 	function ListaRegistros(){
		$handle = @fopen ($this->TxtArquivo, "r");				
		if($handle){			
			$conteudo = @fread ($handle, @filesize ($this->TxtArquivo));
			$this->TxtRegistros = @explode(chr(10),$conteudo);
			@fclose ($handle);
			return $this->FlagResultado = true;
		}
		return $this->FlagResultado = false;
		
	}
	
	/*
	Função responsável pela validação do diretório e localização do arquivo .txt.
	*/
 	function ListaDiretorio(){
		if(is_dir($this->TxtDiretorio)){
			if($diraberto = @opendir($this->TxtDiretorio)) {
				while (($file = @readdir($diraberto)) !== false) {
					if(@filetype($this->TxtDiretorio . $file)!="dir"){
						$tQuebraArquivo1 = @explode(".",$file);
						if(@count($tQuebraArquivo1)>0){
							$tQuebraArquivo2 = @explode("_",$tQuebraArquivo1[0]);
							$tArquivo = @strtolower($tQuebraArquivo2[2]);
							if($tArquivo == $this->TxtNomeConf){
								$this->TxtArquivo = $this->TxtDiretorio.$file;
								return $this->FlagResultado = true;
							}
						}
					}
				}
				@closedir($diraberto);
				return $this->FlagResultado = false;
			}	
		}else{
			return $this->FlagResultado = false;
		}
	}
}
?>
