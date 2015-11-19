<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 30/11/2005 - Gelson
Sistema: Home Bank
Descrição: Cadastra Solicitação
************************************************************************************/

$tipoacao = $_REQUEST['tipoacao'];

if ($acaotriagem != "")
{
  include_once("../library/config.php");
  include_once("../library/funcoes.php");
  Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
 
}
else Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.codtiposervsol.value =='')
  {
    alert('Campo "Tipo de Serviço" obrigatório.');
    document.form.codtiposervsol.focus();
    return false;
  }

  if (document.form.dessolicitacao.value =='')
  {
    alert('Campo "Detalhes da solicitação" obrigatório.');
    document.form.dessolicitacao.focus();
    return false;
  }
   
  if (document.form.desemailcont.value =='')  
  {
    alert('Campo "E-Mail de contato" obrigatório.');
    document.form.desemailcont.focus();
    return false;
  } 
  
  if (document.form.numtelefonecont.value =='')
  {
    alert('Campo "Telefone de contato" obrigatório.');
    document.form.numtelefonecont.focus();
    return false;
  }
  
  if (document.form.bttipoacao.value =='Editar')
  {
     if (document.form.codtecnicoresp.value =='')
     {  
       alert('Campo "Técnico responsável" obrigatório.');
       document.form.codtecnicoresp.focus();
       return false;
	 }
  }
  
  if (document.form.bttipousuario.value =='T')
  {
     if (document.form.numcontacorrentesol.value =='')
     {  
       alert('Campo "Conta corrente do cliente" obrigatório.');
       document.form.numcontacorrentesol.focus();
       return false;
	 }
  }  
  
  if (document.form.btcoddelegado.value !='')
  {
     if (document.form.numcontacorrentesol.value =='')
     {  
       alert('Campo "Conta corrente do cliente" obrigatório.');
       document.form.numcontacorrentesol.focus();
       return false;
	 }
  }  
     
}

</script>
<style>
.base{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#FFFFFF;
	font-weight:bold;
	text-align:right;
	padding-right:5px;
}

.menu{
	color:#FFFFFF;
	font-weight:bold;
	text-align:center;
	text-decoration:none;
	font-size:10px;
}


body,p,div,select,table,tr,th,td,input,textarea,.texto{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000;
	border:0px solid #606060;
	cellspacing: 0px
}


.td1{
    border:1px solid #606060;
	background-color:#F2F8E4;
	color:#CC0000;
	font-weight:bold;
}
.td2{
    border:1px solid #606060;
    background-color:#828916;
	color:#F2F8E4;
	font-weight:bold;
}
.td3{
	background-color:#F4F4F4
}
.td4{
    border:0px solid #606060;
    background-color:#F7FEE7;
	color:#000000;
	font-weight:bold;
}
.td5{
    border:0px solid #606060;
    background-color:#FFFFFF;
	color:#000000;
}
th{
	background-color:#637B9A;
	color:#F2F4F7;
}

input,textarea,select{
	border:1px solid;
	background-color:#F2F8E4;
}

.tb{
	border:1px solid #FFF;
	background-color:#FFF;
}

.tberro{
	border:1px solid #FF0000;
	background-color:#FF9999;
	color:#CC0000;
	font-weight:bold;
}

a{
color:#FFF;
text-decoration:none;
}
.bt{
background-color:#778897;
color:#FFFFFF;
font-weight:bold;
font-size:10px;
font-family:arial;
}

.link{
color:#333333;
text-decoration:underline;
}

