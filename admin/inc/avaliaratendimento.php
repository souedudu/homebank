<?
/********************************************************************************
Autor: Vitor Hugo
Data Cria��o: 09/12/2005
Data Atualiza��o:
Sistema: Home Bank
Descri��o: Formul�rio de Avali��o do Atendimento
************************************************************************************/


include("../../library/config.php");
include("../../library/funcoes.php");

 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

if ($bttipoacao == "Gravar")
{
    // Grava questionario
	$dt = date('Y-m-d'); 
	$sql = "insert into avaliacaosol (codsolicitacao, flaformarelac, flaqualatendimento, flatempoatendimento, flaavalatendimento, desavaliacao, dtavaliacao) values (".$codsolicitacao.",'".$flaformarelac."','".$flaqualatendimento."','".$flatempatendimento."','".$flaavalatendimento."','".$desavaliacao."','".$dt."')";
    mysql_query($sql) or die(mysql_error());

   // Grava na solicita��o que o questionario foi respondido
	$sql = "update solicitacaoserv set flaquestaval = 's'". 
	       " where codsolicitacao = ".$codsolicitacao;
    mysql_query($sql) or die(mysql_error());		   
		   	
	$onclick = "<script>alert('Avalia��o gravada com sucesso.');window.opener.location.reload();window.close();</script>";
	echo $onclick;	

}



?><head>
<title>:. HOMEBANKING .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../site.css" rel="stylesheet" type="text/css">
</head>

<script language=javascript>
function VerificaCamposObrigatorios()
{
    if (document.form.flaformarelac[0].checked == false && document.form.flaformarelac[1].checked == false &&
        document.form.flaformarelac[2].checked == false && document.form.flaformarelac[3].checked == false && document.form.flaformarelac[4].checked == false)
    {
       alert('"Escolha uma das op��es da Forma de Relacionamento." ');
       return false;
    }  
	
   if (document.form.flaqualatendimento[0].checked == false && document.form.flaqualatendimento[1].checked == false &&
     document.form.flaqualatendimento[2].checked == false) && document.form.flaformarelac[3].checked == false && document.form.flaformarelac[4].checked == false)
   {
      alert('"Informe a qualidade do atendimento." ');
       return false;
   }  

   if (document.form.flatempatendimento[0].checked == false && document.form.flatempatendimento[1].checked == false &&
     document.form.flatempatendimento[2].checked == false) && document.form.flaformarelac[3].checked == false && document.form.flaformarelac[4].checked == false)
   {
      alert('"Informe o Qualidade do tempo de atendimento." ');
       return false;
   } 
   
   if (document.form.flaavalatendimento[0].checked == false && document.form.flaavalatendimento[1].checked == false &&
     document.form.flaavalatendimento[2].checked == false) && document.form.flaformarelac[3].checked == false && document.form.flaformarelac[4].checked == false)
   {
      alert('"Informe a qualidade do Atendimento da CrediEmbrapa." ');
       return false;
   }     

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
                     s.codsolicitacao = ".$codsolicitacao;
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

<table width="580" border="0" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td2">
          <b>QUESTION�RIO DE AVALIA��O DE ATENDIMENTO</b>
      </td>
  </tr>
</table>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="580" border="1" cellspacing="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="155" align="right" class="td4"><b>N� da Solicita��o</b></td>
	  <td width="393" class="td3">&nbsp;<? echo $codsolicitacao;?></td>
   </tr>	  	 
    
   <tr>	  
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Data da Abertura</b> </td>
      <td class="td3">&nbsp;<? echo FormataData($dados['dtsolicitacao'],'pt'); ?> </td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"> <b>Tipo de Servi�o</b></td>
	  <td class="td3">&nbsp;<? echo $dados['destiposervsol'];?></td>
   </tr>
   
   <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>T�cnico Respons�vel</b></td>
	  <td class="td3">&nbsp;<? echo $dados['nomtecnicoresp'];?></td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Detalhes da Solicita��o</b></td>
	  <td class="td3">&nbsp;<? echo $dados['dessolicitacao'];?></td>
      
  </tr>
