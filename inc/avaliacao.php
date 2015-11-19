<?php require_once('../Connections/homebank_conecta.php'); ?>
<?php virtual('/homebank2/Connections/homebank_conecta.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO avaliacao (idsolicitacao, contato, qualidade, tempo, geral, comentario) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idsolicitacao'], "int"),
                       GetSQLValueString($_POST['contato'], "text"),
                       GetSQLValueString($_POST['qualidade'], "text"),
                       GetSQLValueString($_POST['tempo'], "text"),
                       GetSQLValueString($_POST['geral'], "text"),
                       GetSQLValueString($_POST['comentario'], "text"));

  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());

  $insertGoTo = "obrigado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  echo '<script language="JavaScript" type="text/javascript">
location.href="obrigado.php";
</script>
';
}

$colname_solicitacao = "-1";
if (isset($_SESSION['codcliente'])) {
  $colname_solicitacao = (get_magic_quotes_gpc()) ? $_SESSION['codcliente'] : addslashes($_SESSION['codcliente']);
}
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_solicitacao = sprintf("SELECT solicitacaoserv.codsolicitacao, DATE_FORMAT(solicitacaoserv.dtsolicitacao,'%%d/%%m/%%Y') AS data_solicitacao, DATE_FORMAT(solicitacaoserv.hrsolicitacao,'%%H:%%i') AS hora_solicitacao, tiposervsolicitacao.destiposervsol, solicitacaoserv.dessolicitacao FROM solicitacaoserv, tiposervsolicitacao, contacorrente, cliente, avaliacao WHERE tiposervsolicitacao.codtiposervsol=solicitacaoserv.codtiposervsol AND solicitacaoserv.dtencerramento IS NOT NULL AND solicitacaoserv.numcontacorrente=contacorrente.numcontacorrente AND contacorrente.codcliente=cliente.codcliente AND cliente.codcliente=%s ORDER BY solicitacaoserv.codsolicitacao DESC LIMIT 0,1", GetSQLValueString($colname_solicitacao, "int"));
$solicitacao = mysql_query($query_solicitacao, $homebank_conecta) or die($query_solicitacao."=>".mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_avaliacao = "SELECT avaliacao.idavaliacao FROM avaliacao WHERE IF('".$row_solicitacao['codsolicitacao']."'='',1,avaliacao.idsolicitacao='".$row_solicitacao['codsolicitacao']."')";
$avaliacao = mysql_query($query_avaliacao, $homebank_conecta) or die($query_avaliacao."=>".mysql_error());
$row_avaliacao = mysql_fetch_assoc($avaliacao);
$totalRows_avaliacao = mysql_num_rows($avaliacao);
?>
<HTML>
<HEAD>
</HEAD>
<BODY TEXT="000000" BGCOLOR="FFFFFF">
<?php if ($totalRows_solicitacao > 0) { // Show if recordset not empty ?>
  <FORM ACTION="<?php echo $editFormAction; ?>" METHOD=POST NAME="form1" id="form1">
    <FONT SIZE=2 FACE="Verdana">
    <table border=0 width=600>
      <tr>
        <td><TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
            <TR VALIGN=top><TD><B><FONT SIZE=2 FACE="Verdana">CREDIEmbrapa - Solicitação de Serviços Bancários</FONT></B><BR>
                <B><FONT SIZE=2 FACE="Verdana">Data de abertura:</FONT></B><FONT SIZE=2 FACE="Verdana"> </FONT><FONT SIZE=2 FACE="Verdana"><?php echo $row_solicitacao['data_solicitacao']; ?> <?php echo $row_solicitacao['hora_solicitacao']; ?></FONT><BR>
                <B><FONT SIZE=2 FACE="Verdana">Número desta Solicitação: </FONT></B><FONT SIZE=2 FACE="Verdana"><?php echo $row_solicitacao['codsolicitacao']; ?></FONT></TD>
            </TR>
              </TABLE>
          <TABLE BORDER=1>
            <TR VALIGN=top><TD WIDTH="461"><B><FONT SIZE=2 FACE="Verdana">Tipo de Serviço: </FONT></B><BR>
                <FONT SIZE=2 FACE="Verdana"><?php echo $row_solicitacao['destiposervsol']; ?></FONT></TD><TD WIDTH="461"><B><FONT SIZE=2 FACE="Verdana">Detalhes:</FONT></B><BR>
            <FONT SIZE=2 FACE="Verdana"><?php echo $row_solicitacao['dessolicitacao']; ?></FONT></TD></TR>
                </TABLE>
          <BR>
                
          <B><FONT SIZE=2 FACE="Verdana">Questionário de Avaliação: </FONT></B>
          <input name="idsolicitacao" type="hidden" id="idsolicitacao" value="<?php echo $row_solicitacao['codsolicitacao']; ?>">
          <BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Com o objetivo de prestar um serviço cada vez melhor, favor responder às seguintes questões:</FONT><BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Indique a forma de relacionamento com a CrediEmbrapa para a obtenção do serviço indicado nesta OS:</FONT><BR>
          <FONT SIZE=2 FACE="Verdana">
          <INPUT TYPE=radio NAME="contato" VALUE="Telefone">Telefone
          <INPUT TYPE=radio NAME="contato" VALUE="Email">Email
          <INPUT TYPE=radio NAME="contato" VALUE="Fax">Fax
          <INPUT TYPE=radio NAME="contato" VALUE="Internet HomeBanking">Internet HomeBanking
          <INPUT TYPE=radio NAME="contato" VALUE="Pessoalmente">Pessoalmente</FONT><BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Como você avalia a qualidade do atendimento obtido através do ítem anterior?</FONT><BR>
          <FONT SIZE=2 FACE="Verdana">
          <INPUT TYPE=radio NAME="qualidade" VALUE="Bom">Bom
          <INPUT TYPE=radio NAME="qualidade" VALUE="Regular">Regular
          <INPUT TYPE=radio NAME="qualidade" VALUE="Ruim">Ruim</FONT><BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Como você avalia o tempo gasto no atendimento à sua solicitação?</FONT><BR>
          <FONT SIZE=2 FACE="Verdana">
          <INPUT TYPE=radio NAME="tempo" VALUE="Bom">Bom (até 72 horas)<BR>
                  
          <INPUT TYPE=radio NAME="tempo" VALUE="Regular">Regular (até 5 dias)<BR>
                  
          <INPUT TYPE=radio NAME="tempo" VALUE="Ruim">Ruim (mais que uma semana)</FONT><BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Qual sua avaliação geral a respeito do atendimento da CrediEmbrapa?</FONT><BR>
          <FONT SIZE=2 FACE="Verdana">
          <INPUT TYPE=radio NAME="geral" VALUE="Bom">Bom<BR>
                  
          <INPUT TYPE=radio NAME="geral" VALUE="Regular">Regular<BR>
                  
          <INPUT TYPE=radio NAME="geral" VALUE="Ruim">Ruim</FONT><BR>
          <BR>
          <FONT SIZE=2 FACE="Verdana">Escreva abaixo sua crítica, elogio ou sugestão, de forma suscinta (máximo 3 linhas):</FONT><BR>
          <FONT SIZE=2 FACE="Verdana">
          <textarea name="comentario" cols="47" id="comentario"></textarea>
          </FONT><BR>
          <BR>
          <?php if ($totalRows_avaliacao == 0) { // Show if recordset empty ?>
            <input type="submit" name="Submit" value="Enviar avalia&ccedil;&atilde;o">
            <?php } // Show if recordset empty ?>
<input type="hidden" name="MM_insert" value="form1">
          <BR>
        <B><FONT SIZE=2 FACE="Verdana"></td>
      </tr>
    </table>
    </FONT>
      </FORM>
	  <?php }else{?>
	  <table border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr><td>&nbsp;</td></tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="center" valign="middle"><strong>N&atilde;o existem solicita&ccedil;&otilde;es para serem avaliadas.</strong></td>
        </tr>
      </table>
      <?php } // Show if recordset not empty ?></BODY>
</HTML>
<?php
mysql_free_result($solicitacao);

mysql_free_result($avaliacao);
?>
