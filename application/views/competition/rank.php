<legend><?= $competition->name ?></legend>
<div class="row">
    <div class="col-md-12">
    <table class="table table-hover table-bordered">
    <tr>
        <td>Rank</td>
        <td>Student ID</td>
        <td>Runtag</td>
        <td>Score</td>
        <td>Time</td>
    </tr>
    <?php $i = 1; ?>
    <?php foreach($commits as $commit): ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $commit->sid ?></td>
        <td><?= $commit->runtag ?></td>
        <td><?= $commit->score ?></td>
        <td><?= date('Y-m-d H:i',$commit->create_time) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

    </div>
</div>
