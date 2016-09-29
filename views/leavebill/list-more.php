<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表-查看更多</title>
<?php use yii\helpers\Html;?>
<?=Html::cssFile("../views/css/leave.css")?>
<?=Html::cssFile("../views/css/module.css")?>
<?=Html::cssFile("../views/css/public.css")?>
</head>
<body>
	
	
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<div class="row-button">
<!-- 	  			<a href="leaveBillAction_input.action">创建请假条 </a> -->
					<a href="">创建请假条</a>
	  	</div>
		<!--做好的 tab 切换两个内容-->
		<ul class="tabs row" data-tab>
		  <li class="tab-title active small-6">
		  	<a href="#panel1">我的假条</a>
		  </li>
		  <li class="tab-title small-6">
		  	<a href="#panel2">我审批的</a>
		  </li>
		</ul>
		
		<div id="scrollwrap">
			<div id="scroller">
				
			    <!--<div id="pullDown">
					<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
<!-- 				</div>--> 
				
				<div class="tabs-content">
					<?php //print_r($dataApproval);?>
					<!--tab1的内容区域-->
					<div class="content active" id="panel1">		    
<!-- 						<s:if test="#lb_list!=null && #lb_list.size()>0"> -->
							<?php if(($dataApproval!=null)&&(count($dataApproval)>0)){?>
							<div class="list-group">
							<!--循环的还是 list.html的结构
								a 作为循环内容
<!-- 							--> 
<!-- 							<s:iterator value="#lb_list"> -->
				<?php foreach ($dataApproval as $approval){?>
<!-- 	  			<a href="leaveBillAction_viewTask.action?id=<s:property value="id"/>" class="listIteam"> -->
					<a href="" class="listIteam">
					
						<?php if($approval["leaveType"]==1){ echo $approval['leaveType']?>
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
	  				<?php }elseif ($approval['leaveType']==4){?>
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
					
					
<!-- 	  				<s:if test="leaveType==1"> -->
<!-- 	  					<i class="icon ic_shi">事</i> -->
<!-- 	  				</s:if> -->
<!-- 	  				<s:elseif test="leaveType==2"> -->
<!-- 	  					<i class="icon ic_ill">病</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==3"> -->
<!-- 	  					<i class="icon ic_marry">婚</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==4"> -->
<!-- 	  					<i class="icon ic_die">丧</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==5"> -->
<!-- 	  					<i class="icon ic_year">年</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:else> -->
<!-- 	  					<i class="icon ic_other">其</i> -->
<!-- 	  				</s:else> -->
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
<!-- 	  							<s:property value="day"/> -->
									<?=Html::encode($approval['days']) ?>
	  							天</span>
	  							
	  					<span class="fr status">
	  					
	  						<?php if($approval['state']==1){?>
	  							<em class="fc_sucess">审批中</em>
<!-- 	  						</s:if> -->
						<?php }elseif ($approval['state']==2){?>
<!-- 	  						<s:elseif test="state==2"> -->
	  							<em class="fc_sucess">同意</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($approval['state']==3){?>
<!-- 	  						<s:elseif test="state==3"> -->
	  							<em class="fc_error">拒绝</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($approval['state']==4){?>
<!-- 	  						<s:else> -->
	  							<em class="fc_sucess">放弃</em>
<!-- 	  						</s:else> -->
						<?php }?>
	  					
	  					
<!-- 	  						<s:if test="state==1"> -->
<!-- 	  							<em class="fc_sucess">审批中</em> -->
<!-- 	  						</s:if> -->
<!-- 	  						<s:elseif test="state==2"> -->
<!-- 	  							<em class="fc_undo">同意</em> -->
<!-- 	  						</s:elseif> -->
<!-- 	  						<s:elseif test="state==3"> -->
<!-- 	  							<em class="fc_error">拒绝</em> -->
<!-- 	  						</s:elseif> -->
<!-- 	  						<s:else> -->
<!-- 	  							<em class="fc_undo">放弃</em> -->
<!-- 	  						</s:else> -->
	  					</span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl summary textCut">
<!-- 	  								<s:property value="reason"/> -->
										<?=Html::encode($approval['reason']) ?>
	  					</span>
	  					<span class="fr date">
<!-- 	  						<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
								<?=Html::encode($approval['applyTime']) ?>
	  					</span>
	  				</p>
	  				</a>
<!-- 	  			</s:iterator> -->
							<?php }?>
						</div>
<!-- 						</s:if> -->
							<?php }?>
					</div>	
					<!--end tab1的内容区域-->
					
					<!--tab2的内容区域-->
					<div class="content" id="panel2">		 
					<?php if(($approvalPerson!=null)&&(count($approvalPerson)>0)){?>   
<!-- 						<s:if test="#sp_list!=null && #sp_list.size()>0"> -->
							<div class="list-group">
<!-- 							<s:iterator value="#sp_list"> -->
								<?php foreach ($approvalPerson as $person){?>
<!-- 	  					<a href="leaveBillAction_viewTaskSp.action?id=<s:property value="id"/>" class="listIteam"> -->
							<a href="" class="listIteam">
				<?php if($person["leaveType"]==1){?>
<!-- 	  				<s:if test="leaveType==1"> -->
	  					<i class="icon ic_shi">事</i>
<!-- 	  				</s:if> -->
				<?php }elseif ($person['leaveType']==2){?>
<!-- 	  				<s:elseif test="leaveType==2"> -->
	  					<i class="icon ic_ill">病</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($person['leaveType']==3){?>
<!-- 	  				<s:elseif test="leaveType==3"> -->
	  					<i class="icon ic_marry">婚</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($person['leaveType']==4){?>
<!-- 	  				<s:elseif test="leaveType==4"> -->
	  					<i class="icon ic_die">丧</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($person['leaveType']==5){?>
<!-- 	  				<s:elseif test="leaveType==5"> -->
	  					<i class="icon ic_year">年</i>
<!-- 	  				</s:elseif> -->
	  				<?php }elseif ($person['leaveType']==6){?>
<!-- 	  				<s:else> -->
	  					<i class="icon ic_other">其</i>
<!-- 	  				</s:else> -->
	  				<?php }?>
<!-- 	  				<s:if test="leaveType==1"> -->
<!-- 	  					<i class="icon ic_shi">事</i> -->
<!-- 	  				</s:if> -->
<!-- 	  				<s:elseif test="leaveType==2"> -->
<!-- 	  					<i class="icon ic_ill">病</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==3"> -->
<!-- 	  					<i class="icon ic_marry">婚</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==4"> -->
<!-- 	  					<i class="icon ic_die">丧</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:elseif test="leaveType==5"> -->
<!-- 	  					<i class="icon ic_year">年</i> -->
<!-- 	  				</s:elseif> -->
<!-- 	  				<s:else> -->
<!-- 	  					<i class="icon ic_other">其</i> -->
<!-- 	  				</s:else> -->
	  				<i class="ficon icon-angle-right"></i>
	  				<p class="info clearfix">
	  					<span class="fl name">
<!-- 	  							<s:property value="username"/> -->
	  								<?=Html::encode($person['username']) ?>
	  					</span>
	  					<span class="fr status">
	  					
	  					<?php if($person['state']==1){?>
	  							<em class="fc_sucess">审批中</em>
<!-- 	  						</s:if> -->
						<?php }elseif ($person['state']==2){?>
<!-- 	  						<s:elseif test="state==2"> -->
	  							<em class="fc_sucess">同意</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($person['state']==3){?>
<!-- 	  						<s:elseif test="state==3"> -->
	  							<em class="fc_error">拒绝</em>
<!-- 	  						</s:elseif> -->
						<?php }elseif($person['state']==4){?>
<!-- 	  						<s:else> -->
	  							<em class="fc_sucess">放弃</em>
<!-- 	  						</s:else> -->
						<?php }?>
<!-- 							<s:if test="state==1"> -->
<!-- 	  							<em class="fc_sucess">审批中</em> -->
<!-- 	  						</s:if> -->
<!-- 	  						<s:if test="state==2"> -->
<!-- 	  							<em class="fc_undo">已同意</em> -->
<!-- 	  						</s:if> -->
<!-- 	  						<s:if test="state==3"> -->
<!-- 	  							<em class="fc_error">已拒绝</em> -->
<!-- 	  						</s:if> -->
<!-- 	  						<s:elseif test="state==4"> -->
<!-- 	  							<em class="fc_undo">已放弃</em> -->
<!-- 	  						</s:elseif> -->
						</span>
	  				</p>
	  				<p class="info clearfix">
	  					<span class="fl date">
<!-- 	  							<s:property value="day"/> -->
								<?=Html::encode($person['days']) ?>
	  							天</span>
	  					<span class="fr date">
<!-- 	  							<s:date name="applyTime" format="YYYY-MM-dd HH:mm"/> -->
					  				<?=Html::encode($person['applyTime']) ?>
	  					</span>
	  				</p>
	  			</a>
<!-- 	  				</s:iterator> -->
						<?php }?>
						</div>
						<?php }?>
<!-- 						</s:if> -->
						
						
					</div>
					<!--end tab2的内容区域-->
					
				</div> <!--tabs-content-->
				
				<!--<div id="pullUp">
					<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
<!-- 				</div>--> 
		  
		    </div> <!--end scroller-->	
		</div>
			
		
	</div>
</div>
	

<?=Html::jsFile("/basic/views/js/vendor/jquery.js")?>
<?=Html::jsFile("/basic/views/js/foundation.min.js")?>
<!-- 
<script src="../js/vendor/jquery.js"></script>
<script src="../js/foundation.min.js"></script>
 -->
<script>
//初始化fundation 

$(document).foundation();
	
</script>

</body>
</html>
