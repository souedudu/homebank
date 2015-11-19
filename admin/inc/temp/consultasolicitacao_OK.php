<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Consulta de Solicitação
************************************************************************************/

include "funcoes_js.php";
   
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
  
  if (document.form.codsolicitacao.value =='')  
    if (document.form.tiposolicitacao.value =='')
    {
      alert('Escolha a opção de Pesquisa.');
      document.form.tiposolicitacao.focus();
      return false;
    }
}

function formatanumerosol(i)
{   

/*  if (document.form.codsolicitacao.length != 0)
  {
	 document.getElementById('dtinicio').disabled = true;
	 document.getElementById('dtfinal').disabled = true;
	 document.getElementById('tiposolicitacao').disabled = true;	 	 
  }

  if (document.form.codsolicitacao.length == 0)
  {
	 document.getElementById('dtinicio').disabled = false;
	 document.getElementById('dtfinal').disabled = false;
	 document.getElementById('tiposolicitacao').disabled = false;	 	 
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
      <td width="5">&nbsp;
          
      </td>
      <td align="center">
          <b>Consulta de Solicitação</b>
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
      <td width="5">&nbsp;
          
      </td>
      <td width="80">
          <b>Data Inicial</b>
      </td>
      <td>
          <b>Data Final</b>
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;
          
      </td>
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
      <td><b>Tipo de Pesquisa</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="left">
          <select size="1" name="tiposolicitacao" id="tiposolicitacao">
              <option value="">Escolha o Tipo de Pesquisa</option>
              <option value="1">Solicitações Abertas</option>
<!--              <option value="2">Solicitações Canceladas</option> !-->
              <option value="3">Solicitações Concluídas</option>
              <option value="4">Todas</option>
          </select>
      </td>
  </tr>
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
     
       if ($tiposolicitacao == "1")
       {
          $sqlwhere = " and s.dtconclusao is null  and  s.dtencerramento is null";
       }
     

       if ($tiposolicitacao == "3")
       {
        $sqlwhere = " and s.dtconclusao is not null";
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
      <td width="5">&nbsp;
          
      </td>
      <td align="center">
          <b>Resultado da Pesquisa</b>
      </td>
  </tr>
</table>
<br>
<?
  //-------- Listagem das Solicitações --------------//
    
  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.codtiposervsol = t.codtiposervsol ";
             
  if ($codsolicitacao == "")			     
    if ($dtinicio != "" && $dtfinal != "")
      $sqlString = $sqlString." and s.dtsolicitacao  between  '$dtinicio' and '$dtfinal'";
    
    $sqlString = $sqlString. $sqlwhere. "
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


<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="right">&nbsp;      </td>
      <td class="td4" width="150" align="right"><b>Nº da Solicitação:</b>      </td>
	  <td class="td3"><? echo $dados['codsolicitacao'];?>      </td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;      </td>
      <td class="td4" width="150" align="right"><b>Data de Abertura:</b></td>
	  <td class="td3"><? echo FormataData($dados['dtsolicitacao'],'pt'); ?></td>
      </td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="right">&nbsp;</td>
      <td class="td4" width="150" align="right"><b>Aberta Por:</b></td>
	  <td class="td3"><? echo $dessolicitante;?></td>
      </td>
  </tr>
</table>

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
     <td width="5"align="center">&nbsp;</td>
      <td class="td4" width="150" align="right"><b>Conta corrente do cliente:</b></td>
	  <td class="td3"><? echo $dados['numcontacorrente']. "- ".$dadosconta['nomcliente'];?></td>
      </td>
  </tr>	  

  <tr>
     <td width="5"align="center">&nbsp;</td>
      <td class="td4" align="right"><b>CPF do Cliente:</b></td>
	  <td class="td3"><? echo $dadosconta['numcpfcnpj'];?></td>
      </td>  
  </tr>
</table> 

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;
          
      </td>
      <td class="td4" align="right" width="150"><b>Tipo Serviço:</b></td>
	  <td class="td3"><? echo $dados['destiposervsol'];?></td>
      </td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="center">&nbsp;       </td>
      <td class="td4" width="150" align="right"><b>E-mail Contato:</b></td>
  	  <td class="td3">  <? echo $dados['desemailcont'];?> </td>
  </tr>
  <tr>	  
     <td width="5" align="center">&nbsp;       </td>
      <td class="td4" align="right"><b>Telefone Contato:</b></td> 
	  <td class="td3"><? echo $dados['numtelefonecont'];?></td>

  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;
          
      </td>
      <td class="td4" width="150" align="right"><b>Detalhes da Solicitação:</b></td>
       <td class="td3" > <? echo $dados['dessolicitacao'];?> </td>
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
      echo "<table width='568' border='1' cellspacing='0' class=form>";
      echo "<tr>";
      echo "<td width='5'>&nbsp;";
      echo "</td>";
      echo "<td align='center'class='td4'>";
      echo "    <b>Histórico de Atendimento</b>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";

      while (!($rsresult3 == 0))
      {
      
         // Recupera a descrição da mensagem de atendimento
         if ($rsresult3['codmenatedimento'] != "")
         {
           $query5 = mysql_query("select desmenatendimento from mensatendimento where codmenatedimento = ".$rsresult3['codmenatedimento']);
           $rsresult5 = mysql_fetch_array($query4);
           $desmesnagem = $rsresult5['desmenatendimento'];
         }
?>
        <table width='568' border='1' cellspacing='0' class=form>
           <tr>
               <td width='5'>&nbsp;</td>
               <td align="right" class="td4" width="150"><b>Data/Hora:</b></td>
               <td align="left" class="td3"><?=FormataData($rsresult3['datregandamento'],'pt'). " - ".$rsresult3['hrregandamento'];?>&nbsp;( <?=$rsresult3['nomtecnicoresp'];?> )</td>
           </tr>
           <tr>
               <td width='5'>&nbsp;</td>
               <td align="right" class="td4" width="150"><b>Descrição:</b></td>
               <td align="left" class="td3"><?=$desmesnagem;?></td>
           </tr>
           <tr>
               <td width='5'>&nbsp;</td>
               <td align="right" class="td4" width="150"><b>Complemento:</b></td>
               <td align="left" class="td3"><?=$rsresult3['descompmensagem'];?></td>
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
   echo "<br>";
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
 <td width="3"> </td>
   <td width="400" align="left">&nbsp;<b>Total de Solicitações: <? echo $totalsol;?></b>
   </td>
  </tr>
</table>

<?

     $bttipoacao = "";
     $tipoacao = "";
      }// fim if bttipoacao = CONSULTAR

?>
