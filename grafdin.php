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



//capturando Temperaturas m√©dias

$result = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Temp Out` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados   = array();
while ($row = mysql_fetch_assoc($result)) {
            $dados[]   = $row["Temp Out"];
	    $label[] = $row["meio"];
        }

$data_string = "[" . join(", ", $dados) . "]";
$labels_string = "['" . join("', '", $label) . "']";



//capturando humidades m√©dias

$result2 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Out Hum` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados2   = array();
while ($row2 = mysql_fetch_assoc($result2)) {
            $dados2[]   = $row2["Out Hum"];
	    $label2[] = $row2["meio"];
        }

$data_string2 = "[" . join(", ", $dados2) . "]";
$labels_string2 = "['" . join("', '", $label2) . "']";



//capturando precipita√ß√µes
 
$result3 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Rain` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados3   = array();
while ($row3 = mysql_fetch_assoc($result3)) {
            $dados3[]   = $row3["Rain"];
	    $label3[] = $row3["meio"];
        }

$data_string3 = "[" . join(", ", $dados3) . "]";
$labels_string3 = "['" . join("', '", $label3) . "']";


//capturando velocidade do vento 
$result4 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Wind Speed` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados4   = array();
while ($row4 = mysql_fetch_assoc($result4)) {
            $dados4[]   = $row4["Wind Speed"];
	    $label4[] = $row4["meio"];
        }

$data_string4 = "[" . join(", ", $dados4) . "]";
$labels_string4 = "['" . join("', '", $label4) . "']";



//capturando radia√ß√£o solar 
$result5 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Solar Rad` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados5   = array();
while ($row5 = mysql_fetch_assoc($result5)) {
            $dados5[]   = $row5["Solar Rad"];
	    $label5[] = $row5["meio"];
	    
        }

$data_string5 = "[" . join(", ", $dados5) . "]";
$labels_string5 = "['" . join("', '", $label5) . "']";


 
//capturando √≠ndice uv 
$result6 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `UV Index` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados6   = array();
while ($row6 = mysql_fetch_assoc($result6)) {
            $dados6[]   = $row6["UV Index"];
	    $label6[] = $row6["meio"];
	    
        }

$data_string6 = "[" . join(", ", $dados6) . "]";
$labels_string6 = "['" . join("', '", $label6) . "']";


//capturando Temperaturas max

$result7 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Hi Temp` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados7   = array();
while ($row7 = mysql_fetch_assoc($result7)) {
            $dados7[]   = $row7["Hi Temp"];
	    $label7[] = $row7["meio"];
        }

$data_string7 = "[" . join(", ", $dados7) . "]";
$labels_string7 = "['" . join("', '", $label7) . "']";

//capturando Temperaturas min

