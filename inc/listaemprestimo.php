<?
/********************************************************************************
Autor: Gelson
Data Criação: 27/12/2005
Data Atualização: 27/12/2005 - Gelson
Sistema: Home Bank
Descrição: Lista Relação de Empréstimos
************************************************************************************/
include "../library/config.php";
include "../library/funcoes.php";

Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

   // Recupera a matricula da conta capital
   $sqlcc = "select *
	       from contratocredito 
	       where numcontrato  = ".$_REQUEST['numcontrato'];		
			  					  
   $rsquerycc = mysql_query($sqlcc);
   $rsresultcc = mysql_fetch_array($rsquerycc);
   
   // recupera o total de parcelas do emprestimo
   $sqlStringpar = "select count(*) numparcelas from planopagamento where numcontrato  = ".$rsresultcc['numcontrato'];
   $rsqrylpar = mysql_query($sqlStringpar);
   $rspar = mysql_fetch_array($rsqrylpar);
   $numparcelas = $rspar['numparcelas'];    
   
   // recupera a descição da situação
   if ($rsresultcc['codsituacao'] != "")
   {			
	  $sqlsit = "select dessitopecredito from sitopecaocredito 
                             where codsitopecredito  = ".$rsresultcc['codsituacao'];
				 
	  $rsqrysit = mysql_query($sqlsit);
	  $rssit = mysql_fetch_array($rsqrysit); 
  	  $dessituacao = $rssit['dessitopecredito'];			
   }
			   
