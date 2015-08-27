<?php
/* @var $this yii\web\View */
$this->title = 'News list';
?>

<div class="row">
    <a class="btn btn-default" href="?r=news/list">List all news</a>
    <a class="btn btn-default" href="?r=admin">Admin</a>
</div>

<div class="row">

    <?php foreach ($categories as $category) : ?>
    <div class="col-lg-4">

        <h2>
            <?= $category->name ?>
        </h2>

        <p>
            <?= $category->description ?>
        </p>

        <p><a class="btn btn-default" href="?r=news/list&catid=<?= $category->id ?>">List news &raquo;</a></p>
    </div>

    <?php endforeach ?>

</div>

<div class="row">

    <?php foreach ($news as $newsItem) : ?>

    <div class="col-lg-4">

        <h2>
            <?= $newsItem->name ?>
        </h2>

        <p>
        <img src="<?= $newsItem->image ?>" /></p>

        <p>
            <?= $newsItem->description_short ?>
        </p>

        <p>
            <?= $newsItem->date?>
        </p>

        <p><a class="btn btn-default" href="?r=news/show&id=<?= $newsItem->id ?>">Read on &raquo;</a></p>
    </div>

    <?php endforeach ?>
</div>
