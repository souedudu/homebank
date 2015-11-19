<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização: 12/12/2005
Sistema: Home Bank
Descrição: Consulta de Solicitação
************************************************************************************/

include "funcoes_js.php";
 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
   
?>

<script language=javascript>
function VerificaCamposObrigatorios()
{

  if((document.form.dtinicio.value == "") && (document.form.dtfinal.value != ""))
  {
    alert('Preencha a data inicio.');
	document.form.dtinicio.focus();
	return false;
  }
  
  if((document.form.dtinicio.value != "") && (document.form.dtfinal.value == ""))
  {
    alert('Preencha a data final.');
	document.form.dtfinal.focus();
	return false;
  }
  
  if(document.form.dtinicio.value != "" || document.form.dtfinal.value != "")
  {
	if (validadata(document.form.dtinicio)==false)
    {
		document.form.dtinicio.focus();
		return false;
	}
	
	if (validadata(document.form.dtfinal)==false)
    {
		document.form.dtfinal.focus();
		return false;
	}

    if (comparadata (document.form.dtinicio,document.form.dtfinal,'A data inicial não pode ser maior que a data final!') == false)
    {
      return false;
    }

  }

}

function formatanumerosol(i)
{   

/*  if (document.form.codsolicitacao.length != 0)
  {
	 document.getElementById('dtinicio').disabled = true;
	 document.getElementById('dtfinal').disabled = true;
  }

  if (document.form.codsolicitacao.length == 0)
  {
	 document.getElementById('dtinicio').disabled = false;
	 document.getElementById('dtfinal').disabled = false;
  }
*/

  if ( event.keyCode == 45 || event.keyCode == 46 || event.keyCode == 47) event.returnValue = false;

  if (event.keyCode  < 44 || event.keyCode > 57) event.returnValue = false;

}
</script>

<?

