<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM logs WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$error = '';

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $logs = $stmt->get_result();
    $stmt->close();
} else {
    $error = 'Database error: Unable to prepare statement';
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
    <title>Your Medication Log</title>
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
        .navbar .logo img {
            max-width: 100px;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .log-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h2 {
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><img src="../assets/images/logo_placeholder.png" alt="Logo"></div>
        </nav>
    </header>
    
    <main>
        <div class="log-container">
            <h2>Your Medication Log</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar-alt"></i> Date</th>
                        <th><i class="fas fa-pills"></i> Medication</th>
                        <th><i class="fas fa-check-circle"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($log_row = $logs->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($log_row['log_date'])); ?></td>
                            <td><?= htmlspecialchars($log_row['medication']); ?></td>
                            <td><?= $log_row['status'] ? 'Taken' : 'Missed'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medication Monitoring System. All rights reserved.</p>
    </footer>
</body>
</html>