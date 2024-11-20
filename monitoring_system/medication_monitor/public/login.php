<?php
include('../config/db.php');
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

if (isset($_SESSION['user_id'])) {
    header('Location: medications.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: medications.php');
                exit();
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }

        $stmt->close();
    } else {
        $error = 'Database error: ' . $conn->error; // Change this to display the error
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
    <title>Login</title>
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
        .login-container {
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
        <div class="login-container">
            <h2>Login to Your Account</h2>
            <?php if ($error): ?>
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
                <button type="submit" class="cta-button">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medication Monitoring System. All rights reserved.</p>
    </footer>
</body>
</html>