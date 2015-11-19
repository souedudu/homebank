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
$DETALHE[1]['tamanho'] = 10; 
$DETALHE[1]['campo'] = 'numcontacaptacao'; 
$DETALHE[1]['tipo'] = 'n'; 

$DETALHE[2]['incial'] = 11; 
$DETALHE[2]['tamanho'] = 2; 
$DETALHE[2]['campo'] = 'codproduto'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 13; 
$DETALHE[3]['tamanho'] = 4; 
$DETALHE[3]['campo'] = 'codidentmodproduto'; 
$DETALHE[3]['tipo'] = 'n'; 

$DETALHE[4]['incial'] = 17; 
$DETALHE[4]['tamanho'] = 8; 
$DETALHE[4]['campo'] = 'codidentaplicremu'; 
$DETALHE[4]['tipo'] = 'n'; 

$DETALHE[5]['incial'] = 25; 
$DETALHE[5]['tamanho'] = 10; 
$DETALHE[5]['campo'] = 'datlote'; 
$DETALHE[5]['tipo'] = 'd'; 

$DETALHE[6]['incial'] = 35; 
$DETALHE[6]['tamanho'] = 4; 
$DETALHE[6]['campo'] = 'codlote'; 
$DETALHE[6]['tipo'] = 'n'; 

$DETALHE[7]['incial'] = 39; 
$DETALHE[7]['tamanho'] = 10; 
$DETALHE[7]['campo'] = 'numseqlancamento'; 
$DETALHE[7]['tipo'] = 'n'; 

$DETALHE[8]['incial'] = 49; 
$DETALHE[8]['tamanho'] = 10; 
$DETALHE[8]['campo'] = 'desnumdocumento'; 
$DETALHE[8]['tipo'] = 's'; 

$DETALHE[9]['incial'] = 59; 
$DETALHE[9]['tamanho'] = 4; 
$DETALHE[9]['campo'] = 'codhistlancamento'; 
$DETALHE[9]['tipo'] = 'n'; 

$DETALHE[10]['incial'] = 63; 
$DETALHE[10]['tamanho'] = 17; 
$DETALHE[10]['campo'] = 'vllancamento'; 
$DETALHE[10]['tipo'] = 'n'; 

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "lancamentocaprem";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "lancamentocaprem";

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
