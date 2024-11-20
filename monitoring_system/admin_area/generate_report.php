<?php
// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $report_type = $_POST['report_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate that all fields are filled
    if (empty($report_type) || empty($start_date) || empty($end_date)) {
        echo "Error: All fields are required.";
        exit;
    }

    // Validate start and end date (use DateTime for proper comparison)
    if ((new DateTime($start_date)) > (new DateTime($end_date))) {
        echo "Error: End date cannot be earlier than start date";
        exit;
    }

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

    // Prepare SQL query based on selected report type
    switch ($report_type) {
        case "medication_adherence":
            $stmt = $conn->prepare("SELECT * FROM medication_adherence WHERE date BETWEEN ? AND ?");
            break;
        case "medication_inventory":
            $stmt = $conn->prepare("SELECT * FROM medication_inventory WHERE date BETWEEN ? AND ?");
            break;
        default:
            echo "Invalid report type";
            exit;
    }

    // Bind the start and end dates to the prepared statement
    $stmt->bind_param('ss', $start_date, $end_date);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for results and display them in a table
    if ($result->num_rows > 0) {
        echo "<h2>Report: " . htmlspecialchars($report_type) . "</h2>";
        echo "<table border='1'>";
        echo "<tr>";

        // Fetch field names for the table header
        while ($field = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";

        // Fetch and display the rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found for the specified dates.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If form is not submitted
    echo "Form not submitted.";
}
?>
