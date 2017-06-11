<?
include 'conecta.php';
$dia = date("d");
$mes = date("m");
$ano = date("Y");

$hoje = date("d/m");
$ontem = mktime(0,0,0,date("m"),date("d")-1,date("Y")); $ontem1= date("d/m", $ontem); $o1= date("Y-m-d", $ontem);
$aontem = mktime(0,0,0,date("m"),date("d")-2,date("Y")); $ontem2= date("d/m", $aontem); $o2= date("Y-m-d", $aontem);
$bontem = mktime(0,0,0,date("m"),date("d")-3,date("Y")); $ontem3= date("d/m", $bontem); $o3= date("Y-m-d", $bontem);
$contem = mktime(0,0,0,date("m"),date("d")-4,date("Y")); $ontem4= date("d/m", $contem); $o4= date("Y-m-d", $contem);
$dontem = mktime(0,0,0,date("m"),date("d")-5,date("Y")); $ontem5= date("d/m", $dontem); $o5= date("Y-m-d", $dontem);
$eontem = mktime(0,0,0,date("m"),date("d")-6,date("Y")); $ontem6= date("d/m", $eontem); $o6= date("Y-m-d", $eontem);




//capturando Temperaturas médias
$tempmedhj = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$tempmedo1 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o1'");
$tempmedo2 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o2'");
$tempmedo3 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o3'");
$tempmedo4 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o4'");
$tempmedo5 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o5'");
$tempmedo6 = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where Date = '$o6'");


$tempmedmes = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where MONTH(`Date`)='$mes'");
$tempmedano = mysql_query("SELECT ROUND(AVG(`Temp Out`),2) as mednum FROM dados where YEAR(`Date`)='$ano'");
$row = mysql_fetch_array($tempmedhj);
$row1 = mysql_fetch_array($tempmedo1);
$row2 = mysql_fetch_array($tempmedo2);
$row3 = mysql_fetch_array($tempmedo3);
$row4 = mysql_fetch_array($tempmedo4);
$row5 = mysql_fetch_array($tempmedo5);
$row6 = mysql_fetch_array($tempmedo6);
$row7 = mysql_fetch_array($tempmedmes);
$row8 = mysql_fetch_array($tempmedano);

//capturando Pressao atm
$pressmedhj = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$pressmedo1 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o1'");
$pressmedo2 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o2'");
$pressmedo3 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o3'");
$pressmedo4 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o4'");
$pressmedo5 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o5'");
$pressmedo6 = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where Date = '$o6'");


$pressmedmes = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where MONTH(`Date`)='$mes'");
$pressmedano = mysql_query("SELECT ROUND(AVG(`Bar`),1) as mednum FROM dados where YEAR(`Date`)='$ano'");
$row90 = mysql_fetch_array($pressmedhj);
$row91 = mysql_fetch_array($pressmedo1);
$row92 = mysql_fetch_array($pressmedo2);
$row93 = mysql_fetch_array($pressmedo3);
$row94 = mysql_fetch_array($pressmedo4);
$row95 = mysql_fetch_array($pressmedo5);
$row96 = mysql_fetch_array($pressmedo6);
$row97 = mysql_fetch_array($pressmedmes);
$row98 = mysql_fetch_array($pressmedano);

//capturando humidades médias
$Hummedhj = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$Hummedo1 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o1'");
$Hummedo2 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o2'");
$Hummedo3 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o3'");
$Hummedo4 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o4'");
$Hummedo5 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o5'");
$Hummedo6 = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where Date = '$o6'");


$Hummedmes = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where MONTH(`Date`)='$mes'");
$Hummedano = mysql_query("SELECT AVG(`Out Hum`) as mednum FROM dados where YEAR(`Date`)='$ano'");
$row9 = mysql_fetch_array($Hummedhj);
$row10 = mysql_fetch_array($Hummedo1);
$row11 = mysql_fetch_array($Hummedo2);
$row12 = mysql_fetch_array($Hummedo3);
$row13 = mysql_fetch_array($Hummedo4);
$row14 = mysql_fetch_array($Hummedo5);
$row15 = mysql_fetch_array($Hummedo6);
$row16 = mysql_fetch_array($Hummedmes);
$row17 = mysql_fetch_array($Hummedano);

