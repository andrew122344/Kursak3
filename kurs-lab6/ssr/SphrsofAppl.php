<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/SphrofApplList.php');
$item=null;
$errorMessage = '';
$a = new SphrofApplList();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $a->getAllFromDatabase();
    if($_POST['id']==""){
       $result = $a->insertIntoDatabase(['name'=>$_POST['name']]);
        if ($result === false) {
            $errorMessage = "Помилка: Така сфера застосування вже внесена в базу даних!";
        }
    } else{
       $result = $a->updateDatabaseById(['id'=>$_POST['id'],'name'=>$_POST['name']]);
        if ($result === false) {
            $errorMessage = "Помилка: Така сфера застосування вже внесена в базу даних!";
            $item = ['id'=>$_POST['id'], 'name'=>$_POST['name']];
        } else {
            header('Location: SphrsofAppl.php');
            exit();
        }
    }
} else{
  if(isset($_GET['action'])&&$_GET['action']=='delete'){
        if(!$a->deleteFromDatabaseById($_GET['id'])){
            $errorMessage = "Помилка: Неможливо видалити цей запис, оскільки він використовується в існуючих сонцезахисних засобах";
            $a->getAllFromDatabase();
        } else {
            header('Location: SphrsofAppl.php');
            exit();
        }
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $a->getAllFromDatabase();
        $item=$a->getById($_GET['id']);
    } else {
        $a->getAllFromDatabase();
    }
}

?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Сфери застосування</title>
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
            <h1>Сфери застосування</h1>
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $a->getAsTableBody();?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <form method="POST">
                        <?php if($errorMessage): ?>
                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <p>
                            <input type="text" name="name" value="<?php echo $item?$item['name']:'';?>" class="form-control" placeholder="Cфера застосування" required/>
                        </p>
                        <p>
                            <input type="hidden" name="id" value="<?php echo $item?$item['id']:'';?>"/>
                            <button class="btn btn-success" type="submit">Зберегти</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>