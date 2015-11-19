<?php include_once("../Connections/crediembrapa.php");?>
<?php
mysql_select_db($database_crediembrapa, $crediembrapa);
$query_delete = "SELECT cod_cupom FROM sementes_serie0 WHERE numero_pessoa = '".$_GET['participante']."' ORDER BY data DESC LIMIT 0,".$_GET['n_cupons'];
$delete = mysql_query($query_delete, $crediembrapa) or die(mysql_error());
$row_delete = mysql_fetch_assoc($delete);
$totalRows_delete = mysql_num_rows($delete);
?>
<?php do {
$sql = "DELETE FROM sementes_serie0 WHERE cod_cupom=".$row_delete['cod_cupom'];
mysql_query($sql,$crediembrapa);
} while ($row_delete = mysql_fetch_assoc($delete)); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body onload="location.href='listacupons.php?participante=<?php echo $_GET['participante'];?>';">
</body>
</html>
