<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="../pages/index.php" class="nav-link">
                <div class="nav-profile-image">
                    <img src="../assets/images/userProfile.jpeg" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2 text-capitalize"><?php echo $_SESSION['name'] ?></span>
                    <span class="text-secondary text-small text-capitalize"><?php echo $_SESSION['role'] ?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../pages/index.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
            <a class="nav-link" href="../pages/departmentListAdd.php">
                <span class="menu-title">Departments</span>
                <i class="fa fa-building menu-icon"></i>
            </a>
        </li>
        <li class="nav-item" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Employees</span>
                <i class="menu-arrow"></i>
                <i class="fa fa-users menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/employeeList.php">All Employess</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/employeeAdd.php">Add Employees</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-tbasic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Trainings</span>
                <i class="menu-arrow"></i>
                <i class="fa fa-institution menu-icon"></i>
            </a>
            <div class="collapse" id="ui-tbasic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/trainingList.php">All Trainings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/trainingAdd.php">Add Trainings</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Vacations</span>
                <i class="fa fa-suitcase menu-icon"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/vacationList.php">All Vacations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/vacationAdd.php">Add Vacations</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">Attendance</span>
                <i class="fa fa-check-circle menu-icon"></i>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
                        <a class="nav-link" href="../pages/attendanceList.php" >All Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/attendanceAdd.php">Add Attendance</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <span class="menu-title">Evaluation</span>
                <i class="fa fa-thumbs-up menu-icon"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/evaluationList.php">All Evaluations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/evaluationAdd.php">Add Evaluation</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item" <?php echo $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'hr' ? 'style="display: none"' : "" ?>>
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Salaries</span>
                <i class="menu-arrow"></i>
                <i class="fa fa-money menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/salaryList.php"> All Salaries </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/salaryAdd.php"> Add Salary </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>