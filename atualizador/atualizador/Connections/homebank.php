<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_homebank = "localhost";
$database_homebank = "homebank";
$username_homebank = "root";
$password_homebank = "asdf";
$homebank = mysql_pconnect($hostname_homebank, $username_homebank, $password_homebank) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
