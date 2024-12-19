<?php
require_once "header.php";
require_once 'db.php';

$msg = $_GET["msg"] ?? "";


if ($_POST) {
    $account = $_POST["account"] ?? "";
    $password = $_POST["password"] ?? "";

    
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(edu(\.tw)?)$/", $account)) {
        header("Location: login.php?msg=請輸入有效的教育信箱 (xxx.edu)");
        exit;
    }

    
    $sql_check = "SELECT * FROM user WHERE account = ?";
    $stmt = mysqli_prepare($conn, $sql_check);

    if ($stmt === false) {
        die("MySQL prepare statement failed");
    }

    mysqli_stmt_bind_param($stmt, "s", $account);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    
    if (!$user) {
        header("Location: login.php?msg=此信箱尚未註冊");
        exit;
    }

    
    if ($user["password"] === $password) {
        session_start();
        $_SESSION["account"] = $user["account"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["name"] = $user["name"];

        header("Location: conference.php");
        exit;
    } else {
        header("Location: login.php?msg=帳號或密碼錯誤");
        exit;
    }
}
?>

<?php require_once "header.php"; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>登入系統</h3>
        </div>
        <div class="card-body">
            <form action="login.php" method="post">
                <div class="mb-3">
                    <input placeholder="帳號 (教育信箱)" class="form-control" type="text" name="account" required><br>
                </div>
                <div class="mb-3">
                    <input placeholder="密碼" class="form-control" type="password" name="password" required><br>
                </div>
                <div class="mb-3">
                    <input class="btn btn-primary" type="submit" value="登入">
                    <a href="register.php" class="btn btn-secondary">註冊</a>
                </div>
                <div class="text-danger mt-2"><?= htmlspecialchars($msg) ?></div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>
