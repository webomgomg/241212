
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<?php require_once "header.php"?>
<?php session_start(); ?>
<?php
if (!$_SESSION){
    header("Location: login.php");
}
?>
<body>
    <div class="container mt-5">
        <h2>會費與活動選擇</h2>
        <form action="fee2.php" method="post">
            <div class="form-group">
                <label>會費:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="membershipFee" value="1" id="Yes">
                    <label class="form-check-label" for="Yes">繳交</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="membershipFee" value="0" id="No">
                    <label class="form-check-label" for="No">不繳交</label>
                </div>
            </div>

            <div class="form-group">
                <label>活動:</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="program[]" value="0" id="program1">
                    <label class="form-check-label" for="program1">一日資管營</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="program[]" value="1" id="program2">
                    <label class="form-check-label" for="program2">迎新茶會</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="program[]" value="2" id="program3">
                    <label class="form-check-label" for="program3">迎新宿營</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">確定</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php require_once "footer.php"?>