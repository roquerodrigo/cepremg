<?
include("restadmin.php");
?>
<?php
include_once "SQL.php";
$id = $_GET["id"];
$dados=mysql_fetch_array(mysql_query("select * from usuarios where id = $id"));
$status = $dados['status'];
  if (trim($status == "1")) {
    $msgstatus = "Aprovado";
} else if (trim($status == "0")){
    $msgstatus = "Rejeitado";	
} 
else {
    $msgstatus = "Pendente";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alteração de senha</title>
<style>
	input	{background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	textarea {background-color: #FFFFFF; font: 14px Verdana; border-style: groove}
	select {background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	.texto      	{font: 13px Verdana; text-decoration: none; color: #000000}
	.form_botao 	{background-color: #CCCCCC; font: 12px Verdana; border-style: solid}
	.text_form {font-family: Verdana; font-size: 10px; font-weight: bold; }
.table{
        margin: 0px;
        padding: 2px;
}
#field {
        margin: 0px;
        padding: 2px;
        width: 500px;
}
.FonTop{
	font-family: Verdana;
}
	</style>
</head>

<body><center>

<center><div id="resposta"></div></center>

<fieldset id="field">
<legend><font size="2" face="verdana">Status</font></legend>
<form name="formstatus" method="post" action="salva_status.php">
  <table width="396" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="92" class="text_form"><div align="left">Nome*&nbsp;</div></td>
      <td width="304">
        <div align="left">
		  <input name="txtId" type="hidden" id="txtId" size="40" value="<?PHP echo $id; ?>" >
		  		  <input name="txtEmail" type="hidden" id="txtEmail" size="40" value="<?PHP echo $dados['email']; ?>" >
          <input name="txtNome" type="text" id="txtNome" size="40" value="<?PHP echo $dados['nome']; ?>">
          </div></td></tr>
	    <tr>
      <td class="text_form"><div align="left">Status*&nbsp;</div></td>
      <td>
        <div align="left">
        <?PHP echo $msgstatus; ?>        </div></td></tr>
	    <tr>
	      <td class="text_form"><div align="left">Alterar Para* </div></td>
	      <td><div align="left">
	        <select name="txtStatus">
	          <option value="2">Pendente</option>
	          <option value="1">Aprovado</option>
	          <option value="0">Rejeitado</option>
            </select>
          </div></td>
      </tr>
	    <tr>
	      <td class="text_form">Mensagem</td>
	      <td><textarea name="txtMensagem" cols="40" rows="5"></textarea></td>
      </tr>
  </table>
<br>
<fieldset><legend><font size="2" face="verdana">A&ccedil;&atilde;o</font></legend><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;" /></fieldset>
</form></fieldset>
<blockquote>
  <div align="center"><a href="index.php"></a></div>
</blockquote>
</center>
</body>
</html> 