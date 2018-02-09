<?php

    include('../server/model.php');
    include('../server/connection.php');

    $res = listAllDoggos($conn);
?>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <?php while($row = mysqli_fetch_array($res)): ?>
        <div class="story-container">
            <div class="image-container">
                <img src="<?= $row['photo'] ?>" alt="<?= $row['title'] . "&" . $row['id'] ?>" class="img-responsive">
            </div>
            <div class="actions">
                <div class="statistics">
                    <small class="form-text text-muted likes-counter"><?php $num = countLikes($conn, $row['id']); echo $num['num_likes']; ?> likes</small>
                    <small class="form-text text-muted dislikes-counter"><?php $num = countDislikes($conn, $row['id']); echo $num['num_dislikes']; ?> dislikes</small>
                    <small class="form-text text-muted comments-counter"><?php $num = countComments($conn, $row['id']); echo $num['num_comm']; ?> comments</small>
                </div>
                <div class="buttons">
                    <?php 
                        $like = checkLike($conn, $_SESSION['id'], $row['id']); 
                        if($like) {
                            $liked = 'liked';
                        }
                        else{
                            $liked = '';
                        }
                        if(isset($_SESSION['id']))
                            $not_active = '';
                        else
                            $not_active = 'not-active'
                    ?>
                    <a href="#" class="like-button-link <?=$liked.' '.$not_active ?>">
                        <span class="like-button"><i class="far fa-thumbs-up"></i></span>
                    </a>
                    <?php 
                        $dislike = checkDislike($conn, $_SESSION['id'], $row['id']); 
                        if($dislike) {
                            $disliked = 'disliked';
                        }
                        else{
                            $disliked = '';
                        }
                    ?>
                    <a href="#" class="dislike-button-link <?=$disliked.' '.$not_active ?> ">
                        <span class="dislike-button"><i class="far fa-thumbs-down"></i></span>
                    </a>
                    <a href="#" class="comment-button-link <?=$not_active ?>">
                        <span class="comment-button"><i class="far fa-comments"></i></span>
                    </a>
                </div>
                <div class="insert-comment">
                    <textarea name="comment" cols="15" rows="2" class="form-control comment-textarea"></textarea>
                    <button class="btn btn-primary btn-block send_comment">Comment</button>
                    <input type="hidden" value="<?= $_SESSION['id']?>" class="session-user-id">
                </div>
            </div>
            <div class="list-of-comments">
                <?php
                    $comments = listCommentsForDoggo($conn, $row['id']);
                    if(mysqli_num_rows($comments) > 0):
                        $counter = 0;
                        while($comment = mysqli_fetch_array($comments)):
                            if($counter == 3) break;
                ?>  
                <div class="each-comment">
                    <span class="user-image"><img src="<?= $comment['avatar'] ?>" alt="<?= $comment['name'].'&'.$_SESSION['id'] ?>"></span>
                    <span class="user-name"><b><?= $comment['name'] ?></b></span>
                    <small class="form-test text-muted date-commented"><?= $comment['date_commented'] ?></small>
                    <div class="user-message"><p><?= $comment['comment'] ?></p></div>
                </div>
                <?php 
                        $counter++;
                        endwhile;
                    else:
                        ?>
                            <div class="alert alert-primary" role="alert">
                                No comments yet for this doggo!
                            </div>
                        <?php
                    endif; 
                ?>
            </div>
            <?php if(mysqli_num_rows($comments)>3):?>
            <div class="pusher"></div>
            <a href="<?=$row['id'] ?>" class="btn btn-primary btn-block load-more">Load more comments</a>
                <?php endif; ?>
        </div>
        <?php endwhile ?>
    </div>
</div>
