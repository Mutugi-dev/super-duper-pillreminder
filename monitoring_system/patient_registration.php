<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Medical Monitoring System</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
    integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" 
    integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

</head>
<body>
   
 <!-- region header -->
 <header>
         <div class="container">
            <img class="logo" href="home.php" src="">
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="patient_account.php">Patient Home</a></li>
                    <li><a href="reminders.php">Reminders</a></li>
                    <li><a href="doctor_account.php">Doctor Account</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Signup</a></li>
                    <li><a href="admin_area/index.php">Admin</a></li>
                </ul>
            </nav>
         </div>

    </header>



    <div class="container mt-5">
    <h2>User Signup</h2>
    <?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset($_POST['username'], $_POST['email'], $_POST['telephone'], $_POST['password']) && 
        !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['telephone']) && !empty($_POST['password'])) {
        
        // Establish a database connection (replace with your database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "monitoring_system_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = $_POST['password'];

        // Prepare SQL statement to insert data into doctors table
        $sql = "INSERT INTO users (username, email, telephone, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $telephone, $password);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "New record created successfully";
            // Redirect to login page upon successful registration
            header("Location: patient_login.php");
            exit(); // Terminate the current script to ensure no further output is sent
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        
        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Form fields are missing or empty, display an error message
        echo "Please fill in all the fields.";
    }
}
?>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="telephone" class="form-label">telephone:</label>
        <input type="telephone" class="form-control" id="telephone" name="telephone" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
  </div>

    
</body>
    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</html>