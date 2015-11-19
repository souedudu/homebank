<SCRIPT LANGUAGE=javascript>
// Coloca mascara no orgao emissor
function mascaraorgao(frmcampo)
 {
 var texto = frmcampo.value;

  if (texto.length == 3 ) 
   {
   frmcampo.value = texto +"/";
   }
 }
 
// Coloca mascara no Telefone
function mascaratelefone (i)
 {


 var texto = i.value
//alert(event.keyCode) 
  
if (event.keyCode  == 46 || event.keyCode == 47 ) event.returnValue = false;
  
  if (event.keyCode  < 45 || event.keyCode > 57) event.returnValue = false;

 }

// Coloca mascara no CEP
function mascaracep (i)
 {
 var texto = i.value

	 if (i.value.length > 8)
		 event.returnValue = false;

   //if (event.keyCode  == 47 || event.keyCode == 46) event.returnValue = false;
  
  if (event.keyCode  < 48 || event.keyCode > 57) event.returnValue = false;
    
  if (texto == "." || texto == "/" ) event.returnValue = false;
 
  if (texto.length == 5 ) 
   {
   i.value = texto +"-";
   }
 }


// Coloca mascara na data
function mascaradata (i)
 {
 var texto = i.value
   //if (event.keyCode  == 47 || event.keyCode == 46) event.returnValue = false;
  

  if (i.value.length >= 10)
		 event.returnValue = false;

  if (event.keyCode  < 48 || event.keyCode > 57) event.returnValue = false;
    
  if (texto == "." || texto == "/" ) event.returnValue = false;
 
  if (texto.length == 2 || texto.length == 5 ) 
   {
   i.value = texto +"/";
   }
 }
 
 function formatavalor(i,c)
 {
 var texto = i.value;
 var casas = c;

 
 
 //alert(texto.length);
  if (event.keyCode  < 48 || event.keyCode > 57) event.returnValue = false;
    
  if (texto.length == 2)  {
   i.value = texto + ".";
   }
   
   
 }
 

 // Validação do campo DATA. 
 function validadata (i)
 {    var str = i.value;
 
      if (str == '')
      { return true ; }
      
         // Verifica se foram digitados 10 caracteres.
         if (str.length != 10)
            {
            alert("\nO campo DATA requer 10 dígitos no formato:\n\nDD/MM/AAAA")
            i.focus() ;
            return false;
            }

       // Verifica se os caracteres são números e barra.
         for (var x = 0; x < str.length; x++) 
            {
            var ch = str.substring(x, x + 1);
            if ((ch < "0" || "9" < ch) && ch != "/") 
               {
               alert("\nO campo DATA aceita somente números e um barra no formato:\n\nDD/MM/AA");
            i.focus() ;
            return false;
               }
            }
         // Verifica o valor do dia.
         if ( (str.substring(0, 2) < 1)  ||  (str.substring(0, 2) > 31)  ) 
            {
            alert("\nDia incorreto.");
            i.focus() ;
            return false;
            }
         // Verifica o valor do dia no valor do mês.
            // Fevereiro
               if ( (str.substring(3, 5) == 2 )  &&  (str.substring(0, 2) > 29)  )
                  {
                  alert("\nFevereiro não tem mais que 29 dias.");
				  i.focus() ;
            return false;
                  }
               if ( (str.substring(3, 5) == 2 )  &&  (str.substring(0, 2) == 29)  )
                  { alert("\nVocê entrou com 29 de Fevereiro...\n\nVocê tem certeza de que é ano bissexto?"); }
            // Abril
               if ( (str.substring(3, 5) == 4 )  &&  (str.substring(0, 2) > 30)  )
                  {
                  alert("\nAbril não tem mais que 30 dias.");
				  i.focus() ;
				  return false;
                  }
            // Junho
               if ( (str.substring(3, 5) == 6 )  &&  (str.substring(0, 2) > 30)  )
                  {
                   alert("\nJunho não tem mais que 30 dias..");
				   i.focus() ;
				  return false;
                  }
            // Setembro
               if ( (str.substring(3, 5) == 9 )  &&  (str.substring(0, 2) > 30)  )
                  {
                    alert("\nSetembro não tem mais que 30 dias..");
				    i.focus() ;
				    return false;
                  }
            // Novembro
               if ( (str.substring(3, 5) == 11 )  &&  (str.substring(0, 2) > 30)  )
                  {
                   alert("\nNovembro não tem mais que 30 dias.");
                   i.focus() ;
				   return false;
                  }
         // Verifica o valor do mês.
         if ( (str.substring(3, 5) < 1)  ||  (str.substring(3, 5) > 12)  ) 
            {
            alert("\nMês incorreto.");
            i.focus() ;
            return false;
            }
         // Verifica o valor do ano.
         if ( (str.substring(6, 8) < 1)  ||  (str.substring(6, 8) > 99)  ) 
            {
            alert("\nAno incorreto.");
            i.focus() ;
            return false;
            }
         // Verifica posicionamento da barra.
         if ( str.substring(3, 4) == "/"  || str.substring(4, 5) == "/" ) 
            {
            alert("\nBarra misturada com o mês.");
            i.focus() ;
            return false;
            }
         if ( str.substring(0, 1) == "/"  || str.substring(1, 2) == "/" ) 
            {
            alert("\nBarra misturada com o dia.");
            i.focus() ;
            return false;
            }
         if ( str.substring(6, 7) == "/"  || str.substring(7, 8) == "/" ) 
            {
            alert("\nBarra misturada com o ano.");
            i.focus() ;
            return false;
            }
         if ( str.substring(2, 3) != "/"  ||  str.substring(5, 6) != "/" ) 
            {
            alert("\nBarra misturada com a data.");
            i.focus() ;
            return false;
            }
       
   return true;

 }
 
    function comparadata (i,j,msg){
 		 data1 = i.value;
         data2 = j.value;
		 
		 if(data2=='') {
		  return true;
		 }
		 
         datainicial = data1.substring(6, 10) + data1.substring(3, 5) + data1.substring(0, 2)
         datafinal = data2.substring(6, 10) + data2.substring(3, 5) + data2.substring(0, 2)
		if(datainicial > datafinal){
		   	alert(msg);
			i.focus();
			return false;
		}
     }
  
  function vazio (i,mensagem)
{
str = document.forms[i].elements[i].value;
if ( str == "" )
  {
   alert( "Informe " + mensagem + " !!!" )
   document.forms[0].elements[i].focus() ;
   return false;
  } 
return true;
}
  
