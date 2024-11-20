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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" 
    integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
</head>
<body>
    <!-- region header -->
    <header>
         <div class="container">
            <img class="logo" href="home.php" src="images/logo.jpg">
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="view_patiens.php">View Patients</a></li>
                    <!-- <li><a href="patient_account.php">Patient Home</a></li>
                    <li><a href="medication_monitor/public/medications.php">Reminders</a></li>
                    <li><a href="doctor_account.php">Doctor Account</a></li>
                    <li><a href="admin_area/index.php">Admin</a></li> -->
                </ul>
            </nav>
         </div>
    </header>

    <div class="container">
        <!-- Medication Management Section -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Medication Management</h2>

                    <!-- Add Medication Form -->
                    <div class="mb-3">
                        <h3>Prescription</h3>
                        <?php
                        // Check if form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['medicine_name'], $_POST['dosage'], $_POST['frequency'], $_POST['start_date']) && 
                                !empty($_POST['medicine_name']) && !empty($_POST['dosage']) && !empty($_POST['frequency']) && !empty($_POST['start_date'])) {

                                // Database connection
                                $servername = "localhost";
                                $username = "root"; // Your database username
                                $password = ""; // Your database password (empty by default in XAMPP)
                                $database = "monitoring_system_db"; // Your database name
                                $conn = new mysqli($servername, $username, $password, $database);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Retrieve form data
                                $medicine_name = $_POST['medicine_name'];
                                $dosage = $_POST['dosage'];
                                $frequency = $_POST['frequency'];
                                $start_date = $_POST['start_date'];
                                $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
                                $special_instructions = isset($_POST['special_instructions']) ? $_POST['special_instructions'] : null;

                                // Prepare SQL statement to insert data into medicines table
                                $sql = "INSERT INTO medicines (medicine_name, dosage, frequency, start_date, end_date, special_instructions) 
                                        VALUES (?, ?, ?, ?, ?, ?)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ssssss", $medicine_name, $dosage, $frequency, $start_date, $end_date, $special_instructions);

                                // Execute the prepared statement
                                if ($stmt->execute()) {
                                    echo "New record created successfully";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }

                                // Close the prepared statement and database connection
                                $stmt->close();
                                $conn->close();
                            } else {
                                echo "Please fill in all the required fields.";
                            }
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="medicine_name" class="form-label">Medicine Name:</label>
                                <input type="text" id="medicine_name" name="medicine_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="dosage" class="form-label">Dosage:</label>
                                <input type="text" id="dosage" name="dosage" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="frequency" class="form-label">Frequency:</label>
                                <input type="text" id="frequency" name="frequency" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="special_instructions" class="form-label">Special Instructions:</label>
                                <textarea id="special_instructions" name="special_instructions" class="form-control" rows="4" cols="50"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Medication</button>
                        </form>
                    </div>

                    <!-- Edit Medication Form -->
                    <div class="mb-3">
                        <h3>Edit Medication</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="select_medication" class="form-label">Select Medication to Edit:</label>
                                <select id="select_medication" name="select_medication" class="form-select" required>
                                    <?php
                                    // Fetch medicine names from the database
                                    $servername = "localhost";
                                    $username = "root"; // Your database username
                                    $password = ""; // Your database password
                                    $dbname = "monitoring_system_db"; // Your database name
                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT id, medicine_name FROM medicines";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["id"] . "'>" . $row["medicine_name"] . "</option>";
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select><br><br>
                            </div>
                            <div class="mb-3">
                                <label for="edit_dosage" class="form-label">Dosage:</label>
                                <input type="text" id="edit_dosage" name="edit_dosage" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_frequency" class="form-label">Frequency:</label>
                                <input type="text" id="edit_frequency" name="edit_frequency" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_start_date" class="form-label">Start Date:</label>
                                <input type="date" id="edit_start_date" name="edit_start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_end_date" class="form-label">End Date:</label>
                                <input type="date" id="edit_end_date" name="edit_end_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="edit_special_instructions" class="form-label">Special Instructions:</label>
                                <textarea id="edit_special_instructions" name="edit_special_instructions" class="form-control" rows="4" cols="50"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Edit Medication</button>
                        </form>
                    </div>

                    <!-- Appointment Scheduling Section -->
                    <div class="mb-3">
                        <h3>Schedule Appointment</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date:</label>
                                <input type="date" id="appointment_date" name="appointment_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">Appointment Time:</label>
                                <input type="time" id="appointment_time" name="appointment_time" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                        </form>
                    </div>

                    <?php
                    // Handle appointment scheduling
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_date'], $_POST['appointment_time'])) {
                        $appointment_date = $_POST['appointment_date'];
                        $appointment_time = $_POST['appointment_time'];

                        // Ensure the username is available
                        $username = "user"; // This should be dynamically set based on logged-in user
                        // Connection and query
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // SQL statement to insert appointment data
                        $sql = "INSERT INTO appointments (username, appointment_date, appointment_time) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sss", $username, $appointment_date, $appointment_time);
                        if ($stmt->execute()) {
                            echo "Appointment scheduled successfully.";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        $stmt->close();
                        $conn->close();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
