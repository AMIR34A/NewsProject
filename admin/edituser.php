<?php
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';

if (isset($_POST['sabt']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $query = "UPDATE `users` SET `fname`= '$fname', `lname`='$lname' , `email`='$email' , `user`='$user' , `pass`='$pass' WHERE id=".$_GET['fid'];
    mysqli_query($conn , $query);
}

if(isset($_GET['fid'])){
    $sql = "SELECT * FROM `users` WHERE id=".$_GET['fid'];
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
}
?>
<html>
<head>
    <title>ویرایش کاربر</title>
    <link rel="stylesheet" href="../css/site1.css">
    <meta charset="utf-8">
    <link href="../ax/2.png" rel="icon">
    <meta name="keywords" content="خبر، اخبار فوری، اقتصادی، سیاسی، ورزشی، هنری، حوادث">
    <meta name="description" content="وبسایت تاج نیوز: درج جدیدترین اخبار در حوزه های مختلف ">
    <meta name="author" content="H.Ebrahimi">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/owl.carousel.css">
    <link rel="stylesheet" href="../css/owl.theme.css">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css">
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/fs.js"></script>
    <style>
        thead {color: #803f1e;font-weight: bold;font-size: 15px;text-align: center}
        tbody {color:black;font-size: 15px;text-align: center;}
        tbody,tr,td{padding: 10px;} 
    </style>
</head>
<body >
<div class="topmenu">
    <div class="container">
        <div class="socialicons fbicon">
            <img src="../ax/tajnews2.png" width="158" height="58" alt="خبر">
        </div>
        <ul>
            <li style="margin-top: 10px;"><a href="../index.php">مشاهده سایت</a></li>
            <li style="margin-top: 10px;"><a href="users.php">کاربران</a></li>
            <li style="margin-top: 10px;"><a href="index.php">خبرها</a></li>
            <li style="margin-top: 10px;"><a href="cats.php">دسته بندی ها</a></li>
            <li style="margin-top: 10px;"><a href="../logout.php">خروج از حساب</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <br>
            <h3 style="text-align: center"> فرم ویرایش کاربر</h3>
            <form action="" method="post">
                <input style="margin: 15px auto" name="fname" type="text" value="<?php echo $row['fname']; ?>" placeholder="نام شما"/>
                <input style="margin: 15px auto" name="lname" type="text" value="<?php echo $row['lname']; ?>" placeholder="نام خانوادگی"/>
                <input style="margin: 15px auto" name="email" type="text" value="<?php echo $row['email']; ?>" dir="ltr" placeholder="email..."/>
                <input style="margin: 15px auto" name="user" type="text" <?php echo $row['user']; ?> dir="ltr" placeholder="username..."/>
                <input style="margin: 15px auto" name="pass" type="password" <?php echo $row['pass']; ?> dir="ltr" placeholder="password..."/>
                <input style="margin: 15px auto" type="submit" name="sabt" value="ویرایش کاربر" id="btn-send"/>
            </form>
            <br>
        </div>
    </div>
</div>
</body>
</html>