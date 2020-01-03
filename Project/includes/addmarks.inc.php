<?php
  if(isset($_POST['addMarks-submit'])){
    require 'connection.inc.php';

    $regno = $_POST['reg-no'];
    $courseid = $_POST['course-id'];
    $delname = $_POST['deliverable'];
    $total = $_POST['total-marks'];
    $obtained = $_POST['obtained-marks'];

    if(empty($regno) || empty($courseid) || empty($delname) || empty($total) || empty($obtained)){
      header("location: ../addmarks.php?addm-submit=&regno=".$regno."&error=emptyfields&regno=".$regno."&courseid=".$courseid."&deliverablename=".$delname."&total=".$total."&obtained".$obtained);
      exit();
    }

    elseif (!preg_match("/^[0-9]*$/", $regno)) {
      header("location: ../addmarks.php?addm-submit=&regno=".$regno."&error=invalidregno&courseid=".$courseid."&deliverablename=".$delname."&total=".$total."&obtained".$obtained);
      exit();
    }
    else {
      $sql = "SELECT Registration_no FROM student WHERE Registration_no=?";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "s", $regno);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if($resultCheck === 0){
            header("location: ../addmarks.php?addm-submit=&regno=".$regno."&error=studentnotadd&courseid=".$courseid."&deliverablename=".$delname."&total=".$total."&obtained".$obtained);
            exit();
          }
          else {
            $sqlcourse = "SELECT * FROM registered_courses WHERE Course_Id=? and Student_Registration_no =?";
            $stmtcourse = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtcourse, $sqlcourse)) {
              header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror0");
              exit();
            }
            else {
              mysqli_stmt_bind_param($stmtcourse, "ii", $courseid, $regno);
              mysqli_stmt_execute($stmtcourse);
              $resultcourse = mysqli_stmt_get_result($stmtcourse);
              if(!$row = mysqli_fetch_assoc($resultcourse)){
                header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=invalidcourseid");
                exit();
                }
              else{
                $regcourseid = $row['id'];
                $sqldel = "SELECT * FROM deliverable WHERE Type=?";
                $stmtdel = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmtdel, $sqldel)) {
                  header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror0");
                  exit();
                }
                else {
                  mysqli_stmt_bind_param($stmtdel, "s", $delname);
                  mysqli_stmt_execute($stmtdel);
                  $resultdel = mysqli_stmt_get_result($stmtdel);
                  if(!$rowdel = mysqli_fetch_assoc($resultdel)){
                    header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=invaliddeliverable");
                    exit();
                    }
                  else{
                    $deliverableid = $rowdel['id'];
                    $sqlregcoursedel = "SELECT * FROM registered_courses_has_deliverable WHERE Deliverable_id=? and Registered_courses_id =?";
                    $stmtregcoursedel = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmtregcoursedel, $sqlregcoursedel)) {
                      header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror1");
                      exit();
                    }
                    else {
                      mysqli_stmt_bind_param($stmtregcoursedel, "ii", $deliverableid, $regcourseid);
                      mysqli_stmt_execute($stmtregcoursedel);
                      $resultregcoursedel = mysqli_stmt_get_result($stmtregcoursedel);
                      if($rowregcoursedel = mysqli_fetch_assoc($resultregcoursedel)){
                        $regdelid = $rowregcoursedel['id'];
                        $sqleditmarks = "UPDATE marks SET Total_marks =? , Obtained_marks =? WHERE marks.Registered_courses_has_Deliverable_id=?";
                        $stmteditmarks = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmteditmarks, $sqleditmarks)){
                          header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
                          exit();
                        }
                        else{
                          mysqli_stmt_bind_param($stmteditmarks, "iii", $total, $obtained, $regdelid);
                          mysqli_stmt_execute($stmteditmarks);
                          header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=alreadyadded");
                          exit();
                        }
                      }
                      else {
                        $sqlRegco = "INSERT INTO registered_courses_has_deliverable(Deliverable_id, Registered_courses_id) VALUES (?, ?)";
                        $stmtRegco = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmtRegco, $sqlRegco)){
                          header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
                          exit();
                        }
                        else{
                          mysqli_stmt_bind_param($stmtRegco, "ii", $deliverableid, $regcourseid);
                          mysqli_stmt_execute($stmtRegco);

                          $sqlrcd = "SELECT * FROM registered_courses_has_deliverable WHERE Deliverable_id=? and Registered_courses_id =?";
                          $stmtrcd = mysqli_stmt_init($conn);
                          if (!mysqli_stmt_prepare($stmtrcd, $sqlrcd)) {
                              header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
                              exit();
                          }
                          else {
                              mysqli_stmt_bind_param($stmtrcd, "ii", $deliverableid, $regcourseid);
                              mysqli_stmt_execute($stmtrcd);
                              $resultrcd = mysqli_stmt_get_result($stmtrcd);
                            if(!$rowrcd = mysqli_fetch_assoc($resultrcd)){
                              header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
                              exit();
                            }
                            else{
                              $rcdid = $rowrcd['id'];
                              $sqlmarks = "INSERT INTO marks(Registered_courses_has_Deliverable_id, Total_marks, Obtained_marks) VALUES (?, ?, ?)";
                              $stmtmarks = mysqli_stmt_init($conn);
                              if(!mysqli_stmt_prepare($stmtmarks, $sqlmarks)){
                                header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&error=sqlerror");
                                exit();
                              }
                              else{
                                mysqli_stmt_bind_param($stmtmarks, "iii",$rcdid, $total, $obtained);
                                mysqli_stmt_execute($stmtmarks);
                                header("Location: ../addmarks.php?addm-submit=&regno=".$regno."&addmarks=success");
                                exit();
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
      mysqli_close($conn);
    }
    else{
      header("Location: ../index.php");
      exit();
    }
