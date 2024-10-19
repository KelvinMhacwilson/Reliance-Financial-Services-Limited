<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
  if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$sql = "SELECT employee_id, employee_username FROM employee;";
$exec = mysqli_query($conn, $sql);
$allEmployees = mysqli_fetch_all($exec, MYSQLI_ASSOC);

$tName = FILTER_INPUT(INPUT_POST, 'trainingName', FILTER_SANITIZE_SPECIAL_CHARS);
$tYear = FILTER_INPUT(INPUT_POST, 'trainingYear', FILTER_SANITIZE_SPECIAL_CHARS);
$tDescription = FILTER_INPUT(INPUT_POST, 'trainingDescription', FILTER_SANITIZE_SPECIAL_CHARS);
$tRegistration = FILTER_INPUT(INPUT_POST, 'trainingRegistration', FILTER_SANITIZE_SPECIAL_CHARS);
$tType = FILTER_INPUT(INPUT_POST, 'trainingType', FILTER_SANITIZE_SPECIAL_CHARS);
$teID = FILTER_INPUT(INPUT_POST, 'trainingEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addTraining'])) {
    (empty($tName) || empty($tYear) || empty($tType)) ?  $errMsg = "All Fields Are Required Execpt Description, Employee And Registration" : $errMsg = '';

    //adding data to database
    $sql1 = "INSERT INTO trainings (training_name, training_description , training_employee_id, training_registration, training_type, training_year)
        VALUES ('$tName', '$tDescription', '$teID', '$tRegistration', '$tType', '$tYear')";

    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Training Added Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("trainingList.php"); </script>';
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
                <i class="fa fa-institution"></i>
            </span> Training
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
                    <h4 class="card-title mb-5">Add Training</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingName">Training Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="trainingName" name="trainingName" placeholder="Enter training name" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingType">Training Type<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="trainingType" name="trainingType" placeholder="Enter training type" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username</label>
                                    <select class="form-select" id="exampleSelectGender" name="trainingEmployeeID">
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
                                    <label for="trainingYear">Year<span class="text-danger">*</span></label>
                                    <input type="year" class="form-control" id="trainingYear" name="trainingYear" placeholder="Enter training year" maxlength="4" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingRegistration">Registration</label>
                                    <input type="text" class="form-control " id="trainingRegistration" name="trainingRegistration" placeholder="Enter training registration">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="trainingDescription" rows="3" placeholder="Describe the Training"></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addTraining" value="ADD">
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