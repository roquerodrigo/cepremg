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




//capturando Temperaturas atual

$result = mysql_query("SELECT ROUND((`Temp Out`),2) as temp FROM dados where Date = '$ano-$mes-$dia' and `Time`= (select max(`Time`) from dados where Date =  '$ano-$mes-$dia')");
$row = mysql_fetch_array($result);


//capturando humidade atual
$result2 = mysql_query("SELECT ROUND((`Out Hum`),0) as hum FROM dados where Date = '$ano-$mes-$dia' and `Time`= (select max(`Time`) from dados where Date =  '$ano-$mes-$dia')");
$row2 = mysql_fetch_array($result2);


//capturando precipita√ß√µes 
$result3 = mysql_query("SELECT ROUND((`Rain`),2) as chuva FROM dados where Date = '$ano-$mes-$dia' and `Time`= (select max(`Time`) from dados where Date =  '$ano-$mes-$dia')");
$row3 = mysql_fetch_array($result3);


//capturando velocidade do vento 
$result4 = mysql_query("SELECT ROUND((`Wind Speed`),2) as ws, `Wind Dir` as wd  FROM dados where Date = '$ano-$mes-$dia' and `Time`= (select max(`Time`) from dados where Date =  '$ano-$mes-$dia')");
$row4 = mysql_fetch_array($result4);


//capturando radia√ß√£o solar e raios UV 
$result5 = mysql_query("SELECT `Solar Rad` as radsol, `UV Index` as uv FROM dados where Date = '$ano-$mes-$dia' and `Time`= (select max(`Time`) from dados where Date =  '$ano-$mes-$dia')");
$row5 = mysql_fetch_array($result5);

//capturando e calculando Ìndice de estress tÈrmico
$result6 = mysql_query("SELECT ROUND(0.63*`Temp Out` - 0.03*`Out Hum` + 0.002*`Solar Rad` + 0.0054*`Temp Out`*`Out Hum` - 0.073*(1/(0.1+`Solar Rad`)),0) as iet FROM dados where `Date`= '$ano-$mes-$dia' and `Time` = (select max(`Time`) from dados where `Date`= '$ano-$mes-$dia')");
$row6 = mysql_fetch_array($result6);


?>
<!DOCTYPE html >
<html lang="pt-BR">
<head>

<meta charset="utf-8">
    <link rel="stylesheet" href="demos.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/RGraph.common.core.js" ></script>
    <script src="js/RGraph.meter.js" ></script>
	<script src="js/RGraph.vprogress.js" ></script>
    <script src="js/RGraph.thermometer.js" ></script>
	<script src="js/RGraph.odo.js" ></script>
	<script src="js/RGraph.common.annotate.js" ></script>
    <script src="js/RGraph.common.effects.js" ></script>
<script src="js/RGraph.common.context.js" ></script>
<script src="js/RGraph.common.zoom.js" ></script>
    <script src="js/RGraph.common.key.js" ></script>
    <script src="js/jquery.min.js" ></script>
   <if IE>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="js/canvasie.js"></script>
