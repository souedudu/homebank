<? 
/* Inclusão das bibliotecas necessárias */
include_once("config.php");

$SITE['CONEXAO']['HOST'] = "localhost";
$SITE['CONEXAO']['USER'] = "root";
$SITE['CONEXAO']['PASS'] = "";
$SITE['CONEXAO']['DATABASE'] = "homebank";

$conex = @mysql_connect($SITE['CONEXAO']['HOST'],$SITE['CONEXAO']['USER'],$SITE['CONEXAO']['PASS']);
@mysql_select_db($SITE['CONEXAO']['DATABASE']);

//$result = mysql_query("SELECT * FROM cliente");
//$result = mysql_query("SELECT * FROM contacapital");
//$result = mysql_query("SELECT * FROM devolucaoch");
//$result = mysql_query("SELECT * FROM contacorrente");
$result = mysql_query("SELECT * FROM lancamentosccapital");
//$result = mysql_query("SELECT * FROM aplicacaocaprem");

$fields = mysql_num_fields($result);
$rows   = mysql_num_rows($result);
$table = mysql_field_table($result, 0);

for ($i=0; $i < $fields; $i++) {
    $type  = mysql_field_type($result, $i);
    $name  = mysql_field_name($result, $i);
    $len   = mysql_field_len($result, $i);
    $flags = mysql_field_flags($result, $i);
    //echo $type." / ".$name." / ".$len." / ".$flags."<br/>";
	echo $name."<br/>";
}
mysql_free_result($result);
mysql_close();

?>