<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 08/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Cadastra de Menu
************************************************************************************/

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

	$sql = "select * from usuario where codusuario = ".$_SESSION['codusuarioadm'];
	$result = mysql_query($sql) or die(mysql_error());
	$dados = mysql_fetch_array($result);
	if ($dados['flapercadmenu'] == "n")
	{
		echo "<script> document.location.href='index.php'; </script>";
		exit;
	}

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.desmenu.value =='')
  {
    alert('Campo descrição do menu obrigatório.');
    document.form.desmenu.focus();
    return false;
  }
  if (document.form.desurl.value =='')
  {
    alert('Campo descrição da URL obrigatório.');
    document.form.desurl.focus();
    return false;
  }
}
</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
	$sql = SQL("menu", "insert", "desmenu,desurl,flaativo,codpaimenu");
  if ($bttipoacao == "Editar")
	$sql = SQL("menu", "update", "desmenu,desurl,flaativo,codpaimenu", "codmenu");

  if ($bttipoacao == "Excluir")
	$sql = SQL("menu","delete","", "codmenu");
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
    <td align='center'><a href='cadastramenu.php?bttipoacao=&$tipoacao='>
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

  $sqlString = "Select * From menu order by desmenu asc";
  $rsqry = mysql_query($sqlString);
  $rsmenu = mysql_fetch_array($rsqry);

?>
<br />
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2">Menu</td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">&nbsp;<br><a href="cadastramenu.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro <BR><BR>
     </td>
  </tr>
</table>
<table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td4"><strong>&nbsp;Descrição do Menu</strong><br></td>
	<td width="70" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
  <tr cellspacing="0">
    <td></td>
	<td></td>
  </tr>
</table>

  <table width="580" class="table" cellspacing="0" cellpadding="0">
<?
  while (!($rsmenu==0))
  {
?>

    <tr>
      <td width="5">&nbsp;</td>
      <td width="450" class="td3">&nbsp;<?=$rsmenu['desmenu'];?></td>
  	  <td width="30" align="center" class="td3">
         <a href="cadastramenu.php?tipoacao=Editar&codmenu=<?=$rsmenu['codmenu'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
         </a>
      <td width="30" align="center" class="td3">
         <a href="cadastramenu.php?tipoacao=Excluir&codmenu=<?=$rsmenu['codmenu'];?>&bttipoacao=Excluir">
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
    $rsmenu = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($_REQUEST['codmenu'] != "")
  {
     $sqlString = "Select * From menu where codmenu = ".$_REQUEST['codmenu'];
     $rsqry = mysql_query($sqlString);
     $rsmenu = mysql_fetch_array($rsqry);
  }

?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b><?=$tipoacao;?> Menu </b></strong></td>
  </tr>
</table>
<br>
<table width="580" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Descrição do Menu</b></td>
    <td class="td4" align="left">
	   &nbsp;<input name="desmenu" value="<?=$rsmenu['desmenu'];?>" type="text" id="desmenu" size="40" maxlength="40" /></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Descrição da URL</b></td>
	<td class="td4" align="left">
	   &nbsp;<input name="desurl" value="<?=$rsmenu['desurl'];?>" type="text" id="desurl" size="70" maxlength="180" /></td>
  </tr>

<?
  if ($rsmenu['flaativo'] == "s")
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
      <td align="right" width="150" class="td3"><b>Ativar Menu</b></td>
	  <td class="td4" align="left">
         &nbsp;<input name= "flaativo" id="flaativo" value="s" type="checkbox" <? echo $checkedflaativo; ?>>
      </td>
  </tr>
  <tr>
     <? if ($rsmenu['codpaimenu'] == 0)
          {
           $msgm = "Escolha o item...";
           }
            else{
                 if ($rsmenu['codpaimenu'] == 1)
                    {
                     $msgm = "Tabelas do Sistema";
                     }
                      elseif ($rsmenu['codpaimenu'] == 2)
                             {
                              $msgm = "Consultas";
                             }
                 }
     ?>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Código Pai</b></td>
    <td class="td4" align="left">
       &nbsp;<select size="1" name="codpaimenu" style="width:150">
                 <option value="">Selecione</option>
                 <option value="1" <? if ($rsmenu['codpaimenu']==1)
 								       echo "selected";
								   ?> >Cadastros</option>
                 <option value="2" <? if ($rsmenu['codpaimenu']==2)
 								       echo "selected";
								   ?> >Consultas</option>
             </select>
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
