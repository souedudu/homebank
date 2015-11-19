<?
?><head>
<title>:. Sistema de OS Sicoob .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="site.css" rel="stylesheet" type="text/css">
</head>

<form id="formLogin" name="formLogin" method="post" action="index.php" onsubmit="return ValLogin();">
<table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2" align="center">
                <?
                  if(!empty($ValLoginErro))
                  {
                   echo($ValLoginErro);
                  }
                ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><font color="#A2A251">&nbsp;<b></b></font></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="td2">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr class="td2">
            <td width="90" align="right"><font color="#F2F8E4">Usuário&nbsp;</td>
            <td width="200"><input name="txtContaCorrente" type="text"  id="txtContaCorrente" size="20" maxlength="15" value=""/></td>
        </tr>
        <tr class="td2">
            <td align="right"><font color="#F2F8E4">Senha&nbsp;</td>
            <td><input name="txtSenha" type="password" id="txtSenha" size="12" maxlength="8" value=""/></td>
        </tr>
        <tr class="td2">
            <td>&nbsp;</td>
            <td><input name="btLogin" type="submit" id="btLogin" value="Entrar" /></td>
        </tr>
        <tr class="td2">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
</table>
</form>

