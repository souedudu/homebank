<?
/********************************************************************************
Autor: Vitor Hugo
Data Cria��o: 22/12/2005
Data Atualiza��o:
Sistema: Home Bank
Descri��o: Impress�o da Solica��o de Servi�o
************************************************************************************/

include("../../library/config.php");
include("../../library/funcoes.php");

 $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

//Montagem do Cabe�alho do Formul�rio de Avalia��o
?>


<head>
<title>.: Home Bank - Solicita��o de Servi�os Banc�rios :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../site.css" rel="stylesheet" type="text/css">

</head>
<body>

<table width="570" border="0" cellspacing="0" class=form>
  <tr>
      <td>
	      <img src="../img/titulorelatorio.jpg" width="570" height="67" border="0">
      </td>
  </tr>
</table>

<? 	
  
  //SQL para buscar a SOLICITA��O
  $sqlString0 = "Select * from solicitacaoserv where
				        codsolicitacao = ".$codsolicitacao;  	  
  $rsqry0 = mysql_query($sqlString0);
  $dados0 = mysql_fetch_array($rsqry0);    
      
  
  if ($dados0){

	//La�o para Exibir Solicita��o Aberta pelo Cliente  
    if($dados0['codcliente'] != ""){     	 	 
  	 	
	 //SQL para buscar dados do Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select c.* From cliente c where c.codcliente = ".$dados0['numcontacorrente'];	       	      
	 $rsqry = mysql_query($sqlString);
     $dadoscliente = mysql_fetch_array($rsqry);
		
	 
	 //Buscar dados do Autor da Abertura de Solicita��o
	 $sqlString = "Select c.* From cliente c where c.codcliente = ".$dados0['codcliente'];	       	      
	 $rsqry = mysql_query($sqlString);
     $dadossolicitante = mysql_fetch_array($rsqry);	 	 
	 
	 if ($dados0['codtecnicoresp'] != ""){
	 //SQL para buscar dados do T�cnico Respons�vel, de acordo com o n� da Solicita��o
	 $sqlString = "Select te.* From tecnicoresp te where te.codtecnicoresp = ".$dados0['codtecnicoresp'];	       	 
     $rsqry = mysql_query($sqlString);
     $dadostecnicoresp = mysql_fetch_array($rsqry);	
	 }	 	 				      
	 
	 //SQL para buscar dados do N�cleo do Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select n.* From nucleo n where n.codnucleo = ".$dadoscliente['codnucleo'];	       	       
	 $rsqry = mysql_query($sqlString);
     $dadosnucleo = mysql_fetch_array($rsqry);
	 
	 //SQL para buscar dados do Tipo de Solicita��o feita pelo Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select t.* From tiposervsolicitacao t where t.codtiposervsol = ".$dados0['codtiposervsol'];	       	 
     $rsqry = mysql_query($sqlString);
     $dadostiposervsol = mysql_fetch_array($rsqry);

     
    }//Fim If para Exibir Solicita��o Aberta Pelo Cliente
	
	//La�o para Exibir Solicita��o Aberta pelo T�cnico ou Delegado  
    if($dados0['codcliente'] == ""){
	
	 //SQL para buscar dados do T�cnico de Abertura da Solicita��o, de acordo com o n� da Solicita��o
	 $sqlString = "Select te.* From tecnicoresp te where te.codtecnicoresp = ".$dados0['codtecnicosol'];	       	 
     
	 $rsqry = mysql_query($sqlString);
     $dadossolicitante = mysql_fetch_array($rsqry);			 	 	 	 
	 
	 if ($dados0['codtecnicoresp'] != ""){
	 //SQL para buscar dados do T�cnico Respons�vel, de acordo com o n� da Solicita��o
	 $sqlString = "Select te.* From tecnicoresp te where te.codtecnicoresp = ".$dados0['codtecnicoresp'];	       	 
     $rsqry = mysql_query($sqlString);
     $dadostecnicoresp = mysql_fetch_array($rsqry);	
	 }	 	 				      
	 
	 //SQL para buscar dados do Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select c.* From cliente c where c.codcliente = ".$dados0['numcontacorrente'];	       	      
	 $rsqry = mysql_query($sqlString);
     $dadoscliente = mysql_fetch_array($rsqry);
	 
	 //SQL para buscar dados do N�cleo do Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select n.* From nucleo n where n.codnucleo = ".$dadoscliente['codnucleo'];	       	       
	 $rsqry = mysql_query($sqlString);
     $dadosnucleo = mysql_fetch_array($rsqry);
	 
	 //SQL para buscar dados do Tipo de Solicita��o feita pelo Cliente, de acordo com o n� da Solicita��o
	 $sqlString = "Select t.* From tiposervsolicitacao t where t.codtiposervsol = ".$dados0['codtiposervsol'];	       	 
     $rsqry = mysql_query($sqlString);
     $dadostiposervsol = mysql_fetch_array($rsqry);
		
	}

 }//Fim If que Carrega dados da Solicita��o


  
?>
<form name="form" method="post" action="" onSubmit="return VerificaCamposObrigatorios();">

<?
  if ($dados0['codtecnicosol'] != "")
  {
   $sqlString3 = "Select te.*
                 From solicitacaoserv s, tecnicoresp te
                 where te.codtecnicoresp = ".$dados0['codtecnicosol'];


   $rsqry3 = mysql_query($sqlString3);
   $dados3 = mysql_fetch_array($rsqry3);
   $abertura = $dados3['nomtecnicoresp'];

  }//fim if que verifica se existe c�digo do tecnico solicitante
   else
   {
    $abertura = "Pr�prio Cliente";
   }
