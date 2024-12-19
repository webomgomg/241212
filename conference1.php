
<?php require_once "header.php"?>
<body>
<?php

if ($_POST){
  session_start();
  $program_price = array(0, 150, 100, 60);

  $name = $_SESSION["account"]??"N/A";



  //new syntax in php 7

  $programlist = $_POST["program"]?? [0];

  $price = 0;

  foreach( $programlist as $program ) {  

    $price += $program_price[$program];

  }

  echo "$name ，您要繳交 $price 元 <br/>";

}

else {

  header("Location: conference.html");

}

?>
<?php require_once "footer.php"?>