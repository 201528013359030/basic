<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport"
	content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表-详细</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile('../views/css/leave.css')?>
<?php $model = $dataDetail?>
</head>
<body>

	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">
	<?php //action=<?='"'."index.php?r=leavebill/saveapproval&id=".$model['id'].'"'?>
<!-- 		<form data-abide action="workflowAction_submitTaskByLeaveBillId.action?id=<s:property value="id" method="post"/> -->
			<form data-abide action="index.php?r=leavebill/saveapproval"
				method="post" />
			<input type="hidden" name="_csrf"
				value=<?=Yii::$app->request->getCsrfToken()?>> <input type="hidden"
				name="id" value=<?=$model['id']?>> <input type="hidden" name="uid"
				value=<?=$uid?>>
			<!--请假条内容部分-->
			<div class="row">

				<div class="row-tab">&nbsp;</div>

				<div class="content">

					<div class="conInfo">
						<p><?=Html::encode($model['spuser']) ?>,您好:<br>
							<br>我是<span class="fb"><?=Html::encode($model['username']) ?>-<?=Html::encode($model['dep']) ?></span>,<span
								class="fb"><?=Html::encode($model['reason']) ?></span>，需请<span
								class="fb"><?php if ($model['leaveType']==1){?>事假<?php }elseif ($model['leaveType']==2){?>病假<?php }elseif ($model['leaveType']==3){?>婚假<?php }elseif ($model['leaveType']==4){?>丧假<?php }elseif ($model['leaveType']==5){?>年假<?php }else{?>其他<?php }?></span>
							<span class="fb"><?=$model['days']?> 天</span>
						</p>
						<p>
							<mark class="fmak">
								<span> <!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($model['leaveStartTime'])?>
	  				</span> ~ <span> <!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($model['leaveEndTime'])?>
	  				</span>
							</mark>
						</p>
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
					        <?php  if($model['state']==1){?>
					          <textarea
											onpropertychange="this.style.height=this.scrollHeight + 'px'"
											oninput="this.style.height=this.scrollHeight + 'px'"
											placeholder="请输入您的批语" name="comment"></textarea>
					          <?php }else{?>
					          	<?php
														if ($taskList != null && count ( $taskList ) > 0) {
															foreach ( array_reverse ( $taskList ) as $task ) {
																// echo $task['assignee'];
																// echo $uid;
																if ($task ['assignee'] == $uid && $task ['name'] == "审批") {
																	$message = "";
																	if (count ( $comments = $task ['comments'] ) > 0) {
																		foreach ( $comments as $comment ) {
																			//echo substr($comment->message,strpos($comment->message,"意见"));
																		 	$start=strpos($comment->message,":")+1;
																			//echo 
																			$message= $message." ".substr($comment->message,$start);
																			//$message=
																			//$message=substr($comment->message,strstr($comment->message,"意见"));
																			//$message = $message . "		" . $comment->message;
																		}
																	}
																	?>
									<textarea onpropertychange="this.style.height=this.scrollHeight + 'px'"
											oninput="this.style.height=this.scrollHeight + 'px'"
											name="comment" disabled><?php echo $message;?></textarea>
					          	<?php
																	break;
																}
															}
															?>
					         
					          <?php } }?>
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
					<?php	
					if (count ( $comments = $task ['comments'] ) > 0) {
							foreach ( $comments as $comment ) {
								echo $comment->message;
							}
						}
						?>
<!-- 					<s:property value="fullMessage"/> -->
						</p>
						<p class="date">
								<?php date_default_timezone_set('PRC');  if($task['deleteReason']=='completed'){ echo date("Y-m-d H:i:s",strtotime($task['endTime']));}else {echo date("Y-m-d H:i:s",strtotime($task['startTime']));}?>
<!-- 					<s:date name="time" format="YYYY-MM-dd HH:mm"/> -->
						</p>
					</li>
					<!-- 				</s:iterator> -->
				<?php }?>
				<?php } ?>

				<li><span class="note"></span>
						<p>创建请假条</p>
						<p class="date">
							<span> <!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($model['applyTime'])?>
	  				</span>
						</p></li>
				</ul>

			</div>
			<!--end 跟踪流程-->

			<div class="row">
		<?php  if($model['state']==1){?>
	  		<div class="small-6 columns">
					<button type="submit" class="button expand" name="outcome"
						value="1">同意</button>
				</div>

				<div class="small-6 columns">
					<button type="submit" class="button secondary expand"
						name="outcome" value="0">拒绝</button>
				</div>
	  	<?php }?>
	  	</div>

			</form>
		</div>
	</div>
</body>
</html>