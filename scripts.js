// JavaScript Document
function ValLogin(){
	var ContaCorrente = document.formLogin.txtContaCorrente;
	var Senha = document.formLogin.txtSenha;
	if(ContaCorrente.value=="" || Senha.value==""){
		ContaCorrente.focus();
		alert('Os campos não podem ficar em branco.');
		return false;
	}
	return true;
}