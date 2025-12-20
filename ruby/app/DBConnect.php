<?php
$servername = "localhost";
$username = "root";
$password = "aaaa2006aaaa";
$database ='db_sunscreen';
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>