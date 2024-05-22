<?php include('include/head.php'); ?>

<style>
    body {
        background-color: #FFE5B4;
        font-family: Times New Roman, sans-serif;
    }

    .sidebar-panel {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .profile-heading {
        color: #333;
        font-size: 24px;
        margin-top: 0;
        font-weight: bold;
    }

    .profile-heading + h4 {
        margin-top: 10px;
        margin-bottom: 20px;
        color: #666;
        font-weight: bold;
    }

    .posts-container {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
    }

    .posts-heading {
        color: #333;
        font-size: 34px;
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .post-panel {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 20px;
        width: 100%;
    }

    .panel-body {
        padding: 15px;
    }

    .panel-footer {
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        padding: 10px 15px;
    }

    .comments-section {
        margin-top: 20px;
    }

    .comments-heading {
        color: #333;
        font-size: 18px;
        margin-top: 0;
        margin-bottom: 10px;
    }

    .comment-content {
        margin-bottom: 10px;
    }

    .no-comment {
        color: #999;
        font-style: italic;
        margin-bottom: 10px;
    }

    .comment-form {
        margin-top: 20px;
    }

    .comment-input {
        border-radius: 3px;
    }

    .comment-btn {
        border-radius: 8px;
    }
    .post-btn {
        border-radius: 8px;
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding:5px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        width: 100%;
    }

    .post-btn:hover {
        background-color: #45a049; /* Darker Green */
    }
</style>

<main class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default sidebar-panel">
                <div class="panel-body">
                    <h3 class="profile-heading">My Profile</h3>
                    <h4><?= isset($user_data['screen_name']) ? $user_data['screen_name'] : ''; ?></h4>
                    <p><?= isset($user_data['status']) ? $user_data['status'] : ''; ?></p>
                    <p><a href="profile.php"><b>Manage Profile</b></a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form method="post" action="home.php" enctype="multipart/form-data">
                <input type="hidden" name="mem_id" value="<?= isset($user_data['member_id']) ? $user_data['member_id'] : ''; ?>">
                <textarea class="post_area form-control" type="text" name="content" placeholder="Make a new post..." required=""></textarea>
                <label for="files" class="file-label">Select Image</label>
                <input name="fileToUpload" accept="image/*" type='file' id="imgInp" class="file-input" />
                <p class="post-btn-wrapper">
                    <button class="btn btn-success post-btn" type="submit" name="submit_post">Post</button>
                </p>
                <br>
                <p id="prev_txt" class="preview-text">
                    <b>Preview:</b>
                </p>
                <img id="prev_img" src="img/head_sun_flower.png" alt="your image" class="preview-img" />
            </form>
            <?php if (isset($_SESSION['success'])){ ?>
                <script>
                    alert("<?php echo $_SESSION['success']; ?>");
                </script>
                <?php unset($_SESSION['success']); ?>
            <?php } ?>
            <hr>
            <h2 class="posts-heading">All Posts</h2>
            <div class="posts-container">
                <?php
                $query="SELECT * from posts order by post_id desc";
                $result=mysqli_query($db, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($rows=mysqli_fetch_array($result)) {?>
                        <div class="panel panel-default post-panel">
                            <?php
                            $posted_by=$rows['posted_by'];
                            $squery="SELECT * from users where member_id='".$posted_by."'";
                            $resultq=mysqli_query($db, $squery);
                            if ($resultq) {
                                $suser_data= mysqli_fetch_assoc($resultq);
                                $post_id=$rows['post_id'];
                                $query2="SELECT count(*) as likes from likes where post_id='".$post_id."'";
                                $result2=mysqli_query($db, $query2);
                                if ($result2) {
                                    $likes=mysqli_fetch_array($result2);
                                    if ($likes!=="") {
                                        $likes=$likes['likes'];
                                    }
                                    else{
                                        $likes=0;
                                    }
                                }
                                if (isset($member_id) && $posted_by==$member_id) {
                                    $display="";
                                    $post_user="You";
                                }
                                else{
                                    $display="hidden";
                                    $post_user= isset($suser_data['screen_name']) ? $suser_data['screen_name'] : '';
                                }
                            ?>
                            <div class="panel-body">
                                <p><?=  $rows['post_body'];?></p>
                                <?php
                                if ($rows['post_img'] != "") { ?>
                                    <p><img src="img/posts/<?php echo  $rows['post_img'];?>" class="post_img"></p>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="panel-footer">
                                <span>
                                    Posted on <?=  $rows['date'];?> by <b><?=$post_user;?></b>
                                </span> 
                                <span class="pull-right <?=$display;?>">
                                    <a class="text-danger" href="db-server.php?delete_post=<?php echo $rows['post_id']?>" title="Delete Post" onclick="return confirm('Are You Sure you want to remove?');"><i class="fa fa-trash"></i></a>
                                </span>
                                <span class="pull-right">
                                    <a class="text-info" href="db-server.php?like_post=<?php echo $rows['post_id']?>&like_page=home.php"><i title="Like" class="fa fa-thumbs-up"></i></a>(<span class="like-count"><?=$likes;?></span>)
                                </span>
                            </div>
                            <div class="comments-section">
                                <div class="comments-heading">
                                    <b>Comments</b>
                                </div>
                                <div class="comments-body">
                                    <?php
                                    $com_query="SELECT * from comments where post_id='".$post_id."'";
                                    $cresult=mysqli_query($db, $com_query);
                                    if ($cresult && mysqli_num_rows($cresult) > 0) {
                                        while($comment_data = mysqli_fetch_array($cresult)){ ?>
                                            <p class="comment-content"><?=$comment_data['content']?></p>
                                    <?php
                                        }
                                    } else { ?>
                                        <p class="no-comment">No comments</p>
                                    <?php } ?>
                                </div>
                                <form method="post" action="home.php" class="comment-form">
                                    <div class="input-group">
                                        <input type="hidden" name="post_id" value="<?= $rows['post_id'];?>">
                                        <input type="hidden" name="member_id" value="<?= isset($member_id) ? $member_id : ''; ?>">
                                        <input class="form-control comment-input" type="text" name="content" placeholder="Post Comment..." required="">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success comment-btn" type="submit" name="submit_comment">Comment</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                        }
                    }}
                    else {?>
                        <div class="panel-body">
                            <p>No post published yet!</p>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php include('include/foot.php'); ?>
