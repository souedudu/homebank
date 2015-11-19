<?php include('/homebank2/Connections/homebank_conecta.php'); ?>
<?php
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacao = "SELECT DISTINCT ( solicitacaoserv.codsolicitacao ), tiposervsolicitacao.codtiposol,
DATE_FORMAT(NOW(),'%d/%m/%Y %H:%i') as data_atual,
CONCAT(DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%d/%m/%Y' ),' ',DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%H:%i' ))as data_hora_solicitacao,
tiposervsolicitacao.destiposervsol, solicitacaoserv.numcontacorrente, DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%d/%m/%Y' ) AS data_solicitacao, DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%H:%i' ) AS hora_solicitacao, IF( solicitacaoserv.dtconclusao IS NULL , 'Solicitação não concluída', DATE_FORMAT( solicitacaoserv.dtconclusao, '%d/%m/%Y' ) ) AS data_conclusao, IF( solicitacaoserv.codtecnicoresp IS NULL , 'Aguardando triagem', tecnicoresp.nomtecnicoresp ) AS tecnico_responsavel, cliente.nomcliente FROM solicitacaoserv, tiposervsolicitacao, tecnicoresp, cliente, contacorrente WHERE solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND ( solicitacaoserv.codtecnicoresp = tecnicoresp.codtecnicoresp OR solicitacaoserv.codtecnicoresp IS NULL ) AND cliente.codcliente = contacorrente.codcliente AND contacorrente.numcontacorrente = solicitacaoserv.numcontacorrente AND IF( '' = '', 1, solicitacaoserv.codsolicitacao = '' ) AND IF( '0' = '0', 1, tiposervsolicitacao.destiposervsol = '0' ) AND IF( '' = '', 1, solicitacaoserv.numcontacorrente = '' ) AND IF( '' = '', 1, cliente.nomcliente LIKE '%' ) AND IF( '--' = '--', 1, solicitacaoserv.dtsolicitacao >= CAST( '--' AS DATE ) ) AND IF( '--' = '--', 1, solicitacaoserv.dtsolicitacao <= CAST( '--' AS DATE ) ) AND IF( '-1' = '-1', 1, solicitacaoserv.dtconclusao IS NOT NULL ) AND solicitacaoserv.codtecnicoresp IS  NULL GROUP BY solicitacaoserv.codsolicitacao";

//echo $query_solicitacao;
$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);
?> Total de Registros: <?php echo $totalRows_solicitacao ?> <br />
  Click sobre a solicita&ccedil;&atilde;o para ver detalhes
  <table border="3" cellpadding="1" cellspacing="1">
    <tr class="td4">
      <td><div align="left">N&ordm; da Solicita&ccedil;&atilde;o </div></td>
      <td><div align="left">Solicita&ccedil;&atilde;o </div></td>
      <td>        <div align="left">Conta Corrente / Cliente
        </div></td>
      <td><div align="left">Data da Solicita&ccedil;&atilde;o </div></td>
      <td><div align="left">Conclus&atilde;o </div></td>
      <td><div align="left">T&eacute;cnico Respons&aacute;vel </div></td>
	  <td><div align="left">Tempo</div></td></tr></tr>
      <?php do { 
			if($cont%2==0)
				$cor="#F5F5F5";
			else
				$cor="#FFFFFF";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_solicitacao['codsolicitacao']; ?>';">
        <td><?php echo $row_solicitacao['codsolicitacao']; ?></td>
        <td><?php echo $row_solicitacao['destiposervsol']; ?></td>
        <td><?php echo $row_solicitacao['numcontacorrente']; ?><br />
            <?php echo $row_solicitacao['nomcliente']; ?></td>
        <td><?php echo $row_solicitacao['data_solicitacao']; ?> - <?php echo $row_solicitacao['hora_solicitacao']; ?></td>
        <td><center>
            <?php echo $row_solicitacao['data_conclusao']; ?>
        </center></td>
        <td><?php echo $row_solicitacao['tecnico_responsavel']; ?></td>
		
    <td>
      <?php if (($row_solicitacao['codtiposol'] == '9') && ($row_solicitacao['data_conclusao'] == "Solicitação não concluída")){
		               $tamanho = getDiference($row_solicitacao['data_hora_solicitacao'], $row_solicitacao['data_atual']);
					   if($tamanho >= 48){
					    echo "<img src=\"/homebank2/img2/sinal_vermelho.gif\" alt=\"$tamanho\" width=\"14\" height=\"26\">";
					   }else if($tamanho > 24){
					    echo "<img src=\"/homebank2/img2/sinal_amarelo.gif\" alt=\"$tamanho\" width=\"14\" height=\"26\">";
					   }if($tamanho < 24){
					    echo "<img src=\"/homebank2/img2/sinal_verde.gif\" alt=\"$tamanho\" width=\"14\" height=\"26\">";
					   }
		             //echo "empréstimo";
				   }else{
				     echo "N/A";
				   } ?>
    </td>
		<td></td>
      </tr>
      <?php		$cont++;
			 } while ($row_solicitacao = mysql_fetch_assoc($solicitacao)); ?>
    </table>
  
  <?php

  function getDiference($dataIn,$dataFn){
  //data inicial
 	$diai = substr($dataIn, 0, 2); 
	$mesi = substr($dataIn, 3, 2);  
	$anoi = substr($dataIn, 6, 4); 
	$horai = substr($dataIn,11, 2); 
	$mini = substr($dataIn,14,2); 
   //$segi = substr("$data",17,2);//segundos
    //data final
    $diaf = substr($dataFn, 0, 2); 
	$mesf = substr($dataFn, 3, 2);  
	$anof = substr($dataFn, 6, 4); 
	$horaf = substr($dataFn,11, 2); 
	$minf = substr($dataFn,14,2);  
   
   $dini = mktime($horai,$mini,$segi,$mesi,$diai,$anoi);
   $dinf = mktime($horaf,$minf,$segf,$mesf,$diaf,$anof);
   $total = (int)(($dinf - $dini)/3600);

	return $total;
  
  }
 
 function getDia($data){
 	return substr($data, 0, 2);// dia
 }
 function getMes($data){
 	return substr($data, 3, 2);// mes
 }
 function getAno($data){
 	return substr($data, 6, 4);// ano
 }
 function getHora($data){
 	return substr($data,11, 2);//hora
 }
 function getMin($data	){
 	return substr($data,14,2);//minutos
 }
 
mysql_free_result($solicitacao);
?>
