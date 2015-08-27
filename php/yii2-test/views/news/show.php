<?php
/* @var $this yii\web\View */
$this->title = 'News show';
?>

<div class="row">
    <p><a class="btn btn-default" href="?r=news/list">&laquo; Back</a></p>
</div>

<div class="row">

    <div class="col-lg-4">

        <h2>
            <?= $newsItem->name ?>
        </h2>

        <p>
            <?= $newsItem->content ?>
        </p>

        <p>
            <?= $newsItem->date?>
        </p>

    </div>
</div>
