<?@session_start();
//Provedor PMTRAINING
//Da in�cio as vari�veis de se��o

// Define as constantes para conex�o com o Banco de Dados
define("conexao_host","localhost");
define("conexao_user","root");
define("conexao_pass","");
define("conexao_db","homebank");



define("Host","localhost");//endere�o do servidor de email
define("SMTPAuth",false); //Se usar SMTPAuth
define("SMTPSecure",'ssl'); //se usar ssl/tsl/'' ou vazio se n�o usar
define("Port",993); //porta do servidor smtp
define("SetFromNome",'SICOOB'); //nome de envio do email
define("SetFromEmail",'relac@crediembrapa.com.br'); //email de envio do email

define("Username","relac@crediembrapa.com.br");//usuario para logar no servidor smtp
define("Password","credi%%%2015");//senha para logar no servidor smtp


define("AddReplyTo",'relac@crediembrapa.com.br'); // caso queria uma c�pia de todos os emails para alguma conta


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
