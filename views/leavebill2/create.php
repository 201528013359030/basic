<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Leavebill */

$this->title = 'Create Leavebill';
$this->params['breadcrumbs'][] = ['label' => 'Leavebills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leavebill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
