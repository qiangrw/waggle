<legend>Competition List</legend>
<div class="row">
    <div class="col-md-12">
    <table class="table table-hover table-bordered">
    <tr>
        <td>ID</td>
        <td>Title</td>
        <td>Deadline</td>
        <td>Operations</td>
    </tr>
    <?php foreach($competitions as $competition): ?>
    <tr>
        <td><?= $competition->id ?></td>
        <td><?= $competition->name ?></td>
        <td><?= date('Y-m-d H:i',$competition->deadline) ?></td>
        <td>
            <a href="<?= site_url('competition/commit/'.$competition->id) ?>">Commit</a> | 
            <a href="<?= site_url('competition/rank/'.$competition->id) ?>">View Rank</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>

    </div>
</div>
