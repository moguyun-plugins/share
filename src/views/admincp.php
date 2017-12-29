<?php

use moguyun\plugins\share\models\Share;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $model Share */
?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<?= $form->field($model, 'title')->textInput(['placeholder' => '标题']) ?>
<?= $form->field($model, 'description')->textInput(['placeholder' => '描述']) ?>
<?= $form->field($model, 'url')->textInput(['placeholder' => '链接']) ?>
<div class="form-group field-share-image">
    <label class="control-label col-sm-3" for="share-image">图标预览</label>
    <div class="col-sm-6">
        <p type="raw" class="form-control-static"><?= Html::img($model->image); ?>
        </p>
        <div class="help-block help-block-error "></div>
    </div>
</div>
<?= $form->field($model, 'imageFile', [
    'inputTemplate' => '<div class="input-group">{input}<span id="share-image-upload" class="input-group-addon">选择图片</span></div>',
])->fileInput(['placeholder' => '图片', 'class' => 'form-control']); ?>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<<JS
$('#share-image-upload').click(function(){
  $(this).prev().click();
});
JS;
$this->registerJs(View::POS_END);
?>
