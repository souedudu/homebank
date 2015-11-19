<?
/********************************************************************************
Autor: Gelson
Data Criação: 
Data Atualização: 30/11/2005 - Gelson
Sistema: Home Bank
Descrição: Notícias
************************************************************************************/

//Conecta ao Banco de Dados
Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

	$sqlnoticias = "select * from noticia where flaativo = 's' order by datcadastro desc";
	
	$querynoticias = mysql_query($sqlnoticias);
    $rsnoticias = mysql_fetch_array($querynoticias);

?>
	<table width="600" border="0">
		<tr class="td6">
			<td width="90"><strong>Data da Notícia</strong></td>
			<td><strong>Descrição da Notícia</strong></td>
			<td width="30"><strong>Link</strong></td>
		</tr>

<?
	//Laço para Imprimir as notícias
	while ($rsnoticias){
?>
		<tr cellspacing="1">
			<td width="90" class="td6"><?=FormataData($rsnoticias['datcadastro'],'pt')?></td>
			<td class="td3" ><?=$rsnoticias['desnoticia']?></td>
			<td width="60" class="td6" ><strong><a href="http://<?=$rsnoticias['desurl']?>" target="new" class="a"><?=$rsnoticias['desurl']?></a></strong></td>
		</tr>

<?	
	
	$rsnoticias = mysql_fetch_array($querynoticias); 
	}
?>
	</table>