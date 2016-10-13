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
<?php $data = $dataDetail ?>
</head>
<body>

<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
		<!--请假条内容部分-->
		<div class="row">
			
			<div class="row-tab">&nbsp;</div>
			
			<div class="content">
				
				<div class="conInfo">
					<p><?=Html::encode($data['spuser']) ?>,您好:<br><br>我是<span class="fb"><?=Html::encode($data['username']) ?>-<?=Html::encode($data['dep']) ?></span>,<span class="fb"><?=Html::encode($data['reason']) ?></span>，需请<span class="fb"><?php if ($data['leaveType']==1){?>事假<?php }elseif ($data['leaveType']==2){?>病假<?php }elseif ($data['leaveType']==3){?>婚假<?php }elseif ($data['leaveType']==4){?>丧假<?php }elseif ($data['leaveType']==5){?>年假<?php }else{?>其他<?php }?></span> <span class="fb"><?=$data['days']?> <!--天  --></span>
					</p>
					<p><mark class="fmak"><span><?=Html::encode($data['leaveStartTime'])?></span>~<span><?=Html::encode($data['leaveEndTime']) ?></span></mark></p>
					<p><?=Html::encode($data['remark']) ?></p>
					<p>请您审批</p>
				</div>
				
				
			</div>
			
		</div>
		<!--end 请假条内容部分-->
		
		<div class="row-tab">&nbsp;</div>
		
		<!--跟踪流程-->
		<div class="row">
			
			<h3 class="freightTit">流程跟踪</h3>
			<ul class="freightUl">	
<!-- 				<s:if test="#list!=null && #list.size()>0"> -->
				<?php if(($taskList!=null)&&count($taskList)>0){?>
				<?php //if(($data!=null)&&(count($data)>0)){?>
				<?php foreach (array_reverse($taskList) as $task){?>
<!-- 				<s:iterator value="#list"> -->
					<?php if($task['deleteReason']=='completed'){?>
					<li class="mcurrent">
					<?php }else{?>
					<li>
					<?php }?>
					<span class="note">
						<?php ?>
					</span>				
					<p>
					<?=$task['name'].'<br/>'?>
					<?php if(count($comments=$task['comments'])>0){
						foreach ($comments as $comment){
							echo $comment->message;
						}
					}?>
<!-- 					<s:property value="fullMessage"/> -->
					</p>
					<p class="date">
								<?php if($task['deleteReason']=='completed'){ echo date("Y-m-d H:i:s",strtotime($task['endTime']));}else {echo date("Y-m-d H:i:s",strtotime($task['startTime']));}?>
<!-- 					<s:date name="time" format="YYYY-MM-dd HH:mm"/> -->
					</p>
					</li>
<!-- 				</s:iterator> -->
				<?php }?>
				<?php } ?>
			
				<li>
					<span class="note"></span>				
					<p>创建请假条</p>
					<p class="date">
					<span>
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($data['applyTime']) ?>
	  				</span>
					</p>
				</li>
			</ul>	
			
		</div>
		<!--end 跟踪流程-->
		<?php  if($data['state']==3){?>
			<div class="row">
	  		<div class="small-6 columns">	  			
	  			<button type="button" class="button disabled expand" name="outcome" onclick="window.location.href='index.php?r=leavebill/update&id=<?php echo $data['id'];?>&uid=<?php echo $uid;?>'">再次提交</button>
	  		</div>
	  		
	  		<div class="small-6 columns">
	  			<button type="button" class="button secondary expand" name="outcome"  onclick="window.location.href='index.php?r=leavebill/giveup&id=<?php echo $data['id']?>&uid=<?php echo $uid?>&outcome=3'">放弃</button>
	  		</div>
	  	</div>
	  	<?php }?>
	</div>
</div>
</body>
</html>