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
          <b>Resultado da Pesquisa</b><?php echo $_SESSION['codusuarioadm'];?></td>
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
<table border="1" width="300" cellpadding="0" cellspacing="1" >

  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left"><img src='img/visualizar.gif' border='0' alt='Visualizar a solicitação.'></td>
      <td align="left"><b>- Visualizar a solicitação</b></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left"><img src="img/triagem_sol.gif" alt='Triagem da solicitação.' width="19" height="15" border="0"></td>
      <td align="left"><b>- Triagem da solicitação</b></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left" height="15"><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></td>
      <td align="left"><b>- Adicionar Andamento</b></td>
  </tr>
</table>
<BR>
<table border="1" width="750" cellpadding="0" cellspacing="2">
  <tr><td width="5" align="right">&nbsp;</td>
      <td class="td4" width="70" align="right">&nbsp;</td>
      <td class="td4" width="60" align="right">Número</td>
      <td class="td4" width="200" align="left">Tipo de Solicitação</td>	  
      <td class="td4" width="300" align="left">Conta - Cliente</td>	  	  
      <td class="td4" width="65" align="left">Data</td>	  	  	  
      <td class="td4" width="55" align="left">Hora</td>
  </tr>
      <?php do { ?>
  <tr>
        <td width="5" align="right">&nbsp;</td>
        <td bgcolor="#f5f5f5" width="70" align="center"><a href='javascript://;' onclick="window.open('inc/impsolicitacao.php?codsolicitacao=18','Consulta','width=605,height=550,scrollbars=YES, left=200, top=150')"><img src='img/visualizar.gif' border='0' alt='Visualizar a solicitação.'></a>&nbsp;&nbsp;<a href='javascript://;' onclick="window.open('../inc/solicitacao.php?tipoacao=Editar&acaotriagem=s&codsolicitacao=18','Triagem','width=600,height=450,scrollbars=NO, left=200, top=150')"><img src='img/triagem_sol.gif' border='0' alt='Triagem da solicitação.'></a>&nbsp;&nbsp;<a href='javascript://;' onclick="window.open('../admin/inc/adicionarandamento.php?codsolicitacao=18','Consulta','width=600,height=450,scrollbars=NO, left=200, top=150')"><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></a></td>
        <td bgcolor="#f5f5f5" width="60" align="center"><font color="#000000"><?php echo $row_solicitacao['codsolicitacao']; ?></font>    </td>
        <td bgcolor="#f5f5f5" width="200" align="left"><?php echo $row_solicitacao['destiposervsol']; ?></td>
        <td bgcolor="#f5f5f5" width="300" align="left"><?php echo $row_solicitacao['numcontacorrente']; ?> - <?php echo $row_solicitacao['nomcliente']; ?></td>
        <td bgcolor="#f5f5f5" width="65" align="left"><?php echo $row_solicitacao['data_solicitacao']; ?></td>
        <td bgcolor="#f5f5f5" width="55" align="left"><?php echo $row_solicitacao['hora_solicitacao']; ?></td></tr>
        <?php } while ($row_solicitacao = mysql_fetch_assoc($solicitacao)); ?>	  
</table>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_solicitacao > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_solicitacao=%d%s", $currentPage, 0, $queryString_solicitacao); ?>"><img src="First.gif" border=0></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_solicitacao > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_solicitacao=%d%s", $currentPage, max(0, $pageNum_solicitacao - 1), $queryString_solicitacao); ?>"><img src="Previous.gif" border=0></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_solicitacao < $totalPages_solicitacao) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_solicitacao=%d%s", $currentPage, min($totalPages_solicitacao, $pageNum_solicitacao + 1), $queryString_solicitacao); ?>"><img src="Next.gif" border=0></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_solicitacao < $totalPages_solicitacao) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_solicitacao=%d%s", $currentPage, $totalPages_solicitacao, $queryString_solicitacao); ?>"><img src="Last.gif" border=0></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
mysql_free_result($solicitacao);
?>