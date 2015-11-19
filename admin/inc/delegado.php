    <?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 29/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra de Delegado
************************************************************************************/

include "../library/class_paginacao.php";
@$objpaginacao = new class_paginacao();

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

if ($codigocadastro != "")
{
   
   // Verifica se o cliente está cadastrado como delegado
   $sqlString2 = "Select * From delegado where codcliente = ".$codigocadastro; 
   $rsqry2 = mysql_query($sqlString2);
   $rsresult2 = mysql_fetch_array($rsqry2);  
   $coddelegado = $rsresult2['coddelegado'];
   
   // Deleta da tabela de degado se existir
   if ($coddelegado != "")
   {
     $sqlString2 = "Delete from delegado where codcliente = ".$codigocadastro; 
     mysql_query($sqlString2) or die(mysql_error());
   }
   else
   {
     // Inclui na tabela de degado se não existir   
     $sqlString2 = "Insert into delegado (codcliente, codnucleo) values (".$codigocadastro.",'".$codnucleo."')";
     mysql_query($sqlString2) or die(mysql_error());
   }   	 
}
?>
<script language=javascript>

function VerificaCamposObrigatorios()
{
  if (document.form.codnucleo.value =='')
  {
    alert('Campo "Núcleo" obrigatório.');
    document.form.codnucleo.focus();
    return false;
  }
  
  if (document.form.nome.value =='')
  {
    alert('Digite o nome ou a metade do nome para facilitar a pesquisa.');
    document.form.nome.focus();
    return false;
  }
}  


function MontaCidade()
{
   
  if (document.form.coduf.value != '')
   	location.replace('delegado.php?coduf='+document.form.coduf.value+'&tipoacao=Incluir'); 
}

function GravaDados(codigo)
{
   location.replace('delegado.php?codigocadastro='+codigo+'&tipoacao=<?=$tipoacao;?>&codnucleo=<?=$codnucleo;?>&nome=<?=$nome;?>'); 
   alert('Aguarde a atualização dos dados.');   
}

</script>
   
<?

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "Listar") 
{
  $tipoacao = "Listar";

  $sqlString = "Select * From cliente 
                where nomcliente like '%$nome%' 
				 and codnucleo = '".$codnucleo."'". " order by nomcliente";
  		
  $rsqry = mysql_query($sqlString);
  
  $rsresultconsulta = mysql_fetch_array($rsqry);  	
  
  // Recupera os dados da uf
  $sqlstring2 = "SELECT * FROM nucleo where codnucleo = '".$codnucleo."'";
  $rsquery2 = mysql_query($sqlstring2);
  $rsresul2 = mysql_fetch_array($rsquery2); 	
  $desnucleo = $rsresul2['desnucleo']; 

?>  
<form name='form2' method='post' action='' onSubmit=''> 
  
 <table width="750" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td2" align="center"><strong>Resultado da Pesquisa - Selecionar o Delegado</td>
  </tr> 

  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">&nbsp;<strong><br>Núcleo: </strong><?=$codnucleo." - ".$desnucleo;?>
	</td>
  </tr>  
 </table> 
 
 <br><br>
 
  <table width="750" border="1" cellspacing="0" cellpadding="0">
  <tr >
  <td width="5">&nbsp;</td>
    <td class="td2"  width="586"><strong>Nome</strong></td>
	<td class="td2" width="148" align="center"><b>Marcar</b></td>	
  </tr>   
  </table>

  <table width="750" border="1" cellspacing="0" cellpadding="0">
<?


  $ct = 0;
  while (!($rsresultconsulta==0))
  {
 
    // Recupera o código do delegado se existir na tabela de delegado
    $sqlString2 = "Select * From delegado where codcliente = ".$rsresultconsulta['codcliente'];
    $rsqry2 = mysql_query($sqlString2);
    $rsresult2 = mysql_fetch_array($rsqry2);  
	$coddelegado = $rsresult2['coddelegado'];

?> 

    <tr>
	  <td width="5">&nbsp;</td>
      <td width="587"><?=$rsresultconsulta['nomcliente'];?></td>
  	  <td width="147" align="center"><input type="checkbox" name="codcadastro[]" value="<?=$rsresultconsulta['codcliente'];?>" <? if ($coddelegado != '') echo 'checked';?>  onclick="GravaDados(this.value);"> </td>		  
    </tr> 
<?    
    $rsresultconsulta = mysql_fetch_array($rsqry);
  }
?> 
 
 </table>
 
 <table width="750" border="1" cellspacing="0" cellpadding="0">
    <tr><td width="5">&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td width="5">&nbsp;</td><td>&nbsp;</td></tr>	

    <tr><td width="5">&nbsp;</td>
      <td width="200">&nbsp;</td>
      <td  width="80"><input name='bttipoacao' type='hidden' value='Incluir'>

	  </td>
	  <td><input type="button" value="Voltar" onclick="javascript:(history.back(-1))"></td>

    </tr>

 </table>   
</form>  
<?
//  if ($codigocadastro != "")
//    echo "<script>alert('Operação efetuada com sucesso.');</script>";

}  

// Formulário para inclusão ou alteração dos dados
if ($_REQUEST['tipoacao'] == "Incluir" && $_REQUEST['bttipoacao'] == "")
{
  $tipoacao = "Listar";
?>


<br>
<form name="form" method="post" action="delegado.php?tipoacao=Listar" onSubmit="return VerificaCamposObrigatorios();">
 <table width="750" border="1" cellspacing="0" cellpadding="0">
  <tr> <td width="5">&nbsp;</td>
    <td class="td2" align="center"><strong><b>Pesquisa Núcleo para Selecionar o Delegado</b></strong></td>
  </tr> 
 </table> 
<br> 
  <table width="750" border="1" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="5">&nbsp;</td>
    <td align="right" width="60">Núcleo</td>
	<td>&nbsp;<select name="codnucleo" id="codnucleo">
	           <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados da uf
                $sqlstring2 = "SELECT * FROM nucleo";
                $rsquery2 = mysql_query($sqlstring2) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($rsquery2))
			    { ?>
       	  	       <option value="<?=$b['codnucleo']?>" 
				                  <? if ($b['codnucleo']==$codnucleo)
 								       echo "selected";
								  ?> 
					>				
					
				      <?=$b['desnucleo']?>
				   </option>
        	  <? } ?>
             </select>     	 
	    
	 </td>

  </tr>   
      
  <tr> 
    <td width="5">&nbsp;</td>
    <td align="right"  width="60">Nome</td>
    <td>&nbsp;<input type="text" id="nome" name="nome" size="30" ></td>	
  </tr>		  
 </table>    
 
 <table width="580" border="1" cellspacing="0" cellpadding="0">
    <tr><td width="5">&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td width="5">&nbsp;</td><td>&nbsp;</td></tr>	

    <tr><td width="5">&nbsp;</td>
      <td width="200">&nbsp;</td>
      <td  width="80"><input type="submit" name="Submit" value="Pesquisar" alt="Pesquisa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     
	  </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>

    </tr>

 </table> 
</form>
<?
}
?>
