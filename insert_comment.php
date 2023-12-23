<?php
// Handle comment submission
if (isset($_POST['submit_comment'])) {
    // Get the video ID and comment from the form
    $videoId = $_POST['video_id'];
    $comment = $_POST['comment'];

    // Insert the comment into the database
    $insertCommentQuery = "INSERT INTO comments (video_id, comment) VALUES ('$videoId', '$comment')";
    $conn->query($insertCommentQuery);
}
?>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['Email_Session'])) {
    header("Location: index.php");
    exit;
}

// Check if the comment form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    // Retrieve the comment data
    $comment = $_POST['comment'];
    $user = $_SESSION['Email_Session'];
    $highlightsId = $_POST['highlightsId'];

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

    
// Check if the comment and video ID are provided
if (isset($_POST['comment']) && isset($_POST['video_id'])) {
    // Get the comment and video ID from the request
    $comment = $_POST['comment'];
    $videoId = $_POST['video_id'];

    // Perform any necessary data sanitization or validation here

    // Insert the comment into the database
    $query = "INSERT INTO comments (video_id, comment_text) VALUES (?, ?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$videoId, $comment]);

    // Check if the comment was successfully inserted
    if ($statement->rowCount() > 0) {
        // Comment inserted successfully
        echo "Comment submitted successfully!";
    } else {
        // Failed to insert comment
        echo "Failed to submit comment. Please try again.";
    }
} else {
    // Invalid request
    echo "Invalid request. Please provide a comment and video ID.";
}

    // Prepare the SQL statement to insert the comment
    $sql = "INSERT INTO comments (user, comment, highlights_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $comment, $highlightsId);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Comment inserted successfully!";
    } else {
        echo "Error inserting comment: " . $stmt->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>
