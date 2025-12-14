<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/SunScreenList.php');
require_once('./app/PropertyList.php');
require_once('./app/SphrofApplList.php');
require_once('./app/ApplTimeList.php');
$servername = "localhost";
$username = "root";
$password = "andrew2006";
$database ='db_sunscreen';
$a=new ApplTimeList();
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM applstime";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $a->add($row);
  }
  $a->display();
} else {
  echo "0 results";
}
$conn->close();
?>