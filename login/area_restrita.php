<?
include("restringir.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
echo "Login: " . $_SESSION['login'] . "<br />";
echo "Senha: " . $_SESSION['senha'] . "<br />";
echo "E-mail: " . $_SESSION['email'] . "<br />";
echo "<a href=\"logout.php\">Sair</a>";
?>
</body>
</html>