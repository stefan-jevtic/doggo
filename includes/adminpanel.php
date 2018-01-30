<?php

    include("../server/model.php");
    include("../server/connection.php");

?>
<div class="row">

<div class="content-holder">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
</div>
<div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
  <div class="panel panel-success" style="border: 1px solid #ddd; border-radius: 5px;">
      <div class="alert alert-success panel-heading">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3">
            <h2 class="text-center pull-left" style="padding-left: 30px;"> <span class="glyphicon glyphicon-list-alt"> </span> Users </h2>
          </div>
          <!-- <div class="col-xs-9 col-sm-9 col-md-9">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-12 col-md-4">
                <label> Search </label>
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control input-md" name="search">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-md btn-warning"> <span class=" glyphicon glyphicon-search"></span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>

      <div class="panel-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center"> Id </th>
              <th class="text-center"> Username </th>
              <th class="text-center"> Email </th>
              <th class="text-center"> Role </th>
              <th class="text-center"> Join date </th>
              <th class="text-center">Update</th>
              <th class="text-center">Delete</th>
            </tr>
          </thead>

          <tbody>
          <?php 
            $res = listUsers($conn);
            while($row = mysqli_fetch_array($res)):
          ?>
            <tr class="edit" id="detail">
              <td class="text-center id" id="<?= $row['id']?>"> <?= $row['id']?> </td>
              <td class="text-center name"> <?= $row['name']?> </td>
              <td class="text-center email"> <?= $row['email']?> </td>
              <td class="text-center role"> <?= $row['role']?> </td>
              <td class="text-center date"> <?= $row['date']?> </td>
              <td class="text-center"><button class="btn btn-primary adminUpdateUser" data-target="#adminUpdateUser" data-toggle="modal" >Change</button></td>
              <td class="text-center"><button class="btn btn-danger adminDeleteUser" >Delete</button></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="panel-footer">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-8">
              </div>
              <div class="col-md-4">
              <p class="muted pull-right"><strong> © 2018 All rights reserved </strong></p>
            </div>
          </div>
        </div>
      </div>
    </div></div>
<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"><div class="row">
        <div class="panel panel-default widget">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">
                    Recent Comments</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <?php 
                        $all = listAllDoggosAndUsers($conn); 
                        while($each = mysqli_fetch_array($all)):
                    ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-xs-2 col-md-1 adminPanelDoggo">
                                <img src="<?=$each['photo']?>" class="rounded-circle img-responsive" alt="<?=$each['title']."&".$each['id']?>" /></div>
                            <div class="col-xs-10 col-md-11 kurcina">
                                <div>
                                    <div class="title-doggo">
                                        <?=$each['title']?>
                                    </div>
                                    <div class="mic-info">
                                        By: <b><?=$each['username']?></a></b> on <b><?=$each['date']?></b>
                                    </div>
                                </div>
                                <div class="comment-text">
                                    <?=$each['description']?>
                                </div>
                                <div class="action">
                                    <button type="button" class="btn btn-primary btn-xs adminEditDoggo" title="Edit">
                                        <span class="far fa-edit"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs adminDeleteDoggo" title="Delete">
                                        <span class="far fa-trash-alt"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endwhile ?>
                </ul>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">dsaaaaaaaaaaaa</div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
</div>
</div>


</div>

<!-- MODALS -->

<div class="modal adminUpdateUser" tabindex="-1" id="adminUpdateUser" role="dialog">
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
                <label for="adminUpdateUsename">Username</label>
                <input type="text" class="form-control" id="adminUpdateUsername" placeholder="Username">
                <span class="username error"></span>
            </div>
            <div class="form-group">
                <label for="adminUpdateEmail">Email</label>
                <input type="email" class="form-control" id="adminUpdateEmail" placeholder="Email">
                <span class="email error"></span>
            </div>
            <div class="form-group">
                <label for="adminUpdateRole">Role:</label>
                <select name="adminUpdateRole" id="adminUpdateRole" class="form-control">

                </select>
                <span class="role error"></span>
            </div>
            <input type="hidden" id="UserId">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnAdminUpdateUser">Update</button>
      </div>
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