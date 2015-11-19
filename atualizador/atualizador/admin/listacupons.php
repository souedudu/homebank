
<?php require_once('../Connections/crediembrapa.php'); ?>
<?php
$colname_cupons = "-1";
if (isset($_GET['participante'])) {
  $colname_cupons = (get_magic_quotes_gpc()) ? $_GET['participante'] : addslashes($_GET['participante']);
}
mysql_select_db($database_crediembrapa, $crediembrapa);
$query_cupons = sprintf("SELECT cod_cupom, cupom, DATE_FORMAT(`data`,'%%d-%%m-%%Y %%H:%%i') AS data_formatada, sementes_serie0.numero_pessoa AS participante FROM sementes_serie0 WHERE sementes_serie0.numero_pessoa = %s ORDER BY `data` DESC", $colname_cupons);
$cupons = mysql_query($query_cupons, $crediembrapa) or die(mysql_error());
$row_cupons = mysql_fetch_assoc($cupons);
$totalRows_cupons = mysql_num_rows($cupons);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<?php if ($totalRows_cupons > 0) { // Show if recordset not empty ?>
  <table border="1" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td colspan="3" align="center" valign="top"><span class="style2">- Este participante possui <?php echo $totalRows_cupons?> cupons (S&eacute;rie 1) -</span> </td>
    </tr>
    <?php
  $n=1;
  do { ?>
      <tr>
        <td align="right" valign="top" class="style1"><?php echo $n;?>.</td>
        <td align="right" valign="top"><span class="style1"><?php echo substr('00000'.$row_cupons['cupom'],-5); ?></span></td>
        <td align="center" valign="top"><span class="style1"><?php echo $row_cupons['data_formatada']; ?></span></td>
      </tr>
      <?php
	$n=$n+1;
	} while ($row_cupons = mysql_fetch_assoc($cupons)); ?>
  </table>
  <?php }else{?>
  <?php if(isset($_GET['participante']) || $_GET['participante']==0){ ?>
  <div align="center"> <span class="style2">- Este participante n&atilde;o tem cupons  -</span><br />
  </div>
  <?php } ?>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($cupons);
?>
