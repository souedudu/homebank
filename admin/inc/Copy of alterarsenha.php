<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 06/12/2005
Data Atualização: 06/12/2005 - Vitor Hugo
Sistema: Home Bank
Descrição: Alterar Senha de Usuário
************************************************************************************/
if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
{
$codusuario = $_SESSION['codusuarioadm'];

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.desusuario.value =='')
  {
    alert('Campo Nome obrigatório.');
    document.form.desusuario.focus();
    return false;
  }
  if (document.form.dessenha.value =='')
  {
    alert('Campo Senha obrigatório.');
    document.form.dessenha.focus();
    return false;
  }
  if (document.form.desfuncao.value =='')
  {
    alert('Campo Função obrigatório.');
    document.form.desfuncao.focus();
    return false;
  }


}
</script>

<?
// Grava dados do formulario

if ($bttipoacao != "")
{

  if ($bttipoacao == "Editar")
  {

    $sql = "update usuario set dessenha = '".$dessenha."' where codusuario = ".$codusuario;
  //$sql = SQL("usuario", "update", "codtecnicoresp,desusuario,desfuncao,dessenha,flaencerraros,flaconcluiros,flapercadusu","codusuario");
	mysql_query($sql) or die(mysql_error());
  }

?>
<br>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td3"><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width="5"></td>
    <td align='center' ></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td4"><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='index.php'>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>

<?
}

}

// Formulário para inclusão ou alteração dos dados
if ($bttipoacao == "" && $_REQUEST['tipoacao'] == "")
{

  if ($codusuario != "")
  {
    $sqlString = "Select * From usuario where codusuario = ".$codusuario;
    $rsqry = mysql_query($sqlString);
    $rsusuario = mysql_fetch_array($rsqry);
  }
 ?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<BR>
 <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b>Alterar Senha</b></strong></td>
  </tr>
</table>
<BR>
<table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td align="right" width="80" class="td3">Nome</td>
      <td class="td4">&nbsp;<input name="desusuario" value="<?=$rsusuario['desusuario'];?>" type="text" id="desusuario" size="20" maxlength="15" disabled /></td>
  </tr>
  <tr>
      <td width="5"></td>
      <td align="right" width="80" class="td3">Senha</td>
      <td class="td4">&nbsp;<input name="dessenha" value="<?=$rsusuario['dessenha'];?>" type="password" id="dessenha" size="10" maxlength="8" /></td>
  </tr>
</table>
<table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
      <td width="200">&nbsp;</td>
<?
  $tipoacao = "Editar";
?>

      <td  width="80"><input type="submit" name="Submit" value="Gravar">
                     <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
      </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>
  </tr>
</table>
<?

}

?>
