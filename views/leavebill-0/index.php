<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LeavebillSerach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leavebills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leavebill-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Leavebill', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'leaveType',
            'leaveStartTime',
            'leaveEndTime',
            // 'reason',
            // 'remark',
            // 'applyTime',
            // 'state',
            // 'username',
            // 'days',
            // 'dep',
            // 'spuser',
            // 'tzuser',
            // 'tongzhi',
            // 'token',
            // 'approvalPerson',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
