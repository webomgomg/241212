<?php
session_start();
require_once "header.php";
require_once 'db.php';

if (!isset($_SESSION["account"])) {
    header("Location: login.php");
    exit();
}

$account = $_SESSION["account"]; // 取得登入使用者的帳號
$role = ""; // 初始化角色變數

// 從資料庫中查詢對應帳號的角色
$sql_role = "SELECT role FROM user WHERE account = ?";
$stmt_role = mysqli_prepare($conn, $sql_role);
mysqli_stmt_bind_param($stmt_role, "s", $account);
mysqli_stmt_execute($stmt_role);
mysqli_stmt_bind_result($stmt_role, $role);
mysqli_stmt_fetch($stmt_role);
mysqli_stmt_close($stmt_role);

$msg = ""; // 初始化錯誤訊息變數

try {
    $order = $_POST["order"] ?? "";
    $searchtxt = $_POST["searchtxt"] ?? "";
    $searchtxt = mysqli_real_escape_string($conn, $searchtxt);
    $start_date = $_POST["start_date"] ?? "";
    $end_date = $_POST["end_date"] ?? "";

    // 檢查開始日期是否晚於結束日期
    if ($start_date && $end_date && $start_date > $end_date) {
        $msg = "警告：開始日期不能晚於結束日期！";
    } else {
        $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbname);

        $condition = "";

        if ($searchtxt) {
            $condition .= " WHERE (company LIKE '%$searchtxt%' OR content LIKE '%$searchtxt%')";
        }

        if ($start_date) {
            $condition .= $condition ? " AND pdate >= '$start_date'" : " WHERE pdate >= '$start_date'";
        }

        if ($end_date) {
            $condition .= $condition ? " AND pdate <= '$end_date'" : " WHERE pdate <= '$end_date'";
        }

        $order_by = "";
        if ($order) {
            $order_by = " ORDER BY " . mysqli_real_escape_string($conn, $order);
        }

        // 執行查詢
        if (!$msg) {
            $sql = "SELECT * FROM job $condition $order_by";
            $result = mysqli_query($conn, $sql);
        }
    }
?>
    <!-- 如果 role 是 "M"，顯示插入按鈕 -->
    <?php if ($role === "M"): ?>
        <a href="insert.php" class="btn btn-primary position-fixed bottom-0 end-0">+</a>
    <?php endif; ?>

    <div class="container">
        <form action="query.php" method="post">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <select name="order" class="form-select" aria-label="選擇排序欄位">
                        <option value="" <?= ($order == '') ? 'selected' : '' ?>>選擇排序欄位</option>
                        <option value="company" <?= ($order == "company") ? "selected" : "" ?>>求才廠商</option>
                        <option value="content" <?= ($order == "content") ? "selected" : "" ?>>求才內容</option>
                        <option value="pdate" <?= ($order == "pdate") ? "selected" : "" ?>>刊登日期</option>
                    </select>
                </div>
                <div class="col-auto">
                    <input placeholder="搜尋廠商及內容" class="form-control" type="text" name="searchtxt" value="<?= htmlspecialchars($searchtxt) ?>">
                </div>
                <div class="col-auto">
                    <label for="start_date" class="col-form-label">開始日期</label>
                </div>
                <div class="col-auto">
                    <input id="start_date" class="form-control" type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                </div>
                <div class="col-auto">
                    <label for="end_date" class="col-form-label">結束日期</label>
                </div>
                <div class="col-auto">
                    <input id="end_date" class="form-control" type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                </div>
                <div class="col-auto">
                    <input class="btn btn-primary" type="submit" value="搜尋">
                </div>
            </div>
        </form>

        <?php if ($msg): ?>
            <div class="alert alert-warning" role="alert">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <?php if (!$msg && isset($result)): ?>
        <div class="container">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>編號</td>
                    <td>求才廠商</td>
                    <td>求才內容</td>
                    <td>刊登日期</td>
                    <?php if ($role === "M"): ?>
                        <td>操作</td>
                    <?php endif; ?>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row["postid"] ?></td>
                        <td><?= $row["company"] ?></td>
                        <td><?= $row["content"] ?></td>
                        <td><?= $row["pdate"] ?></td>
                        <?php if ($role === "M"): ?>
                            <td>
                                <a href="update.php?postid=<?= $row["postid"] ?>" class="btn btn-primary">修改</a>
                                <a href="delete.php?postid=<?= $row["postid"] ?>" class="btn btn-danger">刪除</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php endif; ?>
    </div>

<?php
    if (isset($conn)) {
        mysqli_close($conn);
    }
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
?>