<?php

/** @var yii\web\View $this */
/** @var frontend\models\UploadForm $model */

use yii\bootstrap5\ActiveForm;

?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'myFile')->fileInput() ?>

        <button class="btn btn-success">Upload</button>

        <?php ActiveForm::end() ?>
    </div>
</div>
