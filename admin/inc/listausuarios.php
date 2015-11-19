<?
$codusuario = $_GET['codusuario'];
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

  $sqlString = "Select * From usuario order by desusuario asc";
  $rsqry = mysql_query($sqlString);
  $rsusuario = mysql_fetch_array($rsqry);
?>
<br />
 <table width="580" class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" class="td2"><strong>Usuário<br></strong></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="left">
       <br><a href="old_cadastrausuario.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro<BR>
       <BR>
    </td>
  </tr>
</table>
<table width="580" class="table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td width="235" class="td4"><strong>&nbsp;Nome</strong><br></td>
    <td width="275" class="td4"><strong>&nbsp;Função</strong><br></td>
	<td width="62" align="center" class="td4"><strong>Opções</strong><br></td>
  </tr>
</table>

<table width="580" class="table" cellspacing="0" cellpadding="0">
<?
  while (!($rsusuario==0)){
  
  $sql1 = "Select * From tecnicoresp where codtecnicoresp = ".$rsusuario['codtecnicoresp'];
  $rsqry1 = mysql_query($sql1);
  $rsfuncao = mysql_fetch_array($rsqry1); 
  
?>

    <tr>
      <td width="5">&nbsp;</td>
      <td width="235" class="td3">&nbsp;<?=$rsusuario['desusuario'];?></td>
      <td width="275" class="td3">&nbsp;<?=$rsfuncao['desfuncaoresp'];?></td>
  	  <td width="30" align="center" class="td3">
	      <a href="cadastrausuario.php?tipoacao=Editar&codusuario=<?=$rsusuario['codusuario'];?>">
		     <img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro.">		  </a>
      <td width="30" align="center" class="td3">
          <a href="javascript:if(confirm('Tem certeza que deseja excluir o usuário <?=$rsusuario['desusuario'];?>')){ location.href='excluirusuario.php?cod=<?=$rsusuario['codusuario'];?>'; }">
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
    $rsusuario = mysql_fetch_array($rsqry);
  }
?>
 </table>
<?
}
}
}
 ?>