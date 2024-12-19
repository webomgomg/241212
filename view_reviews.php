<?php
require_once 'header.php';
require_once 'db.php';

$sql = "SELECT a.title, r.reviewer, r.rating, r.comment, r.created_at 
        FROM reviews r 
        JOIN achievements a ON r.achievement_id = a.id 
        ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("查詢失敗：" . mysqli_error($conn));
}


?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>評價列表</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        .fixed-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">評價列表</h1>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>學習成果</th>
                    <th>評價者</th>
                    <th>評分</th>
                    <th>評價內容</th>
                    <th>提交時間</th>
                </tr>
            </thead>
            <tbody> 
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['reviewer']) ?></td>
                    <td><?= htmlspecialchars($row['rating']) ?> 星</td>
                    <td><?= htmlspecialchars($row['comment']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    
    <a href="review.php" class="btn btn-primary fixed-button">新增評價</a>

</body>
</html>




<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
