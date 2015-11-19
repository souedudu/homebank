<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 29/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra de setor
************************************************************************************/

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.destiposol.value =='')
  {
    alert('Campo descrição obrigatório.');
    document.form.destiposol.focus();
    return false;
  }

}
</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
	$sql = SQL("tiposolicitacao", "insert", "codtiposol,destiposol");

  if ($bttipoacao == "Editar")
	$sql = SQL("tiposolicitacao", "update", "destiposol", "codtiposol");

  if ($bttipoacao == "Excluir")
	$sql = SQL("tiposolicitacao","delete","", "codtiposol");

  mysql_query($sql) or die(mysql_error());

?>
 <br><br>
 <table width='580' border='1' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td align='center'><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='tiposolicitacao.php?bttipoacao=&$tipoacao='>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>
   
<?
}

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "")
{
  $tipoacao = "Listar";
  
  $sqlString = "Select * From tiposolicitacao";
  $rsqry = mysql_query($sqlString);
  $rstiposolicitacao = mysql_fetch_array($rsqry);  	
  
?>  
<br /><br />
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong>Tipo de Solicitação</td>
  </tr> 

  <tr>
    <td align="left">&nbsp;&nbsp;<a href="tiposolicitacao.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro
     </td>
  </tr> 
 </table> 
 
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td ><strong>&nbsp;Descrição</strong><br></td>
	<td width="70" align="center"><strong>Opções</strong><br></td>	
  </tr>   
  </table>
  
  <table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  while (!($rstiposolicitacao==0))
  {
?> 

    <tr>
      <td width="450">&nbsp;<?=$rstiposolicitacao['destiposol'];?></td>
  	  <td width="30" align="center">
	  
	      <a href="tiposolicitacao.php?tipoacao=Editar&codtiposol=<?=$rstiposolicitacao['codtiposol'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar a solicitação.">
		  </a>
		  <td width="30" align="center">
          <a href="tiposolicitacao.php?tipoacao=Excluir&codtiposol=<?=$rstiposolicitacao['codtiposol'];?>&bttipoacao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir a solicitação.">
		  </a>	  
	   </td>	
    </tr> 
<?    
    $rstiposolicitacao = mysql_fetch_array($rsqry);
  }
?>  
 </table>
<?
}  

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codtiposol != "")
  {
     $sqlString = "Select * From tiposolicitacao where codtiposol = ".$codtiposol;
     $rsqry = mysql_query($sqlString);
     $rstiposolicitacao = mysql_fetch_array($rsqry);  	
  }

?>

<br>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><b><?=$tipoacao;?> Tipo de Solicitação </b></strong></td>
  </tr> 
 </table> 
 
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" width="60">Código</td>
	 <td>&nbsp;<?=$codtiposol;?><br></td>
  </tr> 
  <tr>
    <td align="right" width="60">Descrição</td>
	 <td>&nbsp;<input name="destiposol" value="<?=$rstiposolicitacao['destiposol'];?>" type="text" id="destiposol" size="60" maxlength="100" /></td>
  </tr> 
  
 </table>    
 
 <table width="580" border="0" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>	

    <tr>
      <td width="200">&nbsp;</td>
      <td  width="80"><input type="submit" name="Submit" value="Gravar">
                     <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
	  </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>

    </tr>

 </table> 
</form>
<?
}
?>