/*   if ($rsresultcc['codsituacao'] == 1)
	 $dessituacao = "Em Aberto";
			  
   if ($rsresultcc['codsituacao'] == 2)
	 $dessituacao = "Liquidado";
*/			     
   // Recupera a matricula da conta capital
   $sqlc = "select *
	        from cliente 
			where codcliente  = ".$rsresultcc['codcliente'];
						  					  
   $rsqueryc = mysql_query($sqlc);
   $rsresultc = mysql_fetch_array($rsqueryc);   
   
   
   if ($rsresultcc['codcobiof'] == 0)
     $descobiof = "Sem IOF";
	 
   if ($rsresultcc['codcobiof'] == 1)
     $descobiof = "Isento";
	 
   if ($rsresultcc['codcobiof'] == 2)
     $descobiof = "Cobrar IOF";	 	 
	 
	 
   // recupera os dados da movimentação
   $sqlmov = "select * from planopagamento 
              where codsitparcela = 2 and
			        numcontrato  = ".$rsresultcc['numcontrato'];
   $rsqrymov = mysql_query($sqlmov);
   $rsmov = mysql_fetch_array($rsqrymov);

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:. HOMEBANKING .: - Crediembrapa - Consulta Movimentação de Título</title>
<link href="../site.css" rel="stylesheet" type="text/css">
<script src="../scripts.js" type="text/javascript"></script>
</head>
        <table width="650" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td ><img src="barra_mov.gif" width="650" ></td>
  		  </tr>
		</table>	
			
        <table width="650" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td ><img src="img/dot_branco.jpg" width="1" height="1"></td>
            <td bgcolor="#CCCCCC" align="center"> <strong>Consulta Movimentação de Título</strong></td>
          </tr>
		  
          <tr>
            <td align="center"> <br /></td>
          </tr>
		  
          <tr>
            <td ><img src="img/dot_branco.jpg" width="1" height="1"></td>
            <td colspan="5" valign="top"><strong>Conta Corrente:</strong> <?=FormataContrato($rsresultcc['numcontacorrente'])." - ".$rsresultc['nomcliente'];?></td>
          </tr>
		  </table>
		  
		  <br>
		  
		  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7">&nbsp;</td>
            <td width="85" bgcolor="f7f4f4" align="right"><b>Cód. Título</td>
            <td width="145" bgcolor="f7f4f4"><b>Situação</td>
            <td width="75" bgcolor="f7f4f4"><b>Nº Parcelas</td>
            <td width="110" bgcolor="f7f4f4" align="right"><b>Valor Financiado</td>
            <td width="130" bgcolor="f7f4f4" align="right"><b>Taxa Juros Normal</td>			  
            <td width="110" bgcolor="f7f4f4" align="right"><b>Data Solicitação</td>			  
          </tr>
		  </table>		  
		  
         <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">		  		 
		    <tr>
            <td width="8" >&nbsp;</td>
            <td width="82" align="right" bgcolor="f7f4f4"><?=FormataContrato($rsresultcc['numcontrato']);?></td>
            <td width="145" bgcolor="f7f4f4"><?=$dessituacao;?></td>
            <td width="85" align="center" bgcolor="f7f4f4"><?=$numparcelas;?></td>
            <td width="110" align="right" bgcolor="f7f4f4"><?=number_format($rsresultcc['vlcontrato'], 2, ',', '.');?></td>
            <td width="135" align="right" bgcolor="f7f4f4"><font color="#003366"><?=number_format($rsresultcc['vlpercjuros'], 2, ',', '.');?> %</font></td>
            <td width="110" align="right" bgcolor="f7f4f4">
              <font color="#003366"><strong><?=FormataData($rsresultcc['datoperacao'],'pt');?></strong></font></td>	
          </tr>
		</table>		 
		<br>
		
		  <table width="650" border="1" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7">&nbsp;</td>
            <td width="80" align="right">&nbsp; </td>
            <td width="85" bgcolor="f7f4f4"><b>Nível de Risco</td>
            <td width="75" bgcolor="f7f4f4" align="right"><b>Crit. IOF</td>
            <td width="110" bgcolor="f7f4f4" align="right"><b>Ind. Cálculo</td>
            <td width="130" bgcolor="f7f4f4" align="right"><b>Valor Juros</td>			  
            <td width="110" bgcolor="f7f4f4" align="right"><b>Data Vencimento</td>			  
          </tr>
		  </table>	
		  
         <table width="650" border="1" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">		  		 
		    <tr>
            <td width="6" >&nbsp;</td>
            <td width="82" align="right">&nbsp;</td>
            <td width="85" align="center" bgcolor="f7f4f4"><?=$rsresultcc['codidenivrisco'];?></td>
            <td width="80" bgcolor="f7f4f4" align="right"><?=$descobiof;?></td>
            <td width="110" align="right" bgcolor="f7f4f4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="135" align="right" bgcolor="f7f4f4"><font color="#003366"><?=number_format($rsresultcc['vljuros'], 2, ',', '.');?></font></td>
            <td width="110" align="right" bgcolor="f7f4f4">
              <font color="#003366"><strong><?=FormataData($rsresultcc['datvencopecred'],'pt');;?></strong></font></td>	
          </tr>
		</table>
		<br>
		<table width="650" border="1" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
        <tr>
		    <td width="7">&nbsp;</td>
            <td width="80" align="right">&nbsp; </td>
            <td width="85" >&nbsp;</td>
            <td width="75" bgcolor="f7f4f4" align="right"><b>Valor IOF</td>
            <td width="110" align="right">&nbsp;  </td>
            <td width="130" bgcolor="f7f4f4" align="right"><b>Juros Mora</td>			  
            <td width="110" bgcolor="f7f4f4" align="right"><b>Data Movimento</td>			  
        </tr>
		</table>					  		
		
         <table width="650" border="1" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">		  
		    <tr>
            <td width="6" >&nbsp;</td>
            <td width="82" align="right">&nbsp;</td>
            <td width="85" align="center">&nbsp; </td>
            <td width="80" align="right" bgcolor="f7f4f4"><?=number_format($rsresultcc['vliof'], 2, ',', '.');?></td>
            <td width="110" align="right" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="135" align="right" bgcolor="f7f4f4"><font color="#003366"><?=number_format($rsresultcc['vlpercmora'], 2, ',', '.');?> % a.m.</font></td>
            <td width="110" align="right" bgcolor="f7f4f4">
              <font color="#003366"><strong><?=FormataData($rsresultcc['datmoventrada'],'pt');?></strong></font></td>	
          </tr>
		</table>	
		
		<br>
		
        <table width="650" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td ><img src="img/dot_branco.jpg" width="1" height="1"></td>
            <td bgcolor="#CCCCCC" align="center"> <strong>Lançamentos</strong></td>
          </tr>			  
		</table>  	
		
		  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7">&nbsp;</td>
            <td width="85" bgcolor="f7f4f4" align=""><b>Situação</td>
            <td width="88" bgcolor="f7f4f4"><b>Data</td>
            <td width="250" bgcolor="f7f4f4"><b>Histórico</td>
            <td width="80" bgcolor="f7f4f4" align="right"><b>Débito</td>
            <td width="80" bgcolor="f7f4f4" align="right"><b>Crédito</td>			  
            <td width="80" bgcolor="f7f4f4" align="right"><b>Saldo</td>			  
          </tr>
		  </table>	
		  
		  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>		  
		    <td width="7">&nbsp;</td>
            <td width="85" bgcolor="f7f4f4" >Saldo Inicial</td>
            <td width="81" bgcolor="f7f4f4"><?=FormataData($rsresultcc['datoperacao'],'pt');?></td>
            <td width="250" bgcolor="f7f4f4">Conversão da Operação</td>
            <td width="80" bgcolor="f7f4f4" align="right"><?=number_format($rsresultcc['vlcontrato'], 2, ',', '.');?></td>
            <td width="80" bgcolor="f7f4f4" align="right"></td>
            <td width="80" bgcolor="f7f4f4" align="right"><?=number_format($rsresultcc['vlcontrato'], 2, ',', '.');?></td>	
          </tr>
		  </table>			  