//capturando precipitações 
$Prechj = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$ano-$mes-$dia'");
$Prec1 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o1'");
$Prec2 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o2'");
$Prec3 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o3'");
$Prec4 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o4'");
$Prec5 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o5'");
$Prec6 = mysql_query("SELECT SUM(`Rain`) as mednum FROM dados where Date = '$o6'");


$row18 = mysql_fetch_array($Prechj);
$row19 = mysql_fetch_array($Prec1);
$row20 = mysql_fetch_array($Prec2);
$row21 = mysql_fetch_array($Prec3);
$row22 = mysql_fetch_array($Prec4);
$row23 = mysql_fetch_array($Prec5);
$row24 = mysql_fetch_array($Prec6);

//capturando velocidades de vento médias
$Velmedhj = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$ano-$mes-$dia' and `Wind Speed`<>0");
$Velmedo1 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o1' and `Wind Speed`<>0");
$Velmedo2 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o2' and `Wind Speed`<>0");
$Velmedo3 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o3' and `Wind Speed`<>0");
$Velmedo4 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o4' and `Wind Speed`<>0");
$Velmedo5 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o5' and `Wind Speed`<>0");
$Velmedo6 = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where Date = '$o6' and `Wind Speed`<>0");


$Velmedmes = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where MONTH(`Date`)='$mes' and `Wind Speed`<>0");
$Velmedano = mysql_query("SELECT ROUND(AVG(`Wind Speed`),2) as mednum FROM dados where YEAR(`Date`)='$ano' and `Wind Speed`<>0");
$row25 = mysql_fetch_array($Velmedhj);
$row26 = mysql_fetch_array($Velmedo1);
$row27 = mysql_fetch_array($Velmedo2);
$row28 = mysql_fetch_array($Velmedo3);
$row29 = mysql_fetch_array($Velmedo4);
$row30 = mysql_fetch_array($Velmedo5);
$row31 = mysql_fetch_array($Velmedo6);
$row32 = mysql_fetch_array($Velmedmes);
$row33 = mysql_fetch_array($Velmedano);

//capturando Radiação Solar e UV médias
$Raduvmedhj = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$ano-$mes-$dia' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo1 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o1' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo2 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o2' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo3 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o3' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo4 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o4' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo5 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o5' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedo6 = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where `Date` = '$o6' and `Solar Rad`<> 0 and `UV Index`<>0");


$Raduvmedmes = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where MONTH(`Date`) = '$mes' and `Solar Rad`<> 0 and `UV Index`<>0");
$Raduvmedano = mysql_query("SELECT ROUND(AVG(`Solar Rad`),0) as mednum1, ROUND(AVG(`UV Index`),2) as mednum2 FROM dados where YEAR(`Date`) = '$ano' and `Solar Rad`<> 0 and `UV Index`<>0");
$row34 = mysql_fetch_array($Raduvmedhj);
$row35 = mysql_fetch_array($Raduvmedo1);
$row36 = mysql_fetch_array($Raduvmedo2);
$row37 = mysql_fetch_array($Raduvmedo3);
$row38 = mysql_fetch_array($Raduvmedo4);
$row39 = mysql_fetch_array($Raduvmedo5);
$row40 = mysql_fetch_array($Raduvmedo6);
$row41 = mysql_fetch_array($Raduvmedmes);
$row42 = mysql_fetch_array($Raduvmedano);


