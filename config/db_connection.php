<!-- db_connection.php -->
<?php
$servername = "localhost";  // Or your Hostinger server name
$username = "root";
$password = "";
$dbname = "taskbuddy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>