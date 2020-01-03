<?php
  session_start();
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="style.css">
    <title></title>
  </head>
  <body>
        <?php
          if(isset($_SESSION['user'])){
            echo '<div align="right"><form action="includes/logout.inc.php" method="post">
              <button type="submit" name="logout-submit" class="btn btn-primary ">Logout</button>
            </form></div>';
          }
          else{
            if(isset($_GET['error'])){
              if($_GET['error'] == "invalidusername"){
                echo '<p>Invalid username</p>';
              }
              else if($_GET['error'] == "wrongpassword"){
                echo '<p>Invalid password</p>';
              }
            }
            echo '<div class="signup"> <h1>Welcome to University Portal</h1>
            <form  action="includes/login.inc.php" method="post">
              <input type="text" name="sid" placeholder="username">
              <input type="password" name="pwwd" placeholder="password">
              <button type="submit" name="login-submit" class="btn btn-primary btn-block btn-large">Login</button>
            </form></div>';
          }
        ?>

    </header>
  </body>
</html>
