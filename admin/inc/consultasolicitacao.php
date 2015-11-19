<?php
session_start();
include('../Connections/homebank_conecta.php'); 
require_once 'auth.php';
verificaAuth($_SESSION['codusuarioadm'], 'Consultar OS');
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tipos = "SELECT destiposervsol AS tipos, codtiposervsol,codtiposol FROM  tiposervsolicitacao ORDER BY destiposervsol";
$tipos = mysql_query($query_tipos, $homebank_conecta) or die(mysql_error());
$row_tipos = mysql_fetch_assoc($tipos);
$totalRows_tipos = mysql_num_rows($tipos);

$query_produtos = "SELECT codtiposol,destiposol FROM tiposolicitacao ORDER BY destiposol";
$produtos = mysql_query($query_produtos, $homebank_conecta) or die(mysql_error());
$row_produtos = mysql_fetch_assoc($produtos);
$totalRows_produtos = mysql_num_rows($produtos);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnico = "SELECT tecnicoresp.nomtecnicoresp, tecnicoresp.codtecnicoresp FROM tecnicoresp ORDER BY tecnicoresp.nomtecnicoresp";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);


$colname_consulta = "-1";
if (isset($_POST['cod_solicitacao'])) {
  $colname_consulta = (get_magic_quotes_gpc()) ? $_POST['cod_solicitacao'] : addslashes($_POST['cod_solicitacao']);
}
$colname2_consulta = "0";
if (isset($_POST['cod_tipo'])) {
  $colname2_consulta = (get_magic_quotes_gpc()) ? $_POST['cod_tipo'] : addslashes($_POST['cod_tipo']);
}
$colname3_consulta = "-1";
if (isset($_POST['contacorrente'])) {
  $colname3_consulta = (get_magic_quotes_gpc()) ? $_POST['contacorrente'] : addslashes($_POST['contacorrente']);
}
$colname4_consulta = "-1";
if (isset($_POST['cliente'])) {
  $colname4_consulta = (get_magic_quotes_gpc()) ? $_POST['cliente'] : addslashes($_POST['cliente']);
}
$colname7_consulta = "-1";
if (isset($_POST['conclusao'])) {
  $colname7_consulta = (get_magic_quotes_gpc()) ? $_POST['conclusao'] : addslashes($_POST['conclusao']);
}
$colname9_consulta = "-1";
if (isset($_POST['ano_inicio'])) {
  $colname9_consulta = (get_magic_quotes_gpc()) ? $_POST['ano_inicio'] : addslashes($_POST['ano_inicio']);
}
$colname10_consulta = "-1";
if (isset($_POST['mes_inicio'])) {
  $colname10_consulta = (get_magic_quotes_gpc()) ? $_POST['mes_inicio'] : addslashes($_POST['mes_inicio']);
}
$colname11_consulta = "-1";
if (isset($_POST['dia_inicio'])) {
  $colname11_consulta = (get_magic_quotes_gpc()) ? $_POST['dia_inicio'] : addslashes($_POST['dia_inicio']);
}
$colname12_consulta = "-1";
if (isset($_POST['ano_fim'])) {
  $colname12_consulta = (get_magic_quotes_gpc()) ? $_POST['ano_fim'] : addslashes($_POST['ano_fim']);
}
$colname13_consulta = "-1";
if (isset($_POST['mes_fim'])) {
  $colname13_consulta = (get_magic_quotes_gpc()) ? $_POST['mes_fim'] : addslashes($_POST['mes_fim']);
}
$colname14_consulta = "-1";
if (isset($_POST['dia_fim'])) {
  $colname14_consulta = (get_magic_quotes_gpc()) ? $_POST['dia_fim'] : addslashes($_POST['dia_fim']);
}
$colname8_consulta = "0";
if (isset($_POST['cod_tecnico'])) {
  $colname8_consulta = (get_magic_quotes_gpc()) ? $_POST['cod_tecnico'] : addslashes($_POST['cod_tecnico']);
}
$cond = '';
if (!empty($cod_tipo)) $cond = " and solicitacaoserv.codtiposervsol = '$cod_tipo' ";
mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_consulta = sprintf("SELECT DISTINCT (  solicitacaoserv.codsolicitacao ),  
tiposervsolicitacao.destiposervsol,  
solicitacaoserv.numcontacorrente,  
DATE_FORMAT( solicitacaoserv.dtsolicitacao, '%%d/%%m/%%Y' ) AS data_solicitacao,  
DATE_FORMAT( solicitacaoserv.hrsolicitacao, '%%H:%%i' ) AS hora_solicitacao,  
IF( solicitacaoserv.dtconclusao IS NULL , 'Solicitação não concluída', DATE_FORMAT( solicitacaoserv.dtconclusao, '%%d/%%m/%%Y' ) ) AS data_conclusao,  
IF( solicitacaoserv.dtconclusao IS NULL , '', DATE_FORMAT( solicitacaoserv.dtconclusao, '<br> %%H:%%i' ) ) AS hora_conclusao,  
IF( solicitacaoserv.codtecnicoresp IS NULL , '<b><blink>Aguardando triagem</blink></b>', tecnicoresp.nomtecnicoresp ) AS tecnico_responsavel,  
cliente.nomcliente 
FROM 
solicitacaoserv, tiposervsolicitacao, tecnicoresp, cliente, contacorrente WHERE solicitacaoserv.codtiposervsol = tiposervsolicitacao.codtiposervsol AND  ( solicitacaoserv.codtecnicoresp = tecnicoresp.codtecnicoresp OR solicitacaoserv.codtecnicoresp IS NULL ) AND  cliente.codcliente = contacorrente.codcliente AND  contacorrente.numcontacorrente = solicitacaoserv.numcontacorrente AND  IF('%s'='',1,solicitacaoserv.codsolicitacao = '%s')  AND  IF('%s'='',1,solicitacaoserv.numcontacorrente = '%s') AND  IF('%s'='',1,cliente.nomcliente LIKE '%%%s%%') AND  IF('%s-%s-%s'='--',1,solicitacaoserv.dtsolicitacao >=CAST('%s-%s-%s' AS DATE)) AND  IF('%s-%s-%s'='--',1,solicitacaoserv.dtsolicitacao <=CAST('%s-%s-%s' AS DATE)) AND  IF('%s'='-1',1,solicitacaoserv.dtconclusao IS NOT NULL) AND  IF('%s'='0',1,solicitacaoserv.codtecnicoresp='%s') AND IF('".$_REQUEST['desproduto']."'='',1 ,solicitacaoserv.desproduto = '".$_REQUEST['desproduto']."') AND IF('".$_REQUEST['conclusao']."'='',1 ,solicitacaoserv.dtencerramento IS NOT NULL) $cond  GROUP BY solicitacaoserv.codsolicitacao ORDER BY solicitacaoserv.codsolicitacao", $colname_consulta,$colname_consulta,$colname3_consulta,$colname3_consulta,$colname4_consulta,$colname4_consulta,$colname9_consulta,$colname10_consulta,$colname11_consulta,$colname9_consulta,$colname10_consulta,$colname11_consulta,$colname12_consulta,$colname13_consulta,$colname14_consulta,$colname12_consulta,$colname13_consulta,$colname14_consulta,$colname7_consulta,$colname8_consulta,$colname8_consulta);
$consulta = mysql_query($query_consulta, $homebank_conecta) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);
$totalRows_consulta = mysql_num_rows($consulta);
?>
<?php //echo $query_consulta;?>

