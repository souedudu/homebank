<?
$id = $_GET['id'];
$tipoacao = $_REQUEST['tipoacao'];

$bttipoacao = $_REQUEST['bttipoacao'];

if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db)){
	$sql = "select * from usuario where codusuario = ".$_SESSION['codusuarioadm'];
	$result = mysql_query($sql) or die(mysql_error());
	$dados = mysql_fetch_array($result);
	if ($dados['flapercadusu'] == "n"){
		include "inc/index.php";
	}else{
// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "" || $_REQUEST['tipoacao'] == "Listar"){
  $tipoacao = "Listar";

  $sqlString = "Select * From tipopermissao order by descricao asc";
  $rsqry = mysql_query($sqlString);
  $tipopermissao = mysql_fetch_array($rsqry);
?>
<br />
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><strong>Grupo Permissão<br></strong></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">
       <br><a href="cadastratipopermissao.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro<BR>
       <BR>
    </td>
  </tr>
</table>
<table width="580" class="table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="85%" class="td4"><strong>&nbsp;Nome</strong><br></td>
	 <td width="15%" colspan="2" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
 
<?
  while (!($tipopermissao==0)){
  
  $sql1 = "Select * From tecnicoresp where codtecnicoresp = ".$tipopermissao['codtecnicoresp'];
  $rsqry1 = mysql_query($sql1);
  $rsfuncao = mysql_fetch_array($rsqry1); 
  
?>

    <tr>
      <td  class="td3">&nbsp;<?=$tipopermissao['descricao'];?></td>
  	  <td  align="center" class="td3">
	      <a href="cadastratipopermissao.php?tipoacao=Editar&id=<?=$tipopermissao['id'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">		  </a>
      <td  align="center" class="td3">
          <a href="javascript:if(confirm('Tem certeza que deseja excluir o usuário <?=$tipopermissao['desusuario'];?>')){ location.href='cadastratipopermissao.php?bttipoacao=Excluir&id=<?=$tipopermissao['id'];?>'; }">
		       <img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro.">
		  </a>
	  </td>
    </tr>
    <tr>
        <td width="5"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
<?
    $tipopermissao = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}
}
}
 ?>