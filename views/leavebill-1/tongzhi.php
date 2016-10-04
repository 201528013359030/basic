
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>通知</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile('/basic/views/css/leave.css')?>
</head>
<body>
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
		<!--请假条内容部分-->
		<div class="row">
			
			<div class="row-tab">&nbsp;</div>
			
			<div class="content">
				
				<div class="conInfo">
					<p>您好，我是<span class="fb">某某人</span>,需请假===天</span>
					</p>
					<p><mark class="fmak">startdate ~ enddate</mark></p>
					<p>状态</p>
					<br>
					<br>
					<span class="send_time">申请时间 </span>&nbsp;<span>某某人 发送</span>
				</div>
				
				
			</div>
			
		</div>
		<!--end 请假条内容部分-->
		
		<div class="row-tab">&nbsp;</div>
		
		<!--跟踪流程-->
		<!--end 跟踪流程-->
		
	</div>
</div>
</body>
</html>