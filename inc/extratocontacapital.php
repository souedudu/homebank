<?
/********************************************************************************
Autor: Gelson
Data Criação: 22/11/2005
Data Atualização: 23/11/2005 - Gelson
Sistema: Home Bank
Descrição: Consulta Extrato Conta Capital
************************************************************************************/
?>

<style>
.base{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#FFFFFF;
	font-weight:bold;
	text-align:right;
	padding-right:5px;
}

.menu{
	color:#FFFFFF;
	font-weight:bold;
	text-align:center;
	text-decoration:none;
	font-size:10px;
}


body,p,div,select,table,tr,th,td,input,textarea,.texto{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000;
	border:0px solid #606060;
	cellspacing: 0px
}


.td1{
    border:1px solid #606060;
	background-color:#F2F8E4;
	color:#CC0000;
	font-weight:bold;
}
.td2{
    border:1px solid #606060;
    background-color:#F7FEE7;
	color:#000000;
	font-weight:bold;
}
.td3{
	background-color:#F7FEE7
}
.td4{
    border:0px solid #606060;
    background-color:#F4F4F4;
	color:#000000;
	font-weight:bold;
}
.td5{
    border:0px solid #606060;
    background-color:#FFFFFF;
	color:#000000;
}
th{
	background-color:#637B9A;
	color:#F2F4F7;
}

input,textarea,select{
	border:1px solid;
	background-color:#F2F8E4;
}

.tb{
	border:1px solid #FFF;
	background-color:#FFF;
}

.tberro{
	border:1px solid #FF0000;
	background-color:#FF9999;
	color:#CC0000;
	font-weight:bold;
}

a{
color:#FFF;
text-decoration:none;
}
.bt{
background-color:#778897;
color:#FFFFFF;
font-weight:bold;
font-size:10px;
font-family:arial;
}

.link{
color:#333333;
text-decoration:underline;
}

.btLink{
 background-color:#C6D2DF;
 border:1px solid #000;
 text-decoration:none;
 font-weight:bold;
 padding:2px;
 padding-top:0px;
 padding-bottom:0px;
 color: #000000;

}
</style>

<?



  Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
  
  // Recupera a matricula da conta capital
  $sqlrecmatricula = "select c.nummatricula
                      from contacapital c
                      where c.numcontacorrente = ".$_SESSION['numcontacorrente'].
			     	  " and c.codcliente = ".$_SESSION['codcliente'];
  $rsquerymat = mysql_query($sqlrecmatricula);
  $rsresultmat = mysql_fetch_array($rsquerymat);				  
				  
  // Recupera os lançamentos da conta capital do associado				  
  /*
  $sqlreclancamentoscc = "select l.*, ll.deslotelancccapital, h.deshistlancamento
  from lancamentosccapital  l, lotelanccontacapital ll, historicolanc h  
  where l.nummatricula = ".$rsresultmat['nummatricula'].
  " and l.codnumlotelanc = ll.codnumlotelanc
  and l.codhistlancamento = h.codhistlancamento
  Order by l.datprocessamento";
  */		  				  
  $sqlreclancamentoscc = "select l.*, ll.deslotelancccapital
                          from lancamentosccapital l, lotelanccontacapital ll
                          where nummatricula = ".$rsresultmat['nummatricula'].
                          " and l.codnumlotelanc = ll.codnumlotelanc and codhistlancamento in (1,6) 
                          Order by datprocessamento";						  
						  			  					  
  $rsquerylanca = mysql_query($sqlreclancamentoscc);
  $rsresultlanca = mysql_fetch_array($rsquerylanca);	

?>

<table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="600"><img src="img/dot_branco.jpg" width="1" height="10"></td>
        </tr>
