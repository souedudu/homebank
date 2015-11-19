<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 09/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Formulário de Avalição do Atendimento
************************************************************************************/

include("../../library/config.php");
include("../../library/funcoes.php");

 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
 
//Montagem do Cabeçalho do Formulário de Avaliação

if ($bttipoacao == "Gravar")
{
    // Grava questionario
	$codtecnicoresp = $_SESSION['codtecnicorespadm'];
	$datregandamento = date("Y/m/d");
	$hrregandamento = date("H:i:s");
	$sql = "insert into andamensolicitacao (codsolicitacao, codmenatendimento, codtecnicoresp, descompmensagem, datregandamento, hrregandamento) values (".$codsolicitacao.",'".$codmenatendimento."','".$codtecnicoresp."','".$descompmensagem."','".$datregandamento."','".$hrregandamento."'".")";
    mysql_query($sql) or die(mysql_error());
	   	
	$onclick = "<script>alert('Andamento gravado com sucesso.');window.opener.location.reload();window.close();</script>";
	echo $onclick;	

}
?>

<head>
<title>:. HOMEBANKING .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../site.css" rel="stylesheet" type="text/css">
</head>

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

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.codmenatendimento.value =='')
  {
    alert('Informe a mensagem de atendimento.');
    document.form.codmenatendimento.focus();
    return false;
  }
}
</script>
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
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="568" border="1" cellspacing="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td width="155" align="right" class="td4"><b>Nº da Solicitação</b></td>
	  <td width="393" class="td3">&nbsp;<? echo $codsolicitacao;?></td>
   </tr>	  	 
    
   <tr>
      <td  width="5">&nbsp;</td>
      <td align="right" class="td4"><b>Data da Abertura</b> </td>
      <td class="td3">&nbsp;<? echo FormataData($dados['dtsolicitacao'],'pt'); ?> </td>
  </tr>
  
  <tr>
      <td  width="5">&nbsp;</td>
      <td align="right" class="td4"> <b>Tipo Serviço</b></td>
	  <td class="td3">&nbsp;<? echo $dados['destiposervsol'];?></td>
   </tr>
   
   <tr>
      <td  width="5">&nbsp;</td>
      <td align="right" class="td4"><b>Técnico Responsável</b></td>
	  <td class="td3">&nbsp;<? echo $dados['nomtecnicoresp'];?></td>
  </tr>
  
  <tr>
      <td width="5">&nbsp;</td>
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
           $query5 = mysql_query("select desmenatendimento from mensatendimento where codmenatendimento = ".$rsresult3['codmenatendimento']);
           $rsresult5 = mysql_fetch_array($query5);
           $desmesnagem = $rsresult5['desmenatendimento'];
         }
?>
        <table width='568' border='1' cellspacing='0' class=form>
           <tr>
             <td width='5'>&nbsp;</td>
             <td width="155" align="right" class="td4"><b>Data/Hora</b></td>
	         <td class="td3">&nbsp;<?=FormataData($rsresult3['datregandamento'],'pt'). " - ".$rsresult3['hrregandamento'];?>
                ( <?=$rsresult3['nomtecnicoresp'];?> )</td>
           </tr>
           <tr>
             <td width="5">&nbsp;</td>
             <td align="right" class="td4"><b>Descrição</b></td>
	         <td class="td3">&nbsp;<?=$desmesnagem;?></td>
           </tr>
           <tr>
               <td width="5">&nbsp;</td>
               <td align="right" class="td4"><b>Complemento:</b></td>
               <td class="td3">&nbsp;<?=$rsresult3['descompmensagem'];?></td>
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

   
?>
<BR>
<table width="568" border="1" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td align="center" class="td4">
          <font color=""><b>Adicionar Andamento</b></font>
      </td>
  </tr>
</table>
<BR>
<table width="568" border="1" cellspacing="0">
  <tr>
      <td width="5">&nbsp;</td>
      <td class="td4"><b>Mensagem de atendimento</b></td>
 </tr>
 <tr>
 	 <td width="5">&nbsp;</td>
	 <td><select name="codmenatendimento" id="codmenatendimento">
	           <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados do setor
                $sqls = "select * from mensatendimento order by desmenatendimento";
                $qrys = mysql_query($sqls) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($qrys))
			    { ?>
       	  	       <option value="<?=$b['codmenatendimento']?>" >
				      <?=$b['desmenatendimento']?>
				   </option>
        	  <? } ?>
             </select>      	  
	 </td>	  
  </tr>
</table>
<table width="568" border="1" cellspacing="0" class="form">
  <tr>
      <td width="5">&nbsp;</td>
      <td class="td4">
        <b>Complemento da mensagem</b>
      </td>
 </tr>
 <tr>
      <td width="5">&nbsp;</td>
      <td>
        <input type="text" size="70" maxlength="200" name="descompmensagem"><br>
      </td>    
 </tr>
 <tr>
      <td width="5">&nbsp;  </td>
      <td align="center">
          <BR /><input type="submit" size="1" value="Gravar"/>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" value="Cancelar" onclick="javascript: window.close();"></td>
		  <input name="bttipoacao" type="hidden" value="Gravar">
      </td>    
 </tr>
</table>
