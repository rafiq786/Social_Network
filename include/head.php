<?php 
include('db-server.php');

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in to continue..!";
  header('location: index.php');
  exit();
}

if (isset($_GET['Logout'])) {
  session_destroy();
  header("location: index.php");
  exit();
}

if (isset($_SESSION['username'])){
  $user = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username='".$user."'";
  $result = mysqli_query($db, $query);
  $user_data = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Social Network</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="img/icon.png" rel="icon">
  <meta property="og:image" content="img/logo.png" />
  <meta property="og:image:type" content="image/png">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
  <style type="text/css">
    #content{
      background-color: #fff;
      padding: 5px 0px 5px 10px;
      border-radius: 5px;
      font-weight: bold;
    }
    .post_area {
      width: 100%;
      height: 150px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      font-size: 16px;
      resize: none;
    }
    .post_img {
      width: 100%;
      height: auto;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="home.php">Social Network</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php echo $filename == 'home.php' ? 'active' : ''; ?>"><a href="home.php">Home</a></li>
        <li class="<?php echo $filename == 'profile.php' ? 'active' : ''; ?>"><a href="profile.php">Profile</a></li>
        <li class="<?php echo $filename == 'my-posts.php' ? 'active' : ''; ?>"><a href="my-posts.php">My Posts</a></li>
        <li><a href="home.php?Logout='1'">Logout</a></li>
      </ul>
    </div>
  </nav>
</body>
</html>
