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
$DETALHE[4]['campo'] = 'codidemodcred';
$DETALHE[4]['tipo'] = 'n';

$DETALHE[5]['incial'] = 37;
$DETALHE[5]['tamanho'] = 10;
$DETALHE[5]['campo'] = 'datoperacao';
$DETALHE[5]['tipo'] = 'd';

$DETALHE[6]['incial'] = 47;
$DETALHE[6]['tamanho'] = 10;
$DETALHE[6]['campo'] = 'datmoventrada';
$DETALHE[6]['tipo'] = 'd';

$DETALHE[7]['incial'] = 57;
$DETALHE[7]['tamanho'] = 10;
$DETALHE[7]['campo'] = 'datvencopecred';
$DETALHE[7]['tipo'] = 'd';

$DETALHE[8]['incial'] = 67;
$DETALHE[8]['tamanho'] = 12;
$DETALHE[8]['campo'] = 'vlpercjuros';
$DETALHE[8]['tipo'] = 'n';

$DETALHE[9]['incial'] = 79;
$DETALHE[9]['tamanho'] = 12;
$DETALHE[9]['campo'] = 'vlpercmora';
$DETALHE[9]['tipo'] = 'n';

$DETALHE[10]['incial'] = 91;
$DETALHE[10]['tamanho'] = 12;
$DETALHE[10]['campo'] = 'vlpercmulta';
$DETALHE[10]['tipo'] = 'n';

$DETALHE[11]['incial'] = 103;
$DETALHE[11]['tamanho'] = 2;
$DETALHE[11]['campo'] = 'codsituacao';
$DETALHE[11]['tipo'] = 'n';

$DETALHE[12]['incial'] = 105;
$DETALHE[12]['tamanho'] = 1;
$DETALHE[12]['campo'] = 'codfinanciaiof';
$DETALHE[12]['tipo'] = 'n';

$DETALHE[13]['incial'] = 106;
$DETALHE[13]['tamanho'] = 17;
$DETALHE[13]['campo'] = 'vlcontrato';
$DETALHE[13]['tipo'] = 'n';

$DETALHE[14]['incial'] = 123;
$DETALHE[14]['tamanho'] = 17;
$DETALHE[14]['campo'] = 'vlliqcontrato';
$DETALHE[14]['tipo'] = 'n';

$DETALHE[15]['incial'] = 140;
$DETALHE[15]['tamanho'] = 17;
$DETALHE[15]['campo'] = 'vljuros';
$DETALHE[15]['tipo'] = 'n';

$DETALHE[16]['incial'] = 157;
$DETALHE[16]['tamanho'] = 17;
$DETALHE[16]['campo'] = 'vliof';
$DETALHE[16]['tipo'] = 'n';

$DETALHE[17]['incial'] = 174;
$DETALHE[17]['tamanho'] = 17;
$DETALHE[17]['campo'] = 'valor_da_tarifa';
$DETALHE[17]['tipo'] = 'n';

$DETALHE[18]['incial'] = 191;
$DETALHE[18]['tamanho'] = 1;
$DETALHE[18]['campo'] = 'codcobiof';
$DETALHE[18]['tipo'] = 'n';

$DETALHE[19]['incial'] = 231;
$DETALHE[19]['tamanho'] = 2;
$DETALHE[19]['campo'] = 'codidenivrisco';
$DETALHE[19]['tipo'] = 's';

$DETALHE[20]['incial'] = 305;
$DETALHE[20]['tamanho'] = 10;
$DETALHE[20]['campo'] = 'numcontacorrente';
$DETALHE[20]['tipo'] = 'n';

$DETALHE[21]['incial'] = 315;
$DETALHE[21]['tamanho'] = 17;
$DETALHE[21]['campo'] = 'vlajustejuros';
$DETALHE[21]['tipo'] = 'n';

$DETALHE[22]['incial'] = 424;
$DETALHE[22]['tamanho'] = 17;
$DETALHE[22]['campo'] = 'vlsaldodevcont';
$DETALHE[22]['tipo'] = 'n';

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "contratocredito";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "contratocredito";

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
