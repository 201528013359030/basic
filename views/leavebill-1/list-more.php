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
<?=Html::cssFile('/basic/views/css/leave.css')?>
</head>
<body>
	
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
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
				</div>-->
				
				<div class="tabs-content">
					
					<!--tab1的内容区域-->
					<div class="content active" id="panel1">		    
						
						<div class="list-group">
							<!--循环的还是 list.html的结构
								a 作为循环内容
							-->
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
							
						</div>
					</div>	
					<!--end tab1的内容区域-->
					
					<!--tab2的内容区域-->
					<div class="content" id="panel2">		    
						
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
						</div>
						
					</div>
					<!--end tab2的内容区域-->
					
				</div> <!--tabs-content-->
				
				<!--<div id="pullUp">
					<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
				</div>-->
		  
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
