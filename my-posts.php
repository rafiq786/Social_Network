<?php include 'include/head.php'; ?>
<style>
    body {
        background-color: #FFE5B4;
        font-family: Times New Roman, sans-serif;
    }

    .sidebar-panel {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
    }

    .profile-heading {
        text-align: center;
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }

    .profile-heading + h4 {
        margin-top: 10px;
        margin-bottom: 20px;
        color: #666;
        font-weight: bold;
    }

    .timeline-panel {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .timeline-panel .panel-body {
        padding: 15px;
    }

    .timeline-panel .panel-footer {
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        padding: 10px 15px;
    }

    .timeline-panel .comments {
        padding: 15px;
    }

    .timeline-panel .comment-content {
        margin-bottom: 10px;
    }

    .timeline-panel .no-comments {
        margin-bottom: 10px;
    }

    .timeline-panel .comment-form {
        padding: 15px;
    }
</style>
<?php 
// Check if the member ID is set in the session
if (isset($_SESSION['member_id'])) {
  $member_id = $_SESSION['member_id']; // Retrieve member ID from session
} else {
  // Redirect to login page or handle the situation where member ID is not set
  header("Location: login.php");
  exit(); // Stop further execution
}
?>

<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="panel panel-default sidebar-panel" style="background-color: #f8f9fa;">
                <div class="panel-body">
                    <h3 class="text-center">My Profile</h3>
                    <h4><?= $user_data['screen_name'];?></h4>
                    <p><?= $user_data['status'];?></p>
                    <p><a href="profile.php"><b>Manage Profile</b></a></p>
                </div>
            </div>
        </div>
        <!-- Timeline -->
        <div class="col-md-9">
            <!-- Success message -->
            <?php if (isset($_SESSION['success'])){ ?>
            <div class="alert alert-success">
                <?php 
                  echo $_SESSION['success']; 
                  unset($_SESSION['success']);
                ?>
            </div>
            <?php } ?>
            <hr>
            <h1 class="text-center">My Timeline</h1>
            <div class="timeline">
                <?php
                $query="SELECT * from posts where posted_by='".$member_id."' order by post_id desc";
                $result=mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($rows=mysqli_fetch_array($result)) {?>
                <div class="panel panel-default timeline-panel" style="background-color: #ffffff;">
                    <?php
                    $posted_by=$rows['posted_by'];
                    $squery="SELECT * from users where member_id='".$posted_by."'";
                    $resultq=mysqli_query($db, $squery);
                    $suser_data= mysqli_fetch_assoc($resultq);
                    $post_id=$rows['post_id'];
                    $query2="SELECT count(*) as likes from likes where post_id='".$post_id."'";
                    $result2=mysqli_query($db, $query2);
                    $likes=mysqli_fetch_array($result2);
                    $likes_count = ($likes !== "") ? $likes['likes'] : 0;
                    $post_user = ($posted_by == $member_id) ? "You" : $suser_data['screen_name'];
                    ?>
                    <div class="panel-body">
                        <p><?= $rows['post_body'];?></p>
                        <?php if ($rows['post_img'] != "") { ?>
                        <p><img src="img/posts/<?= $rows['post_img'];?>" class="img-responsive"></p>
                        <?php } ?>
                    </div>
                    <div class="panel-footer">
                        <span>Posted on <?= $rows['date'];?> by <b><?= $post_user;?></b></span>
                        <span class="pull-right">
                            <a href="db-server.php?like_post=<?= $rows['post_id']?>&like_page=home.php" class="text-info">
                                <i title="Like" class="fa fa-thumbs-up"></i> (<span class="like-count"><?= $likes_count;?></span>)
                            </a>
                        </span>
                        <?php if ($posted_by == $member_id) { ?>
                        <span class="pull-right" style="padding-right: 10px;">
                            <a href="db-server.php?delete_post=<?= $rows['post_id']?>" class="text-danger" title="Delete Post" onclick="return confirm('Are You Sure you want to remove?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                        <?php } ?>
                    </div>
                    <div class="comments">
                        <h4>Comments</h4>
                        <?php
                        $com_query="SELECT * from comments where post_id='".$post_id."'";
                        $cresult=mysqli_query($db, $com_query);
                        if (mysqli_num_rows($cresult) > 0) {
                            while($comment_data = mysqli_fetch_array($cresult)){ ?>
                        <p class="comment-content"><?= $comment_data['content']?></p>
                        <?php }} else { ?>
                        <p class="no-comments"><em>No comments</em></p>
                        <?php } ?>
                    </div>
                    <form method="post" action="home.php" class="comment-form">
                        <input type="hidden" name="post_id" value="<?= $rows['post_id'];?>">
                        <input type="hidden" name="member_id" value="<?= $member_id;?>">
                        <div class="form-group">
                            <input class="form-control" type="text" name="content" placeholder="Post Comment..." required="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit" name="submit_comment">Comment</button>
                        </div>
                    </form>
                </div>
                <?php }} else { ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>No post published yet!</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php include('include/foot.php'); ?>