$result8 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Low Temp` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados8   = array();
while ($row8 = mysql_fetch_assoc($result8)) {
            $dados8[]   = $row8["Low Temp"];
	    $label8[] = $row8["meio"];
        }

$data_string8 = "[" . join(", ", $dados8) . "]";
$labels_string8 = "['" . join("', '", $label8) . "']";

//capturando dir ventos

$result9 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, CASE WHEN (`Wind Dir`='E') THEN 90 WHEN(`Wind Dir`='ENE') THEN 67.30 WHEN(`Wind Dir`='ESE') THEN 112.30 WHEN(`Wind Dir`='N') THEN 360 WHEN(`Wind Dir`='NE') THEN 45 WHEN(`Wind Dir`='NNE') THEN 22.30 WHEN(`Wind Dir`='NNW') THEN 337.30 WHEN(`Wind Dir`='NW') THEN 315 WHEN(`Wind Dir`='S') THEN 180 WHEN(`Wind Dir`='SE') THEN 135 WHEN(`Wind Dir`='SSE') THEN 157.30  WHEN(`Wind Dir`='SSW') THEN 202.30 WHEN(`Wind Dir`='SW') THEN 225 WHEN(`Wind Dir`='W') THEN 270 WHEN(`Wind Dir`='WNW') THEN 292.30 ELSE 247.30 END dir FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados9   = array();
while ($row9 = mysql_fetch_assoc($result9)) {
            $dados9[]   = $row9["dir"];
	    $label9[] = $row9["meio"];
        }

$data_string9 = "[" . join(", ", $dados9) . "]";
$labels_string9 = "['" . join("', '", $label9) . "']";

//capturando pressao atm

$result10 = mysql_query("SELECT CASE WHEN (`Time` = '01:00') THEN DATE_FORMAT(`Date` ,'%d/%m/%y') END AS meio, `Date`, `Time`, `Bar` FROM dados WHERE `Date` between '$data1' and '$data2'");
$dados10   = array();
while ($row10 = mysql_fetch_assoc($result10)) {
            $dados10[]   = $row10["Bar"];
	    $label10[] = $row10["meio"];
        }

$data_string10 = "[" . join(", ", $dados10) . "]";
$labels_string10 = "['" . join("', '", $label10) . "']";


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
     <script>
        window.onload = function ()
        {
            
	    <?if($temp == "yes"){?>
            var line = new RGraph.Line('cvs', <?php print($data_string) ?>);
            line.Set('chart.colors', ['red']);
            line.Set('chart.linewidth', 1);
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
            line1.Set('chart.linewidth', 1);
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
            line2.Set('chart.colors', ['blue']);
            line2.Set('chart.linewidth', 1);
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
            line3.Set('chart.colors', ['blue']);
            line3.Set('chart.linewidth', 1);
            line3.Set('chart.filled', false);
	     
            line3.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line3.Set('chart.ymax', 8);
	    line3.Set('chart.background.grid.autofit.numvlines', 23);
            line3.Set('chart.numxticks', 12);

            line3.Set('chart.labels', <?php print($labels_string4) ?>);
            line3.Draw(); 

		<?}else{}?> 

		<?if($rs == "yes"){?>

            var line4 = new RGraph.Line('cvs4', <?php print($data_string5) ?>);
            line4.Set('chart.colors', ['red']);
            line4.Set('chart.linewidth', 1);
            line4.Set('chart.filled', false);
	     line4.Set('chart.noaxes', false); 
            
	   line4.Set('chart.ylabels', true);
            line4.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line4.Set('chart.ymax', 1300);
	    line4.Set('chart.background.grid.autofit.numvlines', 23);
            line4.Set('chart.numxticks', 12);
           line4.Set('chart.gutter.left', 40);
            line4.Set('chart.labels', <?php print($labels_string5) ?>);
            line4.Draw(); 

	    <?}else{}?> 

	   <?if($uv == "yes"){?>

	   var line5 = new RGraph.Line('cvs5',  <?php print($data_string6) ?>);
            line5.Set('chart.colors', ['orange']);
            line5.Set('chart.linewidth', 1);
	    line5.Set('chart.ylabels', true);
            line5.Set('chart.background.grid', true);
            line5.Set('chart.filled', false);
	    
            line5.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line5.Set('chart.ymax', 15);
	    line5.Set('chart.labels', <?php print($labels_string6) ?>);
	    line5.Set('chart.background.grid.autofit.numvlines', 23);
            line5.Set('chart.numxticks', 12);
            line5.Draw(); 
<?}else{}?> 

            <?if($tempmax == "yes"){?>
            var line6 = new RGraph.Line('cvs6', <?php print($data_string7) ?>);
            line6.Set('chart.colors', ['red']);
            line6.Set('chart.linewidth', 1);
            line6.Set('chart.filled', false);
	     
            line6.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line6.Set('chart.ymax', 40);
	    line6.Set('chart.background.grid.autofit.numvlines', 23);
            line6.Set('chart.numxticks', 12);

            line6.Set('chart.labels', <?php print($labels_string7) ?>);
            line6.Draw(); 

           <?}else{}?> 

            <?if($tempmin == "yes"){?>
            var line7 = new RGraph.Line('cvs7', <?php print($data_string8) ?>);
            line7.Set('chart.colors', ['blue']);
            line7.Set('chart.linewidth', 1);
            line7.Set('chart.filled', false);
	    line7.Set('chart.ymax', 40); 
            line7.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            
	    line7.Set('chart.background.grid.autofit.numvlines', 23);
            line7.Set('chart.numxticks', 12);

            line7.Set('chart.labels', <?php print($labels_string8) ?>);
            line7.Draw(); 

           <?}else{}?> 

           <?if($bar == "yes"){?>
            var line8 = new RGraph.Line('cvs8', <?php print($data_string10) ?>);
            line8.Set('chart.colors', ['green']);
            line8.Set('chart.linewidth', 1);
            line8.Set('chart.filled', false);
	     
            line8.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line8.Set('chart.ymax', 1030);
            line8.Set('chart.ymin', 1000);
	    line8.Set('chart.background.grid.autofit.numvlines', 23);
            line8.Set('chart.numxticks', 12);
            line8.Set('chart.gutter.left', 40);
            line8.Set('chart.labels', <?php print($labels_string10) ?>);
            line8.Draw(); 

           <?}else{}?> 

            <?if($dir== "yes"){?>
            var line9 = new RGraph.Line('cvs9', <?php print($data_string9) ?>);
            line9.Set('chart.colors', ['blue']);
            line9.Set('chart.linewidth', 1);
            line9.Set('chart.filled', false);
	    line9.Set('chart.ymax', 360); 
            line9.Set('chart.ymin', 22.30); 
            line9.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
           
	    line9.Set('chart.background.grid.autofit.numvlines', 23);
            line9.Set('chart.background.grid.autofit.numhlines', 23);
            line9.Set('chart.numxticks', 12);

            line9.Set('chart.labels', <?php print($labels_string9) ?>);
            line9.Draw(); 

           <?}else{}?> 

	
            

        }


	

    </script>

</head>
<body>    
<center>
<?if($temp == "yes"){?>

<h3>Temperatura (∞C)</h3>

<canvas id="cvs" width="500" height="250">[No canvas support]</canvas>
<br><br>
<?}else{}?>
<?if($tempmax == "yes"){?>

<h3>Temperatura M·xima (∞C)</h3>

<canvas id="cvs6" width="500" height="250">[No canvas support]</canvas>
<br><br>
<?}else{}?>
<?if($tempmin == "yes"){?>

<h3>Temperatura MÌnima (∞C)</h3>

<canvas id="cvs7" width="500" height="250">[No canvas support]</canvas>
<br><br>
<?}else{}?>
<?if($bar== "yes"){?>

<h3>Press„o ao NÌvel do Mar (hPa)</h3>

<canvas id="cvs8" width="500" height="250">[No canvas support]</canvas>
<br><br>
<?}else{}?>
<?if($hum == "yes"){?>

<h3>Humidade Relativa do Ar (%)</h3>

<canvas id="cvs1" width="500" height="250">[No canvas support]</canvas>
<br><br>

<?}else{}?>

<?if($prec == "yes"){?>

<h3>PrecipitaÁ„o (mm)</h3>

<canvas id="cvs2" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($rs == "yes"){?>

<h3>RadiaÁ„o Solar (W/m≤)</h3>

<canvas id="cvs4" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($uv == "yes"){?>

<h3>Õçndice de UV (index)</h3>

<canvas id="cvs5" width="500" height="250">[No canvas support]</canvas>

<br><br>
<?}else{}?>
<?if($ws == "yes"){?>

<h3>Velocidade do Vento (m/s)</h3>

<canvas id="cvs3" width="500" height="250">[No canvas support]</canvas>

<br><br>

<?}else{}?>

<?if($dir== "yes"){?>

<h3>DireÁ„o dos ventos (graus)</h3>

<canvas id="cvs9" width="500" height="250">[No canvas support]</canvas>
<br>
<table border=1 width = "200">
<tr><th colspan="4">Tabela de Convers„o</th></tr>
<tr><td>90∫00'</td><td>E</td><td>315∫00'</td><td>NW</td></tr>
<tr><td>67∫30'</td><td>ENE</td><td>180∫00'</td><td>S</td></tr>
<tr><td>112∫30'</td><td>ESE</td><td>135∫00'</td><td>SE</td></tr>
<tr><td>360∫00'</td><td>N</td><td>157∫30'</td><td>SSE</td></tr>
<tr><td>45∫00'</td><td>NE</td><td>157∫30'</td><td>SSE</td></tr>
<tr><td>22∫30'</td><td>NNE</td><td>157∫30'</td><td>SSE</td></tr>
<tr><td>337∫30'</td><td>NNW</td><td>202∫30'</td><td>SSW</td></tr>
<tr><td>225∫00'</td><td>SW</td><td>292∫30'</td><td>WNW</td></tr>
<tr><td>247∫30'</td><td>WSW</td><td></td><td></td></tr>
</table> 
<br><br>
<?}else{?><?}?>

</center>


</body>
</html>
