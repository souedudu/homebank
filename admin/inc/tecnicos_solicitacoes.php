<?php //require_once('../../Connections/homebank_conecta.php'); ?>
<?php virtual('/homebank2/Connections/homebank_conecta.php'); ?>
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

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacoes = "SELECT COUNT( `solicitacaoserv`.`codsolicitacao` ) AS numero_solicitacoes, `tecnicoresp`.`nomtecnicoresp` , `tecnicoresp`.`codtecnicoresp` FROM solicitacaoserv, tecnicoresp WHERE `solicitacaoserv`.`codtecnicoresp` <> 2034 AND `tecnicoresp`.`codtecnicoresp` = `solicitacaoserv`.`codtecnicoresp` AND solicitacaoserv.dtconclusao IS NULL AND solicitacaoserv.codcliente IS NOT NULL GROUP BY `tecnicoresp`.`codtecnicoresp` ORDER BY `tecnicoresp`.`nomtecnicoresp`, solicitacaoserv.dtsolicitacao ASC ";
$solicitacoes = mysql_query($query_solicitacoes, $homebank_conecta) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);
?>
<?php
function mostrasolicitacoes($tecnico){
	//include('../../../Connections/homebank_conecta.php');
	$sql="SELECT `solicitacaoserv`.`codsolicitacao` , `tiposervsolicitacao`.`destiposervsol` , DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%d/%m/%Y' ) AS data_solicitacao, DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%H:%i' ) AS hora_solicitacao, cliente.nomcliente, solicitacaoserv.numcontacorrente FROM solicitacaoserv, tecnicoresp, tiposervsolicitacao, cliente, contacorrente WHERE `solicitacaoserv`.`codtecnicoresp` <> 2034 AND `tecnicoresp`.`codtecnicoresp` = `solicitacaoserv`.`codtecnicoresp` AND `tiposervsolicitacao`.`codtiposervsol` = `solicitacaoserv`.`codtiposervsol` AND cliente.codcliente = contacorrente.codcliente AND contacorrente.numcontacorrente = solicitacaoserv.numcontacorrente AND solicitacaoserv.dtconclusao IS NULL AND tecnicoresp.codtecnicoresp = ".$tecnico." ORDER BY solicitacaoserv.dtsolicitacao, solicitacaoserv.hrsolicitacao DESC ";
	@mysql_select_db($database_homebank_conecta, $homebank_conecta);
	$result = mysql_query($sql);
	$tabela = '<table border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td><strong>N&uacute;mero</strong></td>
    <td><strong>Solicita&ccedil;&atilde;o de: </strong></td>
    <td><strong>Conta/Cliente</strong></td>
    <td><strong>Data abertura </strong></td>
  </tr>';
	do{
		if($row['codsolicitacao']>=1){
			$tabela.="<tr style=\"cursor:hand;\" onclick=\"location.href='ver.php?cod=".$row['codsolicitacao']."';\"><td>".$row['codsolicitacao']."</td><td>".$row['destiposervsol']."</td><td>".$row['numcontacorrente']."/".$row['nomcliente']."</td><td>".$row['data_solicitacao']." - ".$row['hora_solicitacao']."</td></tr>";
		}
	} while ($row = mysql_fetch_assoc($result));
	$tabela.="</table>";
	return $tabela;
}
?>
<script language="JavaScript" type="text/javascript">
function mostratabela(tabela){
	if(document.getElementById(tabela).style.visibility=="visible"){
	document.getElementById(tabela).style.height="0px";
	document.getElementById(tabela).style.visibility="hidden";
	}
	else {
	document.getElementById(tabela).style.height="auto";
	document.getElementById(tabela).style.visibility="visible";
	}
}
function escondetabela(){
	
}
</script>
<input type="hidden" id="amostra" name="amostra" />
<table border="0" cellspacing="0" cellpadding="0">
<?php $i=0;?>
  <?php do { ?>
    <tr>
      <td><img id="expand" src="/homebank2/admin/img/expand.gif" width="16" height="16" onclick="mostratabela('tabeladetalhes[<?php echo $i;?>]');" /></td>
      <td style="border-bottom-style: solid; border-bottom-color:#999999;"><?php echo $row_solicitacoes['nomtecnicoresp']; ?></td>
      <td><?php echo $row_solicitacoes['numero_solicitacoes']; ?></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"><div id="tabeladetalhes[<?php echo $i;?>]" style="height:0px; visibility:hidden;"><?php echo mostrasolicitacoes($row_solicitacoes['codtecnicoresp']); ?></div>
	  </td>
    </tr>
<?php $i=$i+1; ?>
    <?php } while ($row_solicitacoes = mysql_fetch_assoc($solicitacoes)); ?>
</table>
<?php
//mysql_free_result($solicitacoes);
?>