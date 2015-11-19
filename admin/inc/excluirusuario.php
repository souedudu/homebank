<?php virtual('../library/config.php'); ?>
<?php virtual('../Connections/homebank_conecta.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_GET['cod'])) && ($_GET['cod'] != "")) {
  $deleteSQL = sprintf("DELETE FROM usuario WHERE codusuario=%s",
                       GetSQLValueString($_GET['cod'], "int"));

  mysql_select_db(conexao_db, $homebank_conecta);
  $Result1 = mysql_query($deleteSQL, $homebank_conecta) or die(mysql_error());
}

if ((isset($_GET['cod'])) && ($_GET['cod'] != "")) {
  $deleteSQL = sprintf("DELETE FROM acessousu WHERE codusuario=%s",
                       GetSQLValueString($_GET['cod'], "int"));

  mysql_select_db(conexao_db, $homebank_conecta);
  $Result1 = mysql_query($deleteSQL, $homebank_conecta) or die(mysql_error());
}
?>
Aguarde...
<script language="JavaScript" type="text/javascript">
location.href="listausuarios.php";
</script>

