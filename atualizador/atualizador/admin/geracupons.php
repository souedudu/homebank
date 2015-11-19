<?php require_once('../Connections/crediembrapa.php'); ?>
<?php
mysql_select_db($database_crediembrapa, $crediembrapa);
$query_cuponsexistentes = "SELECT cupom FROM sementes_serie0";
$cuponsexistentes = mysql_query($query_cuponsexistentes, $crediembrapa) or die(mysql_error());
$row_cuponsexistentes = mysql_fetch_assoc($cuponsexistentes);
$totalRows_cuponsexistentes = mysql_num_rows($cuponsexistentes);
?>
<?php
do {
	$cp_bd[]=$row_cuponsexistentes['cupom'];
} while ($row_cuponsexistentes = mysql_fetch_assoc($cuponsexistentes));
$x=0;

while($x<$_GET['n_cupons']){
	$a=rand(0,99999);
	if(!in_array($a,$cp_bd)){
		$sorteados[]=$a;
		$cp_bd[]=$a;
		$x=$x+1;
	}
	reset($sorteados);
	reset($cp_bd);
}
reset($sorteados);
reset($cp_bd);
while (list($key, $val) = each($sorteados)){
	$sql="INSERT INTO `sementes_serie0` (`cupom` , `data` , `numero_pessoa`) VALUES ('$val', NOW() , '".$_GET['participante']."')";
	@mysql_query($sql, $crediembrapa) or die($sql.'-----'.mysql_error());
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>$ementes da $orte</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onload="location.href='listacupons.php?participante=<?php echo $_GET['participante'];?>'">

</body>
</html>
<?php
mysql_free_result($cuponsexistentes);
?>
