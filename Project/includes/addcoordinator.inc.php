<?php
  if(isset($_POST['add-submit'])){
    require 'connection.inc.php';

    $name = $_POST['name'];
    $mail = $_POST['email'];
    $username = $_POST['user-name'];
    $pass = $_POST['pwd'];
    $passrepeat = $_POST['pwd-repeat'];

    if(empty($name) || empty($mail) || empty($username) || empty($pass) || empty($passrepeat)){
      header("location: ../coordinator.php?addcoordinator-submit=&error=emptyfields&name=".$name."&email=".$mail."&username=".$username);
      exit();
    }
    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL) and (!preg_match("/^[a-zA-Z0-9]*$/", $username) or strpos($username, "coordinator") === false)) {
      header("location: ../coordinator.php?addcoordinator-submit=&error=invalidemailusername&name=".$name);
      exit();
    }
    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      header("location: ../coordinator.php?addcoordinator-submit=&error=invalidemail&name=".$name."&username=".$username);
      exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username) or strpos($username, "coordinator") === false) {
      header("location: ../coordinator.php?addcoordinator-submit=&error=invalidusername&name=".$name."&email=".$mail);
      exit();
    }
    elseif ($pass !== $passrepeat) {
      header("location: ../coordinator.php?addcoordinator-submit=&error=passwordrepeat&name=".$name."&email=".$mail."&username=".$username);
      exit();
    }
    else {
      $sql = "SELECT User_name FROM user WHERE User_name=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../coordinator.php?addcoordinator-submit=&error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0){
          header("location: ../coordinator.php?addcoordinator-submit=&error=usernametaken&name=".$name."&email=".$mail);
          exit();
        }
        else {
          $sqluser = "INSERT INTO user(User_name, Password) VALUES (?, ?)";
          $stmtuser = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmtuser, $sqluser)){
            header("Location: ../coordinator.php?addcoordinator-submit=&error=sqlerror");
            exit();
          }
          else{
            $hashedPwd = password_hash($pass, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmtuser, "ss",$username, $hashedPwd);
            mysqli_stmt_execute($stmtuser);
            $sqlUser = "SELECT Id FROM user WHERE User_name = ?";
            $stmtUser = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtUser, $sqlUser)) {
                header("Location: ../coordinator.php?addcoordinator-submit=&error=sqlerror");
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
                $sqlcoor = "INSERT INTO coordinator(Name, Email, User_id) VALUES (?, ?, ?)";
                $stmtcoor = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmtcoor, $sqlcoor)){
                  header("Location: ../coordinator.php?addcoordinator-submit=&error=sqlerror");
                  exit();
                }
                else{
                  mysqli_stmt_bind_param($stmtcoor, "ssi", $name, $mail, $userid);
                  mysqli_stmt_execute($stmtcoor);
                  header("Location: ../coordinator.php?addcoordinator-submit=&addcoordinator=success");
                  exit();
                }
              }
              else {
                header("location: ../coordinator.php?addcoordinator-submit=&error=sql");
                exit();
              }

          }
          }
          }
          }
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmtuser);
        mysqli_stmt_close($stmtUser);
        mysqli_stmt_close($stmtcoor);
        mysqli_close($conn);
}
else{
    header("Location: ../index.php");
    exit();
}
