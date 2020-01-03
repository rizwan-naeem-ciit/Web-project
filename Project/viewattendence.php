<center>
<body background="bg.jpg">
<?php
  if(isset($_GET['viewattendence-submit'])){
    require 'header.php';
    require 'includes/connection.inc.php';
    echo '<div align="right"><nav>
        <ul>
          <li><a href="student.php">Profile</a></li>
          <li><a href="viewregcourse.php?viewreg-submit=">Back</a></li>
        </ul>
      </nav></div>';
      $id = $_GET['course-id'];

      if(empty($id)){
        header("location: ../viewregcourse.php?viewreg-submit=&error=emptyfields");
        exit();
      }
      else{

        $sqlcourse = "SELECT * FROM registered_courses WHERE Course_Id=? and Student_Registration_no =?";
        $stmtcourse = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
          echo '<p>Sql error</p>';
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmtcourse, "ii", $id, $_SESSION['reg-no']);
          mysqli_stmt_execute($stmtcourse);
          $resultcourse = mysqli_stmt_get_result($stmtcourse);
          if(!$row = mysqli_fetch_assoc($resultcourse)){
            echo '<p>Course id invalid</p>';
            exit();
            }
          else{
            $regcourseid = $row['id'];
            $sqlattend = "SELECT course.Name, attendence.Lecture_no, attendence.date, attendence.status FROM (attendence join registered_courses ON(attendence.Registered_courses_id = registered_courses.id)) JOIN course ON (Course_Id = course.id) WHERE  Registered_courses_id =?";
            $stmtattend = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtattend, $sqlattend)) {
              echo '<p>Sql error</p>';
              exit();
            }
            else {
              mysqli_stmt_bind_param($stmtattend, "i", $regcourseid);
              mysqli_stmt_execute($stmtattend);
              mysqli_stmt_store_result($stmtattend);
              mysqli_stmt_bind_result($stmtattend, $coursename, $lectureno, $date, $status);
              $resultCheckattend = mysqli_stmt_num_rows($stmtattend);
              if($resultCheckattend === 0){
                echo'<p>No attendence details added yet</p>';
                exit();
                }
              else {
                echo '<p>Registered Courses</p><br>';
                echo "<table border='1' class='table'>
                    <tr>
                      <th>Course name</th>
                      <th>Lecture number</th>
                      <th>Date</th>
                      <th>status</th>
                      </tr>";
              While(mysqli_stmt_fetch($stmtattend)){
                echo "<tr>";
                  echo "<td>" . $coursename . "</td>";
                  echo "<td>" . $lectureno . "</td>";
                  echo "<td>" . $date . "</td>";
                  echo "<td>" . $status . "</td>";
                  echo "</tr>";
                }
                  echo "</table>";
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
</body>
</center>
