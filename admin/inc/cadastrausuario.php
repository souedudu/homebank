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
  $updateSQL = sprintf("UPDATE usuario SET desusuario=%s, dessenha=%s, flapercadusu=%s, flapercadmenu=%s WHERE codusuario=%s",
                       GetSQLValueString($_POST['desusuariologin'], "text"),
                       GetSQLValueString($_POST['dessenha'], "text"),
                       GetSQLValueString($_POST['flapercadusu'], "text"),
                       GetSQLValueString($_POST['flapercadmenu'], "text"),
                       GetSQLValueString($_POST['codusuario'], "int"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($updateSQL, $homebank_conecta) or die(mysql_error());
  //////////// Altera permissoes
  $sql_permissoes="DELETE FROM acessousu WHERE codusuario=".$_POST['codusuario'];
  mysql_query($sql_permissoes, $homebank_conecta) or die(mysql_error());
  while (list($key, $val) = each($_POST['codmenu'])) {  
  $sql_permissoes="INSERT INTO `acessousu` ( `codusuario` , `codmenu` ) VALUES ('".$_POST['codusuario']."', '".$val."')";
  mysql_query($sql_permissoes, $homebank_conecta) or die(mysql_error());
  }
  ////////////

  $updateGoTo = "listausuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  echo '<script language="JavaScript" type="text/javascript">
location.href="listausuarios.php";
</script>';

}

$colname_usuario = "-1";
if (isset($_GET['codusuario'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_GET['codusuario'] : addslashes($_GET['codusuario']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_usuario = sprintf("SELECT usuario.codusuario, usuario.desusuario, usuario.dessenha, usuario.flapercadusu, usuario.flapercadmenu FROM usuario, menu WHERE usuario.codusuario=%s", $colname_usuario);
$usuario = mysql_query($query_usuario, $homebank_conecta) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_menus = "SELECT menu.codmenu, menu.desmenu FROM menu WHERE menu.flaativo='s' AND menu.codpaimenu > 0 ORDER BY menu.desmenu";
$menus = mysql_query($query_menus, $homebank_conecta) or die(mysql_error());
$row_menus = mysql_fetch_assoc($menus);
$totalRows_menus = mysql_num_rows($menus);

$colname_permissoes = "-1";
if (isset($_GET['codusuario'])) {
  $colname_permissoes = (get_magic_quotes_gpc()) ? $_GET['codusuario'] : addslashes($_GET['codusuario']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_permissoes = sprintf("SELECT acessousu.codmenu FROM acessousu WHERE acessousu.codusuario=%s", $colname_permissoes);
$permissoes = mysql_query($query_permissoes, $homebank_conecta) or die(mysql_error());
$row_permissoes = mysql_fetch_assoc($permissoes);
$totalRows_permissoes = mysql_num_rows($permissoes);
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="return VerificaCamposObrigatorios();">
  <BR>
  <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
    <tr>
      <td  width="5">&nbsp;</td>
      <td align="center" class="td2"><strong><b>Editar Usuario </b></strong></td>
    </tr>
  </table>
  <BR>
  <table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
    <tr>
      <td width="5">&nbsp;&nbsp;</td>
      <td  width="200" align="right" valign="middle" class="td3" >Login</td>
      <td valign="middle" class="td4">&nbsp;
        <input name="desusuariologin" type="text" id="desusuariologin" value="<?php echo $row_usuario['desusuario']; ?>" size="20" maxlength="15" /></td>
    </tr>
    <tr>
      <td width="5">&nbsp;</td>
      <td width="200" align="right" valign="middle" class="td3">Senha</td>
      <td valign="middle" class="td4">&nbsp;
        <input name="dessenha" type="password" id="dessenha" value="<?php echo $row_usuario['dessenha']; ?>" size="10" maxlength="8" />
        <input name="codusuario" type="hidden" id="codusuario" value="<?php echo $row_usuario['codusuario']; ?>">
        <input type="hidden" name="MM_update" value="form1"></td>
    </tr>
  </table>
  <table width="580" cellspacing="0" class="table">
    </tr>
<tr>
      <td  width="5">&nbsp;</td>
      <td align="right" width="200" class="td3">Permitir Cadastrar Usuários</td>
      <td class="td4">&nbsp;
        <select size="1" name="flapercadusu" id="flapercadusu">
          <option value="n" <?php if ($row_usuario['flapercadusu']=='n') echo 'selected="selected"'; ?>>Não</option>
          <option value="s" <?php if ($row_usuario['flapercadusu']=='s') echo 'selected="selected"'; ?>>Sim</option>
        </select>
      </td>
    </tr>
    <tr>
      <td  width="5">&nbsp;</td>
      <td align="right" width="200" class="td3">Permitir Cadastrar Menu</td>
      <td class="td4">&nbsp;
        <select size="1" name="flapercadmenu" id="flapercadmenu">
          <option value="n" <?php if ($row_usuario['flapercadmenu']=='n') echo 'selected="selected"'; ?>>Não</option>
          <option value="s" <?php if ($row_usuario['flapercadmenu']=='s') echo 'selected="selected"'; ?>>Sim</option>
        </select>
      </td>
    </tr>
  </table>
  <br>
  <table width="580" class="table"  cellspacing="0" cellpadding="0">
    <tr>
      <td width="5"></td>
      <td align="center" class="td2 ">
	  <?php do {
	  $a_permissoes[]=$row_permissoes['codmenu'];
	  } while ($row_permissoes = mysql_fetch_assoc($permissoes)); ?><font color=""><b>Permissões</b></font></td>
    </tr>
  </table>
  <table width="580" cellpadding="0"  cellspacing="0" class="table">
    <?php do { ?>
      <tr>
        <td width="200" align="right" class="td3"><?php echo $row_menus['desmenu']; ?></td>
        <td class="td4">&nbsp;
          <input type="checkbox" name="codmenu[]" value="<?php echo $row_menus['codmenu']; ?>"<?php if(in_array($row_menus['codmenu'],$a_permissoes)){ echo 'checked'; }?>></td>
      </tr>
      <?php } while ($row_menus = mysql_fetch_assoc($menus)); ?>
    <br>
  </table>
  <br />
  <table width="580" border="1" class="table" cellspacing="0" cellpadding="0">
    <tr>
      <td  width="5">&nbsp;</td>
      <td align="center" class="td2"><strong><b>Men&uacute; (Ordem de Servi&ccedil;o) </b></strong></td>
    </tr>
  </table>
  <br />
  <table width="580" border="0" cellspacing="0" cellpadding="0">
<?
$sql = "SELECT menu.codmenu, menu.desmenu FROM menu WHERE menu.flaativo='s' AND menu.codpaimenu=0 ORDER BY menu.desmenu";
$r = mysql_query($sql, $homebank_conecta) or die(mysql_error());
while(false !== ($dado = mysql_fetch_array($r)))
{
?>
    <tr class="table">
      <td width="200" align="right" class="td3"><?php echo $dado['desmenu']; ?></td>
      <td width="380" class="td4">&nbsp;
          <input type="checkbox" name="codmenu[]" value="<?php echo $dado['codmenu']; ?>"<?php if(in_array($dado['codmenu'],$a_permissoes)){ echo 'checked'; }?> /></td>
    </tr>
<?
}
?>

    <tr class="table">
      <td align="right" >&nbsp;</td>
      <td ><div align="right"><span class="td3">
        <input type="submit" name="Submit" value="Gravar" />
        <input type="button" name="Submit2" value="Cancelar" onclick="history.back(-1);" />
      </span></div></td>
    </tr>
  </table>
</form>
<?php
mysql_free_result($usuario);

mysql_free_result($menus);

mysql_free_result($permissoes);
?>
