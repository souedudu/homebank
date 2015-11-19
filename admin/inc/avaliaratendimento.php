<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Formulário de Avaliação do Atendimento

Atualização em 03/11/2015
Programador: Gilberto Rogerio Landim
Alterações: Layout, Perguntas e Acesso Externo
************************************************************************************/
foreach ($_REQUEST as $key => $value) {
  $$key = $value;
}

include("../../library/config.php");
include("../../library/funcoes.php");
 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
$sql = "select * from avaliacaosol where codsolicitacao =".$_REQUEST['codsolicitacao'];
$query = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($query)>0) {
 die("<center><font color='red'>Já foi respondido a avaliação dessa OS!!!!<br>Obrigado pela contribuição</center></font>");
}

if (@$_REQUEST['bttipoacao'] == "Gravar")
{
    // Grava questionario
  $dt = date('Y-m-d'); 
  $sql = "insert into avaliacaosol (codsolicitacao, flaformarelac, flaqualatendimento, flatempoatendimento, flaavalatendimento, desavaliacao, dtavaliacao) values (".$codsolicitacao.",'".@$flaformarelac."','".$flaqualatendimento."','".$flatempatendimento."','".$flaavalatendimento."','".@$desavaliacao."','".$dt."')";
    mysql_query($sql) or die(mysql_error());

   // Grava na solicitação que o questionario foi respondido
  $sql = "update solicitacaoserv set flaquestaval = 's'". 
         " where codsolicitacao = ".$codsolicitacao;
    mysql_query($sql) or die(mysql_error());       
  $onclick = "<script>alert('Avaliação gravada com sucesso.');window.close();</script>";
  echo $onclick;
  die("<center><font color='red'>Obrigado pela contribuição!!!!<br></center></font>"); 

}



?><head>
<title>Avaliação de Atendimento - Sicoob</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../site.css" rel="stylesheet" type="text/css">
</head>

<script language=javascript>
function VerificaCamposObrigatorios()
{
 
	
   return true;
}
</script>

<style>
table {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: none;
}
.CorFonteZinza{
	color:#666666;
}
.CorFonteAzul{
	color:#003366;
}
.Formulario{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	border-width:thin;
}
</style>
<?
  $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

  $Sql = "Select s.*, t.destiposervsol, te.nomtecnicoresp
                From solicitacaoserv s, tiposervsolicitacao t, tecnicoresp te
                where
                     s.codtecnicoresp = te.codtecnicoresp and
                     s.codtiposervsol = t.codtiposervsol and
                     s.codsolicitacao = ".$_REQUEST['codsolicitacao'];
  
  $rsqry = mysql_query($Sql);
  $dados = mysql_fetch_array($rsqry);
  if ($dados==0)
    echo "<script>document.location.href='index.php';</script>"; 

 	 // Recupera o nome e o cpf do conta corrente do cliente
     $sqlString2 = "select c.nomcliente, c.numcpfcnpj from contacorrente cc, cliente c
	               where cc.numcontacorrente = '".$dados['numcontacorrente']."'"."
				    and cc.codcliente = c.codcliente";  
	 
     $rsqry1 = mysql_query($sqlString2);
     $dadosconta = mysql_fetch_array($rsqry1);


?>

<div id="div_geral" align="center">
<table width="600" border="0" cellspacing="0" class="form">
  <tr>
    <td>&nbsp;</td>
    <td align="center" ><img src="http://www.crediembrapa.com.br//homebank3/admin/img/cabecalho.jpg" alt="" width="600" height="120"/></td>
  </tr>
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td2">
          <p><b class="td1">
      QUESTIONÁRIO DE AVALIAÇÃO DE ATENDIMENTO</b></p></td>
  </tr>
