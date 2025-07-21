<?php
include '../config.php';
session_start();

if (isset($_GET['approve'])) {
    $comment_id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE comments SET status='approved' WHERE id=$comment_id");
    header("Location: comments.php");
    exit;
}
if (isset($_GET['reject'])) {
    $comment_id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE comments SET status='rejected' WHERE id=$comment_id");
    header("Location: comments.php");
    exit;
}

$sql = "SELECT c.id, c.comment_text, c.created_at, c.status, 
               u.fname, u.lname, u.user, n.title AS news_title
        FROM comments c
        JOIN users u ON c.user_id = u.id
        JOIN news n ON c.news_id = n.id
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <link rel="stylesheet" href="../css/site1.css">
    <meta charset="UTF-8">
    <title>مدیریت دیدگاه‌ها</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            direction: rtl;
            padding: 20px;
            background-color: #f5f5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: right;
        }
        th {
            background-color: #eee;
        }
        .actions a {
            margin: 0 5px;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
        }
        .approve {
            background-color: #4CAF50;
            color: white;
        }
        .reject {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="topmenu">
        <div class="container">
            <ul>
                <li style="margin-top: 10px;"><a href="../index.php">مشاهده سایت</a></li>
                <li style="margin-top: 10px;"><a href="users.php">کاربران</a></li>
                <li style="margin-top: 10px;"><a href="cats.php">دسته بندی ها</a></li>
                <li style="margin-top: 10px;"><a href="comments.php">مدیریت دیدگاه‌ها</a></li>
                <li style="margin-top: 10px;"><a href="../logout.php">خروج از حساب</a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>

    <h2>مدیریت دیدگاه‌ها</h2>

    <table>
        <tr>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>نام کاربری</th>
            <th>خبر مربوطه</th>
            <th>متن دیدگاه</th>
            <th>تاریخ</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['fname']) ?></td>
            <td><?= htmlspecialchars($row['lname']) ?></td>
            <td><?= htmlspecialchars($row['user']) ?></td>
            <td><?= htmlspecialchars($row['news_title']) ?></td>
            <td><?= htmlspecialchars($row['comment_text']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td class="actions">
                <?php if ($row['status'] !== 'approved'): ?>
                    <a class="approve" href="?approve=<?= $row['id'] ?>">تأیید</a>
                <?php endif; ?>
                <?php if ($row['status'] !== 'rejected'): ?>
                    <a class="reject" href="?reject=<?= $row['id'] ?>">رد</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>