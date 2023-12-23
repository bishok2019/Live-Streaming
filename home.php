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
    } elseif (isset($_POST['pointsButton'])) {
        // Fetch data from the "points" table
        $pointsQuery = "SELECT * FROM points";
        $pointsResult = $conn->query($pointsQuery);
    } elseif (isset($_POST['scheduleButton'])) {
        // Fetch data from the "schedule" table
        $scheduleQuery = "SELECT * FROM schedule";
        $scheduleResult = $conn->query($scheduleQuery);
    } elseif (isset($_POST['highlightsButton'])) {
        // Fetch data from the "highlights" table
        $highlightsQuery = "SELECT * FROM highlights";
        $highlightsResult = $conn->query($highlightsQuery);
    } elseif (isset($_POST['newsButton'])) {
        // Fetch data from the "highlights" table
        $newsQuery = "SELECT * FROM images";
        $newsResult = $conn->query($newsQuery);
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

        if ($liveResult) {
            echo "<h2>Fun Olympic 2023 Streaming Now!!!</h2>";
            if ($liveResult->num_rows > 0) {
                echo "<table style:'padding:0 200px 0 200px;'>";
                echo "<tr><th>Title</th><th>Description</th><th>Started At</th><th>Click to Watch LIVE video</th></tr>";
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

        } elseif ($pointsResult) {
            echo "<h2>Fun Olympic 2023 Points:</h2>";
            if ($pointsResult->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Team Name</th><th>Points</th><th>Game</th></tr>";
                while ($row = $pointsResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['team_name'] . "</td>";
                    echo "<td>" . $row['points'] . "</td>";
                    echo "<td>" . $row['game'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";


            } else {
                echo "<p>No points data found.</p>";
            }
        } elseif ($scheduleResult) {
            echo "<h2>Fun Olympic 2023 Schedules:</h2>";
            if ($scheduleResult->num_rows > 0) {
                echo "<table>";
                echo "<tr  style='background-color:#6665ee'><th>ID</th><th>Event Name</th><th>Date</th><th>Time</th></tr>";
                while ($row = $scheduleResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['event_name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No points data found.</p>";
            }
        } elseif ($newsResult) {
            echo "<h2>Fun Olympic 2023 News:</h2>";
            if ($newsResult->num_rows > 0) {
                echo "<div class='image-container'     style='padding-bottom: 20px;'>";
                $counter = 0; // Track the number of images
                while ($row = $newsResult->fetch_assoc()) {
                    echo "<div class='image-item' style='padding: 0 300px 0 300px;'>";
                    echo "<img src='uploads/" . $row['image'] . "' alt='Image' width='100%' height='auto'>";                 
                    echo "<h3>" . $row['description'] . "<span style='float: right;font-size: 15px;color: white;margin-top: 10px;''>(Updated at: " . $row['time'] . ")</span></h3>";
                    echo "</div>";                    

                    $counter++;

                    if ($counter % 2 === 0) {
                        // Close the current row after displaying 2 images
                        echo "<div style='clear:both;'></div>"; // Clear float
                    }
                }
                echo "</div>";
            } else {
                echo "<p>No images yet.</p>";
            }
        } elseif ($highlightsResult) {
            echo "<h2 style='background-color:#6665ee'>Fun Olympic 2023 Highlight Videos:</h2>";
            echo "<div class='video-row'>";
            while ($row = $highlightsResult->fetch_assoc()) {
                echo "<div class='video'>";
                // Display the video content
                echo "<video width='100%' controls>";
                echo "<source src='uploads/" . $row['filename'] . "' type='video/mp4'>";
                echo "Your browser does not support the video tag.";
                echo "</video>";
                echo "<p style='color: white;>" . $row['title'] . "</p>";
                echo "<p style='color: white;>" . $row['description'] . "</p>";
                echo "<p style='color: white;'>Uploaded at: " . $row['upload_date'] . "</p>";

                echo "<form method='post' id='commentForm'>";
                echo "<div class='input-comment'>";
                echo "<input type='hidden' name='videoId' value='" . $row['ID'] . "'>";
                echo "<input class='input-comment' type='text' name='comment' placeholder='Enter your comment'>";
                echo "<button type='submit' name='submitComment'>Submit</button>";

                $userEmail = $_SESSION['Email_Session'];
                $videoId = $row['ID'];
                $actionQuery = "SELECT * FROM actions WHERE video_id = $videoId AND user_email = '$userEmail'";
                $actionResult = $conn->query($actionQuery);
                $actionRow = $actionResult->fetch_assoc();
                $hasLiked = ($actionResult && $actionResult->num_rows > 0 && $actionRow['action_type'] == 'like');
                $hasDisliked = ($actionResult && $actionResult->num_rows > 0 && $actionRow['action_type'] == 'dislike');
                $dislikeButtonLabel = $hasDisliked ? 'Disliked' : 'Dislike';
                $likeButtonLabel = $hasLiked ? 'Liked' : 'Like';

                echo "<span class='Dislike'><button type='submit' name='action' value='dislike' " . ($hasDisliked ? 'disabled' : '') . " style='background-color: red; border-radius: 10px;' onmouseover='this.style.backgroundColor=\"darkred\"' onmouseout='this.style.backgroundColor=\"red\"'>$dislikeButtonLabel</button></span>";
                echo "<span class='Like'><button type='submit' name='action' value='like' " . ($hasLiked ? 'disabled' : '') . " style='background-color: blue; border-radius: 10px;' onmouseover='this.style.backgroundColor=\"limegreen\"' onmouseout='this.style.backgroundColor=\"green\"'>$likeButtonLabel</button></span>";
                echo "<br>";
                echo "<span class='DislikeCount' style='padding-left: 315px;'>" . getDislikesCount($videoId) . "</span>";
                echo "<span class='LikeCount'style='float: right;'>" . getLikesCount($videoId) . "</span>";

                echo "</div>";
                echo "</form>";

                // Add the comment section
                echo "<div class='comment-section' id='commentSection'>";
                // Fetch comments for the current video
                $commentsQuery = "SELECT * FROM video_comments WHERE video_id = $videoId";
                $commentsResult = $conn->query($commentsQuery);
                if ($commentsResult && $commentsResult->num_rows > 0) {
                    while ($commentRow = $commentsResult->fetch_assoc()) {
                        echo "<div class='comment' id='commentBox'>";
                        echo "<span><b>" . $commentRow['UserName'] . "</b>:<br> " . $commentRow['comment'] . "</span>";
                        echo "<span class='comment-date'>" . $commentRow['comment_date'] . "</span>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Be the first to give your opinion.</p>";
                }
                echo "</div>"; // Closing comment-section div
        
                echo "</div>"; // Closing video div
            }

            echo "</div>"; // Closing video-row div
        
        }
        function getLikesCount($videoId)
        {
            global $conn;
            $query = "SELECT COUNT(*) AS likeCount FROM actions WHERE video_id = $videoId AND action_type = 'like'";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['likeCount'];
            }
            return 0;
        }

        function getDislikesCount($videoId)
        {
            global $conn;
            $query = "SELECT COUNT(*) AS dislikeCount FROM actions WHERE video_id = $videoId AND action_type = 'dislike'";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['dislikeCount'];
            }
            return 0;
        }

        // Handle the form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            $videoId = $_POST['videoId'];
            $userEmail = $_SESSION['Email_Session'];

            // Delete existing like or dislike for the current user and video
            $deleteQuery = "DELETE FROM actions WHERE video_id = $videoId AND user_email = '$userEmail'";
            $conn->query($deleteQuery);

            // Insert the new like or dislike into the database
            $insertQuery = "INSERT INTO actions (video_id, user_email, action_type) VALUES ($videoId, '$userEmail', '$action')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "<script>alert('Action stored successfully!');</script>";
            } else {
                echo "<script>alert('Error storing action: " . $conn->error . "');</script>";
            }
        }

        ?>
        <script>
            $(document).ready(function () {
                // Attach event listeners to like and dislike buttons
                $('[id^=likeButton_]').click(function () {
                    var videoId = this.id.split('_')[1];
                    var dislikeButtonId = 'dislikeButton_' + videoId;
                    $('#' + dislikeButtonId).removeClass('selected');

                    $(this).toggleClass('selected');

                    // Send AJAX request to update the database
                    $.ajax({
                        type: 'POST',
                        url: 'update-action.php',
                        data: {
                            action: 'like',
                            videoId: videoId
                        },
                        success: function (response) {
                            console.log('Like action stored successfully!');
                        }
                    });
                });

                $('[id^=dislikeButton_]').click(function () {
                    var videoId = this.id.split('_')[1];
                    var likeButtonId = 'likeButton_' + videoId;
                    $('#' + likeButtonId).removeClass('selected');

                    $(this).toggleClass('selected');

                    // Send AJAX request to update the database
                    $.ajax({
                        type: 'POST',
                        url: 'update-action.php',
                        data: {
                            action: 'dislike',
                            videoId: videoId
                        },
                        success: function (response) {
                            console.log('Dislike action stored successfully!');
                        }
                    });
                });
            });
        </script>
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
                    <p id="Uploaded"> </p>
                    <div>
                        <div id="chatbox"
                            style="margin-top: -450px; height: 395px; overflow-y: scroll; float:right;width: 255px;">
                            <h4 style="float:right;margin-right:87px;">Live Chat</h4>
                            <br>
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
                                echo "<p 'style= amrgin-top=2px;'>No messages found.</p>";
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
        

        // Handle form submission
        $('#chatForm').submit(function (e) {
            e.preventDefault();
            var message = $('#chatForm input[name="message"]').val();
            var videoId = $('#videoId').val();

            // Send the message to the server and refresh chat messages
            sendMessage(message, videoId);
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


    <footer style="margin-bottom:2px; text-align:center;">
        
    <p>
        Copyright by &copy;Fun Olympic2023
    </p>


    </footer>
</body>




</html>