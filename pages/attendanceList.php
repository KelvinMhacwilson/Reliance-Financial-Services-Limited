<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: ../pages/login.php");
}
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$sql = "SELECT a.att_id, a.employee_id, a.att_type, a.att_time_date, e.employee_username
        FROM attendance AS a JOIN employee as e 
        ON a.employee_id = e.employee_id;";
$exec = mysqli_query($conn, $sql);
$allAttendance = mysqli_fetch_all($exec, MYSQLI_ASSOC);


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-check-circle"></i>
            </span> Attandance
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
                    <a href="attendanceAdd.php"><button type="button" class="btn btn-gradient-primary"><i class="fa fa-plus-circle"></i> Add Attendance</button></a>
                    <h4 class="card-title mt-5">Attendance</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Employee Username </th>
                                    <th> Attendance Type </th>
                                    <th> Date Time </th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($allAttendance as $depart) : ?>
                                    <tr>
                                        <td> <?php echo $depart['employee_username']; ?> </td>
                                        <td> <?php echo $depart['att_type']; ?></td>
                                        <td> <?php echo $depart['att_time_date']; ?></td>
                                        <td>
                                            <a href="attendanceEdit.php?edit=<?php echo $depart['att_id']; ?>&status="><button type="button" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-file-check btn-icon-append"></i> Edit
                                                </button></a>
                                            <a href="attendanceDelete.php?delete=<?php echo $depart['att_id']; ?>"><button type="button" class="btn btn-gradient-danger" onclick="return confirm('Are you sure you want to delete')"><i class="fa fa-trash-o btn-icon-append"></i> Delete</button></a>
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