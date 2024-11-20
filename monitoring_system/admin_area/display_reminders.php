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

// Initialize the variable for reminders
$reminders = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected patient ID from the form
    $patient_id = $_POST['select_patient'];

    // Fetch reminders from the medications table for the selected patient
    $sql = "SELECT m.medicine_name, m.time, m.description, p.patient_name 
            FROM medications m
            JOIN patients p ON m.patient_id = p.id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patient_id);  // 'i' is the parameter type for an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the fetched reminders in the $reminders array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reminders[] = $row;
        }
    } else {
        $reminders = null;  // No reminders found for the selected patient
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Reminders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .reminder-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .reminder-card h2 {
            margin: 0;
        }
        .reminder-card p {
            margin: 5px 0;
        }
        .no-reminders {
            color: red;
        }
    </style>
</head>
<body>

<h1>Patient Reminders</h1>

<?php if (isset($reminders) && $reminders !== null && count($reminders) > 0): ?>
    <h2>Reminders for <?php echo htmlspecialchars($reminders[0]['patient_name']); ?></h2>
    <?php foreach ($reminders as $reminder): ?>
        <div class="reminder-card">
            <h3>Medicine: <?php echo htmlspecialchars($reminder['medicine_name']); ?></h3>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($reminder['time']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($reminder['description']); ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="no-reminders">No reminders found for the selected patient.</p>
<?php endif; ?>

</body>
</html>