.btLink{
 background-color:#C6D2DF;
 border:1px solid #000;
 text-decoration:none;
 font-weight:bold;
 padding:2px;
 padding-top:0px;
 padding-bottom:0px;
 color: #000000;

}
</style>
<?
// Grava dados do formulario
if ($bttipoacao != "")
{

  // Verifica se a conta corrente existe 
  $sqlexi = "select cc.numcontacorrente, c.codnucleo 
			 from contacorrente cc, cliente c
			  where cc.numcontacorrente = '$numcontacorrentesol' and
			  cc.codcliente = c.codcliente ";
			  
  $msgusuario = "Conta corrente não existe.";	
  		  
  if ($btcoddelegado != "")
  {
    $sqlexi = $sqlexi. " and c.codnucleo = ".$_SESSION['codnucleo']; 
	$msgusuario = "Conta corrente não pertence ao seu núcleo.";
  }
  
  
  $queryexi = mysql_query($sqlexi);
  $rsresultexi = mysql_fetch_array($queryexi);		  
  
  if ($rsresultexi == 0)
  {
    $_SESSION['vdessolicitacao'] = $dessolicitacao;
	$_SESSION['vcodtiposervsol'] = $codtiposervsol;
	$_SESSION['vdesemailcont'] = $desemailcont;
	$_SESSION['vnumtelefonecont'] = $numtelefonecont;		
	echo "<script>alert('".$msgusuario."');history.back(-1);</script>";
  }
  
  $hora = date("H:i:s"); 
  if ($bttipoacao == "Incluir")
  {
    $dtsolicitacao = date("Y/m/d");
	
	if ($numcontacorrentesol == "")
	  $numcontacorrentesol = $_SESSION['numcontacorrente'];
	  
	// Se for o cliente que estive logado então sql do cliente  
	if ($_SESSION['codcliente'] != "")
	{
       $sql = "insert into solicitacaoserv (codcliente, codtiposervsol, numcontacorrente, dessolicitacao, desemailcont, numtelefonecont, dtsolicitacao, hrsolicitacao) values (".$_SESSION['codcliente'].",".$codtiposervsol.",'".$numcontacorrentesol."','".$dessolicitacao."','".$desemailcont."','".$numtelefonecont."','".$dtsolicitacao."', '".$hora."')";
	      	 $onhref = "/crediembrapa/homebanking/site";
	}
	
	// Se for o usuário que estive logado então sql do usuario  
	if ($_SESSION['codtecnicorespadm'] != "")
	{
       $sql = "insert into solicitacaoserv (codtecnicosol, codtiposervsol, numcontacorrente, dessolicitacao, desemailcont, numtelefonecont, dtsolicitacao, hrsolicitacao) values (".$_SESSION['codtecnicorespadm'].",".$codtiposervsol.",'".$numcontacorrentesol."','".$dessolicitacao."','".$desemailcont."','".$numtelefonecont."','".$dtsolicitacao."', '".$hora."')";
	     	$onhref = "/crediembrapa/homebanking/site/admin/solicitacao.php?tipoacao=Incluir";	 

	}	
	
	$desmensagem = "Sua solicitação foi cadastrada com sucesso.";
	$onclick = "";
  }
  
  if ($bttipoacao == "Editar")
  {
	$sql = "update solicitacaoserv set ". 
//	        " codtiposervsol = ".$codtiposervsol."," .
			"codtecnicoresp = ".$codtecnicoresp.
//			.", "."numcontacorrente = '".$numcontacorrente."', dessolicitacao = '".$dessolicitacao
//			."', desemailcont = '".$desemailcont."', numtelefonecont = '".$numtelefonecont."'". 
	       " where codsolicitacao = ".$codsolicitacao;
	$desmensagem = "Solicitação atualizada com sucesso.";
	
	$onhref = "javascript://;";
	$onclick = "<script>alert('Triagem efeutada com sucesso.');window.opener.location.reload();window.close();</script>";
	echo $onclick;
  }
  
  // Grava os dados
  mysql_query($sql) or die(mysql_error());
  
  if ($bttipoacao == "Incluir")
    $codigosolicitacao = mysql_insert_id();

?>

 <br>
 <table width='580' border='1' cellspacing='0' cellpadding='0' class="td1">
  <tr>
    <td width='5'> </td>
    <td class="td2" align='center'><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width='5'> </td>
    <td align='center'><br><?=$desmensagem?><p> </td>
  </tr>
  <tr>
    <td width='5'> </td>
    <td align='center'><br><br>
	                   O número da sua solicitação de serviço é : <?=$codigosolicitacao;?>
					   <br><br><br><br>
	</td>
  </tr>
    
 </table>
 <p>
 <table width='580' border='0' cellspacing='0' cellpadding='0'>
  <tr>                         
    <td align='center'><a href='<?=$onhref?>' onclick= '<?=$onclick?>'>
	                   <img src='/crediembrapa/homebanking/site/img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>
   
<?
}

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  $dtsolicitacao = date("d/m/Y");
  
  // Verifica se é o usuario ou o cliente que está logado
  if ($_SESSION['codcliente'] != "")
  {
     $codcliente = $_SESSION['codcliente'];
     //$numcontacorrentesol = $_SESSION['numcontacorrente']; 
     $dessolicitante = $_SESSION['nomcliente'];
	 $tipousuario = "C";

     $sqldel = "select coddelegado From delegado where codcliente = ".$codcliente;
     $querydel = mysql_query($sqldel);
     $rsresultdel = mysql_fetch_array($querydel);  
	 $coddelegado = $rsresultdel['coddelegado']; 
   	 $onhref = "/crediembrapa/homebanking/site";

  }
  
  if ($_SESSION['codtecnicorespadm'] != "")
  {
     $dessolicitante = $_SESSION['desusuario'];
	 $tipousuario = "T";	 
  }
    
  // Ação do botão cancelar se não for editar solicitação para triagem
  $acaobtcancelar = "javascript:document.location.href='index.php';";
  
  
  if ($_SESSION['vdessolicitacao'] != "")
  {
     $dessolicitacao = $_SESSION['vdessolicitacao'];
	 $codtiposervsol = $_SESSION['vcodtiposervsol'];
	 $desemailcont = $_SESSION['vdesemailcont'];
	 $numtelefonecont = $_SESSION['vnumtelefonecont'];
		 
	 $_SESSION['vdessolicitacao'] = "";
	 $_SESSION['vcodtiposervsol'] = "";
	 $_SESSION['vdesemailcont'] = "";
	 $_SESSION['vnumtelefonecont'] = "";
  }
  
  
  if ($codsolicitacao != "")
  {
     $acaobtcancelar = "javascript: window.close();"; 
	 
     $sqlString = "select * From solicitacaoserv where codsolicitacao = ".$codsolicitacao;
     $rsquery = mysql_query($sqlString);
     $rsresult = mysql_fetch_array($rsquery);  	
	 
	 // Se não encontrou a solicitação volta para a pagina inicial
	 if ($rsresult==0)
       echo "<script>document.location.href='index.php';</script>"; 
	 
	 $codtiposervsol = $rsresult['codtiposervsol']; 
	 
	 $hrsolicitacao = $rsresult['hrsolicitacao']; 
	 $dtsolicitacao = $rsresult['dtsolicitacao']; 
	 $dtsolicitacao = FormataData($dtsolicitacao,'pt');
	 
	 $numcontacorrentesol = $rsresult['numcontacorrente'];
	 $codtecnicoresp = $rsresult['codtecnicoresp'];
	 $codtecnicoresp = $rsresult['codtecnicoresp'];
	 $desemailcont = $rsresult['desemailcont'];
	 $numtelefonecont = $rsresult['numtelefonecont'];
	 
	 if ($dtconclusao != "")
	 {
	   $dtconclusao = $rsresult['dtconclusao'];
	   $dtconclusao = FormataData($dtconclusao,'pt');
	 }

	 if ($dtencerramento != "")
	 {    
   	   $dtencerramento = $rsresult['dtencerramento'];  
       $dtencerramento = FormataData($dtencerramento,'pt');	 
	 }

	 $dessolicitacao = $rsresult['dessolicitacao'];
	 
	 $dessolicitante = RecUsuarioSol($codsolicitacao);
	 
  }

