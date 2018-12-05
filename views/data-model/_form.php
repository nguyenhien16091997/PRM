<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\DataModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uploadFile')->fileInput([ 'required'=>'required'])->label('Choose file') ?>
    <?= $form->field($model, 'choseColumn')->dropDownList(['prompt'=>'Select Option'] ) ?>
    
    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
