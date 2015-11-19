<?php
/* Trata as viriáveis desta página */
if(!empty($_POST['txtMes'])){$VtxtMes = $_POST['txtMes'];}else{$VtxtMes = date('m');}
if(!empty($_POST['txtDia'])){$VtxtDia = $_POST['txtDia'];}else{$VtxtDia = 01;}
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

<form action="extratocontacorrente.php" method="post">
  <table width="530" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
    <tr>
      <td width="30" rowspan="5">&nbsp;</td>
      <td height="16" valign="top"><strong>Extrato de Conta Corrente</strong></td>
    </tr>
    <tr>
      <td bgcolor="f7f4f4"><div align="left">Escolha o Per&iacute;odo do 
        Extrato </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td valign="middle">M&ecirc;s
        <select name="txtMes" class="Formulario">
            <option value="01"<?php if($VtxtMes=='01')echo(" selected=\"selected\"");?>>Janeiro</option>
            <option value="02"<?php if($VtxtMes=='02')echo(" selected=\"selected\"");?>>Fevereiro </option>
            <option value="03"<?php if($VtxtMes=='03')echo(" selected=\"selected\"");?>>Mar&ccedil;o</option>
            <option value="04"<?php if($VtxtMes=='04')echo(" selected=\"selected\"");?>>Abril</option>
            <option value="05"<?php if($VtxtMes=='05')echo(" selected=\"selected\"");?>>Maio</option>
            <option value="06"<?php if($VtxtMes=='06')echo(" selected=\"selected\"");?>>Junho</option>
            <option value="07"<?php if($VtxtMes=='07')echo(" selected=\"selected\"");?>>Julho</option>
            <option value="08"<?php if($VtxtMes=='08')echo(" selected=\"selected\"");?>>Agosto</option>
            <option value="09"<?php if($VtxtMes=='09')echo(" selected=\"selected\"");?>>Setembro</option>
            <option value="10"<?php if($VtxtMes=='10')echo(" selected=\"selected\"");?>>Outubro</option>
            <option value="11"<?php if($VtxtMes=='11')echo(" selected=\"selected\"");?>>Novembro</option>
            <option value="12"<?php if($VtxtMes=='12')echo(" selected=\"selected\"");?>>Dezembro</option>
        </select>
        a partir do dia
        <select name="txtDia">
		<?php
		/* Monta Select de 1 a 31 */
		for($i=1; $i<= 31; $i++){
			echo("<option value=\"".$i);
			if($i==$VtxtDia){echo("\" selected=\"selected");}
			echo("\">");
			echo($i);
			echo("</option>\n");
		}
		?>
        </select>
        &nbsp;
        <input name="formExtrato" type="submit" id="formExtrato" value="Exibir" />
        </td>
    </tr>
    <tr>
      <td valign="middle">&nbsp;</td>
    </tr>
  </table>
</form>
