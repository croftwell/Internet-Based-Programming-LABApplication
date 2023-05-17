<?php

$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";


try {
  $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Error: " . $e->getMessage());
}


$fullName = $_POST['fullName'] ?? '';
$email = $_POST['email'] ?? '';
$gender = $_POST['gender'] ?? '';

$errors = [];

if (empty($fullName)) {
  $errors[] = "Full Name is required.";
}

if (empty($email)) {
  $errors[] = "Email Address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Invalid Email Address.";
}

if (empty($gender)) {
  $errors[] = "Gender is required.";
}

if (!empty($errors)) {
  
  foreach ($errors as $error) {
    echo $error . "<br>";
  }
} else {
  
  $sql = "INSERT INTO students (full_name, email, gender) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$fullName, $email, $gender]);

  
  echo "Registration successful!";
}
?>
