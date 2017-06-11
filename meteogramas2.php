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

error_reporting(0);

//capturando Temperaturas mÃ©dias

$result = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Temp Out` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` ='01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Temp Out` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Temp Out` FROM dados WHERE  Date = '$ano-$mes-$dia'");


$data   = array();
while ($row = mysql_fetch_assoc($result)) {
            $data[]   = $row["Temp Out"];
	    $label[] = $row["meio"];
        }

$data_string = "[" . join(", ", $data) . "]";
$labels_string = "['" . join("', '", $label) . "']";



//capturando humidades mÃ©dias
$result2 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Out Hum` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` ='01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Out Hum` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Out Hum` FROM dados WHERE  Date = '$ano-$mes-$dia'");
$data2   = array();
while ($row2 = mysql_fetch_assoc($result2)) {
            $data2[]   = $row2["Out Hum"];
	    $label2[] = $row2["meio"];
        }

$data_string2 = "[" . join(", ", $data2) . "]";
$labels_string2 = "['" . join("', '", $label2) . "']";


//capturando precipitaÃ§Ãµes 
$result3 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Rain` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` ='01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Rain` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Rain` FROM dados WHERE  Date = '$ano-$mes-$dia'");
$data3   = array();
while ($row3 = mysql_fetch_assoc($result3)) {
            $data3[]   = $row3["Rain"];
	    $label3[] = $row3["meio"];
        }

$data_string3 = "[" . join(", ", $data3) . "]";
$labels_string3 = "['" . join("', '", $label3) . "']";


//capturando velocidade do vento 
$result4 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Wind Speed` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` ='01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Wind Speed` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Wind Speed` FROM dados WHERE  Date = '$ano-$mes-$dia'");
$data4   = array();
while ($row4 = mysql_fetch_assoc($result4)) {
            $data4[]   = $row4["Wind Speed"];
	    $label4[] = $row4["meio"];
        }

$data_string4 = "[" . join(", ", $data4) . "]";
$labels_string4 = "['" . join("', '", $label4) . "']";


//capturando radiaÃ§Ã£o solar e raios UV 
$result5 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Solar Rad`, `UV Index` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Solar Rad`, `UV Index` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Solar Rad`, `UV Index` FROM dados WHERE  Date = '$ano-$mes-$dia'");
$data5   = array();
while ($row5 = mysql_fetch_assoc($result5)) {
            $data5[]   = $row5["Solar Rad"];
	    $data25[]   = $row5["UV Index"];
	    $label5[] = $row5["meio"];
	    
        }

$data_string5 = "[" . join(", ", $data5) . "]";
$data_string25 = "[" . join(", ", $data25) . "]";
$labels_string5 = "['" . join("', '", $label5) . "']";


//capturando pressao

$result6 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Bar` FROM dados WHERE Date = '$o2' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Bar` FROM dados WHERE  Date = '$o1' UNION SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Bar` FROM dados WHERE  Date = '$ano-$mes-$dia'");


$data6   = array();
while ($row6 = mysql_fetch_assoc($result6)) {
            $data6[]   = $row6["Bar"];
	    $label6[] = $row6["meio"];
        }

$data_string6 = "[" . join(", ", $data6) . "]";
$labels_string6 = "['" . join("', '", $label6) . "']";

