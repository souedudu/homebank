<script language=javascript>
function VerificaCamposObrigatorios()
{

  if((document.form1.descricao.value == ""))
  {
    alert('Preencha o campo descrição.');
	document.form1.descricao.focus();
	return false;
  }
   if((document.form1.parcelas_min.value == "0"))
  {
    alert('Preencha o campo Parcela Mínima com valores maiores que "0".');
	document.form1.parcelas_min.focus();
	return false;
  }
   if((document.form1.parcelas_max.value == "0"))
  {
    alert('Preencha o campo Parcela Máxima com valores maiores que "0".');
	document.form1.parcelas_max.focus();
	return false;
  }
}
</script>

<?
  $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
  include "funcoes_js2.php";

  //SQL de Inserção no Banco de Dados
  if($_REQUEST['bttipoacao']=="Insert"){

	$sql = SQL("emprestimos","insert",'descricao,juros,parcelas_min,parcelas_max,email,data_vencimento,valor_minimo,valor_maximo,dia_vencimento,carencia,obs,ativo,flaperdataliber');
	mysql_query($sql);
    $bttipoacao = "";
    $acao = "";
     //SQL de Alteração no Banco de Dados
    }elseif($_REQUEST['bttipoacao']=="Update"){
      $emprestimo_id = $_REQUEST['emprestimo_id'];
	  $sql = SQL("emprestimos",'update','descricao,juros,parcelas_min,parcelas_max,email,valor_minimo,valor_maximo,data_vencimento,carencia,dia_vencimento,obs,ativo,flaperdataliber','emprestimo_id');
	  mysql_query($sql);
	  $bttipoacao = "";
	  $acao = "";
     //SQL de Delete no Banco de Dados
    }elseif($acao=="Delete"){
	  $sql = SQL("emprestimos",'delete','','emprestimo_id');
	  mysql_query($sql);
	  $bttipoacao = "";
	  $acao = "";
    }

    //Formulário de Inclusão e de Alteração dos Registros de Empréstimos
    if($acao=="Inserir" || $acao == "Editar")
    {
       if ($acao == "Editar"){
           $bttipoacao = "Update";
           $sql = "select * from emprestimos where emprestimo_id = ".$_REQUEST['id'];
           $rs = mysql_query($sql) or die(mysql_error());
           $a = mysql_fetch_array($rs);
           }
            else{
                 $bttipoacao = "Insert";
           }

?>

<form name="form1" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
<table align="center" width="770" cellspacing="0">
	<tr>
        <td width="5"></td>
        <td class="td2" align="center"><?=$acao?> Empréstimo</td>
	    <td width="5"></td>
    </tr>
</table>
<BR>
<table width="760" cellspacing="0">
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Descrição</b></td>
       <td class="td6">&nbsp;<input name="descricao" type="text" id="descricao" size="90" maxlength="255" value="<?=$a['descricao']?>"></td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Permitir Alterar Data de Liberação</b></td>
       <td class="td6">&nbsp;<input name="flaperdataliber" type="checkbox" id="flaperdataliber" value="s" <? if ($a['flaperdataliber'] == "s") {echo "checked";}?> /></td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Juros</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;<input name="juros" type="text" id="juros" onkeydown="formataValor('juros',50,event);" onblur="numeros(this.id,true)" onKeyUp="numeros(this.id,true)" maxlength="14" size="10" value="<?=$a['juros']?>">%</td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Parcelas</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;Parcela Mínima:<input name="parcelas_min" type="text" id="parcelas_min" onblur="numeros(this.id,false)" onKeyUp="numeros(this.id,false)" size="3" maxlength="3" value="<?=$a['parcelas_min']?>">&nbsp;Parcela Máxima:<input name="parcelas_max" type="text" id="parcelas_max" onblur="numeros(this.id,false)" onKeyUp="numeros(this.id,false)" size="3" maxlength="3" value="<?=$a['parcelas_max']?>"></td>
   </tr>
   <tr>
      <td width="5"></td>
      <td width="220" class="td3" align="right"><b>Meses de Carência</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
      <td class="td6">&nbsp;<input name="carencia" type="text" id="carencia" onKeyUp="numeros(this.id,false)" onblur="numeros(this.id,false)" value="1" size="2" maxlength="2" value="<?=$a['carencia']?>"></td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Dia de Vencimento </b><font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;<input name="dia_vencimento" type="text" id="dia_vencimento" size="2" onKeyUp="numeros(this.id,false)" maxlength="2" onBlur="numeros(this.id,false);if(this.value>31){alert('O dia não pode ser maior que 31');this.value='';this.focus()}" value="<?=$a['dia_vencimento']?>">
	                         <input name="checkbox" type="checkbox" id="checkbox" value="checkbox" onClick="semvalor('dia_vencimento',this.checked)">
   	                         Sem dia de vencimento
       </td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Modificar Data de Vencimento</b></td>
       <td class="td6">&nbsp;<select name="data_vencimento" id="data_vencimento">
<?

       if ($a['data_vencimento'] == 1){
         echo "<option value='1' selected>Sim</option>";
         echo "<option value='0'>Não</option>";
       }
        elseif ($a['data_vencimento'] == 0)
        {
         echo "<option value='1'>Sim</option>";
         echo "<option value='0' selected>Não</option>";
        }

?>
	                           </select>
       </td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Valor Mínimo</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;<input name="valor_minimo" type="text" id="valor_minimo" maxlength="14" size="10" onkeydown="formataValor(this.id,50,event)" onblur="numeros(this.id,true)" onKeyUp="numeros(this.id,true)" value="<?=$a['valor_minimo']?>">
		                     <input name="check_vmin" type="checkbox" id="check_vmin" value="checkbox" onClick="semvalor('valor_minimo',this.checked)">
		                     Sem valor m&iacute;nimo
       </td>
   </tr>
   <tr>
       <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Valor Máximo</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;<input name="valor_maximo" type="text" id="valor_maximo" onkeydown="formataValor('valor_maximo',50,event)" maxlength="14" size="10" onblur="numeros(this.id,true)" onKeyUp="numeros(this.id,true)" value="<?=$a['valor_maximo']?>">
                             <input name="check_vmax" type="checkbox" id="check_vmax" value="checkbox" onClick="semvalor('valor_maximo',this.checked)">
                             Sem valor m&aacute;ximo
       </td>
   </tr>
   <tr>
	   <td width="5"></td>
       <td width="220" class="td3" align="right"><b>Email do responsável</b> <font size="1" face="arial, helvetica, sans-serif">(somente números)</font></td>
       <td class="td6">&nbsp;<input name="email" type="text" id="email" size="40" value="<?=$a['email']?>"></td>
   </tr>
   <tr>
       <td width="5"></td>
       <td class="td3" align="right"><b>Observações</b> </td>
	   <td align="left" class="td6">&nbsp;<textarea name="obs" id="obs" cols=40 rows=4><?=$a['obs'];?></textarea></td>
   </tr>
   <tr>
      <td width="5"></td>
	  <td class="td3" align="right"><b>Ativar</b> </td>
	  <td align="left" class="td6">&nbsp;<input type="checkbox" name="ativo" id ="ativo" value="1" <? if($a['ativo']=="1") echo "checked"?>></td>
   </tr>
</table>
<table align="center">
   <tr>
       <td width="5"></td>
       <td align="center"><input type="submit" name="Submit" value="Gravar">
                          <input name="bttipoacao" type="hidden" value="<?=$bttipoacao;?>">
                          <input name="emprestimo_id" type="hidden" value="<?=$_REQUEST['id'];?>">
	                      <input type="button" name="Submit2" value="Cancelar" onClick="redireciona('?')" >

       </td>
   </tr>
</table>
<input type="hidden" name="data" value="<?=date("Y-m-d h:i:s")?>">
</form>
<?
       }
       if ($acao == "")
       {
           $sql = "select * from emprestimos order by descricao asc";
	       $rs = mysql_query($sql) or die(mysql_error());

?>
<!--
    Função de Exclusão
!-->
<script>
		function excluir(id){
			if(confirm("Você deseja realmente excluir esse empréstimo?"))
				redireciona("?acao=Delete&emprestimo_id="+id);
		}
</script>

<!--
    Formulário para Listar Tipo de Empréstimos
!-->


<table width="100%" cellpading="0">
   <tr>
       <TD width="5"></TD>
       <TD width="" class="td2" align="center">Empréstimos Cadastrados</TD>
       <TD width="5"></TD>
   </tr>
   <tr>
       <td width="5">&nbsp;</td>
       <td align="left">
           <BR><a href="cadastraremprestimo.php?acao=Inserir"><img src="img/Novo.gif" width="15" height="15" border="0" alt="Incluir novo registro." /></a> Incluir novo registro
       </td>
       <TD width="5"></TD>
  </tr>
</table>
<BR>
<table width="100%" cellspacing="0" cellpading="0">
   <tr cellspacing="1">
      <td width="5"></td>
      <td width="67%" class="td4" align="center"><font color="red">Descrição</font></td>
      <td class="td4" align="center"><font color="red">Juros (%)</font></td>
	  <td class="td4" align="center"><font color="red">Parcelas</font></td>
	  <td class="td4" align="center"><font color="red">Ativo</font></td>
	  <td class="td4" align="center"><font color="red">Opções</font></td>
	  <td width="5"></td>
   </tr>
<?
            while($a = mysql_fetch_array($rs))
            {
?>
   <tr>
      <td width="5"></td>
      <td align="left" class="td3" nowrap>&nbsp;<?=$a['descricao']?></td>
	  <td align="center" class="td3">&nbsp;<?=$a['juros']?></td>
	  <td align="center" class="td3"><?=$a['parcelas_max']?></td>
	  <td align="center" class="td3"><input type="checkbox" name="checkbox" value="checkbox" onClick="atualiza(<?=$a[0]?>,this.checked)" <? if($a['ativo']) echo "checked"?> disabled></td>
      <td width="" align="center" class="td3">
                <a href='?acao=Editar&id=<?=$a['emprestimo_id']?>'><img src="img/Editar.gif" width="15" height="15" border="0" alt="Editar o registro."></a>&nbsp;
                <a href='javascript:excluir(<?=$a['emprestimo_id']?>)'><img src="img/Excluir.gif" width="15" height="15" border="0" alt="Excluir o registro."></a>
      </td>
      <td width="5"></td>
    </tr>
    <tr cellspacing="1">
      <td width="5"></td>
      <td width="5"></td>
      <td width="5"></td>
      <td width="5"></td>
      <td width="5"></td>
      <td width="5"></td>
      <td width="5"></td>
	</tr>
<?
            }
?>
</table>
<?
        }
?>
