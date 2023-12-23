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

// Fetch chat messages from the database
$videoId = $_GET['video_id']; // Assuming you're passing the video ID via GET parameter
$fetchQuery = "SELECT * FROM chat_messages";
$result = $conn->query($fetchQuery);

// Prepare the chat messages as an array
$chatMessages = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chatMessages[] = array(
            'username' => $row['username'],
            'message' => $row['message']
        );
    }
}

// Close the database connection
$conn->close();

// Return the chat messages as a JSON response
header('Content-Type: application/json');
echo json_encode($chatMessages, JSON_UNESCAPED_UNICODE);
