<?php

    include('../server/model.php');
    include('../server/connection.php');
        if(isset($_SESSION['username'])):
?>
<div class="row justify-content-md-center">
    <div class="col-md-6 align-self-center">
        <form action="includes/ajax.php" method="POST" enctype="multipart/form-data" id="doggoForm">
            <div class="form-group">
                <label for="tbTitle">Title</label>
                <input type="text" class="form-control" name="tbDoggoTitle" id="tbDoggoTitle" placeholder="Enter title">
                <span class="title error"></span>
            </div>
            <div class="form-group">
                <label for="ddlCategory">Category</label>
                <select name="ddlDoggoCategory" id="ddlDoggoCategory" class="form-control">
                    <option value="0">Choose...</option>
                    <?php
                        $res = listCategories($conn);
                        while($row = mysqli_fetch_array($res)):
                    ?>
                    <option value="<?= $row['id']?> "><?= $row['name'] ?></option>
                    <?php endwhile ?>
                </select>
                <span class="category error"></span>
            </div>
            <div class="form-group">
                <label for="taDoggoDescription">Description</label>
                <textarea name="taDoggoDescription" id="taDoggoDescription" cols="15" rows="5" class="form-control" placeholder="Enter description..."></textarea>
                <span class="description error"></span>
            </div>
            <div class="form-group">
                <label for="doggo">Upload Doggo photo</label>
                <input type="file" class="form-control" name="flDoggo" id="flDoggo" >
                <span class="doggo error"></span>
            </div>
            <button type="submit" class="btn btn-primary" name="btnUploadDoggo" id="btnUploadDoggo">Upload</button>
        </form>
    </div>
</div>
<?php
        else:
            include("404.php");
    endif    
?>
