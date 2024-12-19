<?php
require_once 'header.php';
require_once 'db.php';

$sql = "SELECT * FROM achievements ORDER BY created_at DESC";
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
    <title>學習成果查看</title>
    <!-- 引入 Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
     
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">學習成果列表</h1>
        <table class="table table-bordered table-striped table-hover">
            <thead class="">
                <tr>
                    <th>學生 ID</th>
                    <th>分類</th>
                    <th>標題</th>
                    <th>描述</th>
                    <th>新增時間</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= ($row['student_id']) ?></td>
                    <td><?= ($row['category']) ?></td>
                    <td><?= ($row['title']) ?></td>
                    <td><?= ($row['description']) ?></td>
                    <td><?= ($row['created_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <a href="upload_achievement.php" class="btn btn-primary floating-button">
        上傳學習成果
    </a>

    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

mysqli_free_result($result);
mysqli_close($conn);
?>
