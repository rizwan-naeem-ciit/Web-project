<?php
  if(isset($_POST['login-submit'])){
    require "connection.inc.php";
    $username = $_POST['sid'];
    $pass = $_POST['pwwd'];
    if (empty($username) || empty($pass)) {
      header("location: ../index.php?error=emptyfields");
      exit();
    }
    else{
      $sql = "SELECT * FROM user WHERE User_name = ?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
          $pwdCheck = password_verify($pass, $row['Password']);
          if($pwdCheck == false){
            header("Location: ../index.php?error=wrongpassword");
            exit();
          }
          elseif ($pwdCheck == true) {
            session_start();
            $_SESSION['user'] = $row['User_name'];
            if(strpos($username, "coordinator") === false){
              $sqlstd = "SELECT student.Registration_no FROM student JOIN user ON student.User_Id = user.Id WHERE  User_name =?";
              $stmtstd = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmtstd, $sqlstd)) {
                header("Location: ../index.php?error=sqlerror1");
                exit();
              }
              else {
                mysqli_stmt_bind_param($stmtstd, "s", $username);
                mysqli_stmt_execute($stmtstd);
                mysqli_stmt_store_result($stmtstd);
                mysqli_stmt_bind_result($stmtstd, $regno);
                if(mysqli_stmt_fetch($stmtstd)){
                  $_SESSION['reg-no'] = $regno;
                }
                else{
                  header("Location: ../index.php?error=sqlerror0");
                  exit();
                }
              }
            }
            header("Location: ../index.php?login=success");
            exit();
          }
          else{
            header("Location: ../index.php?error=wrongpassword");
            exit();
          }
        }
        else {
          header("Location: ../index.php?error=invalidusername");
          exit();
        }
      }

    }
  }
  else {
    header("location: ../index.php");
    exit();
  }
