<?php require_once('../Connections/crediembrapa.php'); ?>
<?php
mysql_select_db($database_crediembrapa, $crediembrapa);
$query_participantes = "SELECT cadastro.nome_do_cliente, cadastro.numero_da_pessoa, contacorrente.numero_da_conta_corrente FROM cadastro, contacorrente WHERE cadastro.numero_da_pessoa = contacorrente.numero_do_cliente_1_titular ORDER BY cadastro.nome_do_cliente";
$participantes = mysql_query($query_participantes, $crediembrapa) or die(mysql_error());
$row_participantes = mysql_fetch_assoc($participantes);
$totalRows_participantes = mysql_num_rows($participantes);
?>
<?php require_once('../Connections/conecta.php'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<body background="../img/fundo.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="MM_preloadImages('../images/regulamento2.jpg','../images/ganhadores2.jpg','../images/meuscupons2.jpg');MM_showHideLayers('loading','','hide')">
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
   <td>&nbsp;</td>
   <td rowspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><span class="style3">atualizador HOMEBANK</span></td>
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
      <td><p>&nbsp;</p>
        <table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><form action="geracupons.php" method="get" name="form1" target="listacupons" class="style2" id="form1">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;                  </p>
                  <p>
                    <select name="participante" id="participante" onchange="listacupons.location.href='listacupons.php?participante='+this.value;if(this.value!='0'){ document.form1.n_cupons.disabled=false; document.form1.Submit.disabled=false; }else{ document.form1.n_cupons.disabled=true; document.form1.Submit.disabled=true; document.form1.n_cupons.value='';}">
                      <option value="0" <?php if (!(strcmp(0, $_GET['participante']))) {echo "selected=\"selected\"";} ?>>Selecione o participante...</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_participantes['numero_da_pessoa']?>"<?php if (!(strcmp($row_participantes['numero_da_pessoa'], $_GET['participante']))) {echo "selected=\"selected\"";} ?>><?php echo $row_participantes['nome_do_cliente'].' - '.$row_participantes['numero_da_conta_corrente']?></option>
                      <?php
} while ($row_participantes = mysql_fetch_assoc($participantes));
  $rows = mysql_num_rows($participantes);
  if($rows > 0) {
      mysql_data_seek($participantes, 0);
	  $row_participantes = mysql_fetch_assoc($participantes);
  }
?>
                    </select>
                  </p>
                <hr />
                <p><strong>Gerar cupons</strong><br />
N&uacute;mero de cupons:
<input name="n_cupons" type="text" id="n_cupons" size="5" maxlength="3" disabled="disabled" /> <input type="button" name="Button" value="Gerar" onclick="document.form1.action='geracupons.php';document.form1.submit();" />

</p><br><br>
                <p>
                  <input name="report" type="button" id="report" value="Download Relat&oacute;rio" onclick="location.href='relatorio.php';" /><input name="delete" type="button" id="delete" value="Remover Cupons" onclick="document.form1.action='delete.php';document.form1.submit();" />
                </p>
                <br>
            </form></td>
          </tr>
        </table>
       
       </td>
    </tr>
    <tr bgcolor="#DCE1DD">
      
    </tr>
    
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($participantes);
?>
