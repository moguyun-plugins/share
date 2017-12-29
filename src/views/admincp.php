<?php

use moguyun\plugins\share\models\Share;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $model Share */

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title')->textInput(['placeholder' => '标题']) ?>
<?= $form->field($model, 'description')->textInput(['placeholder' => '描述']) ?>
<?= $form->field($model, 'url')->textInput(['placeholder' => '链接']) ?>
<?= $form->field($model, 'imageFile')->fileInput(['placeholder' => '图片']) ?>
<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
