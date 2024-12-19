<?php require_once "header.php"?>

<?php

session_start();

if (!$_SESSION){
    header("Location: login.php");
}

if (!$_SESSION["account"]){

  header("Location: index.php");

}

if ($_SESSION){

  echo $_SESSION["account"],"<br/>";

  echo "Status:<br/>";

  

  //new syntax in php 7

  $statuslist = $_POST["status"]?? ["N/A"];

  

  foreach( $statuslist as $status ) {

    echo "$status <br/>";

  }

  

  $dinner = $_POST["dinner"]?? "";

  echo "$dinner <br/>";

}



?>

<form action="status.php" method="post">



name:<?php echo $_SESSION["account"];?></br>

<input type="checkbox" name="status[]" value="faculty" checked="checked" /> Faculty

<input type="checkbox" name="status[]" value="student" /> Student<br/>

<input type="checkbox" name="dinner" value="dinner" checked="checked" /> Dinner needed



<input type="submit" value="Submit" />




</form>

<?php require_once "footer.php"?>