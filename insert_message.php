<?php
// Establish a database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'userform';

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the message and video ID from the request
$message = $_POST['message'];
$videoId = $_POST['videoId'];

// Fetch the username based on the email
session_start();
$userEmail = $_SESSION['Email_Session'];
$userQuery = "SELECT Username FROM register WHERE Email = '$userEmail'";
$userResult = $conn->query($userQuery);

// Check if the query executed successfully and fetch the username
if ($userResult && $userResult->num_rows > 0) {
    $userName = $userResult->fetch_assoc()['Username'];
    
} else {
    $userName = "Unknown User";
}

// Insert the message into the chat_messages table
$insertQuery = "INSERT INTO chat_messages (video_id, username, message,timestamp) VALUES ('$videoId', '$userName', '$message', NOW())";
if ($conn->query($insertQuery) === true) {
    echo "Message inserted successfully.";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
