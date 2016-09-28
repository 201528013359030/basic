<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\base\Action;

?>


<?php $form = ActiveForm::begin();?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'email')?>

<div calss="form-group">
<?=Html::submitButton('submit',['class'=>'btn btn-primary'])?></div>
<?php  ActiveForm::end();?>
<li><a href="/basic/web/index.php?r=site%2Findex">创建请假条</a></li>