<form name="form1" method="post">
<table width="800" border="0" align="center" cellspacing="0" class="form">
  <tr>
    <td height="34" style="text-align: center" class="td2"><b>Consultar O.S.</b> </td>
  </tr>
</table>
<form method="post" name="form1" id="form1">
  <table width="900" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td colspan="5" height="10"></td>
    </tr>
    <tr>
      <td height="51" colspan="">Nº OS:</td>
      <td>
      <input name="cod_solicitacao" type="text" id="cod_solicitacao" size="6" /></td>
      <td align="right">Procedimento / Fase:  </td>
      <td align="right">&nbsp;</td>
      <td><select name="cod_tecnico" id="cod_tecnico" style="width:250">
        <option value="0">---</option>
        <?php
do {  
?>
        <option value="<?php echo $row_tecnico['codtecnicoresp']?>"><?php echo $row_tecnico['nomtecnicoresp']?></option>
        <?php
} while ($row_tecnico = mysql_fetch_assoc($tecnico));
  $rows = mysql_num_rows($tecnico);
  if($rows > 0) {
      mysql_data_seek($tecnico, 0);
    $row_tecnico = mysql_fetch_assoc($tecnico);
  }
?>
      </select></td>

    </tr>
    <tr>
      <td height="34" nowrap="nowrap">Data inicio:</td>
      <td>

        <input name="dia_inicio" type="text" id="dia_inicio" size="3" maxlength="2" />
/
  <input name="mes_inicio" type="text" id="mes_inicio" size="3" maxlength="2" />
/
<input name="ano_inicio" type="text" id="ano_inicio" size="5" maxlength="4" /></td>
      <td align="right">Data fim: </td>
      <td align="right">&nbsp;</td>
      <td><input name="dia_fim" type="text" id="dia_fim" size="3" maxlength="2" />
/
  <input name="mes_fim" type="text" id="mes_fim" size="3" maxlength="2" />
/
<input name="ano_fim" type="text" id="ano_fim" size="5" maxlength="4" /></td>
    </tr>
    <tr>
      <td height="48" >
Conta Corrente:</td>
      <td>
        <input name="contacorrente" type="text" id="contacorrente" size="7" />
      </td>
      <td align="right">Associado: </td>
      <td align="right">&nbsp;</td>
      <td><input name="cliente" type="text" id="cliente" /></td>
    </tr>
    <tr>
      <td height="44" colspan="1">Produto</td>
      <td><select name="produto" id="produto" style="width:250">
        <option>Selecione</option></option>
       <?php
