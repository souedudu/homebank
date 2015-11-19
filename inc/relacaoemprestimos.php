<?
/********************************************************************************
Autor: Gelson
Data Criação: 27/12/2005
Data Atualização: 27/12/2005 - Gelson
Sistema: Home Bank
Descrição: Consulta Relação de Empréstimos
************************************************************************************/

Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

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

<table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="600"><img src="img/dot_branco.jpg" width="1" height="10"></td>
        </tr>
</table>
	  
        <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td ><img src="img/dot_branco.jpg" width="7" height="1"></td>
            <td> <strong>Relação de Empréstimos</strong></td>
          </tr>
          <tr>
            <td width="7" ><img src="img/dot_branco.jpg" width="7" height="1"></td>
            <td colspan="5" valign="top"><strong>Conta Corrente:</strong> <?=$_SESSION['numcontacorrente']." - ".$_SESSION['nomcliente'];?></td>
          </tr>
		  </table>
		  
          <br />
		  <table width="593" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">  
		    <tr>
			  <td width="7" height="16">&nbsp;</td>
		      <td class="tb2" bgcolor="f7f4f4" align="center"><b>Relação de Empréstimos</td>		     
		    </tr>
		  </table> 
		  
		  <table width="593" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">  
          <tr>
		    <td width="7">&nbsp;</td>
            <td width="85" bgcolor="f7f4f4" align="right"><b>Cód. Título</td>
            <td width="70" bgcolor="f7f4f4"><b>Situação</td>
            <td width="75" bgcolor="f7f4f4"><b>Nº Parcelas</td>
            <td width="110" bgcolor="f7f4f4" align="right"><b>Valor Financiado</td>
            <td width="130" bgcolor="f7f4f4" align="right"><b>Taxa Juros Normal</td>			  
            <td width="110" bgcolor="f7f4f4" align="right"><b>Data Solicitação</td>			  
            <td width="30" bgcolor="f7f4f4" align="center"><b>Ver</td>			  			
          </tr>
		  </table>
		  
		  
          <table width="593" border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">
<?  		   

		 // Recupera a matricula da conta capital
		 $sql = "select c.*
		           from contratocredito c
		           where c.codcliente = ".$_SESSION['codcliente'].
				" order by c.datoperacao desc";
						  					  
		 $rsquery = mysql_query($sql);
		 $rsresult = mysql_fetch_array($rsquery);
		 
		 $bgcolor = "#EEEEEE";
		 $ct = 0;

		 while(!($rsresult==0))
		 {
		    $ct++;
			// Recupera o total de parcelas do financiamento
//			$sqlStringpar = "select codsitparcela from planopagamento where numcontrato  = ".$rsresult['numcontrato'];

			$sqlStringpar = "select count(*) numparcelas from planopagamento where numcontrato  = ".$rsresult['numcontrato'];				 
			$rsqrylpar = mysql_query($sqlStringpar);
			$rspar = mysql_fetch_array($rsqrylpar);
			$numparcelas = $rspar['numparcelas']; 
			
/*			while(!($rspar==0))
			{
			   $numparcelas++;
			   $rspar = mysql_fetch_array($rsqrylpar);
			}
*/				 
	 		 
			if ($bgcolor=="#EEEEEE")
			  $bgcolor = "#F4F4F4"; 
			else $bgcolor = "#EEEEEE"; 	
			
			// Recupera a descrição da situação do empréstimo
/*			if ($rsresult['codsituacao'] != "")
			{			
			  $sqlsit = "select dessitopecredito from sitopecaocredito 
                             where codsitopecredito  = ".$rsresult['codsituacao'];
				 
			  $rsqrysit = mysql_query($sqlsit);
			  $rssit = mysql_fetch_array($rsqrysit); 
  			  $dessituacao = $rssit['dessitopecredito'];			
			}
*/			
			if ($rsresult['codsituacao'] == 1)
			  $dessituacao = "Em Aberto";
			  
			if ($rsresult['codsituacao'] == 2)
			  $dessituacao = "Liquidado";
			  
		 $onclickcodsolicitacao = "window.open('inc/listaemprestimo.php?numcontrato=".$rsresult['numcontrato']."','Consulta','width=700,height=550,scrollbars=YES, left=140, top=110')";
		 
		 $opcaosol1 = "<a href='javascript://;' onclick=".chr(34).$onclickcodsolicitacao.chr(34)."><img src='img/visualizar.gif' width='15' height='15' border='0' alt='Visualizar a solicitação.'></a>";			  
			  
?>		  
		    <tr>
            <td width="7" >&nbsp;</td>
            <td width="78" align="right" bgcolor="f7f4f4"><?=FormataContrato($rsresult['numcontrato']);?></td>
            <td width="70" bgcolor="f7f4f4"><?=$dessituacao;?></td>
            <td width="85" align="center" bgcolor="f7f4f4"><?=$numparcelas;?></td>
            <td width="110" align="right" bgcolor="f7f4f4"><?=number_format($rsresult['vlcontrato'], 2, ',', '.');?></td>
            <td width="135" align="right" bgcolor="f7f4f4"><font color="#003366"><?=number_format($rsresult['vlpercjuros'], 2, ',', '.');?> %</font></td>
            <td width="110" align="right" bgcolor="f7f4f4">
              <font color="#003366"><strong><?=FormataData($rsresult['datoperacao'],'pt');;?></strong></font></td>	
   		   <td width="30" align="center" bgcolor="f7f4f4"><?=$opcaosol1;?></td>		  
          </tr>

<?
            $rsresult = mysql_fetch_array($rsquery);
		 }
?>
        </table>
		
        <table width="592" border="0" cellspacing="1" cellpadding="3">
          <tr>
		     <td width="7" >&nbsp;</td>
            <td><b>Total de Empréstimos: <?=$ct;?></b></td>
          </tr>
        </table>
		  		
        <table width="592" border="0" cellspacing="1" cellpadding="3">
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
