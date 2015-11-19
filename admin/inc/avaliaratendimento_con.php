<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Listagem de Solicação de Triagem
************************************************************************************/
include "funcoes_js.php";
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
   
include "../library/class_paginacao.php";
@$objpaginacao = new class_paginacao();

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

<br>


<BR>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="750" border="0" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td2">
          <b>Consulta Solicitação para Avaliação de Atendimento - New</b>
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
          <input type="text" id="dtinicio" name="dtinicio" size="15" onkeypress="mascaradata(document.form.dtinicio)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
      </td>
      <td>
          <input type="text" id="dtfinal" name="dtfinal" size="15" onkeypress="mascaradata(document.form.dtfinal)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
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

  // Abre conexão com o bd
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
<table width="750" border="1" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td2">
          <b>Resultado da Pesquisa</b>
      </td>
  </tr>
</table>
<br>
<?	  
  // Lista dados que estão cadastrados na tabela
if ($_REQUEST['bttipoacao'] == "Consultar")
{
   
    $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.dtconclusao is not null  and
				  s.flaquestaval is null";
             
    if ($codsolicitacao == "")			     
      if ($dtinicio != "" && $dtfinal != "")
        $sqlString = $sqlString." and dtsolicitacao  between  '$dtinicio' and '$dtfinal'";
    
    $sqlString = $sqlString. " and s.codtiposervsol = t.codtiposervsol ".$sqlwhere. "
                 order by s.codsolicitacao, s.dtsolicitacao ";

  $rsqry = mysql_query($sqlString);
  $dados = mysql_fetch_array($rsqry);

  // Total de registro
  $totalreg = mysql_num_rows($rsqry); 
  
  if (trim($totalreg) == "") 
    $totalreg = "0";   
  
  // Inicia Contador
  $ct = 1;
  
  while (!($dados == 0))
  {
     $dessolicitante = RecUsuarioSol($dados['codsolicitacao']);
	 
 	 // Recupera o nome e o cpf do conta corrente do cliente
     $sqlString2 = "select c.nomcliente, c.numcpfcnpj from contacorrente cc, cliente c
	               where cc.numcontacorrente = '".$dados['numcontacorrente']."'"."
				    and cc.codcliente = c.codcliente";  
	 
     $rsqry1 = mysql_query($sqlString2);
     $dadosconta = mysql_fetch_array($rsqry1);	
	 
		$codsolicitacao1[$ct]	= $dados["codsolicitacao"];
		$numcontacorrente[$ct]	= Formatacc($dados["numcontacorrente"]);
		$nomcliente[$ct]        = $dadosconta["nomcliente"]; 
		$dtsolicitacao[$ct]		= $dados["dtsolicitacao"];
		$hrsolicitacao[$ct]		= $dados["hrsolicitacao"];
		$destiposervsol[$ct]	= $dados["destiposervsol"];
    
	    $ct++;	 
	 
     $dados = mysql_fetch_array($rsqry);
  }	  
}  
?>
<table border="1" width="700" cellpadding="0" cellspacing="3">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td ><strong><b>Total de solicitações: <?=$totalreg;?></b></strong></td>
  </tr>
</table>
<?  
  //Variável para VeRificação de Ícones na pag. cabsolicitacao_con.php
  $tipoconsul = "Avaliar";
  // Mostra o cabeçalho da consulta de solicitação
  include "cabsolicitacao_con.php";

  $objpaginacao->totalregistros = $ct - 1; 

  // variaveis de paginação
  if ($registros == "" or $registros <= 0)
  {
	  $objpaginacao->registros = 20;
	  $registros = 20;
  }
  else
	$objpaginacao->registros = $registros;

  // se ela esta vazia, dou valor 1 para naum ter problemas	
  if ($prox == "") 
  { 
	 $objpaginacao->prox = 1;
	 $prox = $objpaginacao->prox;
  }
  else
    $objpaginacao->prox = $prox;

  // Contador para comparar com o total de registros por página
  $contador = 1; 
  while ($contador <= $registros)
  { 
	  $contador = $contador + 1; 	
	  
      if ($codsolicitacao1[$prox] != "") 
	  { 

		 $onclickcodsolicitacao = "window.open('../admin/inc/avaliaratendimento.php?codsolicitacao=".$codsolicitacao1[$prox]."','','width=605,height=500,scrollbars=NO, left=200, top=150')";
		 
		 $opcaosol1 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao.chr(34)."><img src='img/avaliar_atendimento.gif' border='0' alt='Avaliar atendimento.'></a>";
				   			
         // Lista os dados da solicitação
         include "listasolicitacao_con.php";
      }
   
      $prox = $prox + 1;
  }
  
    $proxgrava = $prox;
 	$objpaginacao->anterior = $prox - ($registros*2);
	$objpaginacao->prox = $proxgrava;
	$objpaginacao->de = 1;
	$objpaginacao->pgcao = $pgcao;
	$objpaginacao->rotina= "&registros=".$registros."&bttipoacao=".$bttipoacao;
	
	if ($apartir == "")
	  $objpaginacao->apartir = 1;
	  
	$objpaginacao->coditem = $codsolicitacao1[$objpaginacao->apartir];
	$objpaginacao->coditem2 = $codsolicitacao1[$prox];
	$objpaginacao->link="avaliaratendimento_con.php";
	$links = $objpaginacao->class_paginacao();

?>

<br><br>
<table border="1" width="700" cellpadding="0" cellspacing="3" class="table">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td align="center>"><font color="#CC0000"><? echo $links;?></font> </td>
  </tr>

</table>
<?
}
?>


