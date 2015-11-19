<form method="POST" name="form1" id="form1" onSubmit="return VerificaCamposObrigatorios();">
  <BR>
  <table width="580" border=1 class="table" cellspacing="0" cellpadding="0">
    <tr>
      <td  width="5">&nbsp;</td>
      <td align="center" class="td2"><strong><b>Editar Usuario </b></strong></td>
    </tr>
  </table>
  <BR>
  <table width="580" class="table"  border=1 cellspacing="0" cellpadding="0">
    <tr>
      <td width="5">&nbsp;&nbsp;</td>
      <td  width="200" align="right" valign="middle" class="td3" >Login</td>
      <td valign="middle" class="td4">&nbsp;
        <input name="desusuariologin" type="text" id="desusuariologin" size="20" maxlength="15" /></td>
    </tr>
    <tr>
      <td width="5">&nbsp;</td>
      <td width="200" align="right" valign="middle" class="td3">Senha</td>
      <td valign="middle" class="td4">&nbsp;
        <input name="dessenha" type="password" id="dessenha" size="10" maxlength="8" />
        <input name="codusuario" type="hidden" id="codusuario">
        <input type="hidden" name="MM_update" value="form1"></td>
    </tr>
  </table>
  <table width="580" cellspacing="0" class="table">
    </tr>
<tr>
      <td  width="5">&nbsp;</td>
      <td align="right" width="200" class="td3">Permitir Cadastrar Usuários</td>
      <td class="td4">&nbsp;
        <select size="1" name="flapercadusu" id="flapercadusu">
          <option value="n"
				                  			  >N&atilde;o</option>
          <option value="s"
				                  selected 			  >Sim</option>
        </select>
      </td>
    </tr>
    <tr>
      <td  width="5">&nbsp;</td>
      <td align="right" width="200" class="td3">Permitir Cadastrar Menu</td>
      <td class="td4">&nbsp;
        <select size="1" name="flapercadmenu" id="flapercadmenu">
          <option value="n"
				                  			  >Não</option>
          <option value="s"
				                  selected 			  >Sim</option>
        </select>
      </td>
    </tr>
  </table>
  <br>
  <table width="580" class="table"  cellspacing="0" cellpadding="0">
    <tr>
      <td width="5"></td>
      <td align="center" class="td2 ">
	  <?php do {
	  $a_permissoes[]=$row_permissoes['codmenu'];
	  } while ($row_permissoes = mysql_fetch_assoc($permissoes)); ?><font color=""><b>Permissões</b></font></td>
    </tr>
  </table>
  <table width="580" cellpadding="0"  cellspacing="0" class="table">
    <tr>
      <td width="200" align="right" class="td3"></td>
      <td class="td4">&nbsp;
          <input type="checkbox" name="codmenu[]"<?php if(in_array($row_menus['codmenu'],$a_permissoes)){ echo 'checked'; }?>></td>
    </tr>
<tr>
        <td colspan="2" align="right" class="td3"><input type="submit" name="Submit" value="Gravar">
          <input type="button" name="Submit2" value="Cancelar" onClick="location.href=history.back();"></td>
    </tr>
    <br>
  </table>
</form>
