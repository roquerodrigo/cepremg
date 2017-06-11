<?php

$hostname_SQL = "prometeu.unifei.edu.br"; 
$database_SQL = "cepremg";
$username_SQL = "cepremg_net"; 
$password_SQL = "#456123#";

$SQL = mysql_pconnect($hostname_SQL, $username_SQL, $password_SQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_SQL, $SQL);

?>
