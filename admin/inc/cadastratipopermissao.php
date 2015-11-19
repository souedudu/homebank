<?php @include_once('../Connections/homebank_conecta.php'); ?>
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
if ($bttipoacao != "")
{
/*   $sqlstring2 = "select nomtecnicoresp, desfuncaoresp from tecnicoresp where codtecnicoresp =".$codtecnicoresp;
   $query2 = mysql_query($sqlstring2) or die(mysql_error());
   $rstec = mysql_fetch_array($query2);
   $desusuario = $rstec['nomtecnicoresp'];
   $desfuncao = $rstec['desfuncaoresp'];

    echo "nome: ".$desusuario. " - ".$desfuncao;      
*/
  if ($bttipoacao == "Excluir")
  {

    $sql = SQL("tipopermissao","delete","", "id");
    mysql_query($sql) or die(mysql_error());
    $sql2 = "Delete from acessomenutipo where codtipo =".$id;
    mysql_query($sql2) or die(mysql_error());

  }

  if ($bttipoacao == "Incluir")
  {
  $sql = "insert into tipopermissao (descricao)".
         "values ".
       "('".$descricao."')";

    mysql_query($sql) or die(mysql_error());
    $codtipo = mysql_insert_id();
    
  // Grava o novo acesso do usuario
  if ($codmenu != "")
      foreach ($codmenu as $elemento)
      {
         $sqlins1 = "insert into acessomenutipo
                     (codtipo, codmenu)
                     values
                     ($codtipo, $elemento)";

     mysql_query($sqlins1) or die(mysql_error());
      }

  }


  if ($bttipoacao == "Editar")
  {
   
    $sql = "update tipopermissao set ".
       " descricao='".$_REQUEST['descricao']."'".
       " where id = ".$id;

  mysql_query($sql) or die(mysql_error());
  
  // Excluir o acesso antigo do usuário
  mysql_query("delete from acessomenutipo where codtipo = ".$id) or die(mysql_error());

  // Grava o novo acesso do usuario
    if ($_REQUEST['codmenu'] != "")
      foreach ($_REQUEST['codmenu'] as $elemento)
      {
         $sqlins1 = "insert into acessomenutipo
                     (codtipo, codmenu)
                     values
                     ($id, ".$elemento.")";

         mysql_query($sqlins1) or die(mysql_error());
      }
  // Modifica a variável de Sessão do Usuário, caso Seja Alterado
 
}



?>
<br>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td3"><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width="5"></td>
    <td align='center' ></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td4"><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='tipopermissao.php'>
                     <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
  </td>
  </tr>
 </table>

<?
die();

}
$colname_usuario = "-1";
if (isset($_GET['codtipo'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_GET['codtipo'] : addslashes($_GET['codtipo']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
if (!empty($id)){

$query_usuario = "SELECT * FROM tipopermissao WHERE id=$id";
$usuario = mysql_query($query_usuario, $homebank_conecta) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
}


mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_menus = "SELECT menu.codmenu, menu.desmenu FROM menu WHERE menu.flaativo='s' AND menu.codpaimenu > 0 ORDER BY menu.desmenu";
$menus = mysql_query($query_menus, $homebank_conecta) or die(mysql_error());
$row_menus = mysql_fetch_assoc($menus);
$totalRows_menus = mysql_num_rows($menus);

$colname_permissoes = "-1";
if (isset($_GET['codtipo'])) {
  $colname_permissoes = (get_magic_quotes_gpc()) ? $_GET['codtipo'] : addslashes($_GET['codtipo']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
if (!empty($id)){
  $query_permissoes = "SELECT acessomenutipo.codmenu FROM acessomenutipo WHERE acessomenutipo.codtipo=$id" ;
  $permissoes = mysql_query($query_permissoes, $homebank_conecta) or die(mysql_error());
  $row_permissoes = mysql_fetch_assoc($permissoes);
  $totalRows_permissoes = mysql_num_rows($permissoes);
}
// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "" || $_REQUEST['tipoacao'] == "Listar")
{
  $tipoacao = "Listar";

  $sqlString = "Select * From usuario order by desusuario asc";
  $rsqry = mysql_query($sqlString);
  $rsusuario = mysql_fetch_array($rsqry);
}
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
      <td  width="200" align="right" valign="middle" class="td3" >Tipo de Permissão</td>
      <td valign="middle" class="td4">&nbsp;
        <input name="descricao" type="text" id="descricao" value="<?php echo $row_usuario['descricao']; ?>" size="20" maxlength="15" /></td>
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
        <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
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
