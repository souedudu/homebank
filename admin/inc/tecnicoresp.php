<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 29/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra Mensagem de atendimento
************************************************************************************/

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.tecnicosetor.value =='')
  {
    alert('Campo descrição obrigatório.');
    document.form.tecnicosetor.focus();
    return false;
  }

}
</script>

<?
// Grava dados do formulario
if ($_REQUEST['bttipocao'] != "")
{

  if ($bttipocao == "Incluir")
	 $sql = SQL("tecnicoresp", "insert", "nomtecnicoresp");

  elseif ($bttipocao == "Editar")
	$sql = SQL("tecnicoresp", "update", "nomtecnicoresp", "codtecnicoresp");

  elseif ($bttipocao == "Excluir")
	$sql = SQL("tecnicoresp", "delete", " ", "codtecnicoresp");
  mysql_query($sql) or die(mysql_error());

?>
<script>
	document.location.href='tecnicoresp.php?bttipocao=&$tipoacao=';
</script>
 <!--<br><br>
 <table width='580' border='1' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'>Mensagem</td>
  </tr>
  <tr>
    <td align='center'><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='tecnicoresp.php?bttipocao=&$tipoacao='>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>-->
   
<?
}

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "")
{
  $tipoacao = "Listar";
  
  $sqlString = "Select * From tecnicoresp order by nomtecnicoresp";
				 
  $rsqrytecnicoresp = mysql_query($sqlString);
  $rstecnicoresp = mysql_fetch_array($rsqrytecnicoresp);  	
  
?>  
<br />
 <table width="580" border="0" cellspacing="2" cellpadding="1">
  <tr>
      <td width="5"></td>
      <td align="center" class="td1">Procedimento/Fase </td>
  </tr> 
  <tr>
      <td width="5"></td>
      <td align="left"><BR><a href="tecnicoresp.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo Tipo de  Serviço </td>
  </tr> 
</table>
<BR>
<table width="580" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td  class="td4"><strong>Procedimento</strong><br></td>
	  <td width="5" align="center" colspan="1" class="td4" ><strong>Opções</strong><br></td>
  </tr>   

<?
  while (!($rstecnicoresp==0))
  {
?> 

    <tr>
      <td ></td>
      <td class="td3">&nbsp;<?=$rstecnicoresp['nomtecnicoresp'];?></td>
  	  <td align="right" class="td3">
	      <a href="tecnicoresp.php?tipoacao=Editar&codtecnicoresp=<?=$rstecnicoresp['codtecnicoresp'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
          </a>
    
          <a href="tecnicoresp.php?tipoacao=Excluir&codtecnicoresp=<?=$rstecnicoresp['codtecnicoresp'];?>&bttipocao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro.">
          </a>
      </td>
     </tr>
     <tr cellspacing="0">
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
     </tr>
	   
<?    
    $rstecnicoresp = mysql_fetch_array($rsqrytecnicoresp);
  }
?>  
 </table>
<?
}  
// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $_REQUEST['bttipocao'] == "")
{
  if ($codtecnicoresp != "")
  {
     $sqlString = "Select * From tecnicoresp where codtecnicoresp = ".$codtecnicoresp;
     $rsqrytecnicoresp = mysql_query($sqlString);
     $rstecnicoresp = mysql_fetch_array($rsqrytecnicoresp);  	
  }

?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="center" class="td1"><?=$tipoacao;?> Procedimento/Fase </td>
  </tr> 
</table>
<BR>
<table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  if ($codtecnicoresp != "")
  {
?>

  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Código</td>
      <td class="td3">&nbsp;<?=$codtecnicoresp;?><br></td>
  </tr>
<?
  }
?>
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Procedimento</td>
	  <td class="td3"><input name="nomtecnicoresp" value="<?=$rstecnicoresp['nomtecnicoresp'];?>" type="text" id="tiposervico" size="55" /></td>
  </tr> 
  
</table>
<table width="580" border="0" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>	
    <tr>
      <td width="200">&nbsp;</td>
      <td  width="80"><input type="submit" name="Submit" value="Gravar">
                     <input name="bttipocao" type="hidden" value="<?=$_REQUEST['tipoacao']?>">
	  </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>
    </tr>
</table>
</form>
<?
}
?>
