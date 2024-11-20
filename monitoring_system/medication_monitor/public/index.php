<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Welcome to Medication Monitor</title>
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
            flex-direction: column;
        }
        .info-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-bottom: 2rem;
        }
        .info-container img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .cta-button {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
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
        <div class="info-container">
            <h2>Welcome to the Medication Monitoring System</h2>
            <img src="../assets/images/medication_placeholder.jpg" alt="Medications">
            <p>Manage your medications effectively with reminders and logs.</p>
            <a href="login.php" class="cta-button">Login to Your Account</a>
        </div>
        
        <div class="info-container">
            <h3>Features</h3>
            <img src="../assets/images/reminder_placeholder.jpg" alt="Reminders">
            <p>Set reminders for your medications and never miss a dose.</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medication Monitoring System. All rights reserved.</p>
    </footer>
</body>
</html>