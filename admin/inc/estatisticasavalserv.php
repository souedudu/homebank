<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Consulta de Solicitação
************************************************************************************/

include "funcoes_js.php";

//funcao para retornar número formatado
	 function numero($num,$money=true){
		if($money)
        {
         $m = "R$";
        }
         else
             {
              $m = "";
             }
		$num = round($num,2);
		$num = number_format($num,"2",",",".");
		return "$m $num";
    }


?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
 if (document.form.tipoavaliacao.value =='')
    {
      alert('Escolha o tipo de Avaliação.');
      document.form.tipoavaliacao.focus();
      return false;
    }



}
</script>

<?

  if ($tipoacao == "")
  {

?>

<BR>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<BR>
 <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b>Estatísticas de Avaliação de Serviços</b></strong></td>
  </tr>
</table>
<BR>
<table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td align="right" width="200" class="td3">Tipos de Avalição de Serviços</td>
      <td class="td4">&nbsp;<select size="1" name="tipoavaliacao" id="tipoavaliacao">
                                <option value="">Escolha a Opção</option>
                                <option value="AG">Avaliação Geral</option>
                                <option value="TA">Tempo de Atendimento</option>
                                <option value="QA">Qualidade do Atendimento</option>
                                <option value="TR">Tipo de Relacionamento</option>
                            </select>
      </td>
  </tr>
</table>
<table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center"><br><br>
          <input type="submit" name="Submit" value="Gerar Estatística">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <? $tipoacao = "Consultar"; ?>
          <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
      </td>
  </tr>
</table>
</form>
<?
  }//Fim if tipoação

  if ($tipoacao == "Consultar")
     {
       $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
       
     //Busca total de solicitações
       $sqlStringOS = "SELECT count(*) totalsol
                       FROM solicitacaoserv";
       $rsqryOS = mysql_query($sqlStringOS);
       $dadosOS = mysql_fetch_array($rsqryOS);
       $totalOS = $dadosOS['totalsol'];
       //$totalOSaux = $dadosOS['totalsol'];
     
      if ($_REQUEST['tipoavaliacao'] == "AG")
      {

       $sqlStringAG1 = "SELECT count(*) totavalgeralruim
                        FROM avaliacaosol
                        Where flaavalatendimento = 'u'";
                        
       $sqlStringAG2 = "SELECT count(*) totavalgeralregular
                        FROM avaliacaosol
                        Where flaavalatendimento = 'r'";

       $sqlStringAG3 = "SELECT count(*) totavalgeralbom
                        FROM avaliacaosol
                        Where flaavalatendimento = 'b'";
                        
       $rsqryAG1 = mysql_query($sqlStringAG1);
       $rsqryAG2 = mysql_query($sqlStringAG2);
       $rsqryAG3 = mysql_query($sqlStringAG3);
                     
       $dadosAG1 = mysql_fetch_array($rsqryAG1);
       $dadosAG2 = mysql_fetch_array($rsqryAG2);
       $dadosAG3 = mysql_fetch_array($rsqryAG3);
       
       $AG1 = $dadosAG1['totavalgeralruim'];
       $AG2 = $dadosAG2['totavalgeralregular'];
       $AG3 = $dadosAG3['totavalgeralbom'];
       
       $totalAG = $AG1 + $AG2 + $AG3;
       
       //porcentagem do campo ruim da avaliação geral
       $porcentagemAG1 = $AG1/$totalOS;
       $porcentagemAG1 = $porcentagemAG1 * 100;
       
       //porcentagem do campo regular da avaliação geral
       $porcentagemAG2 = $AG2/$totalOS;
       $porcentagemAG2 = $porcentagemAG2 * 100;
       
       //porcentagem do campo bom da avaliação geral
       $porcentagemAG3 = $AG3/$totalOS;
       $porcentagemAG3 = $porcentagemAG3 * 100;

       //gera o total de votos nulos
       $votosnulosAG = $totalOS - $totalAG;
       
       //gera a porcetagem dos votos nulos
       $porcentagemnulosAG = $votosnulosAG/$totalOS;
       $porcentagemnulosAG = $porcentagemnulosAG * 100;

       //gera a porcentagem final
       $totalOSaux = $totalAG+$votosnulosAG;
       $totalporcentagemAG = $totalOSaux/$totalOS;
       $totalporcentagemAG = $totalporcentagemAG * 100;

?>

<table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td1"><strong><b>Avaliação Geral</b></strong></td>
  </tr>
</table>
<BR>
<table width="400" class="table" border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Ruim:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<?=$AG1?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemAG1,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Regular:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $AG2; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemAG2,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Bom:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $AG3; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemAG3,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Nulos:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $votosnulosAG; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemnulosAG,false)?>%
      </td>
  </tr>
  <tr cellspacing="1">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Total Solicitações:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $totalOSaux; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<font color="red"><b><?=numero($totalporcentagemAG,false)?>%</b></font>
      </td>
  </tr>

</table>

<?
      }//fim if request['tipoavaliacao']
      
      if ($_REQUEST['tipoavaliacao'] == "TA")
      {

       $sqlStringTA1 = "SELECT count(*) totavalgeralruim
                        FROM avaliacaosol
                        Where flatempoatendimento = 'u'";

       $sqlStringTA2 = "SELECT count(*) totavalgeralregular
                        FROM avaliacaosol
                        Where flatempoatendimento = 'r'";

       $sqlStringTA3 = "SELECT count(*) totavalgeralbom
                        FROM avaliacaosol
                        Where flatempoatendimento = 'b'";

       $rsqryTA1 = mysql_query($sqlStringTA1);
       $rsqryTA2 = mysql_query($sqlStringTA2);
       $rsqryTA3 = mysql_query($sqlStringTA3);

       $dadosTA1 = mysql_fetch_array($rsqryTA1);
       $dadosTA2 = mysql_fetch_array($rsqryTA2);
       $dadosTA3 = mysql_fetch_array($rsqryTA3);

       $TA1 = $dadosTA1['totavalgeralruim'];
       $TA2 = $dadosTA2['totavalgeralregular'];
       $TA3 = $dadosTA3['totavalgeralbom'];

       $totalTA = $TA1 + $TA2 + $TA3;

       //porcentagem do campo ruim da avaliação geral
       $porcentagemTA1 = $TA1/$totalOS;
       $porcentagemTA1 = $porcentagemTA1 * 100;

       //porcentagem do campo regular da avaliação geral
       $porcentagemTA2 = $TA2/$totalOS;
       $porcentagemTA2 = $porcentagemTA2 * 100;

       //porcentagem do campo bom da avaliação geral
       $porcentagemTA3 = $TA3/$totalOS;
       $porcentagemTA3 = $porcentagemTA3 * 100;

       //gera o total de votos nulos
       $votosnulosTA = $totalOS - $totalTA;

       //gera a porcetagem dos votos nulos
       $porcentagemnulosTA = $votosnulosTA/$totalOS;
       $porcentagemnulosTA = $porcentagemnulosTA * 100;

       //gera a porcentagem final
       $totalOSaux = $totalTA+$votosnulosTA;
       $totalporcentagemTA = $totalOSaux/$totalOS;
       $totalporcentagemTA = $totalporcentagemTA * 100;

?>

<table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td1"><strong><b>Tempo de Atendimento</b></strong></td>
  </tr>
</table>
<BR>
<table width="400" class="table" border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Ruim:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TA1; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTA1,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Regular:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TA2; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTA2,false)?><? echo $porcentagemTA2; ?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Bom:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TA3; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTA3,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Nulos:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $votosnulosTA; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemnulosTA,false)?>%
      </td>
  </tr>
  <tr cellspacing="1">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Total Solicitações:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $totalOSaux; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<font color="red"><b><?=numero($totalporcentagemTA,false)?>%</b></font>
      </td>
  </tr>

