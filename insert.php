<?php

require_once 'header.php';
require_once 'db.php';

$msg="";

if ($_POST) {
  // insert data
  $company = $_POST["company"];
  $content = $_POST["content"];

  $sql="insert into job (company, content, pdate) values (?, ?, now())";
  $stmt = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ss", $company, $content);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
      header('location:query.php');
      exit;
    } else {
      $msg = "無法新增資料：" . mysqli_error($conn); // 顯示錯誤訊息
    }
  } else {
    $msg = "SQL 語法錯誤：" . mysqli_error($conn);
  }
}
?>

<div class="container">
  <form action="insert.php" method="post">
    <div class="mb-3 row">
      <label for="_company" class="col-sm-2 col-form-label">求才廠商</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="_company" name="company" placeholder="公司名稱" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="_content" class="form-label">求才內容</label>
      <textarea class="form-control" id="_content" name="content" rows="10" required></textarea>
    </div>
    <input class="btn btn-primary" type="submit" value="送出">
    <?=$msg?>
  </form>
</div>

<?php
mysqli_close($conn);
?>