<HTML>
<HEAD>
 <TITLE>Documento PHP</TITLE>
</HEAD>
<script>
        var resposta = confirm("Você realmente deseja Atualizar as Tabelas?")
        alert ("Você clicou: " + resposta)
        if (resposta == "false")
        {
           javascript:(history.back(-1));
        }
</script>
<BODY>
<?
  $dataaux = date("H:i:s", time());
  $Hr = substr($dataaux, 0, 2);
  echo "dataaux: ".$dataaux;
  echo "<BR>Hr: ".$Hr;
?>
</BODY>
</HTML>
