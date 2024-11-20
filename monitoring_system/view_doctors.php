<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Information</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<!-- Header Section -->
<header>
    <div class="container">
        <h1 class="mt-4">Available Doctors</h1>
        <p class="lead">View the details of doctors who are available for consultation.</p>
    </div>
</header>

<div class="container mt-5">
    <div class="row">
        <?php
        // Database connection parameters
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

        // SQL query to fetch available doctors
        $sql = "SELECT id, username, email, telephone FROM doctors ";
        $result = $conn->query($sql);

        // Check if there are any doctors available
        if ($result->num_rows > 0) {
            // Loop through the fetched doctors and display their details in Bootstrap cards
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['username']) . '</h5>';
                echo '<p class="card-text"><strong>Specialization:</strong> ' . htmlspecialchars($row['email']) . '</p>';
                echo '<p class="card-text"><strong>Contact Info:</strong> ' . htmlspecialchars($row['telephone']) . '</p>';
                echo '<p class="card-text"><strong>Status:</strong> ' . htmlspecialchars($row['id']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Message if no available doctors
            echo '<p class="text-center">No doctors are available at the moment.</p>';
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
</div>

<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
