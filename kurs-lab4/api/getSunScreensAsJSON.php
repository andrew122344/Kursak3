<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/SunScreenList.php');
$a=new SunScreenList();
$a->readFromCSV('../data/SunScreens.csv');
echo $a->getAsJSON();
?>