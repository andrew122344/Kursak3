<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../app/ApplTimeList.php');
$item=null;
$a = new ApplTimeList();
$a->getAllFromDatabase();

?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Час застосування</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
        <link rel="stylesheet" href="./style/custom.css">
    </head>
    <body>
        <div class="container">
            <ul class="nav">
                <li><a class="btn btn-outline nav-btn" href="./ApplsTime.php">Час застосування</a></li>
                <li><a class="btn btn-outline nav-btn" href="./SphrsofAppl.php">Сфера застосування</a></li>
                <li><a class="btn btn-outline nav-btn" href="./Properties.php">Характеристики</a></li>
                <li><a class="btn btn-outline nav-btn" href="./SunScreens.php">Сонцезахисні засоби</a></li>
                <li><a class="btn btn-outline nav-btn" href="./logout.php">Вийти</a></li>
            </ul>
            <h1>Час застосування</h1>
            <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $a->getAsTableBody();?>
                        </tbody>
                    </table>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>