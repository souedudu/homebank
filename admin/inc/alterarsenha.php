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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuario SET dessenha=%s WHERE codusuario=%s",
                       GetSQLValueString($_POST['dessenha'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($updateSQL, $homebank_conecta) or die(mysql_error());

  $updateGoTo = "/homebank2/admin/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  echo '<script language="JavaScript" type="text/javascript">
  	alert("Senha alterada com sucesso");
  	location.href="'.$updateGoTo.'";
  </script>';

}

$colname_usuario = "-1";
if (isset($_SESSION['codusuarioadm'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['codusuarioadm'] : addslashes($_SESSION['codusuarioadm']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_usuario = sprintf("SELECT codusuario, desusuario, dessenha FROM usuario WHERE codusuario = %s", $colname_usuario);
$usuario = mysql_query($query_usuario, $homebank_conecta) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.desusuario.value =='')
  {
    alert('Campo Nome obrigatório.');
    document.form.desusuario.focus();
    return false;
  }
  if (document.form.dessenha.value =='')
  {
    alert('Campo Senha obrigatório.');
    document.form.dessenha.focus();
    return false;
  }
  if (document.form.desfuncao.value =='')
  {
    alert('Campo Função obrigatório.');
    document.form.desfuncao.focus();
    return false;
  }


}
</script>
</head>

<body>
<br /><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<table width="580" border="1" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b>Alterar Senha</b></strong></td>
  </tr>
</table>
<br />
<table width="580" class="table"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="right" width="80" class="td3">Nome</td>
    <td class="td4">&nbsp;
        <input name="desusuario" value="<?php echo $row_usuario['desusuario']; ?>" type="text" id="desusuario" size="20" maxlength="15" disabled="disabled" /></td>
  </tr>
  <tr>
    <td width="5"></td>
    <td align="right" width="80" class="td3">Senha</td>
    <td class="td4">&nbsp;
        <input name="dessenha" type="password" id="dessenha" value="<?php echo $row_usuario['dessenha']; ?>" size="10" maxlength="8" />
      <input name="cod" type="hidden" id="cod" value="<?php echo $row_usuario['codusuario']; ?>" /></td>
  </tr>
</table>
<table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
	 <td  width="80"><input type="submit" name="Submit" value="Gravar" /></td>
    <td><input name="button" type="button" onclick="javascript:(history.back(-1))" value="Cancelar" /></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($usuario);
?>
