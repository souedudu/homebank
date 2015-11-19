<BR>
<table width="568" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;

      </td>
      <td align="center" class="td2">
          <b>Histórico de Solicitação Conluídas por Ano/Mês</b>
      </td>
  </tr>
</table>
<br>
<?
  $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
  $query = "SELECT year(dtsolicitacao) ano, month(dtsolicitacao) mes,  count(*) totabertas
            FROM solicitacaoserv
            where dtconclusao is not null
            group by year(dtsolicitacao) , month(dtsolicitacao)";
  $rsqry = mysql_query($query);
  $dados = mysql_fetch_array($rsqry);

  $anoanterior = 0;
  $totalgeral = 0;

  while (!($dados==0)){
  
  //dentro do while
  $query1 = "  SELECT year(dtsolicitacao) ano,count(*) totabertasano
               FROM solicitacaoserv
               where dtconclusao is not null and year(dtsolicitacao) = '".$dados['ano']."'".
             "  group by year(dtsolicitacao)";
  $rsqry1 = mysql_query($query1);
  $dados1 = mysql_fetch_array($rsqry1);
  
  
  
  if ($anoanterior != $dados['ano'])
  {
     $anoanterior = $dados['ano'];
	 
	 $totalgeral = $totalgeral + $dados1['totabertasano'];
	 
?>

<table width="217" cellspacing="0" border="0">
   <tr>
       <td width="2">&nbsp;</td>
	   <td width="68" class="td4"><b>Ano: <? echo $dados['ano'];?></b></td>
       <td width="133" align="left" class="td4">&nbsp;&nbsp;&nbsp;Total: <?=$dados1['totabertasano'];?>       </td>
   </tr>
</table>
<table width="217" cellspacing="0" border="0">
   <tr>
       <td width="5">&nbsp;</td>   
       <td width="107" align="left" class="td3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mês</b></td>
       <td width="91" align="right" class="td3"><b>Total</b></td>
   </tr>
</table>
<?  } ?>

<table width="217" cellspacing="0" border="0">
   <tr>
       <td width="5">&nbsp;</td>   
       <td width="102" align="left" class="td3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $dados['mes'];?>       </td>
       <td width="145" align="right" class="td3"><? echo $dados['totabertas'];?>       </td>
   </tr>
</table>
<?  
  

  $dados = mysql_fetch_array($rsqry);
  
   if ($anoanterior != $dados['ano'])
     echo "<br>";
	 
  }//Fim While

?>
<BR />
<table width="217" cellspacing="0" border="0">
   <tr>
       <td width="5">&nbsp;</td>   
       <td width="168" align="left" class="td4"><font color="red">Total de Solicitações</font></td>
       <td width="35" align="right" class="td3"><b><? echo $totalgeral;?></b></td>
   </tr>
</table>
