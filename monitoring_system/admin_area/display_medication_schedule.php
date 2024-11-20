<?php
// Check if a patient ID was submitted
if (isset($_POST['select_patient'])) {
    // Retrieve the selected patient ID from the POST request
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

    // SQL query to fetch the medication schedule for the selected patient
    $sql = "SELECT medicine_name, dosage, frequency, start_date, end_date, special_instructions 
            FROM medications 
            WHERE patient_id = ?";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any medication schedule was found
    if ($result->num_rows > 0) {
        echo "<h2>Medication Schedule</h2>";
        // Loop through each medication entry and display details
        while ($medication = $result->fetch_assoc()) {
            echo "<p>Medicine: " . htmlspecialchars($medication['medicine_name']) . "</p>";
            echo "<p>Dosage: " . htmlspecialchars($medication['dosage']) . "</p>";
            echo "<p>Frequency: " . htmlspecialchars($medication['frequency']) . "</p>";
            echo "<p>Start Date: " . htmlspecialchars($medication['start_date']) . "</p>";
            echo "<p>End Date: " . htmlspecialchars($medication['end_date']) . "</p>";
            echo "<p>Special Instructions: " . htmlspecialchars($medication['special_instructions']) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No medication schedule found for the selected patient.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p>No patient selected.</p>";
}
?>
