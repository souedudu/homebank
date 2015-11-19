<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 06/12/2005
Data Atualização: 06/12/2005 - Vitor Hugo
Sistema: Home Bank
Descrição: Cadastra de Usuário
************************************************************************************/
//$codusuario = $_SESSION['codusuarioadm'];
$codusuario = $_GET['codusuario'];
$tipoacao = $_REQUEST['tipoacao'];

$bttipoacao = $_REQUEST['bttipoacao'];

if(Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db))
{
 $sql = "select * from usuario where codusuario = ".$_SESSION['codusuarioadm'];
 $result = mysql_query($sql) or die(mysql_error());
 $dados = mysql_fetch_array($result);
 if ($dados['flapercadusu'] == "n")
 {
  include "inc/index.php";
  
 }
  else
 {

?>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.desusuariologin.value =='')
  {
    alert('Campo "Login" obrigatório.');
    document.form.desusuariologin.focus();
    return false;
  }
  if (document.form.dessenha.value =='')
  {
    alert('Campo "Senha" obrigatório.');
    document.form.dessenha.focus();
    return false;
  }
  if (document.form.codtecnicoresp.value =='')
  {
    alert('Campo "Usuario" obrigatório. Verifique se possui alguma opção, caso não possua Cadastre primeiramente um Técnico.');
    document.form.codtecnicoresp.focus();
    return false;
  }

}
</script>

<?
// Grava dados do formulario


if ($bttipoacao != "")
{
/*   $sqlstring2 = "select nomtecnicoresp, desfuncaoresp from tecnicoresp where codtecnicoresp =".$codtecnicoresp;
   $query2 = mysql_query($sqlstring2) or die(mysql_error());
   $rstec = mysql_fetch_array($query2);
   $desusuario = $rstec['nomtecnicoresp'];
   $desfuncao = $rstec['desfuncaoresp'];

		echo "nome: ".$desusuario. " - ".$desfuncao;		  
*/
  if ($bttipoacao == "Excluir")
  {

	$sql = SQL("usuario","delete","", "codusuario");
	$sql2 = "Delete from acessousu where codusuario =".$codusuario;
    mysql_query($sql) or die(mysql_error());
    mysql_query($sql2) or die(mysql_error());

  }

  if ($bttipoacao == "Incluir")
  {
	$sql = "insert into usuario (codtecnicoresp,desusuario,desfuncao,dessenha,flapercadusu,flapercadmenu)".
	       "values ".
		   "('".$codtecnicoresp."', '".$desusuariologin."', '".$desfuncao."', '".$dessenha."', '".$_REQUEST['flapercadusu']."', '".$_REQUEST['flapercadmenu']."')";

    mysql_query($sql) or die(mysql_error());
    $codusuario = mysql_insert_id();
    
	// Grava o novo acesso do usuario
	if ($codmenu != "")
      foreach ($codmenu as $elemento)
      {
         $sqlins1 = "insert into acessousu
                     (codusuario, codmenu)
                     values
                     ($codusuario, $elemento)";

		 mysql_query($sqlins1) or die(mysql_error());
      }

  }
  // Modifica a variável de Sessão do Usuário, caso Seja Incluído
  if ($codusuario == $_SESSION['codusuarioadm'])
  {
     $_SESSION['flapercadusu'] = $_REQUEST['flapercadusu'];
     $_SESSION['flapercadmenu'] = $_REQUEST['flapercadmenu'];
  }



  if ($bttipoacao == "Editar")
  {
    $codusuario = $_REQUEST['codusuario'];
    $sql = "update usuario set ".
		   //"codtecnicoresp='".$codtecnicoresp."',
		   " desusuario='".$_REQUEST['desusuariologin']."', flapercadmenu='".$_REQUEST['flapercadmenu']."', desfuncao='', dessenha='".$_REQUEST['dessenha']."', flapercadusu='".$_REQUEST['flapercadusu']."'".
		   " where codusuario = ".$_SESSION['codusuarioadm'];
    echo "sql: ".$sql;

//	$sql = SQL("usuario", "update", "codtecnicoresp,desusuario,desfuncao,dessenha,flaencerraros,flaconcluiros,flapercadusu","codusuario");
	mysql_query($sql) or die(mysql_error());
	
	// Excluir o acesso antigo do usuário
	mysql_query("delete from acessousu where codusuario = ".$_SESSION['codusuarioadm']) or die(mysql_error());

	// Grava o novo acesso do usuario
    if ($_REQUEST['codmenu'] != "")
      foreach ($_REQUEST['codmenu'] as $_REQUEST['elemento'])
      {
         $sqlins1 = "insert into acessousu
                     (codusuario, codmenu)
                     values
                     ($codusuario, ".$_REQUEST['elemento'].")";

         mysql_query($sqlins1) or die(mysql_error());
      }
  // Modifica a variável de Sessão do Usuário, caso Seja Alterado
  if ($codusuario == $_SESSION['codusuarioadm'])
  {
     $_SESSION['flapercadusu'] = $_REQUEST['flapercadusu'];
     $_SESSION['flapercadmenu'] = $_REQUEST['flapercadmenu'];
  }
}



?>
<br>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td3"><strong><b>Mensagem</b></strong></td>
  </tr>
  <tr>
    <td width="5"></td>
    <td align='center' ></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align='center' class="td4"><br>Operação efetuada com sucesso.<p> </td>
  </tr>
 </table>
 <p>
 <table width='580' class="table" cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center'><a href='cadastrausuario.php?bttipoacao=&$tipoacao='>
	                   <img src='img/bt_voltar.gif' width='53' height='20' border='0'></a>
	</td>
  </tr>
 </table>

<?

}



