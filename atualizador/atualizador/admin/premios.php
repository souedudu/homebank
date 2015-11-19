<?php require_once('../Connections/crediembrapa.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE paginas SET html=%s WHERE id=%s",
                       GetSQLValueString($_POST['html'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_crediembrapa, $crediembrapa);
  $Result1 = mysql_query($updateSQL, $crediembrapa) or die(mysql_error());

  $updateGoTo = "premios.php?save=ok";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_crediembrapa, $crediembrapa);
$query_Recordset1 = "SELECT paginas.html FROM paginas WHERE paginas.id = 1";
$Recordset1 = mysql_query($query_Recordset1, $crediembrapa) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php require_once('auth.inc.php');?>
<?php include('fckeditor/fckeditor.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>$ementes da $orte</title>
<link href="../verdana11.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>

<style type="text/css">

<!--



.dropdown {
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
}
-->
td img {display: block;}.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	font-style: italic;
}
#loading {
	position:absolute;
	left:0;
	top:0;
	width:100%;
	height:100%;
	z-index:1;
	background-color: #FFFFFF;
	visibility: hidden;
}
</style>
</head>
<body <?php if($_POST['save']=='ok'){ ?>onload="alert('Dados atualizados com sucesso');" <?php } ?>background="../img/fundo.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="MM_preloadImages('../images/regulamento2.jpg','../images/ganhadores2.jpg','../images/meuscupons2.jpg');MM_showHideLayers('loading','','hide')">
<div class="style3" id="loading">
  <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img name="logo" src="../images/logo.jpg" width="210" height="45" border="0" id="logo" alt="" /></td>
   <td rowspan="2" align="center" valign="middle"><span class="style3">&Aacute;rea administrativa </span></td>
   <td><img src="../images/spacer.gif" width="1" height="45" border="0" alt="" /></td>
  </tr>
    <tr>
      <td align="center" valign="middle" colspan="2">Carregando...</td>
    </tr>
  </table>
</div>
<div align="center">
  <table width="760" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td><table border="0" cellpadding="0" cellspacing="0" width="760">
<!-- fwtable fwsrc="CrediEmbrapa.png" fwbase="crediembrapa.png" fwstyle="Dreamweaver" fwdocid = "2122681717" fwnested="0" -->
  <tr>
   <td><img src="../images/spacer.gif" width="210" height="1" border="0" alt="" /></td>
   <td colspan="2"><img src="../images/spacer.gif" width="550" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td><img name="logo" src="../images/logo.jpg" width="210" height="45" border="0" id="logo" alt="" /></td>
   <td rowspan="2" align="center" valign="middle"><span class="style3">&Aacute;rea administrativa </span></td>
   <td rowspan="2" align="center" valign="middle">[ <a href="logoff.php"><span class="style2">Sair</span></a> ]</td>
   <td><img src="../images/spacer.gif" width="1" height="45" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img name="crediembrapa_r2_c1" src="../images/crediembrapa_r2_c1.jpg" width="210" height="5" border="0" id="crediembrapa_r2_c1" alt="" /></td>
   <td><img src="../images/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
</table></td>
    </tr>
    <tr>
      <td valign="top"><p class="style2">[  <a href="index.php">Home</a> | <a href="ganhadores.php">Editar Ganhadores</a> | <a href="premios.php" class="style2">Editar Pr&ecirc;mios</a> ]</p><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<?php
$oFCKeditor = new FCKeditor('html') ;
$oFCKeditor->BasePath = '/sementesdasorte/admin/fckeditor/';
$oFCKeditor->Value = $row_Recordset1['html'];
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->ToolbarSet = 'Default';
$oFCKeditor->Create() ;
?>
<input name="id" type="hidden" id="id" value="1" />
      <br>
      <input type="submit" value="Salvar">
      <input type="hidden" name="MM_update" value="form1">
    </form></td>
    </tr>
    <tr bgcolor="#DCE1DD">
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#AFC4BB"><img src="../images/rodape.gif" width="760" height="47" /></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>