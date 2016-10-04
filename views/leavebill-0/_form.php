<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leavebill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leavebill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leaveType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leaveStartTime')->textInput() ?>

    <?= $form->field($model, 'leaveEndTime')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'applyTime')->textInput() ?>

    <?= $form->field($model, 'state')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'days')->textInput() ?>

    <?= $form->field($model, 'dep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spuser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tzuser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tongzhi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'approvalPerson')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