// Lista dados que estão cadastrados na tabela
if ($_REQUEST['tipoacao'] == "" || $_REQUEST['tipoacao'] == "Listar")
{
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
       <br><a href="cadastrausuario.php?tipoacao=Incluir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro<BR><BR>
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
  while (!($rsusuario==0))
  {
  
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
          <a href="cadastrausuario.php?tipoacao=Excluir&codtecnicoresp=<?=$rsusuario['codtecnicoresp'];?>&codusuario=<?=$rsusuario['codusuario'];?>&bttipoacao=Excluir">
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

// Formulário para inclusão ou alteração dos dados
if (($_REQUEST['tipoacao'] == "Incluir" || $_REQUEST['tipoacao'] == "Editar") && $bttipoacao == "")
{


  if ($_REQUEST['tipoacao'] == "Editar" )
  {
    $codusuario = $_SESSION['codusuarioadm'];
    $sqlString = "Select * From usuario where codusuario = ".$codusuario;
    $rsqry = mysql_query($sqlString);
    $rsusuario = mysql_fetch_array($rsqry);
  }
 ?>

<form name="form" method="POST" action="" onSubmit="return VerificaCamposObrigatorios();">
<BR>
 <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="5">&nbsp;</td>
    <td align="center" class="td2"><strong><b><?=$tipoacao;?> Usuario </b></strong></td>
  </tr>
</table>
<BR>
<table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Usuário</td>
	 <td class="td4">&nbsp;<select name="codtecnicoresp" id="codtecnicoresp"
	                          <? if ($tipoacao=="Editar")
							       echo "disabled"; ?>
	                       >
						   
       <option value="">Selecione</option>
       <?
 		            // Recupera os dados do tecnico			
					if ($tipoacao == "Incluir")
					{
                       $sqlstring2 = "SELECT t.* FROM tecnicoresp t LEFT JOIN usuario u ON t.codtecnicoresp = u.codtecnicoresp
                                   where u.codtecnicoresp IS NULL
  								  order by t.nomtecnicoresp  ";
					}
					
					if ($tipoacao == "Editar")
					{
                       $sqlstring2 = "SELECT t.* FROM tecnicoresp t 
  								  order by t.nomtecnicoresp  ";
					}
										
                    $query2 = mysql_query($sqlstring2) or die(mysql_error());
			   
			        while($b = mysql_fetch_array($query2))
			        {
                  ?>
       <option value="<?=$b['codtecnicoresp'];?>"
				  <? if ($b['codtecnicoresp']==$rsusuario['codtecnicoresp'])
 				        echo "selected";
				  ?>
					>
       <?=$b['nomtecnicoresp'];?>
       </option>
       <?
			        }
			      ?>
     </select>
    <br>    </td>
  </tr>
  <tr>
	 <td width="5">&nbsp;&nbsp;</td>
     <td class="td3"  width="200" align="right" >Login</td>
	 <td class="td4">&nbsp;<input name="desusuariologin" value="<?=$rsusuario['desusuario'];?>" type="text" id="desusuariologin" size="20" maxlength="15" />
      <br></td>
  </tr>
  <tr>
     <td width="5">&nbsp;</td>
     <td align="right" width="200" class="td3">Senha</td>
    <td class="td4">&nbsp;<input name="dessenha" value="<?=$rsusuario['dessenha'];?>" type="password" id="dessenha" size="10" maxlength="8" /></td>
  </tr>

</table>
<table width="580" cellspacing="0" class="table">
  </tr>
  <tr>
     <td  width="5">&nbsp;</td>
	 <td align="right" width="200" class="td3">Permitir Cadastrar Usuários</td>
	 <td class="td4">&nbsp;<select size="1" name="flapercadusu" id="flapercadusu">
              <option value="">Selecione</option>
              <option value="s"
				                  <? if ($rsusuario['flapercadusu'] =="s")
 								       echo "selected";
								  ?> 			  >Sim</option>
              <option value="n"
				                  <? if ($rsusuario['flapercadusu'] =="n")
 								       echo "selected";
								  ?>			  >Não</option>
          </select>			  
     </td>
  </tr>
  <tr>
     <td  width="5">&nbsp;</td>
	 <td align="right" width="200" class="td3">Permitir Cadastrar Menu</td>
	 <td class="td4">&nbsp;<select size="1" name="flapercadmenu" id="flapercadmenu">
              <option value="">Selecione</option>
              <option value="s"
				                  <? if ($rsusuario['flapercadmenu'] =="s")
 								       echo "selected";
								  ?> 			  >Sim</option>
              <option value="n"
				                  <? if ($rsusuario['flapercadmenu'] =="n")
 								       echo "selected";
								  ?>			  >Não</option>
          </select>
     </td>
  </tr>

 </table>
<?
  //------------ Permissões---------------//

  $sqlString = "Select m.* From menu m order by desmenu asc";
  $rsqry = mysql_query($sqlString);
  $rsmenu = mysql_fetch_array($rsqry);
?>
<br>
<table width="580" class="table"  cellspacing="0" cellpadding="0">
  <tr>
     <td width="5"></td>
     <td align="center" class="td2 "><font color=""><b>Permissões</b></font></td>
  </tr>
</table>
<table width="580" class="table"  cellspacing="0" cellpadding="0">
<?
  while (!($rsmenu==0))
  {
   if ($codusuario != "")
   {
     $sqlString3 = "select codmenu from acessousu where codmenu = ".$rsmenu['codmenu']." and codusuario = ".$codusuario;
     $rsqry3 = mysql_query($sqlString3);
     $rsmenu3 = mysql_fetch_array($rsqry3);
     $codmenu1 = $rsmenu3['codmenu'];
   }
?>

    <tr>
	  <td  width="5">&nbsp;</td>
      <td width="200" align="right" class="td3"><?=$rsmenu['desmenu'];?></td>
      <td class="td4">&nbsp;<input type="checkbox" name="codmenu[]" value="<?=$rsmenu['codmenu'];?>" <? if ($codmenu1 != '') echo 'checked';?>></td>
    </tr>
<?

    $rsmenu = mysql_fetch_array($rsqry);
  }
?>

 <table width="580" class="table" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td  width="80"><input type="submit" name="Submit" value="Gravar">
                     <input name="bttipoacao" type="hidden" value="<?=$tipoacao;?>">
	  </td>
	  <td><input type="button" value="Cancelar" onclick="javascript:(history.back(-1))"></td>

    </tr>

 </table>
 <?

  }
  }
  }//fim else $_SESSION['flapercadusu'] == "n"
?>
