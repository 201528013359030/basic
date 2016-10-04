<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile('/basic/views/css/leave.css')?>

</head>
<body>
	
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
	  	<div class="row">
	  		<!--未处理状态-->
	  		<div class="row-tab">进行中</div>
	  		<div class="list-group">
	  			<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_shi">事</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">1天</span>
	  					<span class="fr status"><em class="fc_sucess">审批中</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">&nbsp;</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  			<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_marry">婚</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">1天</span>
	  					<span class="fr status"><em class="fc_error">拒绝</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">&nbsp;</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  			
	  		</div>
	  		
	  		<div class="row-tab">待处理的审批</div>
	  		<div class="list-group">
	  			<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_ill">病</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">方连媛</span>
	  					<span class="fr status"><em class="fc_sucess">待审批</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">1 天</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  		</div>
	  		<!--end 未处理状态-->
	  		
	  		<div class="row-tab">&nbsp;</div>
	  		
	  		<div class="list-group">
	  			
	  			<h3 class="listTit">本月</h3>
	  			
	  			<!--a为要循环的内容包含 图标 状态请假日期 和请假人等-->
	  			<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_die">丧</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">1天</span>
	  					<span class="fr status"><em class="fc_undo">同意/放弃</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">&nbsp;</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  			
		  		<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_year">年</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">方连媛</span>
	  					<span class="fr status"><em class="fc_error">已拒绝</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">1 天</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  			<a href="javascript:void(0);" class="listIteam">
	  				<i class="icon ic_other">其</i>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">方连媛</span>
	  					<span class="fr status"><em class="fc_undo">已同意/已放弃</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">1 天</span>
	  					<span class="fr date">2015-09-11 16:00</span>
	  				</p>
	  			</a>
	  		</div>	  		
	  	</div>
	  	
	  	<div class="row">
	  		<div class="small-12 columns">
	  			<a href="javascript:void(0);" class="button expand">
	  				查看更多假条
	  			</a>
	  		</div>
	  	</div>
	  	
	</div>
</div>
	
</body>
</html>
