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
  if (document.form.destipoemprest.value =='')
  {
    alert('Campo descrição obrigatório.');
    document.form.destipoemprest.focus();
    return false;
  }

}
</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
	$sql = SQL("tipoemprestimo", "insert", "codtipoemprest,destipoemprest,qtdeparcemprest,qtdediascarencia");

  if ($bttipoacao == "Editar")
	$sql = SQL("tipoemprestimo", "update", "destipoemprest,qtdeparcemprest,qtdediascarencia", "codtipoemprest");

  if ($bttipoacao == "Excluir")
	$sql = SQL("tipoemprestimo","delete","", "codtipoemprest");

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
    <td align='center'><a href='tipoemprestimo.php?bttipoacao=&$tipoacao='>
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
  
  $sqlString = "Select * From tipoemprestimo";
  $rsqry = mysql_query($sqlString);
  $rstipoemprestimo = mysql_fetch_array($rsqry);  	
  
?>  
<br /><br />
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><b>Tipo de Empr&eacute;stimo </b></strong></td>
  </tr> 

  <tr>
    <td align="left">&nbsp;&nbsp;<a href="tipoemprestimo.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir nova solicitação." /></a> Incluir nova solicitação	
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
  while (!($rstipoemprestimo==0))
  {
?> 

    <tr>
      <td width="450">&nbsp;<?=$rstipoemprestimo['destipoemprest'];?></td>
  	  <td width="30" align="center">
	  
	      <a href="tipoemprestimo.php?tipoacao=Editar&codtipoemprest=<?=$rstipoemprestimo['codtipoemprest'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar a solicitação.">
		  </a>
		  <td width="30" align="center">
          <a href="tipoemprestimo.php?tipoacao=Excluir&codtipoemprest=<?=$rstipoemprestimo['codtipoemprest'];?>&bttipoacao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir a solicitação.">
		  </a>	  
	   </td>	
    </tr> 
<?    
    $rstipoemprestimo = mysql_fetch_array($rsqry);
  }
?>  
 </table>
<?
}  

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codtipoemprest != "")
  {
     $sqlString = "Select * From tipoemprestimo where codtipoemprest = ".$codtipoemprest;
     $rsqry = mysql_query($sqlString);
     $rstipoemprestimo = mysql_fetch_array($rsqry);  	
  }

?>

<br>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><b><?=$tipoacao;?> Tipo de Empréstimo </b></strong></td>
  </tr> 
 </table> 
 
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" width="150">Código</td>
	 <td>&nbsp;<?=$codtipoemprest;?><br></td>
  </tr> 
  <tr>
    <td align="right" width="150">Descrição do Empréstimo</td>
	 <td>&nbsp;<input name="destipoemprest" value="<?=$rstipoemprestimo['destipoemprest'];?>" type="text" id="destipoemprest" size="50" maxlength="100" /></td>
  </tr> 
    <tr>
    <td align="right" width="150">Quantidade de Parcelas</td>
	 <td>&nbsp;<input name="qtdeparcemprest" value="<?=$rstipoemprestimo['qtdeparcemprest'];?>" type="text" id="qtdeparcemprest" size="3" maxlength="3" /></td>
  </tr> 
    <tr>
    <td align="right" width="150">Descrição do Empréstimo</td>
	 <td>&nbsp;<input name="qtdediascarencia" value="<?=$rstipoemprestimo['qtdediascarencia'];?>" type="text" id="qtdediascarencia" size="3" maxlength="3" /></td>
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
