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

$eValue = FILTER_INPUT(INPUT_POST, 'evalValue', FILTER_SANITIZE_SPECIAL_CHARS);
$eNotes = FILTER_INPUT(INPUT_POST, 'evalNotes', FILTER_SANITIZE_SPECIAL_CHARS);
$eID = FILTER_INPUT(INPUT_POST, 'evalEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addEvaluation'])) {
    (empty($eID) || empty($eValue) ?  $errMsg = "All Fields Are Required Execpt Notes" : $errMsg = '');

    //adding data to database
    $sql1 = "INSERT INTO evaluation (eval_value, employee_id, notes)
        VALUES ('$eValue', '$eID', '$eNotes')";

    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Evaluation Added Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("evaluationList.php"); </script>';
    } else {
        $msg = '' . mysqli_error($conn);
        $status = '';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        // echo '<script> location.replace("evaluationListAdd.php"); </script>';
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-institution"></i>
            </span> Evaluation
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
                    <h4 class="card-title mb-5">Add Evaluation</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username<span class="text-danger">*</span></label>
                                    <select class="form-select" id="exampleSelectGender" name="evalEmployeeID" required>
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
                                    <label for="eValue">Evaluation Value(%)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="eValue" max="100" min="0" name="evalValue" placeholder="Enter evaluation value" maxlength="5" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Notes</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="evalNotes" rows="3" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addEvaluation" value="ADD">
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