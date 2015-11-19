<?php
require_once 'class.Date_Diff';
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formINC")) {
  
  if($_POST['enviamensagem'] == '1'){
    $EnviaEmail = new EnviaEmail();
    $email = array();
    $email['email'] = $_POST['email'];
    $email['nomebusca'] = $_POST['nomcliente'];
    $email['os'] = $_REQUEST['cod'];
    // print_r($_SERVER);
    $pg = split("/",$_SERVER['PHP_SELF']);
    array_pop($pg);
    $pg = implode('/', $pg) ;

    $email['link'] = $_SERVER['HTTP_ORIGIN'].$pg.'/'."ver.php?cod=".$_REQUEST['cod'];
    $EnviaEmail->emailAcompanhamento($email);
  }
  $insertSQL = "INSERT INTO andamensolicitacao (codsolicitacao, codmenatendimento, codtecnicoresp, descompmensagem, datregandamento, hrregandamento) VALUES (".GetSQLValueString($_POST['codsolicitacao'], "int").", ".GetSQLValueString($_POST['codmenatendimento'], "int").", ".GetSQLValueString($_POST['codtecnicoresp'], "int").", ".GetSQLValueString($_POST['descompmensagem'], "text").", ".GetSQLValueString($_POST['datregandamento'], "date").", ".GetSQLValueString($_POST['hrregandamento'], "date").")";
  mysql_select_db(conexao_db, $homebank_conecta)or die(mysql_error());
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL, $homebank_conecta) or die(mysql_error());
  $insertGoTo = "?";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }


  //header(sprintf("Location: %s", $insertGoTo));
  echo '<script language="JavaScript" type="text/javascript">
location.href="?cod='.$_REQUEST['codsolicitacao'].'";
</script>';

}

mysql_select_db(conexao_db, $homebank_conecta);
$query_mensagens = "SELECT mensatendimento.codmenatendimento, mensatendimento.desmenatendimento FROM mensatendimento ORDER BY mensatendimento.desmenatendimento";
$mensagens = mysql_query($query_mensagens, $homebank_conecta) or die(mysql_error());
$row_mensagens = mysql_fetch_assoc($mensagens);
$totalRows_mensagens = mysql_num_rows($mensagens);

$colname_andamentos = "-1";

$colname_andamentos = $codsolicitacao;

mysql_select_db(conexao_db, $homebank_conecta);
$query_andamentos = sprintf("SELECT andamensolicitacao.codandsolicitacao, mensatendimento.desmenatendimento, tecnicoresp.nomtecnicoresp, andamensolicitacao.descompmensagem, DATE_FORMAT(andamensolicitacao.datregandamento,'%%d/%%m/%%Y') AS data_andamento, DATE_FORMAT(andamensolicitacao.hrregandamento,'%%H:%%i') AS hora_andamento FROM andamensolicitacao, mensatendimento, tecnicoresp WHERE mensatendimento.codmenatendimento=andamensolicitacao.codmenatendimento AND andamensolicitacao.codtecnicoresp=tecnicoresp.codtecnicoresp AND andamensolicitacao.codsolicitacao=%s ORDER BY andamensolicitacao.datregandamento DESC, andamensolicitacao.hrregandamento DESC", $colname_andamentos);
$andamentos = mysql_query($query_andamentos, $homebank_conecta) or die(mysql_error());
$row_andamentos = mysql_fetch_assoc($andamentos);
$totalRows_andamentos = mysql_num_rows($andamentos);

mysql_select_db(conexao_db, $homebank_conecta);
$query_andamentosProcedimento = "SELECT s.codsolicitacao, s.codtecnicoresp, DATE_FORMAT( s.dtsolicitacao, '%d/%m/%Y' ) AS dtsolicitacao, s.hrsolicitacao, DATE_FORMAT( s.hrsolicitacao, '%H:%i' ) AS hrsolicitacao, h.codtecnicorespantigo, h.codtecnicorespatual, h.codusuarioadm, DATE_FORMAT( h.data, '%d/%m/%Y' ) AS data, DATE_FORMAT( h.data, '%H:%i' ) AS hora, t1.nomtecnicoresp as tecnicorespantigo, t2.nomtecnicoresp as tecnicorespatual FROM solicitacaoserv s INNER JOIN historicotecn h USING (codsolicitacao) LEFT JOIN tecnicoresp t1 on (h.codtecnicorespantigo = t1.codtecnicoresp) LEFT JOIN tecnicoresp t2 on (h.codtecnicorespatual = t2.codtecnicoresp) where 1 and s.codsolicitacao = $colname_andamentos order by s.codsolicitacao,h.data";
$andamentosProcedimento = mysql_query($query_andamentosProcedimento, $homebank_conecta) or die(mysql_error());
$row_andamentosProcedimento = mysql_fetch_assoc($andamentosProcedimento);
$totalRows_andamentosProcedimento = mysql_num_rows($andamentosProcedimento);

mysql_select_db(conexao_db, $homebank_conecta);
$query_tecnico = "SELECT tecnicoresp.codtecnicoresp, tecnicoresp.nomtecnicoresp FROM tecnicoresp ORDER BY tecnicoresp.nomtecnicoresp";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);
?>
<style type="text/css">
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}

