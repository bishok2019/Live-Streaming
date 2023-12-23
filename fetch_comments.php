<?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userform";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

// Fetch comments from the database
$fetchCommentsQuery = "SELECT * FROM video_comments";
$result = $conn->query($fetchCommentsQuery);
$comments = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

// Return comments as a JSON response
header('Content-Type: application/json');
echo json_encode($comments);

// Fetch comments for the current video
$videoId = $_GET['videoId'];
$commentsQuery = "SELECT * FROM video_comments WHERE video_id"
?>
