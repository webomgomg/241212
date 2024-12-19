<?php
session_start();
require_once "header.php";  // 頁面的 header 部分
require_once "db.php";      // 資料庫連接設定

// 檢查是否已登入
if (!isset($_SESSION["account"])) {
    header("Location: login.php?msg=請先登入");
    exit;
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>上傳學習成果</h2>
    <form action="fileupload_process.php" method="post" enctype="multipart/form-data">
        <!-- 最擅長科目 -->
        <div class="form-group">
            <label for="subject">最擅長科目：</label>
            <input type="text" class="form-control" name="subject" id="subject" placeholder="請填寫您最擅長的科目" required>
        </div>
        
        <!-- 程式語言 -->
        <div class="form-group">
            <label for="language">最擅長程式語言：</label>
            <input type="text" class="form-control" name="language" id="language" placeholder="請填寫您最擅長的程式語言" required>
        </div>
        
        <!-- 參與過的競賽 -->
        <div class="form-group">
            <label for="competitions">參與過的競賽：</label>
            <textarea class="form-control" name="competitions" id="competitions" rows="3" placeholder="請列出您參與過的競賽，一個行一項" required></textarea>
        </div>
        
        <!-- 取得的證照 -->
        <div class="form-group">
            <label for="certifications">取得的證照：</label>
            <textarea class="form-control" name="certifications" id="certifications" rows="3" placeholder="請列出您取得的證照，一個行一項" required></textarea>
        </div>
        
        <!-- 檔案上傳 -->
        <div class="form-group">
            <label for="fileToUpload">上傳學習成果檔案：</label>
            <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" required>
            <small class="form-text text-muted">支援檔案類型：jpg, jpeg, png, pdf, docx。</small>
        </div>
        
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
</div>
</body>
</html>
