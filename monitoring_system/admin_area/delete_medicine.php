<?php
// Initialize a flag to track deletion status
$deleted = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected medicine ID
    $medicine_id = $_POST['select_medicine'];

    // Validate selected medicine ID
    if (!$medicine_id) {
        echo "Please select a medicine to delete.";
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

    // Delete medicine from the database
    $sql = "DELETE FROM medicines WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $medicine_id);

    if ($stmt->execute()) {
        echo "Medicine deleted successfully.";
        $deleted = true;  // Set the flag to indicate successful deletion
    } else {
        echo "Error deleting medicine: " . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}

// Display the form only if a medicine has not been deleted
if (!$deleted):
?>

<!-- HTML form for selecting and deleting medicine -->
<form action="delete_medicine.php" method="POST">
    <label for="select_medicine">Select Medicine to Delete:</label>
    <select id="select_medicine" name="select_medicine" required>
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

        // Fetch medicine names and IDs from the database
        $sql = "SELECT id, medicine_name FROM medicines";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["medicine_name"] . "</option>";
            }
        } else {
            echo "<option value=''>No medicines available</option>";
        }

        // Close connection
        $conn->close();
        ?>
    </select><br><br>

    <input type="submit" value="Delete Medicine">
</form>

<?php endif; ?>
