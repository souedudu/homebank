<?php session_start();

require_once("../../library/config.php");
require_once("../../Connections/homebank_conecta.php");?>
<?php

mysql_select_db(conexao_db, $homebank_conecta);

$sql = "select codtecnicoresp from solicitacaoserv "." WHERE `codsolicitacao` =".$_GET['solicitacao'];
$rsqry1 = mysql_query($sql, $homebank_conecta) or die(mysql_error());
$dadosconta = mysql_fetch_array($rsqry1);	


$sql="UPDATE `solicitacaoserv` SET `codtecnicoresp` = '".$_GET['tecnico']."' WHERE `codsolicitacao` =".$_GET['solicitacao'];
mysql_query($sql, $homebank_conecta) or die(mysql_error());

echo $sql = "insert historicotecn (codsolicitacao,codusuarioadm,codtecnicorespantigo,codtecnicorespatual) values (".$_GET['solicitacao'].",".$_SESSION['codusuarioadm'].",'".$dadosconta['codtecnicoresp']."','".$_GET['tecnico']."');";
mysql_query($sql, $homebank_conecta) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body onload="location.href='../ver.php?cod=<?php echo $_GET['solicitacao'];?>';">
</body>
</html>