?>
<!DOCTYPE html >
<html lang="pt-BR">
<head>
<meta charset="iso-8859-1">
    <link rel="stylesheet" href="demos.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/RGraph.common.core.js" ></script>
    <script type="text/javascript" src="js/RGraph.common.dynamic.js" ></script>
    <script type="text/javascript" src="js/RGraph.common.context.js" ></script>
    <script type="text/javascript" src="js/RGraph.bar.js" ></script>
    <script src="js/RGraph.common.dynamic.js" ></script>
    <script src="js/RGraph.common.tooltips.js" ></script>
    <script src="js/RGraph.common.effects.js" ></script>
    <script src="js/RGraph.common.key.js" ></script>
    <script src="js/jquery.min.js" ></script>
    <script src="js/RGraph.common.core.js" ></script>
    <script src="js/RGraph.line.js" ></script>
    <if IE>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="js/canvasie.js"></script>
<endif>
    
    <title>A basic Line chart</title>
</head>
<body><br>

    <h3>Temperatura Média Semanal - (°C)</h3><br>

    <canvas id="cvs" width="500" height="250">[No canvas support]</canvas>

<br><br>

<h3>Umidade Média Semanal (%)</h3><br>

<canvas id="cvs2" width="500" height="250">[No canvas support]</canvas>

<br><br>

    <h3>Precipitação Semanal (mm)</h3><br>

<canvas id="cvs3" width="500" height="250">[No canvas support]</canvas>

<br><br>

    <h3>Velocidade Vento Média Semanal (m/s)</h3><br>

<canvas id="cvs4" width="500" height="250">[No canvas support]</canvas>

<br><br>

<h3>Radiação Solar (W/m²) e Índice de UV (index)</h3><br>

