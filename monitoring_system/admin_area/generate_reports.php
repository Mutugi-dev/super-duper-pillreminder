<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $report_type = $_POST['report_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate start and end date
    if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
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

    // Initialize an empty result variable
    $result = [];
    
    // Perform action based on selected report type
    switch ($report_type) {
        case "medication_adherence":
            // Generate medication adherence report
            $sql = "SELECT * FROM medication_adherence WHERE date BETWEEN ? AND ?";
            break;
        case "medication_inventory":
            // Generate medication inventory report
            $sql = "SELECT * FROM medication_inventory WHERE date BETWEEN ? AND ?";
            break;
        default:
            echo "Invalid report type";
            exit;
    }

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date); // Bind the parameters
    $stmt->execute(); // Execute the query

    // Get the result
    $result = $stmt->get_result();
    
    // Check if any results were returned
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            // Adjust the output according to your needs (e.g., format the report)
            echo "<pre>";
            print_r($row); // Display each row of the result
            echo "</pre>";
        }
    } else {
        echo "No results found for the selected date range.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If form is not submitted
    echo "Form not submitted";
}
?>

<form action="generate_report.php" method="POST">
    <label for="report_type">Select Report Type:</label>
    <select id="report_type" name="report_type" required>
        <option value="">Select Report Type</option>
        <option value="medication_adherence">Patient Medication Adherence Report</option>
        <option value="medication_inventory">Medication Inventory Report</option>
        <!-- Add more report types as needed -->
    </select><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>

    <input type="submit" value="Generate Report">
</form>
