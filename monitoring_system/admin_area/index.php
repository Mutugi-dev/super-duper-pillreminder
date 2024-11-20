<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Medical Monitoring System</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
    integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" 
    integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

</head>
<body>
    <!-- region header -->
    <header>
         <div class="container">
            <img class="logo" href="index.php" src="../images/logo.jpg">
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="reminders.php">Reminders</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="../home.php">Home</a></li>
                </ul>
            </nav>
         </div>

    </header>

    <div class="bg-light">
        <h2 class="text-center p-2">Admin Area</h2>
    </div>

    <div class="row">
        <div class="col-md-12 bg-secondary p-1">
            <div class="button text-center">
                <button>
                    <a href="index.php?insert_patient_form" class="nav-link text-light bg-info my-1">
                        Add New Patient
                    </a>
                </button>
                <button>
                    <a href="index.php?view_edit_patient" class="nav-link text-light bg-info my-1">
                        View/Edit Patient Information
                    </a>
                </button>
                <button>
                    <a href="index.php?add_medicine" class="nav-link text-light bg-info my-1">
                        Add Medicine
                    </a>
                </button>
                <button>
                    <a href="index.php?edit_medicine" class="nav-link text-light bg-info my-1">
                        Edit Medicine
                    </a>
                </button>
                <button>
                    <a href="index.php?delete_medicine" class="nav-link text-light bg-info my-1">
                        Delete Medicine
                    </a>
                </button>
                <button>
                    <a href="index.php?view_patient_schedule" class="nav-link text-light bg-info my-1">
                        View Patient Medication Schedule
                    </a>
                </button>
                <button>
                    <a href="index.php?view_reminders" class="nav-link text-light bg-info my-1">
                        View Reminders/Notifications
                    </a>
                </button>
                <button>
                    <a href="index.php?generate_reports" class="nav-link text-light bg-info my-1">
                        Generate Reports
                    </a>
                </button>
                <button>
                    <a href="index.php?account_settings" class="nav-link text-light bg-info my-1">
                        Account Settings
                    </a>
                </button>
                <button>
                    <a href="index.php?view_patients" class="nav-link text-light bg-info my-1">
                        View Patients
                    </a>
                </button>
                <!-- <button>
                    <a href="" class="nav-link text-light bg-info my-1">
                        Logout
                    </a>
                </button> -->
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        if(isset($_GET['insert_patient_form'])){
            include('insert_patient_form.php');
        }
        if(isset($_GET['view_edit_patient'])){
            include('view_edit_patient.php');
        }
        if(isset($_GET['add_medicine'])){
            include('add_medicine.php');
        }
        if(isset($_GET['edit_medicine'])){
            include('edit_medicine.php');
        }
        if(isset($_GET['delete_medicine'])){
            include('delete_medicine.php');
        }
        if(isset($_GET['view_patient_schedule'])){
            include('view_patient_schedule.php');
        }
        if(isset($_GET['view_reminders'])){
            include('view_reminders.php');
        }
        if(isset($_GET['generate_reports'])){
            include('generate_reports.php');
        }
        if(isset($_GET['account_settings'])){
            include('account_settings.php');
        }
        
        if(isset($_GET['view_patients'])){
            include('view_patients.php');
        }
        ?>
    </div>


    
</body>
    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</html>