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
    $sql1 = "SELECT s.id, s.bonus, s.salary, s.loan, s.last_update, s.employee_id, s.salary_type,
        e.employee_id, e.employee_username
        FROM salary AS s JOIN employee as e 
        ON s.employee_id = e.employee_id
        WHERE s.id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $sala = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
}

$sSalary = FILTER_INPUT(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
$sLoan = FILTER_INPUT(INPUT_POST, 'salaryLoan', FILTER_SANITIZE_SPECIAL_CHARS);
$sBonus = FILTER_INPUT(INPUT_POST, 'salaryBonus', FILTER_SANITIZE_SPECIAL_CHARS);
$sType = FILTER_INPUT(INPUT_POST, 'salaryType', FILTER_SANITIZE_SPECIAL_CHARS);
$seID = FILTER_INPUT(INPUT_POST, 'salaryEmployeeID', FILTER_SANITIZE_SPECIAL_CHARS);
$edit = FILTER_INPUT(INPUT_POST, 'sID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (!isset($_GET['edit'])) {

    // Retrieve the record to edit
    $sql1 = "SELECT s.id, s.bonus, s.salary, s.loan, s.last_update, s.employee_id, s.salary_type,
        e.employee_id, e.employee_username
        FROM salary AS s JOIN employee as e 
        ON s.employee_id = e.employee_id
        WHERE s.id = $edit;";
    $exec1 = mysqli_query($conn, $sql1);
    $sala = mysqli_fetch_array($exec1, MYSQLI_ASSOC);
    if ($exec1) {
    } else {
        die("Error retrieving Training: " . mysqli_error($conn));
    }
}

if (isset($_POST['editSalary'])) {
    (empty($sSalary) || empty($seID) || empty($sType)) ?  $errMsg = "All Fields Are Required Execpt Laon And Bonus" : $errMsg = '';

    //adding data to database
    $sql1 = "INSERT INTO salary (salary, salary_type , loan, bonus, employee_id)
        VALUES ('$sSalary', '$sType', '$sLoan', '$sBonus', '$seID')";

    $sql2 = "UPDATE salary
        SET salary = '$sSalary',
        salary_type = '$sType',
        loan = '$sLoan',
        bonus = '$sBonus',
        employee_id = '$seID'
        WHERE id = $edit";

    if ($errMsg == '' && mysqli_query($conn, $sql2)) {
        $msg = "Salary Updated Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("salaryList.php"); </script>';
    } else {
        $msg = '' . mysqli_error($conn);
        $status = '';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        // echo '<script> location.replace("salaryListAdd.php"); </script>';
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-money"></i>
            </span> Salary
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
                    <h4 class="card-title mb-5">Edit Salary</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" value="<?php echo $sala['id']?>" name="sID" /> 
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Employee's Username<span class="text-danger">*</span></label>
                                    <select class="form-select" id="exampleSelectGender" name="salaryEmployeeID" required>
                                        <option value="">Select ..</option>
                                        <?php foreach ($allEmployees as $employ) : ?>
                                            <option class="dropdown-item" value='<?php echo $employ['employee_id']; ?>' <?php echo $sala['employee_id'] == $employ['employee_id'] ? "selected='selected'": ''?>>
                                                <?php echo $employ['employee_username']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="salary">Salary Amount<span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" maxlength="7" class="form-control " id="salary" name="salary" placeholder="Enter salary amount" value="<?php echo $sala['salary']?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="salaryType">Type of Salary<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="salaryType" name="salaryType" placeholder="Enter salary type" value="<?php echo $sala['salary_type']?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="salaryBonus">Bonus</label>
                                    <input type="number" step="0.01" min="0" maxlength="7" class="form-control " id="salaryBonus" name="salaryBonus" placeholder="Enter bonus amount" value="<?php echo $sala['bonus']?>">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="salaryLoan">Loan</label>
                                    <input type="number" step="0.01" min="0" maxlength="7" class="form-control " id="salaryLoan" name="salaryLoan" placeholder="Enter laon amount" value="<?php echo $sala['loan']?>">
                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="editSalary" value="SAVE">
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