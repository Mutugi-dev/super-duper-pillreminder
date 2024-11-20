<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
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
            <h3>
                MEDITRAX
            </h3>
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <!-- <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="patient_account.php">Patient Home</a></li>
                    <li><a href="doctor_account.php">Doctor Account</a></li>
                </ul> -->
            </nav>
         </div>

    </header>

    <div class="landing">
        <div class="intro-text">
            <h1>
                MEDITRAX MEDICATION MONITORING SYSTEM
            </h1>
            <p>
                Welcome to our medication monitoring application for patients.
            </p>
        </div>
    </div>

    <div class="login-plate">
     <div class="container">

     <div class="doctor-container">
      <form action="doctor_registration.php" method="post">
     <button type="submit" class="login-button doctor-register" name="doctor_register">Doctor Register</button>
     </form>
     </div>

        <div class="doctor-container">
        <form action="doctor_login.php" method="post">
        <button type="submit" class="login-button doctor-login" name="doctor_login">Doctor Login</button>
        </form>
    </div>

    <div class="patient-container">
        <form action="patient_registration.php" method="post">
        <button type="submit" class="login-button patient-register" name="patient_register">Patient Register</button>
        </form>
    </div>

            <div class="patient-container">
                <form action="patient_login.php" method="post">
                <button type="submit" class="login-button patient-login" name="patient_login">Patient Login</button>
                </form>
            </div>
           
           
        </div>
    </div>

    <div class="about-section">
        <div class="container">
            <h2>About Our Medication Monitoring System</h2>
            <p>
                Our Medication Monitoring System is designed to provide efficient tracking and management of medications for both patients and healthcare providers. 
                By leveraging advanced technology, our system ensures accurate medication schedules, reduces errors, and enhances overall healthcare outcomes.
            </p>
            <p>
                Features of our system include medication reminders, dosage tracking, medication history, and seamless communication between patients and doctors.
                With our user-friendly interface and comprehensive functionality, managing medications has never been easier.
            </p>
        </div>
    </div>

    
   

    
</body>
    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</html>