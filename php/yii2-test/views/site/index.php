<?php
/* @var $this yii\web\View */
$this->title = 'Title';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">

            <?php for ($i = 0; $i < 10; $i++) : ?>

            <div class="col-lg-4">
                <h2>Category header</h2>

                <p>Category description</p>
            </div>

            <?php endfor ?>

        </div>

        <div class="row">

            <?php for ($i = 0; $i < 10; $i++) : ?>

            <div class="col-lg-4">
                <h2>News header</h2>

                <p>[image here]</p>

                <p>News short description</p>

                <p>Publication date</p>

                <p><a class="btn btn-default" href="">Read on &raquo;</a></p>
            </div>

            <?php endfor ?>

        </div>
    </div>
</div>
