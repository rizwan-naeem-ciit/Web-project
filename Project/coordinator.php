<?php require "header.php"; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <title>Coordinator Profile</title>
  </head>
  <center>
  <body background="bg.jpg">
  <div class="signup">  <h1>Welcome Coordinator</h1>

    <?php
      if (isset($_GET['addcourse-submit'])) {
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in all the fields!</p>";
          }
          elseif($_GET['error'] == "nametaken"){
            echo"<p>This course name is taken, try another</p>";
          }
        }
        else if(isset($_GET['addcourse'])){
          if ($_GET['addcourse'] == "success") {
            echo"<p>Course is added</p>";
          }
        }
        echo '<div align="right"><nav>
            <ul>
              <li><a href="coordinator.php">Profile</a></li>
            </ul>
          </nav></div>
        <div class=""><form action="includes/addcourse.inc.php" method="post">
          <input type="text" name="course-name" placeholder="Course Name">
          <input type="text" name="course-credithours" placeholder="Course credit hours">
          <button type="submit" name="add-course" class="btn btn-primary btn-block btn-large">Enter</button>
        </form></div>
      ';
      }
      elseif (isset($_GET['addstudent-submit'])) {
        echo '<nav>
          <ul>
            <li><a href="coordinator.php">Profile</a></li>
          </ul>
        </nav>
        <h1>Add student</h1>';
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
          elseif($_GET['error']== "invalidregno"){
            echo"<p>Invalid registration number</p>";
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
          elseif($_GET['error'] == "regnotaken"){
            echo"<p>This registration number is taken, try another</p>";
          }
        }
        else if(isset($_GET['addstudent'])){
          if ($_GET['addstudent'] == "success") {
            echo"<p>Student is added</p>";
          }
        }
        echo '<div class=""><form  action="includes/addstudent.inc.php" method="post">
          <input type="text" name="name" placeholder="Name"><br>
          <input type="text" name="reg-num" placeholder="Registration num"><br>
          <input type="text" name="email" placeholder="Email"><br>
          <input type="text" name="user-name" placeholder="Username"><br>
          <input type="password" name="pwd" placeholder="Password"><br>
          <input type="password" name="pwd-repeat" placeholder="Repeat password"><br>
          <button type="submit" name="add-submit" class="btn btn-primary btn-block btn-large">Add</button>
        </form></div>';
      }
      elseif (isset($_GET['addcoordinator-submit'])) {
        echo '<nav>
          <ul>
            <li><a href="coordinator.php">Profile</a></li>
          </ul>
        </nav>
        <h1>Add Coordinator</h1>';
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
        else if(isset($_GET['addcoordinator'])){
          if ($_GET['addcoordinator'] == "success") {
            echo"<p>Coordinator is added</p>";
          }
        }
        echo '<div class=""><form  action="includes/addcoordinator.inc.php" method="post">
          <input type="text" name="name" placeholder="Name"><br>
          <input type="text" name="email" placeholder="Email"><br>
          <input type="text" name="user-name" placeholder="Username"><br>
          <input type="password" name="pwd" placeholder="Password"><br>
          <input type="password" name="pwd-repeat" placeholder="Repeat password"><br>
          <button type="submit" name="add-submit" class="btn btn-primary btn-block btn-large">Add</button>
        </form></div>';
      }
      else if (isset($_GET['addteacher-submit'])) {
        echo '<nav>
          <ul>
            <li><a href="coordinator.php">Profile</a></li>
          </ul>
        </nav>
        <h1>Add Teacher</h1>';
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in all the fields!</p>";
          }
          elseif($_GET['error']== "invalidemail"){
            echo"<p>Invalid email</p>";
          }
          elseif($_GET['error'] == "emailtaken"){
            echo"<p>This email is taken, try another</p>";
          }
        }
        else if(isset($_GET['addteacher'])){
          if ($_GET['addteacher'] == "success") {
            echo"<p>Teacher is added</p>";
          }
        }
        echo '<div class=""><form  action="includes/addteacher.inc.php" method="post">
          <input type="text" name="name" placeholder="Name"><br>
          <input type="text" name="email" placeholder="Email"><br>
          <input type="text" name="course" placeholder="Course id"><br>
          <button type="submit" name="add-submit" class="btn btn-primary btn-block btn-large">Add</button>
        </form></div>';
      }
      else if (isset($_GET['addattendence-submit'])) {
        echo '<nav>
          <ul>
            <li><a href="coordinator.php">Profile</a></li>
          </ul>
        </nav>
        <h1>Add Attendence</h1>';
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in the field!</p>";
          }
          elseif($_GET['error']== "invalidregno"){
            echo"<p>Invalid registration number</p>";
          }
          elseif($_GET['error']== "studentnotadd"){
            echo"<p>This student is not added, add him first</p>";
          }
        }

        echo "<p>Enter the registration number of the student</p>";
        echo '<div class=""><form  action="addattendence.php" method="get">
          <input type="text" name="regno" placeholder="Registration number"><br>
          <button type="submit" name="addattend-submit" class="btn btn-primary btn-block btn-large">Enter</button>
        </form></div>';
      }
      else if (isset($_GET['addmarks-submit'])) {
        echo '<nav>
          <ul>
            <li><a href="coordinator.php">Profile</a></li>
          </ul>
        </nav>
        <h1>Add Marks</h1>';

        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in the fields!</p>";
          }
          elseif($_GET['error']== "invalidregno"){
            echo"<p>Invalid registration number</p>";
          }
          elseif($_GET['error']== "studentnotadd"){
            echo"<p>This student is not added, add him first</p>";
          }
        }
        echo '<p>Enter the registration number of the student</p>';
        echo '<div class="sigup"><form  action="addmarks.php" method="get">
          <input type="text" name="regno" placeholder="Registraion number"><br>
          <button type="submit" name="addm-submit" class="btn btn-primary btn-block btn-large">Enter</button>
        </form></div>';
      }
      else {
        echo '<div class = ""><br><br><br><br><br>
        <form method="GET">
          <button type="submit" name="addstudent-submit" class="btn btn-primary btn-block btn-large">Add student</button>
          <button type="submit" name="addcoordinator-submit" class="btn btn-primary btn-block btn-large">Add coordinator</button>
          <button type="submit" name="addcourse-submit" class="btn btn-primary btn-block btn-large">Add course</button>
          <button type="submit" name="addteacher-submit" class="btn btn-primary btn-block btn-large">Add teacher</button>
          <button type="submit" name="addattendence-submit" class="btn btn-primary btn-block btn-large">Add attendence</button>
          <button type="submit" name="addmarks-submit" class="btn btn-primary btn-block btn-large">Add marks</button>
        </form>';
        echo '<form  action="addclass.php" method="get">
          <button type="submit" name="addclass-submit" class="btn btn-primary btn-block btn-large">Add class</button>
        </form></div>';
      }
     ?>
</div>
  </body>
</center>
</html>
