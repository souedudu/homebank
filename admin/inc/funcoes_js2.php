<script>

//funcao de redirecionamento
function redireciona(pag){
	document.location.href=pag;
	}
	
// formata valor 0.00
function formataValor(campo,tammax,teclapres) {
	//exemplo FormataValor("saldo",13,event)
	//campo definido em id
	var tecla = teclapres.keyCode;	
	vr = document.getElementById(campo).value;
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

	if (tecla == 8 ){	tam = tam - 1 ; }
		
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= 2 ){ 
	 		document.getElementById(campo).value = vr ; }
	 	if ( (tam > 2) && (tam <= 5) ){
	 		document.getElementById(campo).value = vr.substr( 0, tam - 2 ) + '.' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 6) && (tam <= 8) ){
	 		document.getElementById(campo).value = vr.substr( 0, tam - 5 ) + '' + vr.substr( tam - 5, 3 ) + '.' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 9) && (tam <= 11) ){
	 		document.getElementById(campo).value = vr.substr( 0, tam - 8 ) + '' + vr.substr( tam - 8, 3 ) + '' + vr.substr( tam - 5, 3 ) + '' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 12) && (tam <= 14) ){
	 		document.getElementById(campo).value = vr.substr( 0, tam - 11 ) + '' + vr.substr( tam - 11, 3 ) + '' + vr.substr( tam - 8, 3 ) + '' + vr.substr( tam - 5, 3 ) + '.' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 15) && (tam <= 17) ){
	 		document.getElementById(campo).value = vr.substr( 0, tam - 14 ) + '' + vr.substr( tam - 14, 3 ) + '' + vr.substr( tam - 11, 3 ) + '' + vr.substr( tam - 8, 3 ) + '' + vr.substr( tam - 5, 3 ) + '.' + vr.substr( tam - 2, tam ) ;}
	}
		

}

//funcao para mostrar caixa de atualizando ou com o texto necessário
function atualizando(texto){
	
	d =document.getElementById("atualizando").style.display;
	w = (screen.width/2)-75;
	h = 200;
	document.getElementById("atualizando").innerHTML = texto;
	document.getElementById("atualizando").style.top=h+"px";
	document.getElementById("atualizando").style.left=w+"px";	
	if(d=="none")
		document.getElementById("atualizando").style.display="";
	else	
		document.getElementById("atualizando").style.display="none";
}


function semvalor(campo,valor){			
	if(valor){
		document.getElementById(campo).value = "0";
		document.getElementById(campo).readOnly = true;
	}else{
		document.getElementById(campo).value = "0";
		document.getElementById(campo).readOnly = false;
	}

}

// funcao para limitar tamanho de textarea
function limite(maximo,campo_id,container){
	valor = document.getElementById(campo_id).value
	if(valor.length>maximo){
		document.getElementById(campo_id).value = valor.substring(0,maximo);
	}
	document.getElementById(container).innerHTML =  " "+document.getElementById(campo_id).value.length+" ";
}

function numeros(id,dbl){
	strCampo = document.getElementById(id);
	vr = strCampo.value;
	texto = "";
	for(n=0;n<vr.length;n++){						
		ch = vr.charCodeAt(n);
		if(dbl){
			if((ch>47 && ch < 58) || ch==46) texto += vr.charAt(n);
		}else{
			if(ch>47 && ch < 58) texto += vr.charAt(n);
		}
		
	}
	strCampo.value = texto;
	
}

function maskdata(campo,k){

	tecla = k.keyCode;
	//eval("strCampo = document.form1."+campo);
	strCampo = document.getElementById(campo);
	vr = strCampo.value;
	tamanhoMaximo = 8;

	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	vr = vr.replace("/","");
	tam = vr.length;

	if(tam < tamanhoMaximo && tecla != 8 ){
	tam = vr.length + 1;
	}

	if(tecla == 8){
	tam = vr.length -1;
	}

	if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105){
		if(tam <=2 ) strCampo.value = vr;
		if(tam > 2 && tam <4) strCampo.value = vr.substr(0,2) + "/" + vr.substr(2,tam);
		if(tam >= 4 ) strCampo.value = vr.substr(0,2) + "/" + vr.substr(2,2) + "/" + vr.substr(4,tam);
	}
	
}
function userName(id){
	x = document.getElementById(id).value;
	tam = x.length;
faltam = 7 - tam;
var zeros = "";
if (tam<7) {
	for (var i =0; i< faltam; i++) {
		zeros += "0";
	}
	novo = zeros + x;
	document.getElementById(id).value = novo;
}
}