</table>
	  
        <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td ><img src="img/dot_branco.jpg" width="7" height="1"></td>
            <td> <strong>Extrato da Conta Capital</strong></td>
          </tr>
          <tr>
            <td width="5" height="16"><img src="img/dot_branco.jpg" width="7" height="1"></td>
            <td colspan="5" valign="top"><strong>Conta Corrente:</strong> <?=$_SESSION['numcontacorrente']." - ".$_SESSION['nomcliente'];?></td>
          </tr>
		  </table>
		  
          <br />
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
		    <tr>
			  <td width="7" height="16">&nbsp;</td>
		      <td bgcolor="f7f4f4" align="center"><b>SUBSCRIÇÕES</td>		     
		    </tr>
		  </table>  
		  
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7" height="16">&nbsp;</td>
            <td width="74" bgcolor="f7f4f4">
            <div align="left"><b>Data </div></td>
            <td width="120" bgcolor="f7f4f4">
            <div align="left"><b>Doc.</div></td>
            <td width="235" bgcolor="f7f4f4">
            <div align="left"><b>Hist&oacute;rico</div></td>
            <td width="40" bgcolor="f7f4f4"> 
            <div align="right"><b>Débito</div></td>
            <td width="40" bgcolor="f7f4f4">
            <div align="right"><b>Crédito</div></td>			  
            <td width="50" bgcolor="f7f4f4">
            <div align="right"><b>Saldo</div></td>			  
          </tr>
		  </table>
		  
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td width="7" height="16">&nbsp;</td>
			<td width="445" height="16" bgcolor="f7f4f4">
              <div align="left"><b>Saldo Anterior</div></td>
            <td bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><strong>0,00</strong></font></div></td>
          </tr>
		  </table>
		  
          <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<?  		   
		 $bgcolor = "#EEEEEE";
	     $valorsaldo = 0;
		 while(!($rsresultlanca==0))
		 {
		 
			// Recupera a descrição do historico de lançamento
			$sqlStringHist = "select * from historicolanc 
                             where codhistlancamento  = 2".$rsresultlanca['codhistlancamento'];
				 
			$rsqrylHist = mysql_query($sqlStringHist);
			$rsHistorico = mysql_fetch_array($rsqrylHist); 
	 
	 		 
			if ($bgcolor=="#EEEEEE")
			  $bgcolor = "#F4F4F4"; 
			else $bgcolor = "#EEEEEE";
			
			if ( $rsresultlanca['vllancamento'] >= 0)
			{ 
			  $valorcredito = number_format($rsresultlanca['vllancamento'], 2, ',', '.'); 
			  $valordebito = "";
			  $valorsaldo = $valorsaldo + $rsresultlanca['vllancamento']; 
			}
			else
			{
			  $valorcredito = ""; 
			  $valorsaldo = $valorsaldo - $rsresultlanca['vllancamento']; 
			  $valordebito = number_format($rsresultlanca['vllancamento'], 2, ',', '.'); 
			}
			
?>		  
		    <tr>
            <td width="7" height="16">&nbsp;</td>
            <td width="69" bgcolor="f7f4f4"><?=FormataData($rsresultlanca['datprocessamento'],'pt');?></td>
            <td width="120" bgcolor="f7f4f4">
              <div align="left"><?=$rsresultlanca['deslotelancccapital'];?></div></td>
            <td width="235" bgcolor="f7f4f4">
              <div align="left"><?=$rsHistorico['deshistlancamento'];?></div></td>
            <td width="40" bgcolor="f7f4f4">
              <div align="right"><?=$valordebito;?></div></td>
            <td width="40" bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><?=$valorcredito;?></font></div></td>
            <td width="50" bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><strong><?=number_format($valorsaldo, 2, ',', '.');?></strong></font></div></td>			  
          </tr>

<?
            $rsresultlanca = mysql_fetch_array($rsquerylanca);
		 }
