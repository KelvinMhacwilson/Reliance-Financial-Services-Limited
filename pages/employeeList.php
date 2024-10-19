<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
  if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$sql = "SELECT * FROM employee;";
$exec = mysqli_query($conn, $sql);
$allEmployees = mysqli_fetch_all($exec, MYSQLI_ASSOC);


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-users"></i>
            </span> Employees
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
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="employeeAdd.php"><button type="button" class="btn btn-gradient-primary" ><i class="fa fa-plus-circle"></i> Add Employee</button></a>
                    <h4 class="card-title mt-5">Employees</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Name </th>
                                    <th> Email </th>
                                    <th> Username </th>
                                    <th> Address </th>
                                    <th> Mobile </th>
                                    <th> Role </th>
                                    <th> Authorization </th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($allEmployees as $depart) : ?>
                                    <tr>
                                        <td> <?php echo $depart['employee_name']; ?> </td>
                                        <td> <?php echo $depart['employee_email']; ?></td>
                                        <td> <?php echo $depart['employee_username']; ?></td>
                                        <td> <?php echo $depart['employee_address']; ?></td>
                                        <td> <?php echo $depart['employee_mobile']; ?></td>
                                        <td> <?php echo $depart['role']; ?></td>
                                        <td> <?php echo $depart['authorized']; ?></td>
                                        <td>
                                            <a href="employeeEdit.php?edit=<?php echo $depart['employee_id']; ?>&status="><button type="button" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-file-check btn-icon-append"></i> Edit
                                                </button></a>
                                            <a href="employeeDelete.php?delete=<?php echo $depart['employee_id']; ?>"><button type="button" class="btn btn-gradient-danger" onclick="return confirm('Are you sure you want to delete')"><i class="fa fa-trash-o btn-icon-append"></i> Delete</button></a>
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