do {  
?>
     <option value="<?php echo $row_produtos['codtiposol']?>"><?php echo $row_produtos['destiposol']?></option>
     <?php
} while ($row_produtos = mysql_fetch_assoc($produtos));
  $rows = mysql_num_rows($produtos);
  if($rows > 0) {
      mysql_data_seek($produtos, 0);
    $row_produtos = mysql_fetch_assoc($produtos);
  }
?>   
      </select></td>
      <td width="16%" align="right" nowrap="nowrap">Tipos de Serviço: </td>
      <td width="3%" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="43%">
      <select name="cod_tipo" id="cod_tipo">
        <option value="">Selecione</option></option>
        <?php
do {  
?>
     <option  value="<?php echo $row_tipos['codtiposervsol']?>"><?php echo $row_tipos['tipos']?></option>
     <?php
} while ($row_tipos = mysql_fetch_assoc($tipos));
  $rows = mysql_num_rows($tipos);
  if($rows > 0) {
      mysql_data_seek($tipos, 0);
    $row_tipos = mysql_fetch_assoc($tipos);
  }
?>   
      </select>
      <select class="notchosen" id="codtiposervsol2" >
        <option value="">Selecione</option></option>
        <?php
do {  
?>
     <option class='produto<?php echo $row_tipos['codtiposol']?>' value="<?php echo $row_tipos['codtiposervsol']?>"><?php echo $row_tipos['tipos']?></option>
     <?php
} while ($row_tipos = mysql_fetch_assoc($tipos));
  $rows = mysql_num_rows($tipos);
  if($rows > 0) {
      mysql_data_seek($tipos, 0);
    $row_tipos = mysql_fetch_assoc($tipos);
  }
?>   
      </select>
      </td>
    </tr>
    <script type="text/javascript">
      $('#codtiposervsol2 option').hide();
      $('#codtiposervsol2').hide();
      $(function() {
        $('#produto').change(function(event) {
          /* Act on the event */
          $('#codtiposervsol2 option').hide();
          var id = $(this).val();
          $('.produto'+id).show();
          var $clone = $('#codtiposervsol2').clone().show().attr({
            id: 'cod_tipo',
            name: 'cod_tipo'
          });;
          $('#cod_tipo').parent().find('.chosen-container').remove();
          $('#cod_tipo').remove();
          $($clone).insertBefore( $('#codtiposervsol2') );
          $('#cod_tipo').chosen();
        });
        
      });
      </script>
    <tr>
      <td height="51" colspan="2">Conclu&iacute;da
      <input name="conclusao" type="checkbox" id="conclusao" value="1" /></td>
      <td align="right"></td>
      <td align="right"></td>
      <td></td>
    </tr>
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="29%">&nbsp;</td>
      <td><!-- <input name="reload" type="button" id="reload" value="Desativar Filtro" onclick="document.forms['form1'].reset(); document.forms['form1'].submit()" /> -->
      <input type="submit" name="Submit" value="Filtrar" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php if ($totalRows_consulta == 0) { // Show if recordset empty ?>
  <div id="dados">Preencha os campos acima para executar uma busca...<br><br></div>
  <?php } // Show if recordset empty ?>
<BR>
</form>
<?php if ($totalRows_consulta > 0) { // Show if recordset not empty ?>
  Total de Registros: <?php echo $totalRows_consulta ?> <br />
  Click sobre a solicita&ccedil;&atilde;o para ver detalhes
  <table border="3" cellpadding="1" cellspacing="1">
    <tr class="td4">
      <td><div align="left">N&ordm; da O.S. &nbsp;&nbsp;</div></td>
      <td><div align="left">Solicita&ccedil;&atilde;o </div></td>
      <td>        <div align="left">Conta Corrente / Cliente
        </div></td>
      <td><div align="left">Data da Solicita&ccedil;&atilde;o &nbsp;&nbsp; </div></td>
      <td><div align="left">Data Conclus&atilde;o </div></td>
      <td><div align="left">Procedimento/Fase </div></td></tr></tr>
    <?php do { 
			if($cont%2==0)
				$cor="#F5F5F5";
			else
				$cor="#FFFFFF";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>' ;">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td><?php echo $row_consulta['destiposervsol']; ?></td>
        <td><?php echo $row_consulta['numcontacorrente']; ?><br />
        <?php echo $row_consulta['nomcliente']; ?>&nbsp;</td>
        <td align="left"><?php echo $row_consulta['data_solicitacao']; ?> <br /> <?php echo $row_consulta['hora_solicitacao']; ?></td>
        <td align="left">
            <?php echo $row_consulta['data_conclusao']; ?> <?php echo $row_consulta['hora_conclusao']; ?>&nbsp;
          </td>
        <td><?php echo $row_consulta['tecnico_responsavel']; ?></td>
      <?php 
			$cont++;
		} while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
//mysql_free_result($consulta);
mysql_free_result($tipos);
mysql_free_result($tecnico);
?>
