<?php
/* @var $this yii\web\View */
$this->title = 'Admin';
?>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin/news">&laquo; Back</a></p>
</div>

<div class="row">
<p>

<?php
use yii\widgets\ActiveForm;
use app\models\ImageUploadForm;

$imageUploadModel = new ImageUploadForm();
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <label>Name:</label> <br/>
    <input type="text" name="name" placeholder="name" value="<?= @$newsItem->name ?>"/> <br />

    <?= $form->field($imageUploadModel, 'imageFile')->fileInput() ?>

    <label>Short description:</label> <br/>

    <textarea name="description_short" rows="5" cols="30"><?= @$newsItem->description_short ?></textarea> <br />

    <label>Content:</label> <br/>
    <textarea name="content" rows="10" cols="70"><?= @$newsItem->content ?></textarea> <br />

    <label>Category:</label> <br/>
    <select name="category_id">
    

        <?php foreach ($categories as $category) : ?>

<?php 

$selected = "";
if ($newsItem->category_id == $category->id ) {
    $selected = 'selected="selected"';
}

?>

        <option value="<?= $category->id ?>" <?= $selected ?>><?= $category->name ?></option>

        <?php endforeach ?>
    </select>   <br/>

    <label>Active</label>

<?php 

$checked = "";
if ($newsItem->is_active ) {
    $checked = "checked";
}

?>

    <input type="checkbox" <?= $checked ?> name="is_active" /> <br />

    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <label>Date:</label> <br/>
    <input type="text" name="date" placeholder="date" value="<?= @$newsItem->date ?>"/> <br />

    <button>Submit</button>

<?php ActiveForm::end() ?>

</p>
</div>
