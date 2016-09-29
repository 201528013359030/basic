<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表-详细</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile('../views/css/leave.css')?>
</head>
<body>

<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<form data-abide action="workflowAction_submitTaskByLeaveBillId.action?id=<s:property value="id" method="post"/>
		<!--请假条内容部分-->
<div class="row">
			
			<div class="row-tab">&nbsp;</div>
			
			<div class="content">
				
				<div class="conInfo">
					<p><?=Html::encode($model['spuser']) ?>,您好:<br><br>我是<span class="fb"><?=Html::encode($model['username']) ?>-<?=Html::encode($model['dep']) ?></span>,<span class="fb"><?=Html::encode($model['reason']) ?></span>，需请<span class="fb"><?php if ($model['leaveType']==1){?>事假<?php }elseif ($model['leaveType']==2){?>病假<?php }elseif ($model['leaveType']==3){?>婚假<?php }elseif ($model['leaveType']==4){?>丧假<?php }elseif ($model['leaveType']==5){?>年假<?php }else{?>其他<?php }?></span> <span class="fb"><?php  $model=['days']?> 天</span>
					</p>
					<p><mark class="fmak">
					<span class="fr date">
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($model['leaveStartTime']) ?>
	  				</span>
					~ 
					<span class="fr date">
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($model['leaveEndTime']) ?>
	  				</span>
					</mark></p>
					<p><?=Html::encode($model['remark']) ?></p>
					<p>请您审批</p>
				</div>
				<!--这里是审批人提的意见-->
				<s:if test="#bill.state==1">
				<div class="conInfo">
					
						<div class="small-11">
					      <div class="row">
					        <div class="small-3 columns">
					          <label for="right-label" class="right inline">意见</label>
					        </div>
					        <div class="small-9 columns">
					          <textarea onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入您的批语" name="comment"></textarea>
					        </div>
					      </div>
					    </div>
					
				</div>
				</s:if>
				<!--end 这里是审批人提的意见-->
				
			</div>
			
		</div>
		<!--end 请假条内容部分-->
		
		<div class="row-tab">&nbsp;</div>
		
		<!--跟踪流程-->
		<div class="row">
			
			<h3 class="freightTit">流程跟踪</h3>
			<ul class="freightUl">	
				<s:if test="#list!=null && #list.size()>0">
				<s:iterator value="#list">
					<li class="mcurrent">
					<span class="note"></span>				
					<p><s:property value="fullMessage"/></p>
					<p class="date"><s:date name="time" format="YYYY-MM-dd HH:mm"/></p>
					</li>
				</s:iterator>
				</s:if>
			
				<li>
					<span class="note"></span>				
					<p>创建请假条</p>
					<p class="date"><s:date name="#bill.applyTime" format="YYYY-MM-dd HH:mm"/></p>
				</li>
			</ul>	
			
		</div>
		<!--end 跟踪流程-->
		
		<div class="row">
		<?php  if($model['state']==1){?>
	  		<div class="small-6 columns">	  			
	  			<button type="submit" class="button expand" name="outcome" value="1">同意</button>
	  		</div>
	  		
	  		<div class="small-6 columns">
	  			<button type="submit" class="button secondary expand" name="outcome" value="0">拒绝</button>
	  		</div>
	  	<?php }?>
	  	</div>
		
		</form>
	</div>
</div>
</body>
</html>