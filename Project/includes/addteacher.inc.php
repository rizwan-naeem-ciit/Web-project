<?php
  if(isset($_POST['add-submit'])){
    require 'connection.inc.php';

    $name = $_POST['name'];
    $mail = $_POST['email'];
    $course = $_POST['course'];

    if(empty($name) || empty($mail) || empty($course)){
      header("location: ../coordinator.php?addteacher-submit=&error=emptyfields&name=".$name."&email=".$mail."&course=".$course);
      exit();
    }
    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      header("location: ../coordinator.php?addteacher-submit=&error=invalidemail&name=".$name."&course=".$course);
      exit();
    }
    else {
      $sql = "SELECT Email FROM teacher WHERE Email=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../coordinator.php?addteacher-submit=&error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $mail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0){
          header("location: ../coordinator.php?addteacher-submit=&error=emailtaken&name=".$name."&course=".$course);
          exit();
        }
        else {
          $sqlteacher = "INSERT INTO teacher(Name, Email) VALUES (?, ?)";
          $stmtteacher = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmtteacher, $sqlteacher)){
            header("Location: ../coordinator.php?addteacher-submit=&error=sqlerror");
            exit();
          }
          else{
            mysqli_stmt_bind_param($stmtteacher, "ss",$name, $mail);
            mysqli_stmt_execute($stmtteacher);
            $sqlTeacher = "SELECT Id FROM teacher WHERE Email = ?";
            $stmtTeacher = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtTeacher, $sqlTeacher)) {
                header("Location: ../coordinator.php?addteacher-submit=&error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmtTeacher, "s", $mail);
                mysqli_stmt_execute($stmtTeacher);
                mysqli_stmt_store_result($stmtTeacher);
                //$resultUser = mysqli_stmt_get_result($stmtUser);
                $resultCheckUser = mysqli_stmt_num_rows($stmtTeacher);
                mysqli_stmt_bind_result($stmtTeacher, $teacherid);
                //$rowAddress = mysqli_fetch_assoc($resultAddress) and $rowUser = mysqli_fetch_assoc($stmtUser)
              if(mysqli_stmt_fetch($stmtTeacher)){
                      $sqlcourseteacher = "INSERT INTO course_has_teacher(Course_id, Teacher_id) VALUES (?, ?)";
                      $stmtcourseteacher = mysqli_stmt_init($conn);
                      if(!mysqli_stmt_prepare($stmtcourseteacher, $sqlcourseteacher)){
                        header("Location: ../coordinator.php?addteacher-submit=&error=sqlerror");
                        exit();
                      }
                      else{
                        mysqli_stmt_bind_param($stmtcourseteacher, "ii", $course, $teacherid);
                        mysqli_stmt_execute($stmtcourseteacher);
                        header("Location: ../coordinator.php?addteacher-submit=&addteacher=success");
                        exit();
                      }
                    }
                    else{
                      header("location: ../coordinator.php?addteacher-submit=&error=sql1");
                      exit();
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
