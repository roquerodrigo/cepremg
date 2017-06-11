<?
//Coloque aqui uma mensagem caso a pessoa tente entrar em uma página protegida sem autenticação
$mensagem = base64_encode("Faça o Login primeiro"); 


session_start();
if(isset($_SESSION['login']) && isset($_SESSION['senha']) && ($_SESSION['status'] == 9)) {
        $login = $_SESSION['login'];
        $senha = $_SESSION['senha'];
		$status = $_SESSION['status'];
        require("SQL.php");
        $query = mysql_query("SELECT * FROM usuarios WHERE login='$login' AND senha='$senha'") or die(mysql_error());
        $rTestar = mysql_num_rows($query);
}

if(isset($rTestar) && $rTestar > '0'){
        $row = mysql_fetch_assoc($query);
} else {
	echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php?msg=$mensagem\">";
	exit;
}
?>