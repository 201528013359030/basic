<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Qingjiatiao */

$this->title = 'Create Qingjiatiao';
$this->params['breadcrumbs'][] = ['label' => 'Qingjiatiaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qingjiatiao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
