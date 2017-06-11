<?
include 'conecta.php';
$dia = date("d");
$mes = date("m");
$ano = date("Y");

$hora= mysql_query("SELECT TIME_FORMAT(ADDTIME(TIME_FORMAT(MAX(`Time`), '%H:%i'), '00:00'), '%H:%i') as hr from dados where `Date`= '$ano-$mes-$dia'");
$row = mysql_fetch_array($hora);

?>

<!doctype html>
<html lang="pt-BR">
<head>
 <meta charset="UTF-8">
   <style type="text/css">

      #container {
        margin-top: -28px;
	margin-left: -20px;
      }

#frame { -ms-zoom: 0.85; -moz-transform: scale(0.85); -moz-transform-origin: 0px 0; -o-transform: scale(0.85); -o-transform-origin: 0 0; -webkit-transform: scale(0.85); -webkit-transform-origin: 0 0;}
    </style>
  </head>
  <body>
<h1>Dados Atuais</h1><br><br><h2>Dados atualizados &agrave;s <?echo $row[hr]; ?>hs de <?echo date("d/m/Y"); ?></h2><br><br><br>
<div id="container"><iframe id="frame" width="600px" height="1660px" frameborder="0" scrolling="no" src="graficos.php"></iframe> </div>

</body></html>

