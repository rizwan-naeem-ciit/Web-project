<center>
<body background="bg.jpg">
<?php
  if(isset($_GET['viewmarks-submit'])){
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
            $sqlmarks = "SELECT deliverable.Type, marks.Total_marks, marks.Obtained_marks FROM ((`marks` JOIN registered_courses_has_deliverable ON (marks.Registered_courses_has_Deliverable_id = registered_courses_has_deliverable.id)) JOIN deliverable ON (registered_courses_has_deliverable.Deliverable_id = deliverable.id)) JOIN registered_courses ON (registered_courses.id = registered_courses_has_deliverable.Registered_courses_id) WHERE registered_courses.Student_Registration_no =? AND registered_courses.Course_Id =? ORDER BY deliverable.id";
            $stmtmarks = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtmarks, $sqlmarks)) {
              echo '<p>Sql error</p>';
              exit();
            }
            else {
              mysqli_stmt_bind_param($stmtmarks, "ii", $_SESSION['reg-no'], $id);
              mysqli_stmt_execute($stmtmarks);
              mysqli_stmt_store_result($stmtmarks);
              mysqli_stmt_bind_result($stmtmarks, $deltype, $total, $obtained);
              $resultCheckmarks = mysqli_stmt_num_rows($stmtmarks);
              if($resultCheckmarks === 0){
                echo'<p>No marks details added yet</p>';
                exit();
                }
              else {
                echo '<p>Marks details</p><br>';
                echo "<table border='1' class='table'>
                    <tr>
                      <th>Deliverable type</th>
                      <th>Total marks</th>
                      <th>Obtained marks</th>
                      </tr>";
              While(mysqli_stmt_fetch($stmtmarks)){
                echo "<tr>";
                  echo "<td>" . $deltype . "</td>";
                  echo "<td>" . $total . "</td>";
                  echo "<td>" . $obtained . "</td>";
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
