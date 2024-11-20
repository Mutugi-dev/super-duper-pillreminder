<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch medications for the user
$sql = "SELECT * FROM medications WHERE user_id = ? ORDER BY reminder_time ASC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare error (medications query): " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$medications = $stmt->get_result();

// Handle form submission for adding, updating, or deleting medication
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $med_name = $_POST['med_name'];
        $dosage = $_POST['dosage'];
        $frequency = $_POST['frequency'];
        $reminder_time = $_POST['reminder_time'];

        $sql = "INSERT INTO medications (user_id, med_name, dosage, frequency, reminder_time, status) VALUES (?, ?, ?, ?, ?, 'upcoming')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare error (medication insert): " . $conn->error);
        }
        $stmt->bind_param("issss", $user_id, $med_name, $dosage, $frequency, $reminder_time);

        if ($stmt->execute()) {
            header('Location: medications.php');
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    } elseif ($_POST['action'] === 'update_status' && isset($_POST['medication_id'])) {
        $medication_id = $_POST['medication_id'];
        $status = $_POST['status'];

        $sql = "UPDATE medications SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare error (status update): " . $conn->error);
        }
        $stmt->bind_param("si", $status, $medication_id);
        
        if ($stmt->execute()) {
            header('Location: medications.php');
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['medication_id'])) {
        $medication_id = $_POST['medication_id'];

        $sql = "DELETE FROM medications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare error (delete medication): " . $conn->error);
        }
        $stmt->bind_param("i", $medication_id);
        
        if ($stmt->execute()) {
            header('Location: medications.php');
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Your Medications</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo img {
            max-width: 100px;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
        }
        .medication-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h2, h3 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .cta-button {
            width: 100%;
            padding: 0.5rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
        .medication-list {
            list-style-type: none;
            padding: 0;
            margin-top: 1.5rem;
        }
        .medication-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .medication-card h4 {
            margin: 0;
        }
        .medication-card p {
            margin: 0.5rem 0;
        }
        .medication-card i {
            color: #007bff;
        }
        .reminder-chat {
            background: #e9f5ff;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 2rem;
        }
        .reminder-chat h3 {
            text-align: center;
            color: #007bff;
        }
        .reminder {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 0.5rem;
            margin: 0.5rem 0;
        }
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 1rem;
            position: sticky;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <?php if (file_exists('../assets/images/logo_placeholder.png')): ?>
                    <img src="../assets/images/logo_placeholder.png" alt="Logo">
                <?php else: ?>
                    <span style="font-size: 24px; color: white;">Medication Monitor</span>
                <?php endif; ?>
            </div>
            <ul class="nav-links">
                <li><a href="profile.php" style="color: white; text-decoration: none;"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="logout.php" style="color: white; text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="medication-container">
            <h2>Your Medications</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="med_name"><i class="fas fa-pills"></i> Medication Name</label>
                    <input type="text" name="med_name" id="med_name" required>
                </div>
                <div class="form-group">
                    <label for="dosage"><i class="fas fa-weight"></i> Dosage</label>
                    <input type="text" name="dosage" id="dosage" required>
                </div>
                <div class="form-group">
                    <label for="frequency"><i class="fas fa-clock"></i> Frequency</label>
                    <input type="text" name="frequency" id="frequency" required>
                </div>
                <div class="form-group">
                    <label for="reminder_time"><i class="fas fa-bell"></i> Reminder Time</label>
                    <input type="time" name="reminder_time" id="reminder_time" required>
                </div>
                <button type="submit" name="action" value="add" class="cta-button">Add Medication</button>
            </form>

            <h3>Upcoming, Taken, and Missed Medications</h3>
            <ul class="medication-list">
                <?php while ($med_row = $medications->fetch_assoc()): ?>
                    <li class="medication-card">
                      <li class="medication-card">
                        <div>
                            <h4><?= htmlspecialchars($med_row['med_name']); ?></h4>
                            <p><strong>Dosage:</strong> <?= htmlspecialchars($med_row['dosage']); ?></p>
                            <p><strong>Frequency:</strong> <?= htmlspecialchars($med_row['frequency']); ?></p>
                            <p><strong>Reminder Time:</strong> <?= htmlspecialchars($med_row['reminder_time']); ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($med_row['status']); ?></p>
                        </div>
                        <div>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="medication_id" value="<?= $med_row['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="upcoming" <?= $med_row['status'] === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                    <option value="taken" <?= $med_row['status'] === 'taken' ? 'selected' : ''; ?>>Taken</option>
                                    <option value="missed" <?= $med_row['status'] === 'missed' ? 'selected' : ''; ?>>Missed</option>
                                </select>
                                <input type="hidden" name="action" value="update_status">
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="medication_id" value="<?= $med_row['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this medication?');" style="background: none; border: none; color: red; cursor: pointer;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Medication Monitor. All rights reserved.</p>
    </footer>
</body>
</html>