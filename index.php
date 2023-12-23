<?php
session_start();
if (isset($_SESSION['Email_Session'])) {
  header("Location: logout-user.php");
  die();
}
include('config.php');
$msg = "";
$Error_Pass = "";
if (isset($_GET['Verification'])) {
  $raquet = mysqli_query($conx, "SELECT * FROM register WHERE CodeV='{$_GET['Verification']}'");
  if (mysqli_num_rows($raquet) > 0) {
    $query = mysqli_query($conx, "UPDATE register SET verification='1' WHERE CodeV='{$_GET['Verification']}'");
    if ($query) {
      $rowv = mysqli_fetch_assoc($raquet);
      header("Location: logout-user.php?id='{$rowv['id']}'");
    } else {
      header("Location: index.php");
    }
  } else {
    header("Location: index.php");
  }
}
if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conx, $_POST['email']);
  $Pass = mysqli_real_escape_string($conx, md5($_POST['Password']));
  $sql = "SELECT * FROM register WHERE email='{$email}' and Password='{$Pass}'";
  $resulte = mysqli_query($conx, $sql);
  if (mysqli_num_rows($resulte) === 1) {
    $row = mysqli_fetch_assoc($resulte);
    if ($row['verification'] === '1') {
      $_SESSION['Email_Session'] = $email;
      $_SESSION['Username'] = $row['username']; // Add this line to store the username in the session
      header("Location:home.php");
    } else {
      $msg = "<div class='alert alert-info'>First Verify Your Account</div>";
    }
  } else {
    $msg = "<div class='alert alert-danger'>Email or Password is not match</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css" />
  <title>Sign in Form</title>
  <style>
  </style>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        
        <form action="" method="POST" class="sign-in-form">
        <!-- <h5 style="color:#6665ee">Please Sign in to to aceess video content of Fun Olympics 2023 !!</h5> -->
        <br>
          <h2 class="title">Sign in</h2>
          <?php echo $msg ?>
          <div class="input-field">
            <i>
              <span class="input-group-append">
                <img src="img//mail.png" style="width: 25px; height: 25px; margin-top: 15px;">
              </span>
            </i>
            <input type="text" name="email" placeholder="Email" />
          </div>
          <div class="input-field">
            <i>
              <i>
                <span class="input-group-append">

                  <img src="img/eye-close.png" alt="toggle password visibility" onclick="togglePasswordVisibility()"
                    style="width: 25px; height: 20px; margin-top: 15px; cursor: pointer;">

                </span>
              </i>
            </i>
            <input id="password" type="password" name="Password" placeholder="Password" />
          </div>
          <div class="Forget-Pass">
            <a href="Forget.php" class="Forget">Forget Password ?</a>
          </div>
          <input type="submit" name="submit" value="Login" class="btn solid" />
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
          <!-- <a style="display: inline-block; color: #6665ee;font-weight: 500;" href="adminvalidation.php"> Admin Panel</a> -->
        </form>
        <script src="script.js"></script>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
        <h1 style='text-align:center;'>Fun Olympics 2023</h1>
            <img src="img/olympic.png" class="image" style="margin: -70px 0 -110px 0;" alt="" />
          <h3>New here ?</h3>
          <p>
            Enter your details and help yourself to connect with us.
          </p>
          <a href="SignUp.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
            Sign up
          </a>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
    </div>
  </div>
</body>

</html>