<?php
session_start();
require_once "header.php";  // 頁面的 header 部分
require_once "db.php"; // 資料庫連接設定

// 檢查是否已登入
if (!isset($_SESSION["account"])) {
    header("Location: login.php");
    exit;
}

// 檢查請求方法
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 取得表單資料
    $subject = $_POST['subject'] ?? '未填寫';
    $language = $_POST['language'] ?? '未填寫';
    $competitions = $_POST['competitions'] ?? '未填寫';
    $certifications = $_POST['certifications'] ?? '未填寫';

    // 處理檔案上傳
    $fileInfo = $_FILES['fileToUpload'] ?? null;
    $targetDir = "/var/www/html/uploads/";
    $uploadStatus = false;

    if ($fileInfo && $fileInfo['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($fileInfo['name']);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // 檢查檔案類型
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        if (in_array($fileType, $allowedTypes)) {
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            if (move_uploaded_file($fileInfo['tmp_name'], $targetFile)) {
                $uploadStatus = true;
            }
        }
    }

    // 儲存到資料庫
    if ($uploadStatus) {
        $userId = $_SESSION['account']; // 假設使用者的 ID 存在 session 中
        $filePath = "/uploads/" . $fileName;

        $stmt = $conn->prepare("
            INSERT INTO user_submissions (user_id, subject, language, competitions, certifications, file_path)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isssss", $userId, $subject, $language, $competitions, $certifications, $filePath);

        if ($stmt->execute()) {
            echo "<h2>檔案上傳成功</h2>";
            echo "<p>您的學習成果已成功儲存！</p>";
            echo "<p><a href='fileupload.php'>返回上傳頁面</a></p>";
        } else {
            echo "<h2>檔案上傳失敗</h2>";
            echo "<p>無法儲存資料到資料庫，請稍後再試。</p>";
        }
    } else {
        echo "<h2>檔案上傳失敗</h2>";
        echo "<p>檔案類型不支援或上傳過程出現問題。</p>";
    }
} else {
    header("Location: fileupload.php");
    exit;
}
?>
