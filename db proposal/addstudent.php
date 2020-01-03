<?php require "header.php"; ?>


  <body>
    <main>
      <h1>Add student</h1>
      <?php
      if(isset($_GET['error'])){
        if($_GET['error'] == "emptyfields"){
          echo"<p>Fill in all the fields!</p>";
        }
        elseif($_GET['error'] == "invalidemailusername"){
          echo"<p>Invalid email and username</p>";
        }
        elseif($_GET['error']== "invalidemail"){
          echo"<p>Invalid email</p>";
        }
        elseif($_GET['error'] == "invalidusername"){
          echo"<p>Invalid username</p>";
        }
        elseif($_GET['error'] == "passwordrepeat"){
          echo"<p>Password and repeat password fields donot match</p>";
        }
        elseif($_GET['error'] == "usernametaken"){
          echo"<p>This username is taken, try another</p>";
        }
      }
      else if(isset($_GET['addstudent'])){
        if ($_GET['addstudent'] == "success") {
          echo"<p>Student is added</p>";
        }
      }
      ?>
      <form  action="includes/addstudent.inc.php" method="post">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="reg-num" placeholder="Registration num"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="text" name="user-name" placeholder="Username"><br>
        <input type="password" name="pwd" placeholder="Password"><br>
        <input type="password" name="pwd-repeat" placeholder="Repeat password"><br>
        <button type="submit" name="add-submit">Add student</button>
      </form>
    </main>
  </body>

<?php require "footer.php"; ?>
