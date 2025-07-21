<?php
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';
if(isset($_GET['fid'])){
    $sql = "DELETE FROM `cats` WHERE id=".$_GET['fid'];
    mysqli_query($conn,$sql);
    header("location:cats.php");
}
?>