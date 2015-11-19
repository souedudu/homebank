<?php
header("Pragma: cache");
header("Content-Type: text/comma-separated-values");
header('Content-Disposition: attachment; filename="'.date(YmdHi).'.csv'.'"');
?>
<?php require_once('../Connections/crediembrapa.php'); ?>
<?php
mysql_select_db($database_crediembrapa, $crediembrapa);
$query_report = "SELECT sementes_serie0.cupom, DATE_FORMAT(sementes_serie0.`data`,'%d-%m-%Y') AS `data`, cadastro.nome_do_cliente, cadastro.numero_cpf_cnpj FROM sementes_serie0, cadastro WHERE sementes_serie0.numero_pessoa=cadastro.numero_da_pessoa";
$report = mysql_query($query_report, $crediembrapa) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);
do {
	$csv.= $row_report['cupom'].','.$row_report['data'].','.$row_report['nome_do_cliente'].','.$row_report['numero_cpf_cnpj']."\n";
} while ($row_report = mysql_fetch_assoc($report));
echo $csv;

mysql_free_result($report);
?>