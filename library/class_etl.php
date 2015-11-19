<?
/**************************************************************************************** 
Autor: Rondomar Silva Fran�a
Empresa: PMTraining
Data: 8 de novembro de 2005
Alterado por: Gelson
*****************************************************************************************


A classe ETL tem o objetivo de seguir o processo ETL - Extra��o, Transforma��o e Carga de Dados.
Foi criado um diret�rio (txt/) onde dever�o ser salvo os aquivos ".txt".
para atualiza��o da base de dados do "sistema homebank" do site http://www.crediembrapa.com.br/.

A l�gica primitiva �:
- L� diret�rio;
- Conferir nome do arquivo .txt com o mesmo no sistema;
- Abrir arquivo de texto;
- Verificar estrutura e m�scaras dos registros;
- Abre banco MySQL;
- L� estrutura da tabela;
- Valida estrutura da tabela com as m�scaras do registro;
- Montar QUERY SQL;
- Procurar por relacionamentos;
- Inserir FK (chave estrangeiro se existir);
- Fechar conex�o
*/

class ETL{
	/* Vari�veis para manipula��o do arquivo TXT */
	var $TxtDiretorio;
	var $TxtNomeConf;
	var $TxtArquivo;
	var $TxtRegistros;
	var $TxtRegistrosTotal;
	
	
	/* Dados de conex�o com o banco */
	var $DbHost;
	var $DbUser;
	var $DbPass;
	var $DbDataBase;
	var $DbTabela;
	var $tiposql;
	var $campochave01;
	
	/*
	Vari�veis Arrays passadas pelo arquivo que cont�m as informa��es do arquivo de texto,
	incluindo: Linha Inicial, Tamanho Registro, Nome Tabela, Tipo de Arquivo(S=string,N=numero,D=data).
	*/
	var $ArrayDetalhe;
	var $ArrayDetalheTotal;
	
	// Flag Booleano
	var $FlagResultado = false;
	
	// Construtor da Classe ETL, executa verifica�es b�sicas.
	function ETL($Detalhe,$ArrayConf)
	{		
		/* Valida diret�rio e nome do arquivo txt */
		if(is_array($ArrayConf))
		{
			
			if(is_array($Detalhe))
			{
				
				// N�o imp�e limite no tempo de execu��o do script
				set_time_limit(0);
				
				ini_set('mysql.connect_timeout',0);
				
				
				// Atribui valores as vari�veis do tipo TXT
				$this->TxtDiretorio = $ArrayConf['diretorio'];
				$this->TxtNomeConf = $ArrayConf['nome'];
				$this->DbTabela = $ArrayConf['tabela'];
				$this->tiposql = $ArrayConf['tiposql'];
				$this->campochave01 = $ArrayConf['campochave01'];
				
				
				// Atribui valores as vari�veis do tipo Detalhe
				$this->ArrayDetalheTotal = count($Detalhe);

				$this->ArrayDetalhe = $Detalhe;
				
				if($this->ListaDiretorio())
				{ // Valida diret�rio 				 
					if($this->ListaRegistros())
					{ // Valida arquivo txt, verifica se existe.					  
						
						if($this->TrataRegistros())
						{// Trata registros do arquivo txt
							return $this->FlagResultado = true;
						}else{$this->Mensagem("O arquivo est� vazio.");}
						
					}else{echo "teste3";}
				}else{$this->Mensagem("O diret�rio ou arquivo especificado n�o existe.");} 
			}else{$this->Mensagem("As vari�veis do tipo 'detalhe' n�o foram setadas.");	}
		}else{$this->Mensagem("As vari�veis do tipo 'arquivo' n�o foram setadas.");}
		
		// Se n�o retornar verdadeiro, mata processo.
		return $this->FlagResultado = false;
	}
	
	// Fun��o respons�vel pelo processo de inser��o de registros no DB
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
							
