<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport"
	content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile('/basic/views/css/leave.css')?>

</head>
<body>

	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">

			<div class="pageEmpty">
				<i class="ficon icon-time"></i>
				<p>
	  		<?php
					switch ($result) {
						case '1' :
							echo '操作超时，请重新进入请假条';
							break;
						case '2' :
							echo '流程不存在';
							break;
						case '3' :
							echo '任务不存在';
							break;
						case '4' :
							echo '保存数据失败';
							break;
						case '5':
							echo '创建请假流程失败';
						case '6':
							echo '无此请假条';
						default :
							echo '出错了.....';
					}
					?>
	  		</p>
			</div>

		</div>
	</div>

</body>
</html>
