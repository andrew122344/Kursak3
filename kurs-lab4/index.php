<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/SunScreenList.php');
require_once('./app/PropertyList.php');
require_once('./app/SphrofApplList.php');
require_once('./app/ApplTimeList.php');
$c=new SunScreenList();
$c->readFromCSV('data\SunScreens1.csv');
$c->display();
$c->update(
[
		'id'=>'2',
		'name'=>'Дитячий сонцезахисний спрей',
		'vendor'=>'BABE Laboratorios Pediatric',
		'price'=>'1078',
		'applTime'=>'Універсальні',
		'sphrofAppl'=>'Для тіла',
		'properties'=>'{"SPF": "50", "Вікова категорія": "3+ Роки", "Консистенція": "Спрей", "Країна-виробник: ": "Іспанія", "Об’єм упаковки": "200 Мл"  }'
	]
);
$c->writeToCSV('data\SunScreens1.csv');
$c->display();
/* $c->delete(1);
$c->display(); */
?>