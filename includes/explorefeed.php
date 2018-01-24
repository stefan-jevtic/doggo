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
                    <small class="form-text text-muted likes-counter">10 likes</small>
                    <small class="form-text text-muted dislikes-counter">3 dislikes</small>
                    <small class="form-text text-muted comments-counter">42 comments</small>
                </div>
                <div class="buttons">
                    <a href="#" class="like-button-link">
                        <span class="like-button"><i class="far fa-thumbs-up"></i></span>
                    </a>
                    <a href="#" class="dislike-button-link">
                        <span class="dislike-button"><i class="far fa-thumbs-down"></i></span>
                    </a>
                    <a href="#" class="comment-button-link">
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
                        while($comment = mysqli_fetch_array($comments)):
                ?>  
                <div class="each-comment">
                    <span class="user-image"><img src="<?= $comment['avatar'] ?>" alt="<?= $comment['name'].'&'.$_SESSION['id'] ?>"></span>
                    <span class="user-name"><b><?= $comment['name'] ?></b></span>
                    <small class="form-test text-muted date-commented"><?= $comment['date_commented'] ?></small>
                    <div class="user-message"><p><?= $comment['comment'] ?></p></div>
                </div>
                <?php 
                        endwhile;
                    else:
                            echo $comments;
                    endif; 
                ?>
                <a href="#"><small class="form-test text-muted">Load more comments</small></a>
            </div>
        </div>
        <?php endwhile ?>
    </div>
</div>
