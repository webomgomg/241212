<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-navbar {
            background-color: rgb(122, 162, 241); /* 自定義背景顏色 */
            color: white; /* 文字顏色 */
        }

        .custom-navbar .navbar-nav .nav-link {
            color: white; /* 修改導航鏈接的文字顏色 */
        }

        .custom-navbar .navbar-nav .nav-link:hover {
            color: #FFD700; /* 滑鼠懸停時的顏色 */
        }

        /* 使帳號顯示區域靠右顯示 */
        .navbar-text {
            color: white;
            margin-left: auto; /* 將帳號名稱區域移到右邊 */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm custom-navbar navbar-dark">
        <div class="container-fluid">
            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <h5><a class="nav-link" >學生學習成果展示系統</a></h5>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="conference.php">個人資料</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="fileupload.php">學習成果</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view.php">成果展示</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_reviews.php">評價</a>
                </li>
            </ul>

            <!-- 顯示使用者名稱，若未登入顯示登入提示 -->
            <div class="navbar-text">
    <?php
    if (isset($_SESSION['account'])) {
        echo '歡迎, ' . $_SESSION['name'];  
    } else {
        echo '請先登入';
    }
    ?>
</div>
        </div>
    </nav>
</body>
</html>
