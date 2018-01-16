<div class="row justify-content-md-center">
    <div class="col-md-6 align-self-center">
        <form>
            <div class="form-group">
                <label for="tbEmail">Email address</label>
                <input type="email" class="form-control" id="tbEmail" aria-describedby="emailHelp" placeholder="Enter email">
                <span class="email error"></span>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="tbUsername">Username</label>
                <input type="text" class="form-control" id="tbUsername" placeholder="Username">
                <span class="username error"></span>
            </div>
            <div class="form-group">
                <label for="tbPassword">Password</label>
                <input type="password" class="form-control" id="tbPassword" placeholder="Password">
                <span class="password error"></span>
            </div>
            <div class="form-group">
                <label for="tbPasswordRetype">Password</label>
                <input type="password" class="form-control" id="tbPasswordRetype" placeholder="Retype password">
                <span class="retype error"></span>
            </div>
            <!-- <div class="form-group">
                <label for="avatar">Choose Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar" placeholder="Choose Avatar">
                <span class="avatar error"></span>
            </div> -->
            <button type="button" class="btn btn-primary" name="btnSignUp" id="btnSignUp">Sign Up</button>
        </form>
    </div>
</div>

<div class="modal fade modalSuccessSignIn" id="modalSuccessSignIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bravo!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
            Successfully registred!
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFailedSignIn" id="modalFailedSignIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Error!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
            An error occured!
        </div>
      </div>
    </div>
  </div>
</div>