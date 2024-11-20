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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $medicine_name = $_POST['medicine_name'];
  $dosage = $_POST['dosage'];
  $frequency = $_POST['frequency'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $special_instructions = $_POST['special_instructions'];

  // Insert data into database
  // Replace 'your_db_hostname', 'your_db_username', 'your_db_password', and 'your_db_name' with your actual database credentials
  $conn = new mysqli('localhost', 'root', '', 'monitoring_system_db');
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO medicines (medicine_name, dosage, frequency, start_date, end_date, special_instructions)
          VALUES ('$medicine_name', '$dosage', '$frequency', '$start_date', '$end_date', '$special_instructions')";

  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  exit();
}
?>
                           

<form action="add_medicine.php" method="POST">
  <label for="medicine_name">Medicine Name:</label>
  <input type="text" id="medicine_name" name="medicine_name" required><br><br>

  <label for="dosage">Dosage:</label>
  <input type="text" id="dosage" name="dosage" required><br><br>

  <label for="frequency">Frequency:</label>
  <input type="text" id="frequency" name="frequency" required><br><br>

  <label for="start_date">Start Date:</label>
  <input type="date" id="start_date" name="start_date" required><br><br>

  <label for="end_date">End Date:</label>
  <input type="date" id="end_date" name="end_date"><br><br>

  <label for="special_instructions">Special Instructions:</label><br>
  <textarea id="special_instructions" name="special_instructions" rows="4" cols="50"></textarea><br><br>

  <input type="submit" value="Add Medicine">
</form>
