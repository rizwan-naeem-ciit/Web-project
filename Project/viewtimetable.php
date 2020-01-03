<center>
<body background="bg.jpg">
<?php
  if(isset($_GET['viewtimetable-submit'])){
    require 'header.php';
    require 'includes/connection.inc.php';
    echo '<div align="right"><nav>
        <ul>
          <li><a href="student.php">Profile</a></li>
        </ul>
      </nav></div>';
      $sqltime = "SELECT teacher.Name, course.Name, class.Number, class.day, class.time FROM (((class JOIN registered_courses USING (Course_Id)) join course ON (course.Id = class.Course_Id)) JOIN course_has_teacher ON (course.Id = course_has_teacher.Course_Id)) join teacher ON (course_has_teacher.Teacher_Id = teacher.Id) WHERE Student_Registration_no =? ORDER BY course.Id";
      $stmttime = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmttime, $sqltime)) {
        echo'<p>Sql error</p>';
        exit();
      }
      else {
          mysqli_stmt_bind_param($stmttime, "i", $_SESSION['reg-no']);
          mysqli_stmt_execute($stmttime);
          mysqli_stmt_store_result($stmttime);
          mysqli_stmt_bind_result($stmttime, $teachername, $coursename, $classnum, $classday, $classtime);
          $resultChecktime = mysqli_stmt_num_rows($stmttime);
          if($resultChecktime === 0){
            echo'<p>No course registered</p>';
            exit();
            }
          else {
            echo '<p>Time table</p><br>';
            echo "<table border='1' class='table'>
                <tr>
                  <th>Course name</th>
                  <th>Class number</th>
                  <th>Class day</th>
                  <th>Class time</th>
                    <th>Course teacher</th>
                  </tr>";
          While(mysqli_stmt_fetch($stmttime)){
            echo "<tr>";
              echo "<td>" . $coursename . "</td>";
              echo "<td>" . $classnum . "</td>";
              echo "<td>" . $classday . "</td>";
              echo "<td>" . $classtime . "</td>";
              echo "<td>" . $teachername . "</td>";
              echo "</tr>";
            }
              echo "</table>";
          }
        }
      }
  else{
      header("Location: index.php");
      exit();
  }
?>
</body>
</center>
