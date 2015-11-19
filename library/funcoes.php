<?
// Abre ou Fecha conexão com o Banco de dados, seleciona o banco de dados tb.
function Conexao($opcao='close',$host='',$user='',$pass='',$database=''){
   
// Se opção=open então abre conexão com o banco
	if($opcao=='open'){
		// Se os dados passados são validos então abre banco.
		if($conex = mysql_connect($host,$user,$pass)){
			mysql_select_db($database);
			return true;
		}else{
			return false;
		}
	}else{
		// Fecha conexao
		mysql_close();
		return true;
	}
	return false;
}

// Verifica se o registro existe
function VerificaRegistro($query=""){
	if($query != ""){
		if($Query[0] = mysql_query($query)){

			// Retorna o numero de registros encontrados	
			$Query[1] = mysql_num_rows($Query[0]);
			// Libera a query da memória
			mysql_free_result($Query[0]);
			return $Query[1];
		}
	}
	return false;
}
function FormataData($data='',$formato='pt'){
	// Se a data vier vazia, preencher com a atual
	if($data=='')$data=date('d/m/Y');

	switch($formato){
		case 'en':
			// Formato 2005-11-11
			$dia = substr($data,0,2);
			$mes = substr($data,3,2);
			$ano = substr($data,6,4);
			$data = $ano."-".$mes."-".$dia;
			break;
		case 'pt':
			// 2003-11-21 00:00:00
			// Formato 11/11/2005
			$dia = substr($data,8,2);
			$mes = substr($data,5,2);
			$ano = substr($data,0,4);
			$data = $dia."/".$mes."/".$ano;
			break;
	}
	return $data;
}

// Incremeta n dias em uma data
function incdata($dias,$datahoje)
{ 

  if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $datahoje, $sep)) 
  { 
  $dia = $sep[1]; 
  $mes = $sep[2]; 
  $ano = $sep[3]; 
  } else 
  { 
    echo "<b>Formato Inválido de Data - $datahoje</b><br>"; 
  } 

  $i = $dias; 

  for($i = 0;$i<$dias;$i++)
  { 

    if ($mes == "01" || $mes == "03" || $mes == "05" || $mes == "07" || $mes == "08" || $mes == "10" || $mes == "12")
	{ 
      if($mes == 12 && $dia == 31){ 
        $mes = 01; 
        $ano++; 
        $dia = 00; 
      } 
    if($dia == 31 && $mes != 12){ 
      $mes++; 
      $dia = 00; 
    } 
  }

  if($mes == "04" || $mes == "06" || $mes == "09" || $mes == "11")
  { 
    if($dia == 30)
	{ 
      $dia = 00; 
      $mes++; 
    } 
  }

  if($mes == "02")
  { 
    if($ano % 4 == 0 && $ano % 100 != 0)
	{ 
      if($dia == 29)
	  { 
        $dia = 00; 
        $mes++;       
      } 
    } 
    else{ 
      if($dia == 28)
	  { 
        $dia = 00; 
        $mes++; 
      } 
    } 
  } 

  $dia++; 

  } 


  if(strlen($dia) == 1){$dia = "0".$dia;}; 
  if(strlen($mes) == 1){$mes = "0".$mes;}; 


  $nova_data = $dia."/".$mes."/".$ano; 

  echo $nova_data; 

}


function SQL($tabela,$tipo,$campos,$campoChave=''){
//ex: SQL(texto,insert,'titulo,chamada,texto')
//var campoChave apenas para update e delete
//valores possiveis para tipo: insert,update e delete
//os valores são buscados via request e devem ter o mesmo nome dos campos da tabela
	$camposArray = split(",",$campos);
	switch($tipo){
		case "insert":			
			$nomes = "";
			$valores = "";
			foreach($camposArray as $a)
			{
				if(strpos($a,"="))
				{
					$tmp = split("=",$a);
					$nomes .= $tmp[0].",";
					$valores .= '"'.$tmp[1].'",';
				}else
				{
					$nomes .= $a.",";
					$valores .= '"'.$_REQUEST[$a].'",';
				}
			}
			$nomes = substr($nomes,0,strlen($nomes)-1);
			$valores = substr($valores,0,strlen($valores)-1);
			$sql = "insert into $tabela ($nomes) values($valores)";
		break;
		case "update":
		
			$nomes = "";
			$valores = "";
			foreach($camposArray as $a){
				if(strpos($a,"=")){
					$tmp = split("=",$a);
					$valores .= $tmp[0].'="'.$tmp[1].'",';
				}else{
					$valores .= $a.'="'.$_REQUEST[$a].'",';
				}
			}			
			$valores = substr($valores,0,strlen($valores)-1);
			
			if(strpos($campoChave,"=")){
					$tmp = split("=",$campoChave);
					$Key = $tmp[0].'='.$tmp[1];
				}else{
					$Key .= $campoChave.'='.$_REQUEST[$campoChave];
				}
			
			
			$sql = "update $tabela set $valores where $Key";
		
		
		
		
		/*
			$cmp = split(",",$campos);
			$sql = "update $tabela set ";
			foreach($cmp as $a){
				$sql.= $a."='".$_REQUEST[$a]."', ";				
			}
			$sql = substr($sql,0,strlen($sql)-2);
			$sql .= " where $campoChave = ".$_REQUEST[$campoChave];			
			*/
		break;
		case "delete":
				if(strpos($campoChave,"=")){
					$tmp = split("=",$campoChave);
					$valores .= $tmp[0].'='.$tmp[1];
				}else{
					$valores .= $campoChave.'='.$_REQUEST[$campoChave];
				}
		
			$sql = "delete from $tabela where $valores";
	}
	return $sql;



}

