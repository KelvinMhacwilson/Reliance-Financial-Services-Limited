<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: ../pages/login.php");
}
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$sql = "SELECT * FROM departments;";
$exec = mysqli_query($conn, $sql);
$allDepartments = mysqli_fetch_all($exec, MYSQLI_ASSOC);

$dName = FILTER_INPUT(INPUT_POST, 'departmentName', FILTER_SANITIZE_SPECIAL_CHARS);
$dType = FILTER_INPUT(INPUT_POST, 'departmentType', FILTER_SANITIZE_SPECIAL_CHARS);
$dDiscription = FILTER_INPUT(INPUT_POST, 'departmentDiscription', FILTER_SANITIZE_SPECIAL_CHARS);
$errMsg = "";
$msg = "";

if (isset($_POST['addDepartment'])) {
    (empty($dType) || empty($dName)) ?  $errMsg = "Department Name or Type can't be empty" : $errMsg = '';

    //adding data to movie tables in database
    $sql1 = "INSERT INTO departments (department_name, department_type, department_description)
        VALUES ('$dName', '$dType', '$dDiscription')";


    if ($errMsg == '' && mysqli_query($conn, $sql1)) {
        $msg = "Department Added Successfully";
        $status = 'success';
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        echo '<script> location.replace("departmentListAdd.php"); </script>';
    } else {
        $msg = '' . mysqli_error($conn);
        $status = '';
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
                    <h4 class="card-title mb-2">Add Department</h4>
                    <h6 class="text-danger mb-2 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="departmentName">Department Name</label>
                                    <input type="text" class="form-control " id="departmentName" name="departmentName" placeholder="Enter department name" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="departmentType">Department Type</label>
                                    <input type="text" class="form-control" id="departmentType" name="departmentType" placeholder="Enter department Type" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Discription</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="departmentDiscription" rows="3" placeholder="Describe the Department"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="addDepartment" value="ADD">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Departments</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Department Name </th>
                                    <th> Department Type </th>
                                    <th> Discription </th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($allDepartments as $depart) : ?>
                                    <tr>
                                        <td> <?php echo $depart['department_name']; ?> </td>
                                        <td> <?php echo $depart['department_type']; ?></td>
                                        <td> <?php echo $depart['department_description']; ?></td>
                                        <td>
                                            <a href="departmentEdit.php?edit=<?php echo $depart['department_id']; ?>&status="><button type="button" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-file-check btn-icon-append"></i> Edit
                                                </button></a>
                                            <a href="departmentDelete.php?delete=<?php echo $depart['department_id']; ?>"><button type="button" class="btn btn-gradient-danger" onclick="return confirm('Are you sure you want to delete')"><i class="fa fa-trash-o btn-icon-append"></i> Delete</button></a>
                                        </td>
                                    </tr>

                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- content-wrapper ends -->


<?php

include '../inc/headerEnd.php';

?>