function verifica(fm){
	// verifica(formulario,'nome do campo','nome do campo',...)	
	eval("fm=document."+fm+";");
	args = arguments.length;
	cancela = false;
	for(a=0;a<fm.length;a++){
		pula = false;
		for(b=1;b<args;b++){
			
			if(fm.elements[a].name ==arguments[b]) pula = true;
		}
		if(!pula){
			if(trim(fm.elements[a].value)==""){
				cancela = true;				
				fm.elements[a].style.border="1px solid red";
				fm.elements[a].style.backgroundColor = "#FEE8E7";
			}else{
				fm.elements[a].style.border="1px solid black";
				fm.elements[a].style.backgroundColor = "transparent";
			}
		}
	}
	
	if(cancela){
		alert("Preencha os campos marcados com a borda vermelha");
	}else{
		fm.submit();
	}
}

//##########################################################3

function verEmail(email1,email2){
	eval("e1="+email1+";");
	eval("e2="+email2+";");
	vr1 = e1.value;
	vr2 = e2.value;
	if(vr1!=""){
		if(vr1==vr2){
			alert("O E-mail(2) deve ser diferente do E-mail(1).\n Caso não possua mais de um e-mail deixar o campo Email(2) vazio");
			e1.value = "";
			e1.focus();
		}
	}
	
	
}

function trim(s) {
  while (s.substring(0,1) == ' ') {
    s = s.substring(1,s.length);
  }
  while (s.substring(s.length-1,s.length) == ' ') {
    s = s.substring(0,s.length-1);
  }
  return s;
}

	
//funcao para mostrar caixa de atualizando ou com o texto necessário
function atualizando(texto){
	
	d =document.getElementById("atualizando").style.display;
	w = (screen.width/2)-75;
	h = 200;
	document.getElementById("atualizando").innerHTML = texto;
	document.getElementById("atualizando").style.top=h+"px";
	document.getElementById("atualizando").style.left=w+"px";	
	if(d=="none")
		document.getElementById("atualizando").style.display="";
	else	
		document.getElementById("atualizando").style.display="none";
}


//FUNCOES AJAX

//PRIVATE
// função criando o objeto e enviando a requisição
function xmlrequest(url,div){

	req = null;
	dv = div
	if(window.ActiveXObject){
    //IE
		req = new ActiveXObject("MSXML2.XMLHTTP");
		if(req){
			req.onreadystatechange = escreve;
			req.open("POST",url,true);
			req.send();
		}
	}else if(window.XMLHttpRequest){
    //mozilla 
		req = new XMLHttpRequest(); //incializa objeto
		req.onreadystatechange = escreve; //chama funcao para escrever
		req.open("POST",url,true); //chama pagina para pegar dados
		req.send(null);	//faz requisicao
		
	}
}

//private
// função chamada pela xmlrequest
// recebe os valores e escreve no html
x = 1
function escreve(){
	if(req.readyState ==4){//caso status seja "completado"
		top.document.getElementById(dv).innerHTML = req.statusText;
		if(req.status==200){ //caso o servidor retornar OK
			top.document.getElementById(dv).innerHTML = req.responseText;			
		}else{
			top.document.getElementById(dv).innerHMTL = req.status;
		}
	}
		
}

//funcao que chama o ajax
function ajax(url,div){
	req = null;
	xmlrequest(url,div);	
	
}

//votacao da enquete
function vota(id){
	resposta = document.getElementById('enquete_id'+id).value;
	ajax("inc/enquete.php?ajax=true&funcao=vota&resposta="+resposta+"&id="+id,"divEnq"+id);
}

//verifica formulario de enquete
function verifica_enquete(id,obrigatorio){	
	erro = "";
	eval("form =  document.formenq"+id+";");
	if(obrigatorio){
	
		if(form.nome.value=="") erro += "O nome é de preenchimento obrigatório\n";
		if(form.email.value=="") erro += "O e-mail é de preenchimento obrigatório\n";
		if(form.telefone.value=="") erro += "O telefone é de preenchimento obrigatório\n";		
		if(erro) {
			erro = "Houve erro(s) ao enviar o formulário:\n"+erro;
			envia = false;
			alert(erro);
		}else			
			envia = true;
	}else{
		envia = true;
	}
	
	if(envia){
		ajax("inc/enquete.php?ajax=true&funcao=grava&nome="+form.nome.value+"&email="+form.email.value+"&telefone="+form.telefone.value+"&enquete_item_id="+form.resposta.value+"&enquete_id="+id,"divEnq"+id);		
	}
	
}
	



// FIM DA FUNCAO AJAX

</script>










