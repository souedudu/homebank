<?php @include_once("../../Connections/homebank_conecta.php"); ?>
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

$colname_solicitacao = "-1";
if (isset($_GET['cod'])) {
  $colname_solicitacao = (get_magic_quotes_gpc()) ? $_GET['cod'] : addslashes($_GET['cod']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacao = sprintf("SELECT DISTINCT ( solicitacaoserv.codsolicitacao ), DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%%d/%%m/%%Y' ) AS data_solicitacao, DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%%H:%%i' ) AS hora_solicitacao, solicitacaoserv.numcontacorrente, cliente.nomcliente, cliente.numcpfcnpj, tiposervsolicitacao.destiposervsol, solicitacaoserv.dessolicitacao, IF( solicitacaoserv.dtconclusao IS NULL , 'Solicitação ainda não concluída', DATE_FORMAT( solicitacaoserv.dtconclusao, '%%d/%%m/%%Y' ) ) AS data_conclusao, IF( solicitacaoserv.codtecnicoresp IS NULL , 'Solicitação ainda não encaminhada para nenhum técnico', solicitacaoserv.codtecnicoresp ) AS tecnico_responsavel,solicitacaoserv.codtecnicoresp ,solicitacaoserv.desemailcont, solicitacaoserv.numtelefonecont, IF(solicitacaoserv.dtconclusao IS NULL,'N','S') AS concluida FROM solicitacaoserv, cliente, tiposervsolicitacao, tecnicoresp, contacorrente WHERE IF( solicitacaoserv.codtecnicoresp IS NULL , 1, tecnicoresp.codtecnicoresp = solicitacaoserv.codtecnicoresp ) AND solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND cliente.codcliente = contacorrente.codcliente AND solicitacaoserv.numcontacorrente = contacorrente.numcontacorrente AND contacorrente.codcliente = cliente.codcliente AND solicitacaoserv.codsolicitacao = %s GROUP BY solicitacaoserv.codsolicitacao", GetSQLValueString($colname_solicitacao, "int"));
$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnicoresp = "SELECT `codtecnicoresp` , `nomtecnicoresp` FROM `tecnicoresp`  ORDER BY `nomtecnicoresp`";
$tecnicoresp = mysql_query($query_tecnicoresp, $homebank_conecta) or die(mysql_error());
$row_tecnicoresp = mysql_fetch_assoc($tecnicoresp);
$totalRows_tecnicoresp = mysql_num_rows($tecnicoresp);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_mensagens = "SELECT mensatendimento.codmenatendimento, mensatendimento.desmenatendimento FROM mensatendimento ORDER BY mensatendimento.desmenatendimento";
$mensagens = mysql_query($query_mensagens, $homebank_conecta) or die(mysql_error());
$row_mensagens = mysql_fetch_assoc($mensagens);
$totalRows_mensagens = mysql_num_rows($mensagens);

$colname_andamentos = "-1";
if (isset($_GET['cod'])) {
  $colname_andamentos = (get_magic_quotes_gpc()) ? $_GET['cod'] : addslashes($_GET['cod']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_andamentos = sprintf("SELECT andamensolicitacao.codandsolicitacao, mensatendimento.desmenatendimento, tecnicoresp.nomtecnicoresp, andamensolicitacao.descompmensagem, DATE_FORMAT(andamensolicitacao.datregandamento,'%%d/%%m/%%Y') AS data_andamento, DATE_FORMAT(andamensolicitacao.hrregandamento,'%%H:%%i') AS hora_andamento FROM andamensolicitacao, mensatendimento, tecnicoresp WHERE mensatendimento.codmenatendimento=andamensolicitacao.codmenatendimento AND andamensolicitacao.codtecnicoresp=tecnicoresp.codtecnicoresp AND andamensolicitacao.codsolicitacao=%s ORDER BY andamensolicitacao.datregandamento DESC", $colname_andamentos);
$andamentos = mysql_query($query_andamentos, $homebank_conecta) or die(mysql_error());
$row_andamentos = mysql_fetch_assoc($andamentos);
$totalRows_andamentos = mysql_num_rows($andamentos);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnico = "SELECT tecnicoresp.codtecnicoresp, tecnicoresp.nomtecnicoresp FROM tecnicoresp ORDER BY tecnicoresp.nomtecnicoresp";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);
?>
<?php if ($totalRows_solicitacao > 0) { // Show if recordset not empty ?>
<?php //echo $query_solicitacao; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body onload="window.print();">  <table>
    <tr><td>
  <table border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr valign="top" class="td4">
        <td width="252"><strong>Data de abertura:</strong></td>
        <td width="252"><strong>Solicita&ccedil;&atilde;o N&uacute;mero:</strong></td>
      </tr>
      <tr valign="top">
        <td width="252"><?php echo $row_solicitacao['data_solicitacao']; ?> - <?php echo $row_solicitacao['hora_solicitacao']; ?></td>
        <td width="252"><?php echo $row_solicitacao['codsolicitacao']; ?></td>
      </tr>
      </tbody>
  </table>
  <img src="http://www.crediembrapa.com.br:8080/aplic/os.nsf/ba442b0259fc478683256b21006189fb/$Body/0.734?OpenElement&amp;FieldElemFormat=gif" height="2" width="600">
  <table border="1" cellpadding="0" cellspacing="0">
    <tbody>
      <tr valign="top">
        <td class="td4"><strong>Conta Corrente</strong>:</td>
        <td><?php echo $row_solicitacao['numcontacorrente']; ?> - <?php echo $row_solicitacao['nomcliente']; ?></td>
      </tr>
      <tr valign="top">
        <td class="td4"><strong>CPF:</strong></td>
        <td><?php echo $row_solicitacao['numcpfcnpj']; ?></td>
      </tr>
      </tbody>
  </table>
  <table width="604" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" valign="top"><strong>Conta corrente do cliente</strong>: <?php echo $row_solicitacao['numcontacorrente']; ?><br />
        <br />
        <strong>Tipo de Servi&ccedil;o: </strong><br />
        <?php echo $row_solicitacao['destiposervsol']; ?><br />
        <br />
        <strong>Detalhes desta solicita&ccedil;&atilde;o:</strong><br />
        <?php echo $row_solicitacao['dessolicitacao']; ?><br />
        <br />
        <strong>T&eacute;cnico respons&aacute;vel pelo atendimento:</strong><br />
        <strong> </strong>
		<?php if($row_solicitacao['concluida']=='N'){ ?>
		<select disabled="disabled" name="tec_responsavel" id="tec_responsavel" onchange="if(this.value!='0'){ location.href='inc/alteratecnicoresp.php?tecnico='+this.value+'&solicitacao=<?php echo $_GET['cod'];?>'; }">
          
		  <?php if($row_solicitacao['codtecnicoresp']==''){ ?><option value="0" <?php if (!(strcmp(0, $row_solicitacao['codtecnicoresp']))) {echo "selected=\"selected\"";} ?>><< Aguardando triagem >></option><?php } ?>
          <?php
do {  
?>
          <option value="<?php echo $row_tecnicoresp['codtecnicoresp']?>"<?php if (!(strcmp($row_tecnicoresp['codtecnicoresp'], $row_solicitacao['codtecnicoresp']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tecnicoresp['nomtecnicoresp']?></option>
          <?php
} while ($row_tecnicoresp = mysql_fetch_assoc($tecnicoresp));
  $rows = mysql_num_rows($tecnicoresp);
  if($rows > 0) {
      mysql_data_seek($tecnicoresp, 0);
	  $row_tecnicoresp = mysql_fetch_assoc($tecnicoresp);
  }
?>
        </select>
		<? }else{
		$row_solicitacao['tecnico_responsavel'];
		} ?>
		<br />
        
<br />
        <strong>Data de conclus&atilde;o do servi&ccedil;o: </strong><br />
        <strong> </strong><?php echo $row_solicitacao['data_conclusao']; ?><br />
        <br />
        <strong>Informa&ccedil;&otilde;es para contato:</strong><br />
        <strong>Email: </strong><?php echo $row_solicitacao['desemailcont']; ?><br />
        <strong>Telefone: </strong><?php echo $row_solicitacao['numtelefonecont']; ?></td>
      </tr>
    <tr>
      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><hr noshade="noshade" /></td>
        </tr>
        <?php if ($totalRows_andamentos > 0) { // Show if recordset not empty ?>
        <?php do { ?>
        <tr>
          <td align="left" valign="top">T&eacute;cnico:<br />
              <?php echo $row_andamentos['nomtecnicoresp']; ?><br />
              </span></td>
          <td align="left" valign="top">Data: <?php echo $row_andamentos['data_andamento']; ?><br />
              <?php echo $row_andamentos['hora_andamento']; ?></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"><br />
              <?php echo $row_andamentos['desmenatendimento']; ?></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"><?php echo $row_andamentos['descompmensagem']; ?></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"><br />
              <hr noshade="noshade" /></td>
        </tr>
        <?php } while ($row_andamentos = mysql_fetch_assoc($andamentos)); ?>
        <?php }else{ ?>
        <tr>
          <td colspan="2" align="center" valign="top"><strong>
            <hr />
            Ainda n&atilde;o existem andamentos cadastrados nessa solicita&ccedil;&atilde;o
            <hr />
          </strong> </td>
        </tr>
        <?php } // Show if recordset not empty ?>
      </table></td>
    </tr>
  </table>
  <p><br>
  </p></td></tr>
  </table>
  <?php }else{ ?>
  <div>
    <center>
      Solicita&ccedil;&atilde;o n&atilde;o encontrada
    </center>
  </div>
  <?php } // Show if recordset not empty ?>
  </body>
</html>
  <?php
mysql_free_result($solicitacao);

mysql_free_result($tecnicoresp);

mysql_free_result($mensagens);

mysql_free_result($andamentos);

mysql_free_result($tecnico);
?>