</table>

<BR>

<?
  //Montagem do Formul�rio de Avalia��o
?>
<table width="580" border="0" cellspacing="0" class="table">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="" class="td3">
          <font color="red"><b>Com o objetivo de prestar um servi�o cada vez melhor, favor responder �s seguintes quest�es</b></font>
      </td>
  </tr>
</table>

<table width="597" border="0" cellspacing="0" class="table">
  <tr>
      <td width="4">&nbsp;</td>
      <td width="685"></td>
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="td4">
          Indique a forma de relacionamento com a CrediEmbrapa para a obten��o do servi�o indicado nesta OS.
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
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="td4"><BR>
          Como voc� avalia a qualidade do atendimento obtido atrav�s do �tem anterior ?
          <table width="568" cellspacing="0" border="0" class="table" >
             <tr>
               <td width="101" align="left"><input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="10">
               &Oacute;timo<td width="14">
                 <td width="89"><input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="7,5">
                 Bom</td>
                 <td width="15"></td>
               <td width="108" align="left"><input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="5">Regular<td width="12">
                 <td width="102"><input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="2,5">
                 Deficiente</td>
                 <td width="12"></td>
               <td width="81" align="left"><input type="radio" name="flaqualatendimento" id="flaqualatendimento" value="0">
               P&eacute;ssimo<td width="14">
             </tr>
          </table>
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="td4"><BR>
          Como voc� avalia o tempo gasto no atendimento � sua solicita��o ?
          <table width="569" cellspacing="0" border="0" class="table" >
             <tr>
               <td width="100" align="left"><input type="radio" name="flatempatendimento" id="flatempatendimento" value="10">
               &Oacute;timo 
               <td width="15">
               <td width="89"><input type="radio" name="flatempatendimento" id="flatempatendimento" value="7,5"> 
                 Bom
</td>
               <td width="15"></td>
               <td width="107" align="left"><input type="radio" name="flatempatendimento" id="flatempatendimento" value="5">
                 Regular
               <td width="14">               
               <td width="101"><input type="radio" name="flatempatendimento" id="flatempatendimento" value="2,5">
Deficiente
                 <td width="12"></td>
               <td width="81" align="left"><input type="radio" name="flatempatendimento" id="flatempatendimento" value="0">
                 P&eacute;ssimo
               <td width="15">             </tr>
          </table>
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;</td>
      <td class="td4"><BR>
          Qual sua avalia��o geral a respeito do atendimento da CrediEmbrapa ?
          <table width="570" cellspacing="0" border="0" class="table" >
             <tr>
               <td width="99" align="left"><input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="10">�timo<td width="16">
               <td width="89" ><input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="7,5">
               Bom</td>
               <td width="15" ></td>
               <td width="107" align="left" ><input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="5">Regular<td width="15">
               <td width="100" ><input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="2,5">
               Deficiente</td>
               <td width="12" ></td>
               <td width="82" align="left"><input type="radio" name="flaavalatendimento" id="flaavalatendimento" value="0">
               P&eacute;ssimo<td width="15">
             </tr>
          </table>
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;<br><br></td>
      <td><BR>
          <b>Escreva abaixo sua cr�tica, elogio ou sugest�o, de forma suscinta (m�ximo 3 linhas)<b>
          <table width="568" cellspacing="0" border="0" class="table" >
             <tr>
                 <td><textarea name="desavaliacao" cols="75" rows="3" id="desavaliacao"></textarea>
                 <td>
             </tr>
          </table>
      </td>
  </tr>
  <tr>
      <td width="4">&nbsp;  </td>
  </tr>
  <tr>
      <td width="4">&nbsp;  </td>
      <td align="center">
          <input type="Submit" name="Submit" value="Gravar Avalia��o">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" value="Cancelar" onclick="javascript: window.close();">
		  <input name="bttipoacao" type="hidden" value="Gravar">
	  </td>	  
		  
  </tr>
</table>

</form>
