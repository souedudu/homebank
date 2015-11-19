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
$DETALHE[2]['tamanho'] = 1; 
$DETALHE[2]['campo'] = 'codtipocliente'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 19; 
$DETALHE[3]['tamanho'] = 14; 
$DETALHE[3]['campo'] = 'numcpfcnpj'; 
$DETALHE[3]['tipo'] = 's'; 

$DETALHE[4]['incial'] = 33; 
$DETALHE[4]['tamanho'] = 50; 
$DETALHE[4]['campo'] = 'nomcliente'; 
$DETALHE[4]['tipo'] = 's'; 

$DETALHE[5]['incial'] = 83; 
$DETALHE[5]['tamanho'] = 30; 
$DETALHE[5]['campo'] = 'desemail'; 
$DETALHE[5]['tipo'] = 's'; 

$DETALHE[6]['incial'] = 223; 
$DETALHE[6]['tamanho'] = 10; 
$DETALHE[6]['campo'] = 'datnascimento'; 
$DETALHE[6]['tipo'] = 'd'; 

$DETALHE[7]['incial'] = 296; 
$DETALHE[7]['tamanho'] = 15; 
$DETALHE[7]['campo'] = 'numrg'; 
$DETALHE[7]['tipo'] = 's'; 

$DETALHE[8]['incial'] = 311; 
$DETALHE[8]['tamanho'] = 10; 
$DETALHE[8]['campo'] = 'desorgaoexprg'; 
$DETALHE[8]['tipo'] = 's'; 

$DETALHE[9]['incial'] = 321; 
$DETALHE[9]['tamanho'] = 2; 
$DETALHE[9]['campo'] = 'codufrg'; 
$DETALHE[9]['tipo'] = 's'; 

$DETALHE[10]['incial'] = 323; 
$DETALHE[10]['tamanho'] = 10; 
$DETALHE[10]['campo'] = 'datemissaorg'; 
$DETALHE[10]['tipo'] = 'd'; 

$DETALHE[11]['incial'] = 388; 
$DETALHE[11]['tamanho'] = 1; 
$DETALHE[11]['campo'] = 'codestadocivil'; 
$DETALHE[11]['tipo'] = 's'; 

$DETALHE[12]['incial'] = 389; 
$DETALHE[12]['tamanho'] = 1; 
$DETALHE[12]['campo'] = 'flasexo'; 
$DETALHE[12]['tipo'] = 's'; 

$DETALHE[13]['incial'] = 478; 
$DETALHE[13]['tamanho'] = 4; 
$DETALHE[13]['campo'] = 'codnucleo'; 
$DETALHE[13]['tipo'] = 'n'; 

$DETALHE[14]['incial'] = 768; 
$DETALHE[14]['tamanho'] = 8; 
$DETALHE[14]['campo'] = 'numtelefonecel'; 
$DETALHE[14]['tipo'] = 's';

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "cadastro";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "cliente";

/*
Tipo da Query MySQL
	1 = Insert;
	2 = Update;
	3 = Delete;
*/
$CONF['tiposql'] = 1;

/* Campos chaves da tabela para update */
// Ex: $CONF['campochave01'] = 'codcliente';
$CONF['campochave01'] = 'codcliente';

/* Instância da Classe ETL */
$Processo = new ETL($DETALHE,$CONF);

$Processo->DbHost = $SITE['CONEXAO']['HOST'];
$Processo->DbUser = $SITE['CONEXAO']['USER'];
$Processo->DbPass = $SITE['CONEXAO']['PASS'];
$Processo->DbDataBase = $SITE['CONEXAO']['DATABASE'];

$Processo->CarregaRegistro();
?>