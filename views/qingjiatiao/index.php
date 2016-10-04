<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QingjiatiaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Qingjiatiaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qingjiatiao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


     <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'Id',
           'name',
           'type',
           'startDate',
           'endDate',
            'approveId',
            'informId',
            'reason:ntext',
            'hand:ntext',
           ['class' => 'yii\grid\ActionColumn'],
       ],
   ]); ?>

   <p>
        <?= Html::a('创建请假条', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>