?>
<table width="568" border="1" cellspacing="0">
  <tr>
      <td align="left" ><b>Data da Abertura</b></td>
      <td align="left" ><b>N� da Solicita��o</b></td>
      <td align="left" ><b>Aberta por</b></td>
  </tr>
  <tr>
      <td align="left" ><? echo FormataData($dados0['dtsolicitacao'],'pt'); ?></td>
      <td align="left" ><? echo $codsolicitacao;?></td>
      <td align="left" >

<? 
	if($dados0['codcliente'] != ""){
	echo $dadossolicitante['nomcliente'];
	}else{
			echo $dadossolicitante['nomtecnicoresp'];
	}

?>
	  
	  </td>
  </tr>
</table>

<BR>

<table width="568" border="1" cellspacing="0">
   <tr>
      <td align="left" ><b>Conta Corrente - Cliente:</b>&nbsp;<? echo $dados0['numcontacorrente'];?> - <? echo $dadoscliente['nomcliente'];?></td>
   </tr>
   <tr>
      <td align="left" ><b>CPF / CNPJ:</b>&nbsp;<? echo $dadoscliente['numcpfcnpj'];?></td>
   </tr>
   <tr>
      <td align="left" ><b>N�cleo:</b>&nbsp;<? echo $dadoscliente['codnucleo']." - ".$dadosnucleo['desnucleo'];?></td>
  </tr>
</table>
<br>
<table width="568" border="1" cellspacing="0">
  <tr>
      <td align="left"> <b>Tipo Servi�o:</b>&nbsp;<? echo $dadostiposervsol['destiposervsol'];?></td>
   </tr>
  <tr>
      <td ><b>Detalhes da Solicita��o:</b>&nbsp;<? echo $dados0['dessolicitacao'];?></td>
  </tr>
  
<?
  if ($dados0['dtconclusao'] == ""){
     $dados0['dtconclusao'] = "<font color='red'>Servi�o ainda n�o Conclu�do!</font>";
  }else{
        $dados0['dtconclusao'] = FormataData($dados['dtconclusao'],'pt');
        $dados0['dtconclusao'] = "<font color='red'>".$dados['dtconclusao']."</font>";
  }
?>

   <tr>
      <td align="left" > <b>Data da Conclus�o do Servi�o:</b>&nbsp;<? echo $dados0['dtconclusao'];?></td>
   </tr>
   <tr>
      <td align="left"><b>Nome - T�cnico Respons�vel:</b>&nbsp;<? echo $dadostecnicoresp['nomtecnicoresp'];?></td>
  </tr>

</table>

<BR>

<?

   // Lista o Hist�rico do atendimento
   $sqlstring4 = "select a.*, t.nomtecnicoresp from andamensolicitacao a, tecnicoresp t
                  where a.codsolicitacao =".$codsolicitacao.
                 " and a.codtecnicoresp = t.codtecnicoresp ".
                 " order by a.datregandamento";

   $query4 = mysql_query($sqlstring4);
   $rsresult3 = mysql_fetch_array($query4);

   if (!($rsresult3 == 0))
   {
      echo "<BR>";
      echo "<table width='568' border='1' cellspacing='0' >";
      echo "<tr>";
      echo "<td width='5'>&nbsp;";
      echo "</td>";
      echo "<td align='center'>";
      echo "    <b>Hist�rico de Atendimento</b>";
      echo "</td>";
      echo "</tr>";
      echo "</table><BR>";
?>
        <table width='568' cellspacing='2'>
           <tr>
             <td align="justify" width="30%" class= "td3" cellspacing='2'><b>Data/Hora</b></td>
             <td align="justify" width="40%" class= "td3" cellspacing='2'><b>Descri��o</b></td>
             <td align="justify" width="30%" class= "td3"  cellspacing='2'><b>Complemento</b></td>
           </tr>
        </table>
<?


      while (!($rsresult3 == 0))
      {

         // Recupera a descri��o da mensagem de atendimento
         if ($rsresult3['codmenatendimento'] != "")
         {
           $query5 = mysql_query("select desmenatendimento from mensatendimento where codmenatendimento = ".$rsresult3['codmenatendimento']);
           $rsresult5 = mysql_fetch_array($query5);
           $desmesnagem = $rsresult5['desmenatendimento'];
         }
?>
        <table width='568' border='1' cellspacing='0' class=form>
           <tr>
             <td align="justify" width="30%"><?=FormataData($rsresult3['datregandamento'],'pt'). " - ".$rsresult3['hrregandamento'];?></td>
             <td align="justify" width="40%"><?=$desmesnagem;?></td>
             <td align="justify" width="30%"><?=$rsresult3['descompmensagem'];?></td>
           </tr>
        </table>
<?
        $rsresult3 = mysql_fetch_array($query4);
      }
   }


?>
<BR><BR><BR>
<table width='568' border='1' cellspacing='0' class=form>
       <tr>
           <td align="center"><a href="javascript:window.print();"><img src="../img/bt_imprimir.gif" border="0"></a>&nbsp;&nbsp;<a href="javascript:window.close();"><img src="../img/bt_sair.gif" border="0"></a></td>
       </tr>
</table>


