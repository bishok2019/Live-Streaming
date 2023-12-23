<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "userform";

// Establishing MySQL connection
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user input
function sanitize_input($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Register a new user
if (isset($_POST['register'])) {
    $username = sanitize_input($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = sanitize_input($conn, $_POST['email']);

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

    if (mysqli_query($conn, $sql)) {
        // echo "Congratualation!!! Registration is successful!";
        $registrationSuccess = true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// User login
if (isset($_POST['login'])) {
    $username = sanitize_input($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            // Redirect to admin.php
            header("Location: admin.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Invalid username!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login and Registration Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 93%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
    if (isset($registrationSuccess) && $registrationSuccess) {
        echo '<p style="color: green; text-align: center;">Congratulations!!! Registration is successful!</p>';
    }
    ?>
    <?php
    // Check if the "Register Admin" button was clicked
    if (isset($_POST['show_register_form'])) {
        echo '<h2>Admin Register</h2>
        <form method="POST" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <button type="submit" name="register">Register</button>
        </form>';
    } else {
        echo '<h2>Admin Login</h2>
        <form method="POST" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <form method="POST" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'">
            <button type="submit" name="show_register_form">Register Admin</button>
        </form>';
    }
    ?>
</body>
</html>
