<?
session_start();
session_unset();
session_destroy();

//abertura de conexão com o BD
Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
?><head>
<title>:. HOMEBANKING .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="site.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
var cl_on = new Array(")","!","@","#","$","%","¨","&","*","(");
var cl_off = new Array("0","1","2","3","4","5","6","7","8","9");
function digita(tecla){
	document.formLogin.txtSenha.value = document.formLogin.txtSenha.value+tecla;
}
function apaga(){
	document.formLogin.txtSenha.value = document.formLogin.txtSenha.value.substring(0,document.formLogin.txtSenha.value.length-1);
}
function maiusculas(){
	if(document.tecladovirtual.cl.value == 1){
		for (var i = 0; i < document.tecladovirtual.elements.length; i++) {
			if (document.tecladovirtual.elements[i].type == "button") {
				var letra = document.tecladovirtual.elements[i].value.toLowerCase()
				document.tecladovirtual.elements[i].value = letra;
			}
		}
		for(var i = 0; i <= 9; i++){
			document.getElementById(i).value = cl_off[i];
		}
		document.tecladovirtual.cl.value = 0;
	}else{
		for (var i = 0; i < document.tecladovirtual.elements.length; i++) {
			if (document.tecladovirtual.elements[i].type == "button") {
				var letra = document.tecladovirtual.elements[i].value.toUpperCase()
				document.tecladovirtual.elements[i].value = letra;
			}
		}
		for(var i = 0; i <= 9; i++){
			document.getElementById(i).value = cl_on[i];
		}
		document.tecladovirtual.cl.value = 1;
	}
}
function alerta(){
	alert('Para digitar sua senha utilize nosso teclado virtual');
	document.formLogin.txtSenha.value = "";
	return false;
}
</script>
<style type="text/css">

.btn {
	font-size:10px;
	font-family:Verdana,Arial Narrow,Arial,Sans-serif;
	background:#FFFFFF;
}
</style>
</head>

