<?php require "header.php";
require "includes/connection.inc.php"?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <title>Student Profile</title>
  </head>
  <center>
  <body background="bg.jpg">
    <div class="signup">

    <?php
      if(isset($_GET['regcourse-submit'])){
        require 'includes/connection.inc.php';
        echo '<div align="right"><nav>
            <ul>
              <li><a href="student.php">Profile</a></li>
            </ul>
          </nav></div>';

        echo '<p>Available Courses</p><br>';
        $sqlcourse = "SELECT * FROM course WHERE Id not in (SELECT Course_Id FROM registered_courses WHERE Student_Registration_no =?)";
        $stmtcourse = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
            echo 'Sql error';
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmtcourse, "i", $_SESSION['reg-no']);
            mysqli_stmt_execute($stmtcourse);
            mysqli_stmt_store_result($stmtcourse);
            mysqli_stmt_bind_result($stmtcourse, $courseid, $coursename, $credits);
            echo "<table border='1' class= 'table'>
                <tr>
                  <th>Course id</th>
                  <th>Course Name</th>
                  <th>Credit hours</th>
                  </tr>";
          While(mysqli_stmt_fetch($stmtcourse)){
            echo "<tr>";
              echo "<td>" . $courseid . "</td>";
              echo "<td>" . $coursename . "</td>";
              echo "<td>" . $credits . "</td>";
              echo "</tr>";
            }
            echo "</table>";
          }

          if(isset($_GET['error'])){
            if($_GET['error'] == "emptyfields"){
              echo"<p>Fill in the field!</p>";
            }
            else if($_GET['error'] == "courseavailablilty"){
              echo"<p>Course is not available, try another!</p>";
            }
          }
            else if(isset($_GET['registercourse'])){
            if ($_GET['registercourse'] == "success") {
              echo"<p>Course is registered</p>";
            }
          }
        echo '<p>Enter the course id you want to register</p>';
        echo '<div class="sigup"><form action="includes/registercourse.inc.php?" method="post">
          <input type="text" name="course-id" placeholder="Course id"><br><br>
          <button type="submit" name="register" class="btn btn-primary btn-block btn-large">Register</button>
        </form></div>';
        }
        elseif (isset($_GET['fee-submit'])) {
          echo '<nav>
              <ul>
                <li><a href="student.php">Profile</a></li>
              </ul>
            </nav>';
          $sqlfee = "SELECT SUM(Credit_hours) FROM registered_courses JOIN course ON (registered_courses.Course_Id = course.Id) WHERE registered_courses.Student_Registration_no =? GROUP BY registered_courses.Student_Registration_no";
          $stmtfee = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmtfee, $sqlfee)) {
            echo 'SQL error';
          }
          else {
            mysqli_stmt_bind_param($stmtfee, "i", $_SESSION['reg-no']);
            mysqli_stmt_execute($stmtfee);
            $resultfee = mysqli_stmt_get_result($stmtfee);
            if(!$rowfee = mysqli_fetch_assoc($resultfee)){
              $fee = 0;
              }
            else{
              $fee = $rowfee['SUM(Credit_hours)'] * 5000;
            }
          }
          echo "The fee is ".$fee." Rs.";
        }
      else{
        echo '<p>Welcome Student</p>';
        echo '<div class="sigup"><form method="get">
          <button type="submit" name="regcourse-submit" class="btn btn-primary btn-block btn-large">Register Course</button>
          <button type="submit" name="fee-submit" class="btn btn-primary btn-block btn-large">Generate fee</button>
        </form>';
        echo '<form action="viewregcourse.php" method="get">
          <button type="submit" name="viewreg-submit" class="btn btn-primary btn-block btn-large">View Registered Courses</button>
        </form>';
        echo '<form action="viewtimetable.php" method="get">
          <button type="submit" name="viewtimetable-submit" class="btn btn-primary btn-block btn-large">Generate Time Table</button>
        </form></div>';

      }
    ?>
  </div>
  </body>
</center>
</html>
