<?
/********************************************************************************
Autor: Gelson
Data Cria��o: 
Data Atualiza��o: 24/11/2005 - Gelson
Sistema: Home Bank
Descri��o: Consulta Extrato de Aplica��es
************************************************************************************/

    // Abre conex�o com o bd
	$achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

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

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.codtipoaplicacao.value =='')
  {
    alert('Selecione a situa��o da aplica��o');
    document.form.codtipoaplicacao.focus();
    return false;
  }

}
</script>

 <table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>  
    <td width="500"><strong>Extrato de Aplica��o &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Data: <?=date("d/m/Y");?></strong></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td width="500"><strong>Conta Corrente:</strong> <?=$_SESSION['numcontacorrente']." - ".$_SESSION['nomcliente'];?></td>	
  </tr>
 </table>  
<?
if ($_REQUEST['codtipoaplicacao'] != "")
{
    // Recupera a descri��o do tipo de aplica��o
    switch ($_REQUEST['codtipoaplicacao'])
	{
      case 1:
        $destipoaplicacao = "Abertas";
        break;
      case 2:
        $destipoaplicacao = "Canceladas";
        break;
      case 3:
        $destipoaplicacao = "Resgatadas";
        break;
      case 4:
        $destipoaplicacao = "Todas";
        break;
	}
	
  // Recupera os Dados da Aplica��o
  $sqlString = "select a.codidentaplicremunerada, a.codmodcapremun, a.vlaplicacao, a.numcontacaptacao, 
                a.dataplicacao, a.numprazocarenciadias, a.vltaxabrutaano, m.desmodalidade
                from aplicacaocaprem a, contacapitalremunerada c, modcapremunerada m
                where a.numcontacaptacao = c.numcontacaptacao                
                and a.codmodcapremun = m.codmodcapremun
                and c.numcontacorrente = ".$_SESSION['numcontacorrente'];
				
  //echo "sqlString: ".$sqlString."<BR>";

  if ($_REQUEST['codtipoaplicacao'] != 4)
  {
    $sqlString = $sqlString." and a.codsituacao = ".$_REQUEST['codtipoaplicacao'];	
  }
				  				  
  $rsqryaplicacao = mysql_query($sqlString);
  $rsaplicacao = mysql_fetch_array($rsqryaplicacao);  


	
  if(!($rsaplicacao==0))
  {    


?> 
<br><br>

 <table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>  
    <td width="500"><strong>Tipo de Aplica��o: </strong><?=$destipoaplicacao?></td>
  </tr>
 
 </table> 
 
 <table width="580" border="0" cellspacing="0" cellpadding="0"> 
  <tr>
     <td>&nbsp;</td>
      <td bgcolor="" align="center"><strong>Dados da Aplica��o</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	  <table width="575" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="155" bgcolor="#f4f4f4"><div align="right">N� da Aplica��o:</div></td>
        <td width="245" bgcolor="#f4f4f4"><strong class="CorFonteAzul"><? echo $rsaplicacao['codidentaplicremunerada'];?></strong></td>
        <td width="95" bgcolor="#f4f4f4"><div align="right">Valor Inicial:</div></td>
        <td width="80" bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=number_format($rsaplicacao['vlaplicacao'], 2, ',', '.');?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Modalidade:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=$rsaplicacao['desmodalidade']?>
			
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right">Data Aplica��o:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=FormataData($rsaplicacao['dataplicacao'],'pt');?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Data fim de Car�ncia:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?=incdata($rsaplicacao['numprazocarenciadias'], FormataData($rsaplicacao['dataplicacao'],'pt')); ?>
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right">Car�ncia:</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul"><?=$rsaplicacao['numprazocarenciadias'];?></strong></td>
        </tr>
      <tr>
        <td bgcolor="#f4f4f4"><div align="right">Taxa bruta inicial (% a.a):</div></td>
        <td bgcolor="#f4f4f4"><strong class="CorFonteAzul">
          <?=number_format($rsaplicacao['vltaxabrutaano'], 2, ',', '.');?>
        </strong></td>
        <td bgcolor="#f4f4f4"><div align="right"></div></td>
        <td bgcolor="#f4f4f4">&nbsp;</td>
        </tr>
    </table>
	
 <br>	
 <table width="580" border="0" cellspacing="0" cellpadding="0"> 
  <tr>
    <td>&nbsp;</td>
    <td>
	  <table width="575" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td bgcolor="" align="center"><strong>Lan�amentos da Aplica��o</strong></td>
	  </tr>
	 </td>
	 </table> 
   </tr>
 </table>  

 <table width="565" border="0" cellspacing="2" cellpadding="2"> 	
   <tr>
      <td width="5"> </td>
      <td bgcolor="#f4f4f4"><b>Data</td>
	  <td bgcolor="#f4f4f4"><b>Hist�rico</td>
	  <td align="right" bgcolor="#f4f4f4"><b>D�bitos</td>
	  <td align="right" bgcolor="#f4f4f4"><b>Cr�ditos</td>
	  <td align="right" bgcolor="#f4f4f4"><b>Saldo</td>
   </tr>
<?
  // Recupera os Lan�amentos da Aplica��o
  $sqlString = "select a.* from lancamentocaprem a 
                where  a.numcontacaptacao = ".$rsaplicacao['numcontacaptacao'].
               " order by a.datlote";
	//echo "sqlString1: ".$sqlString;			 
  
  $rsqrylancaplic = mysql_query($sqlString);
  $rslancaplic = mysql_fetch_array($rsqrylancaplic);  
  
  while (!($rslancaplic==0))
  {        	 
	 
	 
	 
	 // Recupera a descri��o do historico de lan�amento
     $sqlStringHist = "select * from historicolanc 
                      where codhistlancamento  = ".$rslancaplic['codproduto'].$rslancaplic['codhistlancamento'];
	 
	 //echo "<br>sqlStringHist2: ".$sqlStringHist."<br>";				       
	 
	 $rsqrylHist = mysql_query($sqlStringHist);
     $rsHistorico = mysql_fetch_array($rsqrylHist); 
	 
     // Recupera se o tipo de lan�amento � cr�dito ou d�bito 
     $sqlStringLote = "select destipolote from lotecaprem 
                      where codlote  = ".$rslancaplic['codlote'];
				 
     $rsqrylLote = mysql_query($sqlStringLote);
     $rsLote = mysql_fetch_array($rsqrylLote); 	  	 
	  
	if ( $rsLote['destipolote'] == 'C')
	{ 
		  $valorcredito = number_format($rslancaplic['vllancamento'], 2, ',', '.'); 		  		  
		  $valordebito = "";
		  $valorsaldo = $valorsaldo + $rslancaplic['vllancamento']; 
	}
	else
	{
		  $valorcredito = ""; 
		  $valorsaldo = $valorsaldo - $rslancaplic['vllancamento']; 		   			  		  
		  $valordebito = number_format($rslancaplic['vllancamento'], 2, ',', '.');		  		   
	}
		
?>  
  
   <tr>
      <td width="5"> </td>
      <td bgcolor="#f4f4f4"><?=FormataData($rslancaplic['datlote'],'pt');?></td>
	  <td bgcolor="#f4f4f4"><?=$rsHistorico['deshistlancamento'];?></td>	  
	  <td width="64" bgcolor="#f4f4f4" align="right"><?=$valordebito;?></td>
	  <td width="64" bgcolor="#f4f4f4" align="right"><?=$valorcredito;?>
	  </td>
	  <td width="64" bgcolor="#f4f4f4" align="right"><b>
	      <?
		     if ( $valorsaldo < 0 )
		       echo "<font color ='red'>";
			   
		     echo number_format($valorsaldo, 2, ',', '.');
			 
		     echo "</font>";

		  ?></b>
	  </td>
   </tr>
     
<?
	  
     $rslancaplic = mysql_fetch_array($rsqrylancaplic);
  }
?>   
   
 </table>

	</td>
  </tr>
  <tr>
    <td height="30" valign="top">&nbsp;</td>
    <td height="35"><br><br>
     <div align="center">
 	    <a href="javascript:(window.print())"><img src="img/bt_imprimir.gif" width="67" height="20" border="0" /></a>
<?
	include_once('inc_botoes.php');
?>
    </div>
	 </td>
  </tr>
</table>

<?
}
else
{
?>
  <br><br>
  <div align="center">
  <br>N�o foi encontrado nenhum registro para aplica��o do tipo <?=$destipoaplicacao?><br><br><br>
<?
	include_once('inc_botoes.php');
?>
    </div>

<?
}

}
else
{
?>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">
 <table width="530" border="0" cellspacing="0" cellpadding="0"> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;</td>
    <td><strong>Situa��o da aplica��o </strong></td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;</td>
    <td>
       <select name="codtipoaplicacao" id="codtipoaplicacao">
	        <option value="">Selecione</option>  
            <option value="1">Abertas</option>
            <option value="2">Canceladas</option>
            <option value="3">Resgatadas</option>			
			<option value="4">Todas</option>			
       </select>  
	
	</td>
  </tr>
  
  <tr> 
    <td>&nbsp;&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;</td>
  </tr>
    	  
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Pesquisar">
	  <input type="hidden" name="enviar" value="true"></td>
    </tr>

  </table>
</form>  
<?
}
	

Conexao($opcao='close');
	
if(empty($achou)){
	echo("<div align='center'><p><br><br><br>");
	echo("N�o foi poss�vel estabelecer uma conex�o com o BD.");
	echo("</p></div>");
}	
?>
