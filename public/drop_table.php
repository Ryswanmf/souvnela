<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "souvnela";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to drop table
$sql = "DROP TABLE pesanan";

if ($conn->query($sql) === TRUE) {
  echo "Table pesanan dropped successfully";
} else {
  echo "Error dropping table: " . $conn->error;
}

$conn->close();
?>