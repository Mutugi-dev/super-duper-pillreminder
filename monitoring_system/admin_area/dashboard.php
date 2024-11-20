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

// Fetch data for dashboard metrics
$totalMedicines = $conn->query("SELECT COUNT(*) as count FROM medicines")->fetch_assoc()['count'];
$totalManufacturers = $conn->query("SELECT COUNT(*) as count FROM manufacturers")->fetch_assoc()['count'];
$totalInvoices = $conn->query("SELECT COUNT(*) as count FROM invoices")->fetch_assoc()['count'];
$totalExpiredMedicines = $conn->query("SELECT COUNT(*) as count FROM medicines WHERE expiration_date < NOW()")->fetch_assoc()['count'];

// Fetch data for User Wise Invoice Table
$userInvoices = $conn->query("SELECT id, utilization_date, client_name, contact, payment_status FROM invoices ORDER BY utilization_date DESC");

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    /* General styling */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f9;
      color: #333;
    }
    .container {
      padding: 20px;
      max-width: 1200px;
      margin: auto;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .col-md-6, .col-md-12 {
      flex: 1;
      min-width: 48%;
    }
    .col-md-12 {
      min-width: 100%;
    }

    /* Header styling */
    header {
      background-color: #333;
      padding: 15px 0;
      color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    header .container {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    header .logo {
      font-size: 1.5em;
      color: #2BC155;
      text-decoration: none;
    }
    header nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 15px;
    }
    header nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 1em;
      transition: color 0.3s;
    }
    header nav ul li a:hover {
      color: #2BC155;
    }

    /* Card styling */
    .card {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .card-icon {
      font-size: 2.5em;
      color: white;
    }
    .card-content {
      text-align: right;
    }
    .card-content h2 {
      font-size: 24px;
      margin: 0;
      color: white;
    }
    .card-content p {
      margin: 5px 0 0;
      color: white;
    }

    .logo {
  
    width: 150px;  
    height: auto; 
    margin: 10px; 
    display: block;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.logo:hover {   
    transform: scale(1.05);  
    transition: transform 0.3s ease;
}



    /* Card colors */
    .bg-primary { background-color: #2BC155; }
    .bg-secondary { background-color: #A02CFA; }
    .bg-danger { background-color: #F94687; }
    .bg-warning { background-color: #FFBC11; }

    /* Table styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 0.9em;
    }
    table th, table td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    table th {
      background-color: #2BC155;
      color: white;
    }

    /* Chart styling */
    .chart-container {
      width: 100%;
      height: 400px;
    }
  </style>
  <script src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<!-- <header>
  <div class="container">
    <a href="index.php" class="logo">Dashboard</a>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="reminders.php">Reminders</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="home.php">Home</a></li>
      </ul>
    </nav>
  </div>
</header> -->


<header>
         <div class="container">
            <img class="logo" href="home.php" src="../images/logo.jpg" alt="Logo">
            <nav>
                <span class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="reminders.php">Reminders</a></li>
          <li><a href="account.php">Account</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="home.php">Home</a></li>
                </ul>
            </nav>
         </div>
    </header>

<div class="container">
  <div class="row">
    <!-- Total Medicine Card -->
    <div class="col-md-6">
      <div class="card bg-primary">
        <div class="card-icon">💊</div>
        <div class="card-content">
          <h2><?php echo $totalMedicines; ?></h2>
          <p>Total Medicine</p>
        </div>
      </div>
    </div>

    <!-- Total Manufacturer Card -->
    <div class="col-md-6">
      <div class="card bg-secondary">
        <div class="card-icon">🏭</div>
        <div class="card-content">
          <h2><?php echo $totalManufacturers; ?></h2>
          <p>Total Manufacturer</p>
        </div>
      </div>
    </div>

    <!-- Total Invoices Card -->
    <div class="col-md-6">
      <div class="card bg-danger">
        <div class="card-icon">📑</div>
        <div class="card-content">
          <h2><?php echo $totalInvoices; ?></h2>
          <p>Total Invoices</p>
        </div>
      </div>
    </div>

    <!-- Total Expired Medicine Card -->
    <div class="col-md-6">
      <div class="card bg-warning">
        <div class="card-icon">⚠️</div>
        <div class="card-content">
          <h2><?php echo $totalExpiredMedicines; ?></h2>
          <p>Total Expired Medicine</p>
        </div>
      </div>
    </div>
  </div>

  <!-- User Wise Invoice Table -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <h3>User Wise Invoice</h3>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Utilization Date</th>
              <th>Client Name</th>
              <th>Contact</th>
              <th>Payment Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $userInvoices->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['utilization_date']; ?></td>
                <td><?php echo $row['client_name']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row">
    <div class="col-md-6">
      <div id="pieChart" class="chart-container"></div>
    </div>
    <div class="col-md-6">
      <div id="barChart" class="chart-container"></div>
    </div>
  </div>
</div>

<script>
  google.charts.load('current', { packages: ['corechart'] });
  google.charts.setOnLoadCallback(drawCharts);

  function drawCharts() {
    const data = google.visualization.arrayToDataTable([
      ['Category', 'Amount'],
      ['Medicine 1', 10],
      ['Medicine 2', 20],
      ['Medicine 3', 30],
    ]);
    const options = { title: 'Sample Data', is3D: true };

    const pieChart = new google.visualization.PieChart(document.getElementById('pieChart'));
    pieChart.draw(data, options);

    const barChart = new google.visualization.BarChart(document.getElementById('barChart'));
    barChart.draw(data, options);
  }
</script>
</body>
</html>
