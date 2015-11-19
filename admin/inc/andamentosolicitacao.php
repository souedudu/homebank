<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Listagem de Solicação de Triagem
************************************************************************************/

include "funcoes_js.php";
include "../library/class_paginacao.php";
@$objpaginacao = new class_paginacao();


Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

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
<table width="750" border="0" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;
          
      </td>
      <td align="center" class="td2">
          <b>Cadastra Andamento das Solicitações</b>
      </td>
  </tr>
</table>
 <BR>
<table width="750" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="738"><b>Nº da Solicitação</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="left"><input type="text" value="<?=$codsolicitacao;?>" id="codsolicitacao" name="codsolicitacao" size="10" onkeypress="formatanumerosol(document.form.codsolicitacao)"> </td>
  </tr>
</table> 

<table width="568" border="0" cellspacing="0" class="form">
  
  <tr>
      <td width="4">&nbsp;      </td>
      <td width="200">
          <b>Data Inicial</b>      </td>
      <td width="358">
          <b>Data Final</b>      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;      </td>
      <td width="200" nowrap="nowrap">
          <input type="text" value="<?=$dtinicio;?>" id="dtinicio" name="dtinicio" size="15" onkeypress="mascaradata(document.form.dtinicio)">
      <font size="1">(dd/mm/aaaa)</font>      </td>
      <td nowrap="nowrap">
          <input type="text" value="<?=$dtfinal;?>"  id="dtfinal" name="dtfinal" size="15" onkeypress="mascaradata(document.form.dtfinal)">
          <font size="1">&nbsp;
          (dd/mm/aaaa)</font>
      </td>
  </tr>
</table>
<table width="760" border="0" cellspacing="0" class="form">

  <tr>
     <td width="5">&nbsp;</td>
      <td align="center"><br><input type="submit" name="Submit" value="Pesquisar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <? $tipoacao = "Consultar"; ?>
          <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
      </td>
  </tr>
</table>
</form>

<?
}

if ($_REQUEST['bttipoacao'] == "Consultar")
{
  
?>
<br>
<table width="750" border="1" cellspacing="0" class=form>
  <tr>
      <td width="5">&nbsp;
          
      </td>
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
   $sqlString6 = "Select te.* from tecnicoresp te, usuario u 
   				  where te.codtecnicoresp = u.codtecnicoresp and
				        u.codusuario = ".$_SESSION['codusuarioadm'];
                 
  $rsqry6 = mysql_query($sqlString6);
  $dados6 = mysql_fetch_array($rsqry6);
  
  if ($codsolicitacao != "")
  {
   $sqlcomplemento = "and s.codsolicitacao = ".$codsolicitacao." ";
  }
   else
   {
    $sqlcomplemento = "";
   }
  if ($dtinicio != "" and $dtfinal != "")
  {
   $dtinicio = FormataData($dtinicio,'en');
   $dtfinal = FormataData($dtfinal,'en');
   $sqlcomplemento2 = "and s.dtsolicitacao >= '".$dtinicio."' and s.dtsolicitacao <= '".$dtfinal."' ";
  }
   else
   {
    $sqlcomplemento2 = "";
   }
  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.dtconclusao is null ".$sqlcomplemento2."
                   and s.codtecnicoresp = ".$dados6['codtecnicoresp']."
                   and s.codtiposervsol = t.codtiposervsol ".$sqlcomplemento."
                 order by s.dtsolicitacao ASC";
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
      <td><strong><b>Total de solicitações: <?=$totalreg;?></b></strong></td>
  </tr>
</table>
<?  

  //Variável para VeRificação de Ícones na pag. cabsolicitacao_con.php
  $tipoconsul = "Andamento";

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
		 $onclickcodsolicitacao = "window.open('../admin/inc/adicionarandamento.php?codsolicitacao=".$codsolicitacao1[$prox]."','Consulta','width=600,height=450,scrollbars=NO, left=200, top=150')";
		 
         //botão de solicitação de triagem
         $onclickcodsolicitacao2 = "window.open('../inc/solicitacao.php?tipoacao=Editar&acaotriagem=s&codsolicitacao=".$codsolicitacao1[$prox]."','Triagem','width=600,height=450,scrollbars=NO, left=200, top=150')";

         $opcaosol1 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao.chr(34)."><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></a>";

         $opcaosol2 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao2.chr(34)."><img src='img/triagem_sol.gif' border='0' alt='Triagem da solicitação.'></a>";

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
	$objpaginacao->link="andamentosolicitacao.php";
	$links = $objpaginacao->class_paginacao()

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


