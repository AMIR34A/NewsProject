<?php
$serverip="localhost";
$dbname="tajnews";
$username="root";
$password="";
$conn = mysqli_connect($serverip,$username,$password,$dbname);
mysqli_query($conn,"SET NAMES 'utf8'");
mysqli_query($conn,"SET CHARACTER SET 'utf8'");
mysqli_query($conn,"SET character_set_connection = 'utf8'");
?>