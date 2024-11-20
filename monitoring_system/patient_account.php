<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Medical Monitoring System</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    
    <!-- Font Awesome link -->
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
    <!-- Header -->
    <header>
         <div class="container">
            <img class="logo" href="home.php" src="images/logo.jpg" alt="Logo">
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="patient_account.php">Patient Home</a></li>
                    <li><a href="reminders.php">Reminders</a></li>
                    <li><a href="view_doctors.php">View Doctors</a></li>
                   
                </ul>
            </nav>
         </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <?php
                // Database connection parameters
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "monitoring_system_db"; // Replace with your actual database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch medicines from the medicines table
                $medicines_sql = "SELECT * FROM medicines";
                $medicines_result = $conn->query($medicines_sql);

                // Check if there are any medicines
                if ($medicines_result->num_rows > 0) {
                    echo '<h2>Medicines</h2>';
                    // Output data of each row in cards
                    while ($medicine_row = $medicines_result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $medicine_row['medicine_name'] . '</h5>';
                        echo '<p class="card-text">Dosage: ' . $medicine_row['dosage'] . '</p>'; // Assuming you have a dosage field
                        echo '<p class="card-text">Frequency: ' . $medicine_row['frequency'] . '</p>'; // Assuming you have an expiry date field
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No medicines found.</p>";
                }

                // Fetch appointments from the appointments table
                $appointments_sql = "SELECT * FROM appointments";
                $appointments_result = $conn->query($appointments_sql);

                // Check if there are any appointments
                if ($appointments_result->num_rows > 0) {
                    echo '<h2 class="mt-5">Appointments</h2>';
                    // Output data of each row in cards
                    while ($appointment_row = $appointments_result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $appointment_row['username'] . '</h5>';
                        echo '<p class="card-text">Date: ' . $appointment_row['appointment_date'] . '</p>';
                        echo '<p class="card-text">Time: ' . $appointment_row['appointment_time'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No appointments found.</p>";
                }
            // Fetch reminders from the database
            $reminders_sql = "SELECT * FROM medications";
            $reminders_result = $conn->query($reminders_sql);

            // Check if there are any reminders
            if ($reminders_result->num_rows > 0) {
                echo '<h2 class="mt-5">Your Medication Reminders</h2>';
                echo '<div class="row">'; // Start row for Bootstrap grid

                // Output data of each reminder in cards
                while ($reminder_row = $reminders_result->fetch_assoc()) {
                    // You may adjust the field names based on your actual table structure
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Medication: ' . htmlspecialchars($reminder_row['med_name']) . '</h5>';
                    echo '<p class="card-text"><strong>Dosage:</strong> ' . htmlspecialchars($reminder_row['dosage']) . '</p>';
                    echo '<p class="card-text"><strong>Frequency:</strong> ' . htmlspecialchars($reminder_row['frequency']) . '</p>';
                    echo '<p class="card-text"><strong>Reminder Time:</strong> ' . htmlspecialchars($reminder_row['reminder_time']) . '</p>';
                    echo '<p class="card-text"><strong>Reminder Date:</strong> ' . htmlspecialchars($reminder_row['reminder_date']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>'; // End row for Bootstrap grid
            } else {
                echo "<p>No reminders found.</p>";
            }


                // Close the database connection
                $conn->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</body>
</html>
