<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 02/01/2006
Data Atualização:
Sistema: Home Bank
Descrição: Cadastra de Notícias
************************************************************************************/

include "funcoes_js.php";

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.desnoticia.value =='')
  {
    alert('Campo Descrição da Notícia obrigatório.');
    document.form.desnoticia.focus();
    return false;
  }
  if (document.form.datcadastro.value =='')
  {
    alert('Campo Data da Notícia obrigatório.');
    document.form.datcadastro.focus();
    return false;
  }
}

function contador(campotexto, campolimitador, limitador) {
         if (campotexto.value.length > limitador) // Se for maior que o campo
            campotexto.value = campotexto.value.substring(0, limitador);
         else
             campolimitador.value = limitador - campotexto.value.length;
}

</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
  {
    $datcadastro = $_REQUEST['datcadastro'];
    $datcadastro = FormataData($datcadastro,"en");
    $desnoticia = $_REQUEST['desnoticia'];
    $flaativo = $_REQUEST['flaativo'];
    $desurl = $_REQUEST['desurl'];

    $sql2 = "insert into noticia (desnoticia, datcadastro, flaativo, desurl)".
            " values ".
            "('".$desnoticia."','".$datcadastro."','".$flaativo."','".$desurl."')";

    $result = mysql_query($sql2) or die(mysql_error());
  }
  if ($bttipoacao == "Editar")
  {
    $datcadastro = $_REQUEST['datcadastro'];
    $datcadastro = FormataData($datcadastro,'en');
  	$sql = "update noticia set desnoticia = '".$_REQUEST['desnoticia']."',
  	                           datcadastro = '".$datcadastro."',
  	                           desurl = '".$_REQUEST['desurl']."',
  	                           flaativo = '".$_REQUEST['flaativo']." '
  	                           where codnoticia = ".$_REQUEST['codnoticia'];

    $result = mysql_query($sql) or die ("Erro na Inserção!");
    
  }
  if ($bttipoacao == "Excluir")
  {
	$sql = SQL("noticia","delete","", "codnoticia");
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
    <td width="5">&nbsp;</td>
    <td align='center'><a href='cadastranoticias.php?bttipoacao=&$tipoacao='>
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

  $sqlString = "Select * From noticia order by datcadastro desc";
  $rsqry = mysql_query($sqlString);
  $rsnoticia = mysql_fetch_array($rsqry);

?>
<br />
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2">Notícias</td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">&nbsp;<br><a href="cadastranoticias.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro <BR><BR>
     </td>
  </tr>
</table>
<table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td4"><strong>&nbsp;Descrição da Notícia</strong><br></td>
	<td width="70" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
  <tr cellspacing="0">
    <td></td>
	<td></td>
  </tr>
</table>

  <table width="580" class="table" cellspacing="0" cellpadding="0">
<?
  while (!($rsnoticia==0))
  {
?>

    <tr>
      <td width="5">&nbsp;</td>
      <td width="450" class="td3">&nbsp;<?=$rsnoticia['desnoticia'];?></td>
  	  <td width="30" align="center" class="td3">
         <a href="cadastranoticias.php?tipoacao=Editar&codnoticia=<?=$rsnoticia['codnoticia'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
         </a>
      <td width="30" align="center" class="td3">
         <a href="cadastranoticias.php?tipoacao=Excluir&codnoticia=<?=$rsnoticia['codnoticia'];?>&bttipoacao=Excluir">
	         <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro.">
	     </a>
      </td>
    </tr>
    <tr cellspacing="0">
        <td width="5"></td>
        <td></td>
	    <td></td>
	    <td></td>
    </tr>
<?
    $rsnoticia = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codnoticia != "")
  {
     $sqlString = "Select * From noticia where codnoticia = ".$codnoticia;
     $rsqry = mysql_query($sqlString);
     $rsnoticia = mysql_fetch_array($rsqry);
  }

?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b><?=$tipoacao;?> Notícia </b></strong></td>
  </tr>
</table>
<br>
<table width="580" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Descrição da Notícia</b></td>
    <td class="td4" align="left">
	   &nbsp;<textarea name="desnoticia" wrap=physical cols=28 rows=4 onKeyDown="contador(this.form.desnoticia,this.form.campolimite,240);" onKeyUp="contador(this.form.desnoticia,this.form.campolimite,240);" class="form"><?=$rsnoticia['desnoticia'];?></textarea>
                                         <font face="arial, verdana, sans-serif" size="1"><input class="form" readonly type=text name="campolimite" size=3 maxlength=3 value="240"> Caracteres Restantes.</font>
   </td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>URL</b></td>
    <td class="td4" align="left">
	   &nbsp;<input type=text name="desurl" size=60 maxlength=50 value="<?=$rsnoticia['desurl'];?>">
   </td>
  </tr>
<?
  if ($rsnoticia['datcadastro'] != "")
    $datcadastro = FormataData($rsnoticia['datcadastro'],'pt');
  else
    $datcadastro = date("d-m-Y", time());
?>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Data de Cadastro da Notícia</b></td>
	<td class="td4" align="left">
	   &nbsp;<input name="datcadastro" value="<?=$datcadastro;?>" type="text" id="datcadastro" onkeypress="mascaradata(document.form.datcadastro)" onsubmit="validadata(document.form.datcadastro)" size="14" maxlength="10" /></td>
  </tr>

<?
  if ($rsnoticia['flaativo'] == "s")
  {
     $checkedflaativo = "checked";
  }
   else
   {
    $checkedflaativo = "";
   }
?>


  <tr>
      <td width="5">&nbsp;</td>
      <td align="right" width="150" class="td3"><b>Ativar Cadastro</b></td>
	  <td class="td4" align="left">
         &nbsp;<input name= "flaativo" id="flaativo" value="s" type="checkbox" <? echo $checkedflaativo; ?>>
      </td>
  </tr>
 </table>

 <table width="580" class="table" cellspacing="0" cellpadding="0">
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
