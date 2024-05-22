<?php include 'db-server.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Social Network - Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="img/icon.png" rel="icon">
  <meta property="og:image" content="img/logo.png" />
  <meta property="og:image:type" content="image/png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    b<style>
  /* Body Styles */
  body {
      background-color: #FFE5B4;
      font-family: Arial, sans-serif;
    }

  /* Container Styles */
  .container {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
    margin-top: 50px;
  }

  /* Form and Input Styles */
  .form-group input[type="text"],
  .form-group input[type="email"],
  .form-group input[type="date"],
  .form-group input[type="password"],
  .form-group input[type="radio"] {
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 12px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 15px;
    transition: border-color 0.3s;
  }

  .form-group input[type="text"]:focus,
  .form-group input[type="email"]:focus,
  .form-group input[type="date"]:focus,
  .form-group input[type="password"]:focus {
    border-color: #4CAF50;
    outline: none;
  }

  .form-group label {
    font-weight: bold;
    margin-bottom: 8px;
    color: #333;
  }

  .radio-inline {
    margin-right: 25px;
    color: #333;
  }

  .form-group a {
    color: #337ab7;
    text-decoration: none;
    transition: color 0.3s;
  }

  .form-group a:hover {
    color: #23527c;
  }

  /* Button Styles */
  .btn-success {
    background-color: #4CAF50;
    border-color: #4CAF50;
    padding: 12px 24px;
    font-size: 18px;
    border-radius: 5px;
    transition: background-color 0.3s, border-color 0.3s;
    width: 100%;
  }

  .btn-success:hover {
    background-color: #45a049;
    border-color: #45a049;
  }

  /* Heading Styles */
  h1, h4 {
    text-align: center;
    color: #333;
  }

  /* Navbar Styles */
  .navbar {
    background-color: #4CAF50;
    border: none;
    border-radius: 0;
    margin-bottom: 0;
  }

  .navbar-brand {
    color: #fff;
    font-size: 24px;
    transition: color 0.3s;
  }

  .navbar-brand:hover {
    color: #f0f0f0;
  }
</style>

  </style>
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">Social Network</a>
      </div>
    </div>
  </nav>
  <main class="container">
    <h1>Welcome to Social Network!</h1>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h4>Don't have an account yet? Register here!</h4>
        <?php include 'errors.php'; ?>
        <form method="post">
          <div class="form-group">
            <label for="username">Username/Email:</label>
            <input class="form-control" type="email" name="username" id="username" placeholder="Username/Email" required="">
          </div>
          <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input class="form-control" type="text" name="full_name" id="full_name" placeholder="Full Name" required="">
          </div>
          <div class="form-group">
            <label for="screen_name">Screen Name:</label>
            <input class="form-control" type="text" name="screen_name" id="screen_name" placeholder="Screen Name" required="">
          </div>
          <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input class="form-control" type="date" name="dob" id="dob" placeholder="Date of Birth" title="Date of Birth" required="">
          </div>
          <div class="form-group">
            <label>Gender:</label>
            <div>
              <label class="radio-inline"><input type="radio" name="gender" value="Male">Male</label>
              <label class="radio-inline"><input type="radio" name="gender" value="Female">Female</label>
              <label class="radio-inline"><input type="radio" name="gender" value="Other">Other</label>
            </div>
          </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <input class="form-control" type="text" name="status" id="status" placeholder="Status" required="">
          </div>
          <div class="form-group">
            <label for="location">Location:</label>
            <input class="form-control" type="text" name="location" id="location" placeholder="Location" required="">
          </div>
          <div class="form-group">
            <label for="password">Password: (At least one number, one uppercase, and at least 8 characters)</label>
            <input class="form-control" type="password" name="password_1" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required="">
          </div>
          <div class="form-group">
            <input class="btn btn-success" type="submit" name="register" value="Register">
          </div>
          <div class="form-group">
            Already have an account? <a href="index.php">Login Here</a>
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include 'include/foot.php'; ?>
</body>
</html>
