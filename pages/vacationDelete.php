<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../pages/login.php");
  }
include '../inc/headerStart.php';


$_SESSION['delete'] = $_GET['delete'];
$delete = $_SESSION['delete'];
$msg = '';
$status = '';

$sql = "DELETE FROM vacation WHERE vacation_id = $delete";
if (mysqli_query($conn, $sql)) {
    $msg = "Vacation Deleted Successfully";
    $status = 'success';
    $_SESSION['status'] = $status;
    $_SESSION['msg'] = $msg;
    echo '<script> location.replace("vacationList.php"); </script>';

    
} else {
    $msg = 'Vacation Not Deleted';
    $status = 'danger';
    $_SESSION['status'] = $status;
    $_SESSION['msg'] = $msg;
    echo '<script> location.replace("vacationList.php"); </script>';
}



?>

<div class="content-wrapper">

    <!-- <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="mb-5 mt-5 text-<?php echo $status ?>"><?php echo $msg ?></h1>
                    


                </div>
            </div>
        </div>

    </div> -->



</div>

<!-- <script>
    setTimeout(function() {
        location.replace("departmentListAdd.php");
    }, 3000);
</script>' -->
<?php


include '../inc/headerEnd.php';
?>