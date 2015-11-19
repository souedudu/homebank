<?
if(isset($_REQUEST['Submit']))
{
	$sql = "SELECT * FROM precadastro WHERE cpfcnpj='".$_REQUEST['cpf']."'";
	$res = mysql_query($sql)or die(mysql_error());
	if(mysql_num_rows($res)>0)
	{
		echo "<script> alert('CPF já existente em nosso banco de dados'); history.go(-1)</script>";
		exit;
	}

	$sql = "INSERT INTO precadastro (cpfcnpj, rg, nome, telefone, email, contacorrente) VALUES ('".$_REQUEST['cpf']."', '".$_REQUEST['rg']."', '".$_REQUEST['nome']."', '".$_REQUEST['telefone']."', '".$_REQUEST['email']."', ".$_REQUEST['contacorrente'].")";
	mysql_query($sql)or die(mysql_error());

	$sql = "INSERT INTO senhaprecad (codcliente, dessenha) VALUES ('".mysql_insert_id()."', '".$_REQUEST['senha']."')";
	mysql_query($sql);

	echo "<script> alert('Cadastro efetuado com sucesso'); document.location.href='index.php' </script>";
}
?>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td width="16%" bgcolor="#F6F6F6"><div align="right"><strong>Conta Corrente: </strong></div></td>
      <td width="84%"><input name="contacorrente" type="text" id="contacorrente"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>CPF/CNPJ:</strong></div></td>
      <td><input name="cpf" type="text" id="cpf"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>Nome:</strong></div></td>
      <td><input name="nome" type="text" id="nome"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>RG.:</strong></div></td>
      <td><input name="rg" type="text" id="rg"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>E-mail:</strong></div></td>
      <td><input name="email" type="text" id="email"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>Telefone:</strong></div></td>
      <td><input name="telefone" type="text" id="telefone"></td>
    </tr>
    <tr>
      <td bgcolor="#F6F6F6"><div align="right"><strong>Senha:</strong></div></td>
      <td><input name="senha" type="password" id="senha" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Cadastrar"></td>
    </tr>
  </table>
</form>
