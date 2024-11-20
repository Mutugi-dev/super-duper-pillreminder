<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    $sql = "UPDATE users SET username = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $user_id);

    if ($stmt->execute()) {
        header('Location: profile.php');
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
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
    <title>Your Profile</title>
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
        .profile-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
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
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><img src="../assets/images/logo_placeholder.png" alt="Logo"></div>
            <ul class="nav-links">
                <li><a href="medications.php" style="color: white; text-decoration: none;">Medications</a></li>
                <li><a href="signup.php" style="color: white; text-decoration: none;">Sign Up</a></li>
                <li><a href="login.php" style="color: white; text-decoration: none;">Login</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="profile-container">
            <h2>Your Profile</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>
                <button type="submit" class="cta-button">Update Profile</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medication Monitoring System. All rights reserved.</p>
    </footer>
</body>
</html>