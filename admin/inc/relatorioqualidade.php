<?php
session_start();
include('../Connections/homebank_conecta.php'); 
require_once 'auth.php';
require_once 'class.Date_Diff';
verificaAuth($_SESSION['codusuarioadm'], 'Consultar OS');
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tipos = "SELECT CONCAT(tiposolicitacao.destiposol, ' - ',tiposervsolicitacao.destiposervsol) AS tipos, tiposervsolicitacao.codtiposervsol FROM tiposolicitacao, tiposervsolicitacao WHERE tiposervsolicitacao.codtiposol = tiposolicitacao.codtiposol ORDER BY tiposervsolicitacao.codtiposervsol";
$tipos = mysql_query($query_tipos, $homebank_conecta) or die(mysql_error());
$row_tipos = mysql_fetch_assoc($tipos);
$totalRows_tipos = mysql_num_rows($tipos);

mysql_select_db($database_homebank_conecta, $homebank_conecta);
$query_tecnico = "SELECT tecnicoresp.nomtecnicoresp, tecnicoresp.codtecnicoresp FROM tecnicoresp ORDER BY tecnicoresp.nomtecnicoresp";
$tecnico = mysql_query($query_tecnico, $homebank_conecta) or die(mysql_error());
$row_tecnico = mysql_fetch_assoc($tecnico);
$totalRows_tecnico = mysql_num_rows($tecnico);


?>
<?php //echo $query_consulta;?>

<form method="post" name="form1" id="form1">
<table width="750" border="0" cellspacing="0" cellpadding="3" class="form">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><b>Relatórios de Qualidade - SGQ</b> </td>
  </tr>
</table>
  <table width="740" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td colspan="4" height="10"></td>
    </tr>
    <tr>
      <td colspan="2" height="10">Tipo de Relatório</td>
      <td colspan="2" height="10">
        <input type="radio" name="tp_relatorio" onclick="this.form.submit()" value='1' <?php if ($tp_relatorio =='1') echo 'checked';?>>Relatório de OS Concluídas
        <br><input type="radio" name="tp_relatorio" onclick="this.form.submit()" value='2' <?php if ($tp_relatorio =='2') echo 'checked';?>>Relatório de Tempo de Abertura de Conclusão de OS's
        <br><input type="radio" name="tp_relatorio" onclick="this.form.submit()" value='3' <?php if ($tp_relatorio =='3') echo 'checked';?>>Relatório de OS's Abertas Por Periodo
<!--

        <br><input type="radio" name="tp_relatorio" onclick="this.form.submit()" value='4' <?php if ($tp_relatorio =='4') echo 'checked';?>>Relatório de Histórico Procedimento

