<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表</title>
<?php use yii\helpers\Html;
?>
 <?=Html::cssFile("../views/css/leave.css")?>


</head>
<body>
<?php
//print_r( $dataDisagree);
?>

<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">

	  	<div class="row">
	  	<div class="row-button">
	  			  <?= Html::tag('a', Html::encode("创建请假条"), ['href'=>'index.php?r=leavebill/create&uid='.$uid]) ?>
<!-- 	  			<a href="leaveBillAction_input.action">创建请假条 </a> -->
	  	</div>
	  		<!--未处理状态-->

<!-- 	  		<s:if test="#lb_list!=null && #lb_list.size()>0"> -->
	  		<?php if(($dataDisagree!=null)&&(count($dataDisagree)>0)){?>
	  		<div class="row-tab">进行中</div>
	  		<div class="list-group">
	  		 <?php foreach ($dataDisagree as $disagree){?>
<!-- 	  			<s:iterator value="#lb_list"> -->
	  			<!-- detail -->
<!-- 	  			<a href="leaveBillAction_input.action">创建请假条 </a> -->
<!-- 	  			<a href="leaveBillAction_viewTask.action?id=<s:property value="id"/>" class="listIteam"> -->
<!-- 				<a href="index.php?r=leavebill/detail&uid=".$uid class="listIteam" > -->
<?php //echo 'index.php?r=leavebill/content&uid='.$uid.'&id='.$disagree['id']?>
					<?=Html::beginTag('a',['class'=>'listIteam','uid'=>$uid,'href'=>'index.php?r=leavebill/content&uid='.$uid.'&id='.$disagree['id']])?>

	  			<?php if($disagree["leaveType"]==1){?>
<!-- 	  				<s:if test="leaveType==1"> -->
	  					<i class="icon ic_shi">事</i>
<!-- 	  				</s:if> -->
				<?php }elseif ($disagree['leaveType']==2){?>
<!-- 	  				<s:elseif test="leaveType==2"> -->
	  					<i class="icon ic_ill">病</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($disagree['leaveType']==3){?>
<!-- 	  				<s:elseif test="leaveType==3"> -->
	  					<i class="icon ic_marry">婚</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($disagree['leaveType']==4){?>
<!-- 	  				<s:elseif test="leaveType==4"> -->
	  					<i class="icon ic_die">丧</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($disagree['leaveType']==5){?>
<!-- 	  				<s:elseif test="leaveType==5"> -->
	  					<i class="icon ic_year">年</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($disagree['leaveType']==6){?>
<!-- 	  				<s:else> -->
	  					<i class="icon ic_other">其</i>
<!-- 	  				</s:else> -->
	  				<?php }?>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
<!-- 	  					<s:property value="day"/> -->
						<?= Html::encode($disagree['days']) ?>
	  					天</span>
	  					<span class="fr status">
<!-- 	  						<s:if test="state==1"> -->
						<?php if($disagree['state']==1){?>
	  							<em class="fc_sucess">审批中</em>
<!-- 	  						</s:if> -->
						<?php }elseif ($disagree['state']==2){?>
<!-- 	  						<s:elseif test="state==2"> -->
	  							<em class="fc_sucess">同意</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($disagree['state']==3){?>
<!-- 	  						<s:elseif test="state==3"> -->
	  							<em class="fc_error">拒绝</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($disagree['state']==4){?>
<!-- 	  						<s:else> -->
	  							<em class="fc_sucess">放弃</em>
<!-- 	  						</s:else> -->
						<?php }?>
	  					</span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl summary textCut">
<!-- 	  					<s:property value="reason"/> -->
							<?=Html::encode($disagree['reason']) ?>
	  					</span>
	  					<span class="fr date">
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
							<?=Html::encode($disagree['applyTime']) ?>
	  					</span>
	  				</p>
<!-- 	  				</a> -->
						<?=Html::endTag('a')?>
	  			</s:iterator>
	  			<?php }?>
	  			</div>
	  		</s:if>
	  		<?php }?>



<!-- 	  		<s:if test="#sp_list!=null && #sp_list.size()>0"> -->
			<?php if(($dataDisapproval !=null)&&(count($dataDisapproval)>0)){?>
	  		<div class="row-tab">待处理的审批</div>
	  		<div class="list-group">
<!-- 	  			<s:iterator value="#sp_list"> -->
					<?php foreach ($dataDisapproval as $disapproval){?>
<!-- 	  				<a href="leaveBillAction_viewTaskSp.action?id=<s:property value="id"/>" class="listIteam"> -->
<!-- 					<a href="" class="listIteam" > -->
						<?=Html::beginTag('a',['class'=>'listIteam','uid'=>$uid,'href'=>'index.php?r=leavebill/contentsp&uid='.$uid.'&id='.$disapproval['id']])?>
					<?php if($disapproval['leaveType']==1){?>
<!-- 	  				<s:if test="leaveType==1"> -->
	  					<i class="icon ic_shi">事</i>
<!-- 	  				</s:if> -->
					<?php }elseif ($disapproval['leaveType']==2){?>
<!-- 	  				<s:elseif test="leaveType==2"> -->
	  					<i class="icon ic_ill">病</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($disapproval['leaveType']==3){?>
<!-- 	  				<s:elseif test="leaveType==3"> -->
	  					<i class="icon ic_marry">婚</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($disapproval['leaveType']==4){ ?>
<!-- 	  				<s:elseif test="leaveType==4"> -->
	  					<i class="icon ic_die">丧</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($disapproval['leaveType']==5){?>
<!-- 	  				<s:elseif test="leaveType==5"> -->
	  					<i class="icon ic_year">年</i>
<!-- 	  				</s:elseif> -->
				<?php }elseif ($disapproval['leaveType']==6){?>
<!-- 	  				<s:else> -->
	  					<i class="icon ic_other">其</i>
<!-- 	  				</s:else> -->
				<?php }?>
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
<!-- 	  					<s:property value="username"/> -->
			<?=Html::encode($disapproval['username']) ?>
	  					</span>
	  					<span class="fr status"><em class="fc_sucess">待审批</em></span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">
<!-- 	  					<s:property value="day"/> -->
					<?=Html::encode($disapproval['days']) ?>
	  					天</span>
	  					<span class="fr date">
<!-- 	  					<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
								<?=Html::encode($disapproval['applyTime']) ?>
	  					</span>
	  				</p>
	  				<?=Html::endTag('a')?>
<!-- 	  			</a> -->
	  				<?php }?>
<!-- 	  			</s:iterator> -->
	  			</div>
<!-- 	  		</s:if> -->
	  			<?php }?>

	  		<!--end 未处理状态-->

	  		<div class="row-tab">&nbsp;</div>

	  		<div class="list-group">
<!-- 	  			<s:if test="#list1!=null && #list1.size()>0"> -->
				<?php if(($dataAgree!=null)&&(count($dataAgree)>0)){?>
	  			<h3 class="listTit">我的假条</h3>
<!-- 	  				<s:iterator value="#list1"> -->
						<?php foreach ($dataAgree as $agree){?>
	  					<!--a为要循环的内容包含 图标 状态请假日期 和请假人等-->
<!-- 	  			<a href="leaveBillAction_viewTask.action?id=<s:property value="id"/>" class="listIteam"> -->
<!-- 					<a href=""  class="listIteam"> -->
						<?=Html::beginTag('a',['class'=>'listIteam','uid'=>$uid,'href'=>'index.php?r=leavebill/content&uid='.$uid.'&id='.$agree['id']])?>
					<?php if($agree['leaveType']==1){?>
<!-- 	  				<s:if test="leaveType==1"> -->
	  					<i class="icon ic_shi">事</i>
<!-- 	  				</s:if> -->
					<?php }elseif ($agree['leaveType']==2){?>
<!-- 	  				<s:elseif test="leaveType==2"> -->
	  					<i class="icon ic_ill">病</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($agree['leaveType']==3){?>
<!-- 	  				<s:elseif test="leaveType==3"> -->
	  					<i class="icon ic_marry">婚</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($agree['leaveType']==4){ ?>
<!-- 	  				<s:elseif test="leaveType==4"> -->
	  					<i class="icon ic_die">丧</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($agree['leaveType']==5){?>
<!-- 	  				<s:elseif test="leaveType==5"> -->
	  					<i class="icon ic_year">年</i>
<!-- 	  				</s:elseif> -->
				<?php }elseif ($agree['leaveType']==6){?>
<!-- 	  				<s:else> -->
	  					<i class="icon ic_other">其</i>
<!-- 	  				</s:else> -->
				<?php }?>

	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
	  							<?=Html::encode($agree['days']) ?>
<!-- 	  						<s:property value="day"/> -->
					天</span>
	  					<span class="fr status">
	  					<?php if($agree['state']==1){?>
<!-- 	  						<s:if test="state==1"> -->
	  							<em class="fc_sucess">审批中</em>
<!-- 	  						</s:if> -->
							<?php }elseif ($agree['state']==2){?>
<!-- 	  						<s:elseif test="state==2"> -->
	  							<em class="fc_undo">同意</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif ($agree['state']==3){?>
<!-- 	  						<s:elseif test="state==3"> -->
	  							<em class="fc_error">拒绝</em>
<!-- 	  						</s:elseif> -->
					<?php }elseif ($agree['state']==4){?>
<!-- 	  						<s:else> -->
	  							<em class="fc_undo">放弃</em>
<!-- 	  						</s:else> -->
					<?php }?>
	  					</span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl summary textCut">
<!-- 	  								<s:property value="reason"/> -->
	  							 	<?=Html::encode($agree['reason']) ?>
	  					</span>
	  					<span class="fr date">
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
									<?=Html::encode($agree['applyTime']) ?>
	  					</span>
	  				</p>
<!-- 	  				</a> -->
								<?=Html::endTag('a')?>
<!-- 	  				</s:iterator> -->
					<?php }?>
<!-- 	  			</s:if> -->
				<?php }?>
<!-- 	  			<s:if test="#list2!=null && #list2.size()>0"> -->
				<?php if(($dataApproval!=null)&&(count($dataApproval)>0)){?>
	  			<h3 class="listTit">我的审批</h3>
	  				<?php foreach ($dataApproval as $approval){?>
<!-- 	  				<s:iterator value="#list2"> -->
<!-- 	  					<a href="leaveBillAction_viewTaskSp.action?id=<s:property value="id"/>" class="listIteam"> -->
<!-- 							<a href=""  class="listIteam"> -->
								<?=Html::beginTag('a',['class'=>'listIteam','uid'=>$uid,'href'=>'index.php?r=leavebill/contentsp&uid='.$uid.'&id='.$approval['id']])?>
					<?php if($approval['leaveType']==1){?>
<!-- 	  				<s:if test="leaveType==1"> -->
	  					<i class="icon ic_shi">事</i>
<!-- 	  				</s:if> -->
					<?php }elseif ($approval['leaveType']==2){?>
<!-- 	  				<s:elseif test="leaveType==2"> -->
	  					<i class="icon ic_ill">病</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($approval['leaveType']==3){?>
<!-- 	  				<s:elseif test="leaveType==3"> -->
	  					<i class="icon ic_marry">婚</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($approval['leaveType']==4){ ?>
<!-- 	  				<s:elseif test="leaveType==4"> -->
	  					<i class="icon ic_die">丧</i>
<!-- 	  				</s:elseif> -->
					<?php }elseif ($approval['leaveType']==5){?>
<!-- 	  				<s:elseif test="leaveType==5"> -->
	  					<i class="icon ic_year">年</i>
<!-- 	  				</s:elseif> -->
				<?php }elseif ($approval['leaveType']==6){?>
<!-- 	  				<s:else> -->
	  					<i class="icon ic_other">其</i>
<!-- 	  				</s:else> -->
				<?php }?>

	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
<!-- 	  								<s:property value="username"/> -->
											<?=Html::encode($approval['username']) ?>
	  					</span>
	  					<span class="fr status">

	  						<?php if($agree['state']==1){?>
<!-- 	  						<s:if test="state==1"> -->
	  							<em class="fc_sucess">审批中</em>
<!-- 	  						</s:if> -->
							<?php }elseif ($agree['state']==2){?>
<!-- 	  						<s:elseif test="state==2"> -->
	  							<em class="fc_undo">同意</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif ($agree['state']==3){?>
<!-- 	  						<s:elseif test="state==3"> -->
	  							<em class="fc_error">拒绝</em>
<!-- 	  						</s:elseif> -->
					<?php }elseif ($agree['state']==4){?>
<!-- 	  						<s:else> -->
	  							<em class="fc_undo">放弃</em>
<!-- 	  						</s:else> -->
					<?php }?>


						</span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">
<!-- 	  							<s:property value="day"/> -->
	  							<?=Html::encode($approval['days']) ?>
	  							天</span>
	  					<span class="fr date">
<!-- 	  								<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
								<?=Html::encode($approval['applyTime']) ?>
	  					</span>
	  				</p>
<!-- 	  			</a> -->
							<?=Html::endTag('a')?>
<!-- 	  				</s:iterator> -->
<!-- 	  			</s:if> -->
					<?php }?>
			<?php }?>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="small-12 columns">
<!-- 	  			<a href="leaveBillAction_more.action" class="button expand"> -->
					<?php //echo "index.php?r=leavebill/more&uid=".$uid?>
					<?php //echo $uid?>
<!-- 					<a href="index.php?r=leavebill/more&uid=".$uid class="button expand"> -->
						<?= Html::tag('a', Html::encode("查看更多假条"), ['href'=>'index.php?r=leavebill/more&uid='.$uid,'class'=>'button expand','uid'=>$uid]) ?>
<!-- 	  				查看更多假条 -->
<!-- 	  			</a> -->
	  		</div>
	  	</div>

	</div>
</div>

</body>
</html>