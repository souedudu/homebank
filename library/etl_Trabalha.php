<?php
/* Inclus�o das bibliotecas necess�rias */
include_once("config.php");
include_once("class_etl.php");

/* 
Sempre come�ar a array sequencial com sua primeira
chave com valor 1, n�o come�ar com 0.

Estrutura da Array:
	$DETALHE[1]['incial'] = 1; // posi��o inicial dentro do .txt
	$DETALHE[1]['tamanho'] = 7; // posi��o tamanho dentro do .txt
	$DETALHE[1]['campo'] = 'codcliente'; // nome do campo na tabela
	$DETALHE[1]['tipo'] = 'n'; // Tipos: n=n�mero, s=string e d=data

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
$DETALHE[2]['tamanho'] = 20; 
$DETALHE[2]['campo'] = 'codmatricula'; 
$DETALHE[2]['tipo'] = 'n';

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "trabalha";

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

/* Inst�ncia da Classe ETL */
$Processo = new ETL($DETALHE,$CONF);

$Processo->DbHost = $SITE['CONEXAO']['HOST'];
$Processo->DbUser = $SITE['CONEXAO']['USER'];
$Processo->DbPass = $SITE['CONEXAO']['PASS'];
$Processo->DbDataBase = $SITE['CONEXAO']['DATABASE'];

$Processo->CarregaRegistro();
?>
