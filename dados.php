<?
include 'conecta.php';


date_default_timezone_set('Brazil/East');

$dia = date("d");
$mes = date("m");
$ano = date("Y");
$hoje = date("d/m");

$hora= mysql_query("SELECT TIME_FORMAT(ADDTIME(TIME_FORMAT(MAX(`Time`), '%H:%i'), '00:00'), '%H:%i') as hr from dados where `Date`= '$ano-$mes-$dia'");
$rowh = mysql_fetch_array($hora);

//capturando Temperaturas
$tempmaxhj = mysql_query("SELECT MAX(`Hi Temp`) as maxnum FROM dados where Date = '$ano-$mes-$dia'");
$tempmaxmes = mysql_query("SELECT MAX(`Hi Temp`) as maxnum FROM dados where MONTH(`Date`)='$mes'");
$tempmaxano = mysql_query("SELECT MAX(`Hi Temp`) as maxnum FROM dados where YEAR(`Date`)='$ano'");
$row = mysql_fetch_array($tempmaxano);
$row2 = mysql_fetch_array($tempmaxmes);
$row3 = mysql_fetch_array($tempmaxhj);

$tempminhj = mysql_query("SELECT MIN(`Low Temp`) as minnum FROM dados where Date = '$ano-$mes-$dia'");
$tempminmes = mysql_query("SELECT MIN(`Low Temp`) as minnum FROM dados where MONTH(`Date`)='$mes'");
$tempminano = mysql_query("SELECT MIN(`Low Temp`) as minnum FROM dados where YEAR(`Date`)='$ano'");
$row4 = mysql_fetch_array($tempminano);
$row5 = mysql_fetch_array($tempminmes);
$row6 = mysql_fetch_array($tempminhj);

//capturando press„o atmosfÈrica
$pressmaxhj = mysql_query("SELECT MAX(`Bar`) as maxnum FROM dados where Date = '$ano-$mes-$dia'");
$pressmaxmes = mysql_query("SELECT MAX(`Bar`) as maxnum FROM dados where MONTH(`Date`)='$mes'");
$pressmaxano = mysql_query("SELECT MAX(`Bar`) as maxnum FROM dados where YEAR(`Date`)='$ano'");
$rowp = mysql_fetch_array($pressmaxano);
$rowp2 = mysql_fetch_array($pressmaxmes);
$rowp3 = mysql_fetch_array($pressmaxhj);

$pressminhj = mysql_query("SELECT MIN(`Bar`) as minnum FROM dados where Date = '$ano-$mes-$dia'");
$pressminmes = mysql_query("SELECT MIN(`Bar`) as minnum FROM dados where MONTH(`Date`)='$mes'");
$pressminano = mysql_query("SELECT MIN(`Bar`) as minnum FROM dados where YEAR(`Date`)='$ano'");
$rowp4 = mysql_fetch_array($pressminano);
$rowp5 = mysql_fetch_array($pressminmes);
$rowp6 = mysql_fetch_array($pressminhj);

//capturando Humidade
$hummaxhj = mysql_query("SELECT MAX(`Out Hum`) as maxnum FROM dados where Date = '$ano-$mes-$dia'");
$hummaxmes = mysql_query("SELECT MAX(`Out Hum`) as maxnum FROM dados where MONTH(`Date`)='$mes'");
$hummaxano = mysql_query("SELECT MAX(`Out Hum`) as maxnum FROM dados where YEAR(`Date`)='$ano'");
$row7 = mysql_fetch_array($hummaxano);
$row8 = mysql_fetch_array($hummaxmes);
$row9 = mysql_fetch_array($hummaxhj);

$humminhj = mysql_query("SELECT MIN(`Out Hum`) as minnum FROM dados where Date = '$ano-$mes-$dia'");
$humminmes = mysql_query("SELECT MIN(`Out Hum`) as minnum FROM dados where MONTH(`Date`)='$mes'");
$humminano = mysql_query("SELECT MIN(`Out Hum`) as minnum FROM dados where YEAR(`Date`)='$ano'");
$row10 = mysql_fetch_array($humminano);
$row11 = mysql_fetch_array($humminmes);
$row12 = mysql_fetch_array($humminhj);

