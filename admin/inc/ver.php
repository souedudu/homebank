<?php include_once('../Connections/homebank_conecta.php'); 
require_once 'auth.php';
verificaAuth($_SESSION['codusuarioadm'], 'Consultar OS');
?>
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
$query_solicitacao = sprintf("SELECT distinct(s.codsolicitacao),
DATE_FORMAT(s.dtsolicitacao, '%%d/%%m/%%Y' ) AS data_solicitacao,
DATE_FORMAT(s.hrsolicitacao, '%%H:%%i' ) AS hora_solicitacao,
s.numcontacorrente,
u.desusuario AS tecnico_abertura,
cl.nomcliente,
t.destiposervsol,
s.codtecnicoresp,
s.dessolicitacao,
IF( s.dtconclusao IS NULL , 'Solicitação ainda não concluída', DATE_FORMAT( s.dtconclusao, '%%d/%%m/%%Y' ) ) AS data_conclusao,
cl.numcpfcnpj,
IF( s.dtconclusao IS NOT NULL,'S','N') AS concluida,
s.desemailcont,
s.numtelefonecont,
tr.nomtecnicoresp AS nomtecnicoresp
FROM solicitacaoserv s LEFT OUTER JOIN
contacorrente c ON  c.numcontacorrente=s.numcontacorrente LEFT OUTER JOIN
cliente cl ON c.codcliente=cl.codcliente LEFT OUTER JOIN
tiposervsolicitacao t ON s.codtiposervsol=t.codtiposervsol LEFT OUTER JOIN
usuario u ON s.tecnico_abertura=u.codusuario LEFT OUTER JOIN
tecnicoresp tr ON s.codtecnicoresp = tr.codtecnicoresp
WHERE s.codsolicitacao =%s
group by s.codsolicitacao
", GetSQLValueString($colname_solicitacao, "int"));
$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);

