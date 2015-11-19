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
  
  if (document.form.codsolicitacao.value =='')  
    if (document.form.tiposolicitacao.value =='')
    {
      alert('Escolha a opção de Pesquisa.');
      document.form.tiposolicitacao.focus();
      return false;
    }
	
  if (document.form.nome2.value !='')  
    if (document.form.nome1.value =='')
    {
      alert('A seleção tem que ser do primeiro nome para o segundo nome, ou então selecione somente o primeiro nome.');
      document.form.nome2.focus();
      return false;
    }	
	
  if ((document.form.nome1.value !='') && (document.form.nome2.value !='')) 
    if (document.form.codoperacao.value =='')
    {
      alert('E obrigatório selecionar a operação.');
      document.form.codoperacao.focus();
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
<table width="750" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;
          
      </td>
      <td align="center" class="td2">
          <b>Consulta de Solicitação</b>
      </td>
  </tr>
</table>
 <BR>
<table width="750" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="100"><b>Nº da Solicitação</b></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td><input type="text" value="<?=$codsolicitacao;?>" id="codsolicitacao" name="codsolicitacao" size="10" onkeypress="formatanumerosol(document.form.codsolicitacao)"> (Obs: Se informar esse campo, os outros abaixo serão ignorados.)</td>	  
  </tr>
</table> 

<table width="750" border="0" cellspacing="0" class="form">
  
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
          <input type="text" value="<?=$dtinicio;?>" id="dtinicio" name="dtinicio" size="15" onkeypress="mascaradata(document.form.dtinicio)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
      </td>
      <td>
          <input type="text" value="<?=$dtfinal;?>"  id="dtfinal" name="dtfinal" size="15" onkeypress="mascaradata(document.form.dtfinal)"><font size="1">&nbsp;(dd/mm/aaaa)</font>
      </td>
  </tr>
</table>
<table width="750" border="1" cellspacing="0" >
  <tr>
      <td width="5">&nbsp;</td>
      <td width="80"><b>Por Técnico</b></td>
      <td width="180"><b>Por Nome (primeiro nome)</b></td>	  
      <td width="90"><b>Operação</b></td>	  	  
      <td width="320"><b>Por Nome (segundo nome)</b></td>	  	  
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td width="80" align="left"><select name="codtecnicoresp" id="codtecnicoresp">
	           <option value="">Selecione</option> 	   
		   
        	  <? 
 		        // Recupera os dados do tecnico
                $sqlstring2 = "select * from tecnicoresp order by nomtecnicoresp";
                $query2 = mysql_query($sqlstring2) or die(mysql_error());			  
			   
			    while($b = mysql_fetch_array($query2))
			    { ?>
       	  	       <option value="<?=$b['codtecnicoresp'];?>" 
				                  <? if ($b['codtecnicoresp']==$rsresult['codtecnicoresp'])
 								       echo "selected";
								  ?> 
					>
				      <?=$b['nomtecnicoresp'];?>
				   </option>
        	  <? 
			     } 			  
			  ?>
             </select> 	  
      </td> 
	  <td><input type="text" id="nome1" name="nome1" size="30" ></td>
      <td align="left">
          <select size="1" name="codoperacao" id="codoperacao">
              <option value="">Seleciona</option>
              <option value="1">E</option>
              <option value="2">Ou</option>
          </select>
      </td>

	  <td><input type="text" id="nome2" name="nome2" size="30" ></td>	  
  </tr>

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
              <option value="3">Solicitações Concluídas</option>
              <option value="4">Todas</option>
          </select>
      </td>
  </tr>
  
  <tr>
     <td width="5">&nbsp;</td>
      <td align="center"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="Pesquisar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="reset" name="resert" value="Cancelar">		  
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

/*  $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t, 
                 where s.codtiposervsol = t.codtiposervsol ";
*/
  $sqlString = "Select s.*, t.destiposervsol, c.numcpfcnpj, c.nomcliente
                 From solicitacaoserv s, tiposervsolicitacao t, contacorrente cc, cliente c
                 where s.codtiposervsol = t.codtiposervsol
                   and s.numcontacorrente = cc.numcontacorrente
                   and cc.codcliente = c.codcliente";				 
				 
  if (($nome1 != "") && ($nome2 == ""))
    $sqlString = $sqlString." and (c.nomcliente like '%$nome1%')"; 	
	
  if (($nome1 != "") && ($nome2 != ""))
  {
    if ($codoperacao == 1)
      $sqlString = $sqlString." and ((c.nomcliente like '%$nome1%') and (c.nomcliente like '%$nome2%'))";
	 
    if ($codoperacao == 2)
      $sqlString = $sqlString." and ((c.nomcliente like '%$nome1%') or (c.nomcliente like '%$nome2%'))";	  
  }	
  
  if ($codtecnicoresp != "")
    $sqlString = $sqlString." and s.codtecnicoresp = $codtecnicoresp ";
							 
	         
  if ($codsolicitacao == "")			     
    if ($dtinicio != "" && $dtfinal != "")
      $sqlString = $sqlString." and s.dtsolicitacao  between  '$dtinicio' and '$dtfinal'";
    
    $sqlString = $sqlString. $sqlwhere. "
                 order by s.codsolicitacao desc";

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
  $tipoconsul = "Consultar";
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
		 $onclickcodsolicitacao = "window.open('inc/impsolicitacao.php?codsolicitacao=".$codsolicitacao1[$prox]."','Consulta','width=605,height=550,scrollbars=YES, left=200, top=150')";
		 
		 $opcaosol1 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao.chr(34)."><img src='img/visualizar.gif' border='0' alt='Visualizar a solicitação.'></a>";
				   			
         $onclickcodsolicitacao2 = "window.open('../inc/solicitacao.php?tipoacao=Editar&acaotriagem=s&codsolicitacao=".$codsolicitacao1[$prox]."','Triagem','width=600,height=450,scrollbars=NO, left=200, top=150')";

		 $opcaosol2 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao2.chr(34)."><img src='img/triagem_sol.gif' border='0' alt='Triagem da solicitação.'></a>";

         $onclickcodsolicitacao3 = "window.open('../admin/inc/adicionarandamento.php?codsolicitacao=".$codsolicitacao1[$prox]."','Consulta','width=600,height=450,scrollbars=NO, left=200, top=150')";

         $opcaosol3 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao3.chr(34)."><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></a>";

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
	$objpaginacao->link="consultasolicitacao.php";
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


