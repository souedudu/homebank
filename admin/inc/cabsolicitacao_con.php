<?
/********************************************************************************
Autor: Gelson S. Rodrigues
Data Criação: 15/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Cabeçalho das consulta de solicitações
************************************************************************************/
?>
<BR>
<table border="1" width="300" cellpadding="0" cellspacing="1" >
<?
  if ($tipoconsul == "Consultar" or $tipoconsul == "Triagem")
  {
?>

  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left"><img src='img/visualizar.gif' border='0' alt='Visualizar a solicitação.'></td>
      <td align="left"><b>- Visualizar a solicitação</b></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left"><img src="img/triagem_sol.gif" alt='Triagem da solicitação.' width="19" height="15" border="0"></td>
      <td align="left"><b>- Triagem da solicitação</b></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left" height="15"><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></td>
      <td align="left"><b>- Adicionar Andamento</b></td>
  </tr>
<?
  }
  elseif ($tipoconsul == "Avaliar")
  {
?>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left" height="15"><img src='img/avaliar_atendimento.gif' border='0' alt='Avaliar Atendimento.'></td>
      <td align="left"><b>- Avaliar Atendimento</b></td>
  </tr>
<?
  }
   elseif ($tipoconsul == "Andamento")
  {
?>

  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left"><img src="img/triagem_sol.gif" alt='Triagem da solicitação.' width="19" height="15" border="0"></td>
      <td align="left"><b>- Triagem da solicitação</b></td>
  </tr>
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td width="20" align="left" height="15"><img src='img/add_andamento.gif' border='0' alt='Adicionar Andamento.'></td>
      <td align="left"><b>- Adicionar Andamento</b></td>
  </tr>

<?
  }
?>
</table>
<BR>
<table border="1" width="750" cellpadding="0" cellspacing="1" >
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td class="td4" width="70" align="right">&nbsp;</td>
      <td class="td4" width="60" align="right">Número</td>
      <td class="td4" width="200" align="left">Tipo de Solicitação</td>	  
      <td class="td4" width="300" align="left">Conta - Cliente</td>	  	  
      <td class="td4" width="65" align="left">Data</td>	  	  	  
      <td class="td4" width="55" align="left">Hora</td>	  	  	  	  
  </tr>
</table>



