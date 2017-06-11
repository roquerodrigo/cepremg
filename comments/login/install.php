<?
require("SQL.php");

mysql_query("
CREATE TABLE `usuarios` (
  `id` int(6) NOT NULL auto_increment,
  `nome` varchar(200) NOT NULL default '',
  `razao` varchar(300) NOT NULL default '',
  `cnpj` varchar(20) NOT NULL default '',
  `cpf` varchar(11) NOT NULL default '',
  `endereco` varchar(300) NOT NULL default '',
  `numero` varchar(5) NOT NULL default '',
  `bairro` varchar(100) NOT NULL default '',
  `cep` varchar(8) NOT NULL default '',
  `complemento` varchar(200) NOT NULL default '',
  `telefone` varchar(15) NOT NULL default '',
  `celular` varchar(15) NOT NULL default '',
  `cidade` varchar(50) NOT NULL default '',
  `estado` varchar(50) NOT NULL default '',
  `login` varchar(255) NOT NULL default '',
  `senha` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
        
") or die(mysql_error());

echo "Tabela usuarios Instalada com sucesso";

$varNome  = "Administrador";
$varRazao = "Administrador";   
$varCnpj = "0000000000";    
$varCpf = "00000000000";   
$varEndereco  = "Administrador";;
$varNumero = "000";   
$varBairro  = "Administrador";;
$varCep = "0000000";
$varComplemento = "Administrador";   
$varTelefone  = "0";
$varCelular  = "0";
$varCidade = "Administrador";;
$varEstado  = "Administrador";;
$varLogin  = "admin";
$varSenha  = "admin";
$varEmail  = "admin@admin.com.br";
$varStatus = 9;

$query  = ("INSERT INTO usuarios(nome, razao, cnpj, cpf, endereco, numero, bairro, cep, complemento, telefone, celular, cidade, estado, login, senha, email, status) VALUES('$varNome', '$varRazao', '$varCnpj', '$varCpf', '$varEndereco', '$varNumero', '$varBairro', '$varCep', '$varComplemento', '$varTelefone', '$varCelular',  '$varCidade', '$varEstado', '$varLogin', '$varSenha', '$varEmail', '$varStatus')");
$result = mysql_query($query);
   if($result) {
     echo "Usuario Administrador Cadastrado Com Sucesso";
    } else {
	 echo "Erro Ao Cadastrar Usuario Administrador";
	}
?>