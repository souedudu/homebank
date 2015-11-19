<?php require_once('Sajax.php'); ?>
<?php
//function busca($cc,$nome){
	include('../../Connections/homebank_conecta.php');
	mysql_select_db($database_conecta, $conecta);
	$query = "SELECT CONCAT(RIGHT(CONCAT('000000',contacorrente.numcontacorrente),6),' - ',cliente.nomcliente) AS cc_nome,contacorrente.numcontacorrente FROM cliente, contacorrente WHERE contacorrente.codcliente=cliente.codcliente
	AND IF('".$cc."' = '',1,contacorrente.numcontacorrente='".$cc."')
	AND IF('".$nome."'='',1,cliente.nomcliente LIKE '%".$nome."%')
	ORDER BY cliente.nomcliente";
	$result = mysql_query($query,$conecta);
	$row = mysql_fetch_assoc($result);
	$campo='<select name="numcontacorrente" id="numcontacorrente">
	    <option value="0">Selecione</option>';
	do {
		$campo.='<option value="'.$row['numcontacorrente'].'">'.$row['cc_nome'].'</option>';
	} while ($row = mysql_fetch_assoc($result));
	$campo.='</select>';
	//return $campo;
	echo $query;
//}
$sajax_request_type = "GET"; //forma como os dados serao enviados
sajax_init(); //inicia o SAJAX
sajax_export("busca"); // lista de funcoes a ser exportadas
sajax_handle_client_request();// serve instancias de clientes
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="JavaScript" type="text/javascript">
///////////////////////////////////////////////////////////
<? sajax_show_javascript(); //gera o javascript ?>
///////////////////////////////////////////////////////////
function mudacampo(campo) { //esta funcao retorna o valor para o campo do formulario
	document.getElementById("campocccliente").innerHTML = "Aguarde...";
	document.getElementById("campocccliente").innerHTML = campo;
}

function formbusca() { //esta funcao chama a funcao PHP exportada pelo Ajax
	var cc, nome;
	cc = document.form1.contacorrente.value;
	nome = document.form1.nome.value;
	x_busca(cc,nome,mudacampo);
}
</script>
                </head>
<body onload="formbusca();">
                <form method="get" name="form1" id="form1">
  <span class="td3">CC
                  <input name="contacorrente" type="text" id="contacorrente" onkeypress="formbusca();" />
                  Nome
                  <input name="nome" type="text" id="nome" onkeypress="formbusca();" />
                  </span>
</form>
                <div id="campocccliente">
  <select name="numcontacorrente" size="5" id="numcontacorrente" >
                  </select>
</div>
                </body>
</html>
