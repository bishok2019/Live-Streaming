<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        .chat-box {
            float: right;
            height: 60vh;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }


        .Like {
            float: right;
            background-color: green;
            border-radius: 10px;
        }

        .Dislike {
            margin-left: 35px;
            background-color: red;
            border-radius: 10px;
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 100px !important;
            padding-right: 100px !important;
            background: #6665ee;
            font-family: 'Poppins', sans-serif;
        }

        .modal-content {
            position: fixed;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 68vw;
            height: 80vh;
            pointer-events: auto;
            background-color: #6665ee;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: 0.3rem;
            outline: 0;
        }

        .navbar-brand {
            color: #fff;
            font-size: 30px !important;
            font-weight: 500;
        }

        .navbar button {
            color: #6665ee;
            font-weight: 500;
        }

        .navbar button:hover {
            text-decoration: none;
        }

        .navbar .logout-button {
            margin-left: 10px;
        }

        .navbar button[name="liveButton"]:hover {
            background-color: red;
            color: #6665ee;
            border: none;
        }

        h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            font-weight: 600;
        }

        h2 {
            text-align: center;
        }

        .video-container {
            width: 80%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            clear: both;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .video-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            background-color: #6665ee;
        }

        .video {
            width: calc(33.33% - 10px);
            margin-bottom: 20px;
            background-color: #6665ee;
            border: 2px solid black;
            border-radius: 10px;
            padding: 7px;
            margin-top: 7px;
            margin-right: 2px;
            margin-left: 2px;
        }

        .comment-date {
            float: right;
        }


        .comment-section {
            align-items: center;
            height: 200px;
            max-height: 150px;
            overflow-y: auto;
            background-color: #b9bad9;
            border-radius: 7px;
        }

        .input-comment {
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['Email_Session'])) {
        header("Location: index.php");
        exit;
    }

    // Logout logic
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit;
    }


    ?>

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

    $liveResult = null;
    $pointsResult = null;
    $scheduleResult = null;
    $highlightsResult = null;
    $newsResult = null;


    if (isset($_POST['liveButton'])) {
        // Fetch data from the "live" table
        $liveQuery = "SELECT * FROM lives";
        $liveResult = $conn->query($liveQuery);
    }

    // Fetch the username based on the email
    $userEmail = $_SESSION['Email_Session'];
    $userQuery = "SELECT Username FROM register WHERE Email = '$userEmail'";
    $userResult = $conn->query($userQuery);

    // Check if the query executed successfully and fetch the username
    if ($userResult && $userResult->num_rows > 0) {
        $UserName = $userResult->fetch_assoc()['Username'];
    } else {
        $UserName = "Unknown User";
    }
    // Fetch the username based on the email
    $userEmail = $_SESSION['Email_Session'];
    $userQuery = "SELECT Username FROM register WHERE Email = '$userEmail'";
    $userResult = $conn->query($userQuery);

    // Check if the query executed successfully and fetch the username
    if ($userResult && $userResult->num_rows > 0) {
        $UserName = $userResult->fetch_assoc()['Username'];
    } else {
        $UserName = "Unknown User";
    }

    // Handle comment submissions for highlights
    if (isset($_POST['submitComment'])) {
        $videoId = $_POST['videoId'];
        $comment = $_POST['comment'];
        $userEmail = $_SESSION['Email_Session'];


        // Insert the comment into the database
        $insertCommentQuery = "INSERT INTO video_comments (video_id, user_email, comment, UserName) VALUES ($videoId, '$userEmail', '$comment','$UserName')";
        if ($conn->query($insertCommentQuery) === TRUE) {
            echo "<script>alert('Comment added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding comment: " . $conn->error . "');</script>";
        }
    }

    ?>

    <nav class="navbar">
        <div>
            <span>
                <img src="img/olympic.png" class="image"
                    style="height: 130px; margin-bottom: -53px; margin-top: -61px; margin-left: -80px;" href='home.php'
                    alt="" />
            </span>
            <a class="navbar-brand" id="navbar-brand" href="home.php">FunOlympic 2023</a>
        </div>

        <div>
            <h5 style="margin-left: 265px; font-size: 14px; color: azure">
                <?php
                echo "Welcome, $UserName. Enjoy Have Fun !! ";
                ?>
            </h5>
            <form method="post" style="display: inline-block;">
                <button id="button5" type="submit" class="btn btn-light" name="newsButton">NEWS</button>
            </form>
            <form method="post" style="display: inline-block;">
                <button id="button1" type="submit" class="btn btn-light" name="liveButton">Live</button>
            </form>
            <form method="post" style="display: inline-block;">
                <button id="button2" type="submit" class="btn btn-light" name="pointsButton">Points</button>
            </form>
            <form method="post" style="display: inline-block;">
                <button id="button3" type="submit" class="btn btn-light" name="scheduleButton">Schedule</button>
            </form>
            <form method="post" style="display: inline-block;">
                <button id="button4" type="submit" class="btn btn-light" name="highlightsButton">Highlights</button>
            </form>
            <button type="button" class="btn btn-light logout-button" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation"><a href="logout-user.php">Logout</a></button>
        </div>
    </nav>


    </div>


    <div style="background-color: #6665ee;">

        <?php
        if ($liveResult->num_rows > 0) {
            echo "<h2>Fun Olympic 2023 Streaming Now!!!</h2>";
            echo "<table>";
            echo "<tr><th>Title</th><th>Description</th><th>Uploaded</th><th>Watch Now</th></tr>";
            while ($row = $liveResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['upload_date'] . "</td>";
                echo "<td><button class='btn btn-primary watch-now-button' data-toggle='modal' data-target='#videoModal' data-video-id='" . $row['ID'] . "' data-video-link='" . $row['link'] . "' data-video-title='" . $row['title'] . "' data-video-description='" . $row['description'] . "'>Watch Now</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No live videos found.</p>";
        }
        
        ?>

    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="height:200px" class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer"></div>
                    <p id="videoDescription"></p>
                    <div>
                        <div id="chatbox"
                            style="margin-top: -450px; height: 395px; overflow-y: scroll; float:right;width: 255px;">
                            <h4 style="float:right;margin-right: 87px;">Live Chat</h4>
                            <?php
                            // Fetch and display the chat messages for the selected video
                            // $videoId = $_POST['video_id']; // Retrieve the video ID from the AJAX request
                            $chatQuery = "SELECT * FROM chat_messages";
                            $chatResult = $conn->query($chatQuery);
                            if ($chatResult && $chatResult->num_rows > 0) {
                                while ($chatRow = $chatResult->fetch_assoc()) {
                                    $message = $chatRow['message'];
                                    $username = $chatRow['username'];
                                    $timestamp = $chatRow['timestamp'];
                                    echo "<p><strong>$username:</strong> <span class='comment-date'>($timestamp)</span><br>$message</p>";
                                }
                            } else {
                                echo "<p>No messages found.</p>";
                            }
                            ?>
                        </div>
                        <div style="float: right; margin-right: 16px;margin-top:-25px;">
                            <form id="chatForm" action="insert_chat.php" method="POST">
                                <input type="hidden" id="videoId" name="videoId">
                                <input type="text" name="message" placeholder="Type your message">
                                <button type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.watch-now-button').click(function () {
                var videoLink = $(this).data('video-link');
                var videoTitle = $(this).data('video-title');
                var videoDescription = $(this).data('video-description');
                var videoUploadedDate = $(this).data('video-uploaded-date');
                var videoId = $(this).data('video-id');

                $('#videoModalLabel').text(videoTitle);
                $('#videoDescription').text(videoDescription);
                $('#videoPlayer').html('' + videoLink + '');
                $('#videoDescription').text(videoDescription);
                $('#videoId').val(videoId);
                // Fetch and display chat messages for the selected video
                fetchChatMessages(videoId);

                // Show the modal
                $('#videoModal').modal('show');

            });
            // Handle Enter key press
        $('#chatForm input[name="message"]').keypress(function (e) {
            if (e.which === 13) {
                e.preventDefault();
                var message = $(this).val();
                var videoId = $('#videoId').val();

                // Send the message to the server and refresh chat messages
                sendMessage(message, videoId);
            }
        });

        function fetchChatMessages(videoId) {
            // Clear existing chat messages
            $('#chatMessages').empty();

            // Fetch chat messages for the selected video from the server
            $.ajax({
                url: 'fetch_chat_messages.php',
                method: 'POST',
                data: { videoId: videoId },
                success: function (response) {
                    if (response) {
                        var chatMessages = JSON.parse(response);
                        chatMessages.forEach(function (chatMessage) {
                            var username = chatMessage.username;
                            var message = chatMessage.message;
                            var timestamp = chatMessage.timestamp;
                            var newMessage = '<p><strong>' + username + ':</strong> ' + message + ' <span class="comment-date">(' + timestamp + ')</span></p>';
                            $('#chatMessages').append(newMessage);
                        });
                    }
                }
            });
        }
        


        function sendMessage(message, videoId) {
            // Send the message to the server
            $.ajax({
                url: 'insert_chat.php',
                method: 'POST',
                data: { message: message, videoId: videoId },
                success: function (response) {
                    if (response === 'success') {
                        // Clear the input field
                        $('#chatForm input[name="message"]').val('');

                        // Refresh chat messages
                        fetchChatMessages(videoId);
                    }
                }
            });
        }
            
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





</body>




</html>