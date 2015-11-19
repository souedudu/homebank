<?
include("library/config.php");
include("library/funcoes.php");

$pg = split("/",$_SERVER['PHP_SELF']);
$nomePAG = $pg[count($pg)-1];
if($nomePAG=="")$nomePAG="login.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- saved from url=(0014)about:internet -->
<html>
<head>
<link href="site.css" rel="stylesheet" type="text/css">
<title>CrediEmbrapa - Homebanking</title>
<meta http-equiv="Content-Type" content="text/html;">
<meta name="description" content="FW 8 DW 8 HTML">
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
  mm_menu_0911185019_0.addMenuItem("Avaliação de qualidade","location='avaliacao.php'");
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
<!--Fireworks 8 Dreamweaver 8 target.  Created Wed Jul 12 14:19:54 GMT-0300 (Hora oficial do Brasil) 2006-->
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

						$sql = "SELECT precadastro.contacorrente AS numcontacorrente, precadastro.id AS codcliente, precadastro.nome AS nomcliente FROM precadastro LEFT OUTER JOIN senhaprecad ON precadastro.id = senhaprecad.codcliente WHERE precadastro.contacorrente='".$VtxtContaCorrente."' AND senhaprecad.dessenha='".$VtxtSenha."'";

						if(VerificaRegistro($SelLogin[0]) || VerificaRegistro($sql))
						{

							$SelLogin[1] = mysql_query($SelLogin[0]);
							if(mysql_num_rows($SelLogin[1])==0)
								$SelLogin[1] = mysql_query($sql);
							$ResLogin = mysql_fetch_array($SelLogin[1]);

							/* Variáveis gerais */
                            $_SESSION['numcontacorrente']=$ResLogin['numcontacorrente'];
							$_SESSION['codcliente']=$ResLogin['codcliente'];							
							$_SESSION['nomcliente']=$ResLogin['nomcliente'];
							if($ResLogin['codnucleo']!="")
								$_SESSION['codnucleo']=$ResLogin['codnucleo'];							
							else
								$_SESSION['codnucleo']="0";
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

?><body background="img/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" id="central">
  <tr><td width="100%" height="100%" align="center" valign="middle">
<script language="JavaScript1.2">mmLoadMenus();</script>
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<table width="771" border="0" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="index.png" fwbase="index.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="img2/spacer.gif" width="12" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="205" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="40" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="51" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="3" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="26" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="59" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="4" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="60" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="46" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="96" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="64" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="16" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="56" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="12" height="1" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="18"><img name="index_1" src="img2/index_1.gif" width="771" height="7" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="7" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td rowspan="3"><img name="index_2" src="img2/index_2.gif" width="12" height="54" border="0" alt=""></td>
   <td rowspan="2"><a href="index.php"><img name="logo" src="img2/logo.gif" width="205" height="47" border="0" alt=""></a></td>
   <td colspan="10"><img name="index_4" src="img2/index_4.gif" width="295" height="17" border="0" alt=""></td>
   <td><a href="faleconosco.php"><img name="bt_faleconosco" src="img2/bt_faleconosco.gif" width="96" height="17" border="0" alt="Fale Conosco"></a></td>
   <td><img name="index_6" src="img2/index_6.gif" width="15" height="17" border="0" alt=""></td>
   <td><a href="noticias.php"><img name="bt_noticias" src="img2/bt_noticias.gif" width="64" height="17" border="0" alt="Notícias"></a></td>
   <td><img name="index_8" src="img2/index_8.gif" width="16" height="17" border="0" alt=""></td>
   <td><a href="http://www.sicoob.com.br" target="_blank"><img name="bt_sicoob" src="img2/bt_sicoob.gif" width="56" height="17" border="0" alt="Sicoob"></a></td>
   <td><img name="index_10" src="img2/index_10.gif" width="12" height="17" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="17" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td rowspan="2"><img name="index_11" src="img2/index_11.gif" width="40" height="37" border="0" alt=""></td>
   <td colspan="15" rowspan="2" align="center" valign="middle" background="img2/dados_login.gif"><table width="475" border="0" cellspacing="0" cellpadding="0">
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
   <td><img src="img2/spacer.gif" width="1" height="30" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td><img name="index_13" src="img2/index_13.gif" width="205" height="7" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="7" border="0" alt=""></td>
  </tr>
  <tr><!-- row 5 -->
   <td colspan="18" background="img2/fakemenu.gif">
   <?php if(!empty($_SESSION['numcontacorrente'])){?>
   <img src="img/menubar.jpg" name="image1" border="0" usemap="#Map" id="image1"><map name="Map">
  <area shape="rect" coords="40,4,140,20" href="#" onMouseOver="MM_showMenu(window.mm_menu_0911185019_0,40,20,null,'image1')" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="158,4,198,20" href="#" onMouseOver="MM_showMenu(window.mm_menu_0911185018_0,160,20,null,'image1')" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="210,4,282,20" href="consultacc.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="297,4,412,20" href="emprestimos.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="428,4,568,20" href="cadastracliente.php?tipoacao=Editar" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="583,4,668,20" href="alterarsenhacliente.php" onMouseOver="" onMouseOut="MM_startTimeout();">
  <area shape="rect" coords="687,4,705,20" href="sair.php" onMouseOver="" onMouseOut="MM_startTimeout();">
</map>
<?php
}else{
echo '<img src="img2/fakemenu.gif" border="0">';
}
?>
</td>
   <td><img src="img2/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 6 -->
   <td colspan="18" background="img2/index_15.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="14%">&nbsp;</td>
       <td width="86%">&nbsp;</td>
     </tr>
   </table></td>
   <td><img src="img2/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 7 -->
    <td colspan="18" rowspan="5" valign="top" bgcolor="#FFFFFF"><?
	switch($nomePAG)
	{
		default: include("inc/$nomePAG");
	}

?></td>
    <td><img src="img2/spacer.gif" width="1" height="94" border="0" alt=""></td>
  </tr>
  <tr><!-- row 8 -->
   <td><img src="img2/spacer.gif" width="1" height="3" border="0" alt=""></td>
  </tr>
  <tr><!-- row 9 -->
   <td><img src="img2/spacer.gif" width="1" height="137" border="0" alt=""></td>
  </tr>
  <tr><!-- row 10 -->
   <td><img src="img2/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 11 -->
   <td><img src="img2/spacer.gif" width="1" height="141" border="0" alt=""></td>
  </tr>
  <tr><!-- row 12 -->
   <td rowspan="3" colspan="6"><img name="index_26" src="img2/index_26.gif" width="337" height="84" border="0" alt=""></td>
   <td colspan="2" bgcolor="#FFFFFF"><img src="img2/spacer.gif" width="0" height="0" border="0" alt=""></td>
   <td rowspan="2" bgcolor="#FFFFFF"><img src="img2/spacer.gif" width="0" height="0" border="0" alt=""></td>
   <td colspan="2" bgcolor="#FFFFFF"><img src="img2/spacer.gif" width="0" height="0" border="0" alt=""></td>
   <td rowspan="3" colspan="7"><img name="index_30" src="img2/index_30.gif" width="305" height="84" border="0" usemap="#m_index_30" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr><!-- row 13 -->
   <td rowspan="2" colspan="2"><img name="index_31" src="img2/index_31.gif" width="64" height="65" border="0" alt=""></td>
   <td rowspan="2" colspan="2"><img name="index_32" src="img2/index_32.gif" width="64" height="65" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="4" border="0" alt=""></td>
  </tr>
  <tr><!-- row 14 -->
   <td><img name="index_33" src="img2/index_33.gif" width="1" height="61" border="0" alt=""></td>
   <td><img src="img2/spacer.gif" width="1" height="61" border="0" alt=""></td>
  </tr>
<map name="m_index_30">
<area shape="rect" coords="193,45,289,57" href="http://www.pmtraining.com.br/" alt="" >
</map>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
</td></tr></table>
</body>
</html>