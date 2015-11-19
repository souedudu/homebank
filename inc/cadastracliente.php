<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 06/12/2005
Data Atualização: 06/12/2005 - Vitor Hugo
Sistema: Home Bank
Descrição: Cadastra de Usuário
************************************************************************************/
include "funcoes_js.php";
$escondercampo = " readonly style='border:none;' ";

if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
{

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
    if (document.form.codtipocliente.value =='')
    {
      alert('Campo "Tipo de Cliente" obrigatório.');
      document.form.codtipocliente.focus();
      return false;
    }
	
    if (document.form.nomcliente.value =='')
    {
      alert('Campo "Nome" obrigatório.');
      document.form.nomcliente.focus();
      return false;
    }
	
    if (document.form.flasexo.value =='')
    {
      alert('Campo "Sexo" obrigatório.');
      document.form.flasexo.focus();
      return false;
    }
	
    if (document.form.numcpfcnpj.value =='')
    {
      alert('Campo "CPF/CNPJ" obrigatório.');
      document.form.numcpfcnpj.focus();
      return false;
    }
	
	if (validacpf(document.form.numcpfcnpj)==false)
    {
      alert('Campo "CPF/CNPJ" Inválido.');
      document.form.numcpfcnpj.focus();
      return false;
    }			
	
    if (document.form.datnascimento.value =='')
    {
      alert('Campo "Data de Nascimento" obrigatório.');
      document.form.datnascimento.focus();
      return false;
    }
	
    if (document.form.codestadocivil.value =='')
    {
      alert('Campo "Estado Civil" obrigatório.');
      document.form.codestadocivil.focus();
      return false;
    }	
	
    if (document.form.desendereco.value =='')
    {
      alert('Campo "Endereço" obrigatório.');
      document.form.desendereco.focus();
      return false;
    }
	
    if (document.form.desbairro.value =='')
    {
      alert('Campo "Bairro" obrigatório.');
      document.form.desbairro.focus();
      return false;
    }
	
    if (document.form.descidade.value =='')
    {
      alert('Campo "Cidade" obrigatório.');
      document.form.descidade.focus();
      return false;
    }
	
    if (document.form.coduf.value =='')
    {
      alert('Campo "UF" obrigatório.');
      document.form.coduf.focus();
      return false;
    }			
			
}
</script>

<?
// Grava dados do formulario

