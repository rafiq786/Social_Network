<?php include 'db-server.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Social Network - Login</title>
  <link href="img/icon.png" rel="icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style>
    body {
      background-color: #FFE5B4;
      font-family: Arial, sans-serif;
    }
    .container {
      margin-top: 50px;
    }
    .login-form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .login-heading {
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .login-btn {
      width: 100%;
    }
    .register-link {
      text-align: center;
      margin-top: 20px;
    }
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
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h1 class="login-heading">Welcome to Social Network!</h1>
        <div class="login-form">
          <form method="post">
            <div class="form-group">
              <input class="form-control" type="text" name="username" placeholder="Username" required="">
            </div>
            <div class="form-group">
              <input class="form-control" type="password" name="password" placeholder="Password" required="">
            </div>
            <div class="form-group">
              <?php include('errors.php'); 
              if (isset($_SESSION['msg'])) {
                echo "<span style='color:red'><b>".$_SESSION['msg']."</b></span>";
                unset($_SESSION['msg']);
              }
              ?>
            </div>
            <div class="form-group">
              <input class="btn btn-primary login-btn" type="submit" name="login" value="Login">
            </div>
            <div class="form-group register-link">
              Don't have an account yet? <a href="register.php">Register Here!</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include('include/foot.php'); ?>
</body>
</html>
