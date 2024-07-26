<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
  if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr') {
    header("Location: ../pages/index.php");
}
include '../inc/headerStart.php';

$sql = "SELECT s.id, s.bonus, s.salary, s.loan, s.last_update, s.employee_id, s.salary_type,
        e. employee_id, e.employee_username
        FROM salary AS s JOIN employee as e 
        ON s.employee_id = e.employee_id;";
$exec = mysqli_query($conn, $sql);
$allSalaries = mysqli_fetch_all($exec, MYSQLI_ASSOC);


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-money"></i>
            </span> Salaries
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
                    <a href="salaryAdd.php"><button type="button" class="btn btn-gradient-primary"><i class="fa fa-plus-circle"></i> Add Salary</button></a>
                    <h4 class="card-title mt-5">Salary</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Employee Username </th>
                                    <th> Salary </th>
                                    <th> Salary Type </th>
                                    <th> Bonus </th>
                                    <th> Loan </th>
                                    <th> Last Updated </th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($allSalaries as $depart) : ?>
                                    <tr>
                                        <td> <?php echo $depart['employee_username']; ?></td>
                                        <td> <?php echo $depart['salary']; ?></td>
                                        <td> <?php echo $depart['salary_type']; ?></td>
                                        <td> <?php echo $depart['bonus']; ?></td>
                                        <td> <?php echo $depart['loan']; ?></td>
                                        <td> <?php echo $depart['last_update']; ?></td>
                                        <td>
                                            <a href="salaryEdit.php?edit=<?php echo $depart['id']; ?>&status="><button type="button" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-file-check btn-icon-append"></i> Edit
                                                </button></a>
                                            <a href="salaryDelete.php?delete=<?php echo $depart['id']; ?>"><button type="button" class="btn btn-gradient-danger" onclick="return confirm('Are you sure you want to delete')"><i class="fa fa-trash-o btn-icon-append"></i> Delete</button></a>
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