<?
/* Inclusão das bibliotecas necessárias */
include_once("config.php");
include_once("class_etl.php");

/*
Sempre começar a array sequencial com sua primeira
chave com valor 1, não começar com 0.

Estrutura da Array:
	$DETALHE[1]['incial'] = 1; // posição inicial dentro do .txt
	$DETALHE[1]['tamanho'] = 7; // posição tamanho dentro do .txt
	$DETALHE[1]['campo'] = 'codcliente'; // nome do campo na tabela
	$DETALHE[1]['tipo'] = 'n'; // Tipos: n=número, s=string e d=data

$DETALHE[]['incial'] = ;
$DETALHE[]['tamanho'] = ;
$DETALHE[]['campo'] = '';
$DETALHE[]['tipo'] = '';

*/
$DETALHE[1]['incial'] = 1;
$DETALHE[1]['tamanho'] = 7;
$DETALHE[1]['campo'] = 'codcliente';
$DETALHE[1]['tipo'] = 'n';

$DETALHE[2]['incial'] = 8;
$DETALHE[2]['tamanho'] = 8;
$DETALHE[2]['campo'] = 'numcontrato';
$DETALHE[2]['tipo'] = 'n';

$DETALHE[3]['incial'] = 16;
$DETALHE[3]['tamanho'] = 2;
$DETALHE[3]['campo'] = 'codproduto';
$DETALHE[3]['tipo'] = 'n';

$DETALHE[4]['incial'] = 18;
$DETALHE[4]['tamanho'] = 4;
$DETALHE[4]['campo'] = 'codmodcredito';
$DETALHE[4]['tipo'] = 'n';

$DETALHE[5]['incial'] = 22;
$DETALHE[5]['tamanho'] = 3;
$DETALHE[5]['campo'] = 'numparcela';
$DETALHE[5]['tipo'] = 'n';

$DETALHE[6]['incial'] = 25;
$DETALHE[6]['tamanho'] = 10;
$DETALHE[6]['campo'] = 'datvencimento';
$DETALHE[6]['tipo'] = 'd';

$DETALHE[7]['incial'] = 35;
$DETALHE[7]['tamanho'] = 17;
$DETALHE[7]['campo'] = 'vlparcela';
$DETALHE[7]['tipo'] = 'n';

$DETALHE[8]['incial'] = 52;
$DETALHE[8]['tamanho'] = 17;
$DETALHE[8]['campo'] = 'vlamorparcela';
$DETALHE[8]['tipo'] = 'n';

$DETALHE[9]['incial'] = 69;
$DETALHE[9]['tamanho'] = 17;
$DETALHE[9]['campo'] = 'vljurparcela';
$DETALHE[9]['tipo'] = 'n';

$DETALHE[10]['incial'] = 86;
$DETALHE[10]['tamanho'] = 17;
$DETALHE[10]['campo'] = 'vlcorparcela';
$DETALHE[10]['tipo'] = 'n';

$DETALHE[11]['incial'] = 103;
$DETALHE[11]['tamanho'] = 17;
$DETALHE[11]['campo'] = 'vlseguro';
$DETALHE[11]['tipo'] = 'n';

$DETALHE[12]['incial'] = 120;
$DETALHE[12]['tamanho'] = 17;
$DETALHE[12]['campo'] = 'vljudiarios';
$DETALHE[12]['tipo'] = 'n';

$DETALHE[13]['incial'] = 137;
$DETALHE[13]['tamanho'] = 1;
$DETALHE[13]['campo'] = 'codsitparcela';
$DETALHE[13]['tipo'] = 'n';

$DETALHE[14]['incial'] = 213;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlvalorizparcela';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[15]['incial'] = 230;
$DETALHE[15]['tamanho'] = 17;
$DETALHE[15]['campo'] = 'vlsaldevinicial';
$DETALHE[15]['tipo'] = 'n';

$DETALHE[16]['incial'] = 247;
$DETALHE[16]['tamanho'] = 1;
$DETALHE[16]['campo'] = 'codsitseguro';
$DETALHE[16]['tipo'] = 'n';

$DETALHE[17]['incial'] = 345;
$DETALHE[17]['tamanho'] = 17;
$DETALHE[17]['campo'] = 'vlorigparcela';
$DETALHE[17]['tipo'] = 'n';

$DETALHE[18]['incial'] = 362;
$DETALHE[18]['tamanho'] = 17;
$DETALHE[18]['campo'] = 'vlorigamort';
$DETALHE[18]['tipo'] = 'n';

$DETALHE[19]['incial'] = 379;
$DETALHE[19]['tamanho'] = 10;
$DETALHE[19]['campo'] = 'datultcormon';
$DETALHE[19]['tipo'] = 'd';

$DETALHE[20]['incial'] = 389;
$DETALHE[20]['tamanho'] = 17;
$DETALHE[20]['campo'] = 'vlparuticor';
$DETALHE[20]['tipo'] = 'n';

$DETALHE[21]['incial'] = 183;
$DETALHE[21]['tamanho'] = 10;
$DETALHE[21]['campo'] = 'dtultapjurparcela';
$DETALHE[21]['tipo'] = 'd';

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "planopagamento";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "planopagamento";

/*
Tipo da Query MySQL
	1 = Insert;
	2 = Update;
	3 = Delete;
*/
$CONF['tiposql'] = 1;

/* Campos chaves da tabela para update */
// Ex: $CONF['campochave01'] = 'codcliente';
$CONF['campochave01'] = 'numcontrato';


/* Instância da Classe ETL */
$Processo = new ETL($DETALHE,$CONF);

$Processo->DbHost = $SITE['CONEXAO']['HOST'];
$Processo->DbUser = $SITE['CONEXAO']['USER'];
$Processo->DbPass = $SITE['CONEXAO']['PASS'];
$Processo->DbDataBase = $SITE['CONEXAO']['DATABASE'];

$Processo->CarregaRegistro();

unset ($DETALHE);
unset ($CONF);
?>
