<?php
        include("../server/model.php");
        include("../server/connection.php");
?>

<div class="row">
        <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="gallery-title">Welcome to doggo website!</h1>
        </div>
        <div class="gallery-holder">
            <?php
                $doggos = randomNine($conn);
                while($doggo = mysqli_fetch_array($doggos)):
            ?>
            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
            <a data-fancybox='group' data-caption="<?=$doggo['title']?>" href="<?=$doggo['photo']?>"><img src="<?=$doggo['photo']?>" alt="<?=$doggo['title'].'&'.$doggo['id']?>" class="img-responsive"></a>
            </div>
            <?php endwhile; ?>  
        </div>
</div>