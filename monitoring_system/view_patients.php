<!-- Styling for the UI -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
   

    
    
</head>

<body>
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

                // Fetch patients from the patients table
                $patients_sql = "SELECT patient_id, patient_name, age, gender, contact_info, medical_history FROM patients";
                $patients_result = $conn->query($patients_sql);

                // Check if there are any patients
                if ($patients_result->num_rows > 0) {
                    echo '<h2 class="section-title text-center mb-4">Patient Information</h2>';
                    echo '<div class="row">'; // Start row for Bootstrap grid
                    
                    // Output data of each row in cards
                    while ($patient_row = $patients_result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">'; // Column for each card
                        echo '<div class="card patient-card h-100">'; // Card with equal height

                        // Add patient information inside the card
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Patient: ' . htmlspecialchars($patient_row['patient_name']) . '</h5>';
                        echo '<p class="card-text"><strong>Age:</strong> ' . htmlspecialchars($patient_row['age']) . '</p>';
                        echo '<p class="card-text"><strong>Gender:</strong> ' . htmlspecialchars($patient_row['gender']) . '</p>';
                        echo '<p class="card-text"><strong>Contact Info:</strong> ' . htmlspecialchars($patient_row['contact_info']) . '</p>';
                        echo '<p class="card-text"><strong>Medical History:</strong> ' . htmlspecialchars($patient_row['medical_history']) . '</p>';
                        echo '</div>'; // Close card-body

                        echo '</div>'; // Close card
                        echo '</div>'; // Close column
                    }

                    echo '</div>'; // End row for Bootstrap grid
                } else {
                    echo "<p class='text-center'>No patients found.</p>";
                }

                // Close the database connection
                $conn->close();
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