?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<br>
<br>
 <table width="580" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td width="5">&nbsp;</td>
    <td class="td2" align="center"><strong><b>Solicitação de Serviços Bancários <? if ($acaotriagem != "") echo " - Triagem "; ?></strong></b></td>
  </tr> 
 </table> 
 <br>
  <table width="580" border="0" cellspacing="0" cellpadding="0">
<?
if ($tipoacao != "Incluir")
{
?>
  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Nº da Solicitação</td>
	 <td class="td3">&nbsp;<b><?=$codsolicitacao;?></b></td>
  </tr> 
<?
}
?>  

  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right" width="145"><b>Aberta Por</td>
	<td class="td3">&nbsp;<? echo $dessolicitante;
	              if ($coddelegado != "") 
				    echo "<font color='red'><b> (Delegado)";
	          ?>
	
	</td>
  </tr> 

<? if (($coddelegado != "") || ($tipousuario == "T"))
{
?>
  <tr><td width="3">&nbsp;</td>
    <td class="td4" align="right"><b>Conta corrente do cliente</td>
	<td class="td3"><? if ($coddelegado != "") echo "<br>";?>&nbsp;<input name="numcontacorrentesol" value="<?=$numcontacorrentesol;?>" type="text" id="numcontacorrentesol" size="10" maxlength="15" <? if ($tipoacao=="Editar") echo "readonly style='border:none;'"?> >&nbsp;&nbsp;Exemplo: 9822 (Não digite "-" ou ".") 
	<? if ($coddelegado != "")
	   {
	    echo "<br>&nbsp;Delegado(a) da CrediEmbrapa: informar no campo acima a sua conta &nbsp;corrente, ou a de algum cliente do seu Posto/Núcleo.";	
	   }?>
	</td>
  </tr>

<?
}  ?>
  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Data de Abertura</td>
    <td class="td3">&nbsp;<?=$dtsolicitacao;?>&nbsp;&nbsp;<? if ($hrsolicitacao!="") echo "Hora: ".$hrsolicitacao;?> <br></td>
  </tr>

  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Data de Conclusão</td>
    <td class="td3" >&nbsp;<?  if ($dtconclusao != "")
				    echo $dtconclusao;
	             else echo "Ainda não Concluida.";
			  ?><br></td>
  </tr>

