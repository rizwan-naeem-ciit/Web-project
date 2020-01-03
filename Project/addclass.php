<center>
<body>

<?php
  if(isset($_GET['addclass-submit'])){
    require 'header.php';
    require 'includes/connection.inc.php';
    echo '<div align="right"><nav>
        <ul>
          <li><a href="coordinator.php">Profile</a></li>
        </ul>
      </nav></div><div class="signup">';
      $sqlcourse = "SELECT course.Id, course.Name, course.Credit_hours FROM  course";
      $stmtcourse = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
        echo'<p>Sql error</p>';
        exit();
      }
      else {
          mysqli_stmt_execute($stmtcourse);
          mysqli_stmt_store_result($stmtcourse);
          mysqli_stmt_bind_result($stmtcourse, $courseid, $coursename, $credits);
          $resultCheckcourse = mysqli_stmt_num_rows($stmtcourse);
          if($resultCheckcourse === 0){
            echo'<p>No course available</p>';
            exit();
            }
          else {
            echo '<p>Courses</p><br>';
            echo "<table class='table'>
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
        }
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            echo"<p>Fill in the field!</p>";
          }
          else if($_GET['error'] == "invalidcourseid"){
            echo"<p>Course id is invalid, try another!</p>";
          }
          else if($_GET['error'] == "invalidclassno"){
            echo"<p>Class number should be integer!!</p>";
          }
          else if($_GET['error'] == "coursenotadd"){
            echo"<p>Course is not available, try another!</p>";
          }
          else if($_GET['error'] == "alreadyadded"){
            echo"<p>Record is already added, cannot edit!</p>";
          }
        }
        else if(isset($_GET['addclass'])){
          if($_GET['addclass'] == "success"){
            echo"<p>Class is added</p>";
          }
        }
        echo '<form action="includes/addclass.inc.php" method="post">
          <input type="text" name="classcourse" placeholder="Course id"><br>
          <input type="text" name="classnumber" placeholder="Class number"><br>
          <input type="text" name="classday" placeholder="Class day"><br>
          <input type="text" name="classtime" placeholder="Class time"><br>
          <button type="submit" name="class-submit" class="btn btn-primary btn-block btn-large">Enter</button>
        </form>';
      }
  else{
      header("Location: index.php");
      exit();
  }
?>
</div>
</body>
</center>
