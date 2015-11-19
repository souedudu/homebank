<?
	/* Abre conexão com o banco */
	if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db)){
?>
<table width="290" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Saldo do &uacute;ltimo Dia</strong></td>
  </tr>
  <tr>
    <td width="141" bgcolor="#E6E6E6"><div align="center">Data</div></td>
    <td width="141" bgcolor="#E6E6E6"><div align="right">Valor do Saldo</div></td>
  </tr>
  <?
		// Faz um Select na tabela 'movcontacorrente' buscando os ultimos 5 registros
		$SelMovCC[0] = "SELECT * FROM contacorrente ";
		$SelMovCC[0].= "WHERE codcliente=".$_SESSION['codcliente']." order by datultmovconta desc";
		echo $SelMovCC[0].= " LIMIT 0,1";
		
		
/*		$SelMovCC[0] = "SELECT datultmovconta,vlsaldodispatual FROM movcontacorrente ";
		$SelMovCC[0].= " WHERE numcontacorrente=".$_SESSION['numcontacorrente'];
		$SelMovCC[0].= " ORDER BY datultmovconta DESC";
		$SelMovCC[0].= " LIMIT 0,3";
*/
		
		if(VerificaRegistro($SelMovCC[0])){
			$SelMovCC[1] = @mysql_query($SelMovCC[0]);
			while($ResMovcc = @mysql_fetch_array($SelMovCC[1])){
				if (empty($ResMovcc['datultmovconta'])) $ResMovcc['datultmovconta'] = $today = date('Y-m-d');
			?>
			<tr>
				<td><div align="center"><?=FormataData($ResMovcc['datultmovconta'],'pt');?></div></td>
				<td><div align="right" class="CorFonteAzul"><?=number_format($ResMovcc['vlsaldodispatual'],2,',','.');?>C&nbsp;&nbsp;</div></td>
			</tr>
			<?
			}
		}else{
			?>
			<tr>
			<td height="40" colspan="2"><div align="center">Nenhum registro foi encontrado.</div></td>
			</tr>
			<?
		}
			?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><?
	include_once('inc_botoes.php');
	?></div></td>
  </tr>
</table>
			<?
		Conexao($opcao='close');
}else{
	echo("<div align='center'><p><br><br><br>");
	echo("Não foi possível estabelecer uma conexão com o BD.");
	echo("</p></div>");
}	
?>
