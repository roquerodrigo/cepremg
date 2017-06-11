<?
include("restadmin.php");
?>
<?php
include_once "SQL.php";
$id = $_POST["txtId"];
$nome = $_POST["txtNome"];
$inst = $_POST["txtInst"];
$finalidade= $_POST["txtFinal"];
$login = $_POST["txtLogin"];
$senha = $_POST["txtSenha"];
$re=mysql_query("UPDATE usuarios SET nome=('$nome'), instituicao=('$inst'), finalidade=('$finalidade'), login=('$login'), senha=('$senha') where id=('$id')");
if ($re==1) {
echo"<script>alert('Usuario Alterado com sucesso...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
else
{
echo"<script>alert('Erro ao alterar usuario...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
?>
