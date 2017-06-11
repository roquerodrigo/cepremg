<?
include("restadmin.php");
?>
<?
include_once "SQL.php";
$consulta=mysql_query("SELECT * FROM usuarios order by nome"); 
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="ISO-8859-1">

<style type="text/css">
<!--
img{border:none}
a img{border:none}
a:hover img{border:none;}
img{ border:0px; !IMPORTANT}
a:link {
	text-decoration: none;
	color: #000080;
}
a:visited {
	text-decoration: none;
	color: #000080;
}
a:hover {
	text-decoration: none;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000080;
}
.style3 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }

.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
-->


body { font-family:"Helvetica Neue", Helvetica, Verdana, sans-serif; font-size:87.5%; color:#635a4e; height:100%; width:90%;}

</style>
  </head>
  <body>
<center><h2>Administrador</h2></center><br><br>
<center><h3>Lista de Usuários Cadastrados</h3><br><br></center>
<table width="600" border="0" cellpadding="2" cellspacing="2"  bgcolor="#FFFFFF">
  <tr>
    <td width="22%" bgcolor="#93A8FF"><div align="left" class="style3">Nome</div></td>
	<td width="22%" bgcolor="#93A8FF"><div align="left" class="style3">Instituicao</div></td>
	<td width="22%" bgcolor="#93A8FF"><div align="left" class="style3">Finalidade</div></td>	
    <td width="17%" bgcolor="#93A8FF"><div align="left" class="style3">Status</div></td>
    <td width="17%" align="center" valign="top" bgcolor="#93A8FF"><div align="center" class="style3">A&ccedil;&otilde;es</div></td>
  </tr>
  <?php
  while($l = mysql_fetch_array($consulta)) {
  $id = $l["id"];
  $inst= $l["instituicao"];
  $nome = $l["nome"];
  $final= $l["finalidade"];
  $status = $l["status"];
  
  if (trim($status == "1")) {
    $msgstatus = "<img src=\"check.jpg\" />";
} else if (trim($status == "0")){
    $msgstatus = "<img src=\"checkn.jpg\" />";	
} 
else {
    $msgstatus = "<img src=\"icone_editar.gif\"";
}
  echo "
  		<tr>
			<td bgcolor=\"#CCCCCC\" class=\"style4\"> $nome</td>
			<td bgcolor=\"#CCCCCC\" class=\"style4\"> $inst</td>
			<td bgcolor=\"#CCCCCC\" class=\"style4\"> $final</td>
			<td bgcolor=\"#CCCCCC\" align=\"center\" class=\"style4\"><a href=\"editarstatus.php?id=$id\">$msgstatus</a></td>
			<td bgcolor=\"#CCCCCC\" class=\"style4\"><div align=center valign=top><a href=\"editar.php?id=$id\"><img src=\"icone_editar.gif\" alt=\"Editar\"/></a> <a href=\"visualizar.php?id=$id\"><img src=\"ico_lupa.gif\" alt=\"Visualizar\" /></a>&nbsp;<a href=\"excluir.php?id=$id\"><img src=\"icone_excluir.gif\" alt=\"Excluir\" /></a></div></td>
		</tr>\n";
}
@mysql_close();
?>
</table>
</center>
<div align="center"><br><br>
<a href="index.php">Sair</a>
</div>
<center>
</center>
</body>
</html>
