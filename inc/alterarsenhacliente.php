<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 06/12/2005
Data Atualização: 06/12/2005 - Vitor Hugo
Sistema: Home Bank
Descrição: Alterar Senha de Usuário
************************************************************************************/
?>
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
    background-color:#F7FEE7;
	color:#000000;
	font-weight:bold;
}
.td3{
	background-color:#F7FEE7
}
.td4{
    border:0px solid #606060;
    background-color:#F4F4F4;
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

<script language=javascript>
function VerificaCamposObrigatorios()
{
    if (document.form.dessenha.value =='')
    {
      alert('Campo "Senha" obrigatório.');
      document.form.dessenha.focus();
      return false;
    }
	
    if (document.form.confirmardessenha.value =='')
    {
      alert('Campo "Confirmar Senha" obrigatório.');
      document.form.confirmardessenha.focus();
      return false;
    }
	
	 if (document.form.dessenha.value != document.form.confirmardessenha.value )
    {
      alert('Campo "Senha" tem que ser identico ao campo "Confirmar Senha".');
      document.form.confirmardessenha.focus();
      return false;
    }
}
</script>


<?
if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
{
$codusuario = $_SESSION['codcliente'];

// Grava dados do formulario

if ($bttipoacao != "")
{

  if ($bttipoacao == "Editar")
  {

    $sql = "update senhacliente set dessenha = '".$dessenha."' where codcliente = ".$codcliente;
  //$sql = SQL("usuario", "update", "codtecnicoresp,desusuario,desfuncao,dessenha,flaencerraros,flaconcluiros,flapercadusu","codusuario");
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
    <td align='center'><a href='index.php'>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>

<?
}

}

// Formulário para inclusão ou alteração dos dados
if ($bttipoacao == "" && $_REQUEST['tipoacao'] == "")
{

  if ($codusuario != "")
  {
    $sqlString = "Select c.nomcliente, cc.numcontacorrente, s.dessenha
                  From cliente c, contacorrente cc, senhacliente s
                  where 
				  		c.codcliente = cc.codcliente and 
      					c.codcliente = ".$codcliente." and 
      					c.codcliente = s.codcliente";

    
	$rsqry = mysql_query($sqlString);
    $rscliente = mysql_fetch_array($rsqry);
    
    $numcontacorrente = $rscliente['numcontacorrente'];
  }
 ?>

<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<BR>
 <table width="580" border="0" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b>Alterar Senha</b></strong></td>
  </tr>
</table>
<BR>
<table width="580" class="table"  border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td width="5"></td>
      <td align="right" width="80" class="td3">Nome</td>
      <td class="td4">&nbsp;<input name="desusuario" value="<?=$rscliente['nomcliente'];?>" type="text" id="desusuario" size="60" disabled /></td>
  </tr>
  <tr>
      <td width="5"></td>
      <td align="right" width="80" class="td3">Senha</td>
      <td class="td4">&nbsp;<input name="dessenha" value="<?=$rscliente['dessenha'];?>" type="password" id="dessenha" size="10" maxlength="8" /></td>
  </tr>
   <tr>
      <td width="5"></td>
      <td align="right" width="80" class="td3">Confirmar Senha</td>
      <td class="td4">&nbsp;<input name="confirmardessenha" value="<?=$rscliente['dessenha'];?>" type="password" id="confirmardessenha" size="10" maxlength="8" /></td>
  </tr>
</table>
<table width="580" border="0" class="table" cellspacing="0" cellpadding="0">
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
      <td width="200">&nbsp;</td>
<?
  $tipoacao = "Editar";
?>

      <td  width="80"><input type="submit" name="Submit" value="Gravar">
                     <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
      </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>
  </tr>
</table>
<?

}

?>