// Função que valida o e-mail .
 function validaemail(e)
{   var str = e.value;
  
       if (str == "")
            return true;
       
      
      if (str.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
        return true;
      else{
        alert(str + "\n É um e-mail inválido");
        e.focus() ;
        return false;
        }
}
// Função que Formata Para Numero .
 
 function formatanumero(i)
{   
//alert(event.keyCode)

if ( event.keyCode == 45 || event.keyCode == 46 || event.keyCode == 47) event.returnValue = false;

if (event.keyCode  < 44 || event.keyCode > 57) event.returnValue = false;

}
 
 
 function validacpf (c) {
   var CPF = c.value;
    //alert (CPF)
	if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" ||
		CPF == "22222222222" ||	CPF == "33333333333" || CPF == "44444444444" ||
		CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" ||
		CPF == "88888888888" || CPF == "99999999999")
	{
	    //alert("CPF inválido");
       // c.focus() ;
		return false;
	}
	
	
	soma = 0;
	for (i=0; i < 9; i ++)
		soma += parseInt(CPF.charAt(i)) * (10 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(9)))
			{
	   // alert("CPF inválido");
       // document.forms[0].elements[c].focus() ;
		return false;
	}
	soma = 0;
	for (i = 0; i < 10; i ++)
		soma += parseInt(CPF.charAt(i)) * (11 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(10)))
			{
	   // alert("CPF inválido");
      //  document.forms[0].elements[c].focus() ;
		return false;
	}
	return true;
 }
 
 


