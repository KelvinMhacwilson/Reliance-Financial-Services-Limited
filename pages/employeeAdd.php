<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
  if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$eName = FILTER_INPUT(INPUT_POST, 'employeeName', FILTER_SANITIZE_SPECIAL_CHARS);
$eEmail = FILTER_INPUT(INPUT_POST, 'employeeEmail', FILTER_SANITIZE_SPECIAL_CHARS);
$ePassword = FILTER_INPUT(INPUT_POST, 'employeeUsername', FILTER_SANITIZE_SPECIAL_CHARS);
$eMobile = FILTER_INPUT(INPUT_POST, 'employeeMobile', FILTER_SANITIZE_SPECIAL_CHARS);
$eUsername = FILTER_INPUT(INPUT_POST, 'employeeUsername', FILTER_SANITIZE_SPECIAL_CHARS);
$eAddress = FILTER_INPUT(INPUT_POST, 'employeeAddress', FILTER_SANITIZE_SPECIAL_CHARS);
$eRole = FILTER_INPUT(INPUT_POST, 'employeeRole', FILTER_SANITIZE_SPECIAL_CHARS);
$eAuth = FILTER_INPUT(INPUT_POST, 'employeeAuth', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addEmployee'])) {
    (empty($eName) || empty($eEmail) || empty($ePassword) || empty($eMobile) || empty($eUsername) || empty($eAddress) || empty($eRole) || empty($eAuth)) ?  $errMsg = "All Fields Are Compulsory" : $errMsg = '';

    // check if username or email already exists
    $verify_username = "SELECT employee_username FROM employee WHERE employee_username = '$eUsername'";
    $verify_email = "SELECT employee_email FROM employee WHERE employee_email = '$eEmail'";
    $verify_admin_username = "SELECT username FROM admin WHERE username = '$eUsername'";
    $verify_admin_email = "SELECT admin_email FROM admin WHERE admin_email = '$eEmail'";

    $execution_verifyUsername = mysqli_query($conn, $verify_username);
    $execution_verifyEmail = mysqli_query($conn, $verify_email);
    $execution_admin_verifyUsername = mysqli_query($conn, $verify_admin_username);
    $execution_admin_verifyEmail = mysqli_query($conn, $verify_admin_email);

    // encrypt password before storing it in database
    $ePassword = $eUsername;
    // $password = isset($_POST[$ePassword]) && !empty($_POST[$ePassword]) ? "" : password_hash($_POST[$ePassword], PASSWORD_BCRYPT);
    $password = md5($ePassword);

    if ($eRole == 'admin') {
        $sql2 = "INSERT INTO admin (admin_name, admin_password , admin_email, username)
        VALUES ('$eName', '$password', '$eEmail', '$eUsername')";

        if (mysqli_num_rows($execution_admin_verifyUsername) != 0 && mysqli_num_rows($execution_admin_verifyEmail) != 0) {
            $errMsg = "Both username and email are already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_admin_verifyUsername) != 0) {
            $errMsg = "This username is already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_admin_verifyEmail) != 0) {
            $errMsg = "This email is already used, Try another one please!";
        } else {
            if ($errMsg == '' && mysqli_query($conn, $sql2)) {
                $msg = "Admin Added Successfully";
                $status = 'success';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                echo '<script> location.replace("employeeList.php"); </script>';
            } else {
                $msg = '' . mysqli_error($conn);
                $status = '';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                // echo '<script> location.replace("trainingListAdd.php"); </script>';
            }
        }
    } else {

        //adding data to database
        $sql1 = "INSERT INTO employee (employee_name, employee_password , employee_address,         employee_mobile, employee_email, employee_username, role, authorized)
            VALUES ('$eName', '$password', '$eAddress', '$eMobile', '$eEmail', '$eUsername', '$eRole','$eAuth')";

        if (mysqli_num_rows($execution_verifyUsername) != 0 && mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "Both username and email are already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyUsername) != 0) {
            $errMsg = "This username is already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "This email is already used, Try another one please!";
        } else {
            if ($errMsg == '' && mysqli_query($conn, $sql1)) {
                $msg = "Employee Added Successfully";
                $status = 'success';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                echo '<script> location.replace("employeeList.php"); </script>';
            } else {
                $msg = '' . mysqli_error($conn);
                $status = '';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                // echo '<script> location.replace("trainingListAdd.php"); </script>';
            }
        }
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-users"></i>
            </span> Employee
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
                    <h4 class="card-title mb-5">Add Employee</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="employeeName">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="employeeName" name="employeeName" placeholder="Enter employee's name" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="employeeEmail">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" placeholder="Enter employee's email" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="employeeUsername">Username<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="employeeUsername" name="employeeUsername" placeholder="Enter employee's username" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="employeeAddress">Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="employeeAddress" name="employeeAddress" placeholder="Enter employee's address" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="employeeMobile">Mobile<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+233</span>
                                        </div>
                                        <input type="number" class="form-control " id="employeeMobile" name="employeeMobile" minlength="9" placeholder="Enter employee's mobile" maxlength="9" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-11" <?php echo $_SESSION['role'] != 'admin' ? 'style="display: none"' : "" ?>>
                                <div class="form-group">
                                    <label for="exampleSelectGender">Role</label>
                                    <select class="form-select" id="exampleSelectGender" name="employeeRole" required <?php echo $_SESSION['role'] != 'admin' ? 'disabled' : "" ?>>
                                        <option value="admin">Administrator</option>
                                        <option value="department">Department Manager</option>
                                        <option value="hr">HR Manager</option>
                                        <option value="employee" selected="selected">Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-11" >
                                <div class="form-group">
                                    <label>Authorization</label>
                                    <div class="my-2 ">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="employeeAuth" id="optionsRadios1" value="valid" required> Valid </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="employeeAuth" id="optionsRadios2" value="invalid" checked required> Invalid </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <h5 class="text-danger">NOTE: The first username saved would be used as the default password.</h5>

                                </div>
                            </div>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addEmployee" value="ADD">
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