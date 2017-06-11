<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
#                 #
# // Cabeçalho -> caracter usado é utf-8       #
#                 #
# // Cabeçalho -> Não armazenar em cache a página     #
#                 #
# // Uso a função utf8_encode para transformar os caracteres  #
# // especiais (acentos, ç, etc) em caracteres utf-8.         #
#                 #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # 

// Includes
include_once "SQL.php";

header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Define variáveis
$msg = null;

$Email = "<html><head></head><body><h2>Bem vindo ao Portal do Centro de Estudos e Previsão de Tempo e Clima de MG (CEPreMG)</h2>
<br>Sua solicitação para acesso aos relatórios de dados diretamente de nossa base foi enviada.
<br><br>Aguarde, você receberá um email de notificação quando seu acesso for aprovado!
<br><br>Obrigado.
<br><br>Att.<br>CEPreMG</body></html>";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: <cepremg@unifei.edu.br>\n";

$varNome  = isset($_POST["txtNome"]) ? $_POST["txtNome"] : "";
$varInst = isset($_POST["txtInst"]) ? $_POST["txtInst"] : "";   
$varFinal = isset($_POST["txtFinal"]) ? $_POST["txtFinal"] : "";   
$varLogin  = isset($_POST["txtLogin"]) ? $_POST["txtLogin"] : "";
$varSenha  = isset($_POST["txtSenha"]) ? $_POST["txtSenha"] : "";
$varRepete = isset($_POST["txtRepetesenha"]) ? $_POST["txtRepetesenha"] : "";
$varEmail  = isset($_POST["txtEmail"]) ? $_POST["txtEmail"] : "";
$varStatus = 2;

if (trim($varNome == "")) {
    $msg = "O campo Nome deve ser preechido ! <br>";
} else if (trim($varInst == "")) {
    $msg = "O campo Instituicao deve ser preechido ! <br>";
	} else if (trim($varFinal == "")) {
    $msg = "O campo Finalidade deve ser preechido ! <br>";
	} else if (trim($varLogin == "")) {
    $msg = "O campo Login deve ser preechido ! <br>";
	} else if (trim($varSenha == "")) {
    $msg = "O campo Senha deve ser preechido ! <br>";
	} else if (trim($varRepete == "")) {
    $msg = "O campo Repetir Senha deve ser preechido ! <br>";
		} else if (trim($varEmail == "")) {
    $msg = "O campo Email deve ser preechido ! <br>";
			} else if ($varSenha != $varRepete) {
    $msg = "As Senhas Digitadas Não Conferem ! <br>";

} else {

    // Cadastra cliente

	$checar_existe=mysql_query("SELECT * FROM usuarios WHERE login='$varLogin'");

	$checar_existe2=mysql_num_rows($checar_existe);

    if($checar_existe2!=0)

	{

    echo"Usuário indisponível, informe outro nome de usuário no campo Login.";

	exit;

    }

	else

	{

    $query  = ("INSERT INTO usuarios(nome, instituicao, finalidade, login, senha, email, status) VALUES('$varNome', '$varInst', '$varFinal', '$varLogin', '$varSenha', '$varEmail', '$varStatus')");

    $result = mysql_query($query);
	  
if($result) {

    $msg = 1;

    mail("$varEmail", "Cadastro Portal CEPreMG Unifei", "$Email", "$headers"); 

   echo $msg;
   exit;
   

    } else {

 $msg = "Erro Ao Se Cadastrar !<br>".mysql_error();

	}
    }

    

}

if(isset($msg)) {

    echo utf8_encode($msg);

}

?>

