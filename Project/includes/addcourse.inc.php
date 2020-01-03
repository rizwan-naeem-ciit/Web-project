<?php
  if(isset($_POST['add-course'])){
    require 'connection.inc.php';

    $name = $_POST['course-name'];
    $credits = $_POST['course-credithours'];

    if(empty($name) || empty($credits)){
      header("location: ../coordinator.php?addcourse-submit=&error=emptyfields&name=".$name."&credits=".$credits);
      exit();
    }
    else {
      $sql = "SELECT Name FROM course WHERE Name=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../coordinator.php?addcourse-submit=&error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0){
          header("location: ../coordinator.php?addcourse-submit=&error=nametaken&credits=".$credits);
          exit();
        }
        else {
          $sqlcourse = "INSERT INTO course(Name, Credit_hours) VALUES (?, ?)";
          $stmtcourse = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmtcourse, $sqlcourse)){
            header("Location: ../coordinator.php?addcourse-submit=&error=sqlerror");
            exit();
          }
          else{
            mysqli_stmt_bind_param($stmtcourse, "si",$name, $credits);
            mysqli_stmt_execute($stmtcourse);
            header("location: ../coordinator.php?addcourse-submit=&addcourse=success");
            exit();
          }
        }
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmtcourse);
    mysqli_close($conn);
}
else{
    header("Location: ../index.php");
    exit();
}
