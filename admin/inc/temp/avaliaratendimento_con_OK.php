<?
/********************************************************************************
Autor: Gelson
Data Cria��o: 09/12/2005
Data Atualiza��o:
Sistema: Home Bank
Descri��o: Consulta Solicita��o para Avalia��o de Atendimento
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

    if (comparadata (document.form.dtinicio,document.form.dtfinal,'A data inicial n�o pode ser maior que a data final!') == false)
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
      <td width="5">&nbsp;
          
      </td>
      <td align="center" class="td2">
          <b>Consulta Solicita��o para Avalia��o de Atendimento</b>
      </td>
  </tr>
</table>
 <BR>
<table width="568" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="100"><b>N� da Solicita��o</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td><input type="text" id="codsolicitacao" name="codsolicitacao" size="10" onkeypress="formatanumerosol(document.form.codsolicitacao)"> (Obs: Se informar esse campo, os outros abaixo ser�o ignorados.)</td>	  
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
      <td width="5">&nbsp;
          
      </td>
      <td align="center" class="td1">
          <b>Resultado da Pesquisa</b>
      </td>
  </tr>
</table>
<br>
<?
  //-------- Listagem das Solicita��es --------------//
    
  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.codtecnicoresp is not null and s.dtconclusao is null 
				 and s.flaquestaval is null";
             
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
     
     
     $nomtecnicoresp = "<font color = 'red'><b>Ainda n�o foi encaminhada para um t�cnico.</b></font>";
     // Recuperar o t�cnico do atendimento
     if ($dados['codtecnicoresp'] != "")
     {
       $sqlstring3 = "select nomtecnicoresp from tecnicoresp where codtecnicoresp = ".$dados['codtecnicoresp'];
       $query3 = mysql_query($sqlstring3);
       $rsresult3 = mysql_fetch_array($query3);
       $nomtecnicoresp = $rsresult3['nomtecnicoresp'];
     }
?>

<table border="1" width="568" cellspacing="0" cellpading="0" class="table">
  <tr>
      <td width="5"align="justify">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>N� da Solicita��o:</b></td>
      <td align="left" class="td3"><? echo $dados['codsolicitacao'];?></td>
  </tr>
  <tr>
      <td width="5"align="justify">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>Data da Abertura:</b></td>
      <td align="left" class="td3"><? echo FormataData($dados['dtsolicitacao'],'pt'); ?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>Aberta Por:</b></td>
      <td align="left" class="td3"><? echo $dessolicitante;?></td>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
     <td width="5"align="center">&nbsp;</td>
     <td align="right" class="td4" width="150"><b>Conta:</b></td>
     <td align="left" class="td3"><? echo $dados['numcontacorrente']. "- ".$dadosconta['nomcliente'];?></td>
  </tr>
  <tr>
     <td width="5"align="center">&nbsp;</td>
     <td align="right" class="td4" width="150"><b>CPF:</b></td>
     <td align="left" class="td3"><? echo $dadosconta['numcpfcnpj'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>Tipo Servi�o:</b></td>
      <td align="left" class="td3"><? echo $dados['destiposervsol'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">
      <td align="right" class="td4" width="150"><b>E-mail Contato:</b></td>
      <td align="left" class="td3"><? echo $dados['desemailcont'];?></td>
  </tr>
  <tr>
      <td width="5"align="center">
      <td align="right" class="td4" width="150"><b>Telefone Contato:</b></td>
      <td align="left" class="td3"><? echo $dados['numtelefonecont'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>T�cnico respons�vel:</b></td>
      <td align="left" class="td3"><? echo $nomtecnicoresp;?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td align="right" class="td4" width="150"><b>Detalhes da Solicita��o:</b></td>
      <td align="left" class="td3"><? echo $dados['dessolicitacao'];?></td>
  </tr>
</table>

<?

   // Lista o Hist�rico do atendimento
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
      echo "    <b>Hist�rico de Atendimento</b>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";

      while (!($rsresult3 == 0))
      {
      
         // Recupera a descri��o da mensagem de atendimento
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
               <td align="right" class="td4" width="150"><b>Descri��o:</b></td>
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
   // Incluir aqui o bot�o para concluir a solicita��o
?>
   <table width="568" cellspacing="0" border="1">
     <tr>
         <td width='5'>&nbsp;</td>
         <td align="right"><b>&nbsp;</b></td>
         <td align="left" width="150"><a href="javascript://;" onclick="window.open('../admin/inc/avaliaratendimento.php?codsolicitacao=<?=$codsolicitacao;?>','Triagem','width=610,height=520,scrollbars=NO, left=200, top=120')"><img src="img/Editar.gif" width="15" height="15" border="0" alt="Concluir Solicita��o."></a>&nbsp;<b>Avaliar Atendimento</b></td>



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
  //--------------------Total de Solicita��es---------------------------//
?>

<table border="1" width="568" cellspacing="0" class="table">
<tr>
 <td width="3"> </td>
   <td width="400" align="left" class="td1">&nbsp;<b>Total de Solicita��es: <? echo $totalsol;?></b>
   </td>
  </tr>
</table>

<?

     $bttipoacao = "";
     $tipoacao = "";
      }// fim if bttipoacao = CONSULTAR

?>