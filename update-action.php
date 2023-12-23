<?php
// Establish database connection (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

// Retrieve action and video ID from the AJAX request
$action = $_POST['action'];
$videoId = $_POST['videoId'];
$userEmail = $_SESSION['Email_Session'];

// Perform necessary validation and sanitization on the received data

// Store the action in the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to update the action in the database
$sql = "INSERT INTO actions (video_id, action_type, user_email) VALUES ('$videoId', '$action', '$userEmail')";

if ($conn->query($sql) === TRUE) {
    echo "Action stored successfully!";
} else {
    echo "Error storing action: " . $conn->error;
}

$conn->close();
?>