/*****************************************************************************
* Autor: Gelson S. Rodrigues
* Recupera o nome do usuário que fez a solicitação de serviço
* a partir do código da solicitação
******************************************************************************/
function RecUsuarioSol($codsolservico)
{
  if ($codsolservico == "")
  {
    return "Código da solicitação vazio";
  }
  
  $sqlfunc = "select codcliente, codtecnicosol From solicitacaoserv where codsolicitacao = ".$codsolservico;
  $queryfun = mysql_query($sqlfunc);
  $rsresultfun = mysql_fetch_array($queryfun);  
  
  if (($rsresultfun == 0))	 
  {
    return "Solicitação não cadastrada.";
  } 
  
  // Verifica se foi o cliente que fez a solicitação
  if ($rsresultfun['codcliente'] != "")
  {
	 // Recupera o nome e a conta corrente do solicitante
     $sqlfunc2 = "select c.nomcliente, cc.numcontacorrente from contacorrente cc, cliente c
	               where cc.codcliente = ".$rsresultfun['codcliente'].
				  " and cc.codcliente = c.codcliente";  
     $queryfun2 = mysql_query($sqlfunc2);
     $rsresultfun2 = mysql_fetch_array($queryfun2);	  
	 return $rsresultfun2['numcontacorrente'] . " - " .$rsresultfun2['nomcliente']; 
  }
  
  // Verifica se foi o tecnico que fez a solicitação  
  if ($rsresultfun['codtecnicosol'] != "")
  {
     // Recupera o nome e código do tecnico 
       $sqlfunc3 = "select nomtecnicoresp from tecnicoresp where codtecnicoresp = ".$rsresultfun['codtecnicosol'];
       $queryfun3 = mysql_query($sqlfunc3);
       $rsresultfun3 = mysql_fetch_array($queryfun3);
       return $rsresultfun['codtecnicosol'] . " - " .$rsresultfun3['nomtecnicoresp']; 
  }  
}


/*****************************************************************************
* Autor: Gelson S. Rodrigues
* Formata a conta corrente do cliente
******************************************************************************/
function Formatacc($cc)
{
   if ($cc == "")
     return "";
	 
   if (!(is_numeric($cc)))
   	 return $cc;
	 
    return substr(str_pad($cc, 5, "0", STR_PAD_LEFT), 0, -1)."-".substr($cc, -1);   
	
}

function FormataContrato($cc)
{
   if ($cc == "")
     return "";
	 
   if (!(is_numeric($cc)))
   	 return $cc;
	 
    return str_pad($cc, 8, "0", STR_PAD_LEFT);
	
}

function Formatacpfcnpj($c)
{ 
   if ($c == "")
     return "";
	 
   if (!(is_numeric($c)))
   	 return $c;
	
   if (strlen($c) < 11)
     return $c;
   
   	 
   if (strlen($c)==11)
   {
       // Formatando CPF	 
       $cpf =    substr("$c", 0,3); // 999 
       $cpf.=".".substr("$c", 3,3); // 999.999 
       $cpf.=".".substr("$c", 6,3); // 999.999.999 
       $cpf.="-".substr("$c", 9,2); // 999.999.999-99 
       return $cpf;
   }
   
   if (strlen($c)==14) 
   {
       // Formatando CNPJ
       $cnpj = $substr($c, 0, 2);
       $cnpj.=".".$substr($c, 2, 3);
       $cnpj.=".".$substr($c, 5, 3);
       $cnpj.="/".$substr($c, 8, 4);
       $cnpj.="-".$substr($c, 12, 2); 
	   return $cnpj;
	}

   
} 

?>
