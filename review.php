<?php
require_once 'header.php';
require_once 'db.php';

// 提交評價邏輯
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $achievement_id = $_POST['achievement_id'];
    $reviewer = $_POST['reviewer'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // 檢查學習成果 ID 是否存在
    $sql_check = "SELECT id FROM achievements WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 'i', $achievement_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // 學習成果存在，可以提交評價
        $sql = "INSERT INTO reviews (achievement_id, reviewer, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'isis', $achievement_id, $reviewer, $rating, $comment);

        if (mysqli_stmt_execute($stmt)) {
            // 提交成功後跳轉到 view_reviews.php
            header("Location: view_reviews.php");
            exit; // 確保跳轉後不再執行後續代碼
        } else {
            echo "評價提交失敗：" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "指定的學習成果 ID 不存在，請檢查！";
    }

    mysqli_stmt_close($stmt_check);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提交評價</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">提交評價</h1>
        <form action="review.php" method="post">
            <div class="mb-3">
                <label for="achievement_id" class="form-label">學習成果 ID</label>
                <input type="number" name="achievement_id" id="achievement_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="reviewer" class="form-label">評價者姓名</label>
                <input type="text" name="reviewer" id="reviewer" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">評分 (1-5)</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="1">1 星</option>
                    <option value="2">2 星</option>
                    <option value="3">3 星</option>
                    <option value="4">4 星</option>
                    <option value="5">5 星</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">文字評價</label>
                <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">提交評價</button>
        </form>
    </div>
</body>
</html>
