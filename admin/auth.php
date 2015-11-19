<?
//require_once '../Connections/homebank_conecta.php';
function auth($usuario, $link, $menu=0)
{
	global $homebank_conecta;
	global $database_homebank_conecta;
	mysql_select_db($database_homebank_conecta, $homebank_conecta);

	$sql = "SELECT * FROM acessousu, menu WHERE menu.codmenu=acessousu.codmenu AND menu.desurl='".$link."' AND acessousu.codusuario=".$usuario." AND menu.codpaimenu=".$menu;
	
	//echo $sql;
	
	$res = mysql_query($sql, $homebank_conecta)or die(mysql_error());

	if(mysql_num_rows($res)==0)
		return "javascript: alert('Você não tem permissão para acessar esta área!')";	
	else
		return $link;
}
function bauth($usuario, $link)
{
	global $homebank_conecta;
	global $database_homebank_conecta;
	mysql_select_db($database_homebank_conecta, $homebank_conecta);

	$sql = "SELECT * FROM acessousu, menu WHERE menu.codmenu=acessousu.codmenu AND menu.desmenu='".$link."' AND acessousu.codusuario=".$usuario;
	
	//echo $sql;
	
	$res = mysql_query($sql, $homebank_conecta)or die(mysql_error());

	if(mysql_num_rows($res)==0)
		return false;	
	else
		return true;
}
function verificaAuth($usuario, $link)
{
	if(bauth($usuario, $link)==false) {
		echo "<script> alert('Você não tem permissão para acessar esta área!'); history.go(-1); </script>";
		exit;
	}
}
?>