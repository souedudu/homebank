
<?
include "Connections/homebank_conecta.php";
mysql_select_db("homebank");

$sql = "UPDATE solicitacaoserv SET dtencerramento IS NULL, dtconclusao IS NULL WHERE codsolicitacao=21";
mysql_query($sql)or die(mysql_error());

$sql = "ALTER TABLE `andamensolicitacao`
  CHANGE COLUMN `descompmensagem` `descompmensagem` text NULL";
mysql_query($sql)or die(mysql_error());

echo "Atualização concluída com sucesso!";
?>
