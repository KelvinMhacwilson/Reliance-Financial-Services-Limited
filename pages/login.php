<?php
require_once '../inc/dbconfig.php';
include '../inc/env.php';

session_start();

$errMsg = "";

if (isset($_POST['login'])) {
  $username = FILTER_INPUT(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = FILTER_INPUT(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
  $role = FILTER_INPUT(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = md5($password);


  if ($role == 'employee') {

    $query = "SELECT * FROM employee WHERE employee_username = '$username' AND employee_password = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if (is_array($row) && !empty($row) && $row['authorized'] == 'valid') {
      $_SESSION['valid'] = $row['employee_username'];
      $_SESSION['email'] = $row['employee_email'];
      $_SESSION['id'] = $row['employee_id'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['name'] = $row['employee_name'];
      $_SESSION['authorized'] = $row['authorized'];
    } else {
      if ($row['authorized'] == 'invalid') {
        $errMsg = "Your account has been blocked by the administrator. See the administrator for futher details.";
      }
      else{
        $errMsg = "Username or Password is incorrect.";
      }
    }
    session_regenerate_id(true);
    if (isset($_SESSION['valid'])) {
      header("Location: index.php");
      exit;
    }
  } else if ($role == 'admin') {
    $query = "SELECT * FROM admin WHERE username = '$username' AND admin_password = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
      $_SESSION['valid'] = $row['username'];
      $_SESSION['email'] = $row['admin_email'];
      $_SESSION['id'] = $row['admin_id'];
      $_SESSION['role'] = 'admin';
      $_SESSION['name'] = $row['admin_name'];
      $_SESSION['authorized'] = 'valid';
    } else {
      $errMsg = "Username or Password is incorrect.";
    }
    session_regenerate_id(true);
    if (isset($_SESSION['valid'])) {
      header("Location: index.php");
      exit;
    }
  } else {
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $projectName ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/vendors/font-awesome/css/font-awesome.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="../../assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="<?php echo $projectLogo ?>">
              </div>
              <h4>Hello! Sign in to continue.</h4>
              <div class="alert alert-danger" <?php echo $errMsg ? "" : 'style="display: none"' ?> role="alert">
                <?php echo $errMsg; ?>
              </div>
              <h6 class="font-weight-light"></h6>
              <form class="pt-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                  <div class="my-2 d-flex justify-content-around align-items-center">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role" id="optionsRadios1" value="employee" checked> Employee </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role" id="optionsRadios2" value="admin"> Admin </label>
                    </div>
                  </div>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <input class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" name="login" type="submit" value="SIGN IN" />
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" /> Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-primary">Forgot password?</a>
                </div>
                <div class="mb-2 d-grid gap-2">

                </div>
                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../assets/js/off-canvas.js"></script>
  <script src="../../assets/js/misc.js"></script>
  <script src="../../assets/js/settings.js"></script>
  <script src="../../assets/js/todolist.js"></script>
  <script src="../../assets/js/jquery.cookie.js"></script>
  <!-- endinject -->
</body>

</html>