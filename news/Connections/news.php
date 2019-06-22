<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_news = "localhost";
$database_news = "news";
$username_news = "root";
$password_news = "root";
$news = mysql_pconnect($hostname_news, $username_news, $password_news) or trigger_error(mysql_error(),E_USER_ERROR); 
?>