<?php
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';
?>
<html>
<head>
    <title>کاربران</title>
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
            <li style="margin-top: 10px;"><a href="index.php">خبرها</a></li>
            <li style="margin-top: 10px;"><a href="cats.php"> دسته بندی ها</a></li>
            <li style="margin-top: 10px;"><a href="../logout.php">خروج از حساب</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <br>
            <h1 style="color: black; text-align: center">همه ی ادمین ها</h1>
            <table border="1" align="center" style="margin: 20px auto">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>نام کاربری</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['user']; ?></td>
                        <td><a href="edituser.php?fid=<?php echo $row['id']; ?>" class="fa fa-edit"></a></td>
                        <td><a href="deleteuser.php?fid=<?php echo $row['id']; ?>" class="fa fa-remove"></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <br>
        </div>
    </div>
</div>
</body>
