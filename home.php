<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homestyle.css">
    <title>Game Home</title>
</head>
<body>
    <h1 style="color: white; text-align: center; font-size: 50px;">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <img src="images/playbtn.png" id="playButton" alt="">
    <button id="signOutButton">SignOut</button>

    <script>
        document.getElementById("playButton").addEventListener("click", function () {
            window.location.href = "game.php";
        });

        document.getElementById("signOutButton").addEventListener("click", function () {
            window.location.href = "logout.php";
        });
    </script>
</body>
</html>
