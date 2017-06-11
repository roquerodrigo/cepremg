<?php
$servidor = "prometeu.unifei.edu.br";

$user = "cepremg_net";

$senha = "#456123#";

$db = "cepremg";

$conexao = mysql_connect($servidor,$user,$senha) or die (mysql_error());

$banco = mysql_select_db($db, $conexao) or die(mysql_error());

?>