//capturando precipita√ß√£o
$prechj = mysql_query("SELECT ROUND(SUM(`Rain`),2) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$precmes = mysql_query("SELECT ROUND(SUM(`Rain`),2) as mednum FROM dados where MONTH(`Date`)='$mes'");
$precano = mysql_query("SELECT ROUND(SUM(`Rain`),2) as mednum FROM dados where YEAR(`Date`)='$ano'");
$row13 = mysql_fetch_array($prechj);
$row14 = mysql_fetch_array($precmes);
$row15 = mysql_fetch_array($precano);

//capturando velocidade dos ventos
$velventoagora = mysql_query("SELECT `Wind Speed` as mednum FROM dados where Date = '$ano-$mes-$dia' AND `Time`= (SELECT MAX(`Time`) from dados where `Date`= '$ano-$mes-$dia')");
$velventohj = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$velventomes = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where MONTH(`Date`)='$mes'");
$velventoano = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where YEAR(`Date`)='$ano'");
$row16 = mysql_fetch_array($velventohj);
$row17 = mysql_fetch_array($velventomes);
$row18 = mysql_fetch_array($velventoano);
$row19 = mysql_fetch_array($velventoagora);

//capturando radia√ß√£o e indice UV

$radmaxhj = mysql_query("SELECT MAX(`Hi Solar Rad`) as maxnum FROM dados where Date = '$ano-$mes-$dia'");
$radmaxmes = mysql_query("SELECT MAX(`Hi Solar Rad`) as maxnum FROM dados where MONTH(`Date`)='$mes'");
$radmaxano = mysql_query("SELECT MAX(`Hi Solar Rad`) as maxnum FROM dados where YEAR(`Date`)='$ano'");
$row20 = mysql_fetch_array($radmaxhj);
$row21 = mysql_fetch_array($radmaxmes);
$row22 = mysql_fetch_array($radmaxano);

$uvmaxhj = mysql_query("SELECT MAX(`Hi UV`) as maxnum FROM dados where Date = '$ano-$mes-$dia'");
$uvmaxmes = mysql_query("SELECT MAX(`Hi UV`) as maxnum FROM dados where MONTH(`Date`)='$mes'");
$uvmaxano = mysql_query("SELECT MAX(`Hi UV`) as maxnum FROM dados where YEAR(`Date`)='$ano'");
$row23 = mysql_fetch_array($uvmaxhj);
$row24 = mysql_fetch_array($uvmaxmes);
$row25 = mysql_fetch_array($uvmaxano);

?>


<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <h1>Resumo dos dados</h1>
<br><br>
<h2>Dados atualizados ‡s <?echo $rowh[hr];?> hs de <?echo date("d/m/Y"); ?></h2>
<br><br><br>
<center><h3>TEMPERATURA</h3></center>
<br>
<center>
<table border="1" width="500px">
  <tr>
    <th align="center">M·xima</th>
    <th align="center">Valores(∞C)</th>
    <th align="center">MÌnima</th>
    <th align="center">Valores(∞C)</th>
  </tr>
  <tr>
    <th align="center">Hoje</th>
    <td align="center"><font color="red"><?echo $row3[maxnum]; ?></font></td>
    <th align="center">Hoje</th>
    <td align="center"><font color="blue"><?echo $row6[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">MÍs</th>
    <td align="center"><font color="red"><?echo $row2[maxnum]; ?></font></td>
    <th align="center">MÍs</th>
    <td align="center"><font color="blue"><?echo $row5[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">Ano</th>
    <td align="center" ><font color="red"><?echo $row[maxnum]; ?></font></td>
    <th align="center">Ano</th>
    <td align="center"><font color="blue"><?echo $row4[minnum]; ?></font></td>
  </tr>
</table></center> 
<br><br><br>
<center><h3>PRESS√O AO NIVEL MEDIO DO MAR</h3></center>
<br>
<center>
<table border="1" width="500px">
  <tr>
    <th align="center">M·xima</th>
    <th align="center">Valores(hPa)</th>
    <th align="center">MÌnima</th>
    <th align="center">Valores(hPa)</th>
  </tr>
  <tr>
    <th align="center">Hoje</th>
    <td align="center"><font color="red"><?echo $rowp3[maxnum]; ?></font></td>
    <th align="center">Hoje</th>
    <td align="center"><font color="blue"><?echo $rowp6[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">MÍss</th>
    <td align="center"><font color="red"><?echo $rowp2[maxnum]; ?></font></td>
    <th align="center">MÍss</th>
    <td align="center"><font color="blue"><?echo $rowp5[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">Ano</th>
    <td align="center" ><font color="red"><?echo $rowp[maxnum]; ?></font></td>
    <th align="center">Ano</th>
    <td align="center"><font color="blue"><?echo $rowp4[minnum]; ?></font></td>
  </tr>
</table></center> 
<br><br><br>

<center><h3>UMIDADE RELATIVA DO AR</h3></center>
<br>
<center>
<table border="1" width="400px">
  <tr>
    <th align="center">M·xima</th>
    <th align="center">Valores(%)</th>
    <th align="center">MÌnima</th>
    <th align="center">Valores(%)</th>
  </tr>
  <tr>
    <th align="center">Hoje</th>
    <td align="center"><font color="blue"><?echo $row9[maxnum]; ?></font></td>
    <th align="center">Hoje</th>
    <td align="center"><font color="red"><?echo $row12[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">MÍs</th>
    <td align="center"><font color="blue"><?echo $row8[maxnum]; ?></font></td>
    <th align="center">MÍs</th>
    <td align="center"><font color="red"><?echo $row11[minnum]; ?></font></td>
  </tr>
  <tr>
    <th align="center">Ano</th>
    <td align="center"><font color="blue"><?echo $row7[maxnum]; ?></font></td>
    <th align="center">Ano</th>
    <td align="center"><font color="red"><?echo $row10[minnum]; ?></font></td>
  </tr>
</table></center> 
<br><br><br>
<center><h3>PRECIPITA«√O</h3></center>
<br>
<center>
<table border="1" width="400px">
  <tr>
    <th align="center">Item</th>
    <th align="center">Valores(mm)</th>
  </tr>
  <tr>
    <th align="center">PrecipitaÁ„o Hoje</th>
    <td align="center"><?echo $row13[mednum]; ?></td>
  </tr>
  <tr>
    <th align="center">PrecipitaÁ„o MÍs</th>
    <td align="center"><?echo $row14[mednum]; ?></td>
  </tr>
  <tr>
    <th align="center">PrecipitaÁ„o Ano</th>
    <td align="center"><?echo $row15[mednum]; ?></td>
  </tr>
</table></center> 
<br><br><br>
<center><h3>VENTOS</h3></center>
<br>
<center>
<table border="1" width="400px">
  <tr>
    <th align="center">Velocidade</th>
    <th align="center">Valores(m/s)</th>
  </tr>
  <tr>
    <th align="center">MÈdia (⁄ltimos 10 min)</th>
    <td align="center"><?echo $row19[mednum]; ?></td>
  </tr>
  <tr>
    <th align="center">MÈdia Di·ria</th>
    <td align="center"><?echo $row16[mednum]; ?></td>
  </tr>
  <tr>
    <th align="center">MÈdia Mensal</th>
    <td align="center"><?echo $row17[mednum]; ?></td>
  </tr>
  <tr>
    <th align="center">MÈdia Anual</th>
    <td align="center"><?echo $row18[mednum]; ?></td>
  </tr>
</table></center> 
<br><br><br>
<center><h3>RADIA«√O SOLAR E ÕçNDICE ULTRAVIOLETA</h3></center>
<br>
<center>
<table border="1" width="400px">
  <tr>
    <th align="center">M·xima RadiaÁ„o</th>
    <th align="center">Valores(W/m≤)</th>
    <th align="center">M·ximo Raios UV</th>
    <th align="center">Valores(index)</th>
  </tr>
  <tr>
    <th align="center">Hoje</th>
    <td align="center"><?echo $row20[maxnum]; ?></td>
    <th align="center">Hoje</th>
    <td align="center"><?echo $row23[maxnum]; ?></td>
  </tr>
  <tr>
    <th align="center">MÍs</th>
    <td align="center"><?echo $row21[maxnum]; ?></td>
    <th align="center">MÍs</th>
    <td align="center"><?echo $row24[maxnum]; ?></td>
  </tr>
  <tr>
    <th align="center">Ano</th>
    <td align="center"><?echo $row22[maxnum]; ?></td>
    <th align="center">Ano</th>
    <td align="center"><?echo $row25[maxnum]; ?></td>
  </tr>
</table></center> 



</body>
</html>
