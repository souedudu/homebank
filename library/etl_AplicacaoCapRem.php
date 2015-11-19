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
$DETALHE[1]['campo'] = 'numcontacaptacao';
$DETALHE[1]['tipo'] = 'n';

$DETALHE[2]['incial'] = 11; 
$DETALHE[2]['tamanho'] = 2; 
$DETALHE[2]['campo'] = 'codproduto'; 
$DETALHE[2]['tipo'] = 'n'; 

$DETALHE[3]['incial'] = 13; 
$DETALHE[3]['tamanho'] = 4; 
$DETALHE[3]['campo'] = 'codmodcapremun'; 
$DETALHE[3]['tipo'] = 'n'; 

$DETALHE[4]['incial'] = 17; 
$DETALHE[4]['tamanho'] = 8; 
$DETALHE[4]['campo'] = 'codidentaplicremunerada'; 
$DETALHE[4]['tipo'] = 'n'; 

$DETALHE[5]['incial'] = 25; 
$DETALHE[5]['tamanho'] = 10; 
$DETALHE[5]['campo'] = 'dataplicacao'; 
$DETALHE[5]['tipo'] = 'd'; 

$DETALHE[6]['incial'] = 35; 
$DETALHE[6]['tamanho'] = 4; 
$DETALHE[6]['campo'] = 'numprazoaplicacao'; 
$DETALHE[6]['tipo'] = 'n'; 

$DETALHE[7]['incial'] = 39;
$DETALHE[7]['tamanho'] = 4;
$DETALHE[7]['campo'] = 'numprazocarenciadias'; 
$DETALHE[7]['tipo'] = 'n';

$DETALHE[8]['incial'] = 43; 
$DETALHE[8]['tamanho'] = 4; 
$DETALHE[8]['campo'] = 'numprazorepac'; 
$DETALHE[8]['tipo'] = 'n'; 

$DETALHE[9]['incial'] = 47; 
$DETALHE[9]['tamanho'] = 10; 
$DETALHE[9]['campo'] = 'datvencaplicacao'; 
$DETALHE[9]['tipo'] = 'd'; 

$DETALHE[10]['incial'] = 57; 
$DETALHE[10]['tamanho'] = 17; 
$DETALHE[10]['campo'] = 'vlaplicacao'; 
$DETALHE[10]['tipo'] = 'n'; 

$DETALHE[11]['incial'] = 74; 
$DETALHE[11]['tamanho'] = 12; 
$DETALHE[11]['campo'] = 'vltaxabrutaano'; 
$DETALHE[11]['tipo'] = 'n';

$DETALHE[12]['incial'] = 86; 
$DETALHE[12]['tamanho'] = 12; 
$DETALHE[12]['campo'] = 'vlpercentindice'; 
$DETALHE[12]['tipo'] = 'n'; 

$DETALHE[13]['incial'] = 98; 
$DETALHE[13]['tamanho'] = 17; 
$DETALHE[13]['campo'] = 'vlsaldodispatual'; 
$DETALHE[13]['tipo'] = 'n';

$DETALHE[14]['incial'] = 115; 
$DETALHE[14]['tamanho'] = 17; 
$DETALHE[14]['campo'] = 'vlsaldodispanterior'; 
$DETALHE[14]['tipo'] = 'n';

$DETALHE[15]['incial'] = 132; 
$DETALHE[15]['tamanho'] = 17; 
$DETALHE[15]['campo'] = 'vljurosapropriar'; 
$DETALHE[15]['tipo'] = 'n'; 

$DETALHE[16]['incial'] = 149; 
$DETALHE[16]['tamanho'] = 17; 
$DETALHE[16]['campo'] = 'vljurosapropriado'; 
$DETALHE[16]['tipo'] = 'n'; 

$DETALHE[17]['incial'] = 166; 
$DETALHE[17]['tamanho'] = 2; 
$DETALHE[17]['campo'] = 'codsituacao'; 
$DETALHE[17]['tipo'] = 'n'; 

$DETALHE[18]['incial'] = 168; 
$DETALHE[18]['tamanho'] = 40; 
$DETALHE[18]['campo'] = 'nomusurespcadastro'; 
$DETALHE[18]['tipo'] = 's';

$DETALHE[19]['incial'] = 208; 
$DETALHE[19]['tamanho'] = 17; 
$DETALHE[19]['campo'] = 'vlsaldoacumumes'; 
$DETALHE[19]['tipo'] = 'n'; 

$DETALHE[20]['incial'] = 225; 
$DETALHE[20]['tamanho'] = 10; 
$DETALHE[20]['campo'] = 'datultcapitalizacao'; 
$DETALHE[20]['tipo'] = 'd'; 

$DETALHE[21]['incial'] = 235; 
$DETALHE[21]['tamanho'] = 10; 
$DETALHE[21]['campo'] = 'datultvalorizacao'; 
$DETALHE[21]['tipo'] = 'd'; 

$DETALHE[22]['incial'] = 245; 
$DETALHE[22]['tamanho'] = 17; 
$DETALHE[22]['campo'] = 'vlcorrecmonapropriada'; 
$DETALHE[22]['tipo'] = 'n'; 

$DETALHE[23]['incial'] = 262; 
$DETALHE[23]['tamanho'] = 17; 
$DETALHE[23]['campo'] = 'vlcorrecmonacumperiodo'; 
$DETALHE[23]['tipo'] = 'n'; 

$DETALHE[24]['incial'] = 279; 
$DETALHE[24]['tamanho'] = 17; 
$DETALHE[24]['campo'] = 'vljurosacumuperiodo'; 
$DETALHE[24]['tipo'] = 'n'; 

$DETALHE[25]['incial'] = 296; 
$DETALHE[25]['tamanho'] = 17; 
$DETALHE[25]['campo'] = 'vlirrfacumuperiodo'; 
$DETALHE[25]['tipo'] = 'n'; 

$DETALHE[26]['incial'] = 313; 
$DETALHE[26]['tamanho'] = 17;
$DETALHE[26]['campo'] = 'vliofacumuperiodo'; 
$DETALHE[26]['tipo'] = 'n';

$DETALHE[27]['incial'] = 330;
$DETALHE[27]['tamanho'] = 2;
$DETALHE[27]['campo'] = 'codboncpmfaplicacao'; 
$DETALHE[27]['tipo'] = 'n';

/* Nome em minusculo do arquivo "txt" (sem .txt no final) */
$CONF['nome'] = "aplicacaocaprem";

/* Nome da tabela no MySQL */
$CONF['tabela'] = "aplicacaocaprem";

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
