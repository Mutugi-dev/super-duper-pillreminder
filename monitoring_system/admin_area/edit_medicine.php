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

// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $medicine_id = $_POST['select_medicine'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $special_instructions = $_POST['special_instructions'];

    // Basic validation
    if (empty($medicine_id) || empty($dosage) || empty($frequency) || empty($start_date)) {
        $message = "Please fill in all required fields.";
    } else {
        // Update medicine information in the database
        $sql = "UPDATE medicines 
                SET dosage = ?, frequency = ?, start_date = ?, end_date = ?, special_instructions = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $dosage, $frequency, $start_date, $end_date, $special_instructions, $medicine_id);

        if ($stmt->execute()) {
            $message = "Medicine information updated successfully.";
        } else {
            $message = "Error updating medicine information: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch medicine names from the database for the dropdown
$sql = "SELECT id, medicine_name FROM medicines";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine</title>
</head>
<body>
    <?php
    // Display success or error message if available
    if ($message) {
        echo "<div>" . htmlspecialchars($message) . "</div>";
    } else {
        // Show the form only if there is no message
    ?>
        <form action="edit_medicine.php" method="POST">
            <label for="select_medicine">Select Medicine to Edit:</label>
            <select id="select_medicine" name="select_medicine" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["medicine_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No medicines available</option>";
                }
                ?>
            </select><br><br>

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

            <input type="submit" value="Save Changes">
        </form>
    <?php
    }
    // Close connection
    $conn->close();
    ?>
</body>
</html>