function validaextensaoarquivo(arquivo)
{


	Indice = arquivo.value.indexOf(".");
	extensao= arquivo.value.substring(Indice,Indice + 4);

	extensaoValida = ".pdf, .doc, .rtf e .sxw";
	if ((extensao != ".pdf") &&(extensao != ".doc")&&(extensao != ".rtf")&&(extensao != ".sxw")&&(extensao != ".sdw") )
	{	
		alert('Extensão de Arquivo Invalida!!!\nAs extensões válidas são:'+extensaoValida)
		return (false);
    
	}
	else
		return (true);
}



function validanomearquivo(arquivo)
{

   var vObjeto = arquivo.value;
   var lenArquivo = vObjeto.length - 4;// 4 são da estensão

	
   var vCaracter = " ,.çàáèéìíòóùúâêîôûãõ~´`";
   var len = vCaracter.length+1;
   for (var i=1; i<= len-1 ; i++)
    {	  
      var caracter= vCaracter.substring(i,i-1);
      var vResult = vObjeto.indexOf(caracter);

	   if (vResult!='-1')
	   {
	      return(false);
	      break;
	   }
    }
  return(true);
}


function maxtamanho(frmCampo,tot, contagemregressiva) 
	{ 
		total = tot
		tam = frmCampo.value.length;   //  a variavel tam recebe o valor do objeto do form
		str=""; // a variavel str recebe valor ""
		str=str+tam; //  a variavel str recebe o seu valor mais o da variavel tam
		contagemregressiva.value = total - str; // o total tbm
		
				if (tam > total){  // se o tamanho for maior que o total
				aux = frmCampo.value; // a variavel aux recebe o valor do form
				frmCampo.value = aux.substring(0,total); // o script para a digitação dos caracteres
			//	Digitado.innerHTML = total
				contagemregressiva.value = 0 
								} 
								
	}  



	//Função que valida URL
	function validaurl(str) 
	{
	 var frmCampo = str.value;
	 	if (frmCampo == "")
			return true;
			
	  if (frmCampo.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
	  {
        alert("Não é permitido preencher o campo de URL com o Email.");
        return false;
	  }
			
		if (frmCampo.search(/^(file|http):\/\/\S+\.(com|net|org|info|br|gov|pro|kit)$/) != -1)
			return true;
		else
		{
	 		alert(frmCampo+" é invalida.\n Digite o (http://) antes da sua URL.");
	 		return false;
		}
		
 	}
	function nomsobrenome(frmCampo) {
	nome = frmCampo.value;
	if (nome != '') {
		ponto 		= nome.lastIndexOf(' ');
		pontoFinal 	= nome.length;
		sobrenome 	= (nome.substr(ponto,pontoFinal));
		
		if (ponto == -1) {
				return false;
			};
		if (sobrenome == ' '){
				return false;
			};
		};
		return true;
	}
	
	
function testacaracterespecial(Caractervalido,campo)
{
  Alfabeto = Caractervalido;
  lenA = Alfabeto.length;
  len = campo.length;
  for (var i=0; i <= len-1 ; i++) {
	caracter= campo.substring(i,i+1);
	caracter= caracter.toLowerCase();
	   if (Alfabeto.indexOf(caracter,0) == -1) {
	      return true;
	      break;
	   }
  }
  return false;
}
	
	function confirma(texto,linkdestino,pgdestino,opjanela) {
	
		if(confirm(texto)==true) {
		
		window.open(linkdestino,pgdestino,opjanela);
		
		} else {
		
		return false;
		
		}
	
	}
	
	
	
function marcartodos(chkbox,nome,numformulario)
	{
	     
		
		for (var i=0;i < document.forms[numformulario].elements.length;i++) {
		var elemento = document.forms[numformulario].elements[i];
		 if ((elemento.type == "checkbox") && (elemento.name == nome)){
		 elemento.checked = chkbox.checked
		 }
	        }
	     

}
	
</SCRIPT>
