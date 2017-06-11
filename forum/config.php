<?php
/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the forum can
work correctly.
******************************************************/

//We log to the DataBase
mysql_connect('prometeu.unifei.edu.br', 'cepremg_net', '#456123#');
mysql_select_db('cepremg');

//Username of the Administrator
$admin='mattmds';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Forum Home Page
$url_home = 'index.php';

//Design Name
$design = 'default';


/******************************************************
----------------------Initialization-------------------
******************************************************/
include('init.php');
?>
