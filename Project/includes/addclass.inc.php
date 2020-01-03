<?php
  if(isset($_POST['class-submit'])){
    require 'connection.inc.php';

    $cid = $_POST['classcourse'];
    $cnumber = $_POST['classnumber'];
    $day = $_POST['classday'];
    $time = $_POST['classtime'];

    if(empty($cid) || empty($cnumber) || empty($day) || empty($time)){
      header("location: ../addclass.php?addclass-submit=&error=emptyfields");
      exit();
    }

    elseif (!preg_match("/^[0-9]*$/", $cid)) {
      header("location: ../addclass.php?addclass-submit=&error=invalidcourseid");
      exit();
    }
    elseif (!preg_match("/^[0-9]*$/", $cnumber)) {
      header("location: ../addclass.php?addclass-submit=&error=invalidclassno");
      exit();
    }
    else {
      $sql = "SELECT * FROM course WHERE course.Id=?";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../addclass.php?addclass-submit=&error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "i", $cid);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if($resultCheck === 0){
            header("location: ../addclass.php?addclass-submit=&error=coursenotadd");
            exit();
          }
          else{
              $sqlclass = "SELECT * FROM class WHERE class.Number=? and class.Course_Id =?";
              $stmtclass = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmtclass, $sqlclass)) {
                  header("Location: ../addclass.php?addclass-submit=&error=sqlerror1");
                  exit();
                }
                else {
                  mysqli_stmt_bind_param($stmtclass, "ii", $cnumber, $cid);
                  mysqli_stmt_execute($stmtclass);
                  mysqli_stmt_store_result($stmtclass);
                  $resultCheckclass = mysqli_stmt_num_rows($stmtclass);
                  if($resultCheckclass > 0){
                      header("Location: ../addclass.php?addclass-submit=&error=alreadyadded");
                      exit();
                    }
                  else {
                    $sqlClass = "INSERT INTO class(Number, time, day, Course_Id) VALUES (?, ?, ?, ?)";
                    $stmtClass = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmtClass, $sqlClass)){
                      header("Location: ../addclass.php?addclass-submit=&error=sqlerror");
                      exit();
                    }
                    else{
                      mysqli_stmt_bind_param($stmtClass, "issi", $cnumber, $time, $day, $cid);
                      mysqli_stmt_execute($stmtClass);
                      header("Location: ../addclass.php?addclass-submit=&addclass=success");
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
