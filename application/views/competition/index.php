<div class="row">
    <div class="col-md-12">
    <table class="table table-hover table-bordered">
    <tr>
        <td>编号</td>
        <td>名称</td>
        <td>截止时间</td>
        <td>提交地址</td>
    </tr>
    <?php foreach($competitions as $competition): ?>
    <tr>
        <td><?= $competition->id ?></td>
        <td><?= $competition->name ?></td>
        <td><?= date('Y-m-d H:i',$competition->deadline) ?></td>
        <td><a href="<?= site_url('competition/commit/'.$competition->id) ?>">前往提交</a></td>
    </tr>
    <?php endforeach; ?>
    </table>

    </div>
</div>
