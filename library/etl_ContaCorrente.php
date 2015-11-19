<?php
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
$DETALHE[1]['tamanho'] = 10; 
$DETALHE[1]['campo'] = 'numcontacorrente'; 
$DETALHE[1]['tipo'] = 'n'; 

$DETALHE[2]['incial'] = 11; 
$DETALHE[2]['tamanho'] = 7; 
$DETALHE[2]['campo'] = 'codcliente'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 18; 
$DETALHE[3]['tamanho'] = 7; 
$DETALHE[3]['campo'] = 'codcliente2'; 
$DETALHE[3]['tipo'] = 'n'; 

$DETALHE[4]['incial'] = 25; 
$DETALHE[4]['tamanho'] = 7; 
$DETALHE[4]['campo'] = 'codcliente3'; 
$DETALHE[4]['tipo'] = 'n'; 

$DETALHE[5]['incial'] = 32; 
$DETALHE[5]['tamanho'] = 7; 
$DETALHE[5]['campo'] = 'codcliente4'; 
$DETALHE[5]['tipo'] = 'n'; 

$DETALHE[6]['incial'] = 39; 
$DETALHE[6]['tamanho'] = 10; 
$DETALHE[6]['campo'] = 'databerturaconta'; 
$DETALHE[6]['tipo'] = 'd'; 

$DETALHE[7]['incial'] = 49; 
$DETALHE[7]['tamanho'] = 10; 
$DETALHE[7]['campo'] = 'datencerramentoconta'; 
$DETALHE[7]['tipo'] = 'd'; 

$DETALHE[8]['incial'] = 59; 
$DETALHE[8]['tamanho'] = 10; 
$DETALHE[8]['campo'] = 'datultmovconta'; 
$DETALHE[8]['tipo'] = 'd'; 

$DETALHE[9]['incial'] = 69; 
$DETALHE[9]['tamanho'] = 10; 
$DETALHE[9]['campo'] = 'datultatucadastral'; 
$DETALHE[9]['tipo'] = 'd'; 

$DETALHE[10]['incial'] = 79; 
$DETALHE[10]['tamanho'] = 1; 
$DETALHE[10]['campo'] = 'codsituacaoconta'; 
$DETALHE[10]['tipo'] = 'n'; 

$DETALHE[11]['incial'] = 80; 
$DETALHE[11]['tamanho'] = 2; 
$DETALHE[11]['campo'] = 'codtipoconta'; 
$DETALHE[11]['tipo'] = 's'; 

$DETALHE[12]['incial'] = 82; 
$DETALHE[12]['tamanho'] = 2; 
$DETALHE[12]['campo'] = 'codgrupoconta'; 
$DETALHE[12]['tipo'] = 's'; 

$DETALHE[13]['incial'] = 84; 
$DETALHE[13]['tamanho'] = 1; 
$DETALHE[13]['campo'] = 'codcategoriaconta'; 
$DETALHE[13]['tipo'] = 's'; 

$DETALHE[14]['incial'] = 86; 
$DETALHE[14]['tamanho'] = 10; 
$DETALHE[14]['campo'] = 'datbloqueioconta'; 
$DETALHE[14]['tipo'] = 'd'; 

$DETALHE[15]['incial'] = 100; 
$DETALHE[15]['tamanho'] = 10; 
$DETALHE[15]['campo'] = 'numtotallancamentos'; 
$DETALHE[15]['tipo'] = 'n'; 

$DETALHE[16]['incial'] = 110; 
$DETALHE[16]['tamanho'] = 10; 
$DETALHE[16]['campo'] = 'datsaldodiaanterior'; 
$DETALHE[16]['tipo'] = 'd'; 

$DETALHE[17]['incial'] = 130; 
$DETALHE[17]['tamanho'] = 10; 
$DETALHE[17]['campo'] = 'datultimolimitecredito'; 
$DETALHE[17]['tipo'] = 'd'; 

$DETALHE[18]['incial'] = 167; 
$DETALHE[18]['tamanho'] = 17; 
$DETALHE[18]['campo'] = 'vlsaldodispatual'; 
$DETALHE[18]['tipo'] = 'n'; 

$DETALHE[19]['incial'] = 201; 
$DETALHE[19]['tamanho'] = 17; 
$DETALHE[19]['campo'] = 'vlsaldobloqatual'; 
$DETALHE[19]['tipo'] = 'n'; 

$DETALHE[20]['incial'] = 218; 
$DETALHE[20]['tamanho'] = 17; 
$DETALHE[20]['campo'] = 'vlsaldoantutilizlimitecredito'; 
$DETALHE[20]['tipo'] = 'n'; 

$DETALHE[21]['incial'] = 320; 
$DETALHE[21]['tamanho'] = 17; 
$DETALHE[21]['campo'] = 'vljurosacumulimitecredito'; 
$DETALHE[21]['tipo'] = 'n'; 

$DETALHE[22]['incial'] = 447; 
$DETALHE[22]['tamanho'] = 2; 
$DETALHE[22]['campo'] = 'codmodalidadeconta'; 
$DETALHE[22]['tipo'] = 's'; 

$DETALHE[23]['incial'] = 286; 
$DETALHE[23]['tamanho'] = 17; 
$DETALHE[23]['campo'] = 'vlutilatuallimcredito'; 
$DETALHE[23]['tipo'] = 'n'; 

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "contacorrente";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "contacorrente";

/*
Tipo da Query MySQL
	1 = Insert;
	2 = Update;
	3 = Delete;
*/
$CONF['tiposql'] = 1;

/* Campos chaves da tabela para update */
$CONF['campochave01'] = 'numcontacorrente';


/* Instância da Classe ETL */
$Processo = new ETL($DETALHE,$CONF);

$Processo->DbHost = $SITE['CONEXAO']['HOST'];
$Processo->DbUser = $SITE['CONEXAO']['USER'];
$Processo->DbPass = $SITE['CONEXAO']['PASS'];
$Processo->DbDataBase = $SITE['CONEXAO']['DATABASE'];

$Processo->CarregaRegistro();
?>
