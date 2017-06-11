<?php
include_once "SQL.php";
$id = $_GET["id"];
$dados=mysql_fetch_array(mysql_query("select * from usuarios where id = $id"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style></head>
<center>
<body>
<table width="646" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="122"><div align="left"><strong>Nome:</strong></div></td>
    <td width="293"><div align="left"><?PHP echo $dados['nome']; ?>&nbsp;</div></td>
    <td width="68"><div align="left"></div></td>
    <td width="153"><div align="left"></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Institui&ccedil;&atilde;o: </strong></div></td>
    <td><div align="left"><?PHP echo $dados['instituicao']; ?></div></td>
    <td><div align="left"></div></td>
    <td><div align="left"></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Finalidade:</strong></div></td>
    <td><div align="left"><?PHP echo $dados['finalidade']; ?></div></td>
    <td><div align="left"></div></td>
    <td><div align="left"></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Login:</strong></div></td>
    <td><div align="left"><?PHP echo $dados['login']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><strong>E-Mail: </strong></div></td>
    <td><div align="left"><?PHP echo $dados['email']; ?></div></td>
    <td><div align="left"></div></td>
    <td><div align="left"></div></td>
  </tr>
</table>
<div align="center"></div>
</body>
</center>
</html>
