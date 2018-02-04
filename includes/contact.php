<?php
    include("../server/model.php");
    include("../server/connection.php");

    $ques = getQandA($conn);
?>

<div class="row justify-content-md-center">
    <div class="col-lg-12 col-sm-12">
        <div class="poll-holder">
        <?php 
            $counter = 0;
            while($row = mysqli_fetch_array($ques)): 
                if($counter == 0):
        ?>
            <div class="poll-header">
                <?= $row['question'] ?>
            </div>
            <div class="poll-body">
                <?php endif; $counter++; ?>
                <span class="poll-answer">
                    <input type="radio" name="rbAnswer" class="rbAnswer"> <?= $row['answer'] ?>
                </span><br>
                <?php endwhile ?>
            </div>
            <div class="poll-footer">
                <span class="button-vote">
                    <button type="button" class="btn btn-success btnVote">Vote</button>
                </span>
                <span class="button-results">
                    <button type="button" class="btn btn-primary btnShowRes">Show results</button>
                </span>
            </div>
        </div>
    </div>
</div>