<?
include("restadmin.php");
?>
<?php
include_once "SQL.php";
$id = $_GET["id"];
$re=mysql_query("DELETE from usuarios where id = $id");
if ($re==1) {
echo"<script>alert('Usuario Excluido Com Sucesso...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
else
{
echo"<script>alert('Erro ao Excluir Usuário...');</script>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=listar.php'>";
}
?>