-->
        <br><input type="radio" name="tp_relatorio" onclick="this.form.submit()" value='5' <?php if ($tp_relatorio =='5') echo 'checked';?>>Relatório de Avaliação de Atendimento
      <br></td>
    </tr>
    <tr>
      <td colspan="2" height="10">&nbsp;</td>
      <td colspan="2" height="10">&nbsp;</td>
    </tr>
    <?php if(!empty($tp_relatorio)) {  ?>
     <tr>
      <td colspan="2" nowrap="nowrap">Data inicial:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="dia_inicio" value="<?php echo $dia_inicio;?>" type="text" id="dia_inicio" size="3" maxlength="2" />
/
  <input name="mes_inicio" value="<?php echo $mes_inicio;?>" type="text" id="mes_inicio" size="3" maxlength="2" />
/
<input name="ano_inicio" value="<?php echo $ano_inicio;?>" type="text" id="ano_inicio" size="5" maxlength="4" /></td>
      <td align="right">Data final:</td>
      <td><input name="dia_fim" value="<?php echo $dia_fim;?>" type="text" id="dia_fim" size="3" maxlength="2">
/
  <input name="mes_fim" value="<?php echo $mes_fim;?>" type="text" id="mes_fim" size="3" maxlength="2">
/
<input name="ano_fim" value="<?php echo $ano_fim;?>" type="text" id="ano_fim" size="5" maxlength="4" />
<br></td>
    </tr>
     <tr>
       <td colspan="2" nowrap="nowrap">&nbsp;</td>
       <td align="right">&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
    <tr>
      <td colspan="2">N&ordm; O.S.:
        <input name="cod_solicitacao" value="<?php echo $cod_solicitacao;?>" type="text" id="cod_solicitacao" size="6" /></td>
      <td colspan="2">Procedimento
      <input name="codtecnicoresp" value="<?php echo $codtecnicoresp;?>" type="text"  id="codtecnicoresp" size="6" />
      <br></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="4" align="center"><input type="submit" name="Submit" value="Filtrar" /></td>
    </tr>
  </table>
</form>

<BR>
</form>


<?php 
if (!empty($Submit)){
  $cond = '';
  if ($tp_relatorio =='1' || $tp_relatorio =='2') $cond .= " and s.dtconclusao is not null ";
  if (!empty($cod_solicitacao)) $cond .= " and s.codsolicitacao = $cod_solicitacao";

  if($tp_relatorio =='1') $data = " s.dtconclusao "; else  $data = " s.dtsolicitacao ";
  if (!empty($mes_inicio) and !empty($dia_inicio) and !empty($ano_inicio)) 
    $cond .= " and $data >= '".$ano_inicio.'-'.$mes_inicio.'-'.$dia_inicio." 00:00:00'";
  if (!empty($mes_fim) and !empty($dia_fim) and !empty($ano_fim)) 
    $cond .= " and $data <= '".$ano_fim.'-'.$mes_fim.'-'.$dia_fim." 23:59:59'";
  if(!empty($codtecnicoresp)) 
    $cond .= " and s.codtecnicoresp = $codtecnicoresp "; 
  mysql_select_db($database_homebank_conecta, $homebank_conecta);
  


  if ($tp_relatorio =='4'){
    $query_consulta = "SELECT s.codsolicitacao,
       s.codtecnicoresp,
       DATE_FORMAT( s.dtsolicitacao, '%d/%m/%Y' ) AS dtsolicitacao,
       s.hrsolicitacao,
       DATE_FORMAT( s.hrsolicitacao, '%H:%i' ) AS hrsolicitacao,
       h.codtecnicorespantigo,
       h.codtecnicorespatual,
       h.codusuarioadm,
       DATE_FORMAT( h.data, '%d/%m/%Y' ) AS data, 
       DATE_FORMAT( h.data, '%H:%i' ) AS hora,
       t1.nomtecnicoresp as tecnicorespantigo, 
       t2.nomtecnicoresp as tecnicorespatual 
  FROM solicitacaoserv s 
       INNER JOIN historicotecn h USING (codsolicitacao)
       LEFT JOIN tecnicoresp t1 on (h.codtecnicorespantigo = t1.codtecnicoresp)
    LEFT JOIN tecnicoresp t2 on (h.codtecnicorespatual = t2.codtecnicoresp) where 1 $cond order by s.codsolicitacao,h.data";
  } if ($tp_relatorio =='5'){
    $query_consulta = "select a.* from avaliacaosol a, solicitacaoserv s where s.codsolicitacao = a.codsolicitacao $cond;";
  } else {
    $query_consulta = "SELECT DISTINCT (  s.codsolicitacao ),  
    tiposervsolicitacao.destiposervsol,s.codtiposervsol,
    s.numcontacorrente,  tiposolicitacao.destiposol,
    DATE_FORMAT( s.dtsolicitacao, '%d/%m/%Y' ) AS data_solicitacao,  
    DATE_FORMAT( s.hrsolicitacao, '%H:%i' ) AS hora_solicitacao,  
    IF( s.dtconclusao IS NULL , 'Solicitação não concluída', DATE_FORMAT( s.dtconclusao, '%d/%m/%Y' ) ) AS data_conclusao,
    DATE_FORMAT( s.dtconclusao, '%d/%m/%Y'  ) AS hora_conclusao,  
    IF( s.dtconclusao IS NULL , '', DATE_FORMAT( s.dtconclusao, '%H:%i' ) ) AS hora_conclusao, s.codtecnicoresp, 
    IF( s.codtecnicoresp IS NULL , '<b><blink>Aguardando triagem</blink></b>', t2.nomtecnicoresp ) AS tecnico_responsavel,  
    cliente.nomcliente,usuario.desusuario
    FROM 
    solicitacaoserv s, tiposervsolicitacao, usuario,tecnicoresp t2, cliente, contacorrente,tiposolicitacao WHERE s.tecnico_abertura = usuario.codusuario and s.codtiposervsol = tiposervsolicitacao.codtiposervsol AND  ( s.codtecnicoresp = t2.codtecnicoresp OR s.codtecnicoresp IS NULL ) AND  cliente.codcliente = contacorrente.codcliente AND  contacorrente.numcontacorrente = s.numcontacorrente 
      $cond AND tiposolicitacao.codtiposol = tiposervsolicitacao.codtiposol GROUP BY s.codsolicitacao ORDER BY s.codsolicitacao";
    
  }
  // echo $query_consulta;
    $consulta = mysql_query($query_consulta, $homebank_conecta) or die(mysql_error());
    $row_consulta = mysql_fetch_assoc($consulta);
    $totalRows_consulta = mysql_num_rows($consulta);
}



?>

<?php if ($totalRows_consulta == 0) { // Show if recordset empty ?>
  <div id="dados"><br>Preencha os campos acima para executar uma busca...</div>
  <?php } // Show if recordset empty ?>

<?php if ($totalRows_consulta > 0) { // Show if recordset not empty ?>
  Total de Registros: <?php echo $totalRows_consulta ?> <br />
  Clique sobre a solicita&ccedil;&atilde;o para ver detalhes<br>
  <table border="3" width="880" cellpadding="1" cellspacing="1">
    
<?php if ($tp_relatorio ==1){ ?>
    <tr class="td4">
      <td><div align="left">CÓD. OS </div></td>
      <td><div align="left">PROCEDIMENTO</div></td>
      <td><div align="left">MENS. CONCLUSÃO</div></td>
      <td><div align="left">DATA CONCLUSÃO</div></td>
      <td><div align="left">HORA CONCLUSÃO</div></td></tr></tr>
    <?php do { 
			if($cont%2==0)
				$cor="#F5F5F5";
			else
				$cor="#FFFFFF";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>';">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td><?php echo $row_consulta['codtecnicoresp']; ?></td>
        <td><?php echo $row_consulta['nomcliente']; ?></td>
        <td align="center"><?php echo $row_consulta['data_conclusao']; ?> </td>
        <td><?php echo $row_consulta['hora_conclusao']; ?></td>
      <?php 
			$cont++;
		} while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
  </table>
  <?php } elseif ($tp_relatorio ==2){ ?>
    <tr class="td4">
      <td><div align="left">CÓD. OS</div></td>
      <td><div align="left">DATA ABERTURA</div></td>
      <td><div align="left">HORA ABERTURA</div></td>
      <td><div align="left">DATA CONCLUSÃO</div></td>
      <td><div align="left">HORA CONCLUSÃO</div></td>
      <td><div align="left">TEMPO</div></td>
      </tr>
    <?php do { 
      if($cont%2==0)
        $cor="#F5F5F5";
      else
        $cor="#FFFFFF";

      $date = new Date_Diff();
      $date->setDatas($row_consulta['data_conclusao'].' '.$row_consulta['hora_conclusao'].':00' ,$row_consulta['data_solicitacao'].' '.$row_consulta['hora_solicitacao'].':00');
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>';">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td><?php echo $row_consulta['data_solicitacao']; ?></td>
        <td><?php echo $row_consulta['hora_solicitacao']; ?></td>
        <td align="center"><?php echo $row_consulta['data_conclusao']; ?> </td>
        <td><?php echo $row_consulta['hora_conclusao']; ?></td>
        <td><?php echo $date->getDiffInDays() ." dias ".$date->getDiffInHours() ." horas ".$date->getDiffInMinutes()." minutos"; ?></td>
      <?php 
      $cont++;
    } while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
  </table>
  <?php } elseif ($tp_relatorio ==3){ ?>
    <tr class="td4">
      <td><div align="left">CÓD. OS</div></td>
      <td><div align="left">TECNICO ABERTURA</div></td>
      <td><div align="left">PRODUTO</div></td>
      <td><div align="left">DESCRIÇÃO TIPO SERVIÇO</div></td>
      <td><div align="left">DATA</div></td>
      <td><div align="left">HORA</div></td></tr></tr>
    <?php do { 
      if($cont%2==0)
        $cor="#F5F5F5";
      else
        $cor="#FFFFFF";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>';">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td align="center"><?php echo $row_consulta['desusuario']; ?> </td>
        <td><?php echo $row_consulta['destiposol']; ?></td>
        <td><?php echo $row_consulta['destiposervsol']; ?></td>
        <td><?php echo $row_consulta['data_solicitacao']; ?></td>
        <td><?php echo $row_consulta['hora_solicitacao']; ?></td>
      <?php 
      $cont++;
    } while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
  </table>
  <?php } elseif ($tp_relatorio ==4){ ?>
    <tr class="td4">
      <td><div align="left">CÓD. OS</div></td>
      <td><div align="left">Data de Início</div></td>
      <td><div align="left">Hora de Início</div></td>
      <td><div align="left">Data de Transição</div></td>
      <td><div align="left">Hora de Transição</div></td>
      <td><div align="left">De</div></td>
      <td><div align="left">Para</div></td>
      <td><div align="left">Duração</div></td></tr></tr>
    <?php do { 
      if($cont%2==0)
        $cor="#F5F5F5";
      else
        $cor="#FFFFFF";
      if ($codsolicitacao == $row_consulta['codsolicitacao']){
        $row_consulta['dtsolicitacao'] = $dtsolicitacao;
        $row_consulta['hrsolicitacao'] = $hrsolicitacao;
      }

      $date = new Date_Diff();
      $date->setDatas($row_consulta['data'].' '.$row_consulta['hora'].':00' ,$row_consulta['dtsolicitacao'].' '.$row_consulta['hrsolicitacao'].':00');
      if (empty($row_consulta['tecnicorespantigo'])) $row_consulta['tecnicorespantigo'] = "Aguardando triagem";
?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>';">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td><?php echo $row_consulta['dtsolicitacao']; ?></td>
        <td><?php echo $row_consulta['hrsolicitacao']; ?></td>
        <td><?php echo $row_consulta['data']; ?></td>
        <td><?php echo $row_consulta['hora']; ?></td>
        <td><?php echo $row_consulta['tecnicorespantigo']; ?></td>
        <td><?php echo $row_consulta['tecnicorespatual']; ?></td>
        <td><?php echo $date->getDiffInDays() ." dias ".$date->getDiffInHours() ." horas ".$date->getDiffInMinutes()." minutos"; ?></td>
      <?php 
      $cont++;
      $codsolicitacao = $row_consulta['codsolicitacao'];
      $dtsolicitacao = $row_consulta['data'];
      $hrsolicitacao = $row_consulta['hora'];
    } while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
  </table>
  <?php } elseif ($tp_relatorio ==5){ ?>
    <tr class="td4">
      <td><div align="left">CÓD. OS</div></td>
      <td><div align="left">NOTA SERVIÇO</div></td>
      <td><div align="left">NOTA ATENDIMENTO</div></td>
      <td><div align="left">NOTA ATEND. GERAL</div></td>
      <td><div align="left">DATA AVALIAÇÃO</div></td>
    <?php do { 
      if($cont%2==0)
        $cor="#F5F5F5";
      else
        $cor="#FFFFFF";

?>
      <tr bgcolor="<?=$cor?>" style="cursor:hand;" onclick="location.href='ver.php?cod=<?php echo $row_consulta['codsolicitacao']; ?>';">
        <td><?php echo $row_consulta['codsolicitacao']; ?></td>
        <td><?php echo $row_consulta['flaqualatendimento']; ?></td>
        <td><?php echo $row_consulta['flatempoatendimento']; ?></td>
        <td><?php echo $row_consulta['flaavalatendimento']; ?></td>
        <td><?php echo $row_consulta['dtavaliacao']; ?></td>
      <?php 
      $cont++;
    } while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
     
  </table>
  <?php }  ?>



<?php } // Show if recordset not empty?>


<?php
//mysql_free_result($consulta);
mysql_free_result($tipos);
mysql_free_result($tecnico);
} 
?>
