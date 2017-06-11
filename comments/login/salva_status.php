<?
include("restadmin.php");
?>
<?php
include_once "SQL.php";
$id = $_POST["txtId"];
$status= $_POST["txtStatus"];
$mensagem = $_POST["txtMensagem"];
$email = $_POST["txtEmail"];
$re=mysql_query("UPDATE usuarios SET status=('$status') where id=('$id')");
if ($re==1) {
mail("$email", "Acesso ao Portal CEPreMG", "$mensagem", "From: <cepremg@unifei.edu.br>\n");
echo"<script>alert('Status Alterado com Sucesso...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
else
{
echo"<script>alert('Erro ao Alterar Status...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
?>
