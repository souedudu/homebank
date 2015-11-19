<?php virtual('/homebank2/Connections/homebank_conecta.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_solicitacao = 10;
$pageNum_solicitacao = 0;
if (isset($_GET['pageNum_solicitacao'])) {
  $pageNum_solicitacao = $_GET['pageNum_solicitacao'];
}
$startRow_solicitacao = $pageNum_solicitacao * $maxRows_solicitacao;

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacao = "SELECT solicitacaoserv.codsolicitacao, tiposervsolicitacao.destiposervsol, contacorrente.numcontacorrente, cliente.nomcliente, DATE_FORMAT(solicitacaoserv.dtsolicitacao,'%d/%m/%Y') AS data_solicitacao, DATE_FORMAT(solicitacaoserv.hrsolicitacao,'%H:%i') AS hora_solicitacao, contacorrente.codtipoconta FROM solicitacaoserv, tiposervsolicitacao, cliente, contacorrente WHERE solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND solicitacaoserv.numcontacorrente = contacorrente.numcontacorrente AND contacorrente.codcliente = cliente.codcliente AND solicitacaoserv.codtecnicoresp IS NULL ORDER BY solicitacaoserv.dtatendimento DESC";
$query_limit_solicitacao = sprintf("%s LIMIT %d, %d", $query_solicitacao, $startRow_solicitacao, $maxRows_solicitacao);
$solicitacao = mysql_query($query_limit_solicitacao, $homebank_conecta) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);

if (isset($_GET['totalRows_solicitacao'])) {
  $totalRows_solicitacao = $_GET['totalRows_solicitacao'];
} else {
  $all_solicitacao = mysql_query($query_solicitacao);
  $totalRows_solicitacao = mysql_num_rows($all_solicitacao);
}
$totalPages_solicitacao = ceil($totalRows_solicitacao/$maxRows_solicitacao)-1;

$queryString_solicitacao = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_solicitacao") == false && 
        stristr($param, "totalRows_solicitacao") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_solicitacao = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_solicitacao = sprintf("&totalRows_solicitacao=%d%s", $totalRows_solicitacao, $queryString_solicitacao);
?><br>
<table width="750" border="1" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;
          
      </td>
      <td align="center" class="td2">
          <b>Solicita&ccedil;&otilde;es Aguardando Triagem </b></td>
  </tr>
</table>
<br>
<table border="1" width="700" cellpadding="0" cellspacing="3">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td><strong><b>Total de solicitações: <?php echo $totalRows_solicitacao ?> </b></strong></td>
  </tr>
</table>
<BR>
<table border="3" cellpadding="1" cellspacing="1">
  <tr class="td4">
    <td><div align="left">N&ordm; da Solicita&ccedil;&atilde;o </div></td>
    <td><div align="left">Solicita&ccedil;&atilde;o </div></td>
    <td><div align="left">Conta Corrente / Cliente </div></td>
    <td><div align="left">Data da Solicita&ccedil;&atilde;o </div></td>
  </tr>
  <tr>
    <td></tr></td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#f5f5f5" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_solicitacao['codsolicitacao']; ?>';">
    <td><?php echo $row_solicitacao['codsolicitacao']; ?></td>
    <td><?php echo $row_solicitacao['destiposervsol']; ?></td>
    <td><?php echo $row_solicitacao['numcontacorrente']; ?> - <?php echo $row_solicitacao['nomcliente']; ?></td>
    <td><?php echo $row_solicitacao['data_solicitacao']; ?> - <?php echo $row_solicitacao['hora_solicitacao']; ?>      <center>
          </center></td>
    </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <?php } while ($row_solicitacao = mysql_fetch_assoc($solicitacao)); ?>
</table>
<?php
mysql_free_result($solicitacao);
?>