</table>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="600" border="1" cellspacing="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="165" align="right" class="td4"><b>Nº da Solicitação</b></td>
	  <td width="510" class="td3">&nbsp;<? echo $_REQUEST['codsolicitacao'];?></td>
   </tr>	  	 
    
   <tr>	  
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Data da Abertura</b> </td>
      <td class="td3">&nbsp;<? echo FormataData($dados['dtsolicitacao'],'pt'); ?> </td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"> <b>Tipo de Serviço</b></td>
	  <td class="td3">&nbsp;<? echo $dados['destiposervsol'];?></td>
   </tr>
   
   <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Procedimento/Fase</b></td>
	  <td class="td3">&nbsp;<? echo $dados['nomtecnicoresp'];?></td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Detalhes da O.S.</b></td>
	  <td class="td3">&nbsp;<? echo $dados['dessolicitacao'];?></td>
      
  </tr>
</table>

<BR>

<?
  //Montagem do Formulário de Avaliação
?>
<table width="600" border="0" cellspacing="0" class="table">
  <!-- <tr>
      <td width="4">&nbsp;</td>
      <td class="td4">
          Indique a forma de relacionamento com a CrediEmbrapa para a obtenção do serviço indicado nesta OS.
          <table width="568" cellspacing="0" border="0" class="table" >
             <tr>
                 <td align="left"><input type="radio" name="flaformarelac" id="flaformarelac" value="Telefone">Telefone<td>
                 <td align="left"><input type="radio" name="flaformarelac" id="flaformarelac" value="Email">E-mail<td>
                 <td align="left"><input type="radio" name="flaformarelac" id="flaformarelac" value="Fax">Fax<td>
                 <td align="left"><input type="radio" name="flaformarelac" id="flaformarelac" value="Internet Banking">Internet HomeBanking<td>
                 <td align="left"><input type="radio" name="flaformarelac" id="flaformarelac" value="Pessoalmente">Pessoalmente<td>
             </tr>
          </table>
      </td>
  </tr> -->
  <tr>
      <td width="4">&nbsp;</td>
      <td width="600" class=""><b>Em relação a cortesia, conhecimento e presteza do atendente:</b>
          <BR>
          <input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="10">&Oacute;timo
          <BR>
          <input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="7,5">Bom
          <BR>
          <input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="5">Regular
          <BR>
          <input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="2,5">Deficiente
          <BR>
          <input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="0">P&eacute;ssimo
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="">
          <BR>
          <b>Em relação ao serviço solicitado:</b>
          <BR>
            <input type="radio" name="flatempatendimento" id="flatempatendimento" value="10">Plenamente Satisfeito 
            <BR>
            <input type="radio" name="flatempatendimento" id="flatempatendimento" value="7,5">Satisfeito
            <BR>
            <input type="radio" name="flatempatendimento" id="flatempatendimento" value="5">Parcialmente Satisfeito
            <BR>
            <input type="radio" name="flatempatendimento" id="flatempatendimento" value="2,5">Insatisfeito
            <BR>
            <input type="radio" name="flatempatendimento" id="flatempatendimento" value="0">Totalmente Insatisfeito
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="">
        <BR>
        <b>Qual sua avaliação geral a respeito do atendimento da CrediEmbrapa ?</b>
        <BR>
        <input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="10">Ótimo
        <BR>
        <input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="7,5">Bom
        <BR>
        <input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="5">Regular
        <BR>
        <input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="2,5">Deficiente
        <BR>
        <input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="0">
         P&eacute;ssimo
      </td>
  </tr>
  <!-- <tr>
      <td width="4">&nbsp;<br><br></td>
      <td><BR>
          <b>Escreva abaixo sua crítica, elogio ou sugestão, de forma suscinta (máximo 3 linhas)<b>
          <table width="568" cellspacing="0" border="0" class="table" >
             <tr>
                 <td><textarea name="desavaliacao" cols="75" rows="3" id="desavaliacao"></textarea>
                 <td>
             </tr>
          </table>
      </td>
  </tr> -->
  <tr>
      <td width="4">&nbsp;  </td>
  </tr>
  <tr>
      <td width="4">&nbsp;  </td>
      <td align="center">
          <input type="Submit" name="Submit" value="Gravar Avaliação">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" value="Cancelar" onclick="javascript: window.close();">
		  <input name="bttipoacao" type="hidden" value="Gravar">
	  </td>	  
		  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><img src="http://www.crediembrapa.com.br//homebank3/admin/img/rodape.jpg" width="600" height="80" alt=""/></td>
  </tr>
</table>
</div>

</form>