if ($bttipoacao != "")
{

  $datnascimento = substr($datnascimento,6,4) . "/" .substr($datnascimento,3,2) . "/" . substr($datnascimento,0,2);
  $datemissaorg = substr($datemissaorg,6,4) . "/" .substr($datemissaorg,3,2) . "/" . substr($datemissaorg,0,2);

/*  if ($bttipoacao == "Incluir")
  {
	$sql = "insert into cliente (codtipocliente,numcpfcnpj,nomcliente,flasexo,datnascimento,numrg,desorgaoexprg,'codufrg',
                                 'datemissaorg','codestadocivil','desendereco','numendereco','descompendereco','numcep',
                                 'desbairro','descidade','coduf','numdddtelefone','numtelefone','numramaltelefone',
                                 'numtelefonecel','codmatricula','desemail','codnucleo')".
            "values ".
		            "('".$codtecnicoresp."', '".$numcpfcnpj."', '".$nomcliente."', '".$flasexo."', '".$datnascimento."',
                      '".$flaconumrgncluiros."', '".$desorgaoexprg."', '".$codufrg."', '".$datemissaorg."', '".$codestadocivil."',
                      '".$desendereco."', '".$numendereco."','".$numendereco."')";

    mysql_query($sql) or die(mysql_error());
    $codusuario = mysql_insert_id();


  }
*/

 if ($bttipoacao == "Editar")
  {
	
	//ENVIO DE EMAIL
	//CARREGANDO OS DADOS PRINCIPAIS DO CABEÇALHO DO EMAIL
	$source = $desemail;
	
	/*
	//	DIGITE O ENDEREÇO PARA O QUAL DESEJA ENVIAR O EMAIL
	*/
	$target = "sac@crediembrapa.com.br";
	
	/*
	//  ASSUNTO DO EMAIL
	*/
	$subject = "[CrediEmbrapa - HomeBanking] - Alteração de Registro de Cliente.";
		
	//Cabeçalho
	$header = "From: $source\n";
	$header .= "Reply-to: $source\n";
	$header .= "Content-Type: $source\n";
	$header .= "X-Mailer: PHP4 Script Language\n";
	$header .= "X-Accept-Language: en\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-Transfer-Encoding: 7bit\n";
		

  	$msg = "<table width='100%' cellspacing='0' border='0'>
				<tr>
					<td align='justify'>
						<p align='center'><b>Informação de Alteração de Registro!</b></p><br>
          					Informamos que o Cliente <b><font color='red'>".$_SESSION['nomcliente']."</font></b> da Conta <b><font color='red'>".$_SESSION['numcontacorrente']."</font></b> Alterou seu Cadastro.<BR>
							Segue os dados:						
					</td>
				</tr>
				<tr>
					<td align='justify'>
						<strong>Endereço:</strong> $desendereco<br>
						<strong>Numero Endereço:</strong> $numendereco<br>
						<strong>Complemento do Endereço:</strong> $descompendereco<br>
						<strong>CEP:</strong> $numcep<br>
						<strong>Bairro:</strong> $desbairro<br>
						<strong>Cidade:</strong> $descidade<br>
						<strong>UF:</strong> $coduf<br>
						<strong>Telefone:</strong> $numdddtelefone - $numtelefone<br>
						<strong>Ramal:</strong> $numramaltelefone<br>
						<strong>Celular:</strong> $numtelefonecel<br>
						<strong>E-mail:</strong> $desemail
					</td>
				</tr>
			</table>
						
          ";

  # Corpo da Mensagem e texto e em HTML
  $html = "<HTML><BODY><font color=black>$msg</font></BODY></HTML>";
  
  //COMANDO DE ENVIO DE EMAIL
  mail ($target, $subject, $html, $header);
  
  //FIM DA FUNCIONALIDADE DE ENVIO DE EMAIL
  
  $sql = "update cliente set ".
//		   "codtipocliente='".$codtipocliente."', numcpfcnpj='".$numcpfcnpj.
//		   "', nomcliente='".$nomcliente."', flasexo='".$flasexo.
//		   "', datnascimento='".$datnascimento."', numrg='".$numrg.
//		   "', desorgaoexprg='".$desorgaoexprg."', codufrg='".$codufrg.
//		   "', datemissaorg='".$datemissaorg."', codestadocivil='".$codestadocivil."', ".
		   "desendereco='".$desendereco."', numendereco='".$numendereco.
		   "', descompendereco='".$descompendereco."', numcep='".$numcep.
		   "', desbairro='".$desbairro."', descidade='".$descidade.
		   "', coduf='".$coduf."', numdddtelefone='".$numdddtelefone.
		   "', numtelefone='".$numtelefone."', numramaltelefone='".$numramaltelefone.
		   "', numtelefonecel='".$numtelefonecel."', numramaltelefone='".$numramaltelefone.
		   "', numtelefone='".$numtelefone.
//		   "', codmatricula='".$codmatricula.		   		   
		   "', desemail='".$desemail.
//		   "', codnucleo=".$codnucleo.		   		   		   		   
		   "' where codcliente = ".$codcliente;

	mysql_query($sql) or die(mysql_error());
  }

?>

 <table width='580' border=1 class="table" cellspacing='0' cellpadding='0'>
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
    <td align='center' class="td4"><br>Dados atualizado com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='<?=$onref;?>'>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>

<?
}

}


// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{
  if ($_SESSION['codcliente'] != "")
  {
     $codcliente = $_SESSION['codcliente'];
	 $onref = "/crediembrapa/homebanking/site";
  }

  if ($_SESSION['codtecnicorespadm'] != "")
  {
	 $onref = "/crediembrapa/homebanking/site/admin";	 
  }
  
  if ($codcliente != "")
  {
    $sqlString = "Select * From cliente where codcliente = ".$codcliente;
    $rsqry = mysql_query($sqlString);
    $rscliente = mysql_fetch_array($rsqry);
	
	
	 // Se não encontrou a solicitação volta para a pagina inicial
	 if ($rscliente==0)
       echo "<script>document.location.href='index.php';</script>"; 	
	   
	 if ($rscliente['datnascimento'] != "")
  	   $datnascimento = FormataData($rscliente['datnascimento'],'pt');  
	   
	 if ($rscliente['datemissaorg'] != "")
  	   $datemissaorg = FormataData($rscliente['datemissaorg'],'pt');  

     $codmatricula = $rscliente['codmatricula'];
	 if ($codmatricula == "0")
  	   $codmatricula = "";  

	 if ($rscliente['numcpfcnpj'] != "")
  	   $numcpfcnpj = +$rscliente['numcpfcnpj']; 

	 if ($rscliente['numrg'] != "")
  	   $numrg = +$rscliente['numrg']; 

	 if ($rscliente['codnucleo'] != "")
  	   $codnucleo = +$rscliente['codnucleo']; 

	 if ($rscliente['numramaltelefone'] != "")
  	   $numramaltelefone = +$rscliente['numramaltelefone']; 
	   
	 if ($rscliente['numdddtelefone'] != "")
  	   $numdddtelefone = +$rscliente['numdddtelefone']; 	   
	   
	   
  }
 ?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<BR>
