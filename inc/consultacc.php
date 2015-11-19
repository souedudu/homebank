<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 21/11/2005 - Gelson
Sistema: Home Bank
Descrição: Consulta Conta Corrente
************************************************************************************/
?>

<style>
.base{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#FFFFFF;
	font-weight:bold;
	text-align:right;
	padding-right:5px;
}

.menu{
	color:#FFFFFF;
	font-weight:bold;
	text-align:center;
	text-decoration:none;
	font-size:10px;
}


body,p,div,select,table,tr,th,td,input,textarea,.texto{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000;
	border:0px solid #606060;
	cellspacing: 0px
}


.td1{
    border:1px solid #606060;
	background-color:#F2F8E4;
	color:#CC0000;
	font-weight:bold;
}
.td2{
    border:1px solid #606060;
    background-color:#F7FEE7;
	color:#000000;
	font-weight:bold;
}
.td3{
	background-color:#F7FEE7
}
.td4{
    border:0px solid #606060;
    background-color:#F4F4F4;
	color:#000000;
	font-weight:bold;
}
.td5{
    border:0px solid #606060;
    background-color:#FFFFFF;
	color:#000000;
}
th{
	background-color:#637B9A;
	color:#F2F4F7;
}

input,textarea,select{
	border:1px solid;
	background-color:#F2F8E4;
}

.tb{
	border:1px solid #FFF;
	background-color:#FFF;
}

.tberro{
	border:1px solid #FF0000;
	background-color:#FF9999;
	color:#CC0000;
	font-weight:bold;
}

a{
color:#FFF;
text-decoration:none;
}
.bt{
background-color:#778897;
color:#FFFFFF;
font-weight:bold;
font-size:10px;
font-family:arial;
}

.link{
color:#333333;
text-decoration:underline;
}

.btLink{
 background-color:#C6D2DF;
 border:1px solid #000;
 text-decoration:none;
 font-weight:bold;
 padding:2px;
 padding-top:0px;
 padding-bottom:0px;
 color: #000000;

}
</style>

<?



	// Ponteiro, identifica se achou registrou ou não.
	$achou = 0;
	// abre conexão com o banco
	if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db)){

		// Instrução SQL para selecionar conta corrente		
		$SelContCorrente = "SELECT * FROM contacorrente";
		$SelContCorrente.= " WHERE codcliente=".$_SESSION['codcliente'];
		
		// Verifica se existe algum registro
		if($achou = VerificaRegistro($SelContCorrente)){
			$SelectCC[0] = mysql_query($SelContCorrente);
			$Resultado = mysql_fetch_array($SelectCC[0]);
			
			//fomata data do saldo com um dia a menos
			$d = date("d"); 
			$d--; 
			$restdata = date("-m-Y"); 
			$datasaldo = $d.$restdata;
			
			?>
 <table width="530" border="0" cellspacing="0" cellpadding="0">  
  <tr>
    <td>&nbsp;</td>
    <td width="500"><strong>Saldo de Conta Corrente&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Data: <?=$datasaldo; ?></strong></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td width="500"><strong>Conta Corrente:</strong> <?=$_SESSION['numcontacorrente']." - ".$_SESSION['nomcliente'];?></td>	
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	  <table width="500" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="99" bgcolor="#f4f4f4"><div align="right">Situa&ccedil;&atilde;o:</div></td>
        <td width="103" bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?
		if($Resultado['codsituacaoconta']==1){
			echo("Ativo");		
		}elseif($Resultado['codsituacaoconta']==2){
			echo("Inativo");
		}?>
        </strong></td>
        <td width="198" bgcolor="#f4f4f4"><div align="right">Data de Abertura:</div></td>
        <td width="87" bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=FormataData($Resultado['databerturaconta'],'pt');?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Tipo de conta:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?
		if(empty($Resultado['codtipoconta'])){
			echo("Pessoa F&iacute;sica");
		}elseif($Resultado['codtipoconta']==1){
			echo("Pessoas Jur&iacute;dicas");
		}elseif($Resultado['codtipoconta']==2){
			echo("Instit. Sistema Financeiro");
		}?>
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right">Data do último movimento:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=FormataData($Resultado['datultmovconta'],'pt');?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Grupo:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?
		if(empty($Resultado['codgrupoconta'])){
			echo("Nenhum");
		}elseif($Resultado['codgrupoconta']==1){
			echo("Funcion&aacute;rios");
		}elseif($Resultado['codgrupoconta']==2){
			echo("Conta de uso interno");
		}?>
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right">Total de lançamentos no mês:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=$Resultado['numtotallancamentos'];?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Categoria:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?
		if($Resultado['codcategoriaconta']==1){
			echo("Individual");
		}elseif($Resultado['codcategoriaconta']==1){
			echo("Conjunta Solid&aacute;ria");
		}elseif($Resultado['codcategoriaconta']==2){
			echo("Conjunta N&atilde;o Solid&aacute;ria");
		}?>
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right"></div></td>
        <td bgcolor="#f4f4f4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp; </td>
  </tr>
  <tr>
    <td width="30" valign="top">&nbsp;</td>
    <td valign="top">
	<table width="388" border="0" align="center" cellpadding="2" cellspacing="1">
      <tr>
        <td bgcolor="#f4f4f4"><div align="center"><strong>Saldos</strong></div></td>
        <td bgcolor="#f4f4f4"><div align="right"><strong>Data</strong></div></td>		
        <td bgcolor="#f4f4f4"><div align="right"><strong>Valor</strong></div></td>
      </tr>
      <tr>
        <td width="300"><div align="right">Dispon&iacute;vel</div></td>
        <td width="95"><div align="right" class="CorFonteAzul"><?=FormataData($Resultado['datultmovconta'],'pt');?></div>
        <td width="95"><div align="center" class="CorFonteAzul">
          <div align="right">
                <strong><?=number_format($Resultado['vlsaldodispatual'],2,',','.');?></strong></div>
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Bloqueado</div></td>
        <td width="95"><div align="right" class="CorFonteAzul"></div>		
        <td><div align="right" class="CorFonteAzul">
            <div align="right">
              <?=number_format($Resultado['vlsaldobloqatual'],2,',','.');?></div>
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Saldo Utilização de limite de crédito</div></td>
        <td width="95"><div align="right" class="CorFonteAzul"></div>				
        <td><div align="center" class="CorFonteAzul">
            <div align="right">
              <?=number_format($Resultado['vlutilatuallimcredito'],2,',','.');?></div>
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Juros acumulados de limite de crédito </div></td>
        <td width="95"><div align="right" class="CorFonteAzul"></div>				
        <td><div align="center" class="CorFonteAzul">
          <div align="right"><?=number_format($Resultado['vljurosacumulimitecredito'],2,',','.');?></div>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" valign="top">&nbsp;</td>
    <td height="35"><br><br><div align="center"><img src="img/bt_imprimir.gif" width="67" height="20" border="0"/>&nbsp;&nbsp;&nbsp;<?
	include_once('inc_botoes.php');
	?></div></td>
  </tr>
</table>

			<?
		}
		Conexao($opcao='close');
	}
if(empty($achou)){
	echo("<div align='center'><p><br><br><br>");
	echo("Não foi possível estabelecer uma conexão com o BD.");
	echo("</p></div>");
}	
?>
