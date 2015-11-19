<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conecta = "localhost";
$database_conecta = "sementes";
$username_conecta = "sementes";
$password_conecta = "sementes";
$conecta = mysql_connect($hostname_conecta, $username_conecta, $password_conecta) or trigger_error(mysql_error(),E_USER_ERROR); 
?>