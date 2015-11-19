<?
/********************************************************************************
Autor: Vitor Hugo
Data Criação: 28/12/2005
Data Atualização:
Sistema: Home Bank
Descrição: Atualização das Tabelas
************************************************************************************/
?>
<table cellspacing="0" border="" width="550" align="center">
  <tr>
      <td width="5"></td>
      <td class="td2" align="center">Tela de Atualização das Tabelas do Sistema</td>
  </tr>
</table>
<?
  $dataaux = date("H:i:s", time());
  $Hr = substr($dataaux, 0, 2);
  if ($Hr == 00 and ($_SESSION['count'] == 0 or $_SESSION['count'] == ""))
  {
   $_SESSION['count'] = 1; //inicia o count para a atualização!!!
   echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
  }
  else
    {
?>
<table cellspacing="0" border="" width="770">
  <tr>
      <td width="5"></td>
      <td align="left"><BR><b>Aguarde um momento...</b>
                       <BR><b>Proxima atualização das tabelas será às <font color="red">00:00</b></font>

      </td>
  </tr>
</table>
<?
     echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"15; URL=''\">";
    }

  Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

  //Primeiro laço --> deletar tabelas
  if ($_SESSION['count'] == 1)
  {
    $sqlString0 = "delete from contacapital";
    $sqlString1 = "delete from devolucaoch";
    $sqlString2 = "delete from contratocredito";
    $sqlString3 = "delete from planopagamento";
    $sqlString4 = "delete from seguroprestamista";
    $sqlString5 = "delete from lancamentosccapital";
    $sqlString6 = "delete from aplicacaocaprem";
    $sqlString7 = "delete from contacapitalremunerada";
    $sqlString8 = "delete from lancamentocaprem";

    $rsqry0 = mysql_query($sqlString0) or die ("Erro ao Deletar Tabela contacapital");
    $rsqry1 = mysql_query($sqlString1) or die ("Erro ao Deletar Tabela devolucaoch");
    $rsqry2 = mysql_query($sqlString2) or die ("Erro ao Deletar Tabela contratocredito");
    $rsqry3 = mysql_query($sqlString3) or die ("Erro ao Deletar Tabela planopagamento");
    $rsqry4 = mysql_query($sqlString4) or die ("Erro ao Deletar Tabela seguroprestamista");
    $rsqry5 = mysql_query($sqlString5) or die ("Erro ao Deletar Tabela lancamentosccapital");
    $rsqry6 = mysql_query($sqlString6) or die ("Erro ao Deletar Tabela aplicacaocaprem");
    $rsqry7 = mysql_query($sqlString7) or die ("Erro ao Deletar Tabela contacapitalremunerada");
    $rsqry8 = mysql_query($sqlString8) or die ("Erro ao Deletar Tabela lancamentocaprem");

    echo "<script>alert('Tabelas Deletadas com Sucesso. Aguarde enquanto o Banco é Carregado...')</script>";

    //inicia váriável de sessão count
    $_SESSION['count']=2;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
  }

   //laços para atualização das tabelas
   if ($_SESSION['count'] == 2)
   {
    include "../library/etl_ContaCorrente.php";
    $_SESSION['count']=3;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
  }
   if ($_SESSION['count'] == 3)
   {
    include "../library/etl_ContaCapRemunerada.php";
    $_SESSION['count']=4;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 4)
   {
    include "../library/etl_ContaCapital.php";
    $_SESSION['count']=5;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 5)
   {
    include "../library/etl_AplicacaoCapRem.php";
    $_SESSION['count']=6;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 6)
   {
    include "../library/etl_ContratoCredito.php";
    $_SESSION['count']=7;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 7)
   {
    include "../library/etl_DevolucaoCH.php";
    $_SESSION['count']=8;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 8)
   {
    include "../library/etl_LancamentoCapRem.php";
    $_SESSION['count']=9;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 9)
   {
    include "../library/etl_LancamentosCCapital.php";
    $_SESSION['count']=10;
   echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
   break;
   }
    if ($_SESSION['count'] == 10)
   {
    include "../library/etl_PlanoPagamento.php";
    $_SESSION['count']=11;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;
   }
    if ($_SESSION['count'] == 11)
   {
    include "../library/etl_SeguroPrestamista.php";
    $_SESSION['count']=12;
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
    break;

   }
    //laço para impressão da execução da tarefa
    if ($_SESSION['count'] == 12)
    {
		include "../library/etl_preCadastro.php";
	    unset ($DETALHE);
    	unset ($CONF);
	    $_SESSION['count']=13;
    	echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL=''\">";
	    break;
	}
    if ($_SESSION['count'] == 13)
	{
     	$_SESSION['count'] = 0;

?>

<table cellspacing="0" border="" width="770">
  <tr>
      <td width="5"></td>
      <td align="left"><BR><b>Aguarde um momento até o tempo de atualização!</b>
                       <BR><b>Proxima atualização das tabelas será às <font color="red">00:00</b></font>
                       <? echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"10000000; URL=''\">"; ?>
      </td>
  </tr>
</table>
<?

    }
?>

