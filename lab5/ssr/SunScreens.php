<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/SunScreenList.php');
$a = new SunScreenList();
$a->readFromCSV('../data/SunScreens.csv');
function escapeJsonString($value) {
    # list from www.json.org: (\b backspace, \f formfeed)    
    $escapers =     array("\\",     "/",  "\n",  "\r",  "\t", "\x08", "\x0c","\'");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b","\\'");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }
$item=null;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['id']==""){
        $a->add(['vendor'=>$_POST['vendor'], 
        'name'=>$_POST['name'],
        'applTime'=>$_POST['applTime'], 
        'sphrofAppl'=>$_POST['sphrofAppl'], 
        'price'=>$_POST['price'],
        'properties'=>$_POST['properties']
    ]);
        $a->writeToCSV('../data/SunScreens.csv');
    } else{
        $a->update(['id'=>$_POST['id'],
        'vendor'=>$_POST['vendor'], 
        'name'=>$_POST['name'],
        'applTime'=>$_POST['applTime'],
        'sphrofAppl'=>$_POST['sphrofAppl'], 
        'price'=>$_POST['price'],
        'properties'=>$_POST['properties']]);
        $a->writeToCSV('../data/SunScreens.csv');
        header('Location: SunScreens.php');
    }
    
} else{
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        $a->delete($_GET['id']);
        $a->writeToCSV('../data/SunScreens.csv');
        header('Location: SunScreens.php');
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $item=$a->getById($_GET['id']);
    }
    
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Cонцезахисні засоби</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Виробник</th>
                                <th>Назва</th>
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
                        <p>
                            <input type="text" name="vendor" value="<?php echo $item?$item['vendor']:'';?>" class="form-control" placeholder="Виробник" required/>
                        </p>
                        <p>
                            <input type="text" name="name" value="<?php echo $item?$item['name']:'';?>" class="form-control" placeholder="Назва" required/>
                        </p>
                        <p>
                            <input type="text" name="applTime" value="<?php echo $item?$item['applTime']:'';?>" class="form-control" placeholder="Час застосування" required/>
                        </p>
                        <p>
                            <input type="text" name="sphrofAppl" value="<?php echo $item?$item['sphrofAppl']:'';?>" class="form-control" placeholder="Сфера застосування" required/>
                        </p>
                        <p>
                            <input type="text" name="price" value="<?php echo $item?$item['price']:'';?>" class="form-control" placeholder="Ціна" required/>
                        </p>
                        <p>
                            <input type="text" name="properties" value='<?php echo $item?escapeJsonString($item['properties']):'';?>' class="form-control" placeholder="Характеристики" required/>
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