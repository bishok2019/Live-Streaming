<!DOCTYPE html>
<html>

<head>
    <title>DashBoard</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }


        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        h3 {
            text-align: center;
            margin-top: 20px;
        }

        .form {
            display: flex;
            flex-direction: column;
            /* max-width: 400px; */
            margin: 20px auto;
            padding: 20px;
            border: 2px solid black;
        }

        .form label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .form input,
        .form textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }

        .form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .delete-link {
            color: red;
        }

        .delete-link:hover {
            text-decoration: underline;
        }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="admin.php">AdminPage</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?table=register">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=schedule">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=highlights">Highlights</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=points">Points</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=lives">LIVE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=actions">Action</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=video_comments">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=chat_messages">LiveVideoMessages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=images">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?table=users">Members</a>
                </li>
            </ul>
        </div>
        <button type="button" class="btn btn-light logout-button" style="float:right;" aria-controls="navbarNav"
    aria-expanded="false" aria-label="Toggle navigation"><a href="admin-logout.php">Logout</a></button>

    </nav>

    <?php

    include('config.php');
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userform";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a specific table is selected
    if (isset($_GET['table'])) {
        $table = $_GET['table'];

        // Fetch data from the selected table
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);

        // Get the column names of the selected table
        $sql_columns = "SHOW COLUMNS FROM $table";
        $result_columns = $conn->query($sql_columns);
        $columns = [];
        while ($row = $result_columns->fetch_assoc()) {
            $columns[] = $row['Field'];
        }

        // Insert userdata into the selected table
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = mysqli_real_escape_string($conx, md5($_POST['password']));
            // $password = $_POST['password'];
            $verification = $_POST['verification'];
            // Insert the user into the database
            $sql_insert_user = "INSERT INTO register (Username, email, Password,verification) VALUES ('$username', '$email', '$password','$verification')";
            if ($conn->query($sql_insert_user) === TRUE) {
                // echo "New user created successfully";
                $registrationSuccess = true;
            } else {
                echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
            }
        }

        // Delete data from the selected table
        if (isset($_POST['delete'])) {
            $id = $_POST['delete'];
            $sql_delete = "DELETE FROM $table WHERE ID = $id";
            if ($conn->query($sql_delete) === TRUE) {
                // echo "Record deleted successfully";
                $delete = true;
            } else {
                echo "Error: " . $sql_delete . "<br>" . $conn->error;
            }
        }
        ?>
        <?php
        if (isset($delete) && $delete) {
            echo '<p style="color: green; text-align: center;">Record deleted successfully!</p>';
        }
        ?>

        <div class="container mt-4">
            <h2>
                <?php echo ucfirst($table); ?>
            </h2>
            <table class="table">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column) { ?>
                            <th>
                                <?php echo ucfirst($column); ?>
                            </th>
                        <?php } ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Function to display videos from the database
                    function displayVideos($conn)
                    {
                        $sql = "SELECT * FROM lives";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>";
                            echo "<tr><th>Title</th><th>Description</th><th>Link</th><th>Upload Date</th><th>Action</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td><a href='" . $row['link'] . "' style='display: block; height:100px;'>" . $row['link'] . "</a></td>";
                                echo "<td>" . $row['upload_date'] . "</td>";
                                echo "<td><a href='?delete=" . $row['id'] . "' class='delete-link'>Delete</a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "No videos found.";
                        }
                    }

                    // Handle file upload
                    if ($table === 'lives') {
                        if (isset($_POST['submit2'])) {
                            $title = $_POST['title'];
                            $description = $_POST['description'];
                            $link = $_POST['link'];

                            // Insert data into the "lives" table
                            $sql = "INSERT INTO lives (title, description, link) VALUES ('$title', '$description', '$link')";

                            if ($conn->query($sql) === TRUE) {
                                $liveSuccess = true;
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($columns as $column) {
                                echo "<td>" . $row[$column] . "</td>";
                            }
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<button type='submit' class='btn btn-danger' name='delete' value='" . $row['ID'] . "'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='" . (count($columns) + 1) . "'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?php if ($table === 'schedule') { ?>
                <?php
                // Check if the form is submitted
                if (isset($_POST['submitschedule'])) {
                    // Retrieve form data
                    $eventName = $_POST['event_name'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];

                    // Insert data into the database
                    $sql = "INSERT INTO schedule (event_name, date, time) VALUES ('$eventName', '$date', '$time')";

                    if ($conn->query($sql) === TRUE) {
                        $scheduleSuccess = true;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    // Close the connection
                    $conn->close();
                }
                ?>


                <?php
                if (isset($scheduleSuccess) && $scheduleSuccess) {
                    echo '<p style="color: green; text-align: center;">Schedule has been added!</p>';
                }
                ?>

                <h3>Add New Schedule</h3>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="event_name">Event Name:</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="text" class="form-control datepicker" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="text" class="form-control timepicker" id="time" name="time" required>
                    </div>
                    <button type="submitschedule" class="btn btn-primary" name="submitschedule">Add Schedule</button>
                </form>
            <?php } ?>

            <?php if ($table === 'points') { ?>
                <?php
                // Check if the form is submitted
                if (isset($_POST['submitpoints'])) {
                    // Retrieve form data
                    $teamName = $_POST['team_name'];
                    $points = $_POST['points'];
                    $game = $_POST['game'];

                    // Insert data into the database
                    $sql = "INSERT INTO points (team_name, points, game) VALUES ('$teamName', $points, '$game')";

                    if ($conn->query($sql) === TRUE) {
                        $pointSuccess = true;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    // Close the connection
                    $conn->close();
                }
                ?>
                <?php
                if (isset($pointSuccess) && $pointSuccess) {
                    echo '<p style="color: green; text-align: center;">Points has been added!</p>';
                }
                ?>
                <h3>Add Points</h3>

                <div style="margin-left: 200px; margin-bottom:10px">
                    <form style="width:70%" ; method="post" action="">
                        <div class="form-group">
                            <label for="team_name">Team Name:</label>
                            <input type="text" class="form-control" id="team_name" name="team_name" required>
                        </div>
                        <div class="form-group">
                            <label for="points">Points:</label>
                            <input type="number" class="form-control" id="points" name="points" required>
                        </div>
                        <div class="form-group">
                            <label for="game">Game:</label>
                            <input type="text" class="form-control" id="game" name="game" required>
                        </div>
                        <button type="submitpoints" class="btn btn-primary" name="submitpoints">Add Points</button>
                    </form>
                </div>
            <?php } ?>

            <?php if ($table === 'lives') { ?>
                <h3>Manage Live Videos</h3>
                <?php
                if (isset($liveSuccess) && $liveSuccess) {
                    echo '<p style="color: green; text-align: center;">Congratulations!!! Video has been added!</p>';
                }
                ?>
                
                <form class="form" method="post" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>

                    <label for="link">Insert Link:</label>
                    <input type="text" name="link" id="link" required>
                    <input type="submit" name="submit2" value="Upload Video">
                </form>
            <?php } ?>

            <?php if ($table === 'highlights' && isset($_POST['submit1'])) { ?>
                <?php
                $title = $_POST['title'];
                $description = $_POST['description'];
                $filename = $_FILES['video']['name'];
                $tempFile = $_FILES['video']['tmp_name'];
                $targetFile = "uploads/" . $filename;

                // Move the uploaded file to the target location
                if (move_uploaded_file($tempFile, $targetFile)) {
                    // Insert the video details into the database
                    $sql = "INSERT INTO highlights (title, description, filename) VALUES ('$title', '$description', '$filename')";
                    if ($conn->query($sql) === TRUE) {
                        // echo "Video uploaded successfully.";
                        $highlightsSuccess = true;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error uploading the video.";
                }
                ?>
            <?php } ?>
            <?php if ($table === 'highlights') { ?>

                <h3>ManageHighlightsVideos</h3>
                <?php
                if (isset($highlightsSuccess) && $highlightsSuccess) {
                    echo '<p style="color: green; text-align: center;">Congratulations!!! Video has been added !</p>';
                }
                ?>

                <form class="form" method="post" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>

                    <label for="video">Select Video:</label>
                    <input type="file" name="video" id="video" required>

                    <input type="submit" name="submit1" value="Upload Video">
                </form>


            <?php } ?>


            <?php if ($table === 'register') { ?>
                <h3>Add User</h3>
                <?php
                if (isset($registrationSuccess) && $registrationSuccess) {
                    echo '<p style="color: green; text-align: center;">Congratulations!!! User has been added !</p>';
                }
                ?>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="verification">Verification:</label>
                        <input type="text" class="form-control" id="verification" name="verification" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Add User</button>
                </form>
            <?php } ?>
            <?php if ($table === 'images' && isset($_POST['submit3'])) { ?>
                <?php
                $title = $_POST['title'];
                $description = $_POST['description'];
                $filename = $_FILES['images']['name'];
                $tempFile = $_FILES['images']['tmp_name'];
                $targetFile = "uploads/" . $filename;

                // Move the uploaded file to the target location
                if (move_uploaded_file($tempFile, $targetFile)) {
                    // Insert the video details into the database
                    $sql = "INSERT INTO images (name,  description,image) VALUES ('$title', '$description','$filename')";
                    if ($conn->query($sql) === TRUE) {
                        $newsSuccess = true;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error uploading the News.";
                }
                ?>
            <?php } ?>
            <?php if ($table === 'images') { ?>

                <h3>Manage News</h3>
                <?php
                if (isset($newsSuccess) && $newsSuccess) {
                    echo '<p style="color: green; text-align: center;">Congratulations!!! News has been added !</p>';
                }
                ?>

                <form class="form" method="post" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>

                    <label for="images">Select Image:</label>
                    <input type="file" name="images" id="images" required>

                    <input type="submit" name="submit3" value="Upload Image">
                </form>

            <?php } ?>


        </div>

    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            // Initialize timepicker
            $('.timepicker').timepicker({
                showMeridian: false,
                defaultTime: false
            });
        });
    </script>
    <footer style="margin-bottom:2px; text-align:center;">
        
        <p>
            Copyright by &copy;Fun Olympic2023
        </p>
    
    
        </footer>
</body>

</html>