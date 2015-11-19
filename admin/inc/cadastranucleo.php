<?
/********************************************************************************
Autor: Gelson
Data Criação:
Data Atualização: 29/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra de setor
************************************************************************************/

  include "funcoes_js.php";
  include "funcoes_js2.php";

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.codnucleo.value =='')
  {
    alert('Campo código obrigatório.');
    document.form.codnucleo.focus();
    return false;
  }
  if (document.form.desnucleo.value =='')
  {
    alert('Campo descrição obrigatório.');
    document.form.desnucleo.focus();
    return false;
  }

}
</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
  {
   $sqlString = "Select * from nucleo where codnucleo = ".$_REQUEST['codnucleo'];

    $rsqry = mysql_query($sqlString);
    $rsqry = mysql_num_rows($rsqry);
    
    if ($rsqry != 0)
     {
      $aux1 = 1;
      $desnucleo = $_REQUEST['desnucleo'];
      echo "<script>history.back('cadastranucleo.php?tipoacao=Incluir&desnucleo=".$desnucleo."');alert('Esse código já está Cadastrado');</script>";
     }
    else
      $sql = SQL("nucleo", "insert", "codnucleo,desnucleo");

  }

  if ($bttipoacao == "Editar")
	$sql = SQL("nucleo", "update", "desnucleo", "codnucleo");

  if ($bttipoacao == "Excluir")
	$sql = SQL("nucleo","delete","", "codnucleo");

  mysql_query($sql) or die(mysql_error());

?>
<br>
<table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td3"><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width="5"></td>
    <td align='center'></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td4"><br>Operação efetuada com sucesso.<p> </td>
  </tr>
</table>
<table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='cadastranucleo.php?bttipoacao=&$tipoacao='>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
</table>

<?
}

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "Listar" || $_REQUEST['tipoacao'] == "")
{
  $tipoacao = "Listar";

  $sqlString = "Select * From nucleo order by codnucleo asc";
  $rsqry = mysql_query($sqlString);
  $rsnucleo = mysql_fetch_array($rsqry);

?>
<br />
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td align="center" class="td1"><strong>Núcleo</td>
  </tr>
  <tr>
      <td width="5"></td>
      <td align="left"><BR>&nbsp;&nbsp;<a href="cadastranucleo.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro
      </td>
  </tr>
</table>
<BR>
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td width="15" class="td4"><strong>&nbsp;Código</strong><br></td>
    <td class="td4"><strong>&nbsp;Descrição</strong><br></td>
	<td width="70" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
</table>
<table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  while ($rsnucleo!=0)
  {
?>

    <tr>
      <td width="5"></td>
      <td width="15" class="td3">&nbsp;<?=$rsnucleo['codnucleo'];?>&nbsp;-</td>
      <td width="450" class="td3">&nbsp;<?=$rsnucleo['desnucleo'];?></td>
  	  <td width="30" align="center" class="td3">
	      <a href="cadastranucleo.php?tipoacao=Editar&codnucleo=<?=$rsnucleo['codnucleo'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
		  </a>
	  <td width="30" align="center" class="td3">
          <a href="cadastranucleo.php?tipoacao=Excluir&codnucleo=<?=$rsnucleo['codnucleo'];?>&bttipoacao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro.">
		  </a>
	   </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
<?
    $rsnucleo = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codnucleo != "")
  {
     $sqlString = "Select * From nucleo where codnucleo = ".$codnucleo;
     $rsqry = mysql_query($sqlString);
     $rsnucleo = mysql_fetch_array($rsqry);
     $desnucleo = $rsnucleo['desnucleo'];
  }

?>
<br>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="center" class="td1"><strong><b><?=$tipoacao;?> Núcleo </b></strong></td>
  </tr>
</table>
<BR>
<table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  if ($codnucleo != "")
  {
?>
  <tr>
     <td width="5"></td>
     <td align="right" width="60" class="td4">Código</td>
	 <td class="td3">&nbsp;<?=$codnucleo;?><br></td>
  </tr>
<?
  }
   else
   {
?>
  <tr>
     <td width="5"></td>
     <td align="right" width="60" class="td4">Código</td>
	 <td class="td3">&nbsp;<input type="text" name="codnucleo" id="codnucleo" maxlength="4" size="5" onblur="numeros(this.id,true)" onKeyUp="numeros(this.id,true)"></td>
  </tr>
<?
   }
?>
  <tr>
      <td width="5"></td>
      <td align="right" width="60" class="td4">Descrição</td>
	  <td class="td3">&nbsp;<input name="desnucleo" value="<?=$desnucleo;?>" type="text" id="desnucleo" size="60" maxlength="100" /></td>
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
