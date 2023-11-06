<?php

// Start session
session_start();

// Define database connection variables
$servername = "43.204.212.15";
$username = "admin";
$password = "nirvana1234";
$dbname = "server-nirvana";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Get form data and sanitize
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);
  
  // Check if password and confirm_password match
  if ($password != $confirm_password) {
    $_SESSION["signup_error"] = "Password and confirm password do not match!";
    header("Location: signup.php");
    exit();
  }
  
  // Check if username already exists
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    $_SESSION["signup_error"] = "Username already exists!";
    header("Location: signup.php");
    exit();
  }
  
  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  // Insert user into database
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
$_SESSION["signup_success"] = "You have successfully signed up!";
header("Location: login.php");
exit();
} else {
$_SESSION["signup_error"] = "Error: " . $sql . "<br>" . $conn->error;
header("Location: signup.php");
exit();
}

}

// Close database connection
$conn->close();

?>