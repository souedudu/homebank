<?@session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
// DEBUG 
// ini_set ('display_errors', 'On');
// ini_set ('error_reporting', E_ALL);
$bttipoacao = @$_REQUEST['Submit'];
if(isset($_REQUEST) && count($_REQUEST)) extract($_REQUEST);

include("../library/config.php");
require_once '../Connections/homebank_conecta.php';
require_once "auth.php";
/////////////////////////////////////////////////////
function formataCampo($tipo, $campo)
{
	if($tipo=="CEP"){
		$configuracao = array(2,3);
		$caracteres = array(".","-");
	}
	if($tipo=="TELEFONE"){
		if(strstr($campo, "080"))
		{
			$configuracao = array(4,3);
			$caracteres	= array("-","-");
		}
		else
		{
			$configuracao = array(0,2,4);
			$caracteres = array("(", ")", "-");
		}
	}
	if($tipo=="PROCESSO"){
		$configuracao = array(4,2,1,6);
		$caracteres = array(".",".",".","-");
	}
	if($tipo=="CNPJ"){
		$configuracao = array(2,3,3,4);
		$caracteres = array(".",".","/","-");
	}
	if($tipo=="CPF"){
		$campo = substr($campo, -11);
		$configuracao = array(3,3,3);
		$caracteres = array(".",".","-");
	}

	/////////Executa a configuração
	for($i = 0; $i < count($configuracao); $i++){		
		$newcampo.= substr($campo, 0, $configuracao[$i]).$caracteres[$i];
		$campo = substr($campo, $configuracao[$i]);

		if(($i+1)==count($configuracao))
			$newcampo.=$campo;

	}
	return $newcampo;
}