<?
         $vldebitotot = $rsresultcc['vlcontrato'];
		 while(!($rsmov==0))
		 {
		 
		   switch ($rsmov['codsitparcela'])
		   {
		      case 1:
		          $dessitparcela = "Normal";
				  break;
		      case 2:
		          $dessitparcela = "Liquidada";
				  break;				  
		      case 3:
		          $dessitparcela = "Liquidada parcial";
				  break;				  
		      case 4:
		          $dessitparcela = "Enviada a débito";
				  break;				  
		      case 5:
		          $dessitparcela = "Baixada";
				  break;				  
		      case 6:
		          $dessitparcela = "Estornada";
				  break;				  
		      case 7:
		          $dessitparcela = "Transferida";
				  break;					  
		   }
		 
   
?>
   
		  	  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
	            <tr>		  
	  		    <td width="7">&nbsp;</td>
	              <td width="85" bgcolor="f7f4f4" ><?=$dessitparcela?></td>
	              <td width="81" bgcolor="f7f4f4"><?=FormataData($rsmov['dtultapjurparcela'],'pt');?></td>
      	        <td width="250" bgcolor="f7f4f4">Apropriação de Juros</td>
          	    <td width="80" bgcolor="f7f4f4" align="right"><?=number_format($rsmov['vljurparcela'], 2, ',', '.');?></td>
	              <td width="80" bgcolor="f7f4f4" align="right"> </td>
      	        <td width="80" bgcolor="f7f4f4" align="right"><?$saldoaux = $rsresultcc['vlcontrato']+$rsmov['vljurparcela']; echo number_format($saldoaux, 2, ',', '.')?></td>
	            </tr>
	  		  </table>	
<?
  //somatorio coluna débito
  $vldebitotot = $vldebitotot+$vlparcelatot+$rsmov['vljurparcela'];
  
  
?>
	   
		  	  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
	            <tr>		  
	  		    <td width="7">&nbsp;</td>
	              <td width="85" bgcolor="f7f4f4" ><?=$dessitparcela?></td>
	              <td width="81" bgcolor="f7f4f4"><?=FormataData($rsmov['datvencimento'],'pt');?></td>
      	        <td width="250" bgcolor="f7f4f4">Liquidação na operação</td>
          	    <td width="80" bgcolor="f7f4f4" align="right"> </td>
	              <td width="80" bgcolor="f7f4f4" align="right"><?=number_format($rsmov['vlparcela'], 2, ',', '.');?></td>
      	        <td width="80" bgcolor="f7f4f4" align="right"><?$saldoaux2 = $saldoaux-$rsmov['vlparcela']; echo number_format($saldoaux2, 2, ',', '.');?></td>
	            </tr>
	  		  </table>	
<?			  		   
  //somatorio coluna crédito
  $vlcreditotot = $vlcreditotot+$rsmov['vlparcela'];
  
  //somatorio coluna saldo
  $vltotaltot = $saldoaux2;
		   $rsmov = mysql_fetch_array($rsqrymov);
		 }
?>		  
		  		  
		  <br>
		  <table width="650" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7">&nbsp;</td>
            <td width="85" bgcolor="f7f4f4" align="right"><b>Totais</td>
            <td width="80" ><b></td>
            <td width="250" ><b></td>
            <td width="80" bgcolor="f7f4f4" align="right"><b><? echo number_format($vldebitotot, 2, ',', '.'); ?></td>
            <td width="80" bgcolor="f7f4f4" align="right"><b><? echo number_format($vlcreditotot, 2, ',', '.'); ?></td>
            <td width="80" bgcolor="f7f4f4" align="right"><b><? echo number_format($vltotaltot, 2, ',', '.'); ?></td>
          </tr>
		  </table>			  			
<br><br>
<table width='568' border='1' cellspacing='0' class=form>
       <tr>
           <td align="right" width="30%"><a href="javascript:window.print();"><img src="../img/bt_imprimir.gif" border="0"></a></td>
		   
           <td align="left" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                <a href="javascript:window.close();"><img src="../img/bt_sair.gif" border="0"></a></td>		   
       </tr>
</table>

<body>
</body>
</html>