</table>
<?
     }//fim if request['tipoavaliacao']

     if ($_REQUEST['tipoavaliacao'] == "QA")
      {

       $sqlStringQA1 = "SELECT count(*) totavalgeralruim
                        FROM avaliacaosol
                        Where flaqualatendimento = 'u'";

       $sqlStringQA2 = "SELECT count(*) totavalgeralregular
                        FROM avaliacaosol
                        Where flaqualatendimento = 'r'";

       $sqlStringQA3 = "SELECT count(*) totavalgeralbom
                        FROM avaliacaosol
                        Where flaqualatendimento = 'b'";

       $rsqryQA1 = mysql_query($sqlStringQA1);
       $rsqryQA2 = mysql_query($sqlStringQA2);
       $rsqryQA3 = mysql_query($sqlStringQA3);

       $dadosQA1 = mysql_fetch_array($rsqryQA1);
       $dadosQA2 = mysql_fetch_array($rsqryQA2);
       $dadosQA3 = mysql_fetch_array($rsqryQA3);

       $QA1 = $dadosQA1['totavalgeralruim'];
       $QA2 = $dadosQA2['totavalgeralregular'];
       $QA3 = $dadosQA3['totavalgeralbom'];

       $totalQA = $QA1 + $QA2 + $QA3;

       //porcentagem do campo ruim da avaliação geral
       $porcentagemQA1 = $QA1/$totalOS;
       $porcentagemQA1 = $porcentagemQA1 * 100;

       //porcentagem do campo regular da avaliação geral
       $porcentagemQA2 = $QA2/$totalOS;
       $porcentagemQA2 = $porcentagemQA2 * 100;

       //porcentagem do campo bom da avaliação geral
       $porcentagemQA3 = $QA3/$totalOS;
       $porcentagemQA3 = $porcentagemQA3 * 100;

       //gera o total de votos nulos
       $votosnulosQA = $totalOS - $totalQA;

       //gera a porcetagem dos votos nulos
       $porcentagemnulosQA = $votosnulosQA/$totalOS;
       $porcentagemnulosQA = $porcentagemnulosQA * 100;

       //gera a porcentagem final
       $totalOSaux = $totalQA+$votosnulosQA;
       $totalporcentagemQA = $totalOSaux/$totalOS;
       $totalporcentagemQA = $totalporcentagemQA * 100;

?>

<table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td1"><strong><b>Qualidade do Atendimento</b></strong></td>
  </tr>
</table>
<BR>
<table width="400" class="table" border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Ruim:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $QA1; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemQA1,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Regular:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $QA2; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemQA2,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Bom:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $QA3; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemQA3,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Nulos:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $votosnulosQA; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemnulosQA,false)?>%
      </td>
  </tr>
  <tr cellspacing="1">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Total Solicitações:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $totalOSaux; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<font color="red"><b><?=numero($totalporcentagemQA,false)?>%</b></font>
      </td>
  </tr>

