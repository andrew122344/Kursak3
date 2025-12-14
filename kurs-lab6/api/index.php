<?php
$path= $_SERVER['REQUEST_URI'];
if(str_contains($path, 'ApplsTime')){
    require_once('./ApplsTime.php');
} else if(str_contains($path, 'SphrsofAppl')){
    require_once('./SphrsofAppl.php');
} else if(str_contains($path, 'Properties')){
    require_once('./Properties.php');
} else if(str_contains($path, 'SunScreens')){
    require_once('./SunScreens.php');
} else if(str_contains($path, 'Profile')){
    require_once('./Profile.php');
} else{
    echo "Invalid route";
}
?>