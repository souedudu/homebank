<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 30/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra Tipo de Serviço da Solicitação
************************************************************************************/

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.destiposervsol.value =='')
  {
    alert('Campo "Descrição" obrigatório.');
    document.form.destiposervsol.focus();
    return false;
  }

  if (document.form.codtiposol.value =='')
  {
    alert('Campo "Tipo de Solicitação" obrigatório.');
    document.form.codtiposol.focus();
    return false;
  }
}
</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
	$sql = SQL("tiposervsolicitacao", "insert", "codtiposol,destiposervsol");

  if ($bttipoacao == "Editar")
	$sql = SQL("tiposervsolicitacao", "update", "codtiposol,destiposervsol", "codtiposervsol");

  if ($bttipoacao == "Excluir")		
	$sql = "delete from tiposervsolicitacao where codtiposervsol = ".$_REQUEST['codtiposervsol'];
	
	

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
   
<?
}

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "")
{
  $tipoacao = "Listar";
  
  $sqlString = "Select t.*, s.destiposol From tiposervsolicitacao t, tiposolicitacao s 
                where t.codtiposol = s.codtiposol order by destiposervsol";
				 
  $rsquery = mysql_query($sqlString);
  $rsresult = mysql_fetch_array($rsquery);  	
  
  
  //bgcolor="#91CDC0" 
?>  
<br />
<table width="580" border="1" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td1"><strong><b>Item do Tipo de Serviço</b></strong></td>
  </tr> 

  <tr>
    <td width="5">&nbsp;</td>
    <td align="left"><BR><a href="itemtiposervsolicitacao.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro </td>
  </tr> 
</table>
<BR>
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="260" class="td4"><strong>&nbsp;Descrição</strong><br></td>
    <td width="110" class="td4"><strong>&nbsp;Tipo de Serviço</strong><br></td>
	<td width="58" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>   
  </table>
  
  <table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  while (!($rsresult==0))
  {
?> 

    <tr>
      <td width="272" class="td3">&nbsp;<?=$rsresult['destiposervsol'];?></td>
      <td width="115" class="td3">&nbsp;<?=$rsresult['destiposol'];?></td>
  	  <td width="29" align="center" class="td3">
	  
	      <a href="itemtiposervsolicitacao.php?tipoacao=Editar&amp;codtiposervsol=<?=$rsresult['codtiposervsol'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro."></a>
	  <td width="29" align="center" class="td3">
          <a href="itemtiposervsolicitacao.php?tipoacao=Excluir&amp;codtiposervsol=<?=$rsresult['codtiposervsol'];?>&amp;bttipoacao=Excluir">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro."> </a>
	  </td>	   
<?    
    $rsresult = mysql_fetch_array($rsquery);
    echo "</tr>";
    echo "<tr cellspacing='1'>";
    echo "    <td></td>";
    echo "    <td></td>";
    echo "    <td></td>";
    echo "</tr>";
  }
?>  
 </table>
<?
}  

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($codtiposervsol != "")
  {
     $sqlString = "Select * From tiposervsolicitacao where codtiposervsol = ".$codtiposervsol;
     $rsquery = mysql_query($sqlString);
     $rsresult = mysql_fetch_array($rsquery);  	
  }

?>

<br>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"></td>
    <td align="center" class="td1"><strong><b><?=$tipoacao;?> Item do Tipo de Serviço</strong></b></td>
  </tr> 
</table>
<BR>
<table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" width="110" class="td4">Código</td>
	 <td class="td3">&nbsp;<?=$codtiposervsol;?><br></td>
  </tr> 
  <tr>
    <td align="right" width="110" class="td4">Descrição</td>
	 <td class="td3">&nbsp;<input name="destiposervsol" value="<?=$rsresult['destiposervsol'];?>" type="text" id="destiposervsol" size="70" /></td>
  </tr> 

  <tr>
    <td align="right" width="110" class="td4">Tipo de Serviço</td>
	 <td class="td3">&nbsp;<select name="codtiposol" id="codsetor">
	           <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados do setor
                $sqltiposol = "select * from tiposolicitacao order by destiposol";
                $qrytiposol = mysql_query($sqltiposol) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($qrytiposol))
			    { ?>
       	  	       <option value="<?=$b['codtiposol']?>" 
				                  <? if ($b['codtiposol']==$rsresult['codtiposol'])
 								       echo "selected";
								  ?> 
					>				
					
				      <?=$b['destiposol']?>
				   </option>
        	  <? } ?>
             </select>      	  
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
