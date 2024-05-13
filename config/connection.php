<?php 

$host = "localhost";
$user = "root";
$pass = "";
$database = "admin";

$conn = new mysqli($host, $user, $pass, $database);

if($conn->connect_error){
    die("Error : ".$conn->connect_error);
}