<table align="center" id="central">
  <tr>
    <td></td>
	  <td></td>
  </tr>
  
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="771">
  <!-- fwtable fwsrc="index.png" fwbase="____index.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
  <tr>
    <!-- Shim row, height 1. -->
    <td><img src="img2/spacer.gif" width="12" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="205" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="40" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="51" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="3" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="26" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="59" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="5" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="4" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="60" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="46" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="96" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="15" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="64" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="16" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="56" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="12" height="1" border="0" alt="" /></td>
    <td><img src="img2/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
    <!-- row 1 -->
    <td colspan="4"   background="img2/login.gif"><form id="formLogin" name="formLogin" method="post" action="index.php" onsubmit="return ValLogin();"><input type="hidden" name="ava" id="ava" value="<?php echo $_GET['ava'];?>" />
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center"><font color="#A2A251">&nbsp;<b></b></font></td>
          <td rowspan="6">&nbsp;</td>
        </tr>
        <tr class="td2">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="td2">
          <td width="90" align="right"><font color="#F2F8E4">Usuário&nbsp;</font></td>
          <td width="200"><input name="txtContaCorrente" type="text"  id="txtContaCorrente" value="" size="20" maxlength="11" /></td>
        </tr>
        <tr class="td2">
          <td align="right"><font color="#F2F8E4">Senha&nbsp;</font></td>
          <td><input name="txtSenha" type="password" id="txtSenha" value="" size="20" maxlength="15" onfocus="alerta();" onkeypress="alerta();" /></td>
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
    </form></td>
    <td rowspan="4" valign="top"><img src="img2/spacer.gif" width="1" height="1" /></td>
    <td colspan="13" rowspan="3" valign="top" bgcolor="#D6CFD6" style="background-image:url(img2/novidades.gif); background-repeat:no-repeat; background-position:top;">&nbsp;</td>
    <td><img src="img2/spacer.gif" width="1" height="94" border="0" alt="" /></td>
  </tr>
  <tr>
    <!-- row 2 -->
    <td colspan="4" valign="top"><img src="img2/spacer.gif" width="1" height="1" /></td>
    <td><img src="img2/spacer.gif" width="1" height="3" border="0" alt="" /></td>
  </tr>
  <tr>
    <!-- row 3 -->
    <td colspan="4" align="center" background="img2/duvidas.gif"><br />
        <form name="tecladovirtual" id="tecladovirtual" style="visibility:visible;left:150px;">
          <table border="0" cellpadding="0" cellspacing="3" bgcolor="#D4D0C8">
            <tr>
              <td align="right"><input name="1" type="button" id="1" value="1" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="2" type="button" id="2" value="2" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="3" type="button" id="3" value="3" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="4" type="button" id="4" value="4" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="5" type="button" id="5" value="5" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="6" type="button" id="6" value="6" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="7" type="button" id="7" value="7" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="8" type="button" id="8" value="8" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="9" type="button" id="9" value="9" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="0" type="button" id="0" value="0" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
            </tr>
            <tr>
              <td align="right"><input name="q" type="button" id="q" value="q" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="w" type="button" id="w" value="w" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="e" type="button" id="e" value="e" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="r" type="button" id="r" value="r" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="t" type="button" id="t" value="t" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="y" type="button" id="y" value="y" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="u" type="button" id="u" value="u" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="i" type="button" id="i" value="i" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="o" type="button" id="o" value="o" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="p" type="button" id="p" value="p" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
            </tr>
            <tr>
              <td align="right"><input name="a" type="button" id="a" value="a" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="s" type="button" id="s" value="s" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="d" type="button" id="d" value="d" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="f" type="button" id="f" value="f" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="g" type="button" id="g" value="g" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="h" type="button" id="h" value="h" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="j" type="button" id="j" value="j" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="k" type="button" id="k" value="k" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="l" type="button" id="l" value="l" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="ccedil;" type="button" id="ccedil;" value="&ccedil;" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
            </tr>
            <tr>
              <td align="right"><input name="z" type="button" id="z" value="z" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="x" type="button" id="x" value="x" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="c" type="button" id="c" value="c" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="v" type="button" id="v" value="v" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="b" type="button" id="b" value="b" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="n" type="button" id="n" value="n" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td><input name="m" type="button" id="m" value="m" style="width:27px;" class="btn" onclick="digita(this.value)" /></td>
              <td colspan="3"><input name="backspace" type="button" id="backspace" value="&laquo; BackSpace" style="width:100%;" class="btn" onclick="apaga();" /></td>
            </tr>
            <tr>
              <td colspan="3"><input name="capslock" type="button" id="capslock" value="CapsLock" style="width:100%;" class="btn" onclick="maiusculas();" /></td>
              <td colspan="7"><input name="espaco" type="button" id="espaco" value=" " style="width:100%;" class="btn" onclick="digita(this.value)" /></td>
            </tr>
          </table>
          <input name="cl" type="hidden" id="cl" value="0" />
      </form></td>
    <td><img src="img2/spacer.gif" width="1" height="137" border="0" alt="" /></td>
  </tr>
  <tr>
    <!-- row 4 -->
    <td colspan="4" valign="top">&nbsp;</td>
    <td colspan="13" valign="top">&nbsp;</td>
    <td><img src="img2/spacer.gif" width="1" height="25" border="0" alt="" /></td>
  </tr>
  <!--   This table was automatically created with Macromedia Fireworks   -->
  <!--   http://www.macromedia.com   -->
</table>
<br />
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="dedfd0">
    <td colspan="4" bgcolor="#dedfd0"><img src="img/noticias.gif" width="116" height="21" /></td>
  </tr>
  <tr>
    <td width="20"><img src="img/dot_branco.jpg" width="20" height="8" /></td>
    <td width="242">&nbsp;</td>
    <td width="12" rowspan="4" valign="top" background="img/tracado.jpg"><img src="img/tracadoimg.jpg" width="11" height="6" /></td>
    <td width="251">&nbsp;</td>
  </tr>
  <?
  $sql = "select * from noticia where flaativo = 's' order by datcadastro desc";
  $rsquery = mysql_query($sql);
  $dados = mysql_fetch_array($rsquery);
  $i = 1;
  while ($i <= 1){
  ?>
  <tr>
    <td height='41'>&nbsp;</td>
    <td valign='top'><div align='justify'><?php echo $dados['desnoticia'];?></div></td>
    <?php
  $desurl1 = $dados['desurl'];
  $dados = mysql_fetch_array($rsquery);
  ?>
    <td valign='top'><div align='justify'><?php echo $dados['desnoticia'];?></div></td>
  </tr>
  <?php
  $desurl2 = $dados['desurl'];
  $i++;
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right"><a href="http://<? echo $desurl1;?>" target="new"><img src="img/saibamais.jpg" width="67" height="12" border="0"/></a></div></td>
    <td><div align="right"><a href="http://<? echo $desurl2;?>" target="new"><img src="img/saibamais.jpg" width="67" height="12" border="0" /></a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
