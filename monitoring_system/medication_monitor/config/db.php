<?php
$conn = new mysqli('localhost', 'root', '', 'medication_monitor');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>