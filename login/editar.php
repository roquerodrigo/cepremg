<?
include("restadmin.php");
?>
<?php
include_once "SQL.php";
$id = $_GET["id"];
$dados=mysql_fetch_array(mysql_query("select * from usuarios where id = $id"));
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
        width: 360px;
}
.FonTop{
	font-family: Verdana;
}
	</style>
</head>

<body><center>

<center><div id="resposta"></div></center>

<fieldset id="field"><legend><font size="2" face="verdana">Cadastro</font></legend>
<form name="formedicao" method="post" action="salva_edicao.php">
  <table width="362" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="91" class="text_form"><div align="left">Nome*&nbsp;</div></td>
      <td width="271">
        <div align="left">
		  <input name="txtId" type="hidden" id="txtId" size="40" value="<?PHP echo $id; ?>" >
          <input name="txtNome" type="text" id="txtNome" size="40" value="<?PHP echo $dados['nome']; ?>">
          </div></td></tr>
	    <tr>
      <td class="text_form"><div align="left">Institui&ccedil;&atilde;o*</div></td>
      <td>
        <div align="left">
          <input name="txtInst" type="text" id="txtInst" size="40"  value="<?PHP echo $dados['instituicao']; ?>">
          </div></td></tr>
	    <tr>
      <td class="text_form"><div align="left">Finalidade*&nbsp;</div></td>
      <td>
        <div align="left">
           <input name="txtFinal" type="text" id="txtFinal" size="40"  value="<?PHP echo $dados['finalidade']; ?>">
          </div></td></tr>
		  	    <tr>
      <td class="text_form"><div align="left">Login&nbsp;*</div></td>
      <td>
        <div align="left">
          <input name="txtLogin" type="text" id="txtLogin" size="20"  value="<?PHP echo $dados['login']; ?>">
          </div></td></tr>
		  		  	    <tr>
      <td class="text_form"><div align="left">Senha*&nbsp;</div></td>
      <td>
        <div align="left">
          <input name="txtSenha" type="password" id="txtSenha" size="20"  value="<?PHP echo $dados['senha']; ?>">
          </div></td></tr>

  </table>
  <br><fieldset><legend><font size="2" face="verdana">Contato</font></legend><table width="320" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50" class="text_form">E-mail*</td>
    <td><div align="center">
      <input name="txtEmail" type="text" id="txtEmail" size="40" disabled="disabled" value="<?PHP echo $dados['email']; ?>">
    </div></td>
  </tr>
</table>
</fieldset><br>
<fieldset><legend><font size="2" face="verdana">A&ccedil;&atilde;o</font></legend><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;" /></fieldset>
</form></fieldset>
<blockquote>
  <div align="center"><a href="index.php"></a></div>
</blockquote>
</center>
</body>
</html> 