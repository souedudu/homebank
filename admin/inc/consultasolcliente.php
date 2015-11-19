<?php virtual('/homebank2/Connections/homebank_conecta.php'); ?>
<?php
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacoes = "SELECT solicitacaoserv.codsolicitacao, tiposervsolicitacao.destiposervsol, cliente.nomcliente, tecnicoresp.nomtecnicoresp, DATE_FORMAT(solicitacaoserv.dtsolicitacao,'%d/%m/%Y') AS data_solicitacao, DATE_FORMAT(solicitacaoserv.hrsolicitacao,'%H:%i') AS hora_solicitacao, contacapitalremunerada.numcontacorrente FROM solicitacaoserv, tiposervsolicitacao, cliente, tecnicoresp, contacapitalremunerada WHERE solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND solicitacaoserv.codcliente = cliente.codcliente AND solicitacaoserv.codtecnicoresp = tecnicoresp.codtecnicoresp AND cliente.codcliente = contacapitalremunerada.codcliente";
$solicitacoes = mysql_query($query_solicitacoes, $homebank_conecta) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);
?><table border="1" width="600" cellspacing="0" class="table">
  <tr>
    <td width="5"align="center">&nbsp;</td>
    <td class="td2" align="center"><b>Consulta de OS</b> </td>
  </tr>
</table>
<table border="1" width="600" cellpadding="0" cellspacing="3">
  <tr>
    <td width="5" align="right">&nbsp;</td>
    <td><strong><b>Total de solicita&ccedil;&otilde;es:
      
    </b></strong></td>
  </tr>
  <tr>
    <td width="5" align="right">&nbsp;</td>
    <td><img src='img/visualizar.gif' width='15' height='15' border='0' /> <b>- Visualiza a Ordem de Servi&ccedil;o.</b></td>
  </tr>
</table>
<table border="1" width="600" cellpadding="0" cellspacing="1" >
  <tr>
    <td width="5" align="right">&nbsp;</td>
    <td class="td4" width="90" align="right">&nbsp;</td>
    <td class="td4" width="40" align="right">N&uacute;mero</td>
    <td class="td4" width="120" align="left">Tipo de Solicita&ccedil;&atilde;o</td>
    <td class="td4" width="200" align="left">Conta - Cliente</td>
    <td class="td4" width="32" align="left">T&eacute;cnico</td>
    <td class="td4" width="32" align="left">Data</td>
    <td class="td4" width="55" align="left">Hora</td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td align="right">&nbsp;</td>
    <td align="right" class="td4">&nbsp;</td>
    <td align="right" class="td4"><?php echo $row_solicitacoes['codsolicitacao']; ?></td>
    <td align="left" class="td4"><?php echo $row_solicitacoes['destiposervsol']; ?></td>
    <td align="left" class="td4"><?php echo $row_solicitacoes['numcontacorrente']; ?> - <?php echo $row_solicitacoes['nomcliente']; ?></td>
    <td align="left" class="td4"><?php echo $row_solicitacoes['nomtecnicoresp']; ?></td>
    <td align="left" class="td4"><?php echo $row_solicitacoes['data_solicitacao']; ?></td>
    <td align="left" class="td4"><?php echo $row_solicitacoes['hora_solicitacao']; ?></td>
  </tr>
</table>
<?php
mysql_free_result($solicitacoes);
?>