<endif>
     <script>           

                    window.onload = function ()
        {


            var thermometer = new RGraph.Thermometer('cvs', 0,50,<?echo $row['temp']; ?>);
	    if(<?echo $row['temp']; ?><10){
	    thermometer.Set('chart.colors',['blue']);}
            thermometer.Draw();
        
	    var vprogress = new RGraph.VProgress('cvs1', <?echo $row2['hum']; ?>,100);
            vprogress.Draw();

	      // ID, MINIMUM, MAXIMUM, INDICATED VALUE

		var nowdir = '<?echo $row4['wd']; ?>';
		var dir;
	  	    switch (nowdir) {
		case 'N': dir=0;break;
		case 'NNE': dir=25;break; 
		case 'NE': dir=45;break;
		case 'ENE': dir=70;break;
		case 'E': dir=90;break;
		case 'ESE': dir=115;break;
		case 'SE': dir=135;break;
		case 'SSE': dir=160;break;
		case 'S': dir=180;break;
		case 'SSW': dir=205;break;
		case 'SW': dir=225;break;
		case 'WSW': dir=250;break;
		case 'W': dir=270;break;
		case 'WNW': dir=295;break;
		case 'NW': dir=315;break;
		case 'NNW': dir=340}
            var odo2 = new RGraph.Odometer('cvs3', 0, 360, dir, <?echo $row4['ws']; ?>);
            
            //odo2.Set('chart.needle.thickness', 6);
            odo2.Set('chart.needle.color', 'black');
            odo2.Set('chart.needle.tail', false);
            //odo2.Set('chart.needle.type', 'triangle');
            odo2.Set('chart.label.area', 35);
            //odo2.Set('chart.contextmenu', [['Clear', function () {RGraph.Clear(odo2.canvas); odo2.Draw();}]]);
            odo2.Set('chart.border', true);
            //odo2.Set('chart.tickmarks.highlighted', true);
            odo2.Set('chart.labels', ['N','NE','E','SE','S','SW','W','NW']);
            odo2.Set('chart.red.min', 360);
            odo2.Set('chart.red.color', 'gray');
            odo2.Set('chart.value.text', true);
            odo2.Set('chart.value.units.post', ' m/s');
            odo2.Draw();

		
	    var progress2 = new RGraph.VProgress('cvs2', <?echo $row3['chuva']; ?>, 10);
            progress2.Set('chart.colors', ['blue']);
            progress2.Set('chart.shadow', true);
            progress2.Set('chart.shadow.color', '#666');
            progress2.Set('chart.shadow.offsetx', 0);
            progress2.Set('chart.shadow.offsety', 0);
            progress2.Set('chart.shadow.blur', 15);
            progress2.Set('chart.margin', 3);
            progress2.Set('chart.tickmarks', true);
            progress2.Set('chart.tickmarks.inner', true);
            progress2.Draw();

	    var meter = new RGraph.Meter('cvs4', 0,1000,<?echo $row5['radsol']; ?>);
            meter.Set('chart.border', false);
            meter.Set('chart.tickmarks.small.num', 0);
            meter.Set('chart.tickmarks.big.num', 0);
            meter.Set('chart.segment.radius.start', 80);
            meter.Set('chart.red.color', 'green');
            meter.Set('chart.green.color', 'red');
            meter.Set('chart.text.size', 10);
            meter.Set('chart.colors.ranges', [[0,400,'#0c0'], [400,800,'yellow'], [800,1000,'red']]);
            meter.Set('chart.needle.radius', 100);
            meter.Draw();

  	    var meter2 = new RGraph.Meter('cvs5', 0,14,<?echo $row5['uv']; ?>);
            meter2.Set('chart.border', false);
            meter2.Set('chart.tickmarks.small.num', 0);
            meter2.Set('chart.tickmarks.big.num', 0);
            meter2.Set('chart.segment.radius.start', 80);
            meter2.Set('chart.red.color', 'green');
            meter2.Set('chart.green.color', 'red');
            meter2.Set('chart.text.size', 10);
            meter2.Set('chart.colors.ranges', [[0,2,'green'], [2,5,'yellow'], [5,7,'orange'], [7,10, 'red'], [10,14,'purple']]);
            meter2.Set('chart.needle.radius', 100);
            meter2.Draw();

	    var meter3 = new RGraph.Meter('cvs6', 0,50,<?echo $row6['iet']; ?>);
            meter3.Set('chart.border', false);
            meter3.Set('chart.tickmarks.small.num', 0);
            meter3.Set('chart.tickmarks.big.num', 0);
            meter3.Set('chart.segment.radius.start', 80);
            meter3.Set('chart.red.color', 'green');
            meter3.Set('chart.green.color', 'red');
	    meter3.Set('chart.text.size', 10);
            meter3.Set('chart.colors.ranges', [[0,25,'#0c0'], [25,33,'yellow'], [33,50,'red']]);
            meter3.Set('chart.needle.radius', 100);
            meter3.Draw();
            

        }



    </script>

</head>
<body>    


<table border = "0" width=20%>
<tr>
<th><font size ="4">Temperatura (∞C)</font></th>
<th><font size ="4">Umidade (%)</font></th>
</tr>
<tr>
<td align="center"><canvas id="cvs" width="100" height="400">[No canvas support]</canvas></td>
<td align="center"><canvas id="cvs1" width="100" height="400">[No canvas support]</canvas></td>
</tr>
<tr>
<th colspan="2"><br><br><br><font size ="4">Õndice de Estresse TÈrmico</font></th>
</tr>
<tr>
<td align="center" colspan="2"><img src="/img/form.jpg"></td>
</tr>
<tr>
<td align="center" colspan="2">TA: Temperatura ambiente (∞C)/ UR: Umidade relativa (%)/RS: RadiaÁ„o solar (W/m≤)</td>
</tr>
<tr>
<td align="center" colspan="2"><canvas id="cvs6" width="300" height="200">[No canvas support]</canvas><br><br></td>
</tr>
<tr>
<td align="center" colspan="2"><img src="/img/tab.jpg"><br><br><br><br><br></td>
</tr>
<tr>
<th><font size ="4">PrecipitaÁ„o (mm)</font></th>
<th><font size ="4">Velocidade (m/s) e DireÁ„o dos ventos</font></th>
</tr>
<tr>
<td align="center"><canvas id="cvs2" width="140" height="400">[No canvas support]</canvas></td>
<td align="center"><canvas id="cvs3" width="300" height="300">[No canvas support]</canvas></td>
</tr>
<tr>
<th><font size ="4">RadiaÁ„o Solar (W/m≤)</font></th>
<th><font size ="4">Õçndice UV </font></th>
</tr>
<tr>
<td align="center"><canvas id="cvs4" width="300" height="200">[No canvas support]</canvas></td>
<td align="center"><canvas id="cvs5" width="300" height="200">[No canvas support]</canvas></td>
</tr>
</table>



    
   
    <p><br>

    
   
    </script>
    </p>

</body>
</html>
