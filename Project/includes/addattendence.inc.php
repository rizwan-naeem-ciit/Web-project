<?php
  if(isset($_POST['add-submit'])){
    require 'connection.inc.php';

    $regno = $_POST['reg-no'];
    $courseid = $_POST['course-id'];
    $lectureno = $_POST['lecture-no'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    if(empty($regno) || empty($courseid) || empty($lectureno) || empty($date) || empty($status)){
      header("location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=emptyfields&regno=".$regno."&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
      exit();
    }

    elseif (!preg_match("/^[0-9]*$/", $regno)) {
      header("location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=invalidregno&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
      exit();
    }
    elseif (!preg_match("/^[0-9]*$/", $lectureno)) {
      header("location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=invalidlectureno&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
      exit();
    }
    else {
      $sql = "SELECT Registration_no FROM student WHERE Registration_no=?";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "s", $regno);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if($resultCheck === 0){
            header("location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=studentnotadd&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
            exit();
          }
          else {
            $sqlcourse = "SELECT * FROM registered_courses WHERE Course_Id=? and Student_Registration_no =?";
            $stmtcourse = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
              header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=sqlerror0");
              exit();
            }
            else {
              mysqli_stmt_bind_param($stmtcourse, "ii", $courseid, $regno);
              mysqli_stmt_execute($stmtcourse);
              $resultcourse = mysqli_stmt_get_result($stmtcourse);
              if(!$row = mysqli_fetch_assoc($resultcourse)){
                header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=invalidcourseid");
                exit();
                }
              else{
                $regcourseid = $row['id'];
                $sqlattend = "SELECT * FROM attendence WHERE Lecture_no=? and Registered_courses_id =?";
                $stmtattend = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmtattend, $sqlattend)) {
                  header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=sqlerror1".$regcourseid);
                  exit();
                }
                else {
                  mysqli_stmt_bind_param($stmtattend, "ii", $lectureno, $regcourseid);
                  mysqli_stmt_execute($stmtattend);
                  mysqli_stmt_store_result($stmtattend);
                  $resultCheckattend = mysqli_stmt_num_rows($stmtattend);
                  if($resultCheckattend > 0){

                    $sqleditattend = "UPDATE attendence SET date =?, status =? WHERE attendence.Lecture_no =? AND attendence.Registered_courses_id =?";
                    $stmteditattend = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmteditattend, $sqleditattend)){
                      header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=sqlerror");
                      exit();
                    }
                    else{
                      mysqli_stmt_bind_param($stmteditattend, "ssii", $date, $status, $lectureno, $regcourseid);
                      mysqli_stmt_execute($stmteditattend);
                      header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=alreadyadded");
                      exit();
                    }
                  }
                  else {
                    $sqlAttend = "INSERT INTO attendence(Lecture_no, date, status, Registered_courses_id) VALUES (?, ?, ?, ?)";
                    $stmtAttend = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmtAttend, $sqlAttend)){
                      header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&error=sqlerror");
                      exit();
                    }
                    else{
                      mysqli_stmt_bind_param($stmtAttend, "issi", $lectureno, $date, $status, $regcourseid);
                      mysqli_stmt_execute($stmtAttend);
                      header("Location: ../addattendence.php?addattend-submit=&regno=".$regno."&addattendence=success");
                      exit();
                    }

                  }
                }
              }
          }
        }
      }
    }
  mysqli_close($conn);
}
else{
    header("Location: ../index.php");
    exit();
}