if(strstr($row_solicitacao['numcontacorrente'], "p"))
{
	$query_solicitacao = sprintf("SELECT distinct(s.codsolicitacao),
DATE_FORMAT(s.dtsolicitacao, '%%d/%%m/%%Y' ) AS data_solicitacao,
DATE_FORMAT(s.hrsolicitacao, '%%H:%%i' ) AS hora_solicitacao,
s.numcontacorrente,
u.desusuario AS tecnico_abertura,
cl.nome AS nomcliente,
t.destiposervsol,
s.codtecnicoresp,
s.dessolicitacao,
IF( s.dtconclusao IS NULL , 'Solicitação ainda não concluída', DATE_FORMAT( s.dtconclusao, '%%d/%%m/%%Y' ) ) AS data_conclusao,
cl.cpfcnpj AS numcpfcnpj,
IF( s.dtconclusao IS NOT NULL,'S','N') AS concluida,
s.desemailcont,
s.numtelefonecont,
tr.nomtecnicoresp AS nomtecnicoresp
FROM solicitacaoserv s LEFT OUTER JOIN
precadastro cl ON '".substr($row_solicitacao['numcontacorrente'], 1)."'=cl.id LEFT OUTER JOIN
tiposervsolicitacao t ON s.codtiposervsol=t.codtiposervsol LEFT OUTER JOIN
usuario u ON s.tecnico_abertura=u.codusuario LEFT OUTER JOIN
tecnicoresp tr ON s.codtecnicoresp = tr.codtecnicoresp
WHERE s.codsolicitacao =%s
group by s.codsolicitacao
", GetSQLValueString($colname_solicitacao, "int"));

	//echo $query_solicitacao;

	$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die(mysql_error());
	$row_solicitacao = mysql_fetch_assoc($solicitacao);
	$totalRows_solicitacao = mysql_num_rows($solicitacao);
}

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnicoresp = "SELECT `codtecnicoresp` , `nomtecnicoresp` FROM `tecnicoresp`  ORDER BY `nomtecnicoresp`";
$tecnicoresp = mysql_query($query_tecnicoresp, $homebank_conecta) or die(mysql_error());
$row_tecnicoresp = mysql_fetch_assoc($tecnicoresp);
$totalRows_tecnicoresp = mysql_num_rows($tecnicoresp);
?>
<?php if ($totalRows_solicitacao > 0) { // Show if recordset not empty ?>
<table width="100%">
    <tr><td>
  <table border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr valign="top" class="td4">
        <td width="126"><strong>Data de abertura:</strong></td>
        <td width="252"><strong>Solicita&ccedil;&atilde;o N&uacute;mero:</strong></td>
      </tr>
      <tr valign="top">
        <td width="126"><?php echo $row_solicitacao['data_solicitacao']; ?> - <?php echo $row_solicitacao['hora_solicitacao']; ?></td>
        <td width="252"><?php echo $row_solicitacao['codsolicitacao']; ?></td>
      </tr>
	  <?php if($row_solicitacao['tecnico_abertura']!=''){?>
      <tr valign="top" class="td4">
        <td colspan="2"><strong>Aberta por: </strong></td>
        </tr>
      <tr valign="top">
        <td colspan="2"><?php echo $row_solicitacao['tecnico_abertura']; ?></td>
        </tr>
		<?php } ?>
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
        <td><?php

	$row_solicitacao['numcpfcnpj'] = substr($row_solicitacao['numcpfcnpj'], -11);

	echo formataCampo("CPF", $row_solicitacao['numcpfcnpj']);
		?></td>
      </tr>
      </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="296" align="left" valign="top"><p><strong>Conta corrente do cliente</strong>: <br />
          <?php echo $row_solicitacao['numcontacorrente']; ?><br />
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
          <select name="tec_responsavel" id="tec_responsavel" onchange="if(this.value!='0'){ location.href='inc/alteratecnicoresp.php?tecnico='+this.value+'&solicitacao=<?php echo $_GET['cod'];?>'; }">
            
            <?php if($row_solicitacao['codtecnicoresp']==''){ ?>
            <option value="0" <?php if (!(strcmp(0, $row_solicitacao['codtecnicoresp']))) {echo "selected=\"selected\"";} ?>><< Aguardando triagem >></option>
            <?php } ?>
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
		echo $row_solicitacao['nomtecnicoresp'];
		} ?>
          <br />
        
            <br />
          <strong>Data de conclus&atilde;o do servi&ccedil;o: </strong><br />
          <strong> </strong><?php echo $row_solicitacao['data_conclusao']; ?><br />
          <br />
          <strong>Informa&ccedil;&otilde;es para contato:</strong><br />
          <strong>Email: </strong><?php echo $row_solicitacao['desemailcont']; ?><br />
          <strong>Telefone: </strong><?php echo $row_solicitacao['numtelefonecont']; ?></p>
        <p>
          <input name="print" type="button" id="print" value="Imprimir" onclick="window.open('inc/imprimir.php?cod=<?php echo $_GET['cod'];?>','','menubar=yes,scrollbars=yes,width='+screen.width+',height='+screen.height+'')" />
          <?php if($row_solicitacao['concluida']=='N'){ ?>
          <input name="concluir" type="button" id="concluir" value="Concluir OS" onclick="if(confirm('Deseja realmente encerrar essa Solicita&ccedil;&atilde;o ?')){ location.href='encerrar_os.php?cod=<?php echo $_GET['cod'];?>'; }" />
          <?php } ?>
        </p></td>
      <td width="547" valign="top"><? 
$codsolicitacao=$row_solicitacao['codsolicitacao'];
$concluida=$row_solicitacao['concluida'];
include_once "inc/andamentoINC.php"; ?></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="top">&nbsp;</td>
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
  <?php } // Show if recordset not empty ?><?php
mysql_free_result($solicitacao);

mysql_free_result($tecnicoresp);
?>
