<?php
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';

if (isset($_POST['sabt']))
{
    $name = $_POST['name'];
    if(!isset($_GET['fid'])){
        $query = "INSERT INTO `cats` (`name`) VALUES ('$name')";
    }else{
        $query = "UPDATE `cats` SET `name`='$name' where id=".$_GET['fid'];
    }
    mysqli_query($conn , $query);
header("location:cats.php");
}
?>
<html>
<head>
    <title>دسته بندی ها</title>
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
            <li style="margin-top: 10px;"><a href="index.php">خبرها</a></li>
            <li style="margin-top: 10px;"><a href="users.php">کاربران</a></li>
            <li style="margin-top: 10px;"><a href="../logout.php">خروج از حساب</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<?php
$catname = '';
if (isset($_GET['fid'])) {
    $sql = "SELECT * FROM cats where id=".$_GET['fid'];
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $catname = $row['name'];
}
?>
<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <h3 style="text-align: center"> فرم افزودن دسته بندی</h3>

            <form action="" method="post">
                <input style="margin: 15px auto" name="name" type="text" value="<?php echo $catname; ?>"  placeholder="نام دسته بندی"/>
                <input style="margin: 15px auto" type="submit" name="sabt" value="ثبت دسته" id="btn-send"/>
            </form>
            <br>
        </div>
    </div>
</div>

<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <h1 style="color: black; text-align: center">همه ی دسته بندی ها</h1>
            <table border="1" align="center" style="margin: 20px auto">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام دسته بندی</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM cats";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><a href="cats.php?fid=<?php echo $row['id']; ?>" class="fa fa-edit"></a></td>
                        <td><a href="deletecat.php?fid=<?php echo $row['id']; ?>" class="fa fa-remove"></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
