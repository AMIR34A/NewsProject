<?php
date_default_timezone_set('Asia/Tehran');
session_start();
if(!isset($_SESSION['islogin'])){
    header("location:../login.php");
}
include '../config.php';

if (isset($_POST['sabt']))
{
    $userid = $_SESSION['userid'];
    $title = $_POST['title'];
    $matn = $_POST['matn'];
    $catid = $_POST['catid'];
    
    if((isset($_FILES["image"])) && ($_FILES["image"]["size"] > 0)) {
        $imgSize = $_FILES["image"]["size"];
        $imgType = $_FILES["image"]["type"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $fp = fopen($tmpName, 'r');
        $image = fread($fp, filesize($tmpName));

        $catid = mysqli_real_escape_string($conn, $_POST['catid']);
        $matn = mysqli_real_escape_string($conn, $_POST['matn']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $image = mysqli_real_escape_string($conn, $image);

        fclose($fp);
    }

    $date = $_POST['date'];
    $query = "INSERT INTO `news` (`title`,`matn`,`date`,`catid`,`pic`,`userid`, `status`) VALUES ('$title','$matn','$date','$catid','$image','$userid', 'pending')";
    mysqli_query($conn, $query);
}
?>
<html>
<head>
    <title>خبرها</title>
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
        <ul>
            <li style="margin-top: 10px;"><a href="../index.php">مشاهده سایت</a></li>
            <li style="margin-top: 10px;"><a href="../logout.php">خروج از حساب</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <br>
            <h3 style="text-align: center"> فرم افزودن خبر</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <input style="margin: 15px auto" name="title" type="text"  placeholder="تیتر خبر"/>
                <textarea style="margin: 15px auto;height: 80px" name="matn" type="text" placeholder="متن خبر"></textarea>
                <select name="catid" style="margin: 15px auto;width: 200px;margin-right: 388px">
                    <?php
                    $sql = "select * from cats";
                    $res = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_assoc($res)){
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php } ?>
                </select>
                <input name="image" type="file" style="margin: 15px auto">
                <input type="date" name="date" style="margin: 15px auto"/>
                <input type="submit" name="sabt" value="ثبت خبر" id="btn-send" style="margin: 15px auto"/>
            </form>
            <br>
        </div>
    </div>
</div>

<div class="container">
    <div class="tilearea" style="background: white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) ">
        <div  class="contact-left">
            <br>
            <h1 style="color: black; text-align: center">خبرهای من</h1>
            <table border="1" align="center" style="margin: 20px auto">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>تایتل خبر</th>
                    <th>متن خبر</th>
                    <th>تاریخ درج</th>
                    <th>دسته بندی</th>
                    <th>تصویر</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $userid = $_SESSION['userid'];
                $sql = "SELECT * FROM news WHERE userid = $userid ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)){
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['matn']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td>
                            <?php
                            $id = isset($row['catid']) ? (int)$row['catid'] : 0;
                            $q = "SELECT * FROM cats WHERE id = $id";
                            $r = mysqli_query($conn,$q);
                            $ro = mysqli_fetch_assoc($r);
                            echo $ro['name'];
                            ?>
                        </td>
                        <td><img width="80" height="80" src="data:image/jpeg;base64,<?php echo base64_encode($row['pic']); ?>"></td>
                        <td><a href="edit.php?fid=<?php echo $row['id']; ?>" class="fa fa-edit"></a></td>
                        <td><a href="delete.php?fid=<?php echo $row['id']; ?>" class="fa fa-remove"></a></td>
                    </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='8'>خبری از سمت شما وارد نشده.</td></tr>";
                }
                ?>
                </tbody>
            </table>
            <br>
        </div>
    </div>
</div>
</body>
</html>