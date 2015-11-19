<?
/********************************************************************************
Autor: Gelson S. Rodrigues
Data Criação: 15/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Cabeçalho das consulta de solicitações
************************************************************************************/


?>
<table border="1" width="750" cellpadding="0" cellspacing="2">
  <tr>
      <td width="5" align="right">&nbsp;</td>
      <td bgcolor="#f5f5f5" width="70" align="center"><?=$opcaosol1;if ($opcaosol2 != "") echo"&nbsp;&nbsp;".$opcaosol2; if ($opcaosol3 != "") echo"&nbsp;&nbsp;".$opcaosol3; ?></td>
      <td bgcolor="#f5f5f5" width="60" align="center"><font color="#000000"> <?=$codsolicitacao1[$prox];?> </font>
	   </td>
      <td bgcolor="#f5f5f5" width="200" align="left"><?=$destiposervsol[$prox];?></td>	  
      <td bgcolor="#f5f5f5" width="300" align="left"><?=$numcontacorrente[$prox]." - ".$nomcliente[$prox];?></td>	  	  
      <td bgcolor="#f5f5f5" width="65" align="left"><?=FormataData($dtsolicitacao[$prox],'pt');?></td>	  	  	  
      <td bgcolor="#f5f5f5" width="55" align="left"><?=$hrsolicitacao[$prox];?></td>	  	  	  	  
  </tr>	  
</table>
