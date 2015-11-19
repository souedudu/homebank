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

$DETALHE[2]['incial'] = 155;
$DETALHE[2]['tamanho'] = 2; 
$DETALHE[2]['campo'] = 'coduf'; 
$DETALHE[2]['tipo'] = 's'; 

$DETALHE[3]['incial'] = 59; 
$DETALHE[3]['tamanho'] = 6; 
$DETALHE[3]['campo'] = 'numendereco'; 
$DETALHE[3]['tipo'] = 's'; 

$DETALHE[4]['incial'] = 65; 
$DETALHE[4]['tamanho'] = 20; 
$DETALHE[4]['campo'] = 'descompendereco'; 
$DETALHE[4]['tipo'] = 's'; 

$DETALHE[5]['incial'] = 157; 
$DETALHE[5]['tamanho'] = 8; 
$DETALHE[5]['campo'] = 'numcep'; 
$DETALHE[5]['tipo'] = 's';

$DETALHE[6]['incial'] = 85; 
$DETALHE[6]['tamanho'] = 30; 
$DETALHE[6]['campo'] = 'desbairro'; 
$DETALHE[6]['tipo'] = 's'; 

$DETALHE[7]['incial'] = 115; 
$DETALHE[7]['tamanho'] = 40; 
$DETALHE[7]['campo'] = 'descidade'; 
$DETALHE[7]['tipo'] = 's'; 

$DETALHE[8]['incial'] = 165; 
$DETALHE[8]['tamanho'] = 4; 
$DETALHE[8]['campo'] = 'numdddtelefone';
$DETALHE[8]['tipo'] = 's'; 

$DETALHE[9]['incial'] = 169; 
$DETALHE[9]['tamanho'] = 8; 
$DETALHE[9]['campo'] = 'numtelefone'; 
$DETALHE[9]['tipo'] = 's'; 

$DETALHE[10]['incial'] = 177; 
$DETALHE[10]['tamanho'] = 4; 
$DETALHE[10]['campo'] = 'numramaltelefone';
$DETALHE[10]['tipo'] = 's'; 

$DETALHE[11]['incial'] = 9;
$DETALHE[11]['tamanho'] = 50;
$DETALHE[11]['campo'] = 'desendereco';
$DETALHE[11]['tipo'] = 's';

$DETALHE[12]['incial'] = 8;
$DETALHE[12]['tamanho'] = 1;
$DETALHE[12]['campo'] = 'tipoendereco';
$DETALHE[12]['tipo'] = 's';
/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "endereco";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "cliente";

/*
Tipo da Query MySQL
	1 = Insert;
	2 = Update;
	3 = Delete;
*/
$CONF['tiposql'] = 2;

/* Campos chaves da tabela para update */
$CONF['campochave01'] = 'codcliente';

/* Instância da Classe ETL */
$Processo = new ETL($DETALHE,$CONF);

$Processo->DbHost = $SITE['CONEXAO']['HOST'];
$Processo->DbUser = $SITE['CONEXAO']['USER'];
$Processo->DbPass = $SITE['CONEXAO']['PASS'];
$Processo->DbDataBase = $SITE['CONEXAO']['DATABASE'];

$Processo->CarregaRegistro();
?>
