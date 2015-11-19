<BR>
<table width="568" border="1" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;

      </td>
      <td align="center" class="td2">
          <b>Total de solicitação de serviço por tipo de atendimento</b>
      </td>
  </tr>
</table>

<BR>

<table width="200" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td class="td4">Descrição</td>
	<td width="30" class="td4" align="center">Total</td>
  </tr>
</table>

<?

  $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
  $query = "SELECT count(*) totconcluidas from solicitacaoserv where dtconclusao is not null";
  $rsconcluidas = mysql_query($query);
  $dadosconcluidas = mysql_fetch_array($rsconcluidas);
  
  $query = "SELECT count(*) totabertas from solicitacaoserv where dtconclusao is null";
  $rsabertas = mysql_query($query);
  $dadosabertas = mysql_fetch_array($rsabertas);
  

?>

<table width="200" cellspacing="0" cellpadding="0" border="1">
  <tr cellspacing="1">
      <td></td>
      <td></td>
      <td></td>
  <tr>
  <tr>
    <td width="5"></td>
    <td class="td6">Solicitações Abertas</td>
    <td width="50" class="td3" align="right"><? echo $dadosabertas['totabertas']?></td>
  </tr>
  <tr>
    <td width="5"></td>
	<td class="td6">Solicitações Concluídas</td>
    <td width="50" class="td3" align="right"><? echo $dadosconcluidas['totconcluidas']?></td>
  </tr>

</table>