?>
<!DOCTYPE html >
<html lang="pt-BR">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta charset="utf-8">
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
     <script>
        window.onload = function ()
        {
            

            var line = new RGraph.Line('cvs', <?php print($data_string) ?>);
            line.Set('chart.colors', ['red']);
            line.Set('chart.linewidth', 2);
            line.Set('chart.filled', false);
	     
            line.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line.Set('chart.ymax', 40);
	    line.Set('chart.background.grid.autofit.numvlines', 23);
            line.Set('chart.numxticks', 12);

            line.Set('chart.labels', <?php print($labels_string) ?>);
            line.Draw();  

 	    var line1 = new RGraph.Line('cvs1', <?php print($data_string2) ?>);
            line1.Set('chart.colors', ['blue']);
            line1.Set('chart.linewidth', 2);
            line1.Set('chart.filled', false);
	     
            line1.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line1.Set('chart.ymax', 100);
	    line1.Set('chart.background.grid.autofit.numvlines', 23);
            line1.Set('chart.numxticks', 12);

            line1.Set('chart.labels', <?php print($labels_string2) ?>);
            line1.Draw();  

 	    var line2 = new RGraph.Line('cvs2', <?php print($data_string3) ?>);
            line2.Set('chart.colors', ['green']);
            line2.Set('chart.linewidth', 2);
            line2.Set('chart.filled', false);
	     
            line2.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line2.Set('chart.ymax', 30);
	    line2.Set('chart.background.grid.autofit.numvlines', 23);
            line2.Set('chart.numxticks', 12);

            line2.Set('chart.labels', <?php print($labels_string3) ?>);
            line2.Draw();     

	    var line3 = new RGraph.Line('cvs3', <?php print($data_string4) ?>);
            line3.Set('chart.colors', ['green']);
            line3.Set('chart.linewidth', 1);
            line3.Set('chart.filled', false);
	     
            line3.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line3.Set('chart.ymax', 8);
	    line3.Set('chart.background.grid.autofit.numvlines', 23);
            line3.Set('chart.numxticks', 12);

            line3.Set('chart.labels', <?php print($labels_string4) ?>);
            line3.Draw(); 
		 
		var gutterLeft = 70;
            var gutterRight = 25;


            var line4 = new RGraph.Line('cvs4', <?php print($data_string5) ?>);
            line4.Set('chart.colors', ['red']);
            line4.Set('chart.linewidth', 1);
            line4.Set('chart.filled', false);
	     line4.Set('chart.noaxes', true); 
  
	    line4.Set('chart.colors', ['red', 'orange']);
            line4.Set('chart.key', ['Radiação Solar', 'UV']);
            line4.Set('chart.key.position', 'gutter');
            line4.Set('chart.key.position.gutter.boxed', false);
            line4.Set('chart.key.position.x', 275);
	   line4.Set('chart.ylabels', false);
            line4.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line4.Set('chart.ymax', 1300);
	    line4.Set('chart.background.grid.autofit.numvlines', 23);
            line4.Set('chart.numxticks', 12);
            line4.Set('chart.gutter.left', gutterLeft);
	    line4.Set('chart.gutter.right', gutterRight);
            line4.Set('chart.labels', <?php print($labels_string5) ?>);
            line4.Draw(); 

	   var line5 = new RGraph.Line('cvs4', <?php print($data_string25) ?>);
            line5.Set('chart.colors', ['orange']);
            line5.Set('chart.linewidth', 1);
	    line5.Set('chart.ylabels', false);
            line5.Set('chart.background.grid', false);
            line5.Set('chart.filled', false);
	    line5.Set('chart.noaxes', true); 
            line5.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line5.Set('chart.ymax', 20);
	    line5.Set('chart.gutter.left', gutterLeft);
	    line5.Set('chart.gutter.right', gutterRight);
	    line5.Set('chart.background.grid.autofit.numvlines', 23);
            line5.Set('chart.numxticks', 12);
            line5.Draw(); 

	   RGraph.DrawAxes(line4, {
                                        'axis.x': 70,
                                        'axis.color': 'orange',
                                        'axis.text.color': 'red',
                                        'axis.max': 20,
                                        'axis.min': 0,
                                        'axis.align': 'left'
                                       });
                RGraph.DrawAxes(line5, {
                                        'axis.x': 40,
                                        'axis.y': 25,
                                        'axis.color': 'red',
                                        'axis.text.color': 'green',
                                        'axis.max': 1300
                                       });

 		var line6 = new RGraph.Line('cvs5', <?php print($data_string6) ?>);
            line6.Set('chart.colors', ['red']);
            line6.Set('chart.linewidth', 2);
            line6.Set('chart.filled', false);
	     
            line6.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line6.Set('chart.ymax', 1030);
	    line6.Set('chart.ymin', 1000);
	    line6.Set('chart.background.grid.autofit.numvlines', 23);
            line6.Set('chart.numxticks', 12);
	    line6.Set('chart.gutter.left', 40);
            line6.Set('chart.labels', <?php print($labels_string6) ?>);
            line6.Draw();  


        }

	     </script>



</head>
<body>    
<br><br>
<div id="met">
<p style="font-family:Helvetica, Verdana, sans-serif; font-size:87.5%; color:#635a4e;"><b>Meteograma:</b> Gráficos que mostram a evolução temporal de diferentes parâmetros meteorológicos.</p><br><br>

<h3>Temperatura (°C)</h3>

<canvas id="cvs" width="500" height="250">[No canvas support]</canvas>
<br><br>
<h3>Pressao ao Nivel Medio do Mar (hPa)</h3>

<canvas id="cvs5" width="500" height="250">[No canvas support]</canvas>
<br><br>
<h3>Umidade Relativa do Ar (%)</h3>

<canvas id="cvs1" width="500" height="250">[No canvas support]</canvas>
<br><br>
<h3>Precipitação (mm)</h3>

<canvas id="cvs2" width="500" height="250">[No canvas support]</canvas>

<br><br>
<h3>Velocidade do Vento (m/s)</h3>

<canvas id="cvs3" width="500" height="250">[No canvas support]</canvas>

<br><br>
<h3>Radiação Solar (W/m²) e Índice de UV (index)</h3>

<canvas id="cvs4" width="500" height="250">[No canvas support]</canvas>

</div>

</body>
</html>
