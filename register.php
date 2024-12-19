<?php
require_once "header.php";
require_once 'db.php';

$msg = "";

if ($_POST) {
  
    $name = $_POST["name"];
    $account = $_POST["account"];
    $password = $_POST["password"];
    $school = $_POST["school"];
    $department = $_POST["department"];
    $level = $_POST["level"];

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(edu(\.tw)?)$/", $account)) {
        $msg = "帳號必須是教育信箱(.edu)。";
    } else {
       
        $check_sql = "SELECT * FROM user WHERE account = ?";
        $stmt_check = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_check, $check_sql)) {
            $msg = "資料庫錯誤：無法準備查詢語句。";
        } else {
            mysqli_stmt_bind_param($stmt_check, "s", $account);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
    
            if (mysqli_num_rows($result_check) > 0) {
             
                $msg = "此帳號已經註冊過";
            } else {
                // 插入資料
                $sql = "INSERT INTO user (name, account, password, school, department, level) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    $msg = "資料庫錯誤：無法準備插入語句。錯誤資訊：" . mysqli_error($conn);
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssss", $name, $account, $password, $school, $department, $level);
                    if (mysqli_stmt_execute($stmt)) {
                        // 註冊成功後顯示訊息並重定向到登入頁面
                        $msg = "註冊成功！請登入。";
                        header('Location: login.php?msg=' . urlencode($msg));
                        exit;
                    } else {
                        $msg = "註冊失敗，請稍後再試。錯誤資訊：" . mysqli_error($conn);
                    }
                }
            }
        }
    }
}    
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>註冊新帳號</h3>
        </div>
        <div class="card-body">
            <form action="register.php" method="post">
                <div class="form-group">
                    <input placeholder="姓名" class="form-control" type="text" name="name" required><br>
                </div>
                <div class="form-group">
                    <input placeholder="帳號" class="form-control" type="email" name="account" required><br>
                </div>
                <div class="form-group">
                    <input placeholder="密碼" class="form-control" type="password" name="password" required><br>
                </div>
                <div class="form-group">
                    <select name="school" class="form-control" required>
                        <option value="">選擇學校</option>
                        <option value="國立台灣大學">國立台灣大學</option>
                        <option value="國立交通大學">國立交通大學</option>
                        <option value="國立清華大學">國立清華大學</option>
                        <option value="國防醫學院">國防醫學院</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <select name="department" class="form-control" required>
                        <option value="">選擇系所</option>
                        <option value="資訊科學">資訊科學</option>
                        <option value="電機工程">電機工程</option>
                        <option value="生物醫學">生物醫學</option>
                        <option value="化學工程">化學工程</option>
                        <option value="機械工程">機械工程</option>
                        <option value="財務金融">財務金融</option>
                        <option value="醫學科學">醫學科學</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <select name="level" class="form-control" required>
                        <option value="">選擇年級</option>
                        <option value="一年級">一年級</option>
                        <option value="二年級">二年級</option>
                        <option value="三年級">三年級</option>
                        <option value="四年級">四年級</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="註冊">
                </div>
                <p style="color:red;"><?= $msg ?></p>
            </form>
        </div>
    </div>
</div>
