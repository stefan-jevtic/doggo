<?php
session_start();

    if(isset($_SESSION['username'])){
        include("../server/connection.php");
        include("../server/model.php");

?>
<div class="row justify-content-md-center">
<div class="col-lg-12 col-sm-12">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="<?php echo $_SESSION['avatar']; ?>">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
            <img alt="" src="<?php echo $_SESSION['avatar']; ?>">
        </div>
        <div class="card-info"> <span class="card-title"><?php echo $_SESSION['username']; ?></span>

        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item tabovi">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                <span class="far fa-arrow-alt-circle-up fa-3x" aria-hidden="true"></span>
                <!-- <div class="hidden-xs">Uploaded</div> -->
            </a>
        </li>
        <li class="nav-item tabovi">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                <span class="far fa-heart fa-3x" aria-hidden="true"></span>
                <!-- <div class="hidden-xs">Favorites</div> -->
            </a>
        </li>
        <li class="nav-item tabovi">
            <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                <span class="far fa-user fa-3x" aria-hidden="true"></span>
                <!-- <span class="hidden-xs">User info</div -->
            </a>
        </li>
    </ul>

    <div class="well">
        <div class="tab-content lg-9" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h2>Uploaded Doggos</h2>
                <div class="gallery-holder">
                    <?php 
                        $dogs = listUploadedDoggos($conn, $_SESSION['id']);
                        while($dog = mysqli_fetch_array($dogs)):
                    ?>
                    <div class="polaroid">
                        <img src="<?= $dog['photo'] ?>" alt="<?= $dog['title'] ?>" style="width:100%">
                        <div class="paragraph">
                            <p><?= $dog['title'] ?></p>
                        </div>
                    </div>
                    <?php endwhile ?>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h2>Doggos you like</h2>
                <div class="gallery-holder">
                    <?php
                        $doglikes = listLikedDoggos($conn, $_SESSION['id']);
                        while($doglike = mysqli_fetch_array($doglikes)):
                    ?>
                    <div class="polaroid">
                        <img src="<?= $doglike['photo'] ?>" alt="<?= $doglike['title'] ?>" style="width:100%">
                        <div class="paragraph">
                            <p><?= $doglike['title'] ?></p>
                        </div>
                    </div>
                    <?php endwhile ?>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <h3><strong>Basic information:</strong></h3>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Username:</th>
                            <td class="user-row"><?php echo $_SESSION['username'];?></td>
                            <td><button type="button" class="btn btn-primary" data-target="#changeUsername" data-toggle="modal">Change</button></td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td class="email row"><?php echo $_SESSION['email']; ?></td>
                            <td><button type="button" class="btn btn-primary" data-target="#changeEmail" data-toggle="modal">Change</button></td>
                        </tr>
                        <tr>
                            <th scope="row">Avatar:</th>
                            <td class="avatar row"><img src="<?php echo $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['role']; ?>" style="width:70px; height:70px;"></td>
                            <td><button type="button" class="btn btn-primary" data-target="#changeAvatar" data-toggle="modal">Change</button></td>
                        </tr>
                        <tr>
                            <th scope="row">Role:</th>
                            <td><?php echo $_SESSION['role']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">Member since:</th>
                            <td><?php echo $_SESSION['date']; ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <h5><strong>Recently used profile pictures:</strong></h5>
                <div class="recently-used">
                    <?php
                        $rows = getProfilePictures($conn, $_SESSION['id']);
                        while($row = mysqli_fetch_array($rows)){
                            ?>

                            <a href="#" class="changeProfile">
                                <div class="card" style="width: 12rem; display: inline-block;">
                                <img class="card-img-top" style="width:126px; height:126px;" src="<?php echo $row['path'] ?>" alt="Card image cap">
                                <div class="card-body">
                                    <!-- <h5 class="card-title">Card title</h5>
                                    <a href="#" class="btn btn-primary">Set as profile</a> -->
                                </div>
                                </div>
                            </a>
                            

                            <?php
                        }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
</div>


<!--    MODALS     -->

<div class="modal changeUsername" tabindex="-1" id="changeUsername" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change username</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="form-group">
                <label for="tbUsername">Username</label>
                <input type="text" class="form-control" id="tbChangeUsername" placeholder="Username">
                <span class="username error"></span>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnUpdateUsername">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal changeEmail" tabindex="-1" id="changeEmail" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change username</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="form-group">
                <label for="tbChangeEmail">Email</label>
                <input type="email" class="form-control" id="tbChangeEmail" placeholder="Email">
                <span class="email error"></span>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnUpdateEmail">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal changeAvatar" tabindex="-1" id="changeAvatar" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change username</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/ajax.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
                <div class="form-group">
                    <label for="tbChangeEmail">Photo</label>
                    <input type="file" class="form-control" name="tbChangeAvatar" id="tbChangeAvatar">
                    <span class="avatar error"></span>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="btnUpdateAvatar" id="btnUpdateAvatar">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--    SUCCESS MODAL     -->
<div class="modal fade modalSuccess" id="modalFailedSignIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Success!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
            
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    }
    else{
        include("404.php");
    }
?>