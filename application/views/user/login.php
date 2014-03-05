<div class="row">
<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputSid3" class="col-sm-2 control-label">Student ID</label>
    <div class="col-sm-10">
     <input name="sid" type="email" class="form-control" placeholder="Input your student ID">
    </div>
    <p class="help-block text-danger"><?php echo form_error('sid'); ?></p>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input name="password" type="password" class="form-control" placeholder="Input your password">
    </div>
    <p class="help-block text-danger"><?php echo form_error('password'); ?></p>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-lg btn-primary">Login</button>
    </div>
  </div>
</form>
</div>