?>
        </table>


          <br /><br />
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
		    <tr>
			  <td width="7" height="16">&nbsp;</td>
		      <td bgcolor="f7f4f4" align="center"><b>INTEGRALIZAÇÕES</td>		     
		    </tr>
		  </table>  
		  
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7" height="16">&nbsp;</td>
            <td width="74" bgcolor="f7f4f4">
            <div align="left"><b>Data </div></td>
            <td width="120" bgcolor="f7f4f4">
            <div align="left"><b>Doc.</div></td>
            <td width="235" bgcolor="f7f4f4">
            <div align="left"><b>Hist&oacute;rico</div></td>
            <td width="40" bgcolor="f7f4f4"> 
            <div align="right"><b>Débito</div></td>
            <td width="40" bgcolor="f7f4f4">
            <div align="right"><b>Crédito</div></td>			  
            <td width="50" bgcolor="f7f4f4">
            <div align="right"><b>Saldo</div></td>			  
          </tr>
		  </table>
		  
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td width="7" height="16">&nbsp;</td>
			<td width="445" height="16" bgcolor="f7f4f4">
              <div align="left"><b>Saldo Anterior</div></td>
            <td bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><strong>0,00</strong></font></div></td>
          </tr>
		  </table>
		  
          <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">	
<?  		   

  
		 $sqllancintegra = "select l.*, ll.deslotelancccapital
                          from lancamentosccapital l, lotelanccontacapital ll
                          where nummatricula = ".$rsresultmat['nummatricula'].
                          " and l.codnumlotelanc = ll.codnumlotelanc and codhistlancamento not in (1,6) 
                          Order by datprocessamento";
						  			  					  
		 $rsqrylancintegra = mysql_query($sqllancintegra);
		 $rslancaintegra = mysql_fetch_array($rsqrylancintegra);  
  
		 $bgcolor = "#EEEEEE";
	     $valorsaldo = 0;
		 while(!($rslancaintegra==0))
		 {
		 
			// Recupera a descrição do historico de lançamento
			$sqlStringHist = "select * from historicolanc 
                             where codhistlancamento  = 2".$rslancaintegra['codhistlancamento'];
				 
			$rsqrylHist = mysql_query($sqlStringHist);
			$rsHistorico = mysql_fetch_array($rsqrylHist); 
	 
	 		 
			if ($bgcolor=="#EEEEEE")
			  $bgcolor = "#F4F4F4"; 
			else $bgcolor = "#EEEEEE";
			
			if ($rslancaintegra['vllancamento'] >= 0)
			{ 
			  $valorcredito = number_format($rslancaintegra['vllancamento'], 2, ',', '.'); 
			  $valordebito = "";
			  $valorsaldo = $valorsaldo + $rslancaintegra['vllancamento']; 
			}
			else
			{
			  $valorcredito = ""; 
			  $valorsaldo = $valorsaldo - $rslancaintegra['vllancamento']; 
			  $valordebito = number_format($rslancaintegra['vllancamento'], 2, ',', '.'); 
			}
			
?>		  
		    <tr>
            <td width="7" height="16">&nbsp;</td>
            <td width="69" bgcolor="f7f4f4"><?=FormataData($rslancaintegra['datprocessamento'],'pt');?></td>
            <td width="120" bgcolor="f7f4f4">
              <div align="left"><?=$rslancaintegra['deslotelancccapital'];?></div></td>
            <td width="235" bgcolor="f7f4f4">
              <div align="left"><?=$rsHistorico['deshistlancamento'];?></div></td>
            <td width="40" bgcolor="f7f4f4">
              <div align="right"><?=$valordebito;?></div></td>
            <td width="40" bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><?=$valorcredito;?></font></div></td>
            <td width="50" bgcolor="f7f4f4">
              <div align="right"><font color="#003366"><strong><?=number_format($valorsaldo, 2, ',', '.');?></strong></font></div></td>			  
          </tr>

<?
            $rslancaintegra = mysql_fetch_array($rsqrylancintegra);
		 }
?>
        </table>
		<br/><br/>
		<table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
		    <tr>
			  <td width="7" height="16">&nbsp;</td>
		      <td bgcolor="" align="left"><b><strong>Saldo atual: </strong></b><font color="#003366"><b>R$ <?=number_format($valorsaldo, 2, ',', '.');?> </font></b></td>		     
		    </tr>
		</table>  
		  		
        <table width="592" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="img/dot_branco.jpg" width="1" height="20"></td>
          </tr>
        </table>
        <div align="center">
 	    <a href="javascript:(window.print())"><img src="img/bt_imprimir.gif" width="67" height="20" border="0"/></a>
<?
	include_once('inc_botoes.php');
?>
    </div>
