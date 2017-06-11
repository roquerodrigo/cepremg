<?
$requi = $_SERVER["HTTP_REFERER"];
$requi= strtolower("/$requi/"); //
$server = $_SERVER['SERVER_NAME'];
$server= strtolower("/$server/");
if(preg_match($server, $requi) == 0){
 header("Location: http://cepremg-unifei.webege.com/");
 die();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="ISO-8859-1">
<title></title>
<style>

body { font-family:"Helvetica Neue", Helvetica, Verdana, sans-serif; font-size:87.5%; color:#635a4e; height:100%; width:90%;}

</style>
<script type="text/javascript">
			function Formatadata(Campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(Campo.value);
				vr = vr.replace("/", "");
				vr = vr.replace("/", "");
				vr = vr.replace("/", "");
				tam = vr.length + 1;
				if (tecla != 8 && tecla != 8)
				{
					if (tam > 0 && tam < 2)
						Campo.value = vr.substr(0, 2) ;
					if (tam > 2 && tam < 4)
						Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
					if (tam > 4 && tam < 7)
						Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
				}
			}
		</script>

<script language="JavaScript">

//VALIDAÇÃO DA DATA 

function VerificaData(digData) 
{
        var bissexto = 0;
        var data = digData; 
        var tam = data.length;
        if (tam == 10) 
        {
                var dia = data.substr(0,2)
                var mes = data.substr(3,2)
                var ano = data.substr(6,4)
                if ((ano > 1900)||(ano < 2100))
                {
                        switch (mes) 
                        {
                                case '01':
                                case '03':
                                case '05':
                                case '07':
                                case '08':
                                case '10':
                                case '12':
                                        if  (dia <= 31) 
                                        {
                                                return true;
                                        }
                                        break
                                
                                case '04':              
                                case '06':
                                case '09':
                                case '11':
                                        if  (dia <= 30) 
                                        {
                                                return true;
                                        }
                                        break
                                case '02':
                                        /* Validando ano Bissexto / fevereiro / dia */ 
                                        if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) 
                                        { 
                                                bissexto = 1; 
                                        } 
                                        if ((bissexto == 1) && (dia <= 29)) 
                                        { 
                                                return true;                             
                                        } 
                                        if ((bissexto != 1) && (dia <= 28)) 
                                        { 
                                                return true; 
                                        }                       
                                        break                                           
                        }
                }
        }       
        alert("A Data "+data+" é inválida!");
        return false;
}
</script>

<script>
// VERIFICA SE DATA FINAL É MAIOR QUE INICIAL
function verificaDatas(dtInicial, dtFinal){
   
    var dtini = dtInicial;
    var dtfim = dtFinal;
   
    if ((dtini == '') && (dtfim == '')) {
        alert('Complete os Campos.');
        campos.de.focus();
        return false;
    }
   
    datInicio = new Date(dtini.substring(6,10),
                         dtini.substring(3,5),
                         dtini.substring(0,2));
    datInicio.setMonth(datInicio.getMonth() - 1);
   
   
    datFim = new Date(dtfim.substring(6,10),
                      dtfim.substring(3,5),
                      dtfim.substring(0,2));
                     
    datFim.setMonth(datFim.getMonth() - 1);

    if(datInicio <= datFim){
        return true;
    } else {
        alert('ATENÇÃO: Data Inicial é maior que Data Final');
        campos.ate.focus();
        return false;
    }   
}
</script>

</head>

<body>
<center>
<h1>Banco de Dados</h1>
<br><br>
<p>Selecione os dados de interesse para geração do relatório<br><br>
obs.: Dados disponíveis a partir de 01/09/2012 a cada 10 minutos.<br>
Os dados não consideram o horário de verão.


<br><br />
<form name= "campos" target="_blank" action="gerarelatorio.php" method="POST" onSubmit="return verificaDatas(campos.de.value, campos.ate.value);" >
<table border="0" width="600px">
<tr><td align="center" colspan="2">
De*:<input name="de" id="data" type="text" maxlength="10" onkeyup="javascript:Formatadata(this,event)"  onBlur="VerificaData(this.value);"/> 
</td></tr><tr><td align="center" colspan="2">
Até*:<input name="ate" id="data2" type="text"  maxlength="10" onkeyup="javascript:Formatadata(this,event)" onBlur="VerificaData(this.value);"/></td></tr>
<tr><td td align="center" colspan="2">Às:<select name="as">
<option selected value=" "> </option>
<option value="00:00">00:00</option>
<option value="01:00">01:00</option>
<option value="02:00">02:00</option>
<option value="03:00">03:00</option>
<option value="04:00">04:00</option>
<option value="05:00">05:00</option>
<option value="06:00">06:00</option>
<option value="07:00">07:00</option>
<option value="08:00">08:00</option>
<option value="09:00">09:00</option>
<option value="10:00">10:00</option>
<option value="11:00">11:00</option>
<option value="12:00">12:00</option>
<option value="13:00">13:00</option>
<option value="14:00">14:00</option>
<option value="15:00">15:00</option>
<option value="16:00">16:00</option>
<option value="17:00">17:00</option>
<option value="18:00">18:00</option>
<option value="19:00">19:00</option>
<option value="20:00">20:00</option>
<option value="21:00">21:00</option>
<option value="22:00">22:00</option>
<option value="23:00">23:00</option>
</select></td></tr>
<tr><td colspan="2"><br><b>Buscar:</b></td></tr>
<tr><td align="left"><br>
<input type="checkbox" style="display:none;"  name="chk1" value="Date" checked/>
<input type="checkbox" style="display:none;"  name="chk2" value="Time" checked/>
<input type="checkbox" name="chk3" value="Temp Out" /> Temperatura(°C)</br>
<input type="checkbox" name="chk11" value="Hi Temp" /> Temperatura máxima(°C)</br>
<input type="checkbox" name="chk12" value="Low Temp" /> Temperatura mínima(°C)</br>
<input type="checkbox" name="chk4" value="Out Hum" /> Umidade Relativa(%)<br />
<input type="checkbox" name="chk5" value="Rain" /> Precipitação(mm)<br /></td><td align="left"><br>
<input type="checkbox" name="chk6" value="Solar Rad" /> Radiação Solar(W/m²)<br />
<input type="checkbox" name="chk7" value="UV Index" /> Índice UV(adimensional)<br />
<input type="checkbox" name="chk8" value="Wind Speed" /> Velocidade dos Ventos(m/s)<br />
<input type="checkbox" name="chk9" value="Wind Dir" /> Direção dos Ventos(graus)<br />
<input type="checkbox" name="chk10" value="Bar" /> Pressão ao nível médio do mar(hPa)<br /></td></tr>
<tr><td colspan="2"><br><b>Gráficos:<br></br></td></tr>
<tr><td align="left" colspan="2">
<input type="radio" name="rd" value="1" checked>Meteogramas<br>
<input type="radio" name="rd" value="2">Média diária<br>
<input type="radio" name="rd" value="3">Média mensal<br><br></td></tr>

<tr><td align="center"><br><input name="action" type="submit" value="Gerar Relatório" /></td>
<td align="center"><br><input name="action"  type="submit" value="Gerar Gráfico" /></td></tr></table>

</form></center>
</body>
</html>
