<?php
include('../config/db.php');
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Database error: " . $conn->error; // Capture error
        }
    } else {
        $error = "Passwords do not match.";
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
    <title>Sign Up</title>
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
        .signup-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
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
            margin-top: auto; /* Ensures footer stays at bottom */
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
        <div class="signup-container">
            <h2>Create Your Account</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <button type="submit" class="cta-button">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medication Monitoring System. All rights reserved.</p>
    </footer>
</body>
</html>