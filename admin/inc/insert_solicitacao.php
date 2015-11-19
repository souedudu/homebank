<?php include_once('../Connections/homebank_conecta.php'); ?>
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
	
	$sql="SELECT codcliente FROM contacorrente WHERE numcontacorrente=".$_POST['numcontacorrente'];
	mysql_select_db($database_homebank_conecta, $homebank_conecta);
	$Result = mysql_query($sql, $homebank_conecta) or die(mysql_error());
	$conta = mysql_fetch_assoc($Result);

	if(strstr($_REQUEST['tipoc'], "PRECAD"))
		$_POST['numcontacorrente'] = 'p'.$_POST['numcontacorrente'];
	
  $insertSQL = sprintf("INSERT INTO solicitacaoserv (codtiposervsol, codtecnicoresp, dessolicitacao, desemailcont, numtelefonecont, dtsolicitacao, hrsolicitacao, numcontacorrente, tecnico_abertura, codcliente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codtiposervsol'], "int"),
                       GetSQLValueString($_POST['codtecnicoresp'], "int"),
                       GetSQLValueString($_POST['dessolicitacao'], "text"),
                       GetSQLValueString($_POST['desemailcont'], "text"),
                       GetSQLValueString($_POST['numtelefonecont'], "text"),
                       GetSQLValueString($_POST['dtsolicitacao'], "date"),
                       GetSQLValueString($_POST['hrsolicitacao'], "date"),
                       GetSQLValueString($_POST['numcontacorrente'], "text"),
                       GetSQLValueString($_SESSION['codusuarioadm'], "int"),
                       GetSQLValueString($conta['codcliente'], "text"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  echo '<script language="JavaScript" type="text/javascript">
location.href="ver.php?cod='.mysql_insert_id().'";
</script>';

}

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tipos = "SELECT CONCAT(tiposolicitacao.destiposol, ' - ',tiposervsolicitacao.destiposervsol) AS tipos, tiposervsolicitacao.codtiposervsol FROM tiposolicitacao, tiposervsolicitacao WHERE tiposervsolicitacao.codtiposol = tiposolicitacao.codtiposol ORDER BY tiposervsolicitacao.codtiposervsol";
$tipos = mysql_query($query_tipos, $homebank_conecta) or die(mysql_error());
$row_tipos = mysql_fetch_assoc($tipos);
$totalRows_tipos = mysql_num_rows($tipos);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnico = "SELECT usuario.codtecnicoresp, usuario.desusuario FROM usuario ORDER BY usuario.desusuario";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_conta_cliente = "SELECT CONCAT(RIGHT(CONCAT('000000',contacorrente.numcontacorrente),6),' - ',cliente.nomcliente) AS cc_nome,contacorrente.numcontacorrente, cliente.codcliente FROM cliente, contacorrente WHERE contacorrente.codcliente=cliente.codcliente ORDER BY cliente.nomcliente";
$conta_cliente = mysql_query($query_conta_cliente, $homebank_conecta) or die(mysql_error());
$row_conta_cliente = mysql_fetch_assoc($conta_cliente);
$totalRows_conta_cliente = mysql_num_rows($conta_cliente);
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
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' n�o � um endere�o de e-mail v�lido.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' deve conter apenas caracteres numericos.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' deve conter um n�mero entre '+min+' e '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' � necess�rio que seje preenchido.\n'; }
  } 
  if(document.getElementById('codtiposervsol').value=='')
	errors += '- tipo de servi�o n�o pode ser nulo';
  if (errors) alert('O sistema detectou o(s) seguinte(s) erro(s):\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<br>
<br>
 <table width="580" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td2" align="center"><strong>Solicita��o de Servi�os Banc�rios </strong></td>
  </tr> 
 </table> 
 <br>
  <table border="0" cellspacing="3" cellpadding="0">
  <tr><td>&nbsp;</td>
    <td class="td4" align="right">Aberta Por</td>
	<td class="td3">&nbsp;<?php echo $_SESSION['codusuarioadm'].' - '.$_SESSION['desusuario']; ?></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td class="td4" align="right"><b>Buscar CC/Cliente </b></td>
    <td class="td3"><b>por</b> <select name="tipoBusca" id="tipoBusca" onchange="document.getElementById('nomebusca').value=''; formbusca()">
        <option value="NM">Nome</option>
        <option value="CC">Conta Corrente</option>
      </select><b>:</b> <input name="nomebusca" type="text" id="nomebusca" onkeyup="formbusca(this.value);" /></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td align="right" valign="top" class="td4">CC/Cliente</td>
	<td class="td3">
		<div id="campocccliente">Busque um correntista...</div></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td class="td4" align="right">Tipo de Servi�o</td>
	 <td class="td3"><select name="codtiposervsol" id="codtiposervsol">
	   <option value="">Selecione</option></option>
	   <?php
do {  
?>
	   <option value="<?php echo $row_tipos['codtiposervsol']?>"><?php echo $row_tipos['tipos']?></option>
	   <?php
} while ($row_tipos = mysql_fetch_assoc($tipos));
  $rows = mysql_num_rows($tipos);
  if($rows > 0) {
      mysql_data_seek($tipos, 0);
	  $row_tipos = mysql_fetch_assoc($tipos);
  }
?>
             </select></td>
  </tr> 

  <tr><td>&nbsp;</td>
    <td class="td4" align="right">Detalhes da solicita��o<br><br><br><br><br><br></td>
	   <td class="td3">&nbsp;<textarea style='width:415px; height:75px' name='dessolicitacao'></textarea>	   </td>
  </tr> 

  <tr><td>&nbsp;</td>
    <td class="td4" align="right">T�cnico respons�vel</td>

	 <td class="td3">&nbsp;<select name="codtecnicoresp" id="codtecnicoresp">
	   <option value="">Selecione</option>
	   <?php
do {  
?>
	   <option value="<?php echo $row_tecnico['codtecnicoresp']?>"><?php echo $row_tecnico['desusuario']?></option>
	   <?php
} while ($row_tecnico = mysql_fetch_assoc($tecnico));
  $rows = mysql_num_rows($tecnico);
  if($rows > 0) {
      mysql_data_seek($tecnico, 0);
	  $row_tecnico = mysql_fetch_assoc($tecnico);
  }
?>
      </select></td>	
  </tr> 
 
   <tr><td>&nbsp;</td>
    <td class="td4" align="right">E-Mail de contato</td>
	   <td class="td3">&nbsp;<input name="desemailcont" type="text" id="desemailcont" size="50" maxlength="60">	   </td>
  </tr>

   <tr><td>&nbsp;</td>
    <td class="td4" align="right">Telefone de contato</td>
	   <td class="td3">&nbsp;<input name="numtelefonecont" type="text" id="numtelefonecont" size="15" maxlength="15">	   </td>
  </tr>
 </table>

 <table width="580" border="0" cellspacing="0" cellpadding="0">
    <tr><td><input name="dtsolicitacao" type="hidden" id="dtsolicitacao" value="<?php echo date('Y-m-d');?>">
      <input name="hrsolicitacao" type="hidden" id="hrsolicitacao" value="<?php echo date('H:i');?>">
      <input name="valor" type="hidden" id="valor" />
      <input name="tipoc" type="hidden" id="tipoc" /></td>
    </tr>
    <tr><td>&nbsp;</td>
    </tr>

    <tr>
      <td width="200">&nbsp;</td>
      <td  width="80"><input name="Submit" type="submit" onclick="MM_validateForm('nomebusca','','R');return document.MM_returnValue" value="Gravar"></td>
	  <td></td>
    </tr>
 </table> 
 <input type="hidden" name="MM_insert" value="form1">
</form>
<?php
mysql_free_result($tipos);
mysql_free_result($tecnico);
mysql_free_result($conta_cliente);
?>