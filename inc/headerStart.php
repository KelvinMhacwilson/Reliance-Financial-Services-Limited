<?php
require_once 'dbconfig.php';
include '../inc/env.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $projectName ?></title>
  <?php include '../inc/styles.php' ?>
</head>

<body>
  <!-- partial:partials/_navbar.html -->
  <?php include '../inc/navbar.php'; ?>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include '../inc/sidebar.php'; ?>
    <!-- partial -->
    <div class="main-panel">
      <!-- toast -->
       <?php include '../inc/toast.php'; ?>
      <!-- content-wrapper starts -->