<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: ../pages/login.php");
}
include '../inc/headerStart.php';

$name = FILTER_INPUT(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = FILTER_INPUT(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$username = FILTER_INPUT(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$address = FILTER_INPUT(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$mobile = FILTER_INPUT(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS);

$valueName = "";
$valueUsername = "";
$valueAddress = "";
$valueEmail = "";
$valueMobile = "";
$errMsg = "";
$errMsg2 = "";
$msg = "";
$id = $_SESSION['id'];

if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM admin WHERE admin_id = $id";
    $exec = mysqli_query($conn, $sql);
    $employ = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    } else {
        die("Error retrieving employees: " . mysqli_error($conn));
    }

    $valueEmail = $employ['admin_email'];
    $valueName = $employ['admin_name'];
    $valueUsername = $employ['username'];

    if (isset($_POST['editAdminProfile'])) {
        (empty($name) || empty($email) || empty($username)) ?  $errMsg = "All Fields Are Compulsory" : $errMsg = '';

        // check if username and password already exists
        $verify_username = "SELECT username FROM admin WHERE username = '$username' AND admin_id <> '$id'";
        $verify_email = "SELECT admin_email FROM admin WHERE admin_email = '$email' AND admin_id <> '$id'";

        $execution_verifyUsername = mysqli_query($conn, $verify_username);
        $execution_verifyEmail = mysqli_query($conn, $verify_email);

        //updating data 
        $sql1 = "UPDATE admin
            SET admin_name = '$name',
            admin_email = '$email',
            username = '$username'
            WHERE admin_id = $id";

        if (mysqli_num_rows($execution_verifyUsername) != 0 && mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "Both username and email are already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyUsername) != 0) {
            $errMsg = "This username is already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "This email is already used, Try another one please!";
        } else {
            if ($errMsg == '' && mysqli_query($conn, $sql1)) {
                $msg = "Profile Updated Successfully";
                $status = 'success';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                echo '<script> location.replace("profile.php"); </script>';
            } else {
                $msg = 'Profile not Updated' . mysqli_error($conn);
                $status = 'danger';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                // echo '<script> location.replace("profile.php"); </script>';
            }
        }
    }
} else {
    $sql = "SELECT * FROM employee WHERE employee_id = $id";
    $exec = mysqli_query($conn, $sql);
    $employ = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    } else {
        die("Error retrieving employees: " . mysqli_error($conn));
    }

    $valueAddress = $employ['employee_address'];
    $valueEmail = $employ['employee_email'];
    $valueName = $employ['employee_name'];
    $valueMobile = $employ['employee_mobile'];
    $valueUsername = $employ['employee_username'];

    if (isset($_POST['editEmployeeProfile'])) {
        (empty($name) || empty($email) || empty($mobile) || empty($username) || empty($address)) ?  $errMsg = "All Fields Are Compulsory" : $errMsg = '';

        // check if username and password already exists
        $verify_username = "SELECT employee_username FROM employee WHERE employee_username = '$username' AND employee_id <> '$id'";
        $verify_email = "SELECT employee_email FROM employee WHERE employee_email = '$email' AND employee_id <> '$id'";

        $execution_verifyUsername = mysqli_query($conn, $verify_username);
        $execution_verifyEmail = mysqli_query($conn, $verify_email);

        //updating data 
        $sql1 = "UPDATE employee
            SET employee_name = '$name',
            employee_address = '$address',
            employee_Mobile = '$mobile',
            employee_email = '$email',
            employee_username = '$username'
            WHERE employee_id = $id";

        if (mysqli_num_rows($execution_verifyUsername) != 0 && mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "Both username and email are already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyUsername) != 0) {
            $errMsg = "This username is already taken, Try another one please!";
        } else if (mysqli_num_rows($execution_verifyEmail) != 0) {
            $errMsg = "This email is already used, Try another one please!";
        } else {
            if ($errMsg == '' && mysqli_query($conn, $sql1)) {
                $msg = "Profile Updated Successfully";
                $status = 'success';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                echo '<script> location.replace("profile.php"); </script>';
            } else {
                $msg = 'Profile not Updated' . mysqli_error($conn);
                $status = 'danger';
                $_SESSION['status'] = $status;
                $_SESSION['msg'] = $msg;
                // echo '<script> location.replace("profile.php"); </script>';
            }
        }
    }
}

if (isset($_POST['editAdminPassword'])) {
    $oldPassword = FILTER_INPUT(INPUT_POST, 'oldPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $newPassword = FILTER_INPUT(INPUT_POST, 'newPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $conNewPassword = FILTER_INPUT(INPUT_POST, 'conNewPassword', FILTER_SANITIZE_SPECIAL_CHARS);

    //encrypt password
    $oldPassword = md5($oldPassword);
    $newPass = md5($newPassword);

    $sql = "SELECT * FROM admin WHERE admin_id = $id";
    $exec = mysqli_query($conn, $sql);
    $employ = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    } else {
        die("Error retrieving employees: " . mysqli_error($conn));
    }

    $sql1 = "UPDATE admin
            SET admin_password = '$newPass'
            WHERE admin_id = $id";

    if ($oldPassword != $employ['admin_password']) {
        $errMsg2 = "Wrong Old Password, please try again";
    } else if ($newPassword != $conNewPassword) {
        $errMsg2 = "New Password and Confirm Password do not match. Please try again";
    } else if (empty($oldPassword) && empty($newPassword) && empty($conNewPassword)) {
        $errMsg2 = "All Fields are required";
    } else {
        if (mysqli_query($conn, $sql1)) {
            $msg = "Password Changed Successfully";
            $status = 'success';
            $_SESSION['status'] = $status;
            $_SESSION['msg'] = $msg;
            echo '<script> location.replace("profile.php"); </script>';
        } else {
            $msg = 'Password Change Unseccessfully' . mysqli_error($conn);
            $status = 'danger';
            $_SESSION['status'] = $status;
            $_SESSION['msg'] = $msg;
            // echo '<script> location.replace("profile.php"); </script>';
        }
    }
}

if (isset($_POST['editEmployeePassword'])) {
    $oldPassword = FILTER_INPUT(INPUT_POST, 'oldPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $newPassword = FILTER_INPUT(INPUT_POST, 'newPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $conNewPassword = FILTER_INPUT(INPUT_POST, 'conNewPassword', FILTER_SANITIZE_SPECIAL_CHARS);

    //encrypt password
    $oldPassword = md5($oldPassword);
    $newPass = md5($newPassword);

    $sql = "SELECT * FROM employee WHERE employee_id = $id";
    $exec = mysqli_query($conn, $sql);
    $employ = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    if ($exec) {
    } else {
        die("Error retrieving employees: " . mysqli_error($conn));
    }

    $sql1 = "UPDATE employee
            SET employee_password = '$newPass'
            WHERE employee_id = $id";

    if ($oldPassword != $employ['employee_password']) {
        $errMsg2 = "Wrong Old Password, please try again";
    } else if ($newPassword != $conNewPassword) {
        $errMsg2 = "New Password and Confirm Password do not match. Please try again";
    } else if (empty($oldPassword) && empty($newPassword) && empty($conNewPassword)) {
        $errMsg2 = "All Fields are required";
    } else {
        if (mysqli_query($conn, $sql1)) {
            $msg = "Password Changed Successfully";
            $status = 'success';
            $_SESSION['status'] = $status;
            $_SESSION['msg'] = $msg;
            echo '<script> location.replace("profile.php"); </script>';
        } else {
            $msg = 'Password Change Unseccessfully' . mysqli_error($conn);
            $status = 'danger';
            $_SESSION['status'] = $status;
            $_SESSION['msg'] = $msg;
            // echo '<script> location.replace("profile.php"); </script>';
        }
    }
}


?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-address-card"></i>
            </span> Profile
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
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Profile</h4>
                    <h6 class="text-danger mb-4 mt-2"><?php echo $errMsg ? $errMsg : '' ?></h6>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" value="<?php echo $id ?>" name="id" />
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $valueName ?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $valueEmail ?>" required>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="username">Username<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $valueUsername ?>" required>
                                </div>
                            </div>
                            <span <?php echo $_SESSION['role'] == 'admin' ? 'style="display: none;"' : "" ?>>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $valueAddress ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+233</span>
                                            </div>
                                            <input type="number" class="form-control " id="mobile" name="mobile" minlength="9" value="<?php echo $valueMobile ?>" maxlength="9" required>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <div class="col-md-8 d-flex justify-content-start align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-primary btn-icon-text" name="<?php echo $_SESSION['role'] == 'admin' ? "editAdminProfile" : "editEmployeeProfile" ?>" value="SAVE">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Change Password</h4>
                    <div class="alert alert-danger" <?php echo $errMsg2 ? "" : 'style="display: none"' ?> role="alert">
                        <?php echo $errMsg2; ?>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="oldPassword">Old Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="newPassword">New Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="newPassword" minlength="6" name="newPassword" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="conNewPassword">Confirm New Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="conNewPassword" minlength="6" name="conNewPassword" required>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center mt-2 align-self-center">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-gradient-success btn-icon-text" name="<?php echo $_SESSION['role'] == 'admin' ? "editAdminPassword" : "editEmployeePassword" ?>" value="SAVE">
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