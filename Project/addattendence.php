<center>
<body background="bg.jpg">
<?php
  if(isset($_GET['addattend-submit'])){
    require 'header.php';
    require 'includes/connection.inc.php';

    $regno = $_GET['regno'];
    if (empty($regno)) {
      header("location: coordinator.php?addattendence-submit=&regno=".$regno."&error=emptyfields&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
      exit();
    }
    elseif (!preg_match("/^[0-9]*$/", $regno)) {
      header("location: coordinator.php?addattendence-submit=&regno=".$regno."&error=invalidregno&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
      exit();
    }
    else {
      $sql = "SELECT Registration_no FROM student WHERE Registration_no=?";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: coordinator.php?addattendence-submit=&regno=".$regno."&error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "s", $regno);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if($resultCheck === 0){
            header("location: coordinator.php?addattendence-submit=&regno=".$regno."&error=studentnotadd&courseid=".$courseid."&lectureno=".$lectureno."&date=".$date."&status".$status);
            exit();
          }
          else {
            echo '<div align="right"><nav>
              <ul>
              <li><a href="coordinator.php">Profile</a></li>
              <li><a href="coordinator.php?addattendence-submit=">Back</a></li>
              </ul>
            </nav></div><div class="signup">';
            $sqlreg = "SELECT course.Id, course.Name, course.Credit_hours FROM registered_courses join course ON registered_courses.Course_id = course.Id WHERE Student_Registration_no =?";
            $stmtreg = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtreg, $sqlreg)) {
              echo'<p>Sql error</p>';
              exit();
            }
            else {
              mysqli_stmt_bind_param($stmtreg, "i", $regno);
              mysqli_stmt_execute($stmtreg);
              mysqli_stmt_store_result($stmtreg);
              mysqli_stmt_bind_result($stmtreg, $courseid, $coursename, $credits);
              $resultCheckreg = mysqli_stmt_num_rows($stmtreg);
              if($resultCheckreg === 0){
                echo'<p>No course registered of this student</p>';
                exit();
              }
              else {
                echo '<p>Registered Courses of this student</p><br>';
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
                    if(isset($_GET['error'])){
                      if($_GET['error'] == "emptyfields"){
                        echo"<p>Fill in all the fields!</p>";
                      }
                      elseif($_GET['error']== "invalidregno"){
                        echo"<p>Invalid registration number</p>";
                      }
                      elseif($_GET['error']== "invalidlectureno"){
                        echo"<p>Invalid lecture number</p>";
                      }
                      elseif($_GET['error']== "studentnotadd"){
                        echo"<p>This student is not added, add him first</p>";
                  }
                  elseif($_GET['error']== "invalidcourseid"){
                    echo"<p>Invalid course id</p>";
                  }
                  elseif($_GET['error']== "alreadyadded"){
                    echo"<p>Record is edited</p>";
                  }
                }
                else if(isset($_GET['addattendence'])){
                  if ($_GET['addattendence'] == "success") {
                    echo"<p>Attendence is added</p>";
                  }
                }
                  echo '<br><br><div class="sigup"><form  action="includes/addattendence.inc.php" method="post">
                  <input type="text" name="reg-no" placeholder="Registration number", value = '.$regno.'><br>
                  <input type="text" name="course-id" placeholder="Course id"><br>
                  <input type="text" name="lecture-no" placeholder="Lecture no"><br>
                  <input type="text" name="date" placeholder="Date"><br>
                  <input type="text" name="status" placeholder="Status"><br>
                  <button type="submit" name="add-submit" class="btn btn-primary btn-block btn-large">Enter</button>
                </form></div>';
              }
            }
          }
        }
      }
    }
    else{
      header("Location: index.php");
      exit();
    }
?>
</div>
</body>
</center>
