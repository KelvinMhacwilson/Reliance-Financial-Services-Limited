<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
include '../inc/headerStart.php';

$sql = "SELECT employee_id, employee_username FROM employee;";
$exec = mysqli_query($conn, $sql);
$allEmployees = mysqli_fetch_all($exec, MYSQLI_ASSOC);

$aTimeDate = FILTER_INPUT(INPUT_POST, 'attendanceTimeDate', FILTER_SANITIZE_SPECIAL_CHARS);
$aType = FILTER_INPUT(INPUT_POST, 'attendanceType', FILTER_SANITIZE_SPECIAL_CHARS);
$aeID = FILTER_INPUT(INPUT_POST, 'attendanceEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addAttendance'])) {
    (empty($aType) || empty($aeID) ) ?  $errMsg = "All Fields Are Required " : $errMsg = '';

    //adding data to database
    $sql1 = "INSERT INTO attendance (att_type, employee_id)
        VALUES ('$aType', '$aeID')";

    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Attendance Added Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("attendanceList.php"); </script>';
    } else {
        $msg = '' . mysqli_error($conn);
        $status = '';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        // echo '<script> location.replace("attendanceListAdd.php"); </script>';
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa fa-check-circle"></i>
            </span> Attendance
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Add Attendance</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username</label>
                                    <select class="form-select" id="exampleSelectGender" name="attendanceEmployeeID">
                                        <option value="">Select ..</option>
                                        <?php foreach ($allEmployees as $employ) : ?>
                                            <option class="dropdown-item" value='<?php echo $employ['employee_id']; ?>'>
                                                <?php echo $employ['employee_username']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="attendanceType">Attendance Type<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="attendanceType" name="attendanceType" placeholder="Enter attendance type" required>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addAttendance" value="ADD">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- content-wrapper ends -->


<?php

include '../inc/headerEnd.php';

?>