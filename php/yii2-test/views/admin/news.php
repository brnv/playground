<?php
/* @var $this yii\web\View */
$this->title = 'Admin';
?>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin">&laquo; Back</a></p>
</div>

<div class="row">
<p>
    <?php foreach ($news as $newsItem ) : ?>

    <div class="col-lg-4">

    <h2>
        <?= $newsItem->name ?>
    </h2>
        <p><a class="btn btn-default" href="?r=admin/editnews&id=<?= $newsItem->id ?>">Edit &raquo;</a></p>
    </div>

    <?php endforeach ?>
</p>
</div>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin/addnews">Add new &raquo;</a></p>
</div>
