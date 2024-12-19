<?php
require_once 'header.php';
require_once 'db.php';

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $progress = $_POST['progress'];

    // 準備 SQL 查詢
    $sql = "INSERT INTO achievements (student_id, category, title, description, progress, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issss', $student_id, $category, $title, $description, $progress);

    if (mysqli_stmt_execute($stmt)) {
        // 提交成功後跳轉到 view.php
        header("Location: view.php");
        exit; // 確保跳轉後不再執行後續代碼
    } else {
        echo "<div class='alert alert-danger'>上傳失敗：" . mysqli_error($conn) . "</div>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>上傳學習成果</title>
    <!-- 引入 Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">上傳學習成果</h1>
        <form action="upload_achievement.php" method="post">
            <div class="mb-3">
                <label for="student_id" class="form-label">學生 ID</label>
                <input type="number" name="student_id" id="student_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">分類</label>
                <input type="text" name="category" id="category" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">標題</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">描述</label>
                <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="progress" class="form-label">進度</label>
                <input type="text" name="progress" id="progress" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">提交成果</button>
        </form>
    </div>
    
    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
