<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 30/11/2005 - Gelson
Sistema: Home Bank
Descrição: Formulário Fale Conosco
************************************************************************************/
	$nomcliente = $_SESSION['nomcliente'];
	$numcontacorrente=$_SESSION['numcontacorrente'];	
?>
<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.emailRemetente.value =='')
  {
    alert('Campo "E-mail" obrigatório.');
    document.form.emailRemetente.focus();
    return false;
  }
  if (document.form.assunto.value =='')
  {
    alert('Campo "Assunto" obrigatório.');
    document.form.assunto.focus();
    return false;
  }
  if (document.form.mensagem.value =='')
  {
    alert('Campo "Mensagem" obrigatório.');
    document.form.mensagem.focus();
    return false;
  }
}
</script>
<?	
	if ($_REQUEST['bttipoacao'] == "enviar"){
		$nomcliente=$_SESSION['nomcliente'];
		$numcontacorrente=$_SESSION['numcontacorrente'];		
		$emailRemetente=$_REQUEST['emailRemetente'];
		$assunto=$_REQUEST['assunto'];
		$mensagem=$_REQUEST['mensagem'];
		
		//ENVIO DE EMAIL PARA SAC
		//CARREGANDO OS DADOS PRINCIPAIS DO CABEÇALHO DO EMAIL
		$source = $emailRemetente;
	
		/*
		//	DIGITE O ENDEREÇO PARA O QUAL DESEJA ENVIAR O EMAIL
		*/
		$target = "sac@crediembrapa.com.br";
	
		/*
		//  ASSUNTO DO EMAIL
		*/	
		$subject = "[CrediEmbrapa - HomeBanking] - Envio de Email da página Fale Conosco";
		
	//Cabeçalho
	$header = "From: $source\n";
	$header .= "Reply-to: $source\n";
	$header .= "Content-Type: $source\n";
	$header .= "X-Mailer: PHP4 Script Language\n";
	$header .= "X-Accept-Language: en\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-Transfer-Encoding: 7bit\n";				 
		 	 
  	$msg = "<table width='570' cellspacing='0' border='0'>
				<tr>
					<td align='justify'>
						<p align='center'><b>Envio de Email</b></p><br>							 						
					</td>
				</tr>
				<tr>
					<td align='justify'>
						<strong>Nome do Cliente:</strong> ".$nomcliente."<br>".						
						"<strong>Conta Corrente:</strong> ".$numcontacorrente."<br>";						
	
	$msg .= "<strong>Data de Envio do Email:</strong> ".date("d-m-Y")."<br>											
						 		 <strong>Assunto:</strong> ".$assunto."<br>
						 	 	 <strong>Mensagem:</strong> ".$mensagem."<br>						 		 					 
					</td>
				</tr>
			</table>						
          ";

  # Corpo da Mensagem e texto e em HTML
  $html = "<table width='570' border='0' cellspacing='0'>
  						<tr>
      						<td>
	      						<img src='../img/titulorelatorio.jpg' width='570' height='67' border='0'>
      						</td>
  						</tr>
		   			   </table>
		    <font color=black>$msg</font>";
  echo "session núcleo: ".$_SESSION['codnucleo'];
  
  //COMANDO DE ENVIO DE EMAIL  
  mail ($target, $subject, $html, $header);
  
  //FIM DA FUNCIONALIDADE DE ENVIO DE EMAIL
  
  echo "<input type='hidden' value='' name='bttipoacao' id='bttipoacao'>";
?>
<br>
 <table width='580' border='1' cellspacing='0' cellpadding='0' class="td1">
  <tr>
    <td width='5'> </td>
    <td class="td2" align='center'><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width='5'> </td>
    <td align='center'><br>Email Enviado com Sucesso!<p> </td>
  </tr>  
 </table>
<?	
	}else{
?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table width="600" border="0">
		<tr >
			<td width="5"></td>
			<td width="90" class="td6" align="right"><strong>Nome</strong></td>
			<td align="left" class="td6"><strong><input type="text" size="50" name="nomcliente" id="nomecliente" value="<?=$nomcliente?>" disabled="disabled"></strong></td>		
		</tr>
		<tr >
			<td width="5"></td>
			<td width="90" class="td6" align="right"><strong>Conta Corrente</strong></td>
			<td class="td6" align="left"><strong><input type="text" size="7" name="numcontacorrente" id="numcontacorrente" value="<?=Formatacc($numcontacorrente)?>" disabled="disabled"></strong></td>		
		</tr>
		<tr >
			<td width="5"></td>
			<td width="90" class="td6" align="right"><strong>Email</strong></td>
			<td class="td6" align="left"><strong><input type="text" size="50" maxlength="40" name="emailRemetente" id="emailRemetente" ></strong></td>		
		</tr>
		<tr >
			<td width="5"></td>
			<td class="td6" width="90" align="right"><strong>Assunto</strong></td>
			<td class="td6" align="left"><strong><input type="text" size="30" maxlength="25" name="assunto" id="assunto" ></strong></td>		
		</tr>
		<tr >
			<td width="5"></td>
			<td class="td6" width="90" align="right"><strong>Mensagem</strong></td>
			<td class="td6" align="left"><textarea name="mensagem" id="mensagem" cols="40" rows="6"></textarea><font size="1px"><strong>Máx. 250 Caracteres</strong></td>		
		</tr>
		<tr >
			<td width="5"></td>
			<td width="90" align="right"></td>
			<td align="right"><input type="submit" value="Enviar" name="submit" id="btenviar"><input type="hidden" value="enviar" name="bttipoacao" id="bttipoacao"></td>		
		</tr>
	</table>
</form>
<?
	}
?>