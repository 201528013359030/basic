<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeavebillSerach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leavebill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'leaveType') ?>

    <?= $form->field($model, 'leaveStartTime') ?>

    <?= $form->field($model, 'leaveEndTime') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'applyTime') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'days') ?>

    <?php // echo $form->field($model, 'dep') ?>

    <?php // echo $form->field($model, 'spuser') ?>

    <?php // echo $form->field($model, 'tzuser') ?>

    <?php // echo $form->field($model, 'tongzhi') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'approvalPerson') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
