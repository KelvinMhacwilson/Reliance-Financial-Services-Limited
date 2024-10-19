<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: ../pages/login.php");
}
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';


if (isset($_GET['edit'])) {
    $edit = intval($_GET['edit']); // Sanitize the input
    $_SESSION['edit'] = $edit;

    // Retrieve the record to edit
    $sql = "SELECT * FROM departments WHERE department_id = $edit";
    $exec = mysqli_query($conn, $sql);
    $depart = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    }
    // else {
    //     die("Error retrieving department: " . mysqli_error($conn));
    // }
}



$dName = FILTER_INPUT(INPUT_POST, 'departmentName', FILTER_SANITIZE_SPECIAL_CHARS);
$dType = FILTER_INPUT(INPUT_POST, 'departmentType', FILTER_SANITIZE_SPECIAL_CHARS);
$dDescription = FILTER_INPUT(INPUT_POST, 'departmentDiscription', FILTER_SANITIZE_SPECIAL_CHARS);
$edit = FILTER_INPUT(INPUT_POST, 'dID', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (!isset($_GET['edit'])) {

    // Retrieve the record to edit
    $sql = "SELECT * FROM departments WHERE department_id = $edit";
    $exec = mysqli_query($conn, $sql);
    $depart = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    } else {
        die("Error retrieving department: " . mysqli_error($conn));
    }
}

if (isset($_POST['editDepartment'])) {
    (empty($dType) || empty($dName)) ?  $errMsg = "Department Name or Type can't be empty" : $errMsg = '';


    $sql1 = "UPDATE departments
                    SET department_name = '$dName',
                    department_type = '$dType',
                    department_description = '$dDescription'
                    WHERE department_id = $edit";


    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Department Updated Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("departmentListAdd.php"); </script>';
    } else {
        $msg = 'Department Not Edited' . mysqli_error($conn);
        $status = 'danger';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        // echo '<script> location.replace("departmentListAdd.php"); </script>';
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-building"></i>
            </span> Departments
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
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Department</h4>
                    <h6 class="text-danger mb-2 mt-2"><?php echo $errMsg ? $errMsg : ''; ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" value="<?php echo $depart['department_id'] ?>" name="dID" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departmentName">Department Name</label>
                                    <input type="text" class="form-control " id="departmentName" name="departmentName" placeholder="Enter department name" value="<?php echo $depart['department_name'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departmentType">Department Type</label>
                                    <input type="text" class="form-control" id="departmentType" name="departmentType" placeholder="Enter department Type" value="<?php echo $depart['department_type'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Discription</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="departmentDiscription" rows="3" placeholder="Describe the Department"><?php echo $depart['department_description'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text w-100" name="editDepartment" value="SAVE">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php $errMsg = ""; ?>


</div>
<!-- content-wrapper ends -->


<?php

include '../inc/headerEnd.php';

?>