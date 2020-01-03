<?php
  if(isset($_POST['register'])){
    require '../header.php';
    require 'connection.inc.php';

    $id = $_POST['course-id'];

    if(empty($id)){
      header("location: ../student.php?regcourse-submit=&error=emptyfields");
      exit();
    }
    else {
      $sqlcourse = "SELECT Id FROM course WHERE id =? and not EXISTS (SELECT Id FROM registered_courses WHERE Course_Id = course.Id and Student_Registration_no =?)";
      $stmtcourse = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
        header("Location: ../student.php?regcourse-submit=&error=sqlerror");
        exit();
      }
      else {
          mysqli_stmt_bind_param($stmtcourse, "ii", $id, $_SESSION['reg-no']);
          mysqli_stmt_execute($stmtcourse);
          mysqli_stmt_store_result($stmtcourse);
          $resultCheckcourse = mysqli_stmt_num_rows($stmtcourse);
          if($resultCheckcourse === 0){
            header("Location: ../student.php?regcourse-submit=&error=courseavailablilty");
            exit();
            }
          else {
            $sqlregister = "INSERT INTO registered_courses(Student_Registration_no, Course_Id, Grade) VALUES (?, ?, NULL)";
            $stmtregister = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmtregister, $sqlregister)){
              header("Location: ../student.php?regcourse-submit=&error=sqlerror");
              exit();
            }
            else{
              mysqli_stmt_bind_param($stmtregister, "ii",$_SESSION['reg-no'], $id);
              mysqli_stmt_execute($stmtregister);
              header("location: ../student.php?regcourse-submit=&registercourse=success");
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
