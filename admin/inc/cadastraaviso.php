<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 16/02/2006
Data Atualização:
Sistema: Home Bank
Descrição: Cadastra de Avisos
************************************************************************************/
	// Abre conexão com o bd
	$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

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
  $dataviso = FormataData($_REQUEST['dataviso'],'en');
   
  
  if ($bttipoacao == "Incluir"){
  	
  	$sql = "insert into aviso (desaviso, dataviso, flaativo, horaaviso, codpainel) values ('".$desaviso."', '".$dataviso."', '".$flaativo."', '".$horaaviso."', '".$codpainel."')";

    $result = mysql_query($sql) or die("Erro na Inserção!");
  
  }	
  if ($bttipoacao == "Editar"){
  	$sql = "update aviso set desaviso = '".$_REQUEST['desaviso']."',
  	                           dataviso = '".$dataviso."',
  	                           flaativo = '".$_REQUEST['flaativo']."',
							   codpainel = '".$_REQUEST['codpainel']."',
  	                           horaaviso = '".$_REQUEST['horaaviso']." '
  	                           where codaviso = ".$_REQUEST['codaviso'];

    $result = mysql_query($sql) or die ("Erro na Alteração!");
  }
	

  if ($bttipoacao == "Excluir"){
	$sql = SQL("aviso","delete","", "codaviso");
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
    <td align='center'><a href='cadastraaviso.php?bttipoacao=&$tipoacao='>
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

  $sqlString = "Select * From aviso order by dataviso desc";
  $rsqry = mysql_query($sqlString);
  $rsaviso = mysql_fetch_array($rsqry);

?>
<br />
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2">Avisos</td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">&nbsp;<br><a href="cadastraaviso.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro <BR><BR>
     </td>
  </tr>
</table>
<table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td4"><strong>&nbsp;Descrição do Aviso</strong><br></td>
	<td width="70" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
  <tr cellspacing="0">
    <td></td>
	<td></td>
  </tr>
</table>

  <table width="580" class="table" cellspacing="0" cellpadding="0">
<?
  while (!($rsaviso==0))
  {
?>

    <tr>
      <td width="5">&nbsp;</td>
      <td width="450" class="td3">&nbsp;<?=$rsaviso['desaviso'];?></td>
  	  <td width="30" align="center" class="td3">
         <a href="cadastraaviso.php?tipoacao=Editar&codaviso=<?=$rsaviso['codaviso'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
         </a>
      <td width="30" align="center" class="td3">
         <a href="cadastraaviso.php?tipoacao=Excluir&codaviso=<?=$rsaviso['codaviso'];?>&bttipoacao=Excluir">
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
    $rsaviso = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codaviso != "")
  {
     $sqlString = "Select * From aviso where codaviso = ".$codaviso;
     $rsqry = mysql_query($sqlString);
     $rsaviso = mysql_fetch_array($rsqry);
  }

?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b><?=$tipoacao;?> Aviso </b></strong></td>
  </tr>
</table>
<br>
<table width="580" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Descrição do Aviso</b></td>
    <td class="td4" align="left">
	   &nbsp;<textarea name="desaviso" id="desaviso" cols="40" rows="10" maxlength="250"><?=$rsaviso['desaviso'];?></textarea>
	</td>
  </tr>
<?
	//Busca HORÁRIO DE CADASTRO
	if ($rsaviso['horaaviso'] != ""){
		$horaaviso = $rsaviso['horaaviso'];
	}else{
		$horaaviso = date ("H:i:s");
	}
	
	//Busca DATA DE CADASTRO
	if ($rsaviso['dataviso'] != ""){
		$dataviso = $rsaviso['dataviso'];
		$dataviso = FormataData($dataviso,'pt');
	}else{
		$dataviso = date ("d-m-Y");
	}
	
?>
  
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Horário de Cadastro</b></td>
	<td class="td4" align="left">
	   &nbsp;<input name="horaaviso1" value="<?=$horaaviso;?>" type="text" id="horaaviso1" size="10" disabled/><input name="horaaviso" value="<?=$horaaviso;?>" type="hidden" id="horaaviso" />										
	</td>	
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Data de Cadastro</b></td>
	<td class="td4" align="left">
	   &nbsp;<input name="dataviso1" value="<?=$dataviso;?>" type="text" id="dataviso1" size="18" disabled/><input name="dataviso" value="<?=$dataviso;?>" type="hidden" id="dataviso" />										
	</td>	
  </tr>
<?
  if ($rsaviso['codpainel'] == "0" || $rsaviso['codpainel'] == "")
  {
     $radiopaineladmin = "checked";
  }
   else
   {
    $radiopainelcliente = "checked";
   }
?>


  <tr>
    <td width="5">&nbsp;</td>
    <td align="right" width="150" class="td3"><b>Mostrar Mensagem no Painel</b></td>
	<td class="td4" align="left">
	   &nbsp;<input name="codpainel" type="radio" value="0" <?=$radiopaineladmin?> />&nbsp;Administrativo&nbsp;&nbsp;<input name="codpainel" type="radio" value="1" <?=$radiopainelcliente?> />&nbsp;Cliente										
	</td>	
  </tr>

<?
  if ($rsaviso['flaativo'] == "s")
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
      <td align="right" width="150" class="td3"><b>Ativar Aviso</b></td>
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
