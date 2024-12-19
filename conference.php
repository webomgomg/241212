<?php
session_start();
require_once "header.php";  
require_once "db.php";      


if (!isset($_SESSION["account"])) {
    header("Location: login.php?msg=請先登入");
    exit;
}

$account = $_SESSION["account"];


$sql = "SELECT name, account, school, department, level, profile_picture FROM user WHERE account = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $account);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);


$profile_picture = $user['profile_picture'] ?: 'images.jpg';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>個人基本資料</h3>
        </div>
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-3">
                    <img src="<?= htmlspecialchars($profile_picture) ?>" alt="Profile Picture" class="img-thumbnail" width="150">
                </div>
                
                <div class="col-md-9">
                    <h5>姓名：<?= htmlspecialchars($user['name']) ?></h5>
                    <p>帳號：<?= htmlspecialchars($user['account']) ?></p>
                    <p>學校：<?= htmlspecialchars($user['school']) ?></p>
                    <p>系所：<?= htmlspecialchars($user['department']) ?></p>
                    <p>年級：<?= htmlspecialchars($user['level']) ?></p>
                </div>
            </div>

            
            <div class="mt-3">
                <a href="revise.php" class="btn btn-custom">修改資料</a>
            </div>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>  
<style>
    .btn-custom{
    background-color: rgb(122, 162, 241);
    color: white; 
}
</style>