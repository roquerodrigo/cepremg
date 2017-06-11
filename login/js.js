// Define variável global
var xmlhttp;

function __cadastraCliente(varForm) {

// Define variáveis
var varNome;  
var varInst;  
var varFinal;  
var varLogin; 
var varSenha; 
var varRepete; 
var varEmail;  


// Atribui valores as variáveis
varNome  = escape(varForm.txtNome.value);
varInst = escape(varForm.txtInst.value); 
varFinal = escape(varForm.txtFinal.value); 
varLogin = escape(varForm.txtLogin.value);
varSenha = escape(varForm.txtSenha.value);
varRepete = escape(varForm.txtRepetesenha.value);
varEmail  = escape(varForm.txtEmail.value);

    // Instancia o objeto, dependendo do navagador
    if (window.XMLHttpRequest) {
 xmlhttp = new XMLHttpRequest();  
    } else if (window.ActiveXObject) {
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  
    } else {
 alert("Seu navegador n&atilde;o suporta XMLHttpRequest.");
 return;
    }

   xmlhttp.open("POST", "cadastro.php", true);    

   xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   xmlhttp.setRequestHeader("Pragma", "no-cache");
   
    xmlhttp.onreadystatechange = processReqChange;

   xmlhttp.send("txtNome=" + varNome + "&txtInst=" + varInst + "&txtFinal=" + varFinal + "&txtLogin=" + varLogin + "&txtSenha=" + varSenha + "&txtRepetesenha=" + varRepete + "&txtEmail=" + varEmail );
}



function processReqChange() {



    document.getElementById('resposta').innerHTML = "<img src='carregando.gif' />";

   if (xmlhttp.readyState == 4) {    

 if (xmlhttp.status == 200) {

     if(xmlhttp.responseText == 1) {

      //document.getElementById("resposta").innerHTML = "Cadastro Realizado Com Sucesso!";

      document.forms[0].reset();
      alert("Cadastro realizado com sucesso! Sua solicitação para acesso a página foi enviada ao administrador, você receberá um e-mail quando autorizado, obrigado.");

   window.location.href = "index.php";    // Redireciona para uma pagina....

     } else

   document.getElementById("resposta").innerHTML = xmlhttp.responseText;

     

       } else {

           alert("Problemas ao carregar o arquivo.");

       }

   }



}