<canvas id="cvs5" width="500" height="250">[No canvas support]</canvas>


    
    <script>
        window.onload = function ()
        {
            var line = new RGraph.Line('cvs', [<?echo $row6[mednum]; ?>,<?echo $row5[mednum]; ?>,<?echo $row4[mednum]; ?>,<?echo $row3[mednum]; ?>,<?echo $row2[mednum]; ?>,<?echo $row1[mednum]; ?>,<?echo $row[mednum]; ?>]);
            line.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
            line.Set('chart.linewidth', 2);
	    line.Set('chart.colors', ['red', 'green', 'blue']);
            line.Set('chart.key', ['Media Dia', 'Media Mês', 'Media Ano']);
	    line.Set('chart.key.position', 'gutter');
            line.Set('chart.key.position.gutter.boxed', false);	     
	    line.Set('chart.key.position.x', 105);
	    line.Draw();

	    
	    var line1 = new RGraph.Line('cvs', [<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>,<?echo $row7[mednum]; ?>]);
            line1.Set('chart.linewidth', 2);
	    line1.Set('chart.background.grid', false);
            line1.Set('chart.colors', ['green']);
            line1.Set('chart.ylabels', false);
	    line1.Draw();

            
            var line2 = new RGraph.Line('cvs', [<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>,<?echo $row8[mednum]; ?>]);
            line2.Set('chart.linewidth', 2);
	    line2.Set('chart.background.grid', false);
            line2.Set('chart.colors', ['blue']);
            line2.Set('chart.ylabels', false);
	    line2.Draw();


	    
            var line3 = new RGraph.Line('cvs2', [<?echo $row15[mednum]; ?>,<?echo $row14[mednum]; ?>,<?echo $row13[mednum]; ?>,<?echo $row12[mednum]; ?>,<?echo $row11[mednum]; ?>,<?echo $row10[mednum]; ?>,<?echo $row9[mednum]; ?>]);
            line3.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
            line3.Set('chart.linewidth', 2);
            line3.Set('chart.ymax', 100);
	    line3.Set('chart.ymin', 0);
	    line3.Set('chart.colors', ['red', 'green', 'blue']);
            line3.Set('chart.key', ['Media Dia', 'Media Mês', 'Media Ano']);
	    line3.Set('chart.key.position', 'gutter');
            line3.Set('chart.key.position.gutter.boxed', false);	     
	    line3.Set('chart.key.position.x', 105);
	    line3.Draw();


	    var line4 = new RGraph.Line('cvs2', [<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>,<?echo $row16[mednum]; ?>]);
            line4.Set('chart.linewidth', 2);
            line4.Set('chart.ymax', 100);
	    line4.Set('chart.ymin', 0);
	    line4.Set('chart.background.grid', false);
            line4.Set('chart.colors', ['green']);
            line4.Set('chart.ylabels', false);
	    line4.Draw();

         
            var line5 = new RGraph.Line('cvs2', [<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>,<?echo $row17[mednum]; ?>]);
            line5.Set('chart.linewidth', 2);
            line5.Set('chart.ymax', 100);
	    line5.Set('chart.ymin', 0);
	    line5.Set('chart.background.grid', false);
            line5.Set('chart.colors', ['blue']);
            line5.Set('chart.ylabels', false);
	    line5.Draw();

 	   
            var bar6 = new RGraph.Bar('cvs3', [<?echo $row24[mednum]; ?>,<?echo $row23[mednum]; ?>,<?echo $row22[mednum]; ?>,<?echo $row21[mednum]; ?>,<?echo $row20[mednum]; ?>,<?echo $row19[mednum]; ?>,<?echo $row18[mednum]; ?>]);
            bar6.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
            bar6.Set('chart.annotatable', true);
            bar6.Set('chart.contextmenu', [['Clear', function () {RGraph.Clear(bar6.canvas); RGraph.ClearAnnotations(bar6.canvas); bar6.Draw();}]]);
            bar6.Draw();



            var line6 = new RGraph.Line('cvs4', [<?echo $row31[mednum]; ?>,<?echo $row30[mednum]; ?>,<?echo $row29[mednum]; ?>,<?echo $row28[mednum]; ?>,<?echo $row27[mednum]; ?>,<?echo $row26[mednum]; ?>,<?echo $row25[mednum]; ?>]);
            line6.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
	    line6.Set('chart.colors', ['red']);
            line6.Set('chart.linewidth', 2);
            line6.Set('chart.ymin', 0);
	    line6.Set('chart.colors', ['red', 'green', 'blue']);
            line6.Set('chart.key', ['Media Dia', 'Media Mês', 'Media Ano']);
	    line6.Set('chart.key.position', 'gutter');
            line6.Set('chart.key.position.gutter.boxed', false);	     
	    line6.Set('chart.key.position.x', 105);
            line6.Draw();

           
            var line7 = new RGraph.Line('cvs4', [<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>,<?echo $row32[mednum]; ?>]);
            line7.Set('chart.linewidth', 2);
	    line7.Set('chart.ymin', 0);
            line7.Set('chart.background.grid', false);
            line7.Set('chart.colors', ['green']);
            line7.Set('chart.ylabels', false);
	    line7.Draw();

         
            var line8 = new RGraph.Line('cvs4', [<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>,<?echo $row33[mednum]; ?>]);
            line8.Set('chart.linewidth', 2);
            line8.Set('chart.ymin', 0);
	    line8.Set('chart.background.grid', false);
            line8.Set('chart.colors', ['blue']);
            line8.Set('chart.ylabels', false);
            line8.Draw();

var gutterLeft = 70;
            var gutterRight = 25;

	    var line9 = new RGraph.Line('cvs5', [<?echo $row40[mednum1]; ?>,<?echo $row39[mednum1]; ?>,<?echo $row38[mednum1]; ?>,<?echo $row37[mednum1]; ?>,<?echo $row36[mednum1]; ?>,<?echo $row35[mednum1]; ?>,<?echo $row34[mednum1]; ?>]);
            line9.Set('chart.colors', ['red']);
            line9.Set('chart.linewidth', 2);
            line9.Set('chart.filled', false);
	    line9.Set('chart.noaxes', true); 
  
	    line9.Set('chart.colors', ['red', 'orange']);
            line9.Set('chart.key', ['Radiação Solar', 'UV']);
            line9.Set('chart.key.position', 'gutter');
            line9.Set('chart.key.position.gutter.boxed', false);
            line9.Set('chart.key.position.x', 275);
            line9.Set('chart.ylabels', false);
            line9.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line9.Set('chart.ymax', 1000);
	    line9.Set('chart.background.grid.autofit.numvlines', 23);
            line9.Set('chart.numxticks', 12);
            line9.Set('chart.gutter.left', gutterLeft);
	    line9.Set('chart.gutter.right', gutterRight);
            line9.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
	    line9.Draw(); 

	   var line10 = new RGraph.Line('cvs5', [<?echo $row40[mednum2]; ?>,<?echo $row39[mednum2]; ?>,<?echo $row38[mednum2]; ?>,<?echo $row37[mednum2]; ?>,<?echo $row36[mednum2]; ?>,<?echo $row35[mednum2]; ?>,<?echo $row34[mednum2]; ?>]);
            line10.Set('chart.colors', ['orange']);
            line10.Set('chart.linewidth', 2);
	    line10.Set('chart.ylabels', false);
            line10.Set('chart.background.grid', false);
            line10.Set('chart.filled', false);
	    line10.Set('chart.noaxes', true); 
            line10.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line10.Set('chart.ymax', 10);
	    line10.Set('chart.gutter.left', gutterLeft);
	    line10.Set('chart.gutter.right', gutterRight);
	    line10.Set('chart.background.grid.autofit.numvlines', 23);
            line10.Set('chart.numxticks', 12);
            line10.Draw(); 

	   RGraph.DrawAxes(line9, {
                                        'axis.x': 70,
                                        'axis.color': 'orange',
                                        'axis.text.color': 'red',
                                        'axis.max': 10,
                                        'axis.min': 0,
                                        'axis.align': 'left'
                                       });
                RGraph.DrawAxes(line10, {
                                        'axis.x': 40,
                                        'axis.y': 25,
                                        'axis.color': 'red',
                                        'axis.text.color': 'green',
                                        'axis.max': 1000
                                       });

        }


	    var line11 = new RGraph.Line('cvs6', [<?echo $row96[mednum]; ?>,<?echo $row95[mednum]; ?>,<?echo $row94[mednum]; ?>,<?echo $row93[mednum]; ?>,<?echo $row92[mednum]; ?>,<?echo $row91[mednum]; ?>,<?echo $row90[mednum]; ?>]);
            line11.Set('chart.labels', ['<?echo $ontem6 ?>','<?echo $ontem5 ?>','<?echo $ontem4 ?>','<?echo $ontem3 ?>','<?echo $ontem2 ?>','<?echo $ontem1 ?>','<?echo $hoje ?>']);
            line11.Set('chart.linewidth', 2);
	    line11.Set('chart.colors', ['red', 'green', 'blue']);
            line11.Set('chart.key', ['Media Dia', 'Media Mês', 'Media Ano']);
	    line11.Set('chart.key.position', 'gutter');
            line11.Set('chart.key.position.gutter.boxed', false);	     
	    line11.Set('chart.key.position.x', 105);
	    line11.Draw();

	    var line12 = new RGraph.Line('cvs6', [<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>,<?echo $row97[mednum]; ?>]);
            linep12.Set('chart.linewidth', 2);
	    linep12.Set('chart.background.grid', false);
            linep12.Set('chart.colors', ['green']);
            linep12.Set('chart.ylabels', false);
	    linep12.Draw();

	    var line13 = new RGraph.Line('cvs6', [<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>,<?echo $row98[mednum]; ?>]);
            linep13.Set('chart.linewidth', 2);
	    linep13.Set('chart.background.grid', false);
            linep13.Set('chart.colors', ['blue']);
            linep13.Set('chart.ylabels', false);
	    linep13.Draw();
        




    </script>

    <p><br>

    
   
    </script>
    </p>

</body>
</html>
