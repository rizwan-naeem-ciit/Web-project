<?php
  if(isset($_POST['add-submit'])){
    require 'connection.inc.php';

    $name = $_POST['name'];
    $regnum = $_POST['reg-num'];
    $mail = $_POST['email'];
    $username = $_POST['user-name'];
    $pass = $_POST['pwd'];
    $passrepeat = $_POST['pwd-repeat'];

    if(empty($name) || empty($regnum) || empty($mail) || empty($username) || empty($pass) || empty($passrepeat)){
      header("location: ../coordinator.php?addstudent-submit=&error=emptyfields&name=".$name."&reg-num=".$regnum."&email=".$mail."&username=".$username);
      exit();
    }
    elseif (!(filter_var($mail, FILTER_VALIDATE_EMAIL)) and !(preg_match("/^[a-zA-Z0-9]*$/", $username))) {
      header("location: ../coordinator.php?addstudent-submit=&error=invalidemailusername&name=".$name."&reg-num=".$regnum);
      exit();
    }
    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      header("location: ../coordinator.php?addstudent-submit=&error=invalidemail&name=".$name."&reg-num=".$regnum."&username=".$username);
      exit();
    }
    elseif (!preg_match("/^[0-9]*$/", $regnum)) {
      header("location: ../coordinator.php?addstudent-submit=&error=invalidregno&name=".$name."&username=".$username."&email=".$mail);
      exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
      header("location: ../coordinator.php?addstudent-submit=&error=invalidusername&name=".$name."&reg-num=".$regnum."&email=".$mail);
      exit();
    }
    elseif ($pass !== $passrepeat) {
      header("location: ../coordinator.php?addstudent-submit=&error=passwordrepeat&name=".$name."&reg-num=".$regnum."&email=".$mail."&username=".$username);
      exit();
    }
    else {
      $sql = "SELECT User_name FROM user WHERE User_name=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../coordinator.php?addstudent-submit=&error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0){
          header("location: ../coordinator.php?addstudent-submit=&error=usernametaken&name=".$name."&reg-num=".$regnum."&email=".$mail);
          exit();
        }
        else {
          $sqls = "SELECT * FROM student WHERE Registration_no=?";
          $stmts = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmts, $sqls)){
            header("Location: ../coordinator.php?addstudent-submit=&error=sqlerror");
            exit();
          }
          else {
            mysqli_stmt_bind_param($stmts, "i", $regnum);
            mysqli_stmt_execute($stmts);
            mysqli_stmt_store_result($stmts);
            $resultChecks = mysqli_stmt_num_rows($stmts);
            if($resultChecks > 0){
              header("location: ../coordinator.php?addstudent-submit=&error=regnotaken&name=".$name."&reg-num=".$regnum."&email=".$mail);
              exit();
            }
            else {

          $sqluser = "INSERT INTO user(User_name, Password) VALUES (?, ?)";
          $stmtuser = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmtuser, $sqluser)){
            header("Location: ../coordinator.php?addstudent-submit=&error=sqlerror");
            exit();
          }
          else{
            $hashedPwd = password_hash($pass, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmtuser, "ss",$username, $hashedPwd);
            mysqli_stmt_execute($stmtuser);
            $sqlUser = "SELECT Id FROM user WHERE User_name = ?";
            $stmtUser = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtUser, $sqlUser)) {
                header("Location: ../coordinator.php?addstudent-submit=&error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmtUser, "s", $username);
                mysqli_stmt_execute($stmtUser);
                mysqli_stmt_store_result($stmtUser);
                //$resultUser = mysqli_stmt_get_result($stmtUser);
                $resultCheckUser = mysqli_stmt_num_rows($stmtUser);
                mysqli_stmt_bind_result($stmtUser, $userid);
                //$rowAddress = mysqli_fetch_assoc($resultAddress) and $rowUser = mysqli_fetch_assoc($stmtUser)
              if(mysqli_stmt_fetch($stmtUser)){
                $sqlstd = "INSERT INTO student(Registration_no, Name, Email, User_id) VALUES (?, ?, ?, ?)";
                $stmtstd = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmtstd, $sqlstd)){
                  header("Location: ../coordinator.php?addstudent-submit=&error=sqlerror");
                  exit();
                }
                else{
                  mysqli_stmt_bind_param($stmtstd, "issi",$regnum, $name, $mail, $userid);
                  mysqli_stmt_execute($stmtstd);
                  header("Location: ../coordinator.php?addstudent-submit=&addstudent=success");
                  exit();
                }
              }
              else {
                header("location: ../coordinator.php?addstudent-submit=&error=sql");
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
