<div class="row">
<legend>Please Login</legend>
<form class="form-horizontal" role="form" method="post" action="<?= site_url('user/submit_login') ?>">
  <?php if(!isset($url)) $url='competition'; ?>
  <input type="hidden" name="url" value="<?= $url ?>" />
  <div class="form-group">
    <label for="inputSid3" class="col-sm-2 control-label">Student ID</label>
    <div class="col-sm-10">
    <input name="sid" type="text" class="form-control" placeholder="Input your student ID" value='<?= set_value('sid') ?>'>
    <p class="help-block text-danger"><?php echo form_error('sid'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input name="password" type="password" class="form-control" placeholder="Input your password">
      <p class="help-block text-danger"><?php echo form_error('password'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a href="mailto:qiangrw@gmail.com">Forget Password?</a>
      <br /> <br />
      <button type="submit" class="btn btn-lg btn-primary">Login</button>
    </div>
  </div>
</form>
</div>
