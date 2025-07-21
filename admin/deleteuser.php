<?php
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';
if(isset($_GET['fid'])){
    $sql = "DELETE FROM `users` WHERE id=".$_GET['fid'];
    mysqli_query($conn,$sql);
    header("location:users.php");
}
?>