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
  if (document.form.desmenatendimentoeditar.value =='')
  {
    alert('Campo descrição obrigatório.');
    document.form.desmenatendimentoeditar.focus();
    return false;
  }

}
</script>

<?
$desmenatendimento = $desmenatendimentoeditar;
if ($negrito == 's') $desmenatendimento = "<b>".$desmenatendimento."</b>";

$desmenatendimento = "<font color='$cor'>".$desmenatendimento."</font>";
$_REQUEST['desmenatendimento'] = $desmenatendimento;
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
	 $sql = SQL("mensatendimento", "insert", "desmenatendimento,desmenatendimentoeditar,cor,negrito");

  if ($bttipoacao == "Editar")
	 $sql = SQL("mensatendimento", "update", "desmenatendimento,desmenatendimentoeditar,cor,negrito", "codmenatendimento");

  if ($bttipoacao == "Excluir")
	$sql = SQL("mensatendimento","delete","", "codmenatendimento");
// echo $sql;
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
 <p>
<table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='mensagematendimento.php?bttipoacao=&$tipoacao='>
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
  

  $sqlString = "Select * From mensatendimento order by desmenatendimentoeditar";
  $rsqrymens = mysql_query($sqlString);
  $rsmensagem = mysql_fetch_array($rsqrymens);    
  
  while (!($rsmensagem==0))
  {

    $sql_update = "update mensatendimento set desmenatendimentoeditar = '".strip_tags($rsmensagem['desmenatendimentoeditar'])."' where codmenatendimento=".$rsmensagem['codmenatendimento'];
    mysql_query($sql_update);
    $rsmensagem = mysql_fetch_array($rsqrymens);
  }


  $sqlString = "Select * From mensatendimento order by desmenatendimentoeditar";
  $rsqrymens = mysql_query($sqlString);
  $rsmensagem = mysql_fetch_array($rsqrymens);  	
  
?>  
<br /><br />
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="center" class="td1"><strong><b>Mensagens de Atendimento</b></strong></td>
  </tr> 

  <tr>
    <td width="5"></td>
    <td align="left">&nbsp;&nbsp;<BR><a href="mensagematendimento.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro
     </td>
  </tr> 
</table>
 <BR>
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td class="td4"><strong>&nbsp;Descrição</strong><br></td>
	<td width="70" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>   
  </table>
  
  <table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  while (!($rsmensagem==0))
  {
?> 

    <tr>
      <td width="5">&nbsp;</td>
      <td width="450" class="td3">&nbsp;<?=$rsmensagem['desmenatendimento'];?></td>
  	  <td width="30" align="center" class="td3">
	  
	      <a href="mensagematendimento.php?tipoacao=Editar&codmenatendimento=<?=$rsmensagem['codmenatendimento'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
		  </a>
	  <td width="30" align="center" class="td3">
          <a href="mensagematendimento.php?tipoacao=Excluir&codmenatendimento=<?=$rsmensagem['codmenatendimento'];?>&bttipoacao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro.">
		  </a>	  
	   </td>	
    </tr>
    <tr cellspacing="1">
       <td width="5"></td>
       <td></td>
       <td></td>
       <td></td>
    </tr>
<?    
    $rsmensagem = mysql_fetch_array($rsqrymens);
  }
?>  
 </table>
<?
}  

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codmenatendimento != "")
  {
     $sqlString = "Select * From mensatendimento where codmenatendimento = ".$codmenatendimento;
     $rsqrymens = mysql_query($sqlString);
     $rsmensagem = mysql_fetch_array($rsqrymens);  	
  }

?>

<br>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="center" class="td1"><strong><b><?=$tipoacao;?>&nbsp;Mensagem de Atendimento</b></strong></td>
  </tr> 
 </table> 
<br>
<table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  if ($codmenatendimento != "")
  {
?>
  <tr>
     <td align="right" width="60" class="td4">Código</td>
	 <td class="td3">&nbsp;<?=$codmenatendimento;?><br></td>
  </tr>
<?
  }
?>
  <tr>
    <td align="right" width="60" class="td4">Descrição</td>
   <td class="td3">&nbsp;<input name="desmenatendimentoeditar" value="<?=strip_tags($rsmensagem['desmenatendimentoeditar']);?>" type="text" id="desmenatendimentoeditar" size="60" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="right" width="60" class="td4">Cor</td>
    <td class="td3">&nbsp;<input type="text" name="cor" id="cor" data-format="hex" class="demo1" value="<?=$rsmensagem['cor'];?>" />
    <script>
    $(function(){
        $('.demo1').colorpicker({
      colorSelectors: {
        'default': '#777777',
        'primary': '#337ab7',
        'success': '#5cb85c',
        'info': '#5bc0de',
        'warning': '#f0ad4e',
        'danger': '#d9534f'
      }
    });
    });
</script>

  </td>
  <tr>
    <td align="right" width="60" class="td4">Negrito?</td>
	  <td class="td3">&nbsp;
    <input type="checkbox" name="negrito" id="negrito" value="s" <?php if ($rsmensagem['negrito']=='s') echo "checked" ?> >
   
  </td>
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
