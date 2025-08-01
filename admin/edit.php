﻿<?php
date_default_timezone_set('Asia/Tehran');
session_start();
if (!isset($_SESSION['islogin'])) {
    header("location:../login.php");
    exit();
}
include '../config.php';

if (isset($_POST['sabt'])) {
    $userid = $_SESSION['userid'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $matn = mysqli_real_escape_string($conn, $_POST['matn']);
    $catid = mysqli_real_escape_string($conn, $_POST['catid']);

    if ((isset($_FILES["image"])) && ($_FILES["image"]["size"] > 0)) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $fp = fopen($tmpName, 'r');
        $image = fread($fp, filesize($tmpName));
        $image = mysqli_real_escape_string($conn, $image);
        fclose($fp);
        $img_sql = ", `pic`='$image'";
    } else {
        $img_sql = "";
    }

    $date = $_POST['date'];
    $query = "UPDATE `news` SET `title`= '$title', `matn`='$matn', `status`='pending', `date`='$date', `catid`='$catid' $img_sql WHERE id=" . intval($_GET['fid']);
    mysqli_query($conn, $query);
}

$t='';
$m='';
if(isset($_GET['fid'])){ 
    $fid = intval($_GET['fid']);
    $sql = "SELECT * FROM `news` WHERE id=".$_GET['fid'];
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $t = $row['title'];
    $m = $row['matn'];
}
?>
<html>
<head>
    <title>ویرایش خبر</title>
    <link rel="stylesheet" href="../css/site1.css">
    <meta charset="utf-8">
    <link href="../ax/khabar1.png" rel="icon">
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
            <h3 style="text-align: center"> فرم ویرایش خبر</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <input style="margin: 15px auto" name="title" type="text" value="<?php echo $t; ?>" placeholder="تیتر خبر"/>
                <textarea style="margin: 15px auto;height: 80px" name="matn" type="text" placeholder="متن خبر"><?php echo $m; ?></textarea>
                <select name="catid" style="margin: 15px auto;width: 200px;margin-right: 388px">
                    <?php
                    $sql = "select * from cats";
                    $res = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_assoc($res)){

                        ?>
                        <option style="margin: 15px auto" value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php } ?>
                </select>
                <input style="margin: 15px auto" name="image" type="file">
                <input type="date" name="date" style="margin: 15px auto"/>
                <input style="margin: 15px auto" type="submit" name="sabt" value="ویرایش خبر" id="btn-send"/>
            </form>
            <br>
        </div>
    </div>
</div>
</body>
</html>