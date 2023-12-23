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

// Get the video ID from the request
$videoId = $_GET['video_id'];

// Fetch chat messages for the given video ID
$fetchQuery = "SELECT * FROM chat_messages ";
$fetchResult = $conn->query($fetchQuery);

// Prepare an array to store the chat messages
$chatMessages = array();

// Check if the query executed successfully
if ($fetchResult && $fetchResult->num_rows > 0) {
    while ($row = $fetchResult->fetch_assoc()) {
        // Add chat message to the array
        $chatMessages[] = array(
            'username' => $row['username'],
            'message' => $row['message']
        );
    }
}

// Close the database connection
$conn->close();

// Return chat messages as JSON
header('Content-Type: application/json');
echo json_encode($chatMessages);
?>
