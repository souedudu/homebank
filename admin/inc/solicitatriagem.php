<?php include_once('/homebank2/Connections/homebank_conecta.php'); ?>
<?php
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacao = "SELECT DISTINCT ( solicitacaoserv.codsolicitacao ),solicitacaoserv.desproduto, 
tiposervsolicitacao.destiposervsol, 
solicitacaoserv.numcontacorrente,
DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%d/%m/%Y' ) AS data_solicitacao, 
DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%H:%i' ) AS hora_solicitacao, 
IF( solicitacaoserv.codtecnicoresp IS NULL , 'Aguardando triagem', tecnicoresp.nomtecnicoresp ) AS tecnico_responsavel, 
cliente.nomcliente FROM solicitacaoserv, 
tiposervsolicitacao, 
tecnicoresp, 
cliente, 
contacorrente 
WHERE 
solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND 
( solicitacaoserv.codtecnicoresp = tecnicoresp.codtecnicoresp OR solicitacaoserv.codtecnicoresp IS NULL ) AND 
cliente.codcliente = contacorrente.codcliente AND 
contacorrente.numcontacorrente = solicitacaoserv.numcontacorrente AND 
IF( '' = '', 1, solicitacaoserv.codsolicitacao = '' ) AND 
IF( '0' = '0', 1, tiposervsolicitacao.destiposervsol = '0' ) AND 
IF( '' = '', 1, solicitacaoserv.numcontacorrente = '' ) AND 
IF( '' = '', 1, cliente.nomcliente LIKE '%' ) AND 
IF( '--' = '--', 1, solicitacaoserv.dtsolicitacao >= CAST( '--' AS DATE ) ) AND 
IF( '--' = '--', 1, solicitacaoserv.dtsolicitacao <= CAST( '--' AS DATE ) ) AND 
solicitacaoserv.dtconclusao IS NULL AND 
solicitacaoserv.codtecnicoresp IS NULL 
GROUP BY solicitacaoserv.codsolicitacao";
$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);
?> Total de Registros: <?php echo $totalRows_solicitacao ?> <br><br />
  Clique sobre a solicita&ccedil;&atilde;o para ver detalhes<br><br>
  <table border="3" width="100%" cellpadding="1" cellspacing="1">
    <tr class="td4">
      <td><div align="left">N&ordm; da Solicita&ccedil;&atilde;o </div></td>
      <td><div align="left">Produto </div></td>
      <td><div align="left">Tipo Servi�o </div></td>
      <td>        <div align="left">Conta Corrente / Cliente
        </div></td>
      <td><div align="left">Data da Solicita&ccedil;&atilde;o </div></td>
      <td><div align="left">Procedimento/ Fase </div></td></tr></tr>
      <?php do {
			if($cont%2==0)
				$cor="#F5F5F5";
			else
				$cor="#FFFFFF";

 ?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_solicitacao['codsolicitacao']; ?>';">
        <td><?php echo $row_solicitacao['codsolicitacao']; ?></td>
        <td><?php echo $row_solicitacao['desproduto']; ?></td>
        <td><?php echo $row_solicitacao['destiposervsol']; ?></td>
        <td><?php echo $row_solicitacao['numcontacorrente']; ?><br />
            <?php echo $row_solicitacao['nomcliente']; ?></td>
        <td><?php echo $row_solicitacao['data_solicitacao']; ?> - <?php echo $row_solicitacao['hora_solicitacao']; ?></td>
        <td><?php echo $row_solicitacao['tecnico_responsavel']; ?></td>
      </tr>
      <?php 
			$cont++;
			} while ($row_solicitacao = mysql_fetch_assoc($solicitacao)); ?>
    </table>
  
  <?php
mysql_free_result($solicitacao);
?>
