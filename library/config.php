<?@session_start();
//Provedor PMTRAINING
//Da início as variáveis de seção

// Define as constantes para conexão com o Banco de Dados
define("conexao_host","localhost");
define("conexao_user","root");
define("conexao_pass","");
define("conexao_db","homebank");



define("Host","localhost");//endereço do servidor de email
define("SMTPAuth",false); //Se usar SMTPAuth
define("SMTPSecure",'ssl'); //se usar ssl/tsl/'' ou vazio se não usar
define("Port",993); //porta do servidor smtp
define("SetFromNome",'SICOOB'); //nome de envio do email
define("SetFromEmail",'relac@crediembrapa.com.br'); //email de envio do email

define("Username","relac@crediembrapa.com.br");//usuario para logar no servidor smtp
define("Password","credi%%%2015");//senha para logar no servidor smtp


define("AddReplyTo",'relac@crediembrapa.com.br'); // caso queria uma cópia de todos os emails para alguma conta


$SITE['CONEXAO']['HOST'] = "localhost";
$SITE['CONEXAO']['USER'] = "root";
$SITE['CONEXAO']['PASS'] = "";
$SITE['CONEXAO']['DATABASE'] = "homebank";

//Caminho do diretório onde estam salvos os arquivos .txt para Carga no DB.

$CONF['diretorio'] = "../arquivos/txt/";

// Seta a data atual pro sistema
$DataAtual = date('d/m/Y');

/*
//Da início as variáveis de seção

session_start();

//Caminho do diretório onde estam salvos os arquivos .txt para Carga no DB.

$CONF['diretorio'] = "../arquivos/txt/";

// Seta a data atual pro sistema
$DataAtual = date('d/m/Y');

*/
?>
