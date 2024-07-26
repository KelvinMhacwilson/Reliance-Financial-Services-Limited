<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
include '../inc/headerStart.php';

$sql = "SELECT employee_id, employee_username FROM employee;";
$exec = mysqli_query($conn, $sql);
$allEmployees = mysqli_fetch_all($exec, MYSQLI_ASSOC);

$vTitle = FILTER_INPUT(INPUT_POST, 'vacationTitle', FILTER_SANITIZE_SPECIAL_CHARS);
$vFDate = FILTER_INPUT(INPUT_POST, 'vacationFromDate', FILTER_SANITIZE_SPECIAL_CHARS);
$vTDate = FILTER_INPUT(INPUT_POST, 'vacationToDate', FILTER_SANITIZE_SPECIAL_CHARS);
$veID = FILTER_INPUT(INPUT_POST, 'vacationEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addVacation'])) {
    (empty($vTitle) || empty($vFDate) || empty($vTDate) || empty($veID)) ?  $errMsg = "All Fields Are Required" : $errMsg = '';

    //adding data to database
    $sql1 = "INSERT INTO vacation (vacation_title, vacation_from_date , vacation_to_date, employee_id)
        VALUES ('$vTitle', '$vFDate', '$vTDate', '$veID')";

    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Vacation Created Successfully";
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
                    <h4 class="card-title mb-5">Add Vacation</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationTitle">Vacation Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="vacationTitle" name="vacationTitle" placeholder="Enter vacation's title" required>
                                </div>
                            </div>
                            <div class="col-md-11" <?php echo $_SESSION['role'] == 'employee' ? 'style="display: none"' : "" ?>>
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username</label>
                                    <select class="form-select" id="exampleSelectGender" name="vacationEmployeeID">
                                        <option value="">Select ..</option>
                                        <?php foreach ($allEmployees as $employ) : ?>
                                            <option class="dropdown-item" value='<?php echo $_SESSION['role'] == 'employee' ? $_SESSION['id'] : $employ['employee_id']; ?>'>
                                                <?php echo $employ['employee_username']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationFromDate">Vacation Start Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="vacationFromDate" name="vacationFromDate" placeholder="Enter the date vacation begins" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="vacationToDate">Vacation End Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="vacationToDate" name="vacationToDate" placeholder="Enter the date vacation ends" required>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addVacation" value="ADD">
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