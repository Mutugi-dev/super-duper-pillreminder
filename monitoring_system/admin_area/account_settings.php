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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data safely using isset() to check if the fields are set
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_new_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : '';
    $new_email = isset($_POST['new_email']) ? $_POST['new_email'] : '';
    $new_phone = isset($_POST['new_phone']) ? $_POST['new_phone'] : '';

    // Validation steps
    $errors = [];

    // 1. Validate New Password
    if (strlen($new_password) < 8) {
        $errors[] = "New password must be at least 8 characters long.";
    } elseif (!preg_match("/[A-Za-z]/", $new_password) || !preg_match("/[0-9]/", $new_password)) {
        $errors[] = "New password must contain both letters and numbers.";
    }

    // 2. Check if New Password Matches Confirmed Password
    if ($new_password !== $confirm_new_password) {
        $errors[] = "New password and confirmation password do not match.";
    }

    // 3. Validate Email Format
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check for any errors
    if (!empty($errors)) {
        // Display errors if any
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit(); // Stop execution if there are errors
    }

    // If validation passes, continue processing the form
    echo "Validation passed! You can proceed with updating the account information.";

    // For demonstration purposes, let's just print the received data
    echo "Current Password: " . htmlspecialchars($current_password) . "<br>";
    echo "New Password: " . htmlspecialchars($new_password) . "<br>";
    echo "Confirmed New Password: " . htmlspecialchars($confirm_new_password) . "<br>";
    echo "New Email: " . htmlspecialchars($new_email) . "<br>";
    echo "New Phone: " . htmlspecialchars($new_phone) . "<br>";

    // You would typically update the account information in your database instead of printing it

    // Redirect or perform any other necessary actions after processing the form data
    // header("Location: success.php"); // Redirect to a success page
    exit(); // Terminate script execution

}
?>



<form action="update_account.php" method="POST">
  <h2>Change Password</h2>
  <label for="current_password">Current Password:</label>
  <input type="password" id="current_password" name="current_password" required><br><br>

  <label for="new_password">New Password:</label>
  <input type="password" id="new_password" name="new_password" required><br><br>

  <label for="confirm_new_password">Confirm New Password:</label>
  <input type="password" id="confirm_new_password" name="confirm_new_password" required><br><br>

  <h2>Update Contact Information</h2>
  <label for="new_email">New Email:</label>
  <input type="email" id="new_email" name="new_email" required><br><br>

  <label for="new_phone">New Phone:</label>
  <input type="text" id="new_phone" name="new_phone" required><br><br>

  <input type="submit" value="Update Account">
</form>
