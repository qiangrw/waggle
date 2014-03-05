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
    <label class="col-sm-2 control-label">vcode</label>
    <div class="col-sm-5">
      <input name="vcode" type="vcode" class="form-control">
    </div>
    <div class="col-sm-5">
    <img src="<?= site_url('vcode/generate_vcode') ?>" alt="读取失败"></img>
    </div>
    <p class="help-block text-danger"><?php echo form_error('vcode'); ?></p>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-lg btn-primary">Signup</button>
    </div>
  </div>
</form>
</div>