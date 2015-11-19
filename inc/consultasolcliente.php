<?
/********************************************************************************
Autor: Gelson
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Consulta Solicitação do cliente
************************************************************************************/
include "library/class_paginacao.php";
@$objpaginacao = new class_paginacao();

?>

<br>

<table border="1" width="600" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;
          
      </td>
      <td class="td2" align="center">
          <b>Ordem de Serviço já Solicitadas</b>
      </td>
  </tr>
</table>

<?

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
{
  // Lista dados que estão cadastrados na tabela
  if ($_REQUEST['tipoacao'] == "")
  {
  
     // Verifica se o usuário é delegado
     $sqldel = "select coddelegado From delegado where codcliente = ".$_SESSION['codcliente'];
     $querydel = mysql_query($sqldel);
     $rsresultdel = mysql_fetch_array($querydel);  
	 
	 if ($rsresultdel['coddelegado'] != "")
	 {
	   // Sql para recuperar as solicitações que o delegado fez
       $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.codtiposervsol = t.codtiposervsol
				 and s.codcliente = '".$_SESSION['codcliente']."'"."
                 order by s.codsolicitacao desc";	
	 }
	 else
	 {
 	   //  Sql para recuperar as solicitações do cliente
       $sqlString = "Select s.*, t.destiposervsol
                 From solicitacaoserv s, tiposervsolicitacao t
                 where s.codtiposervsol = t.codtiposervsol
				 and s.numcontacorrente = '".$_SESSION['numcontacorrente']."'"."
                 order by s.codsolicitacao desc";
      }
	             
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
		$numcontacorrentev[$ct]	= Formatacc($dados["numcontacorrente"]);
		$nomclientev[$ct]        = $dadosconta["nomcliente"]; 
		$dtsolicitacao[$ct]		= $dados["dtsolicitacao"];
		$hrsolicitacao[$ct]		= $dados["hrsolicitacao"];
		$destiposervsol[$ct]	= $dados["destiposervsol"];
    
	    $ct++;	 
	 
     $dados = mysql_fetch_array($rsqry);
  }	  
  
?>
<table border="1" width="600" cellpadding="0" cellspacing="3">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td><strong><b>Total de solicitações: <?=$totalreg;?></b></strong></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>  
      <td><img src='img/visualizar.gif' width='15' height='15' border='0'> <b>- Visualiza a Ordem de Serviço.</b></td>
  </tr>
</table>

<table border="1" width="600" cellpadding="0" cellspacing="1" >
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td class="td4" width="15" align="right">&nbsp;</td>
      <td class="td4" width="40" align="right">Número</td>
      <td class="td4" width="120" align="left">Tipo de Solicitação</td>	  
      <td class="td4" width="200" align="left">Conta - Cliente</td>	  	  
      <td class="td4" width="65" align="left">Data</td>	  	  	  
      <td class="td4" width="55" align="left">Hora</td>	  	  	  	  
  </tr>
</table>
<?  

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

         $onclickcodsolicitacao2 = "window.open('admin/inc/impsolicitacao.php?codsolicitacao=".$codsolicitacao1[$prox]."','Consulta','width=605,height=550,scrollbars=YES, left=200, top=150')";

		 $opcaosol = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao2.chr(34)."><img src='img/visualizar.gif' width='15' height='15' border='0' alt='Visualizar a solicitação.'></a>";

         // Lista os dados da solicitação
		 
?>

<table border="1" width="600" cellpadding="0" cellspacing="2">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td bgcolor="#f5f5f5" width="15" align="center"><?=$opcaosol;?></td>
      <td bgcolor="#f5f5f5" width="40" align="center"><font color="#000000"> <?=$codsolicitacao1[$prox];?> </font>
	   </td>
      <td bgcolor="#f5f5f5" width="120" align="left"><?=$destiposervsol[$prox];?></td>	  
	  <td bgcolor="#f5f5f5" width="200" align="left"><?=$numcontacorrentev[$prox] . "-".$nomclientev[$prox];?></td>
      <td bgcolor="#f5f5f5" width="65" align="left"><?=FormataData($dtsolicitacao[$prox],'pt');?></td>	  	  	  
      <td bgcolor="#f5f5f5" width="55" align="left"><?=$hrsolicitacao[$prox];?></td>	  	  	  	  
  </tr>	  
</table>


<?
      }
   
      $prox = $prox + 1;
  }
  
    $proxgrava = $prox;
 	$objpaginacao->anterior = $prox - ($registros*2);
	$objpaginacao->prox = $proxgrava;
	$objpaginacao->de = 1;
	$objpaginacao->pgcao = $pgcao;
	$objpaginacao->rotina= "&registros=".$registros;
	
	if ($apartir == "")
	  $objpaginacao->apartir = 1;
	  
	$objpaginacao->coditem = $codsolicitacao1[$objpaginacao->apartir];
	$objpaginacao->coditem2 = $codsolicitacao1[$prox];
	$objpaginacao->link="consultasolcliente.php";
	$links = $objpaginacao->class_paginacao();

?>

<br><br>

<table border="1" width="600" cellpadding="0" cellspacing="3">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td align="center" bgcolor="#f5f5f5"><font color="#CC0000">  <? echo $links;?> </font> </td>
  </tr>

</table>
<?
  } //fim if LISTAR

  } //fim if conexão com o banco de dados
?>


