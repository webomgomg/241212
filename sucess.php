<?php
require_once 'header.php';
require_once 'db.php';

$sql = "SELECT a.title, r.reviewer, r.rating, r.comment, r.created_at 
        FROM reviews r 
        JOIN achievements a ON r.achievement_id = a.id 
        ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $sql);

mysqli_query($conn, $sql)：
使用 $conn 資料庫連線執行 $sql 查詢。
查詢結果存入 $result 變數。
$result：是 mysqli_query 返回的物件，用於存取查詢結果。


if (!$result) {
    die("查詢失敗：" . mysqli_error($conn));
}
檢查查詢結果是否成功：
如果 $result 為 false，表示查詢失敗。
die()：
終止程式執行並輸出錯誤訊息。
mysqli_error($conn)：返回資料庫的具體錯誤訊息，幫助開發者調試。




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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    從資料庫查詢結果中取得一列資料的函式。
                    這個函式會將資料列的每一個欄位名稱作為鍵，並將對應的值組成一個關聯陣列返回。

                    $result: 這是由 mysqli_query() 或其他類似函式返回的查詢結果。
                    每次調用 mysqli_fetch_assoc，會返回查詢結果中的下一列資料。
                    如果已經取到最後一列，則會返回 false。
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['reviewer']) ?></td>
                    <td><?= htmlspecialchars($row['rating']) ?> 星</td>
                    <td><?= htmlspecialchars($row['comment']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
                <?php endwhile; ?>
                while ($row = mysqli_fetch_assoc($result))：
                mysqli_fetch_assoc：從 $result 提取一行資料，並以關聯陣列形式返回。
                每次執行迴圈時，$row 會包含一筆記錄。
                當資料讀取完成時，mysqli_fetch_assoc 返回 false，迴圈結束。
                htmlspecialchars：
                防止 XSS 攻擊，將特殊字元（如 < 和 >）轉換為 HTML 實體，避免執行惡意腳本。
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
mysqli_free_result($result)：
釋放 $result 所占用的記憶體，優化資源使用。
mysqli_close($conn)：
關閉資料庫連線 $conn，釋放與資料庫的連結。
 