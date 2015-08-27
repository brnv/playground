<?php
/* @var $this yii\web\View */
$this->title = 'Admin';
?>

<div class="row">
    <p><a class="btn btn-default" href="?r=admin/categories">&laquo; Back</a></p>
</div>

<div class="row">
<p>

    <form action="" method="POST">

    <label>Name:</label> <br/>
    <input type="text" name="name" placeholder="name" value="<?= @$categoryItem->name ?>"/> <br />

    <label>Description:</label> <br/>

    <textarea name="description" rows="10" cols="70"><?= @$categoryItem->description  ?></textarea> <br />

    <label>Parent category:</label> <br/>

    <select name="parent_id">

        <option value="0" selected="selected">none</option>

        <?php foreach ($categories as $category) : ?>

<?php 

if ($categoryItem->id == $category->id ) {
    continue;
}

?>


<?php 

$selected = "";
if ($categoryItem->parent_id == $category->id ) {
    $selected = 'selected="selected"';
}

?>

        <option value="<?= $category->id ?>" <?= $selected ?>><?= $category->name ?></option>

        <?php endforeach ?>
    </select>   <br/>


    <label>Active</label>

<?php 

$checked = "";
if ($categoryItem->is_active ) {
    $checked = "checked";
}

?>

    <input type="checkbox" <?= $checked ?> name="is_active" /> <br />

    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <input type="submit" />

    </form>

</p>
</div>
