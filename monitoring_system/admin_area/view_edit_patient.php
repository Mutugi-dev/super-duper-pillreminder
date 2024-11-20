


<form action="index.php?view_patient_schedule" method="GET">
  <label for="search_query">Search by Name or ID:</label>
  <input type="text" id="search_query" name="search_query" required>
  <input type="submit" value="Search">
</form>

<!-- Display Patient Information -->
<div id="patient_info">
  <?php
  // Assuming $patientInfo is an array containing patient information fetched from the database
  if (isset($patientInfo)) {
    echo "<h2>Patient Information</h2>";
    echo "<p>Name: " . $patientInfo['name'] . "</p>";
    echo "<p>Age: " . $patientInfo['age'] . "</p>";
    echo "<p>Gender: " . $patientInfo['gender'] . "</p>";
    echo "<p>Contact Information: " . $patientInfo['contact_info'] . "</p>";
    echo "<p>Medical History: " . $patientInfo['medical_history'] . "</p>";

    // Edit form
    echo "<h3>Edit Patient Information</h3>";
    echo "<form action='edit_patient.php' method='POST'>";
    echo "<input type='hidden' name='patient_id' value='" . $patientInfo['id'] . "'>";
    echo "<label for='edit_name'>Name:</label>";
    echo "<input type='text' id='edit_name' name='edit_name' value='" . $patientInfo['name'] . "' required><br><br>";
    echo "<label for='edit_age'>Age:</label>";
    echo "<input type='number' id='edit_age' name='edit_age' value='" . $patientInfo['age'] . "' required><br><br>";
    echo "<label for='edit_gender'>Gender:</label>";
    echo "<select id='edit_gender' name='edit_gender' required>";
    echo "<option value='male' " . ($patientInfo['gender'] == 'male' ? 'selected' : '') . ">Male</option>";
    echo "<option value='female' " . ($patientInfo['gender'] == 'female' ? 'selected' : '') . ">Female</option>";
    echo "<option value='other' " . ($patientInfo['gender'] == 'other' ? 'selected' : '') . ">Other</option>";
    echo "</select><br><br>";
    echo "<label for='edit_contact_info'>Contact Information:</label>";
    echo "<input type='text' id='edit_contact_info' name='edit_contact_info' value='" . $patientInfo['contact_info'] . "' required><br><br>";
    echo "<label for='edit_medical_history'>Medical History:</label><br>";
    echo "<textarea id='edit_medical_history' name='edit_medical_history' rows='4' cols='50' required>" . $patientInfo['medical_history'] . "</textarea><br><br>";
    echo "<input type='submit' value='Save Changes'>";
    echo "</form>";
  }
  ?>
</div>

<?php
// Check if search query is provided
if (isset($_GET['search_query'])) {
    // Get the search query
    $search_query = $_GET['search_query'];

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

    // SQL query to search for patients
    $sql = "SELECT * FROM patients WHERE patient_name LIKE '%$search_query%' OR patient_id = '$search_query'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th></tr>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["patient_id"] . "</td><td>" . $row["patient_name"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results found.";
    }

    // Close connection
    $conn->close();
} else {
    // If search query is not provided
    echo "Please provide a search query.";
}
?>
