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

if (isset($_GET['edit'])) {
    $edit = intval($_GET['edit']); // Sanitize the input
    $_SESSION['edit'] = $edit;

    // Retrieve the record to edit
    $sql1 = "SELECT t.training_id, t.training_name, t.training_employee_id, t.training_registration, 
        t.training_type, t.training_year, t.training_description, e.employee_username
        FROM trainings AS t JOIN employee as e 
        ON t.training_employee_id = e.employee_id
        WHERE t.training_id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $train = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
}


$tName = FILTER_INPUT(INPUT_POST, 'trainingName', FILTER_SANITIZE_SPECIAL_CHARS);
$tYear = FILTER_INPUT(INPUT_POST, 'trainingYear', FILTER_SANITIZE_SPECIAL_CHARS);
$tDescription = FILTER_INPUT(INPUT_POST, 'trainingDescription', FILTER_SANITIZE_SPECIAL_CHARS);
$tRegistration = FILTER_INPUT(INPUT_POST, 'trainingRegistration', FILTER_SANITIZE_SPECIAL_CHARS);
$tType = FILTER_INPUT(INPUT_POST, 'trainingType', FILTER_SANITIZE_SPECIAL_CHARS);
$teID = FILTER_INPUT(INPUT_POST, 'trainingEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$edit = FILTER_INPUT(INPUT_POST, 'tID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (!isset($_GET['edit'])) {

    // Retrieve the record to edit
    $sql1 = "SELECT t.training_id, t.training_name, t.training_registration, 
    t.training_type, t.training_year, t.training_description, e.employee_username
    FROM trainings AS t JOIN employee as e 
    ON t.training_employee_id = e.employee_id
    WHERE t.training_id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $train = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
    if ($exec1) {
    } else {
        die("Error retrieving Training: " . mysqli_error($conn));
    }
}

if (isset($_POST['editTraining'])) {
    (empty($tName) || empty($tYear) || empty($tType)) ?  $errMsg = "All Fields Are Required Execpt Description and Registration" : $errMsg = '';

    //updating data

    $sql2 = "UPDATE trainings
        SET training_name = '$tName',
        training_description = '$tDescription',
        training_employee_id = '$teID',
        training_registration = '$tRegistration',
        training_type = '$tType',
        training_year = '$tYear'
        WHERE training_id = $edit";

    if ($errMsg == '' && mysqli_query($conn, $sql2)) {
        $msg = "Training Updated Successfully";
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
                    <h4 class="card-title mb-5">Edit Training</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" value="<?php echo $train['training_id']?>" name="tID" /> 
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingName">Training Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="trainingName" name="trainingName" placeholder="Enter training name" required
                                    value="<?php echo $train['training_name']?>" >
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingType">Training Type<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="trainingType" name="trainingType" placeholder="Enter training type" required
                                    value="<?php echo $train['training_type']?>">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username</label>
                                    <select class="form-select" id="exampleSelectGender" name="trainingEmployeeID">
                                        <option value="">Select ..</option>
                                        <?php foreach ($allEmployees as $employ) : ?>
                                            <option class="dropdown-item" value='<?php echo $employ['employee_id']; ?>' <?php echo $train['training_employee_id'] == $employ['employee_id'] ? "selected='selected'": ''?>>
                                                <?php echo $employ['employee_username']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingYear">Year<span class="text-danger">*</span></label>
                                    <input type="year" class="form-control" id="trainingYear" name="trainingYear" placeholder="Enter training year" required
                                    value="<?php echo $train['training_year']?>">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="trainingRegistration">Registration</label>
                                    <input type="text" class="form-control " id="trainingRegistration" name="trainingRegistration" placeholder="Enter training registration" value="<?php echo $train['training_registration']?>">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="trainingDescription" rows="3" placeholder="Describe the Training"><?php echo $train['training_description']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="editTraining" value="SAVE">
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