
<?php require "header.php"; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <title></title>
  
  </head>
  <body  >

    <?php
      if(isset($_SESSION['user'])){
        if (strpos($_SESSION['user'], "coordinator") === false) {
          header("location: student.php");
        }
        else{
          header("location: coordinator.php");
        }
      }
    ?>
  </body>
</html>

<?php require "footer.php"; ?>