							// Variaveis respons�veis pela inser��o no DB
							$ini = $this->ArrayDetalhe[$w]['incial']-1;
							$fim = $this->ArrayDetalhe[$w]['tamanho'];
							$campo = $this->ArrayDetalhe[$w]['campo'];
							$tipo = $this->ArrayDetalhe[$w]['tipo'];
							$registro = substr($this->TxtRegistros[$r],$ini,$fim);
							
							// Critica na tabela de endere�o
							if ($this->DbTabela == "cliente")
						    {
                             // echo "campo: ".$campo." ".$registro."<BR>";
							  if ($campo == "tipoendereco")
                              {
                                if ($registro == 0)
                                  $endercocli = $registro;
								  
                              }
                            }
							
                            // Verifica se o campo da tabela � um valor (17 posi��es) e formata o valor.
							if ($this->ArrayDetalhe[$w]['tipo']=='n')
  							  if (strlen($registro) == 17)
							  {
							     $registro = substr($registro, 0, -2).".".substr($registro, -2);
							  }
							  
							// Verifica se o campo da tabela � um valor (12 posi��es) e formata o valor.  
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
                              
							  //VERIFICA SE O CAMPO � DO TIPO DATA "d"					   
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
							   
							   //VERIFICA SE O CAMPO � DO TIPO DATA "d"					   
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
						  
						  
						  
						  // Verifica se o cliente j� existe.
						  $sqlexist = "select codcliente from cliente where codcliente = $codcliente1";
                          $qry1 = @mysql_query($sqlexist);
                          $rc1 = @mysql_fetch_array($qry1);						  						  
						  
						  if (!($rc1 == 0))
					        $QueryRefinada = $sqlupdate;	
							 
						  // Verifica se o cliente j� tem senha
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
						
						// Verificar se � conta corrente e inserir o valor e a data do saldo na tabela de movimenta��o da conta
						if ($this->DbTabela == "contacorrente")
						{
						    // Grava na tabela de movimenta��o do saldo da conta corrente
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
						
					}else{$this->Mensagem("As vari�veis do tipo 'detalhe' n�o cont�m valor.");}
				}
						
				// Mensagem do resultado final do processo.
				$msg = "<strong>Total de registros inseridos</strong>: ".$IdRegInseridos."<br/>";
				$msg.= "<strong>Total de registros n�o inseridos</strong>: ".$IdRegNaoInseridos."<br/>";
				$msg.= "<strong>Log n�o inseridos</strong>: ".$LogNaoInseridos;
				
				// Mostra mensagem do resultado do processo.
				$this->Mensagem($msg);				

				// Fecha conex�o com o DB
				$this->Conexao('close');
				
			}else{$this->Mensagem("N�o foi poss�vel estabelecer uma conex�o com o Banco de Dados.");}							
 		}
	}
	
	function TrataData($registro){
		// Tamanho do campo DATA
		$TamanhoDt = strlen($registro);

		// Data no formato padr�o
		$resDados = "'0000-00-00'";
		
		// Divide a data em partes e monta um Array no padr�o MySQL
		if($ExplodeDt = explode("/",$registro)){
			if(count($ExplodeDt)==3){
				$ExpDia = $ExplodeDt[0]; // Dia
				$ExpMes = $ExplodeDt[1]; // M�s
				$ExpAno = $ExplodeDt[2]; // Ano									

				//Por precaus�o valida se o ano � maior que 4, evitando assim
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
	
	// Retorna mensagens ao usu�rio
	function Mensagem($Msg){
		echo($Msg);
	}
	
	// Verifica se o arquivo .txt cont�m registro.
	function TrataRegistros(){
		$this->TxtRegistrosTotal = count($this->TxtRegistros);
		if($this->TxtRegistrosTotal > 0){
			return $this->FlagResultado = true;
		}
		return $this->FlagResultado = false;
	}
	
	// Abre e fecha conex�o com o banco de dados;
	function Conexao($tipo='close')
	{
		if($tipo=='open')
		{
			// dados de conex�o do DB MySQL
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
	
	// Fun��o respons�vel pela abertura do arquivo .txt.
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
	Fun��o respons�vel pela valida��o do diret�rio e localiza��o do arquivo .txt.
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
