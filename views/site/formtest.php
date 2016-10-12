
<?php use yii\helpers\Url;?>
<?php use yii\helpers\Html;?>


		<form action=<?= Url::to(['site/test'])?> method="post" >
			<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
			<input type="text" name="name">
			<input type="submit" value="submit" name="submit">
		</form>