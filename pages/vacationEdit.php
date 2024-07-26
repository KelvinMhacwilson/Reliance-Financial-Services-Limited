<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
include '../inc/headerStart.php';

$sql = "SELECT employee_id, employee_username FROM employee;";
$exec = mysqli_query($conn, $sql);
$allEmployees = mysqli_fetch_all($exec, MYSQLI_ASSOC);

if (isset($_GET['edit'])) {
    $edit = intval($_GET['edit']); // Sanitize the input
    $_SESSION['edit'] = $edit;

    // Retrieve the record to edit
    $sql1 = "SELECT v.vacation_id, v.vacation_title, v.vacation_to_date, v.vacation_from_date,
        e.employee_id,e.employee_username, v.vacation_status
        FROM vacation AS v JOIN employee as e 
        ON v.employee_id = e.employee_id
        WHERE v.vacation_id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $vac = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
}

$vTitle = FILTER_INPUT(INPUT_POST, 'vacationTitle', FILTER_SANITIZE_SPECIAL_CHARS);
$vFDate = FILTER_INPUT(INPUT_POST, 'vacationFromDate', FILTER_SANITIZE_SPECIAL_CHARS);
$vTDate = FILTER_INPUT(INPUT_POST, 'vacationToDate', FILTER_SANITIZE_SPECIAL_CHARS);
$vStatus = FILTER_INPUT(INPUT_POST, 'vacationStatus', FILTER_SANITIZE_SPECIAL_CHARS);
$veID = FILTER_INPUT(INPUT_POST, 'vacationEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$edit = FILTER_INPUT(INPUT_POST, 'vID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (!isset($_GET['edit'])) {

    // Retrieve the record to edit
    $sql1 = "SELECT v.vacation_id, v.vacation_title, v.vacation_to_date, v.vacation_from_date,
        e.employee_id,e.employee_username, v.vacation_status
        FROM vacation AS v JOIN employee as e 
        ON v.employee_id = e.employee_id
        WHERE v.vacation_id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $vac = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
    if ($exec1) {
    } else {
        die("Error retrieving department: " . mysqli_error($conn));
    }
}

if (isset($_POST['editVacation'])) {
    (empty($vTitle) || empty($vFDate) || empty($vTDate) || empty($veID) || empty($vStatus)) ?  $errMsg = "All Fields Are Required" : $errMsg = '';

    //adding data to database
    $sql2 = "UPDATE vacation
        SET vacation_title = '$vTitle', 
        vacation_from_date = '$vFDate', 
        vacation_to_date = '$vTDate',
        vacation_status = '$vStatus',
        employee_id = '$veID'
        WHERE vacation_id = '$edit';
";

    if ($errMsg == '' && mysqli_query($conn, $sql2)) {
        $msg = "Vacation Updated Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("vacationList.php"); </script>';
    } else {
        $msg = '' . mysqli_error($conn);
        $status = '';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        // echo '<script> location.replace("trainingListAdd.php"); </script>';
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-suitcase"></i>
            </span> Vacations
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
                    <h4 class="card-title mb-5">Edit Vacation</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" value="<?php echo $vac['vacation_id']?>" name="vID" /> 
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationTitle">Vacation Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="vacationTitle" name="vacationTitle" placeholder="Enter vacation's title"
                                    value="<?php echo $vac['vacation_title']?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username</label>
                                    <select class="form-select" id="exampleSelectGender" name="vacationEmployeeID">
                                        <option value="">Select ..</option>
                                        <?php foreach ($allEmployees as $employ) : ?>
                                            <option class="dropdown-item" value='<?php echo $employ['employee_id']; ?>' <?php echo $vac['employee_id'] == $employ['employee_id'] ? "selected='selected'": ''?>>
                                                <?php echo $employ['employee_username']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationFromDate">Vacation Start Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="vacationFromDate" name="vacationFromDate" placeholder="Enter the date vacation begins" value="<?php echo $vac['vacation_from_date']?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationToDate">Vacation End Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="vacationToDate" name="vacationToDate" placeholder="Enter the date vacation ends" value="<?php echo $vac['vacation_to_date']?>" required>
                                </div>
                            </div>
                            <div class="col-md-11" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
                                <div class="form-group">
                                    <label for="exampleSelectGender">Vacation Status</label>
                                    <select class="form-select" id="exampleSelectGender" name="vacationStatus" required <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'disabled' : "" ?>>
                                        <option value="accepted" <?php echo $vac['vacation_status'] == 'accepted' ? 'selected="selected"' : ""; ?>>Accept</option>
                                        <option value="denied" <?php echo $vac['vacation_status'] == 'denied' ? 'selected="selected"' : ""; ?>>Denied</option>
                                        <option value="waiting" <?php echo $vac['vacation_status'] == 'waiting' ? 'selected="selected"' : ""; ?>>Waiting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="editVacation" value="SAVE">
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