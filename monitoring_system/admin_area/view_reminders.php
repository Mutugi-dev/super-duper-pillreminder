<form action="display_reminders.php" method="POST">
  <label for="select_patient">Select Patient:</label>
  <select id="select_patient" name="select_patient">
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

            // Fetch patient names and IDs from the database
            $sql = "SELECT patient_id, patient_name FROM patients";
            $result = $conn->query($sql);

            // Check if there are patients in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["patient_name"] . "</option>";
                }
            } else {
                echo "<option>No patients found</option>";
            }

            // Close connection
            $conn->close();
            ?>
  </select><br><br>

  <input type="submit" value="Display Reminders">
</form>

<!-- Display Reminders -->
<div id="reminders">
  <?php
  // Check if the form has been submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected patient ID from the form
    $patient_id = $_POST['select_patient'];

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

    // Fetch reminders from the medications table for the selected patient
    $sql = "SELECT m.med_name, m.time, m.description, p.patient_name 
            FROM medications m
            JOIN patients p ON m.patient_id = p.id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('i', $patient_id);  // 'i' is the parameter type for an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any reminders exist for the selected patient
    if ($result->num_rows > 0) {
        echo "<h2>Reminders/Notifications</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Patient:</strong> " . htmlspecialchars($row['patient_name']) . "</p>";
            echo "<p><strong>Medicine:</strong> " . htmlspecialchars($row['medicine_name']) . "</p>";
            echo "<p><strong>Time:</strong> " . htmlspecialchars($row['time']) . "</p>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No reminders found for the selected patient.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
  }
  ?>
</div>
