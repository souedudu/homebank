<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 10/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Tela de Atendimento
************************************************************************************/
?>
<style>
table {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: none;
}
.CorFonteZinza{
	color:#666666;
}
.CorFonteAzul{
	color:#003366;
}
.Formulario{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	border-width:thin;
}
</style>

<script language=javascript>
function VerificaCamposObrigatorios()
{
  if (document.form.codmenatendimento.value =='')
  {
    alert('Informe a mensagem de atendimento.');
    document.form.codmenatendimento.focus();
    return false;
  }
}
</script>

<br>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td align="center" class="td2">
          <b>Andamento das Solicitações</b>
      </td>
  </tr>
</table>
<?

// Abre conexão com o bd
  $achou = Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);
  {
  //Busca Código do Técnico Responsável

   $sqlString6 = "Select te.* from tecnicoresp te, usuario u 
   				  where te.codtecnicoresp = u.codtecnicoresp and
				        u.codusuario = ".$_SESSION['codusuarioadm'];
                 
  $rsqry6 = mysql_query($sqlString6);
  $dados6 = mysql_fetch_array($rsqry6);
  
  // Lista dados que estão cadastrados na tabela
  if ($_REQUEST['tipoacao'] == "")
  {
  $sqlString = "Select s.*, c.nomcliente, c.desemail, c.numtelefone, cc.numcontacorrente, t.destiposervsol
                 From solicitacaoserv s, cliente c, contacorrente cc, tiposervsolicitacao t
                 where s.dtconclusao is null  and  s.dtencerramento is null
				   and s.flacancelada is null 
                   and s.codtecnicoresp = ".$dados6['codtecnicoresp']."
                   and s.codcliente = c.codcliente and s.codcliente = cc.codcliente
                   and s.codtiposervsol = t.codtiposervsol
                 order by s.codsolicitacao, s.dtsolicitacao";
                 
  $rsqry = mysql_query($sqlString);
  $dados = mysql_fetch_array($rsqry);
  
  $totalsol = 0;
   while (!($dados == 0))
   {
     $codsolicitacao = $dados['codsolicitacao'];
	 
	 // Recupera o nome e o cpf da conta corrente do cliente
     $sqlString2 = "select c.nomcliente, c.numcpfcnpj from contacorrente cc, cliente c
	               where cc.numcontacorrente = '".$dados['numcontacorrente']."'"."
				    and cc.codcliente = c.codcliente";  
	 
     $rsqry1 = mysql_query($sqlString2);
     $dadosconta = mysql_fetch_array($rsqry1);	 
?>

<form name="form" method="post" action="" onSubmit="">

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Nº da Solicitação:</b></td>
      <td align="left" class="td3"><? echo $dados['codsolicitacao'];?></td>
  </tr>
  <tr>
      <td width="5" align="justify">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Data de Abertura:</b></td>
      <td align="left" class="td3"><? echo FormataData($dados['dtsolicitacao'],'pt'); ?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Aberta Por:</b></td>
      <td align="left" class="td3"><? echo $dados['nomcliente'];?></td>
  </tr>
</table>

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
     <td width="5"align="center">&nbsp;</td>
     <td width="150" align="right" class="td4"><b>Conta corrente do cliente:</b></td>
     <td align="left" class="td3"><? echo $dados['numcontacorrente']. "- ".$dadosconta['nomcliente'];?></td>
  </tr>

  <tr>
     <td width="5"align="center">&nbsp;</td>
     <td width="150" align="right" class="td4"><b>CPF:</b></td>
     <td align="left" class="td3"><? echo $dadosconta['numcpfcnpj'];?></td>
  </tr>
</table> 

<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Tipo Serviço:</b></td>
      <td align="left" class="td3"><? echo $dados['destiposervsol'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>E-mail Contato:</b></td>
      <td align="left" class="td3"><? echo $dados['desemail'];?></td>
  </tr>
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Telefone Contato:</b></td>
      <td align="left" class="td3"><? echo $dados['numtelefone'];?></td>
  </tr>
</table>
<table border="1" width="568" cellspacing="0" class="table">
  <tr>
      <td width="5"align="center">&nbsp;</td>
      <td width="150" align="right" class="td4"><b>Detalhes da Solicitação:</b></td>
      <td align="left" class="td3"><? echo $dados['dessolicitacao'];?></td>
  </tr>
</table>

<?

   // Lista o Histórico do atendimento
   $sqlstring4 = "select a.*, t.nomtecnicoresp from andamensolicitacao a, tecnicoresp t
                  where a.codsolicitacao =".$codsolicitacao.
                 " and a.codtecnicoresp = t.codtecnicoresp ".
                 " order by a.datregandamento";
   $query4 = mysql_query($sqlstring4);
   $rsresult3 = mysql_fetch_array($query4);
   
   if (!($rsresult3 == 0))
   {
      echo "<table width='568' border='1' cellspacing='0' class=form>";
      echo "<tr>";
      echo "<td width='5'>&nbsp;";
      echo "</td>";
      echo "<td align='center' class='td4'>";
      echo "    <b>Histórico de Atendimento</b>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      while (!($rsresult3 == 0))
      {
    
         // Recupera a descrição da mensagem de atendimento
         if ($rsresult3['codmenatendimento'] != "")
         {
           $sqlmen = mysql_query("select desmenatendimento from mensatendimento where codmenatendimento = ".$rsresult3['codmenatendimento']);
		   
           $rsresult5 = mysql_fetch_array($sqlmen);
           $desmesnagem = $rsresult5['desmenatendimento'];
         }
?>
        <table width='568' border='1' cellspacing='0' class=form>
           <tr>
             <td width='5'>&nbsp;</tr>
             <td width="150" align="right" class="td4"><b>Data/Hora:</b></td>
             <td align="left" class="td3"><?=FormataData($rsresult3['datregandamento'],'pt'). " - ".$rsresult3['hrregandamento'];?>
                ( <?=$rsresult3['nomtecnicoresp'];?> )
             </td>
           </tr>
           <tr>
             <td width='5'>&nbsp;</tr>
             <td width="150" align="right" class="td4"><b>Descrição:</b></td>
             <td align="left" class="td3"><?=$desmesnagem;?></td>
           </tr>
           <tr>
             <td width='5'>&nbsp;</tr>
             <td width="150" align="right" class="td4"><b>Complemento:</b></td>
             <td align="left" class="td3"><?=$rsresult3['descompmensagem'];?></td>
           </tr>
           <tr cellspacing="1">
             <td width='5'></tr>
             <td width="150" align="right" ><b></b></td>
             <td align="left"></td>
           </tr>
        </table>

<?
        $rsresult3 = mysql_fetch_array($query4);
      }
   }

?>

<table border="1" width="568" cellspacing="0" class="table">
<tr>
 <td width="3"> </td>
      <td width="400" align="center">&nbsp;</td>
      <td width="155" align="center">
          <a href="javascript://;" onclick="window.open('../admin/inc/adicionarandamento.php?codsolicitacao=<?=$codsolicitacao;?>','Triagem','width=600,height=400,scrollbars=YES, left=200, top=150')"><img src="img/Editar.gif" width="15" height="15" border="0" alt="Adicionar andamento a solicitação."></a>&nbsp;<b>Adicionar Andamento</b>		  
      </td>

  </tr>
</table>
  <br />

<?
   $dados = mysql_fetch_array($rsqry);
   $totalsol = $totalsol + 1;
   }//fim while
?>

<?
  //--------------------Total de Solicitações---------------------------//
?>

<br>
<table border="1" width="568" cellspacing="0" class="table">
<tr>
 <td width="3"> </td>
   <td width="400" align="left" class="td1">&nbsp;<b>Total de Solicitações: <? echo $totalsol;?></b>
   </td>
  </tr>
</table>
<?
  }//fim if LISTAR

  }//fim if conexão com o banco de dados
?>
