<?
include("library/config.php");
include("library/funcoes.php");

$pg = split("/",$_SERVER['PHP_SELF']);
$nomePAG = $pg[count($pg)-1];
if($nomePAG=="")$nomePAG="login.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<iframe src="" id="apoio" name="apoio" frameborder="0" style="width:0px;height:0px"></iframe>
<title>:. HOMEBANKING .:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="site.css" rel="stylesheet" type="text/css">
<script src="scripts.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_0911183413_0)
  {
   return;
  }

  window.mm_menu_0911185018_0 = new Menu("root",213,14,"Verdana, Arial, Helvetica, sans-serif",9,"#003333","#FFFFFF","#F2F2F2","#79A289","left","middle",2,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_0911185018_0.addMenuItem("Extrato Conta Capital","location='extratocontacapital.php'");
  mm_menu_0911185018_0.addMenuItem("Extrato de Aplicações","location='extratoaplicacoes.php'");
  mm_menu_0911185018_0.addMenuItem("Relação de Empréstimos","location='relacaoemprestimos.php'");
  mm_menu_0911185018_0.hideOnMouseOut=true;
  mm_menu_0911185018_0.bgColor='#669999';
  mm_menu_0911185018_0.menuBorder=1;
  mm_menu_0911185018_0.menuLiteBgColor='#669999';
  mm_menu_0911185018_0.menuBorderBgColor='#C4D7CD';

  window.mm_menu_1114152937_0 = new Menu("root",213,14,"Verdana, Arial, Helvetica, sans-serif",9,"#003333","#FFFFFF","#F2F2F2","#79A289","left","middle",2,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1114152937_0.addMenuItem("Alteração&nbsp;de&nbsp;Dados&nbsp;Cadastrais","location='alteracaodedadoscadastrais.php'");
  mm_menu_1114152937_0.hideOnMouseOut=true;
  mm_menu_1114152937_0.bgColor='#669999';
  mm_menu_1114152937_0.menuBorder=1;
  mm_menu_1114152937_0.menuLiteBgColor='#669999';
  mm_menu_1114152937_0.menuBorderBgColor='#C4D7CD';

  window.mm_menu_0911185019_0 = new Menu("root",150,14,"Verdana, Arial, Helvetica, sans-serif",9,"#003333","#FFFFFF","#F2F2F2","#79A289","left","middle",2,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_0911185019_0.addMenuItem("Consultar Solicitação","location='consultasolcliente.php'");
  mm_menu_0911185019_0.addMenuItem("Cadastrar Solicitação","location='solicitacao.php?tipoacao=Incluir'");
  mm_menu_0911185019_0.hideOnMouseOut=true;
  mm_menu_0911185019_0.bgColor='#669999';
  mm_menu_0911185019_0.menuBorder=1;
  mm_menu_0911185019_0.menuLiteBgColor='#669999';
  mm_menu_0911185019_0.menuBorderBgColor='#C4D7CD';
  
  mm_menu_1114152937_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
</head>
<?

  	//includes
		/* Verifica se a seção está aberta */

        if(empty($_SESSION['logado'])){
			/* Habilita como padrão a página Login */
			$nomePAG="login.php";
			/* Valida se o usuário clicou no botão logar */
			if(!empty($_REQUEST['btLogin'])){
				/* Coleta as variáveis do formuláro login*/
				$VtxtContaCorrente = $_POST['txtContaCorrente'];
				$VtxtSenha = $_POST['txtSenha'];
				/* Verifica se os dados passados pelo formulário são do tipo Inteiro */				
				if(is_numeric($VtxtContaCorrente) && is_numeric($VtxtSenha))
                {

                    if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
                    {

                /* Query SQL para verificação dos dados do cliente */
						$SelLogin[0] = "SELECT A.nomcliente, A.codnucleo, A.codcliente, B.numcontacorrente";
						$SelLogin[0].= " FROM cliente A, contacorrente B, senhacliente C";
						$SelLogin[0].= " WHERE A.codcliente=B.codcliente";
						$SelLogin[0].= " AND B.numcontacorrente=".$VtxtContaCorrente;
						$SelLogin[0].= " AND B.codcliente=C.codcliente";
						$SelLogin[0].= " AND C.dessenha='".$VtxtSenha."'";
											                        
						if(VerificaRegistro($SelLogin[0]))
						{

							$SelLogin[1] = mysql_query($SelLogin[0]);
							$ResLogin = mysql_fetch_array($SelLogin[1]);

							/* Variáveis gerais */
                            $_SESSION['numcontacorrente']=$ResLogin['numcontacorrente'];
							$_SESSION['codcliente']=$ResLogin['codcliente'];							
							$_SESSION['nomcliente']=$ResLogin['nomcliente'];
							$_SESSION['codnucleo']=$ResLogin['codnucleo'];							
							$_SESSION['logado'] = 'ok';


                            /* GERA DATA ATUAL*/
                            $datatualacesso = date("Y-m-d", time());

                            /*BUSCA ÚLTIMA DATA DE ACESSO NO BD*/
                            $sql2 = "select * from cliente where codcliente = ".$_SESSION['codcliente'];
                            $result2 = mysql_query($sql2) or die(mysql_error());
                            $dadosresult = mysql_fetch_array($result2);
                            $_SESSION['datultacessocli'] = $dadosresult['datultacesso'];

                            /*CADASTRA ULTIMO ACESSO DO CLIENTE*/
                            $sql = "update cliente set datultacesso = '".$datatualacesso."' where codcliente = ".$_SESSION['codcliente'];

                            $result = mysql_query($sql) or die(mysql_error());

							/* Inclui página inicial */
                            $nomePAG="index.php";

						}
                        else
                        {
							$ValLoginErro="Dados incorretos, tente novamente.";
							
						}
						Conexao($opcao='close');
					}
                    else
                    {

                          $ValLoginErro="Dados incorretos, tente novamente.";
					}
				}
			}
		}

?>



<body background="img/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="259"><a href="index.php"><img src="img/logomarca.jpg" width="284" height="61" border="0"></a></td>
    <td width="511" valign="bottom" background="img/bg_topo.jpg">
      <table width="475" border="0" cellspacing="0" cellpadding="0">
<?
  if ($_SESSION['numcontacorrente'] != "")
  {
?>
        <tr>
          <td width="80"><img src="img/contacorrente2.gif" width="75" height="17"></td>
          <td><font color="#FFFFFF"><?
		  if(!empty($_SESSION['numcontacorrente'])){
		  	echo($_SESSION['numcontacorrente']);
		  }?></font><font color="#FFFFFF"> - <?
		  if(!empty($_SESSION['nomcliente'])){
		  	echo($_SESSION['nomcliente']);
		  }?>
          </font></td>
          <td width="78"><img src="img/ultimo_acesso.jpg" width="75" height="17"> </td>
          <td width="66"><font color="#FFFFFF"><?=FormataData($_SESSION['datultacessocli'],'pt');?></font></td>
        </tr>
<?

  }
?>
    </table></td>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top" background="img/bg_caixapostal.jpg"><img src="img/menubar.jpg" name="image1" border="0" usemap="#Map" id="image1"><map name="Map">
  <area shape="rect" coords="40,4,140,20" href="#" onMouseOver="MM_showMenu(window.mm_menu_0911185019_0,40,20,null,'image1')" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="158,4,198,20" href="#" onMouseOver="MM_showMenu(window.mm_menu_0911185018_0,160,20,null,'image1')" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="210,4,282,20" href="consultacc.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="297,4,412,20" href="emprestimos.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="428,4,568,20" href="cadastracliente.php?tipoacao=Editar" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="583,4,668,20" href="alterarsenhacliente.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="687,4,705,20" href="sair.php" onMouseOver="" onMouseOut="MM_startTimeout();">
</map></td>
  </tr>
  <tr>
    <td width="197" height="34" valign="top" background="img/bg_caixapostal.jpg"><img src="img/topo01.jpg" width="203" height="164" usemap="#Map2" id="image2" border="0"></td>
    <td width="573" valign="top"><img src="img/topo02.jpg" width="567" height="164"></td>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5" valign="top" bgcolor="#FFFFFF"><img src="img/dot_branco.jpg" width="1" height="5"></td>
  </tr>
</table>

<?
  $nomePAGcount = strlen($nomePAG);
  $nomePAGcount = $nomePAGcount - 4;
  $nomePAGaux = substr($nomePAG, 0, $nomePAGcount);
?>

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="267" bgcolor="828916"><img src="img/<?=$nomePAGaux?>.jpg" ></td>
    <td width="380" bgcolor="828916">&nbsp;</td>
    <td width="170" bgcolor="#828916">&nbsp;</td>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
        <BR>

<?
	switch($nomePAG)
	{
		default: include("inc/$nomePAG");
	}

?>
       <BR>
  </td>
    <td width="170" height="132" valign="top" align="right">									
<?
	if ($_SESSION['logado'] != ""){
		
		// Abre conexão com o bd
		$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
		
		$sqlStringAviso = "Select * From aviso where codpainel = 1 and flaativo = 's' order by dataviso desc";
	    $rsqryAviso = mysql_query($sqlStringAviso);
    	$rsavisoadmin = mysql_fetch_array($rsqryAviso);
?>
	   <div style=" background-position:center; background:url(img/atencao.jpg); position: fixed; top:275px; margin-left:0px; left: 330px; height: 130px; width: 170px;" align="left">
	   <table cellspacing="0" border="0">
		  <tr>
		  	<td width="3"></td>
			<td align="justify">
				<p class="style4"><BR><BR><? if ($rsavisoadmin['desaviso']) echo $rsavisoadmin['desaviso']."<BR><b>Postada em </b>(".FormataData($rsavisoadmin['dataviso'],'pt').")";?></p>
			</td>
			<td width="1"></td>
		  </tr>
		</table>
	    
	    
      </div>
	  
<?	
	}else{
?>
	  <div style=" background-position:center;  position: fixed; top:275px; margin-left:0px; left: 330px; height: 130px; width: 170px; text-align:left">
	    <table cellspacing="0" border="0">
		  <tr>
		  	<td width="3"></td>
			<td>
				<p class="style4"><BR><BR>
	    		<b>Faça o Seu LOGIN!</b></p>
			</td>
		  </tr>
		</table>
		
      </div>

<?	
	}

?>				   							
					
	</td>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="img/rodape.gif" width="770" height="63"></td>
  </tr>
</table>




<map name="Map2">  
  <area shape="rect" coords="18,8,49,22" href="http://www.sicoob.com.br" target="new" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="16,26,59,41" href="noticias.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="16,43,78,58" href="faleconosco.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  
</map>

</body>
</html>