</style>
  <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="2" valign="top">
  <?php if($concluida=='N'){ ?>
    <table align="center">
  <form method="post" name="formINC" action="<?php echo $editFormAction; ?>">
          <tr valign="baseline">
            <td align="left" nowrap>Enviar Email para o Associado?<br />
              <input type="checkbox" name="enviamensagem" value="1"></td>
              <input type="hidden" name="email" value="<?php echo $row_solicitacao['desemailcont'];?>"></td>
              <input type="hidden" name="nomcliente" value="<?php echo $row_solicitacao['nomcliente']; ?>"></td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap>Mensagem de atendimento:<br />
              <select name="codmenatendimento" style="width:550">
                <?php 
do {  
?>
                <option value="<?php echo $row_mensagens['codmenatendimento']?>" ><?php echo $row_mensagens['desmenatendimento']?></option>
                <?php
} while ($row_mensagens = mysql_fetch_assoc($mensagens));
?>
              </select>
              <input type="hidden" name="codtecnicoresp" id="codtecnicoresp" value="<?php echo $row_solicitacao['codtecnicoresp'];?>" /></td>
          </tr>  
          <tr valign="baseline">
            <td align="left" valign="top" nowrap><textarea name="descompmensagem" cols="50" rows="5"></textarea>      </td>
          </tr>
          <tr valign="baseline">
            <td align="center" nowrap>
            <?php if(!empty($row_solicitacao['codtecnicoresp'])) {?>
              <input type="submit" value="Inserir andamento">
              <?php } else { echo 'Antes de inserir uma mensagem escolha um procedimento';}?>
              <input type="hidden" name="codsolicitacao" value="<?php echo $_GET['cod']; ?>" />
              <input type="hidden" name="datregandamento" value="<?php echo date('Y-m-d');?>" />
              <input type="hidden" name="hrregandamento" value="<?php echo date('H:i');?>" />
              <input type="hidden" name="MM_insert" value="formINC" /></td>
          </tr>
      </form>
        </table>
<?php } ?>
<hr noshade="noshade" /></td>
    </tr>
  <?php if ($totalRows_andamentos > 0) { // Show if recordset not empty ?>
    <?php do { ?>
      <tr>
        <td align="left" valign="top">Procedimento/Fase:<br /> 
          <?php echo $row_andamentos['nomtecnicoresp']; ?><br />          </span></td>
        <td align="left" valign="top">Data:<br /> 
          <?php echo $row_andamentos['data_andamento']; ?><br />
        <?php echo $row_andamentos['hora_andamento']; ?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"><br /><?php echo $row_andamentos['desmenatendimento']; ?></td>
      </tr><tr>
        <td colspan="2" align="left" valign="top"><?php echo $row_andamentos['descompmensagem']; ?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"><br /><hr noshade="noshade" /></td>
      </tr>
      <?php } while ($row_andamentos = mysql_fetch_assoc($andamentos)); ?>
    <?php }else{ ?>
    <tr>
      <td colspan="2" align="center" valign="top"><strong><hr />Ainda n&atilde;o existem andamentos cadastrados nessa solicita&ccedil;&atilde;o<hr /></strong> </td>
    </tr>
  <?php } // Show if recordset not empty ?>
</table>
<h4 />Histórico Procedimento<h4 />
<table align="center" style="width:100%">
<tr class="td4">
      <td><div align="left">Data de Tramitação</div></td>
      <td><div align="left">Hora de Tramitação</div></td>
      <td><div align="left">De</div></td>
      <td><div align="left">Para</div></td>
      <td><div align="left">Duração</div></td></tr></tr>
    <?php do { 
      if($cont%2==0)
        $cor="#F5F5F5";
      else
        $cor="#FFFFFF";
      if ($row_andamentosProcedimento['codsolicitacao'] == null) continue;

      if ($codsolicitacaoteste == $row_andamentosProcedimento['codsolicitacao']){
        $row_andamentosProcedimento['dtsolicitacao'] = $dtsolicitacao;
       $row_andamentosProcedimento['hrsolicitacao'] = $hrsolicitacao;
      }

      $date = new Date_Diff();
      $date->setDatas($row_andamentosProcedimento['data'].' '.$row_andamentosProcedimento['hora'].':00' ,$row_andamentosProcedimento['dtsolicitacao'].' '.$row_andamentosProcedimento['hrsolicitacao'].':00');
      if (empty($row_andamentosProcedimento['tecnicorespantigo'])) $row_andamentosProcedimento['tecnicorespantigo'] = "Aguardando triagem";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_andamentosProcedimento['codsolicitacao']; ?>';">
        <td><?php echo $row_andamentosProcedimento['data']; ?></td>
        <td><?php echo $row_andamentosProcedimento['hora']; ?></td>
        <td><?php echo $row_andamentosProcedimento['tecnicorespantigo']; ?></td>
        <td><?php echo $row_andamentosProcedimento['tecnicorespatual']; ?></td>
        <td><?php echo $date->getDiffInDays() ." dias ".$date->getDiffInHours() ." horas ".$date->getDiffInMinutes()." minutos"; ?></td>
      <?php 
      $cont++;
      $codsolicitacaoteste = $row_andamentosProcedimento['codsolicitacao'];
      $dtsolicitacao = $row_andamentosProcedimento['data'];
      $hrsolicitacao = $row_andamentosProcedimento['hora'];
    } while ($row_andamentosProcedimento = mysql_fetch_assoc($andamentosProcedimento)); ?>
  </table>
<?php
mysql_free_result($mensagens);

mysql_free_result($andamentos);

mysql_free_result($tecnico);
?>
