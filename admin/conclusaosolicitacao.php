<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Formulário de Avalição do Atendimento
************************************************************************************/

include("../library/config.php");
include("../library/funcoes.php");


//Montagem do Cabeçalho do Formulário de Avaliação

 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
 
//Montagem do Cabeçalho do Formulário de Avaliação

if ($bttipoacao == "Gravar")
{
    // Grava questionario
	$codtecnicoconcsol = $_SESSION['codtecnicorespadm'];
	$data = date("Y/m/d");
	$hora = date("H:i:s");
   	
   // Grava na solicitação que o questionario foi respondido
	$sql = "update solicitacaoserv set dtconclusao = '".$data."', hrconclusaosol='".$hora."', codtecnicoconcsol = ".$codtecnicoconcsol.", codregencatendimento = '".$codregencatendimento."'".
	       " where codsolicitacao = ".$codsolicitacao;	   
    mysql_query($sql) or die(mysql_error());	
			
	$onclick = "<script>alert('Solicitação concluida com sucesso.');window.opener.location.reload();window.close();</script>";
	echo $onclick;	

}
?>

<head>
<title>:. HOMEBANKING .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="site.css" rel="stylesheet" type="text/css">
</head>

<script>
function VerificaCamposObrigatorios()
{
  if (document.form.codregencatendimento.value =='')
  {
    alert('Preencha o campo de Registro de Encerramento do Atendimento.');
    document.form.codregencatendimento.focus();
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


  $query = "Select s.*, t.destiposervsol, te.nomtecnicoresp
                From solicitacaoserv s, tiposervsolicitacao t, tecnicoresp te
                where
                     s.codtecnicoresp = te.codtecnicoresp and
                     s.codtiposervsol = t.codtiposervsol and
                     s.codsolicitacao = ".$codsolicitacao;
  $rsqry = mysql_query($query);
  $dados = mysql_fetch_array($rsqry);

?>
<table width="568" border="1" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;

      </td>
      <td align="center" class="td2"><b>Conclusão de Solicitação</b>
      </td>
  </tr>
</table>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="568" border="1" cellspacing="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="155" align="right" class="td4"><b>Nº da Solicitação</b></td>
	  <td width="393" class="td3">&nbsp;<? echo $codsolicitacao;?></td>
   </tr>	  	 
    
   <tr>	  
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Data da Abertura</b> </td>
      <td class="td3">&nbsp;<? echo FormataData($dados['dtsolicitacao'],'pt'); ?> </td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"> <b>Tipo Serviço</b></td>
	  <td class="td3">&nbsp;<? echo $dados['destiposervsol'];?></td>
   </tr>
   
   <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Técnico Responsável</b></td>
	  <td class="td3">&nbsp;<? echo $dados['nomtecnicoresp'];?></td>
  </tr>
  
  <tr>
      <td >&nbsp;</td>
      <td align="right" class="td4"><b>Detalhes da Solicitação</b></td>
	  <td class="td3">&nbsp;<? echo $dados['dessolicitacao'];?></td>
      
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
           $rsresult5 = mysql_fetch_array($sql5	);
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
        </table>
<?
        $rsresult3 = mysql_fetch_array($query4);
      }
   }

   
?>
<BR />

<?
  $data = date("d/m/Y, H:i");
?>

<table width="568" border="1" cellspacing="0" cellpadding="0">
 <tr>
      <td width="5">&nbsp;  </td>
      <td width="50" align="right" class="td4">Data:</td>
      <td width="400" align="left" class="td3"><? echo $data."hs"; ?></td>
 </tr>
 <tr>
      <td width="5">&nbsp;</td>
      <td width="50" align="right" class="td4"></td>
      <td width="400" align="left" class="td3"><? echo "<b>Registro de encerramento do atendimento</b>"; ?></td>
 </tr>
</table>
<table width="568" border="1" cellspacing="0" cellpadding="0">
 <tr>
     <td width="5">&nbsp;  </td>
     <td width="50" align="right" class="td4"></td>
     <td width="400" align="left" class="td3"><input type="text" name="codregencatendimento" id="codregencatendimento" size="50"/></td>
 </tr>
</table>
<table width="568" border="1" cellspacing="0" cellpadding="0">
 <tr>
      <td width="5">&nbsp;</td>
      <td align="center">
            <br /><input type="submit" size="1" value="Concluir Solicitação"/>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" value="Cancelar" onclick="javascript: window.close();"></td>
		  <input name="bttipoacao" type="hidden" value="Gravar">			
      </td>    
 </tr>
</table>
