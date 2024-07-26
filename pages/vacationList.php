<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
include '../inc/headerStart.php';

$sql = "SELECT v.vacation_id, v.vacation_title, v.vacation_to_date, v.vacation_from_date,
                e.employee_id,e.employee_username, v.vacation_status
        FROM vacation AS v JOIN employee as e 
        ON v.employee_id = e.employee_id;";
$exec = mysqli_query($conn, $sql);
$allVacations = mysqli_fetch_all($exec, MYSQLI_ASSOC);


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
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="vacationAdd.php"><button type="button" class="btn btn-gradient-primary"><i class="fa fa-plus-circle"></i> Add Vacation</button></a>
                    <h4 class="card-title mt-5">Training</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Vacation Title </th>
                                    <th> Employee Username </th>
                                    <th> Vacation From Date </th>
                                    <th> Vacation To Date </th>
                                    <th> Status </th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($allVacations as $depart) : ?>
                                    <tr>
                                        <td> <?php echo $depart['vacation_title']; ?> </td>
                                        <td> <?php echo $depart['employee_username']; ?></td>
                                        <td> <?php echo $depart['vacation_from_date']; ?></td>
                                        <td> <?php echo $depart['vacation_to_date']; ?></td>
                                        <td> <?php echo $depart['vacation_status']; ?></td>
                                        <td>
                                            <a href="vacationEdit.php?edit=<?php echo $depart['vacation_id']; ?>&status="><button type="button" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-file-check btn-icon-append"></i> Edit
                                                </button></a>
                                            <a href="vacationDelete.php?delete=<?php echo $depart['vacation_id']; ?>"><button type="button" class="btn btn-gradient-danger" onclick="return confirm('Are you sure you want to delete')"><i class="fa fa-trash-o btn-icon-append"></i> Delete</button></a>
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