</table>
<?
     }//fim if request['tipoavaliacao']

     if ($_REQUEST['tipoavaliacao'] == "TR")
      {

       $sqlStringTR1 = "SELECT count(*) tottel
                        FROM avaliacaosol
                        Where flaformarelac = 't'";

       $sqlStringTR2 = "SELECT count(*) totmail
                        FROM avaliacaosol
                        Where flaformarelac = 'm'";

       $sqlStringTR3 = "SELECT count(*) totfax
                        FROM avaliacaosol
                        Where flaformarelac = 'f'";
                        
       $sqlStringTR4 = "SELECT count(*) totinternet
                        FROM avaliacaosol
                        Where flaformarelac = 'i'";
                        
       $sqlStringTR5 = "SELECT count(*) totpessoalmente
                        FROM avaliacaosol
                        Where flaformarelac = 'p'";

       $rsqryTR1 = mysql_query($sqlStringTR1);
       $rsqryTR2 = mysql_query($sqlStringTR2);
       $rsqryTR3 = mysql_query($sqlStringTR3);
       $rsqryTR4 = mysql_query($sqlStringTR4);
       $rsqryTR5 = mysql_query($sqlStringTR5);

       $dadosTR1 = mysql_fetch_array($rsqryTR1);
       $dadosTR2 = mysql_fetch_array($rsqryTR2);
       $dadosTR3 = mysql_fetch_array($rsqryTR3);
       $dadosTR4 = mysql_fetch_array($rsqryTR4);
       $dadosTR5 = mysql_fetch_array($rsqryTR5);

       $TR1 = $dadosTR1['tottel'];
       $TR2 = $dadosTR2['totmail'];
       $TR3 = $dadosTR3['totfax'];
       $TR4 = $dadosTR4['totinternet'];
       $TR5 = $dadosTR5['totpessoalmente'];

       $totalTR = $TR1 + $TR2 + $TR3 + $TR4 + $TR5;

       //porcentagem do campo telefone da avaliação geral
       $porcentagemTR1 = $TR1/$totalOS;
       $porcentagemTR1 = $porcentagemTR1 * 100;

       //porcentagem do campo mail da avaliação geral
       $porcentagemTR2 = $TR2/$totalOS;
       $porcentagemTR2 = $porcentagemTR2 * 100;

       //porcentagem do campo fax da avaliação geral
       $porcentagemTR3 = $TR3/$totalOS;
       $porcentagemTR3 = $porcentagemTR3 * 100;
       
       //porcentagem do campo internet da avaliação geral
       $porcentagemTR4 = $TR4/$totalOS;
       $porcentagemTR4 = $porcentagemTR4 * 100;
       
       //porcentagem do campo pessoalmente da avaliação geral
       $porcentagemTR5 = $TR5/$totalOS;
       $porcentagemTR5 = $porcentagemTR5 * 100;

       //gera o total de votos nulos
       $votosnulosTR = $totalOS - $totalTR;

       //gera a porcetagem dos votos nulos
       $porcentagemnulosTR = $votosnulosTR/$totalOS;
       $porcentagemnulosTR = $porcentagemnulosTR * 100;

       //gera a porcentagem final
       $totalOSaux = $totalTR+$votosnulosTR;
       $totalporcentagemTR = $totalOSaux/$totalOS;
       $totalporcentagemTR = $totalporcentagemTR * 100;

?>

<table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td1"><strong><b>Tipo de Relacionamento</b></strong></td>
  </tr>
</table>
<BR>
<table width="400" class="table" border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Telefone:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TR1; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTR1,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           E-mail:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TR2; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTR2,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Fax:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TR3; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTR3,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Internet:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TR4; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTR4,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Pessoalmente:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $TR5; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemTR5,false)?>%
      </td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Nulos:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $votosnulosTR; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<?=numero($porcentagemnulosTR,false)?>%
      </td>
  </tr>
  <tr cellspacing="1">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="110" class="td4">
           Total Solicitações:
      </td>
      <td width="30" align="center" class="td3">
           &nbsp;<? echo $totalOSaux; ?>
      </td>
      <td align="center" width="90" class="td4">
           Porcentagem:
      </td>
      <td align="center" width="30" class="td3">
           &nbsp;<font color="red"><b><?=numero($totalporcentagemTR,false)?>%</b></font>
      </td>
  </tr>

</table>
<?
     }//fim if request['tipoavaliacao']
     
     }//fim if tipoacao = CONSULTAR
?>

