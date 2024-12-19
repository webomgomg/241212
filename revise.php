<?php
session_start();
require_once "header.php";  
require_once "db.php";      


if (!isset($_SESSION["account"])) {
    header("Location: login.php?msg=請先登入");
    exit;
}

$account = $_SESSION["account"];
$msg = $_GET["msg"] ?? "";


$sql = "SELECT * FROM user WHERE account = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $account);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST["name"] ?? $user["name"];
    $new_account = $_POST["account"] ?? $account;
    $email = $_POST["email"] ?? $user["email"];
    $school = $_POST["school"] ?? $user["school"];
    $department = $_POST["department"] ?? $user["department"];
    $level = $_POST["level"] ?? $user["level"];
    $profile_picture = $user['profile_picture']; 

   
    if ($new_account !== $account) {
        $sql_check_account = "SELECT * FROM user WHERE account = ?";
        $stmt_check_account = mysqli_prepare($conn, $sql_check_account);
        mysqli_stmt_bind_param($stmt_check_account, "s", $new_account);
        mysqli_stmt_execute($stmt_check_account);
        $result_check = mysqli_stmt_get_result($stmt_check_account);

        if (mysqli_num_rows($result_check) > 0) {
            $msg = "帳號已存在，請選擇其他帳號";
            header("Location: revise.php?msg=" . urlencode($msg));
            exit;
        }
    }

    
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_pictures/';
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $picname = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . $picname;

        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $profile_picture = $target_file;
        } else {
            $msg = "大頭貼上傳失敗";
            header("Location: revise.php?msg=" . urlencode($msg));
            exit;
        }
    }

   
    $sql_update = "UPDATE user 
                   SET name = ?, account = ?, email = ?, school = ?, department = ?, level = ?, profile_picture = ? 
                   WHERE account = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    if ($stmt_update) {
        mysqli_stmt_bind_param($stmt_update, "ssssssss", $name, $new_account, $email, $school, $department, $level, $profile_picture, $account);
        mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) > 0) {
            $msg = "資料更新成功";
            header("Location:conference.php?msg=" . urlencode($msg));  // 成功跳轉到 profile.php
            exit;
        } else {
            $msg = "資料更新失敗或未修改";
            header("Location: revise.php?msg=" . urlencode($msg));
            exit;
        }
    } else {
        $msg = "資料庫錯誤：" . mysqli_error($conn);
        header("Location: revise.php?msg=" . urlencode($msg));
        exit;
    }
}
?>



<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>更新個人資料</h3>
        </div>
        <div class="card-body">
        <form action="revise.php" method="post" enctype="multipart/form-data">
        <div class="row">
           
           <div class="col-md-3">
    <div class="form-group text-center">
        
        <?php 
        $default_picture = 'images.jpg'; 
        $profile_picture = $user['profile_picture'] && file_exists($user['profile_picture']) 
                           ? htmlspecialchars($user['profile_picture']) 
                           : $default_picture;
        ?>
        <img src="<?= $profile_picture ?>" alt="Profile Picture" class="img-thumbnail mt-2" width="150">

        <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*">
        <label for="profile_picture" class="btn btn-custom mt-2">上傳頭貼</label>
    </div>
</div>




          
            <div class="col-md-9">
                <div class="form-group">
                <label for="name">姓名：</label>
                    <input placeholder="姓名" class="form-control" type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>
                </div>
                
                <input type="hidden" name="account" value="<?= htmlspecialchars($user['account']) ?>">

                <div class="form-group">
                    <label for="school">學校名稱：</label>
                    <select name="school" class="form-control" required>
                        <option value="">選擇學校</option>
                        <option value="國立台灣大學" <?= $user['school'] == '國立台灣大學' ? 'selected' : '' ?>>國立台灣大學</option>
                        <option value="國立交通大學" <?= $user['school'] == '國立交通大學' ? 'selected' : '' ?>>國立交通大學</option>
                        <option value="國立清華大學" <?= $user['school'] == '國立清華大學' ? 'selected' : '' ?>>國立清華大學</option>
                        <option value="國防醫學院" <?= $user['school'] == '國防醫學院' ? 'selected' : '' ?>>國防醫學院</option>
                    </select>
                </div>
                <br>

             
                <div class="form-group">
                    <label for="department">系所：</label>
                    <select name="department" class="form-control" required>
                        <option value="">選擇系所</option>
                        <option value="資訊科學" <?= $user['department'] == '資訊科學' ? 'selected' : '' ?>>資訊科學</option>
                        <option value="電機工程" <?= $user['department'] == '電機工程' ? 'selected' : '' ?>>電機工程</option>
                        <option value="生物醫學" <?= $user['department'] == '生物醫學' ? 'selected' : '' ?>>生物醫學</option>
                        <option value="化學工程" <?= $user['department'] == '化學工程' ? 'selected' : '' ?>>化學工程</option>
                        <option value="機械工程" <?= $user['department'] == '機械工程' ? 'selected' : '' ?>>機械工程</option>
                        <option value="財務金融" <?= $user['department'] == '財務金融' ? 'selected' : '' ?>>財務金融</option>
                        <option value="醫學科學" <?= $user['department'] == '醫學科學' ? 'selected' : '' ?>>醫學科學</option>
                    </select>
                </div>
                <br>

                
                <div class="form-group">
                    <label for="level">年級：</label>
                    <select class="form-control" name="level" required>
                        <option value="">選擇年級</option>
                        <option value="一年級" <?= $user['level'] == '一年級' ? 'selected' : '' ?>>一年級</option>
                        <option value="二年級" <?= $user['level'] == '二年級' ? 'selected' : '' ?>>二年級</option>
                        <option value="三年級" <?= $user['level'] == '三年級' ? 'selected' : '' ?>>三年級</option>
                        <option value="四年級" <?= $user['level'] == '四年級' ? 'selected' : '' ?>>四年級</option>
                    </select>
                </div>
                <br>

                <input class="btn btn-custom" type="submit" value="更新資料">
                <a href="conference.php" class="btn btn-secondary">取消變更</a>
            </div>
        </div>
       
       
    </form>
    </div>
        </div></div></div>
    </div>
</div>

<style>
    .btn-custom{
    background-color: rgb(122, 162, 241);
    color: white; 
}
</style>
