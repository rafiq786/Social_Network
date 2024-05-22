<?php 
include 'include/head.php';

// Check if the member ID is set in the session
if (isset($_SESSION['member_id'])) {
  $member_id = $_SESSION['member_id']; // Retrieve member ID from session
} else {
  // Redirect to login page or handle the situation where member ID is not set
  header("Location: login.php");
  exit(); // Stop further execution
}

$db = mysqli_connect('localhost', 'root', '', 'social_network') or die('Wrong Database Connection!');
$query = "SELECT * FROM posts WHERE posted_by='" . $member_id . "' ORDER BY post_id DESC";
$result = mysqli_query($db, $query);
?>
<style>
  body {
        background-color: #FFE5B4;
        font-family: Times New Roman, sans-serif;
    }

  .panel-default {
    border-color: #ddd;
  }

  .panel-body {
    padding: 15px;
  }

  .panel-footer {
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    padding: 10px 15px;
  }

  .media-body {
    padding-left: 20px;
  }

  .media-heading {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 24px;
    color: #333;
    font-weight: bold;
  }

  .media p {
    margin-bottom: 5px;
    color: #666;
  }

  .timeline-heading {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
    font-weight: bold;
  }

  .timeline-panel {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  .comments-heading {
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
  }

  .comment-content {
    margin-bottom: 10px;
    font-weight: bold;
  }

  .no-comments {
    margin-bottom: 10px;
    color: #666;
  }

  .comment-form {
    margin-top: 10px;
  }

  .input-group {
    margin-bottom: 10px;
  }
</style>

<main class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Edit profile</h4>
          <form method="post" action="profile.php">
            <div class="form-group">
              <input class="form-control" type="text" name="screen_name" placeholder="Screen Name" value="<?= $user_data['screen_name'];?>" required="">
            </div>
            <div class="form-group">
              <input class="form-control" type="text" name="status" placeholder="Status" value="<?= $user_data['status'];?>" required="">
            </div>

            <div class="form-group">
              <input class="form-control" type="text" name="location" placeholder="Location" value="<?= $user_data['location'];?>" required="">
            </div>

            <div class="form-group">
              <input class="btn btn-primary" type="submit" name="update_profile" value="Save">
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="media">
        <div class="media-left">
          <img src="img/head_sun_flower.png" class="media-object" style="width: 128px; height: 128px;">
        </div>
        
        <div class="media-body">
          <h2 class="media-heading"><?= $user_data['screen_name'];?></h2>
          <p><b>Status:</b> <?= $user_data['status'];?></p>
          <p><b>Location:</b> <?= $user_data['location'];?></p>
        </div>
      </div>

      <hr>

      <h1>My Timeline</h1>

      <div>
        <?php
          if (mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_array($result)) {?>
              <div class="panel panel-default">
                <?php
                  $posted_by = $rows['posted_by'];
                  if ($posted_by == $member_id) {
                    $display = "";
                  } else {
                    $display = "hidden";
                  }
                  $squery = "SELECT * FROM users WHERE member_id='" . $posted_by . "'";
                  $resultq = mysqli_query($db, $squery);
                  $suser_data = mysqli_fetch_assoc($resultq);
                  $post_id = $rows['post_id'];
                  $query2 = "SELECT count(*) AS likes FROM likes WHERE post_id='" . $post_id . "'";
                  $result2 = mysqli_query($db, $query2);
                  $likes = mysqli_fetch_array($result2);
                  if ($likes !== "") {
                    $likes = $likes['likes'];
                  } else {
                    $likes = 0;
                  }
                ?>
                <div class="panel-body">
                  <p><?=  $rows['post_body'];?></p>
                </div>
                <div class="panel-footer">
                  <span>Posted on <?=  $rows['date'];?></span> 
                  <span class="pull-right <?=$display;?>" style="padding-left: 10px;">
                    <a class="text-danger" href="db-server.php?delete_post=<?php echo $rows['post_id']?>" title="Delete Post" onclick="return confirm('Sure you want to remove?');"><i class="fa fa-trash"></i></a>
                  </span>
                  <span class="pull-right">
                    <a class="text-info" href="db-server.php?like_post=<?php echo $rows['post_id']?>&like_page=profile.php"><i title="Like" class="fa fa-thumbs-up"></i>
                    </a>(<span id="no_like"><?=$likes;?></span>)
                  </span>
                </div>
                <div style="padding-left: 10px;">
                  <b>Comments</b>
                </div>
                
                <div class="panel-body">
                  <?php
                    $com_query = "SELECT * FROM comments WHERE post_id='" . $post_id . "'";
                    $cresult = mysqli_query($db, $com_query);
                    if (mysqli_num_rows($cresult) > 0) {
                      while ($comment_data = mysqli_fetch_array($cresult)) {
                  ?>
                  <p id="content"><?=$comment_data['content']?></p>
                  <?php
                      }
                    } else {
                  ?>
                  <p><b>No comments</b></p>
                  <?php
                    }
                  ?>
                </div>
                <form method="post" action="profile.php">
                  <div class="input-group">
                    <input type="hidden" name="post_id" value="<?= $rows['post_id'];?>">
                    <input type="hidden" name="member_id" value="<?= $member_id;?>">
                    <input class="form-control" type="text" name="content" placeholder="Post Comment..." required="">
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="submit" name="submit_comment">Comment</button>
                    </span>
                  </div>
                </form>
              </div>
            <?php
            }
          } else {?>
            <div class="panel-body">
              <p>Post has not been Published!</p>
            </div>
          <?php } 
        ?>
      </div>
    </div>
  </div>
</main>

<?php include('include/foot.php'); ?>
