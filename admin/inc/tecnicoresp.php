<?
/********************************************************************************
Autor: Gelson
Data Cria��o: 
Data Atualiza��o: 29/11/2005 - Gelson
Sistema: Home Bank
Descri��o: Cadastra Mensagem de atendimento
************************************************************************************/

// Abre conex�o com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.tecnicosetor.value =='')
  {
    alert('Campo descri��o obrigat�rio.');
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
	$sql = SQL("tecnicoresp", "insert", "codsetor,desfuncaoresp,nomtecnicoresp,desemailresp,numtelefoneresp,numramalresp");

  elseif ($bttipocao == "Editar")
	$sql = SQL("tecnicoresp", "update", "codsetor,desfuncaoresp,nomtecnicoresp,desemailresp,numtelefoneresp,numramalresp", "codtecnicoresp");

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
    <td align='center'><br>Opera��o efetuada com sucesso.<p> </td>
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

// Lista dados que est�o cadastrados na tabela
if ($_REQUEST['tipoacao'] == "")
{
  $tipoacao = "Listar";
  
  $sqlString = "Select t.*, s.dessetor From tecnicoresp t, setor s 
                where t.codsetor = s.codsetor";
				 
  $rsqrytecnicoresp = mysql_query($sqlString);
  $rstecnicoresp = mysql_fetch_array($rsqrytecnicoresp);  	
  
?>  
<br />
 <table width="580" border="0" cellspacing="2" cellpadding="1">
  <tr>
      <td width="5"></td>
      <td align="center" class="td1">T&eacute;cnico Respons&aacute;vel </td>
  </tr> 
  <tr>
      <td width="5"></td>
      <td align="left"><BR><a href="tecnicoresp.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo t&eacute;cnico </td>
  </tr> 
</table>
<BR>
<table width="580" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td width="281" class="td4"><strong>Nome </strong><br></td>
      <td width="140" class="td4"><strong>Fun��o </strong><br></td>
      <td width="86" class="td4"><strong>Ger�ncia </strong><br></td>
	  <td width="63" class="td4" ><strong>Op��es</strong><br></td>
  </tr>   
</table>
<table width="580" border="0" cellspacing="0" cellpadding="0">
<?
  while (!($rstecnicoresp==0))
  {
?> 

    <tr>
      <td width="5"></td>
      <td width="281" class="td3">&nbsp;<?=$rstecnicoresp['nomtecnicoresp'];?></td>
      <td width="141" class="td3">&nbsp;<?=$rstecnicoresp['desfuncaoresp'];?></td>
	  <td width="85" class="td3">&nbsp;<?=$rstecnicoresp['dessetor'];?></td>
  	  <td width="32" align="center" class="td3">
	      <a href="tecnicoresp.php?tipoacao=Editar&codtecnicoresp=<?=$rstecnicoresp['codtecnicoresp'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">
          </a>
      </td>
	  <td width="29" align="center" class="td3">
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
// Formul�rio para inclus�o ou altera��o dos dados
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
    <td align="center" class="td1"><?=$tipoacao;?> T&eacute;cnico Respons&aacute;vel </td>
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
      <td align="right" width="110" class="td4">C�digo</td>
      <td class="td3">&nbsp;<?=$codtecnicoresp;?><br></td>
  </tr>
<?
  }
?>
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Nome do T�cnico</td>
	  <td class="td3">&nbsp;<input name="nomtecnicoresp" value="<?=$rstecnicoresp['nomtecnicoresp'];?>" type="text" id="nomtecnicoresp" size="70" /></td>
  </tr> 
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Ger�ncia</td>
	  <td class="td3">&nbsp;<select name="codsetor" id="codsetor">
	           <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados do setor
                $sqlsetor = "select * from setor order by dessetor";
                $qrysetor = mysql_query($sqlsetor) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($qrysetor))
			    { ?>
       	  	       <option value="<?=$b['codsetor']?>" 
				                  <? if ($b['codsetor']==$rstecnicoresp['codsetor'])
 								       echo "selected";
								  ?> 
					>
				      <?=$b['dessetor']?>
				   </option>
        	  <? } ?>
             </select>      	  
	 </td>
  </tr> 
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Fun��o</td>
	  <td class="td3">&nbsp;<input name="desfuncaoresp" value="<?=$rstecnicoresp['desfuncaoresp'];?>" type="text" id="desfuncaoresp" size="50" maxlength="100" /></td>
  </tr> 
  
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">E-Mail</td>
	  <td class="td3">&nbsp;<input name="desemailresp" value="<?=$rstecnicoresp['desemailresp'];?>" type="text" id="desemailresp" size="60" maxlength="100" /></td>
  </tr> 
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Telefone</td>
      <td class="td3">&nbsp;<input name="numtelefoneresp" value="<?=$rstecnicoresp['numtelefoneresp'];?>" type="text" id="numtelefoneresp" size="20" maxlength="100" /></td>
  </tr>     
  <tr>
      <td width="5"></td>
      <td align="right" width="110" class="td4">Ramal</td>
      <td class="td3">&nbsp;<input name="numramalresp" value="<?=$rstecnicoresp['numramalresp'];?>" type="text" id="numramalresp" size="5" maxlength="100" /></td>
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