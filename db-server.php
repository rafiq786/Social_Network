<?php
session_start();

$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'social_network') or die('Wrong Database Connection!');

if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
  $screen_name = mysqli_real_escape_string($db, $_POST['screen_name']);
  $dob  = mysqli_real_escape_string($db, $_POST['dob']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $status = mysqli_real_escape_string($db, $_POST['status']);
  $location = mysqli_real_escape_string($db, $_POST['location']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

  $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user && $user['username'] === $username) {
    array_push($errors, "User already exists");
  }

  if (count($errors) == 0) {
    $password = md5($password_1);
    $query = "INSERT INTO users(username, full_name, screen_name, dob, gender, status, location, password) 
    VALUES('$username', '$full_name', '$screen_name', '$dob', '$gender', '$status', '$location', '$password')";
    mysqli_query($db, $query);
    echo "<script>alert('Successfully Registered, Click Ok to login!')</script>";
    echo "<script>window.location.href='index.php';</script>";
  }
}

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
      $user = mysqli_fetch_assoc($results);
      $_SESSION['username'] = $user['username'];
      $_SESSION['screen_name'] = $user['screen_name'];
      $_SESSION['member_id'] = $user['member_id'];
      $_SESSION['success'] = "You are now logged in";
      header('location: home.php');
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

if (isset($_POST['update_profile'])) {
  $user = $_SESSION['username'];
  $status = mysqli_real_escape_string($db, $_POST['status']);
  $location = mysqli_real_escape_string($db, $_POST['location']);
  $screen_name = mysqli_real_escape_string($db, $_POST['screen_name']);

  $query = "UPDATE users SET status='$status', location='$location', screen_name='$screen_name' WHERE username='$user'";
  mysqli_query($db, $query);
  header("location: profile.php");
}

if (isset($_POST['submit_post'])) {
  $user_id = mysqli_real_escape_string($db, $_POST['mem_id']);
  $content = mysqli_real_escape_string($db, $_POST['content']);
  $post_img = "";

  if (basename($_FILES["fileToUpload"]["name"]) != "") {
    $target_dir = "img/posts/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $post_img = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));

    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "<script>alert('Sorry, there was an error uploading your file!')</script>";
    }
  }

  $query = "INSERT INTO posts(post_body, post_img, posted_by) VALUES('$content', '$post_img', '$user_id')";
  mysqli_query($db, $query);
  $_SESSION['success'] = "Post published successfully!";
}

if (isset($_POST['submit_comment'])) {
  $user_id = mysqli_real_escape_string($db, $_POST['member_id']);
  $post_id = mysqli_real_escape_string($db, $_POST['post_id']);
  $content = mysqli_real_escape_string($db, $_POST['content']);

  $query = "INSERT INTO comments(content, post_id, member_id) VALUES('$content', '$post_id', '$user_id')";
  mysqli_query($db, $query);
  header('location: home.php');
}

if (isset($_GET['delete_post'])) {
  $id = $_GET['delete_post'];
  $query = "DELETE FROM posts WHERE post_id='$id'";
  mysqli_query($db, $query);
  $query2 = "DELETE FROM comments WHERE post_id='$id'";
  mysqli_query($db, $query2);
  header('location: home.php');
}

if (isset($_GET['like_post'])) {
  $post_id = $_GET['like_post'];
  $page = $_GET['like_page'];
  $member_id = $_SESSION['member_id'];

  $like_check_query = "SELECT * FROM likes WHERE post_id='$post_id' AND member_id='$member_id' LIMIT 1";
  $result = mysqli_query($db, $like_check_query);
  $check = mysqli_fetch_assoc($result);

  if ($check) {
    // Post is already liked
    echo "<script>alert('You have already liked this post.');</script>";
    header('location:'.$page);
  } else {
    // Insert like into database
    $query = "INSERT INTO likes(post_id, member_id) VALUES('$post_id', '$member_id')";
    mysqli_query($db, $query);
    echo "<script>alert('Post liked successfully.');</script>";
    header('location:'.$page);
  }
}

