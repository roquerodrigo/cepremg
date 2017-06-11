<?php
    if( $_SERVER['REQUEST_METHOD']=='POST' )  
    {  
if ($_POST['action']=='Gerar Relatório'){
include 'conecta.php';

$de  = $_POST['de'];
$data1 = explode('/', $de);
$data1 = $data1[2].'-'.$data1[1].'-'.$data1[0];
$ate = $_POST['ate'];
$data2 = explode('/', $ate);
$data2 = $data2[2].'-'.$data2[1].'-'.$data2[0];



$campos = array(); //CRIA UMA ARRAY

for($i=1; $i<=10; $i++){ //INÃƒÂCIO DO LOOP QUE VERIFICA QUAIS CHECKBOX ESTÃƒÆ’O MARCADOS
    if(isset($_POST["chk$i"])) { //SE ALGUM ESTIVER MARCADO INSERE SEU VALOR NA ARRAY
        $campos[] = $_POST["chk$i"];
    }
}

$camposelect = "`" . join("`, `", $campos) . "`";


$result = mysql_query("select $camposelect from dados where `Date` between '$data1' and '$data2'");

echo "<HTML><HEAD></HEAD><BODY>";
echo "<center><h1>Relatório de Dados da Estação</h1><br><br>

<center><table border='1'><tr>";

for ($i = 0; $i < mysql_num_fields($result); ++$i) {
	if($campos[$i]=='Temp Out'){
	echo "<td align='center'><b>Temperatura</b></td>";}
        else if($campos[$i]=='Out Hum'){
	echo "<td align='center'><b>Umidade</b></td>";}
	else if($campos[$i]=='Rain'){
	echo "<td align='center'><b>Precipitação</b></td>";}
	else if($campos[$i]=='Solar Rad'){
	echo "<td align='center'><b>Radiação Solar</b></td>";}
	else if($campos[$i]=='UV Index'){
	echo "<td align='center'><b>Índice UV</b></td>";}
	else if($campos[$i]=='Wind Speed'){
	echo "<td align='center'><b>Velocidade Ventos</b></td>";}
	else if($campos[$i]=='Wind Dir'){
	echo "<td align='center'><b>Direção dos Ventos</b></td>";}
	else if($campos[$i]=='Bar'){
	echo "<td align='center'><b>Pressão Atmosférica</b></td>";}
	else if($campos[$i]=='Date'){
	echo "<td align='center'><b>Data</b></td>";}
	else if($campos[$i]=='Time'){
	echo "<td align='center'><b>Hora</b></td>";}
}
echo "</tr>";
while($escrever=mysql_fetch_array($result)){
/*Escreve cada linha da tabela*/echo "<tr>";
for ($i = 0; $i < mysql_num_fields($result); ++$i) {
echo "<td align='center'>" . $escrever[$campos[$i]] . "</td>";}
}
echo "</tr>";
echo "</table></center>";


echo "</BODY></HTML>";} 


else{
$de  = $_POST['de'];
$data1 = explode('/', $de);
$data1 = $data1[2].'-'.$data1[1].'-'.$data1[0];
$ate = $_POST['ate'];
$data2 = explode('/', $ate);
$data2 = $data2[2].'-'.$data2[1].'-'.$data2[0];

$temp = "no";
$tempmax = "no";
$tempmin = "no";
$hum = "no";
$prec = "no";
$rs = "no";
$uv = "no";
$ws = "no";
$dir = "no";
$bar = "no";



if(isset($_POST["chk3"])){ 
$temp = "yes";}else{}
if(isset($_POST["chk4"])){ 
$hum = "yes";}else{}
if(isset($_POST["chk5"])){ 
$prec = "yes";}else{}
if(isset($_POST["chk6"])){ 
$rs = "yes";}else{}
if(isset($_POST["chk7"])){ 
$uv = "yes";}else{}
if(isset($_POST["chk8"])){ 
$ws = "yes";}else{}
if(isset($_POST["chk11"])){ 
$tempmax= "yes";}else{}
if(isset($_POST["chk12"])){ 
$tempmin= "yes";}else{}
if(isset($_POST["chk9"])){ 
$dir = "yes";}else{}
if(isset($_POST["chk10"])){ 
$bar = "yes";}else{}


if($_POST["rd"]==1){ 
header("Location: grafdin.php?de=".$data1."&ate=".$data2."&temp=".$temp."&tempmax=".$tempmax."&tempmin=".$tempmin."&hum=".$hum."&prec=".$prec."&rs=".$rs."&uv=".$uv."&ws=".$ws."&dir=".$dir."&bar=".$bar."");
}else{}

if($_POST["rd"]==2){ 
header("Location: grafdin2.php?de=".$data1."&ate=".$data2."&temp=".$temp."&tempmax=".$tempmax."&tempmin=".$tempmin."&hum=".$hum."&prec=".$prec."&rs=".$rs."&uv=".$uv."&ws=".$ws."&dir=".$dir."&bar=".$bar."");
}else{}

if($_POST["rd"]==3){ 
header("Location: grafdin3.php?de=".$data1."&ate=".$data2."&temp=".$temp."&tempmax=".$tempmax."&tempmin=".$tempmin."&hum=".$hum."&prec=".$prec."&rs=".$rs."&uv=".$uv."&ws=".$ws."&dir=".$dir."&bar=".$bar."");
}else{}



}}

?>



