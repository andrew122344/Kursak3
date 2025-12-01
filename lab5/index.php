<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/BackpackList.php');
require_once('./app/PropertyList.php');
require_once('./app/CategoryList.php');
/*$a=new CategoryList();
$a->readFromCSV('data/categories.csv');
$a->add(['name'=>'Експедиційні рюкзаки']);
$a->display();
$a->writeToCSV('data/categories.csv');*/
/*$a=new PropertyList();
$a->readFromCSV('data/properties.csv');
$a->add(['name'=>'Висота спинки','units'=>'см']);
$a->display();
$a->writeToCSV('data/properties.csv');*/
/*$a=new BackpackList();
$a->readFromCSV('data/backpacks.csv');
$a->add(['model'=>'Kestrel',
    'vendor'=>'Osprey',
    'price'=>'3000',
    'category'=>'Похідні рюкзаки',
    'properties'=>'{"Вага":"1.8 кг", "Об\'єм":"100 л"}'
]);
$a->display();
$a->writeToCSV('data/backpacks.csv');*/
