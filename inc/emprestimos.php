<?
    include "admin/inc/funcoes_js.php";
    include "admin/inc/funcoes_js2.php";

    //Abre Conexão com o Banco de Dados
    Conexao($opcao='open',conexao_host,conexao_user,conexao_pass,conexao_db);

    //Formulário para Simular Empréstimos
    if ($acao == "Simular")
    {

     //funcao para transformar segundos em dias
	 function sec2day($sec)
     {
 		$day = $sec/60/60/24;
		return $day;
	 }

     //funcao para calcular a diferenca entre 2 dias
	 function diasDiff($dia1,$dia2){
		$sec = date("U",$dia1)-date("U",$dia2);
		$dia = sec2day($sec);
		return $dia;
	 }

	 //funcao para retornar número formatado
	 function numero($num,$money=true){
		if($money)
        {
         $m = "R$";
        }
         else
             {
              $m = "";
             }
		$num = round($num,2);
		$num = number_format($num,"2",",",".");
		return "$m $num";
    }

     //funcao com a tabela price
     function price($juros,$dia)
     {
		$juros = ($juros / 100) + 1;
		$dias = $dia/1;
		$fator = (1 / (pow($juros,$dias)));
		$fator = number_format($fator,8,".","");

		return  $fator;
 	  }

    //Função de Arrendondamento de Valores para até duas casas decimais
	function arredonda($num,$dec=2)
    {
     $fl = floor($num);
     if($num==$fl)
     {
    	return $num;
     }
	  else
          {
			$decimais = $num-$fl;
			$decimais = substr($decimais,2);
			$dm = substr($decimais,0,$dec);
			$resto = substr($decimais,$dec,2);

			if($resto>=55)
            {
			 $dm++;
			}
			$dm = "0.".$dm;
			return number_format(($fl+$dm),2,",",".");
		   }
	}

    //Lista o Tipo de Empréstimo com a Identificação
    $sql = "select * from emprestimos where emprestimo_id = ".$_REQUEST['id'];
	$rs = mysql_query($sql) or die(mysql_error());
	$a = mysql_fetch_assoc($rs);

	$dtLib = split("/",$_REQUEST['liberacao']);
	$dtVenc = split("/",$_REQUEST['vencimento']);

	$parcela = $_REQUEST['parcelas'];
	$dtLib  = mktime(0,0,0,$dtLib[1],$dtLib[0],$dtLib[2]);
	$dtVenc = mktime(0,0,0,$dtVenc[1],$dtVenc[0],$dtVenc[2]);
	$dtUlt = mktime(0,0,0,date("m",$dtVenc)+$parcela,date("d",$dtVenc),date("Y",$dtVenc));
	$juros = $a['juros'];

	$valor = $_REQUEST['valor'];

	$fator = 0; //inicialização da variavel fator
	$venc = $dtVenc; // venc recebe primeira data de vencimento para adição
		
	$carencia = diasDiff($dtVenc,$dtLib); //calcula dias de carência
	$venc2 = $dtLib;
		
    //calcula valor parcela
    $juros1 = $juros / 100;
        
    $juros2 = $juros1 + 1;
        
    $fator = pow($juros2, -$_REQUEST['parcelas']);

    $fator = 1 - $fator;

    $fator = $juros1 / $fator;
        
    $valorparcela = $valor * $fator;
        
   // $valorparcela = $valor * (($juros / 100)/(1-(pow(1+$juros,-$_REQUEST['parcelas']))));
   //loop para somatória de fatores
  /*  for($n=1;$n<=$parcela;$n++){
			$dias = diasDiff($venc,$dtLib); //número de dias entre o pagamento da parcela e o vencimento
			$dias2 = diasDiff($venc,$venc2);
			$diasMes[$n] = round($dias2);
			$venc2 = $venc;



            //$f = price($juros,$dias); //fator mensal
			$fator += $f; //faz somatória de fatores
			$venc = mktime(0,0,0,date("m",$venc)+1,date("d",$venc),date("Y",$venc)); //muda venc para próximo dia 5
		} */

  //$valorparcela1 = $valor / $fator;
  //$valorParcela = $valorparcela1; //calcula valor da parcela
  //$valorAtualizado = $parcela*$valorParcela;

?>
<table width="100%">
   <tr>
       <td width="5"></td>
       <th width="133" align="right" class="td4"><div align="right">Tipo de Simulação: </div></th>
	   <td width="713" class="td3"><?=$a['descricao']?></td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap><div align="right">Data da Libera&ccedil;&atilde;o: </div></th>
	   <td width="713" class="td3"><?=$_REQUEST['liberacao']?></td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap><div align="right">Data da Vencimento: </div></th>
	   <td width="713" class="td3"><?=$_REQUEST['vencimento']?></td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" align="right" class="td4" nowrap><div align="right">Dias de Carência: </div></th>
	   <td width="713" class="td3"><?=numero($carencia,false)?>&nbsp;(Dias)</td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap><span class="nomesForm"><b>Parcelas:</b></span></th>
	   <td class="td3"><?=$_REQUEST['parcelas']." mês(es)";?></td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap><span class="nomesForm"><b>Taxa de Juros:</b></span></th>
	   <td class="td3"><?=numero($a['juros']);?>% ao mês</td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap class="nomesForm"><b>Valor do Empréstimo:</b></th>
       <td class="td3"><?=numero($_REQUEST['valor'])?></td>
   </tr>
   <tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap><span class="nomesForm"><b>Valor Parcela:</b></span></th>
	   <td class="td3"><?=numero($valorparcela)?></td>
   </tr>
</table>
<bR><br>
<table width="100%" cellpadding="0" cellspacing="2" >
   <tr>
       <td width="5"></td>
       <td colspan="6" align="right"><em>Valores Expresso em Reais</em></td>
   </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="2" >
   <tr bgcolor="#CECFCE">
      <th class="td2">Parcela</th>
      <th class="td2">Data</th>
      <th class="td2">Amortização</th>
      <th class="td2">Juros</th>
      <th class="td2">Valor Parcela</th>
      <th class="td2">Saldo Devedor</th>
   </tr>
<?
    $venc = $dtVenc;
	$saldo = $valor;
	$amortTotal = 0;
	$jurosTotal = 0;
	$valorTotal = 0;

	//Pega valor TOTAL
	$valorAtualizado1 = $valorparcela*$_REQUEST['parcelas'];
?>

   <tr align="center" bgcolor="f2f2f2">
       <td class="emp_cell" style="text-align:center"><?=0?></td>
	   <td class="emp_cell" style="text-align:center"></td>
	   <td class="emp_cell" style="text-align:right"></td>
	   <td class="emp_cell" style="text-align:right"></td>
	   <td class="emp_cell" style="text-align:right"></td>
	   <td class="emp_cell" style="text-align:right"><?=numero($valorAtualizado1,false)?></td>
   </tr>

<?
/*
        for($n=1;$n<=$_REQUEST['parcelas'];$n++){
          if($_REQUEST['parcelas']==1){
				//$amort = $valor;
				$jurosMensal = $valorAtualizado-$valor;

				$amort = $valorParcela - $jurosMensal;
			}else{
				$amort = $valorParcela - $jurosMensal;
				$jm = round((($juros / 100) + 1),8);
				$dm = round($diasMes[$n] / 30,8);
				$jurosMensal = $saldo * ((pow($jm,$dm))-1);
			}

            $valorAtualizado = $valorAtualizado - $valorParcela;

		    //if($saldo<0) $saldo = 0;
            $amortTotal += $amort;
			$jurosTotal += $jurosMensal;
*/
   $restante = $valor;
   for($n=1;$n<=$_REQUEST['parcelas'];$n++)
   {
      if($n==1)
      {
	   $jurosMensal = $restante * ($juros/100);
	   $amort = $valorparcela - $jurosMensal;
	   $valorAtualizado = $restante - $amort;
	  }
       else
           {
            $jurosMensal = $valorAtualizado * ($juros/100);
            $amort = $valorparcela - $jurosMensal;
            $valorAtualizado = $valorAtualizado - $amort;
           }
       $amortTotal += $amort;
       $jurosTotal += $jurosMensal;
?>
	<tr align="center" bgcolor="f2f2f2">
         <td class="emp_cell" style="text-align:center"><?=$n?></td>
		 <td class="emp_cell" style="text-align:center"><?=date("d/m/Y",$venc)?></td>
		 <td class="emp_cell" style="text-align:right"><?=numero($amort,false)?></td>
		 <td class="emp_cell" style="text-align:right"><?=numero($jurosMensal,false)?></td>
		 <td class="emp_cell" style="text-align:right"><?=numero($valorparcela,false)?></td>
		 <td class="emp_cell" style="text-align:right"><?=numero($valorAtualizado,false)?></td>
	</tr>
<?
			$venc = mktime(0,0,0,date("m",$venc)+1,date("d",$venc),date("Y",$venc));
   }
?>
</table>
<BR>
<table width="" cellspacing="0" align="right">
    <tr>
		<td width="120" colspan="2"  style="text-align:center" valign="top" class="td2"><b>Total&nbsp;</b> <?=numero($valorAtualizado1,false)?></td>
	    <!--	<td width="100" style="text-align:right" valign="top" class="formnome2"><?//=numero($amortTotal,false)?></td> !-->
		<!--	<td width="100" style="text-align:right" valign="top" class="formnome2"><?=$a['juros']."%"?></td> !-->
		<!--	<td width="100" style="text-align:right" valign="top" class="td1"><?//=numero($valorAtualizado,false)?></td>  !-->
		<!--	<td width="100" style="text-align:right" valign="top" class="formnome2">&nbsp;</td>  !-->
	</tr>
</table>
<BR>
<BR>
<table width="" cellspacing="0" align="center">
   <tr>
       <td align="center"><a href="javascript:window.print();"><img src="img/bt_imprimir.gif" border="0"></a>&nbsp;&nbsp;<a href="javascript:(history.back(-1));"><img src="img/bt_voltar.gif" border="0"></a></td>
   </tr>
</table>
<?
   }//fim acao == SIMULAR

    //Cria Formulário de Simulação
	if ($_REQUEST['id'] != "" && $acao == "Listar")
    {
     $sql = "select * from emprestimos where emprestimo_id = ".$_REQUEST['id'];
	 $rs = mysql_query($sql) or die(mysql_error());
	 $a = mysql_fetch_array($rs);
	 $data = date("d/m/Y");
?>
<form name="form1" method="post" action="?acao=Simular">
<table width="100%">
   <tr align="left">
      <td width="5"></td>
      <td style="text-transform:uppercase;" class="td1" align="center"><strong>SIMULAR <?=$a['descricao']?></strong></td>
   </tr>
</table>
<BR>
<table width="100%">
	<tr>
       <td width="5"></td>
       <th width="133" class="td4" align="right" nowrap align="right"><div align="right">Data da Libera&ccedil;&atilde;o: </div></th>
<? 
	   if ($a['flaperdataliber'] == "s") {
?>						
			<td width="713" class="td3"><input type="text" name="liberacao" id="liberacao" value="<?=$data?>" onkeypress="mascaradata(document.form1.liberacao)" maxlength="10"></td>
<?	   		
	   }else{
?>
			<td class="td3"><input type="hidden" name="liberacao" value="<?=$data?>"><? echo $data; ?></td></td>
<?	   
	   
	   }
?>	   
   </tr>
	<tr>
        <td width="5"></td>
        <td width="150" class="td4" align="right">Data Vencimento:<span style="font-weight:normal"><em>(ddmmaaaa)</em></span></td>
        <td class="td3">
<?
		  $carencia = $a['carencia'];
		  $dia = $a['dia_vencimento'];
		  $df = $a['desconto_folha'];
		  $dh = date("d");
		  if($dh>$dia)
          {
           $carencia++;
          }
		  if($dia==0)
          {
           $dia = date("d");
          }		 
          $venc = date("d/m/Y",mktime(0,0,0,date("m")+$carencia,$dia));
		  if($a['data_vencimento']=="1")
          {
?>
			<input type="text" name="vencimento" id="vencimento" value="<?=$venc?>" onkeypress="mascaradata(document.form1.vencimento)" maxlength="10">
<?
		  }
           else
           {
		  	echo $venc;
			echo"<input type='hidden' name='vencimento' value='$venc'>";
           }
?>
		 </td>
	</tr>
    <tr>
        <td width="5"></td>
        <td width="150" class="td4" align="right">Taxa de Juros:</td>
        <td class="td3"><?=$a['juros']?>%</td>
    </tr>
    <tr>
         <td width="5"></td>
         <td width="150" class="td4" align="right">Valor do Empréstimo:</td>
         <td class="td3">R$ <input type="text" name="valor" id="valor" onkeydown="formataValor('valor',50,event)" maxlength="14" size="10" onblur="numeros(this.id,true)" onKeyUp="numeros(this.id,true)"><br>
<?
		  $vm = "";
		  if($a['valor_minimo']!="0.00")
?>
			  valor mínimo de <font color='#cc0000'><strong>R$ <?=$a['valor_minimo']?></strong></font>
<?
		  if($a['valor_maximo']!="0.00"){
		  if($vm!="") echo " e ";
			 echo " valor máximo de <font color='#cc0000'><strong>R$ ".$a['valor_maximo']."</strong></font>";
		  }
?>
        </td>
    </tr>
    <tr>
        <td width="5"></td>
        <td width="150" class="td4" align="right">Parcelas:</td>
        <td class="td3"><select name="parcelas">
<?
          for($n=$a['parcelas_min'];$n<=$a['parcelas_max'];$n++)
          {
			echo "<option value='".$n."'>".$n."</option>";
		  }
?>
                        </select>
		</td>
     </tr>
</table>
<table width="100%" cellspacing="0" border="0">
     <tr>
         <td width="5"></td>
         <td><input type="submit" name="Submit" value="Simular o empr&eacute;stimo">&nbsp;&nbsp;<input type="button" value="Voltar" onclick="javascript:(history.back(-1))"></td>
	 </tr>
</table>
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
</form>

<br><br>

<div style="font-size:9px">
    <em><?=$a['obs']?><BR>
      &nbsp;* Este cálculo é meramente ilustrativo. Consulte seu gerente para obter o valor exato para seu empréstimo.
    </em>
</div>

<?
	}
    //Lista links dos tipos de Empréstimos
	if ($_REQUEST['id'] == ""){

		$sql = "select emprestimo_id,descricao from emprestimos where ativo = '1' order by descricao asc";
		$rs= mysql_query($sql) or die(mysql_error());
?>
<form name="form1" method="post" action="?acao=Formulario">
<table cellspacing="0" border="0">
<?
        $auxxx = 1;
        while($a = mysql_fetch_array($rs)){
?>
            <tr>
				<td width="5"></td>
				<td width="25" class="td6"><? echo $auxxx." - "; ?></td>
				<td class="td3">&nbsp;<a href="<?="?id=".$a['emprestimo_id']."&acao=Listar"?>"class="link"><?=$a['descricao']?></a></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
<?
       $auxxx++;
		}

?>
        </table>
        </form>

<?
	}

?>
