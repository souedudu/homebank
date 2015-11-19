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
$DETALHE[1]['tamanho'] = 7; 
$DETALHE[1]['campo'] = 'codcliente'; 
$DETALHE[1]['tipo'] = 'n'; 

$DETALHE[2]['incial'] = 8; 
$DETALHE[2]['tamanho'] = 10; 
$DETALHE[2]['campo'] = 'numcontacorrente'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 18; 
$DETALHE[3]['tamanho'] = 7; 
$DETALHE[3]['campo'] = 'nummatricula'; 
$DETALHE[3]['tipo'] = 'n'; 

$DETALHE[4]['incial'] = 25; 
$DETALHE[4]['tamanho'] = 10; 
$DETALHE[4]['campo'] = 'datentrada'; 
$DETALHE[4]['tipo'] = 'd'; 

$DETALHE[5]['incial'] = 35; 
$DETALHE[5]['tamanho'] = 10; 
$DETALHE[5]['campo'] = 'datsaida'; 
$DETALHE[5]['tipo'] = 'd'; 

$DETALHE[6]['incial'] = 45; 
$DETALHE[6]['tamanho'] = 1; 
$DETALHE[6]['campo'] = 'codsituacao'; 
$DETALHE[6]['tipo'] = 'n'; 

$DETALHE[7]['incial'] = 46; 
$DETALHE[7]['tamanho'] = 2; 
$DETALHE[7]['campo'] = 'codcondassociado'; 
$DETALHE[7]['tipo'] = 'n'; 

$DETALHE[8]['incial'] = 48; 
$DETALHE[8]['tamanho'] = 1; 
$DETALHE[8]['campo'] = 'coddireitovoto'; 
$DETALHE[8]['tipo'] = 'n'; 

$DETALHE[9]['incial'] = 49; 
$DETALHE[9]['tamanho'] = 17; 
$DETALHE[9]['campo'] = 'vlsaldointegralizado'; 
$DETALHE[9]['tipo'] = 'n'; 

$DETALHE[10]['incial'] = 66; 
$DETALHE[10]['tamanho'] = 17; 
$DETALHE[10]['campo'] = 'vlsubscrito'; 
$DETALHE[10]['tipo'] = 'n'; 

$DETALHE[11]['incial'] = 83; 
$DETALHE[11]['tamanho'] = 17; 
$DETALHE[11]['campo'] = 'vldevolver'; 
$DETALHE[11]['tipo'] = 'n'; 

$DETALHE[12]['incial'] = 100; 
$DETALHE[12]['tamanho'] = 17; 
$DETALHE[12]['campo'] = 'vldebito'; 
$DETALHE[12]['tipo'] = 'n'; 

$DETALHE[13]['incial'] = 117; 
$DETALHE[13]['tamanho'] = 2; 
$DETALHE[13]['campo'] = 'codformadebito'; 
$DETALHE[13]['tipo'] = 'n'; 

$DETALHE[14]['incial'] = 119; 
$DETALHE[14]['tamanho'] = 2; 
$DETALHE[14]['campo'] = 'numperiododebito'; 
$DETALHE[14]['tipo'] = 'n'; 

$DETALHE[15]['incial'] = 121; 
$DETALHE[15]['tamanho'] = 1; 
$DETALHE[15]['campo'] = 'coddebitoindeterminado'; 
$DETALHE[15]['tipo'] = 'n'; 

$DETALHE[16]['incial'] = 122; 
$DETALHE[16]['tamanho'] = 1; 
$DETALHE[16]['campo'] = 'codparticiparateio'; 
$DETALHE[16]['tipo'] = 'n'; 

$DETALHE[17]['incial'] = 123; 
$DETALHE[17]['tamanho'] = 1; 
$DETALHE[17]['campo'] = 'codresticaorateio'; 
$DETALHE[17]['tipo'] = 'n'; 

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "contacapital";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "contacapital";

/*
Tipo da Query MySQL
	1 = Insert;
	2 = Update;
	3 = Delete;
*/
$CONF['tiposql'] = 1;

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
