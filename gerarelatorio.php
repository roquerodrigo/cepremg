<?php
    if( $_SERVER['REQUEST_METHOD']=='POST' )  
    {  
if ($_POST['action']=='Gerar Relatório'){
include 'conecta.php';
require 'Classes/PHPExcel.php';
$de  = $_POST['de'];
$data1 = explode('/', $de);
$data1 = $data1[2].'-'.$data1[1].'-'.$data1[0];
$ate = $_POST['ate'];
$data2 = explode('/', $ate);
$data2 = $data2[2].'-'.$data2[1].'-'.$data2[0];
$de  = $_POST['as'];



$campos = array(); //CRIA UMA ARRAY


for($i=1; $i<=12; $i++){ //INÃCIO DO LOOP QUE VERIFICA QUAIS CHECKBOX ESTÃƒO MARCADOS
    if(isset($_POST["chk$i"])) { //SE ALGUM ESTIVER MARCADO INSERE SEU VALOR NA ARRAY
       if($_POST["chk$i"]<> "Date"){
	      
	$campos[] = $_POST["chk$i"];}
    
    }
}

$camposelect = "`" . join("`, `", $campos) . "`";


// $result = mysql_query("select $camposelect from dados where `Date` between '$data1' and '$data2'");

if ($de == ' '){
$query = "select DATE_FORMAT(`Date`, '%d/%m/%Y') As 'Data', $camposelect from dados where `Date` between '$data1' and '$data2'";
}else{
$query = "select DATE_FORMAT(`Date`, '%d/%m/%Y') As 'Data', $camposelect from dados where `Time`= '$de' and `Date` between '$data1' and '$data2'";
}
if ($result = mysql_query($query) or die(mysql_error())) {
    // Create a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Dados');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $rowNumber = 1;
    $objPHPExcel->getActiveSheet()->setCellValue('A1','Data');
    $col = 'B';
for ($i = 0; $i < mysql_num_fields($result); ++$i) {
if($campos[$i]=='Temp Out'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Temperatura');
        $col++;}
	else if($campos[$i]=='Low Temp'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Temperatura Minima');
        $col++;}
	else if($campos[$i]=='Hi Temp'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Temperatura Maxima');
        $col++;}
        else if($campos[$i]=='Out Hum'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Umidade');
        $col++;}
	else if($campos[$i]=='Rain'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Precipitacao');
        $col++;}
	else if($campos[$i]=='Solar Rad'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Radiacao_Solar');
        $col++;}
	else if($campos[$i]=='UV Index'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Indice_UV');
        $col++;}
	else if($campos[$i]=='Wind Speed'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Velocidade_dos_Ventos');
        $col++;}
	else if($campos[$i]=='Wind Dir'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Direcao_dos_Ventos');
        $col++;}
	else if($campos[$i]=='Bar'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Pressao_Atmosferica');
        $col++;}
	else if($campos[$i]=='Time'){
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,'Hora');
        $col++;}
    }}
    foreach($campos as $camposel) {
   

    // Loop through the result set
    $rowNumber = 2;
    while ($row = mysql_fetch_row($result)) {
       $col = 'A';
       foreach($row as $cell) {
          $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
          $col++;
       }
       $rowNumber++;
    }

    // Freeze pane so that the heading line won't scroll
    $objPHPExcel->getActiveSheet()->freezePane('A2');
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);


    // Save as an Excel BIFF (xls) file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

   header('Content-Type: application/vnd.ms-excel');
   header('Content-Disposition: attachment;filename="relatorio.xls"');
   header('Cache-Control: max-age=0');

   $objWriter->save('php://output');
   exit();
}





$de  = $_POST['de'];
$data1 = explode('/', $de);
$data1 = $data1[2].'-'.$data1[1].'-'.$data1[0];
$ate = $_POST['ate'];
$data2 = explode('/', $ate);
$data2 = $data2[2].'-'.$data2[1].'-'.$data2[0];



$campos = array(); //CRIA UMA ARRAY

for($i=1; $i<=10; $i++){ //INÃCIO DO LOOP QUE VERIFICA QUAIS CHECKBOX ESTÃƒO MARCADOS
    if(isset($_POST["chk$i"])) { //SE ALGUM ESTIVER MARCADO INSERE SEU VALOR NA ARRAY
        $campos[] = $_POST["chk$i"];
    }
}

$camposelect = "`" . join("`, `", $campos) . "`";


$result = mysql_query("select $camposelect from dados where `Date` between '$data1' and '$data2'");

echo "<HTML><HEAD></HEAD><BODY>";
echo "<center><br><center><table border='1'><tr>";

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
	echo "<td align='center'><b>indice UV</b></td>";}
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
echo "</table><a href='example1.pdf'>pdf</a></center>";


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

