<?php virtual('/fundacao2/Connections/homebank_conecta.php'); ?>
<?php require_once('Sajax.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO solicitacaoserv (codtiposervsol, codtecnicoresp, dessolicitacao, desemailcont, numtelefonecont, dtsolicitacao, hrsolicitacao, numcontacorrente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codtiposervsol'], "int"),
                       GetSQLValueString($_POST['codtecnicoresp'], "int"),
                       GetSQLValueString($_POST['dessolicitacao'], "text"),
                       GetSQLValueString($_POST['desemailcont'], "text"),
                       GetSQLValueString($_POST['numtelefonecont'], "text"),
                       GetSQLValueString($_POST['dtsolicitacao'], "date"),
                       GetSQLValueString($_POST['hrsolicitacao'], "date"),
                       GetSQLValueString($_POST['numcontacorrente'], "text"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());

  $insertGoTo = "index.php";
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
$query_conta_cliente = "SELECT CONCAT(RIGHT(CONCAT('000000',contacorrente.numcontacorrente),6),' - ',cliente.nomcliente) AS cc_nome,contacorrente.numcontacorrente FROM cliente, contacorrente WHERE contacorrente.codcliente=cliente.codcliente ORDER BY cliente.nomcliente";
$conta_cliente = mysql_query($query_conta_cliente, $homebank_conecta) or die(mysql_error());
$row_conta_cliente = mysql_fetch_assoc($conta_cliente);
$totalRows_conta_cliente = mysql_num_rows($conta_cliente);
?>
<?php
function busca($nome){
	include('../../Connections/homebank_conecta.php');
	mysql_select_db($database_homebank_conecta, $homebank_conecta);
	$query = "SELECT CONCAT(RIGHT(CONCAT('000000',contacorrente.numcontacorrente),6),' - ',cliente.nomcliente) AS cc_nome,contacorrente.numcontacorrente FROM cliente, contacorrente WHERE contacorrente.codcliente=cliente.codcliente
	AND IF('".$nome."'='',1,cliente.nomcliente LIKE '%".$nome."%')
	ORDER BY cliente.nomcliente";
	$result = mysql_query($query,$homebank_conecta);
	$row = mysql_fetch_assoc($result);
	$campo='<select name="numcontacorrente" id="numcontacorrente" size="5">';
	do {
		$campo.='<option value="'.$row['numcontacorrente'].'">'.$row['cc_nome'].'</option>';
	} while ($row = mysql_fetch_assoc($result));
	$campo.='</select>';
	return $campo;
}
$sajax_request_type = "POST"; //forma como os dados serao enviados
sajax_init(); //inicia o SAJAX
sajax_export("busca"); // lista de funcoes a ser exportadas
sajax_handle_client_request();// serve instancias de clientes
?>
<script language="JavaScript" type="text/javascript">
///////////////////////////////////////////////////////////
<? sajax_show_javascript(); //gera o javascript ?>
///////////////////////////////////////////////////////////
function mudacampo(campo) { //esta funcao retorna o valor para o campo do formulario
	document.getElementById("campocccliente").innerHTML = "Aguarde...";
	document.getElementById("campocccliente").innerHTML = campo;
}

function formbusca() { //esta funcao chama a funcao PHP exportada pelo Ajax
	var nome;
	nome = document.form1.nome.value;
	x_busca(nome,mudacampo);
}
</script>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<br>
<br>
 <table width="580" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td2" align="center"><strong><b>Solicitação de Serviços Bancários </strong></td>
  </tr> 
 </table> 
 <br>
  <table border="0" cellspacing="3" cellpadding="0">
  <tr><td>&nbsp;</td>
    <td class="td4" align="right"><b>Aberta Por</td>
	<td class="td3">&nbsp;<?php echo $_SESSION['codusuarioadm'].' - '.$_SESSION['desusuario']; ?></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td class="td4" align="right"><b>Buscar CC/Cliente </b></td>
    <td class="td3"><b>por Nome:</b> <input name="nome" type="text" id="nome" onKeyPress="formbusca();" /></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td align="right" valign="top" class="td4"><b>CC/Cliente</td>
	<td class="td3"><div id="campocccliente">
	  <select name="numcontacorrente" id="numcontacorrente">
	    <option value="0">Selecione</option>
	    <?php
do {  
?>
	    <option value="<?php echo $row_conta_cliente['numcontacorrente']?>"><?php echo $row_conta_cliente['cc_nome']?></option>
	    <?php
} while ($row_conta_cliente = mysql_fetch_assoc($conta_cliente));
  $rows = mysql_num_rows($conta_cliente);
  if($rows > 0) {
      mysql_data_seek($conta_cliente, 0);
	  $row_conta_cliente = mysql_fetch_assoc($conta_cliente);
  }
?>
	    </select></div></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td class="td4" align="right"><b>Tipo de Serviço</td>
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
             </select>	 </td>
  </tr> 

  <tr><td>&nbsp;</td>
    <td class="td4" align="right"><b>Detalhes da solicitação<br><br><br><br><br><br></td>
	   <td class="td3">&nbsp;<textarea style='width:415px; height:75px' name='dessolicitacao'></textarea>	   </td>
  </tr> 

  <tr><td>&nbsp;</td>
    <td class="td4" align="right"><b>Técnico responsável</td>

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
    <td class="td4" align="right"><b>E-Mail de contato</td>
	   <td class="td3">&nbsp;<input name="desemailcont" type="text" id="desemailcont" size="50" maxlength="60">	   </td>
  </tr>

   <tr><td>&nbsp;</td>
    <td class="td4" align="right"><b>Telefone de contato</td>
	   <td class="td3">&nbsp;<input name="numtelefonecont" type="text" id="numtelefonecont" size="15" maxlength="15">	   </td>
  </tr>
 </table>

 <table width="580" border="0" cellspacing="0" cellpadding="0">
    <tr><td><input name="dtsolicitacao" type="hidden" id="dtsolicitacao" value="<?php echo date('Y-m-d');?>">
      <input name="hrsolicitacao" type="hidden" id="hrsolicitacao" value="<?php echo date('H:i');?>"></td>
    </tr>
    <tr><td>&nbsp;</td>
    </tr>

    <tr>
      <td width="200">&nbsp;</td>
      <td  width="80"><input type="submit" name="Submit" value="Gravar"></td>
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