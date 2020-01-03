<?php
  if(isset($_POST['drop-submit'])){
    require '../header.php';
    require 'connection.inc.php';

    $id = $_POST['course-id'];

    if(empty($id)){
      header("location: ../viewregcourse.php?viewreg-submit=&error=emptyfields");
      exit();
    }
    else {
      $sqldrop = "SELECT * FROM registered_courses WHERE Course_Id =? and Student_Registration_no =?";
      $stmtdrop = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtdrop, $sqldrop)) {
        header("Location: ../viewregcourse.php?viewreg-submit=&error=sqlerror");
        exit();
      }
      else {
          mysqli_stmt_bind_param($stmtdrop, "ii", $id, $_SESSION['reg-no']);
          mysqli_stmt_execute($stmtdrop);
          mysqli_stmt_store_result($stmtdrop);
          $resultCheckdrop = mysqli_stmt_num_rows($stmtdrop);
          if($resultCheckdrop === 0){
            header("Location: ../viewregcourse.php?viewreg-submit=&error=courseavailablilty");
            exit();
            }
          else {
            $sqlDrop = "DELETE FROM registered_courses WHERE Course_Id =? and Student_Registration_no =?";
            $stmtDrop = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmtDrop, $sqlDrop)){
              header("Location: ../viewregcourse.php?viewreg-submit=&error=sqlerror");
              exit();
            }
            else{
              mysqli_stmt_bind_param($stmtDrop, "ii", $id, $_SESSION['reg-no']);
              mysqli_stmt_execute($stmtDrop);
              header("location: ../viewregcourse.php?viewreg-submit=&dropcourse=success");
              exit();
            }
          }
        }
      }
    }
  else{
      header("Location: ../index.php");
      exit();
  }
