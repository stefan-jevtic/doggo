<div class="row justify-content-md-center">
    <div class="col-md-6 align-self-center">
        <form>
            <div class="form-group">
                <label for="tbUsername">Username</label>
                <input type="text" class="form-control" id="tbUsernameLogin" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="tbPassword">Password</label>
                <input type="password" class="form-control" id="tbPasswordLogin" placeholder="Password">
            </div>
            <button type="button" class="btn btn-primary" name="btnLogin" id="btnLogin">Log in</button>
        </form>
        <span class="required-fields"></span>
    </div>
</div>

<div class="modal fade modalFailedLogin" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Not bravo!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            Login failed!
        </div>
      </div>
    </div>
  </div>
</div>