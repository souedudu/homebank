<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_crediembrapa = "localhost";
$database_crediembrapa = "crediembrapa";
$username_crediembrapa = "root";
$password_crediembrapa = "";
$crediembrapa = mysql_pconnect($hostname_crediembrapa, $username_crediembrapa, $password_crediembrapa) or trigger_error(mysql_error(),E_USER_ERROR); 
?>