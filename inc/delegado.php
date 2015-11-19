<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 29/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra de Delegado
************************************************************************************/

// Abre conexão com o bd
$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

if ($codigocadastro != "")
{
   // Recupera a UF e Cidade do cliente
   $sqlString2 = "Select coduf, descidade From cliente where codcliente = ".$codigocadastro; 
   $rsqry2 = mysql_query($sqlString2);
   $rsresult2 = mysql_fetch_array($rsqry2);  
   $codufcli = $rsresult2['coduf'];   
   $descidadecli = $rsresult2['descidade'];      
   
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
     $sqlString2 = "Insert into delegado (codcliente, descidade, coduf) values (".$codigocadastro.",'".$descidadecli."','".$codufcli ."')";
     mysql_query($sqlString2) or die(mysql_error());
   }   	 
   //$codigocadastro = ""; 
  
  //echo "<script>mensagem('<strong>Carregando...</strong>')</script>";
}
?>
<script language=javascript>

function VerificaCamposObrigatorios()
{
  if (document.form.coduf.value =='')
  {
    alert('Campo "UF" obrigatório.');
    document.form.coduf.focus();
    return false;
  }

  if (document.form.nome.value =='')
  {
    alert('Campo "Nome" obrigatório.');
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
   location.replace('delegado.php?codigocadastro='+codigo+'&tipoacao=<?=$tipoacao;?>&coduf=<?=$coduf;?>&descidade=<?=$descidade;?>&nome=<?=$nome;?>'); 
   alert('Aguarde a atualização dos dados.');   
}

</script>

<?
// Grava dados do formulario
if ($bttipoacao != "")
{
  if ($bttipoacao == "Incluir")
  {
	 $bttipoacao = "";
	 $tipoacao = "Incluir";
 
  }
  
?>
 <br><br>
 <table width='580' border='1' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td align='center'><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='delegado.php?bttipoacao=&$tipoacao='>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>
   
<?
}

// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "Listar") 
{
  $tipoacao = "Listar";

  $sqlString = "Select * From cliente where coduf = '".$coduf."'";
  
  if ($nome != "")
    $sqlString = $sqlString . " and nomcliente like '%".$nome."%'";
	
  if ($descidade != "")
    $sqlString = $sqlString . " and descidade like '%".$descidade."%'";
		
  $rsqry = mysql_query($sqlString);
  
  $rsresultconsulta = mysql_fetch_array($rsqry);  	
  
?>  
<form name='form2' method='post' action='' onSubmit=''> 
<br />
  
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center"><strong>Pesquisa Cadastro de Cliente Para Selecionar o Delegado</td>
  </tr> 

  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">&nbsp;<b>Parâmetros da Pesquisa</b><br /><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome: </strong><?=$nome;?><br /><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UF:</strong> <?=$coduf;?><br /><strong>&nbsp;&nbsp;&nbsp;Cidade: </strong><?=$descodade;?>
	</td>
  </tr> 
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center"><strong>Resultado da Pesquisa</td>
  </tr>   
 </table> 
 
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr >
    <td width="2">&nbsp;</td>
    <td width="205"><strong>Nome</strong></td>
    <td width="25" align="center"><strong>&nbsp;UF</strong></td>
    <td width="125"><strong>&nbsp;Cidade</strong></td>		
	<td width="45" align="center"><b>Marcar</b></td>	
  </tr>   
  </table>

  <table width="580" border="1" cellspacing="0" cellpadding="0">
<?
  while (!($rsresultconsulta==0))
  {
 
    // Recupera o código do delegado se existir na tabela de delegado
    $sqlString2 = "Select * From delegado where codcliente = ".$rsresultconsulta['codcliente'];
    $rsqry2 = mysql_query($sqlString2);
    $rsresult2 = mysql_fetch_array($rsqry2);  
	$coddelegado = $rsresult2['coddelegado'];

?> 

    <tr>
	  <td width="2">&nbsp;</td>
      <td width="205"><?=$rsresultconsulta['nomcliente'];?></td>
      <td width="25" align="center">&nbsp;<?=$rsresultconsulta['coduf'];?></td>
      <td width="125">&nbsp;<font FACE="Arial, Helvetica, Geneva" size=1> <?=$rsresultconsulta['descidade'];?></font></td>		
  	  <td width="45" align="center"><input type="checkbox" name="codcadastro[]" value="<?=$rsresultconsulta['codcliente'];?>" <? if ($coddelegado != '') echo 'checked';?>  onclick="GravaDados(this.value);"> </td>		  
    </tr> 
<?    
    $rsresultconsulta = mysql_fetch_array($rsqry);
  }
?> 
 
 </table>
 
 <table width="580" border="1" cellspacing="0" cellpadding="0">
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
<br>
 <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr> <td width="5">&nbsp;</td>
    <td align="center"><strong><b>Pesquisa Cadastro de Cliente Para Selecionar o Delegado</b></strong></td>
  </tr> 
 </table> 
 
  <table width="580" border="1" cellspacing="0" cellpadding="0">
  <tr> <td width="5">&nbsp;</td>
    <td align="right" width="60">UF</td>
	 <td>&nbsp;<select name="coduf" id="coduf" onChange="MontaCidade();">
	           <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados da uf
                $sqlstring2 = "SELECT distinct coduf FROM cliente Where coduf <> '' Order by coduf";
                $rsquery2 = mysql_query($sqlstring2) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($rsquery2))
			    { ?>
       	  	       <option value="<?=$b['coduf']?>" 
				                  <? if ($b['coduf']==$coduf)
 								       echo "selected";
								  ?> 
					>				
					
				      <?=$b['coduf']?>
				   </option>
        	  <? } ?>
             </select>     	 
	    
	 </td>

  </tr> 
  
  <tr> <td width="5">&nbsp;</td>
    <td align="right" width="60">Cidade</td>
	 <td><div align="left" id="divcidade">
	        &nbsp;<select name="descidade" id="descidade">
	                <option value="">Selecione</option> 
        	  <? 
 		        // Recupera os dados da cidade
                $sqlstring2 = "SELECT distinct descidade FROM cliente ".
				              "Where descidade <> '' and descidade <> '.' and coduf = '".$coduf."'".
							  "Order by descidade";
                $rsquery2 = mysql_query($sqlstring2) or die(mysql_error());			  
			  
			    while($b = mysql_fetch_array($rsquery2))
			    { ?>
       	  	       <option value="<?=$b['descidade']?>" 
				                  <? if ($b['descidade']==$rsresult['descidade'])
 								       echo "selected";
								  ?> 
					>				
					
				      <?=$b['descidade']?>
				   </option>
        	  <? } ?>			
         </select> 
         </div>    	 
	 
	 </td>
  </tr> 

  <tr>
    <tr> <td width="5">&nbsp;</td>
    <td align="right" width="60">Nome</td>
	 <td>
	    &nbsp;<input name="nome" type="text" id="nome" size="45" maxlength="60" value="<?=$nome?>">
		<font color="#FF0000"> (Digite o nome ou parte dele.)</font>
	</td>
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
