<?
//Provedor PMTRAINING
//Da in�cio as vari�veis de se��o

session_start();

// Define as constantes para conex�o com o Banco de Dados
define("conexao_host","localhost");
define("conexao_user","root");
define("conexao_pass","");
define("conexao_db","homebank");

$SITE['CONEXAO']['HOST'] = "localhost";
$SITE['CONEXAO']['USER'] = "root";
$SITE['CONEXAO']['PASS'] = "";
$SITE['CONEXAO']['DATABASE'] = "homebank";

//Caminho do diret�rio onde estam salvos os arquivos .txt para Carga no DB.

$CONF['diretorio'] = "../arquivos/txt/";

// Seta a data atual pro sistema
$DataAtual = date('d/m/Y');

/*
//Da in�cio as vari�veis de se��o

session_start();

//Caminho do diret�rio onde estam salvos os arquivos .txt para Carga no DB.

$CONF['diretorio'] = "../arquivos/txt/";

// Seta a data atual pro sistema
$DataAtual = date('d/m/Y');

*/
?>
