<?

unset ($DETALHE);
unset ($CONF);

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
$DETALHE[3]['tamanho'] = 10; 
$DETALHE[3]['campo'] = 'numcontacaptacao'; 
$DETALHE[3]['tipo'] = 'n'; 

$DETALHE[4]['incial'] = 28; 
$DETALHE[4]['tamanho'] = 2; 
$DETALHE[4]['campo'] = 'codproduto'; 
$DETALHE[4]['tipo'] = 'n'; 

$DETALHE[5]['incial'] = 30; 
$DETALHE[5]['tamanho'] = 4; 
$DETALHE[5]['campo'] = 'codmodproduto'; 
$DETALHE[5]['tipo'] = 'n'; 

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "contacapremunerada";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "contacapitalremunerada";

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

?>
