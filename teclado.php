<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="JavaScript" type="text/javascript">
var cl_on = new Array(")","!","@","#","$","%","¨","&","*","(");
var cl_off = new Array("0","1","2","3","4","5","6","7","8","9");
function digita(tecla){
	document.form1.senha.value = document.form1.senha.value+tecla;
}
function apaga(){
	document.form1.senha.value = document.form1.senha.value.substring(0,document.form1.senha.value.length-1);
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
</script>
<style type="text/css">
<!--
.btn {
	font-size:10px;
	font-family:Verdana,Arial Narrow,Arial,Sans-serif;
	background:#FFFFFF;
}
-->
</style>
</head>
<body>
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
</form>
<form name="form1" id="form1">
  <p>
    Recebe:
      <input name="senha" type="text" id="senha" />
</p>
</form>
</body>
</html>
