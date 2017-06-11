<?php

include "conecta.php";

$tabela = "dados"; //tabela do banco
$arquivo = 'dados/download.txt';
$ll=1;
$arq = fopen($arquivo,'r');// le o arquivo txt
$data = fread($arq, filesize($arquivo));
fclose($arq);
$string= '0';
$pos= strpos($data, $string);
$datalimpo = substr($data,$pos);
$output = explode("\n", $datalimpo);
foreach($output as $var){
$linha = explode("\t", $var);
$sql = "INSERT INTO $tabela VALUES (DATE_FORMAT( STR_TO_DATE( '$linha[0]' , '%d/%m/%y' ) , '%Y-%m-%d' )
, '$linha[1]', '$linha[2]', '$linha[3]', '$linha[4]', '$linha[5]', '$linha[6]', '$linha[7]', '$linha[8]', '$linha[9]', '$linha[10]', '$linha[11]', '$linha[12]', '$linha[13]', '$linha[14]', '$linha[15]', '$linha[16]', '$linha[17]', '$linha[18]', '$linha[19]', '$linha[20]', '$linha[21]', '$linha[22]', '$linha[23]', '$linha[24]', '$linha[25]', '$linha[26]', '$linha[27]', '$linha[28]', '$linha[29]', '$linha[30]', '$linha[31]', '$linha[32]', '$linha[33]', '$linha[34]', '$linha[35]', '$linha[36]', '$linha[37]', '$linha[38]', '$linha[39]')";
mysql_query($sql);
//print_r($linha);

}

?>


