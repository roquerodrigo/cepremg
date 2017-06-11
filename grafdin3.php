<?

include 'conecta.php';

$data1 = $_GET["de"];
$data2 = $_GET["ate"];
$temp = $_GET["temp"];
$tempmax = $_GET["tempmax"];
$tempmin = $_GET["tempmin"];
$hum = $_GET["hum"];
$prec = $_GET["prec"];
$ws = $_GET["ws"];
$rs = $_GET["rs"];
$uv = $_GET["uv"];
$dir= $_GET["dir"];
$bar= $_GET["bar"];



//capturando Temperaturas médias

$result = mysql_query("SELECT Day(`Date`), ROUND(AVG(`Temp Out`),0) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados   = array();
while ($row = mysql_fetch_assoc($result)) {
            $dados[]   = $row["ROUND(AVG(`Temp Out`),0)"];
	    $label[] = $row["Day(`Date`)"];
        }

$data_string = "[" . join(", ", $dados) . "]";
$labels_string = "['" . join("', '", $label) . "']";



//capturando humidades médias

$result2 = mysql_query("SELECT Day(`Date`), ROUND(AVG(`Out Hum`),0) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados2   = array();
while ($row2 = mysql_fetch_assoc($result2)) {
            $dados2[]   = $row2["ROUND(AVG(`Out Hum`),0)"];
	    $label2[] = $row2["Day(`Date`)"];
        }

$data_string2 = "[" . join(", ", $dados2) . "]";
$labels_string2 = "['" . join("', '", $label2) . "']";



//capturando precipitações
 
$result3 = mysql_query("SELECT Day(`Date`), ROUND(MAX(`Rain`),0) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados3   = array();
while ($row3 = mysql_fetch_assoc($result3)) {
            $dados3[]   = $row3["ROUND(MAX(`Rain`),0)"];
	    $label3[] = $row3["Day(`Date`)"];
        }

$data_string3 = "[" . join(", ", $dados3) . "]";
$labels_string3 = "['" . join("', '", $label3) . "']";


//capturando velocidade do vento 
$result4 = mysql_query("SELECT Day(`Date`), ROUND(MAX(`Wind Speed`),2) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados4   = array();
while ($row4 = mysql_fetch_assoc($result4)) {
            $dados4[]   = $row4["ROUND(MAX(`Wind Speed`),2)"];
	    $label4[] = $row4["Day(`Date`)"];
        }

$data_string4 = "[" . join(", ", $dados4) . "]";
$labels_string4 = "['" . join("', '", $label4) . "']";



//capturando radiação solar 
$result5 = mysql_query("SELECT Day(`Date`), AVG(`Solar Rad`) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados5   = array();
while ($row5 = mysql_fetch_assoc($result5)) {
            $dados5[]   = $row5["AVG(`Solar Rad`)"];
	    $label5[] = $row5["Day(`Date`)"];
	    
        }

$data_string5 = "[" . join(", ", $dados5) . "]";
$labels_string5 = "['" . join("', '", $label5) . "']";


 
//capturando índice uv 
$result6 = mysql_query("SELECT Day(`Date`), AVG(`UV Index`) FROM dados where Date between '$data1' and '$data2' GROUP BY `Date`");
$dados6   = array();
while ($row6 = mysql_fetch_assoc($result6)) {
            $dados6[]   = $row6["AVG(`UV Index`)"];
	    $label6[] = $row6["Day(`Date`)"];
	    
        }

$data_string6 = "[" . join(", ", $dados6) . "]";
$labels_string6 = "['" . join("', '", $label6) . "']";


?>
<!DOCTYPE html >
<html lang="pt-BR">
<head>

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
            
	    <?if($temp == "yes"){?>
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

	    <?}else{}?> 

	   <?if($hum == "yes"){?>

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

	     <?}else{}?> 

	    <?if($prec == "yes"){?>
	    
 	    var line2 = new RGraph.Line('cvs2', <?php print($data_string3) ?>);
            line2.Set('chart.colors', ['green']);
            line2.Set('chart.linewidth', 2);
            line2.Set('chart.filled', false);
	     
            line2.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line2.Set('chart.ymax', 10);
	    line2.Set('chart.background.grid.autofit.numvlines', 23);
            line2.Set('chart.numxticks', 12);

            line2.Set('chart.labels', <?php print($labels_string3) ?>);
            line2.Draw();  

	     <?}else{}?> 


	      <?if($ws == "yes"){?> 

	    var line3 = new RGraph.Line('cvs3', <?php print($data_string4) ?>);
            line3.Set('chart.colors', ['green']);
            line3.Set('chart.linewidth', 2);
            line3.Set('chart.filled', false);
	     
            line3.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line3.Set('chart.ymax', 8);
	    line3.Set('chart.background.grid.autofit.numvlines', 23);
            line3.Set('chart.numxticks', 12);

            line3.Set('chart.labels', <?php print($labels_string4) ?>);
            line3.Draw(); 

		<?}else{}?> 

		<?if($rs == "yes"){?>
		 
		var gutterLeft = 70;
            var gutterRight = 25;


            var line4 = new RGraph.Line('cvs4', <?php print($data_string5) ?>);
            line4.Set('chart.colors', ['red']);
            line4.Set('chart.linewidth', 2);
            line4.Set('chart.filled', false);
	     line4.Set('chart.noaxes', false); 
            line4.Set('chart.key.position', 'gutter');
            line4.Set('chart.key.position.gutter.boxed', false);
            line4.Set('chart.key.position.x', 275);
	   line4.Set('chart.ylabels', false);
            line4.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line4.Set('chart.ymax', 1000);
	    line4.Set('chart.background.grid.autofit.numvlines', 23);
            line4.Set('chart.numxticks', 12);
            line4.Set('chart.gutter.left', gutterLeft);
	    line4.Set('chart.gutter.right', gutterRight);
            line4.Set('chart.labels', <?php print($labels_string5) ?>);
            line4.Draw(); 

	    <?}else{}?> 

	   <?if($uv == "yes"){?>

	   var line5 = new RGraph.Line('cvs5',  <?php print($data_string6) ?>);
            line5.Set('chart.colors', ['orange']);
            line5.Set('chart.linewidth', 2);
	    line5.Set('chart.ylabels', false);
            line5.Set('chart.background.grid', true);
            line5.Set('chart.filled', false);
	    line5.Set('chart.noaxes', false); 
            line5.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line5.Set('chart.ymax', 10);
	    line5.Set('chart.gutter.left', gutterLeft);
	    line5.Set('chart.gutter.right', gutterRight);
	    line5.Set('chart.labels', <?php print($labels_string6) ?>);
	    line5.Set('chart.background.grid.autofit.numvlines', 23);
            line5.Set('chart.numxticks', 12);
            line5.Draw(); 
<?}else{}?> 

	   RGraph.DrawAxes(line4, {
                                        'axis.x': 70,
                                        'axis.color': 'orange',
                                        'axis.text.color': 'red',
                                        'axis.max': 10,
                                        'axis.min': 0,
                                        'axis.align': 'left'
                                       });
                RGraph.DrawAxes(line5, {
                                        'axis.x': 70,
                                        'axis.y': 25,
                                        'axis.color': 'red',
                                        'axis.text.color': 'green',
                                        'axis.max': 1000
                                       });

        }


	

    </script>

</head>
<body>    
<center>
<?if($temp == "yes"){?>

<h3>Temperatura (°C)</h3>

<canvas id="cvs" width="500" height="250">[No canvas support]</canvas>
<br><br>

<?}else{}?>

<?if($hum == "yes"){?>

<h3>Humidade Relativa do Ar (%)</h3>

<canvas id="cvs1" width="500" height="250">[No canvas support]</canvas>
<br><br>

<?}else{}?>

<?if($prec == "yes"){?>

<h3>Precipitação (mm)</h3>

<canvas id="cvs2" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($ws == "yes"){?>

<h3>Velocidade do Vento (m/s)</h3>

<canvas id="cvs3" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($rs == "yes"){?>

<h3>Radiação Solar (W/m²)</h3>

<canvas id="cvs4" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($uv == "yes"){?>

<h3>Índice de UV (index)</h3>

<canvas id="cvs5" width="500" height="250">[No canvas support]</canvas>

<br><br><?}else{?><?}?>

</center>


</body>
</html>
