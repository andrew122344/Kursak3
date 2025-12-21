<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/SunScreenList.php');
require_once('../app/SphrofApplList.php');
require_once('../app/ApplTimeList.php');
require_once('../app/PropertyList.php');
$timeList=new ApplTimeList();
$timeList->getAllFromDatabase();
$sphrList=new SphrofApplList();
$sphrList->getAllFromDatabase();
$propList=new PropertyList();
$propList->getAllFromDatabase();
$propArray=$propList->getAsAssocArray();
$a = new SunScreenList();
$item=null;
$itemProps=[];
$errorMessage = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['id']==""){
        $sunScreenid=$a->insertIntoDatabase(['vendor'=>$_POST['vendor'], 
        'name'=>$_POST['name'],
        'appltimeid'=>$_POST['applTimeid'],
        'sphrofapplid'=>$_POST['sphrofApplid'],  
        'price'=>$_POST['price']
        ]);
        if ($sunScreenid === false) {
            $errorMessage = "Помилка: Такий сонцезахисний засіб вже внесений в базу даних!";
            if(isset($_GET['search'])){
                 $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
            }else{
                 $a->getAllFromDatabase();
            }
        } else {
        for ($i=0;$i<count($propArray);$i++){
            if(isset($_POST['prop-'.$propArray[$i]['id']])){
                $a->addSunScreenProperty($sunScreenid,$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
            }
        } header('Location: SunScreens.php');}
    } else{
        $propArray=$propList->getAsAssocArray();
        $a->updateDatabaseById(['id'=>$_POST['id'],
        'vendor'=>$_POST['vendor'], 
        'name'=>$_POST['name'],
        'appltimeid'=>$_POST['applTimeid'],
        'sphrofapplid'=>$_POST['sphrofApplid'],   
        'price'=>$_POST['price']]);
        for ($i=0;$i<count($propArray);$i++){
            if(isset($_POST['prop-'.$propArray[$i]['id']])){
                $a->updateSunScreenProperty($_POST['id'],$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
            }
        }  header('Location: SunScreens.php');
    }
} else{
    if(isset($_GET['search'])){
        $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
    }else{
        $a->getAllFromDatabase();
    }
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        $a->deleteFromDatabaseById($_GET['id']);
        header('Location: SunScreens.php');
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $item=$a->getById($_GET['id']);
        $itemProps=$a->getSunScreenPropertiesById($_GET['id']);
    }
    
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Cонцезахисні засоби</title>
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
            <h1>Cонцезахисні засоби</h1>
            <div class="row">
                <div class="col-md-8">
                    <form method="GET">
                        <input type="text" required name="search" placeholder="Шукати"/>
                        <button type="submit" class="btn btn-primary">Пошук</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                                <th>Виробник</th>
                                <th>Час застосування</th>
                                <th>Сфера застосування</th>
                                <th>Ціна</th>
                                <th>Характеристики</th>
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
                            <input type="text" name="name" value="<?php echo $item?$item['name']:'';?>" class="form-control" placeholder="Назва" required/>
                        </p>
                        <p>
                            <input type="text" name="vendor" value="<?php echo $item?$item['vendor']:'';?>" class="form-control" placeholder="Виробник" required/>
                        </p>
                        <p>
                            <select name="applTimeid" class="form-select" placeholder="Час застосування" required><?php echo $timeList->getAsSelectOptions($item?$item['applTimeid']:'');?></select>
                        </p>
                        <p>
                            <select name="sphrofApplid" class="form-select" placeholder="Сфера застосування" required><?php echo $sphrList->getAsSelectOptions($item?$item['sphrofApplid']:'');?></select>
                        </p>
                        <p>
                            <input type="text" name="price" value="<?php echo $item?$item['price']:'';?>" class="form-control" placeholder="Ціна" required/>
                        </p>
                        <?php echo $propList->getAsInputGroup($itemProps); ?>
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