<!-- Search Form -->
<form action="index.php?view_patient_schedule" method="GET">
  <label for="search_query">Search by Name or ID:</label>
  <input type="text" id="search_query" name="search_query" required>
  <input type="submit" value="Search">
</form>

<!-- Display Patient Information -->
<div id="patient_info">
  <?php
  // Check if patient info is set after a successful search
  if (isset($patientInfo) && $patientInfo != null) {
    echo "<h2>Patient Information</h2>";
    echo "<p>Name: " . htmlspecialchars($patientInfo['patient_name']) . "</p>";
    echo "<p>Age: " . htmlspecialchars($patientInfo['age']) . "</p>";
    echo "<p>Gender: " . htmlspecialchars($patientInfo['gender']) . "</p>";
    echo "<p>Contact Information: " . htmlspecialchars($patientInfo['contact_info']) . "</p>";
    echo "<p>Medical History: " . nl2br(htmlspecialchars($patientInfo['medical_history'])) . "</p>";

    // Edit form
    echo "<h3>Edit Patient Information</h3>";
    echo "<form action='edit_patient.php' method='POST'>";
    echo "<input type='hidden' name='patient_id' value='" . htmlspecialchars($patientInfo['patient_id']) . "'>";
    echo "<label for='edit_name'>Name:</label>";
    echo "<input type='text' id='edit_name' name='edit_name' value='" . htmlspecialchars($patientInfo['patient_name']) . "' required><br><br>";
    echo "<label for='edit_age'>Age:</label>";
    echo "<input type='number' id='edit_age' name='edit_age' value='" . htmlspecialchars($patientInfo['age']) . "' required><br><br>";
    echo "<label for='edit_gender'>Gender:</label>";
    echo "<select id='edit_gender' name='edit_gender' required>";
    echo "<option value='male' " . ($patientInfo['gender'] == 'male' ? 'selected' : '') . ">Male</option>";
    echo "<option value='female' " . ($patientInfo['gender'] == 'female' ? 'selected' : '') . ">Female</option>";
    echo "<option value='other' " . ($patientInfo['gender'] == 'other' ? 'selected' : '') . ">Other</option>";
    echo "</select><br><br>";
    echo "<label for='edit_contact_info'>Contact Information:</label>";
    echo "<input type='text' id='edit_contact_info' name='edit_contact_info' value='" . htmlspecialchars($patientInfo['contact_info']) . "' required><br><br>";
    echo "<label for='edit_medical_history'>Medical History:</label><br>";
    echo "<textarea id='edit_medical_history' name='edit_medical_history' rows='4' cols='50' required>" . htmlspecialchars($patientInfo['medical_history']) . "</textarea><br><br>";
    echo "<input type='submit' value='Save Changes'>";
    echo "</form>";
  }
  ?>
</div>

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

// Check if search query is provided
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $_GET['search_query'];

    // Prepare and execute the query securely
    if (is_numeric($search_query)) {
        // Search by patient ID
        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
        $stmt->bind_param("i", $search_query);
    } else {
        // Search by patient name (with wildcard for partial matches)
        $search_query = "%" . $search_query . "%";
        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_name LIKE ?");
        $stmt->bind_param("s", $search_query);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results were found
    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th></tr>";
        
        // Output data of each row
        $patients = [];  // Store all results in an array
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["patient_id"]) . "</td><td>" . htmlspecialchars($row["patient_name"]) . "</td></tr>";
            $patients[] = $row;  // Add patient data to the array
        }
        echo "</table>";

        // If only one patient was found, store patient info for display
        if (count($patients) == 1) {
            $patientInfo = $patients[0];
        } else {
            $patientInfo = null;  // More than one result, no specific info to display
        }
    } else {
        echo "0 results found.";
        $patientInfo = null;  // No results, clear patient info
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Please provide a search query.";
}

// Close connection
$conn->close();
?>
