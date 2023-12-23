<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 100px !important;
            padding-right: 100px !important;
            background: #6665ee;
            font-family: 'Poppins', sans-serif;
        }

        .live-button:hover {
        background-color: red;
        color: blue;
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
    </style>
</head>

<body>


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


    $pointsResult = null;
    $scheduleResult = null;

    $newsResult = null;


    if (isset($_POST['pointsButton'])) {
        // Fetch data from the "points" table
        $pointsQuery = "SELECT * FROM points";
        $pointsResult = $conn->query($pointsQuery);
    } elseif (isset($_POST['scheduleButton'])) {
        // Fetch data from the "schedule" table
        $scheduleQuery = "SELECT * FROM schedule";
        $scheduleResult = $conn->query($scheduleQuery);
    } elseif (isset($_POST['newsButton'])) {
        // Fetch data from the "highlights" table
        $newsQuery = "SELECT * FROM images";
        $newsResult = $conn->query($newsQuery);
    }



    ?>

    <nav class="navbar">
        <div>
            <span>
                <img src="img/olympic.png" class="image"
                    style="height: 130px; margin-bottom: -53px; margin-top: -61px; margin-left: -80px;" alt="" />
            </span>
            <a class="navbar-brand" id="navbar-brand" >FunOlympic 2023</a>

        </div>

        <div>
            <h5 style="margin-left: 265px; font-size: 14px; color: azure"></h5>
            <form method="post" style="display: inline-block;">
                <button id="button5" type="submit" class="btn btn-light" name="newsButton">NEWS</button>
            </form>

            <a style="display: inline-block; color: #6665ee;
    font-weight: 500;" class="btn btn-light live-button" name ="livebtn" href="index.php">Live</a>


            <form method="post" style="display: inline-block;">
                <button id="button2" type="submit" class="btn btn-light" name="pointsButton">Points</button>
            </form>
            <form method="post" style="display: inline-block;">
                <button id="button3" type="submit" class="btn btn-light" name="scheduleButton">Schedule</button>
            </form>

            <a style="display: inline-block; color: #6665ee;
    font-weight: 500;" class="btn btn-light" href="index.php">Highlights</a>
    <a style="display: inline-block; color: #6665ee;
    font-weight: 500;" class="btn btn-light" href="index.php"> Sign In</a>

        </div>
    </nav>



    </div>


    <div>

        <?php

        if ($pointsResult) {
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
                echo "<tr><th>ID</th><th>Event Name</th><th>Date</th><th>Time</th></tr>";
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
                    // echo "<h3>" . $row['description'] . "</h3>";
                    echo "<h3>" . $row['description'] . "<span style='float: right;font-size: 15px;margin-top: 10px;''>(Updated at: " . $row['time'] . ")</span></h3>";                    
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
        }



        ?>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <footer style="margin-bottom:2px; text-align:center;">
        
        <p> 
            Copyright by &copy;Fun Olympic2023
        </p>
    
    
        </footer>
</body>




</html>