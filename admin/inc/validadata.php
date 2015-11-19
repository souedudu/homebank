<script>

var reDate5 = /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/\d{4}$/;

function doDate(pStr, pFmt)
{
	eval("reDate = reDate" + pFmt);
	if (reDate.test(pStr)) {
		alert(pStr + " é uma data válida.");
	} else if (pStr != null && pStr != "") {
		alert(pStr + " NÃO é uma data válida.");
	}
} // doDate


</script>


<form class="boxLeft" id="frmDate" action="#"
 onsubmit="doDate(this.txtDate.value, this.selDate.value); return false;">
<div>
<label for="txtDate">Data:</label>
<input type="text" size="10" maxlength="10" id="txtDate" name="txtDate" />
<input type="hidden" name="selDate" value="5">
<input type="submit" value="Validar" />
</div>
</form>