<!--  <tr><td width="3">&nbsp;</td>
    <td class="td4" align="right"><b>Data de Encerramento</td>
    <td class="td3">&nbsp;<?
//                 if ($dtencerramento != "")
	//			    echo $dtencerramento;
	  //           else echo "Ainda não Encerrada.";
	
			  ?><br></td>
  </tr>
-->

  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Tipo de Serviço</td>
	 <td class="td3">&nbsp;<select name="codtiposervsol" id="codtiposervsol" <? if ($tipoacao=="Editar") echo "disabled"?>>
	           <option value="">Selecione</option> 		   
        	  <? 
 		        // Recupera os dados do tipo de serviço
                $sqlString2 = "select s.*, t.destiposol 
				               from tiposervsolicitacao s, tiposolicitacao t 
							   where s.codtiposol = t.codtiposol
							   order by t.destiposol, s.destiposervsol";
                $qrery2 = mysql_query($sqlString2);
				$rsresult2 = mysql_fetch_array($qrery2);		  
			    
				$codtiposol = 0;
			    while (!($rsresult2==0))				
			    { 
				  if ($rsresult2['codtiposol'] != $codtiposol)
				  { 
				    echo "<optgroup label='".$rsresult2['destiposol']."'>";
  				    $codtiposol = $rsresult2['codtiposol'];
				  } 
				?>
				    
       	  	       <option value="<?=$rsresult2['codtiposervsol']?>"  
				                  <? if ($rsresult2['codtiposervsol']== $codtiposervsol)
 								       echo "selected";
								  ?> 
					>				
					
				      <?=$rsresult2['destiposervsol']?>
				   </option>
        	  <? 
			      $rsresult2 = mysql_fetch_array($qrery2);
				  if ($rsresult2['codtiposol'] != $codtiposol)
				    echo "</optgroup>";			  
			     }
			  ?>
             </select>      	  
	 </td>
  </tr> 

  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Detalhes da solicitação<br><br><br><br><br><br></td>
	   <td class="td3">&nbsp;<textarea style='width:415px; height:75px' name='dessolicitacao' 
	                          <? if ($tipoacao=="Editar") 
							       echo "disabled"?>
								><?=$dessolicitacao;?></textarea>
	   </td>
  </tr> 

  <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Técnico responsável</td>

	 <td class="td3">
<? 
if ($codtecnicoresp != "" || $acaotriagem != "")
{
?>	 
&nbsp;<select name="codtecnicoresp" id="codtecnicoresp">
	           <option value="">Selecione</option> 	   
		   
        	  <? 
 		        // Recupera os dados do tecnico
                $sqlstring2 = "select * from tecnicoresp order by nomtecnicoresp";
                $query2 = mysql_query($sqlstring2) or die(mysql_error());			  
			   
			    while($b = mysql_fetch_array($query2))
			    { ?>
       	  	       <option value="<?=$b['codtecnicoresp'];?>" 
				                  <? if ($b['codtecnicoresp'] == $codtecnicoresp)
 								       echo "selected";
								  ?> 
					>
				      <?=$b['nomtecnicoresp'];?>
				   </option>
        	  <? 
			     } 			  
			  ?>
             </select>      	  
<? 
}
else
echo "<font color ='red'><b>&nbsp;Ainda não foi encaminhada para um técnico.</b></font>";
?>
	 </td>	
   
  </tr> 
 
   <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>E-Mail de contato</td>
	   <td class="td3">&nbsp;<input name="desemailcont" value="<?=$desemailcont;?>" type="text" id="desemailcont" size="50" maxlength="60" <? if ($tipoacao=="Editar") echo "readonly style='border:none;'";?>>
	   </td>
  </tr>

   <tr><td width="5">&nbsp;</td>
    <td class="td4" align="right"><b>Telefone de contato</td>
	   <td class="td3">&nbsp;<input name="numtelefonecont" value="<?=$numtelefonecont;?>" type="text" id="numtelefonecont" size="15" maxlength="15" <? if ($tipoacao=="Editar") echo "readonly style='border:none;'"?>>
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
                     <input name="bttipousuario" type="hidden" value="<?=$tipousuario;?>">					 
                     <input name="btcoddelegado" type="hidden" value="<?=$coddelegado;?>">					 					 
	  </td>
	  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" value="Cancelar" onclick="<?=$acaobtcancelar?>"></td>

    </tr>

 </table> 
</form>
<?
}

?>
