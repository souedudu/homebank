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
$DETALHE[2]['tamanho'] = 6; 
$DETALHE[2]['campo'] = 'numcheque'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 17; 
$DETALHE[3]['tamanho'] = 10; 
$DETALHE[3]['campo'] = 'datdevolucao'; 
$DETALHE[3]['tipo'] = 'd'; 

$DETALHE[4]['incial'] = 27; 
$DETALHE[4]['tamanho'] = 50; 
$DETALHE[4]['campo'] = 'desmotivodevolucao'; 
$DETALHE[4]['tipo'] = 's'; 

$DETALHE[5]['incial'] = 77; 
$DETALHE[5]['tamanho'] = 17; 
$DETALHE[5]['campo'] = 'vlchequedevolvido'; 
$DETALHE[5]['tipo'] = 'n'; 

$DETALHE[6]['incial'] = 94; 
$DETALHE[6]['tamanho'] = 1; 
$DETALHE[6]['campo'] = 'codmovgerado'; 
$DETALHE[6]['tipo'] = 'n'; 

$DETALHE[7]['incial'] = 95; 
$DETALHE[7]['tamanho'] = 1; 
$DETALHE[7]['campo'] = 'coddevolucaocaixa'; 
$DETALHE[7]['tipo'] = 'n'; 

$DETALHE[8]['incial'] = 96; 
$DETALHE[8]['tamanho'] = 2; 
$DETALHE[8]['campo'] = 'codidentmotdevbacen'; 
$DETALHE[8]['tipo'] = 's'; 

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "devolucaoch";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "devolucaoch";

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