<?
if ($tipoacao=="Incluir")
{
?>
 <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b><?=$tipoacao;?> Cliente </b></strong></td>
  </tr>
</table>
<BR>
<?
}
?>
<table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Nome</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" size="60" value="<?=$rscliente['nomcliente'];?>" mxlength="100" name="nomcliente" id="nomcliente"></td>
	 <td width="275" class="td4">&nbsp;</td>
  </tr>
<?
if ($tipoacao=="Incluir")
{
?>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Senha</td>
     <td class="td4">&nbsp;<input name="dessenha" value="<?=$rscliente['dessenha'];?>" type="password" id="dessenha" size="8" maxlength="8" /></td>
     <td width="275" class="td4">&nbsp;</td>
  </tr>
<?
}
?>  
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">CPF/CNPJ</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" size="20" value="<?=$numcpfcnpj;?>" maxlength="14" name="numcpfcnpj" id="numcpfcnpj"></td>
	 <td width="275" class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Tipo de Cliente</td>
	 <td class="td4">&nbsp;
<?	 
 	switch($rscliente['codtipocliente'])
	{
		case 1: 
  		   echo "Pessoa Jurídica";
		   break;
		case 0: 
		   echo "Pessoa Física";
		   break;	   
	}
?>	
<!--	 
	 <select  name="codtipocliente" id="codtipocliente">
                                   <option value="">Escolha a opção</option>
                                   <option value="1" <? if ($rscliente['codtipocliente']==1)
 								       echo "selected";
								   ?>>Pessoa Jurídica</option>
                                   <option value="0" <? if ($rscliente['codtipocliente']==0)
 								       echo "selected";
								   ?>>Pessoa Física</option>
                           </select>
-->						   
     </td>
     <td width="275" class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Sexo</td>
	 <td class="td4">&nbsp;
<?	 
 	switch($rscliente['flasexo'])
	{
		case 0: 
  		   echo "Feminino";
		   break;
		case 1: 
		   echo "Masculino";
		   break;	   
	}
?>	 
	 
<!--	 <select  name="flasexo" id="flasexo">
                 <option value="">Escolha a opção</option>
                 <option value="0" <? if ($rscliente['flasexo']=="0")
 								       echo "selected";
								   ?>>Feminino</option>
                 <option value="1" <? if ($rscliente['flasexo']=="1")
 								       echo "selected";
								   ?>>Masculino</option>
         </select>
-->		 
     </td>
     <td width="275" class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Data de Nascimento</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" value="<?=$datnascimento;?>"  size="15" maxlenght="10" name="datnascimento" id="datnascimento" onkeypress="mascaradata(document.form.datnascimento)"></td>
	 <td width="275" class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">RG</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" value="<?=$numrg;?>" size="16" maxlength="15" name="numrg" id="numrg"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200"  class="td3">Orgão Emissor</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" value="<?=$rscliente['desorgaoexprg'];?>" size="11" maxlength="10" name="desorgaoexprg" id="desorgaoexprg">&nbsp;&nbsp;
	                       UF&nbsp;<input <?=$escondercampo?> type="text" value="<?=$rscliente['codufrg'];?>" name="codufrg" id="codufrg" size="2" maxlength="2"></td>
	 <td class="td4">&nbsp;</td>
     
  </tr>

  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Data de Emissão</td>
	 <td class="td4">&nbsp;<input <?=$escondercampo?> type="text" value="<?=$datemissaorg;?>" size="15" maxlength="10" name="datemissaorg" id="datemissaorg" onkeypress="mascaradata(document.form.datemissaorg)"></td>
	 <td width="275" class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Estado Civil</td>
	 <td class="td4">&nbsp;
