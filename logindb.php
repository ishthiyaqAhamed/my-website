<?php

$conn = new mysqli("localhost", "root", "", "loginbanana");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM userdetails WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        
        session_start();
        $_SESSION['username'] = $row['username'];
        header("Location: home.php");
        exit();
    } else {
        session_start();
        $_SESSION['username'] = $row['username'];
        header("Location: home.php");
        exit();
    }
} else {
    echo "No user found with that email!";
}

$conn->close();
?>
