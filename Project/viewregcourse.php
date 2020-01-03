<center>
<body background="bg.jpg">

<?php
  if(isset($_GET['viewreg-submit'])){
    require 'header.php';
    require 'includes/connection.inc.php';
    echo '<div align="right"><nav>
        <ul>
          <li><a href="student.php">Profile</a></li>
        </ul>
      </nav></div><div class="signup">';
      $sqlreg = "SELECT course.Id, course.Name, course.Credit_hours FROM registered_courses join course ON registered_courses.Course_id = course.Id WHERE Student_Registration_no =?";
      $stmtreg = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtreg, $sqlreg)) {
        echo'<p>Sql error</p>';
        exit();
      }
      else {
          mysqli_stmt_bind_param($stmtreg, "i", $_SESSION['reg-no']);
          mysqli_stmt_execute($stmtreg);
          mysqli_stmt_store_result($stmtreg);
          mysqli_stmt_bind_result($stmtreg, $courseid, $coursename, $credits);
          $resultCheckreg = mysqli_stmt_num_rows($stmtreg);
          if($resultCheckreg === 0){
            echo'<p>No course registered</p>';
            exit();
            }
          else {
            echo '<p>Registered Courses</p>';
            echo "<table border='1' class='table'>
                <tr>
                  <th>Course id</th>
                  <th>Course Name</th>
                  <th>Credit hours</th>
                  </tr>";
          While(mysqli_stmt_fetch($stmtreg)){
            echo "<tr>";
              echo "<td>" . $courseid . "</td>";
              echo "<td>" . $coursename . "</td>";
              echo "<td>" . $credits . "</td>";
              echo "</tr>";
            }
              echo "</table>";




          }
        }
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in the field!</p>";
          }
          else if($_GET['error'] == "courseavailablilty"){
            echo"<p>Course is not registered, try another!</p>";
          }

        }
          else if(isset($_GET['dropcourse'])){
          if ($_GET['dropcourse'] == "success") {
            echo"<p>Course is droped</p>";
          }
        }
        echo '<p>Enter the course id you want to drop</p>';
        echo '<div class="sigup"><form action="includes/dropcourse.inc.php" method="post">
          <input type="text" name="course-id" placeholder="Course id">
          <button type="submit" name="drop-submit" class="btn btn-primary btn-block btn-large">Drop</button>
        </form>';
        echo '<p>Enter the course id of which you want to view attendence</p>';
        echo '<form action="viewattendence.php" method="get">
          <input type="text" name="course-id" placeholder="Course id">
          <button type="submit" name="viewattendence-submit" class="btn btn-primary btn-block btn-large">View attendence</button>
        </form>';

        echo '<p>Enter the course id of which you want to view marks</p>';
        echo '<form action="viewmarks.php" method="get">
          <input type="text" name="course-id" placeholder="Course id">
          <button type="submit" name="viewmarks-submit" class="btn btn-primary btn-block btn-large">View marks</button>
        </form></div>';
      }
  else{
      header("Location: index.php");
      exit();
  }
?>
</div>
</body>
</center>
