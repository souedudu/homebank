<? 
session_start();
include_once("../Connections/homebank_conecta.php");
require_once "auth.php";
verificaAuth($_SESSION['codusuarioadm'], 'Concluir OS');

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formINC")) {
  $insertSQL = sprintf("INSERT INTO andamensolicitacao (codsolicitacao, codmenatendimento, codtecnicoresp, descompmensagem, datregandamento, hrregandamento, final) VALUES (%s, %s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['codsolicitacao'], "int"),
                       GetSQLValueString($_POST['codmenatendimento'], "int"),
                       GetSQLValueString($_POST['codtecnicoresp'], "int"),
                       GetSQLValueString($_POST['descompmensagem'], "text"),
                       GetSQLValueString($_POST['datregandamento'], "date"),
                       GetSQLValueString($_POST['hrregandamento'], "date"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta)or die(mysql_error());
//	echo $insertSQL;
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());

	mysql_select_db($database_homebank_conecta, $homebank_conecta);
	$sql="UPDATE solicitacaoserv SET dtencerramento = NOW(), dtconclusao = NOW() WHERE codsolicitacao =".$_GET['cod'];
	mysql_query($sql, $homebank_conecta) or die(mysql_error());

  $insertGoTo = "?";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));

  echo '<script language="JavaScript" type="text/javascript">
alert(\'Solicitação encerrada com sucesso.\');
location.href="ver.php?cod='.$_REQUEST['codsolicitacao'].'";
</script>';

}


mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_mensagens = "SELECT mensatendimento.codmenatendimento, mensatendimento.desmenatendimento FROM mensatendimento ORDER BY mensatendimento.desmenatendimento";
$mensagens = mysql_query($query_mensagens, $homebank_conecta) or die(mysql_error());
$row_mensagens = mysql_fetch_assoc($mensagens);
$totalRows_mensagens = mysql_num_rows($mensagens);


?>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' não é um endereço de e-mail válido.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' deve conter apenas caracteres numericos.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' deve conter um número entre '+min+' e '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' é necessário que seje preenchido.\n'; }
  } if (errors) alert('O sistema detectou o(s) seguinte(s) erro(s):\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<table align="center">
  <form method="post" name="formINC" action="<?php echo $editFormAction; ?>">
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
      <td align="left" valign="top" nowrap><textarea name="descompmensagem" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="center" nowrap><input name="submit" type="submit" value="Concluir OS" onClick="MM_validateForm('descompmensagem','','R');return document.MM_returnValue; return confirm('Voc&ecirc; tem certeza que deseja realmente concluir esta OS?');">
          <input type="hidden" name="codsolicitacao" value="<?php echo $_GET['cod']; ?>" />
          <input type="hidden" name="datregandamento" value="<?php echo date('Y-m-d');?>" />
          <input type="hidden" name="hrregandamento" value="<?php echo date('H:i');?>" />
          <input type="hidden" name="MM_insert" value="formINC" /></td>
    </tr>
  </form>
</table>
