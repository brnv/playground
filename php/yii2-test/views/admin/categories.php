<?php
/* @var $this yii\web\View */
$this->title = 'Admin';
?>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin">&laquo; Back</a></p>
</div>

<div class="row">
<p>
    <?php foreach ($categories as $category) : ?>

    <div class="col-lg-4">

    <h2>
        <?= $category->name ?>
    </h2>
        <p><a class="btn btn-default" href="?r=admin/editcategory&id=<?= $category->id ?>">Edit &raquo;</a></p>
    </div>

    <?php endforeach ?>
</p>
</div>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin/addcategory">Add new &raquo;</a></p>
</div>
