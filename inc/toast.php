

<div class="toast-container p-3 top-0 end-0" id="toastPlacement" data-original-class="toast-container p-3">

    <div class="toast align-items-center fade <?php echo $_SESSION['status'] ? "show" : '' ?> border-<?php echo $_SESSION['status']; ?> border-3 " role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex ">
            <div class="toast-body text-<?php echo $_SESSION['status']; ?>">
            <?php echo $_SESSION['msg']; ?>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
</div>
<?php
$_SESSION['status'] = null;
?>