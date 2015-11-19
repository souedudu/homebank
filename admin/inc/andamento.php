<?php session_start();?>
<?php virtual('/homebank2/Connections/homebank_conecta.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO andamensolicitacao (codsolicitacao, codmenatendimento, codtecnicoresp, descompmensagem, datregandamento, hrregandamento) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codsolicitacao'], "int"),
                       GetSQLValueString($_POST['codmenatendimento'], "int"),
                       GetSQLValueString($_POST['codtecnicoresp'], "int"),
                       GetSQLValueString($_POST['descompmensagem'], "text"),
                       GetSQLValueString($_POST['datregandamento'], "date"),
                       GetSQLValueString($_POST['hrregandamento'], "date"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());

  $insertGoTo = "andamento.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  echo '<script language="JavaScript" type="text/javascript">
location.href="'.$insertGoTo.'";
</script>';

}

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_mensagens = "SELECT mensatendimento.codmenatendimento, mensatendimento.desmenatendimento FROM mensatendimento ORDER BY mensatendimento.desmenatendimento";
$mensagens = mysql_query($query_mensagens, $homebank_conecta) or die(mysql_error());
$row_mensagens = mysql_fetch_assoc($mensagens);
$totalRows_mensagens = mysql_num_rows($mensagens);

$colname_andamentos = "-1";
if (isset($_GET['codsolicitacao'])) {
  $colname_andamentos = (get_magic_quotes_gpc()) ? $_GET['codsolicitacao'] : addslashes($_GET['codsolicitacao']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_andamentos = sprintf("SELECT andamensolicitacao.codandsolicitacao, mensatendimento.desmenatendimento, tecnicoresp.nomtecnicoresp, andamensolicitacao.descompmensagem, DATE_FORMAT(andamensolicitacao.datregandamento,'%%d/%%m/%%Y') AS data_andamento, DATE_FORMAT(andamensolicitacao.hrregandamento,'%%H:%%i') AS hora_andamento FROM andamensolicitacao, mensatendimento, tecnicoresp WHERE mensatendimento.codmenatendimento=andamensolicitacao.codmenatendimento AND andamensolicitacao.codtecnicoresp=tecnicoresp.codtecnicoresp AND andamensolicitacao.codsolicitacao=%s ORDER BY andamensolicitacao.datregandamento DESC, andamensolicitacao.hrregandamento DESC", $colname_andamentos);
$andamentos = mysql_query($query_andamentos, $homebank_conecta) or die(mysql_error());
$row_andamentos = mysql_fetch_assoc($andamentos);
$totalRows_andamentos = mysql_num_rows($andamentos);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnico = "SELECT tecnicoresp.codtecnicoresp, tecnicoresp.nomtecnicoresp FROM tecnicoresp ORDER BY tecnicoresp.nomtecnicoresp";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="/homebank2/admin/site.css" rel="stylesheet" type="text/css" />
</head>
<body>


  <table border="0" cellpadding="0" cellspacing="0">
    <tr><td colspan="2">
	<?php if($_GET['concluida']=='N'){ ?>
	<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td align="left" nowrap>Mensagem de atendimento:<br />
              <select name="codmenatendimento">
                <?php 
do {  
?>
                <option value="<?php echo $row_mensagens['codmenatendimento']?>" ><?php echo $row_mensagens['desmenatendimento']?></option>
                <?php
} while ($row_mensagens = mysql_fetch_assoc($mensagens));
?>
              </select>
              <input type="hidden" name="codtecnicoresp" id="codtecnicoresp" value="<?php echo $_SESSION['codtecnicorespadm'];?>" /></td>
            
          <tr valign="baseline">
            <td align="left" valign="top" nowrap><textarea name="descompmensagem" cols="50" rows="5"></textarea>      </td>
          </tr>
          <tr valign="baseline">
            <td align="center" nowrap><input type="submit" value="Inserir andamento">
              <input type="hidden" name="codsolicitacao" value="<?php echo $_GET['codsolicitacao']; ?>" />
              <input type="hidden" name="datregandamento" value="<?php echo date('Y-m-d');?>" />
              <input type="hidden" name="hrregandamento" value="<?php echo date('H:i');?>" />
              <input type="hidden" name="MM_insert" value="form1" /></td>
            </tr>
          </table>
        </form><?php } ?><hr noshade="noshade" /></td>
    </tr>
	<?php if ($totalRows_andamentos > 0) { // Show if recordset not empty ?>
    <?php do { ?>
      <tr>
        <td align="left" valign="top">T&eacute;cnico:<br /> 
          <?php echo $row_andamentos['nomtecnicoresp']; ?><br />          </span></td>
        <td align="left" valign="top">Data: <?php echo $row_andamentos['data_andamento']; ?><br />
          <?php echo $row_andamentos['hora_andamento']; ?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"><br /><?php echo $row_andamentos['desmenatendimento']; ?></td>
      </tr><tr>
        <td colspan="2" align="left" valign="top"><?php echo $row_andamentos['descompmensagem']; ?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"><br /><hr noshade="noshade" /></td>
      </tr>
      <?php } while ($row_andamentos = mysql_fetch_assoc($andamentos)); ?>
	  <?php }else{ ?>
	  <tr>
	    <td colspan="2" align="center" valign="top"><strong><hr />Ainda n&atilde;o existem andamentos cadastrados nessa solicita&ccedil;&atilde;o<hr /></strong> </td>
	  </tr>
  <?php } // Show if recordset not empty ?>
</table>
</body>
</html>
<?php
mysql_free_result($mensagens);

mysql_free_result($andamentos);

mysql_free_result($tecnico);
?>
