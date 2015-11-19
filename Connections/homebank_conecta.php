<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_homebank_conecta = "localhost";
$database_homebank_conecta = "homebank";
$username_homebank_conecta = "root";
$password_homebank_conecta = "";
$homebank_conecta = mysql_pconnect(conexao_host, conexao_user, conexao_pass) or trigger_error(mysql_error(),E_USER_ERROR); 
?>