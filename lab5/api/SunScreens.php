<?php
session_start();
if(!$_SESSION['user']){
    header('HTTP/1.0 401 Unauthorized');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/SunScreenList.php');
$a=new SunScreenList();
$a->readFromCSV('../data/SunScreens.csv');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->add(['vendor'=>$data['vendor'],
            'name'=>$data['name'],
            'price'=>$data['price'],
            'applTime'=>$data['applTime'],
            'sphrofAppl'=>$data['sphrofAppl'],
            'properties'=>$data['properties']
]);
    $a->writeToCSV('../data/SunScreens.csv');
    echo "OK!";
}
if($_SERVER['REQUEST_METHOD']=='UPDATE'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->update(['id'=>$data['id'],'vendor'=>$data['vendor'],
            'model'=>$data['model'],
            'price'=>$data['price'],
            'applTime'=>$data['applTime'],
            'sphrofAppl'=>$data['sphrofAppl'],
            'properties'=>$data['properties']]);
    $a->writeToCSV('../data/SunScreens.csv');
    echo "OK!";
}
else if($_SERVER['REQUEST_METHOD']=='DELETE'){
    $a->delete($_REQUEST['id']);
    $a->writeToCSV('../data/SunScreens.csv');
} 
else if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        echo json_encode($a->getById($_GET['id']));
    } else{
        echo $a->getAsJSON();
    }
    
}