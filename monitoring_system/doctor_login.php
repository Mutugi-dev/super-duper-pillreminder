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
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Doctor Login</h3>
          </div>
          <div class="card-body">
          

        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              // Check if form fields are set and not empty
              if (isset($_POST['username_email']) && isset($_POST['password']) && !empty($_POST['username_email']) && !empty($_POST['password'])) {
                  // Retrieve form data
                  $username_email = $_POST['username_email'];
                  $password = $_POST['password'];

                  // Here you can perform the actual authentication logic, such as querying the database to validate the credentials
                  // For demonstration purposes, let's assume valid credentials
                  // You would replace this with your actual authentication logic

                  // Successful authentication, redirect the user to another page
                  header("Location: doctor_account.php"); // Change this to the appropriate page
                  exit;
              } else {
                  // Form fields are missing or empty, display an error message
                  echo "Please enter both username/email and password.";
              }
          }
          ?>


            <form action="#" method="post"> <!-- action="#" means form data will be submitted to the same page -->
              <div class="form-group">
                <label for="username_email">Username or Email:</label>
                <input type="text" class="form-control" id="username_email" name="username_email" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    
</body>
    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</html>