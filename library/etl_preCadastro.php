<?
include "../Connections/homebank_conecta.php";

mysql_select_db("homebank");

$sql = "SELECT id, contacorrente FROM precadastro";
$res = mysql_query($sql)or die("L7: ".mysql_error());

$cont=0;
while(false !== ($dado = mysql_fetch_array($res)))
{	
	$sql = "SELECT numcontacorrente FROM contacorrente WHERE numcontacorrente='".$dado[1]."'";
	$r = mysql_query($sql)or die($sql."<BR />L12: ".mysql_error());
	
	if(mysql_num_rows($res)>0)
	{
		$sql = "UPDATE solicitacaoserv SET numcontacorrente='".mysql_result($r, 0, "numcontacorrente")."' WHERE numcontacorrente='p".$dado[0]."'";
		mysql_query($sql)or die("L17: ".mysql_error());
		
		$sql = "DELETE FROM precadastro WHERE id=".$dado[0];
		mysql_query($sql)or die("L19: ".mysql_error());
		
		echo "<p><b>Conta corrente nº:</b> ".mysql_result($r, 0, "numcontacorrente")." Atualizada com sucesso</p>";

		$cont++;
	}
}
echo "<p>".$cont." registros atualizados no total.</p><p><a href='javascript: history.go(-1)'>Voltar</a></p>";
?>