<?	 
 	switch($rscliente['codestadocivil'])
	{
		case 1: 
  		   echo "Solteiro(a)";
		   break;
		case 2: 
		   echo "Casado(a)";
		   break;	   
		case 3: 
		    echo "Viúvo(a)";
			break;
		case 4: 
		    echo "Desquitado(a)";
			break;
		case 5: 
 		    echo "Divorciado(a)";
			break;
		case 6: 
		   echo "Separado(a)";				
		   break;
		case 7: 
		   echo "Outro(a)";				
		   break;

	}
?>	 
<!--	 <select  name="codestadocivil" id="codestadocivil">
                 <option value="">Escolha a opção</option>
                 <option value="1" <? if ($rscliente['codestadocivil']=="1")
 								       echo "selected";
								   ?>>Solteiro(a)</option>
                 <option value="2" <? if ($rscliente['codestadocivil']=="2")
 								       echo "selected";
								   ?>>Casado(a)</option>
                 <option value="3" <? if ($rscliente['codestadocivil']=="3")
 								       echo "selected";
								   ?>>Viúvo(a)</option>
                 <option value="4" <? if ($rscliente['codestadocivil']=="4")
 								       echo "selected";
								   ?>>Desquitado(a)</option>
                 <option value="5" <? if ($rscliente['codestadocivil']=="5")
 								       echo "selected";
								   ?>>Divorciado(a)</option>
                 <option value="6" <? if ($rscliente['codestadocivil']=="6")
 								       echo "selected";
								   ?>>Separado(a)</option>
                 <option value="7" <? if ($rscliente['codestadocivil']=="7")
 								       echo "selected";
								   ?>>Outro(a)</option>
								   
         </select>
--> 
     </td>
     <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Endereço</td>
	 <td class="td4">&nbsp;<input type="text" name="desendereco" id="desendereco"  value="<?=$rscliente['desendereco'];?>" size="60" maxlength="80" ></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Numero Endereço</td>
	 <td class="td4">&nbsp;<input type="text" name="numendereco" id="numendereco" value="<?=$rscliente['numendereco'];?>" size="7" maxlength="7"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Complemento do Endereço</td>
	 <td class="td4">&nbsp;<input type="text" name="descompendereco" id="descompendereco" value="<?=$rscliente['descompendereco'];?>" size="30" maxlength="30"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">CEP</td>
	 <td class="td4">&nbsp;<input type="text" name="numcep" id="numcep" value="<?=$rscliente['numcep'];?>" size="11" maxlength="11"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Bairro</td>
	 <td class="td4">&nbsp;<input type="text" name="desbairro" id="desbairro" value="<?=$rscliente['desbairro'];?>" size="40" maxlength="60"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Cidade</td>
	 <td class="td4">&nbsp;<input type="text" name="descidade" id="descidade" value="<?=$rscliente['descidade'];?>" size="60" maxlength="80"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">UF</td>
	 <td class="td4">&nbsp;<input type="text" name="coduf" id="coduf" value="<?=$rscliente['coduf'];?>" size="2" maxlength="2"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Telefone</td>
	 <td class="td4">&nbsp;<input type="text" size="2" maxlength="2" name="numdddtelefone" id="numdddtelefone" value="<?=$numdddtelefone;?>" >&nbsp;-&nbsp;<input type="text" name="numtelefone" id="numtelefone" value="<?=$rscliente['numtelefone'];?>" size="15" maxlength="15"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Ramal</td>
	 <td class="td4">&nbsp;<input type="text" name="numramaltelefone" id="numramaltelefone" value="<?=$numramaltelefone;?>" size="4" maxlength="4"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Celular</td>
	 <td class="td4">&nbsp;<input type="text" name="numtelefonecel" id="numtelefonecel" value="<?=$rscliente['numtelefonecel'];?>" size="15" maxlength="15"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Matrícula</td>
	 <td class="td4">&nbsp;<input type="text" <?=$escondercampo?> name="codmatricula" id="codmatricula" value="<?=$codmatricula?>" size="20" maxlength="20"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">E-mail</td>
	 <td class="td4">&nbsp;<input type="text" name="desemail" id="desemail" value="<?=$rscliente['desemail'];?>" size="60" maxlength="60"></td>
	 <td class="td4">&nbsp;</td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Núcleo</td>
	 <td class="td4">&nbsp;<input type="text" <?=$escondercampo?> name="codnucleo" id="codnucleo" value="<?=$codnucleo;?>" size="3" maxlength="5"></td>
	 <td class="td4">&nbsp;</td>
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
