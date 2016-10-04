<!DOCTYPE html>
<html>
<?php use yii\helpers\Html;?>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表-详细</title>

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
					<p>您好，我是<span class="fb">王大伟 - 研发中心</span>,<span class="fb">明天同学结婚这里放的是请假事由</span>，需请<span class="fb">事假</span> <span class="fb">3天</span>
					</p>
					<p><mark class="fmak">2015-09-11 8:00 ~ 2015-09-11 8:00</mark></p>
					<p>这里放的是工作安排以及后面的任务谁来完成。</p>
					<p>请您审批</p>
				</div>
				
				<!--这里是审批人提的意见-->
				<div class="conInfo">
					<form data-abide>
						<div class="small-11">
					      <div class="row">
					        <div class="small-3 columns">
					          <label for="right-label" class="right inline">意见</label>
					        </div>
					        <div class="small-9 columns">
					          <textarea onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入您的批语"></textarea>
					        </div>
					      </div>
					    </div>
					</form>
				</div>
				<!--end 这里是审批人提的意见-->
				
			</div>
			
		</div>
		<!--end 请假条内容部分-->
		
		<div class="row-tab">&nbsp;</div>
		
		<!--跟踪流程-->
		<div class="row">
			
			<h3 class="freightTit">流程跟踪</h3>
			<ul class="freightUl">			
				<li class="mcurrent">
					<span class="note"></span>				
					<p>孙建伟&nbsp;已同意&nbsp;这里放的是工作安排以及后面的任务谁来完成</p>
					<p class="date">2015-08-01 09:10</p>
				</li>
				<li>
					<span class="note"></span>				
					<p>创建请假条</p>
					<p class="date">2015-08-01 09:10</p>
				</li>
				
			</ul>	
			
		</div>
		<!--end 跟踪流程-->
		
		<div class="row">
	  		<div class="small-6 columns">	  			
	  			<button type="submit" class="button disabled expand">同意</button>
	  		</div>
	  		
	  		<div class="small-6 columns">
	  			<button type="reset" class="button secondary expand">拒绝</button>
	  		</div>
	  	</div>
		
		
	</div>
</div>

</body>
</html>
