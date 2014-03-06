<legend><?= $competition->name ?> Commit</legend>
<div class="row">
    <div class="col-md-12">
    <p> <center>
        <?= $sid ?>, Left Commit Count: <strong><?= $count ?> </strong>
    </center> </p>
    </div>
</div>

<br />
<form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="<?= site_url('competition/submit_commit/'.$cid) ?>">
  <div class="form-group">
    <label for="inputSid3" class="col-sm-2 control-label">* Runtag</label>
    <div class="col-sm-10">
    <input name="runtag" type="text" class="form-control" value='<?set_value('runtag')?>' placeholder="e.g. RUN1">
    <p class="help-block text-danger"><?php echo form_error('runtag'); ?></p>
    </div>
  </div>     
  <div class="form-group">
    <label for="inputSid3" class="col-sm-2 control-label">* Result File</label>
    <div class="col-sm-10">
    <input name="userfile" type="file">
    <p class="help-block text-info">upload result file, *.txt, less than 10MB </p>
    <p class="help-block text-danger"><?php echo form_error('file'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="inputSid3" class="col-sm-2 control-label">Message</label>
    <div class="col-sm-10">
    <input name="message" type="text" class="form-control" value='<?set_value('message')?>' placeholder="Optional">
    <p class="help-block text-danger"><?php echo form_error('message'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-lg btn-primary">Submit</button>
    </div>
  </div>
</form>

