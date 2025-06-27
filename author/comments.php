<?php
include '../config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['userid'];

if (isset($_GET['delete'])) {
    $comment_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM comments WHERE id = $comment_id AND user_id = $userId");
    header("Location: comments.php");
    exit;
}

if (isset($_POST['edit_comment'])) {
    $comment_id = intval($_POST['comment_id']);
    $new_text = mysqli_real_escape_string($conn, $_POST['new_text']);

    mysqli_query($conn, "UPDATE comments SET comment_text='$new_text', status='pending' WHERE id=$comment_id AND user_id=$userId");
    header("Location: comments.php");
    exit;
}

$sql = "SELECT c.id, c.comment_text, c.created_at, c.status, n.title AS news_title
        FROM comments c
        JOIN news n ON c.news_id = n.id
        WHERE c.user_id = $userId
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>دیدگاه‌های من</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            direction: rtl;
            background-color: #f5f5f5;
            padding: 20px;
        }
        nav {
            background-color: #333;
            padding: 10px;
            margin-bottom: 20px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }
        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: right;
        }
        th {
            background-color: #eee;
        }
        .actions a, .actions form {
            display: inline-block;
            margin: 0 5px;
        }
        .edit-btn, .delete-btn {
            background-color: #2196F3;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .status {
            font-weight: bold;
        }
        .approved { color: green; }
        .pending { color: orange; }
        .rejected { color: red; }
    </style>
</head>
<body>

<nav>
    <a href="../index.php">بازگشت به سایت</a>
    <a href="index.php">پنل نویسنده</a>
    <a href="../logout.php">خروج</a>
</nav>

<h2>دیدگاه‌های من</h2>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p>شما هنوز هیچ دیدگاهی ثبت نکرده‌اید.</p>
<?php else: ?>
    <table>
        <tr>
            <th>خبر</th>
            <th>دیدگاه</th>
            <th>تاریخ</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['news_title']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['comment_text'])) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td class="status <?= $row['status'] ?>">
                    <?= $row['status'] == 'pending' ? 'در انتظار تأیید' : ($row['status'] == 'approved' ? 'تأیید شده' : 'رد شده') ?>
                </td>
                <td class="actions">
                    <a class="delete-btn" href="?delete=<?= $row['id'] ?>" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                    
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="comment_id" value="<?= $row['id'] ?>">
                        <input type="text" name="new_text" value="<?= htmlspecialchars($row['comment_text']) ?>" required>
                        <button class="edit-btn" type="submit" name="edit_comment">ویرایش</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

</body>
</html>
