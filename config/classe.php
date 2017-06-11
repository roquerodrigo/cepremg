<?php
/*
@utor-Leonardo Musashi Miyamoto

th3ultimat3@hotmail.com

http://harukanata.no-ip.org
*/

class Banco{
	function conexao($nome_banco){
		
		$localhost = "localhost";
		$usuario   = "root";
		$senha     = "";

		
		$banco = $nome_banco;
		
		mysql_connect($localhost,$usuario,$senha);
		mysql_select_db($banco);
	}

}

$banco = new Banco();

?>