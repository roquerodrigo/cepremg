<?
//Mude aqui para onde o usuário vai ser redirecionado caso o Login for bem sucedido
$pagina_restrita = "area_restrita.php";

if(isset($_GET['msg']) && $_GET['msg'] != "") {
	require("SQL.php");
	$mensagem = $_GET['msg'];
} else {
	$mensagem = base64_encode("Acesso para &Aacute;rea Restrita");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['login']) && isset($_POST['senha'])){
		require("SQL.php");                
		$login = $_POST['login'];
                $senha = $_POST['senha'];
                $query = mysql_query("SELECT * FROM usuarios WHERE login='$login' AND senha='$senha'") or die(mysql_error());
                $rTestar = mysql_num_rows($query);
		$row = mysql_fetch_assoc($query);
               
                if($rTestar > '0'){
			if( $row['status']=='9'){
			session_start();
                        session_register('email');
                        session_register('login');
                        session_register('senha');
			session_register('status');
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['login'] = $row['login'];
                        $_SESSION['senha'] = $row['senha'];
			$_SESSION['status'] = $row['status'];
                        header("location: listar.php");
			exit;
			}elseif ( $row['status']=='1'){
                        session_start();
                        session_register('email');
                        session_register('login');
                        session_register('senha');
			session_register('status');
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['login'] = $row['login'];
                        $_SESSION['senha'] = $row['senha'];
			$_SESSION['status'] = $row['status'];
                        header("location:../relatorio.php");
			exit;}
			else{
			echo "<script>alert('Sua solicitação para acesso aos dados se encontra pendente, aguarde.');</script>";
			echo("<script language='javascript'>location.href='index.php'</script>");
			exit;
			}
                } else {
               
                        $mensagem = base64_encode("<font color=\"red\"><b>Login ou senha Invalida</b></font>");
               
                }
               
        }

}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
	input	{background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	textarea {background-color: #FFFFFF; font: 14px Verdana; border-style: groove}
	select {background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	.texto      	{font: 13px Verdana; text-decoration: none; color: #000000}
	.form_botao 	{background-color: #CCCCCC; font: 12px Verdana; border-style: solid}
	.text_form {font-family: Verdana; font-size: 14px; font-weight: bold; }
.table{
        margin: 0px;
        padding: 2px;
}
#field {
        margin: 0px;
        padding: 2px;
        width: 360px;
}
.FonTop{
	font-family: Verdana;
}
	</style>
<style type="text/css">
body { font-family:"Helvetica Neue", Helvetica, Verdana, sans-serif; font-size:87.5%; color:#635a4e; height:60%; width:90%;}
<!--
.text_form {font-family: Verdana; font-size: 10px; font-weight: bold; }
.table{
        margin: 0px;
        padding: 2px;
}
#field {
        margin: 0px;
        padding: 2px;
        width: 260px;
}
-->
</style>
</head>

<body>
<center>
<form name="form1" method="post" action="">
<div align="center">
<fieldset id="field">
<legend><? echo "<font face=\"Verdana\" size=\"3\"><b>" . base64_decode($mensagem) . "</b></font>"; ?></legend>
  <table width="345" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td width="200" scope="col"><span class="text_form"><font face size="2">Login:</font></span></td>
      <td width="345" scope="col"><input name="login" type="text" id="login"></td>
    </tr>
    <tr>
      <td width="200" scope="row"><span class="text_form"><font face size="2">Senha:</font></span></td>
      <td width="345"><input name="senha" type="password" id="senha"></td>
    </tr>
    <tr>
      <td width="200" scope="row"></td>
      <td width="345"><input type="submit" name="Submit" value="Logar">
      <input type="reset" name="Submit2" value="Limpar"></td>
    </tr>
  </table><br><br>
<a href="cadastrar.php">Cadastrar-se</a>
  </fieldset>
  </div>
</form></center>
</body>
</html>
