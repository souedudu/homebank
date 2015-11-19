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

$DETALHE[9]['incial'] = 52;
$DETALHE[9]['tamanho'] = 17;
$DETALHE[9]['campo'] = 'vlamorparcela';
$DETALHE[9]['tipo'] = 'n';

$DETALHE[10]['incial'] = 69;
$DETALHE[10]['tamanho'] = 17;
$DETALHE[10]['campo'] = 'vljurparcela';
$DETALHE[10]['tipo'] = 'n';

$DETALHE[11]['incial'] = 86;
$DETALHE[11]['tamanho'] = 17;
$DETALHE[11]['campo'] = 'vlcorparcela';
$DETALHE[11]['tipo'] = 'n';

$DETALHE[12]['incial'] = 103;
$DETALHE[12]['tamanho'] = 17;
$DETALHE[12]['campo'] = 'vlseguro';
$DETALHE[12]['tipo'] = 'n';

$DETALHE[13]['incial'] = 120;
$DETALHE[13]['tamanho'] = 17;
$DETALHE[13]['campo'] = 'vljudiarios';
$DETALHE[13]['tipo'] = 'n';

$DETALHE[14]['incial'] = 137;
$DETALHE[14]['tamanho'] = 1;
$DETALHE[14]['campo'] = 'codsitparcela';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 213;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlvalorizparcela';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 230;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlsaldodevinicial';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 247;
$DETALHE[14]['tamanho'] = 1;
$DETALHE[14]['campo'] = 'codsitseguro';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 345;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlorigparcela';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 362;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlorigamort';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[14]['incial'] = 379;
$DETALHE[14]['tamanho'] = 10;
$DETALHE[14]['campo'] = 'datultcormon';
$DETALHE[14]['tipo'] = 'd';

$DETALHE[14]['incial'] = 389;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlparulticor';
$DETALHE[14]['tipo'] = 'n';

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
?>
