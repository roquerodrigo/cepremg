<html>
<head>

<meta charset="ISO-8859-1">
    <title> </title>

<script type="text/javascript" src="js.js" charset="ISO-8859-1"></script>
<script>

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function telefone(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}
function celular(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

</script>
</head>

<style>
	input	{background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	textarea {background-color: #FFFFFF; font: 14px Verdana; border-style: groove}
	select {background-color: #FFFFFF; font: 12px Verdana; border-style: groove}
	.texto      	{font: 13px Verdana; text-decoration: none; color: #000000}
	.form_botao 	{background-color: #CCCCCC; font: 12px Verdana; border-style: solid}
	.text_form {font-family: Verdana; font-size: 14px; font-weight: bold; }
.table{
        margin: 0px;
        padding: 2px;
}

body { font-family:"Helvetica Neue", Helvetica, Verdana, sans-serif; font-size:67.5%; color:#635a4e; height:100%; width:100%;}


#resposta{
color: #FF0000;

}
#field {
        margin: 0px;
        padding: 2px;
        width: 460px;
}
.FonTop{
	font-family: Verdana;
}
	</style>

<body><center>

<center><div id="resposta"></div></center>

<fieldset id="field"><legend><font size="3" face="verdana">Cadastro</font></legend>
<form name="frmCadastro" method="post">
  <table width="462" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="191" class="text_form"><div align="left">Nome*&nbsp;</div></td>
      <td width="371">
        <div align="left">
          <input name="txtNome" type="text" id="txtNome" size="40">
          </div></td></tr>
	    <tr>
      <td class="text_form"><div align="left">Institui&ccedil;&atilde;o*</div></td>
      <td>
        <div align="left">
          <input name="txtInst" type="text" id="txtInst" size="40">
          </div></td></tr>
	   <tr>
      <td class="text_form"><div align="left">Finalidade*&nbsp;</div></td>
      <td>
        <div align="left">
          <input name="txtFinal" type="text" id="txtFinal" size="40">
          </div></td></tr>
    <tr>
      <td class="text_form"><div align="left">Login&nbsp;*</div></td>
      <td>
        <div align="left">
          <input name="txtLogin" type="text" id="txtLogin" size="20">
          </div></td></tr>
    <tr>
      <td class="text_form"><div align="left">Senha*&nbsp;</div></td>
      <td>
        <div align="left">
          <input name="txtSenha" type="password" id="txtSenha" size="20">
          </div></td></tr>
		      <tr>
      <td class="text_form"><div align="left">Repetir Senha*&nbsp;</div></td>
      <td>
        <div align="left">
          <input name="txtRepetesenha" type="password" id="txtRepetesenha" size="20">
          </div></td></tr>
  </table>
<br><fieldset><legend><font size="3" face="verdana">Contato</font></legend><table width="350" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="190" class="text_form">E-mail*</td>
    <td><div align="center">
      <input name="txtEmail" type="text" id="txtEmail" size="40">
    </div></td>
  </tr>
</table>
</fieldset>
  <br><fieldset><legend><font size="3" face="verdana">Dados</font></legend><table width="320" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="350"><font size="3">O presente Portal do Centro de Estudos e Previs�o de Tempo e Clima de Minas Gerais (CEPreMG) � automaticamente atualizado 
com dados de uma esta��o meteorol�gica amadora. � um servi�o p�blico e sem fins lucrativos. Por estas raz�es, n�o se assume qualquer responsabilidade sobre 
as decis�es que se possam basear nos dados gerados pela esta��o, e apresentados neste portal.</font></td>

  </tr>
</table>
</fieldset><br>
<fieldset><legend><font size="3" face="verdana">A&ccedil;&atilde;o</font></legend> <input name="button" type="button" onClick="__cadastraCliente(this.form);" value="Cadastrar"><input name="Limpar" type="reset" value="Limpar"></fieldset>
</form></fieldset>
<blockquote>
  <div align="center"><a href="index.php"></a></div>
</blockquote>
</center>
</body>
</html>