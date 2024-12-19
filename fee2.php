<?php require_once "header.php"?>
<?php

$membershipFee=2000;

$program_price = array(

  array(300, 150, 5500),//非會員

  array(0, 0, 3000) //會員

);

$price = 0;

//檢查是否取得POST內容

if ($_POST){ //如果POST有內容，進行以下的登入檢查

  $membership = $_POST["membershipFee"]??1;

  $programs = $_POST["program"]??[];

  if($membership == 1){
    $price += $membershipFee;
}


  foreach( $programs as $program ) {

    $price += $program_price[$membership][$program];
  //計算費用


}
}

?>

<html lang="zh-Hant">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container mt-5">
        <h2>計算結果</h2>
        <p>費用: <strong><?=$price?></strong></p>
        <a href="fee.php" class="btn btn-secondary">重新計算</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php require_once "footer.php"?>