/////////////////////////////////////////////////////
$teste= explode('/', $_SERVER['PHP_SELF']);
if ($teste[count($teste)-1]!='insert_solicitacao.php'){
	include("../library/funcoes.php");
}else{
	function Conexao($opcao='close',$host='localhost',$user='root',$pass='',$database='homebank'){
		// Se opção=open então abre conexão com o banco
		if($opcao=='open'){
			// Se os dados passados são validos então abre banco.
			if($conex = mysql_connect($host,$user,$pass) or die("Impossivel conectar ao banco de dados")){
				mysql_select_db($database) or die("Banco de dados não encontrado");
				return true;
			}else{
				return false;
			}
		}else{
			// Fecha conexao
			mysql_close();
			return true;
		}
		return false;
	}
	function FormataData($data='',$formato='pt'){
		// Se a data vier vazia, preencher com a atual
		if($data=='')$data=date('d/m/Y');

		switch($formato){
			case 'en':
				// Formato 2005-11-11
				$dia = substr($data,0,2);
				$mes = substr($data,3,2);
				$ano = substr($data,6,4);
				$data = $ano."-".$mes."-".$dia;
				break;
			case 'pt':
				// 2003-11-21 00:00:00
				// Formato 11/11/2005
				$dia = substr($data,8,2);
				$mes = substr($data,5,2);
				$ano = substr($data,0,4);
				$data = $dia."/".$mes."/".$ano;
				break;
		}
		return $data;
	}
	///////////
	//if ($_SERVER['PHP_SELF']=='/homebank2/admin/insert_solicitacao.php'){
	require_once('Sajax.php');
	function busca2($nome, $tipo, $valor=NULL){
		if (empty($valor)) return null;

		include('../Connections/homebank_conecta.php');
		mysql_select_db(conexao_db, $homebank_conecta);
		$query = "SELECT trim(cliente.desemail) as desemail,trim(cliente.numdddtelefone) as numdddtelefone,trim(cliente.numtelefone) as numtelefone FROM `cliente` INNER JOIN contacorrente ON ( cliente.codcliente = contacorrente.codcliente) where contacorrente.numcontacorrente = $valor";
		$result = mysql_query($query,$homebank_conecta)or die("L58: ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$totalregistros = mysql_num_rows($result);
		if($totalregistros>=1){
			$campo = $row['desemail'];
		}
		return $campo;
	}
	function busca3($nome, $tipo, $valor=NULL){
		if (empty($valor)) return null;

		include('../Connections/homebank_conecta.php');
		mysql_select_db(conexao_db, $homebank_conecta);
		$query = "SELECT trim(cliente.desemail) as desemail,trim(cliente.numdddtelefone) as numdddtelefone,trim(cliente.numtelefone) as numtelefone FROM `cliente` INNER JOIN contacorrente ON ( cliente.codcliente = contacorrente.codcliente) where contacorrente.numcontacorrente = $valor";
		$result = mysql_query($query,$homebank_conecta)or die("L58: ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$totalregistros = mysql_num_rows($result);
		if($totalregistros>=1){
			$campo = trim($row['numdddtelefone']).trim($row['numtelefone']);
		}
		return $campo;
	}
	function busca($nome, $tipo, $valor=NULL){
		include('../Connections/homebank_conecta.php');
		mysql_select_db(conexao_db, $homebank_conecta);
		$cond = '';
		if ($tipo == 'CC' and !empty($nome)) 
			$cond = "and contacorrente.numcontacorrente = $nome ";
		else if (!empty($nome))
			$cond = "and trim(cliente.nomcliente) like trim('$nome%') ";
		$query = "SELECT CONCAT(RIGHT(CONCAT('000000',contacorrente.numcontacorrente),6),' - ',cliente.nomcliente) AS cc_nome,contacorrente.numcontacorrente, cliente.codcliente FROM cliente, contacorrente WHERE contacorrente.codcliente=cliente.codcliente $cond
		AND contacorrente.codmodalidadeconta = '01'
		ORDER BY cliente.nomcliente";
		$result = mysql_query($query,$homebank_conecta)or die("L58: ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$totalregistros = mysql_num_rows($result);
		if($totalregistros>=1){
			$campo='<select name="numcontacorrente" id="numcontacorrente" size="5" style="width:450" onchange="mudaPesquisa(\''.$tipo.'\')">';
			do {
				$campo.='<option value="'.$row['numcontacorrente'].'" ';
				if($row['numcontacorrente']==$valor)
					$campo.='SELECTED';
				$campo.='>'.$row['cc_nome'].'</option>';
				
			} while ($row = mysql_fetch_assoc($result));
		}
		$sql = "SELECT id, nome FROM precadastro WHERE IF('".$nome."'='precad', 1, IF('".$nome."'='', 1, nome LIKE '".$nome."%'))";
		$res = mysql_query($sql, $homebank_conecta)or die("L72: ".mysql_error());
		if(mysql_num_rows($res) > 0){
			if($totalregistros==0)
				$campo='<select name="numcontacorrente" id="numcontacorrente" size="5"  style="width:450" onchange="mudaPesquisa(\''.$tipo.'\')">';
			do {
				$campo.='<option value="'.$row['id'].'" ';
				if($row['id']==$valor)
					$campo.='SELECTED';
				$campo.='>PRECAD - '.$row['nome'].'</option>';
				
			} while ($row = mysql_fetch_assoc($res));
		}

		if($totalregistros==0 && mysql_num_rows($res)==0)
			$campo='Nenhum registro encontrado!';
		else
			$campo.='</select>';

		return $campo;
	}

	$sajax_request_type = "POST"; //forma como os dados serao enviados
	$sajax_debug_mode = 0;
	sajax_init(); //inicia o SAJAX
	sajax_export("busca"); // lista de funcoes a ser exportadas
	sajax_export("busca2"); // lista de funcoes a ser exportadas
	sajax_export("busca3"); // lista de funcoes a ser exportadas
	sajax_handle_client_request();// serve instancias de clientes
	//////////
	echo '<script language="JavaScript" type="text/javascript">';
	sajax_show_javascript(); //gera o javascript 
	echo '
	function mudaPesquisa(tipo)
	{
		var indexOption1 = document.getElementById(\'numcontacorrente\').selectedIndex;
		var nome = document.getElementById(\'numcontacorrente\').options[indexOption1].text;
		var valor = document.getElementById(\'numcontacorrente\').options[indexOption1].value;
		document.getElementById(\'tipoc\').value = nome;
		var index = nome.indexOf(\'-\')+2;
		if(tipo==\'CC\')
			document.getElementById(\'nomebusca\').value = valor;
		else
			document.getElementById(\'nomebusca\').value = nome.substring(index);
		document.getElementById(\'valor\').value = valor;
		formbusca();
	}
	function mudacampo(campo) { //esta funcao retorna o valor para o campo do formulario
		document.getElementById("campocccliente").innerHTML = campo;
	}
	function desemailcont(campo) { //esta funcao retorna o valor para o campo do formulario
		document.getElementById("desemailcont").value = campo;
	}
	function numtelefonecont(campo) { //esta funcao retorna o valor para o campo do formulario
		document.getElementById("numtelefonecont").value = campo;
	}

	function formbusca() { //esta funcao chama a funcao PHP exportada pelo Ajax
		document.getElementById("campocccliente").innerHTML = "Aguarde...";
		var vnome, vtipo;
		vnome = document.getElementById("nomebusca").value;
		vtipo = document.getElementById("tipoBusca").value;
		vval = document.getElementById("valor").value;
		//alert(vnome);
		x_busca(vnome, vtipo, vval, mudacampo);
		x_busca2(vnome, vtipo, vval, desemailcont);
		x_busca3(vnome, vtipo, vval, numtelefonecont);

	}
	</script>';
}

////////////////////////////////////////////
$pg = split("/",$_SERVER['PHP_SELF']);
$nomePAG = $pg[count($pg)-1];

//if($nomePAG=="")$nomePAG="login.php";

		/* Verifica se a seção está aberta */
		if(empty($_SESSION['logadoadm'])){

			/* Habilita como padrão a página Login */
			$nomePAG="login.php";
			/* Valida se o usuário clicou no botão logar */
			if(!empty($_REQUEST['btLogin'])){

                /* Coleta as variáveis do formuláro login*/
				$VtxtContaCorrente = $_POST['txtContaCorrente'];
				$VtxtSenha = $_POST['txtSenha'];

				/* Verifica se os dados passados pelo formulário estão vazios */
				if(($VtxtContaCorrente != "") && ($VtxtSenha != ""))
				{

					if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
					{

						/* Query SQL para verificação dos dados do cliente */
						$SelLogin[0] = "SELECT * FROM usuario ".
						               " Where dessenha = '".$VtxtSenha."'".
									   " and desusuario = '".$VtxtContaCorrente."'";

						if(VerificaRegistro($SelLogin[0])){
							$SelLogin[1] = mysql_query($SelLogin[0])or die("L163: ".mysql_error());
							$ResLogin = mysql_fetch_array($SelLogin[1]);

							/* Variáveis gerais */
							$_SESSION['codusuarioadm'] = $ResLogin['codusuario'];
							$_SESSION['codtecnicorespadm'] = $ResLogin['codtecnicoresp'];
							$_SESSION['desusuario'] = strtoupper($ResLogin['desusuario']);
							$_SESSION['flaencerraros'] = $ResLogin['flaencerraros'];							
							$_SESSION['flaconcluiros'] = $ResLogin['flaconcluiros'];
							$_SESSION['ultimo_acesso'] = $ResLogin['dtultimoacesso'];
							$_SESSION['flapercadusu'] = $ResLogin['flapercadusu'];
							$_SESSION['flapercadmenu'] = $ResLogin['flapercadmenu'];
							$_SESSION['ultimo_acesso'] = $ResLogin['dtultimoacesso'];							
							                            
							$dataultacesso = FormataData($_SESSION['ultimo_acesso'],$formato='pt');
							
							$datault = date("Y-m-d");
							
							$_SESSION['ultimo_acesso'] = $datault;
							
							
														
							
							//****Atualiza data de ultimo Acesso do Usuário*******//
							$sqlStringdataultacesso = "update usuario set dtultimoacesso = '".$datault."' where codusuario = ".$_SESSION['codusuarioadm'];																										
	    					$rsqrydataultacesso = mysql_query($sqlStringdataultacesso)or die("L187: ".mysql_error());    						
							


							$_SESSION['logadoadm'] = 'ok';

							/* Inclui página inicial */
							$nomePAG="inicio.php";

							//$nomePAG="login.php";

                        	
							

						}else{
							$ValLoginErro="<b>Dados incorretos, tente novamente.</b>";
						}
						Conexao($opcao='close');
					}
					else
					{
                            $ValLoginErro="<b>Dados incorretos, tente novamente.</b>";
					}
				}
			}
		}

	
		

	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Sistema de OS Sicoob</title>
<meta charset="ISO-8859-1">
<link href="site.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="dist/chosen/chosen.css">

<script src="../scripts.js" type="text/javascript"></script>
<script language="JavaScript" src="../mm_menu.js"></script>
<link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="dist/js/jquery-2.1.1.min.js"></script>
<script src="dist/js/jquery-ui.js"></script>
<script src="dist/js/bootstrap-colorpicker.min.js"></script>
<script src="dist/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function($) {
	    $('select').not('.notchosen').chosen();
  });
</script>
<?
    // Monta Menu
    if(isset($_SESSION['logadoadm']))
      include ("menupopup.php");
?>
<style type="text/css">

.style4 {
	color: #333333;
	font-weight: bold;
}
.style5 {
	color: #FFFFFF;
}

</style>
</head>

<body background="../img/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="284" style="background-image: url('../img/logomarcabkp.jpg');"><a href="index.php"><img src="../img/logomarca.jpg" width="244" height="61" border="0"></a></td>
    <td valign="bottom" background="../img/bg_topo.jpg">
      <table width="854" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="114" height="34" align="right">
		     <? if(!empty($_SESSION['codusuarioadm']))
			   echo "<font color='#FFFFFF'>Usu�rio:&nbsp;";
             ?>
		  </td>
          <td><font color="#FFFFFF"><?
		  if(!empty($_SESSION['codusuarioadm'])){
		  	echo($_SESSION['codusuarioadm']);
		  }?></font><font color="#FFFFFF"> <?
		  if(!empty($_SESSION['desusuario'])){
		  	echo " - ".($_SESSION['desusuario']);
		  }?>
          </font></td>
          <td width="78">
<? 				if(!empty($_SESSION['codusuarioadm'])){
 		          echo "<img src='../img/ultimo_acesso.jpg' width='75' height='17'>";
?> 
		  </td>
          <td width="66"><font color="#FFFFFF"><? echo FormataData($_SESSION['ultimo_acesso'],$formato='pt'); ?></font></td>
        </tr>
<?
					
					}
?>
    </table></td>
  </tr>
</table>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top" background="img/bg_caixapostal.jpg">
<?
if(isset($_SESSION['logadoadm']))
{
?>
<img src="img/menu.jpg" name="image1" width="770" height="24" border="0" usemap="#Map" id="image1" href="Drag to a file to make a link.">
<?
}
else
{
?>
<img src="../img/spacer.gif" width="1" height="1">
<?
}
?></td>
  </tr>
  <tr>
  	<td width="55%" height="34" valign="top" background="img/fundo_novo.jpg">
<?
if(isset($_SESSION['logadoadm']))
{
?>
<img src="img/topo01.jpg" usemap="#Map2" id="image2" width="203" height="113" border="0">    
<?
}
else
	echo "&nbsp;";
?></td>
    <td width="45%" height="113"valign="top" background="img/topo02.jpg">
	<?
	if (@$_SESSION['logadoadm'] != ""){
		
		// Abre conexão com o bd
		$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
		
			$sqlStringAviso = "Select * From aviso where codpainel = 0 and flaativo = 's' order by dataviso desc limit 3";
	    $rsqryAviso = mysql_query($sqlStringAviso)or die("L317: ".mysql_error());
    	$rsavisoadmin = mysql_fetch_array($rsqryAviso);
		?>
     <div style="position: relative; margin-left:307px; top:-10px; width: 239px;" > 
     <?php do { ?>
	    	<? if ($rsavisoadmin['desaviso']) echo "<br><b title='".$rsavisoadmin['desaviso']."'>".substr($rsavisoadmin['desaviso'], 0,20) ."...</b><BR>".FormataData($rsavisoadmin['dataviso'],'pt');?>
      <?php } while ($rsavisoadmin = mysql_fetch_assoc($rsqryAviso)); ?>
      </div>

	
	  
<?	
	}else{
?>
     <div style="position: relative; margin-left:307px; top:-10px; width: 239px;" > 
	    <p class="style4"><br>Efetue o login!</p>
      </div>
<?	
	}
?>	</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="E1EAE5">
  <tr>
    <td height="5" valign="top" bgcolor="#FFFFFF"><img src="../img/dot_branco.jpg" width="1" height="5"></td>
  </tr>
</table>


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
<?
  $nomePAGcount = strlen($nomePAG);
  $nomePAGcount = $nomePAGcount - 4;
  $nomePAGaux = substr($nomePAG, 0, $nomePAGcount);

?>
  
    <td width="267"  bgcolor="E1EAE5" align="left"><img src="img/<?=(is_file($nomePAGaux.".jpg"))?$nomePAGaux:"index"?>.jpg"></td>
    <td align="right" valign="middle" bgcolor="E1EAE5"><form action="ver.php" method="get" name="formlocalizaordem" id="formlocalizaordem">
        <input name="cod" type="text" id="cod" value="Busca R�pida" size="30" onClick="this.value='';">
        <input type="submit" name="Submit" value="OK">
    </form></td>
  </tr>
</table>
	
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr bgcolor="#FFFFFF">
    <td align="center">&nbsp;
        <BR>
		<?
            switch($nomePAG)
            {
							case("inicio.php"):
								@include("inc/index.php");

							default: @include("inc/$nomePAG");
						}
        ?>
		<br>
    </td>	
  </tr>
  <tr>
  	<td height="410" bgcolor="#FFFFFF"></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="../img/rodape.gif" width="100%"></td>
  </tr>
</table>




<?
   
   //Crítica de Acesso ao Menu Cadastrar Usuário
   if (@$_SESSION['flapercadusu'] == "s")
   {
    	$cadastrausuario = "cadastrausuario.php";
   }else{
      $cadastrausuario = "#";
   }
   
   //Crítica de Acesso ao Menu Cadastrar Menu
   if (@$_SESSION['flapercadmenu'] == "s")
   {
    	$cadastramenu = "cadastramenu.php";
   }else{
      $cadastramenu = "#";
   }
   //Crítica de Acesso ao Menu Consultar OS
   if (@$_SESSION['flapercadmenu'] == "s")
   {
    	$cadastramenu = "cadastramenu.php";
   }else{
      $cadastramenu = "#";
   }
   //Crítica de Acesso ao Menu Concluir OS
   if (@$_SESSION['flaconcluiros'] == "s")
   {
    	$concluisolicitacao = "concluisolicitacao.php";
   }else{
      $concluisolicitacao = "";
   }
   
?>
<map name="Map">
<area shape="rect" coords="40,4,155,20" href="listausuarios.php" onMouseOut="MM_startTimeout();">

<area shape="rect" coords="180,3,290,21" href="<?=$cadastramenu?>" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="315,4,380,20" href="#" onMouseOver="MM_showMenu(window.menu_1,283,21,null,'image1')" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="405,5,475,21" href="#" onMouseOver="MM_showMenu(window.menu_2,350,21,null,'image1')" onMouseOut="MM_startTimeout();">

<area shape="rect" coords="495,2,585,21" href="alterarsenha.php" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="610,2,635,19" href="logout.php" onMouseOut="MM_startTimeout();">


</map>
<?
//Crítica de Acesso ao Menu Consultar OS
   if (@$_SESSION['logadoadm'] != "")
   {
   	// Abre conexão com o bd
		$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
		
		$sqlString = "Select * From acessousu where codusuario = ".$_SESSION['codusuarioadm']." and codmenu = 31";
	    $rsqry = mysql_query($sqlString)or die("L436: ".mysql_error());
    	$rs = mysql_fetch_array($rsqry);
		
		if($rs){
			$consultasolcliente = "consultasolcliente.php";		
		}else{
				$consultasolcliente = "";
		}

?>

<map name="Map2">

  <area shape="rect" coords="47,27,136,42" href="<?=auth($_SESSION['codusuarioadm'], 'insert_solicitacao.php')?>" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="46,46,131,61" href="<?=auth($_SESSION['codusuarioadm'], 'consultasolicitacao.php')?>" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="46,63,166,77" href="<?=auth($_SESSION['codusuarioadm'], 'tecnicos_solicitacoes.php')?>" onMouseOut="MM_startTimeout();">
<area shape="rect" coords="46,81,85,95" href="<?=auth($_SESSION['codusuarioadm'], 'solicitatriagem.php')?>" onMouseOut="MM_startTimeout();">
</map>
<?
	}
?>
</body>
</html>
