<!-- -->
<?php


// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoring_system_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);
    $medical_history = mysqli_real_escape_string($conn, $_POST['medical_history']);

    // Insert data into database
    $sql = "INSERT INTO patients (patient_name, age, gender, contact_info, medical_history)
            VALUES ('$patient_name', '$age', '$gender', '$contact_info', '$medical_history')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>






<form action="" method="POST" class="mb-2">
  <label for="patient_name">Patient's Name:</label>
  <input type="text" id="patient_name" name="patient_name" required><br><br>

  <label for="age">Age:</label>
  <input type="number" id="age" name="age" required><br><br>

  <label for="gender">Gender:</label>
  <select id="gender" name="gender" required>
    <option value="">Select Gender</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
  </select><br><br>

  <label for="contact_info">Contact Information:</label>
  <input type="text" id="contact_info" name="contact_info" required><br><br>

  <label for="medical_history">Medical History:</label><br>
  <textarea id="medical_history" name="medical_history" rows="4" cols="50" required></textarea><br><br>

  <input type="submit" value="Submit">
</form>
