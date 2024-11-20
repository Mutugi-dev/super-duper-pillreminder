<?php
// Database connection
$servername = "localhost"; // Replace with your server details
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "monitoring_system_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {

    // Get form data
    $med_name = $conn->real_escape_string($_POST['med_name']);
    $dosage = $conn->real_escape_string($_POST['dosage']);
    $frequency = $conn->real_escape_string($_POST['frequency']);
    $reminder_time = $conn->real_escape_string($_POST['reminder_time']);
    $reminder_date = $conn->real_escape_string($_POST['reminder_date']);


    // Prepare SQL query to insert the data
    $sql = "INSERT INTO medications (med_name, dosage, frequency, reminder_time, reminder_date)
            VALUES ('$med_name', '$dosage', '$frequency', '$reminder_time','$reminder_date')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>New medication added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Close connection
$conn->close();
?>




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

    
    <style>
        /* Custom CSS for the page */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: black;
        }

        header {
            background-color: white;
            color: black;
            padding: 1rem;
            outline: 1px solid transparent;
            outline-offset: 2px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar .logo {
            max-width: 120px;
        }

        .navbar ul {
            display: flex;
            list-style: none;
            gap: 1rem;
            padding-left: 0;
            margin: 0;
        }

        .navbar ul li a {
            color: black;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
            color: black;
        }

        .medication-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2, h3 {
            text-align: center;
            color: black;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: black;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .cta-button {
            width: 100%;
            padding: 0.5rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        .medication-list {
            list-style-type: none;
            padding: 0;
            margin-top: 1.5rem;
        }

        .medication-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
        }

        .medication-card h4 {
            margin: 0;
            color: black;
        }

        .medication-card p {
            margin: 0.5rem 0;
            color: black;
        }

        .medication-card i {
            color: #007bff;
        }

        footer {
            background-color: white;
            color: black;
            text-align: center;
            padding: 1rem;
            position: sticky;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
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
                    
                </ul>
            </nav>
         </div>
    </header>
<main>
    <div class="medication-container">
        <h2>Your Medications</h2>

        <form method="POST" action="reminders.php">
            <div class="form-group">
                <label for="med_name"><i class="fas fa-pills"></i> Medication Name</label>
                <input type="text" name="med_name" id="med_name" required>
            </div>
            <div class="form-group">
                <label for="dosage"><i class="fas fa-weight"></i> Dosage</label>
                <input type="text" name="dosage" id="dosage" required>
            </div>
            <div class="form-group">
                <label for="frequency"><i class="fas fa-clock"></i> Frequency</label>
                <input type="text" name="frequency" id="frequency" required>
            </div>
            <div class="form-group">
                <label for="reminder_time"><i class="fas fa-bell"></i> Reminder Time</label>
                <input type="time" name="reminder_time" id="reminder_time" required>
            </div>
            <div class="form-group">
                 <label for="reminder_date"><i class="fas fa-calendar"></i> Reminder Date</label>
              <input type="date" name="reminder_date" id="reminder_date" required>
             </div>

            <button type="submit" name="action" value="add" class="cta-button">Add Medication</button>
           
        </form>

    </div>
</main>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