if ($tipoacao == "")
{

?>

<BR>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="568" border="0" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td2">
          <b>Consulta de Solicitação para Conclusão de Atendimento</b>
      </td>
  </tr>
</table>
 <BR>
<table width="568" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="100"><b>Nº da Solicitação</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td><input type="text" id="codsolicitacao" name="codsolicitacao" size="10" onkeypress="formatanumerosol(document.form.codsolicitacao)"> (Obs: Se informar esse campo, os outros abaixo serão ignorados.)</td>	  
  </tr>
</table> 

<table width="568" border="0" cellspacing="0" class="form">
  
  <tr>
      <td width="5">&nbsp;</td>
      <td width="80"><b>Data Inicial</b></td>
      <td><b>Data Final</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td width="80">
          <input type="text" id="dtinicio" name="dtinicio" size="10" onkeypress="mascaradata(document.form.dtinicio)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
      </td>
      <td>
          <input type="text" id="dtfinal" name="dtfinal" size="10" onkeypress="mascaradata(document.form.dtfinal)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
      </td>
  </tr>
</table>
<table width="568" border="0" cellspacing="0" class="form">
  <tr>
     <td width="5">&nbsp;</td>
      <td align="center"><br><br>
          <input type="submit" name="Submit" value="Pesquisar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="reset" name="resert" value="Cancelar">		  
          <? $tipoacao = "Consultar"; ?>
          <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
      </td>
  </tr>
</table>
</form>

<?

  }//fim if tipoacao = VAZIO
  
  //------------ CONSULTAR ----------------------//
    $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

  if ($bttipoacao == "Consultar")
  {

    if ($codsolicitacao == "")
	{
       if ($dtinicio != "")
       {
         $dtinicio = FormataData($dtinicio,'en');
         $dtfinal = FormataData($dtfinal,'en');
       }
     
    }
	else
	{
	  $sqlwhere = " and s.codsolicitacao = ".$codsolicitacao;
	}
	 

?>

<br>
<table width="568" border="1" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td1">
          <b>Resultado da Pesquisa</b>
      </td>
  </tr>
</table>
<br>
<?
  //-------- Listagem das Solicitações --------------//
    
  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.codtecnicoresp is not null and s.dtconclusao is null ";
             
  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.dtconclusao is null
                   and s.codtecnicoresp is null
                   and s.codtiposervsol = t.codtiposervsol";

             
  if ($codsolicitacao == "")			     
    if ($dtinicio != "" && $dtfinal != "")
      $sqlString = $sqlString." and dtsolicitacao  between  '$dtinicio' and '$dtfinal'";
    
    $sqlString = $sqlString. " and s.codtiposervsol = t.codtiposervsol ".$sqlwhere. "
                 order by s.codsolicitacao, s.dtsolicitacao ";
                 
  $rsqry = mysql_query($sqlString);
  $dados = mysql_fetch_array($rsqry);
  $totalsol = 0;
  while (!($dados == 0))
   {
     $codsolicitacao = $dados['codsolicitacao'];
	 $dessolicitante = RecUsuarioSol($codsolicitacao);

	 // Recupera o nome e o cpf do conta corrente do cliente
    $sqlString2 = "select c.nomcliente, c.numcpfcnpj from contacorrente cc, cliente c
	               where cc.numcontacorrente = '".$dados['numcontacorrente']."'"."
				    and cc.codcliente = c.codcliente";

     $rsqry1 = mysql_query($sqlString2);
     $dadosconta = mysql_fetch_array($rsqry1);
     
     
     $nomtecnicoresp = "<font color = 'red'><b>Ainda não foi encaminhada para um técnico.</b></font>";
     // Recuperar o técnico do atendimento
     if ($dados['codtecnicoresp'] != "")
     {
       $sqlstring3 = "select nomtecnicoresp from tecnicoresp where codtecnicoresp = ".$dados['codtecnicoresp'];
       $query3 = mysql_query($sqlstring3);
       $rsresult3 = mysql_fetch_array($query3);
       $nomtecnicoresp = $rsresult3['nomtecnicoresp'];
     }
?>

<table border="1" width="568" cellspacing="0">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Nº da Solicitação:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['codsolicitacao'];?></td>
  </tr>
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Data da Abertura:</b></td>
      <td align="left" class="td3">&nbsp;<? echo FormataData($dados['dtsolicitacao'],'pt'); ?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Aberta Por:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dessolicitante;?></td>
  </tr>
</table>

<table border="1" width="568" cellspacing="0">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Conta:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['numcontacorrente']. "- ".$dadosconta['nomcliente'];?></td>
  </tr>
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>CPF:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dadosconta['numcpfcnpj'];?></td>
  </tr>
</table>

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Tipo Serviço:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['destiposervsol'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>E-mail Contato:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['desemailcont'];?></td>
  </tr>
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Telefone Contato:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['numtelefonecont'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Técnico responsável:</b></td>
      <td align="left" class="td3">&nbsp;<? echo $nomtecnicoresp;?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Detalhes da Solicitação</b></td>
      <td align="left" class="td3">&nbsp;<? echo $dados['dessolicitacao'];?></td>
  </tr>

</table>
<?

   // Lista o Histórico do atendimento
   $sqlstring4 = "select a.*, t.nomtecnicoresp from andamensolicitacao a, tecnicoresp t
                  where a.codsolicitacao =". $dados['codsolicitacao'].
                 " and a.codtecnicoresp = t.codtecnicoresp ".
                 " order by a.datregandamento";
   $query4 = mysql_query($sqlstring4);
   $rsresult3 = mysql_fetch_array($query4);
   
   if (!($rsresult3 == 0))
   {
      echo "<table width='568' border='1' cellspacing='0'>";
      echo "<tr>";
      echo "<td width='5'>&nbsp;";
      echo "</td>";
      echo "<td align='center' class='td4'>";
      echo "    <b>Histórico de Atendimento</b>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";

      while (!($rsresult3 == 0))
      {
      
         // Recupera a descrição da mensagem de atendimento
         if ($rsresult3['codmenatendimento'] != "")
         {
           $sql5 = mysql_query("select desmenatendimento from mensatendimento where codmenatendimento = ".$rsresult3['codmenatendimento']);
           $rsresult5 = mysql_fetch_array($sql5);
           $desmesnagem = $rsresult5['desmenatendimento'];
         }
?>
        <table width='568' border='1' cellspacing='0' class=form>
           <tr>
               <td width="5" align="justify">&nbsp;</td>
               <td width="150" align="right" class="td4"><b>Data/Hora:</b></td>
               <td align="left" class="td3">&nbsp;<?=FormataData($rsresult3['datregandamento'],'pt'). " - ".$rsresult3['hrregandamento'];?>
                ( <?=$rsresult3['nomtecnicoresp'];?> )</td>
           </tr>
           <tr>
               <td width="5" align="justify">&nbsp;</td>
               <td width="150" align="right" class="td4"><b>Descrição:</b></td>
               <td align="left" class="td3">&nbsp;<?=$desmesnagem;?></td>
           </tr>
           <tr>
               <td width="5" align="justify">&nbsp;</td>
               <td width="150" align="right" class="td4"><b>Complemento:</b></td>
               <td align="left" class="td3">&nbsp;<?=$rsresult3['descompmensagem'];?></td>
           </tr>
           <tr cellspacing="1">
             <td width='5'></tr>
             <td width="150" align="right" ><b></b></td>
             <td align="left"></td>
           </tr>
        </table>
<?
        $rsresult3 = mysql_fetch_array($query4);
      }
   }
   // Incluir aqui o botão para concluir a solicitação
?>
   <table width="568" cellspacing="0" border="1">
     <tr>
	 	<td>&nbsp;</td>
		<td width="135">
			<a href="javascript://;" onclick="window.open('conclusaosolicitacao.php?codsolicitacao=<?=$codsolicitacao;?>','Triagem','width=600,height=450,scrollbars=YES, left=200, top=150')"><img src="img/Editar.gif" width="15" height="15" border="0" alt="Concluir Solicitação."></a>&nbsp;<b>Concluir Solicitação</b>
		</td>
	</tr>
   </table>
<?   
   


   echo "<br><br>";
   $dados = mysql_fetch_array($rsqry);
   $totalsol = $totalsol + 1;
   }//fim while

   $bttipoacao = "";
   $dtinicio = "";
   $dtfinal = "";
?>

<?
  //--------------------Total de Solicitações---------------------------//
?>

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <tr>
          <td width="5" align="justify">&nbsp;</td>
          <td width="150" align="right" class="td1"><b>Total de Solicitações:&nbsp;<? echo $totalsol;?></b></td>
      </tr>
</table>

<?

     $bttipoacao = "";
     $tipoacao = "";
      }// fim if bttipoacao = CONSULTAR

?>
