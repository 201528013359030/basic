<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport"
	content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
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
					<?= Html::tag('a', Html::encode("创建请假条"), ['href'=>'index.php?r=leavebill/create&uid='.$uid])?>
<!-- 					<a href="">创建请假条</a> -->
			</div>
			<!--做好的 tab 切换两个内容-->
			<ul class="tabs row" data-tab>
				<li class="tab-title active small-6"><a href="#panel1">我的假条</a></li>
				<li class="tab-title small-6"><a href="#panel2">我审批的</a></li>
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
							<?php if(($dataApproval!=null)&&(count($dataApproval)>0)){?>
							<div class="list-group"></div>
						<?php }?>
<!-- 						</s:if> -->


						</div>
						<!--end tab2的内容区域-->

					</div>
					<!--tabs-content-->

					<div id="pullUp">
						<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
						<li class="list"></li>
					</div>

				</div>
				<!--end scroller-->
			</div>


		</div>
	</div>
	<input type="hidden" value=<?=$uid?> class="uid">
	<script src="../views/js/vendor/jquery.js"></script>
	<script src="../views/js/foundation.min.js"></script>


	<script>
		//初始化fundation 
		$(document).foundation();
	</script>
				
				
				<script>
					var $jq = jQuery.noConflict();
					var uid=$jq(".uid").val();
					var curPage = 1; //当前页码  
					var total,pageSize,totalPage;  
					//获取数据  
					//var jq = $.noConflict();
			function getData(page){  
					
					$jq.ajax({  
				        type: 'GET',  
				        url: 'index.php?r=leavebill/page',  
				        data: {'page':page-1,'uid':uid},  
				        dataType:'json',  
				        afterSend:function(){  
				            $(".pullUpIcon").append("<li id='loading'>loading</li>");  
				        },  
				        success:function(json){  
				            total = json.total; //总记录数  
				            pageSize = json.pageSize; //每页显示条数  
				            curPage = page; //当前页  
				            totalPage = json.totalPage; //总页数  
				            dataApproval=json.dataApproval;
				            setView(dataApproval);
				            //$this->rend
				            //alert(total+"  "+pageSize+" "+curPage+" "+totalPage);
				        },  
				        complete:function(){ //生成分页条  
				            //getPageBar();  
				        },  
				        error:function(){  
				            alert("数据加载失败");  
				        }  
				    });  
				}  
				getData(1);
				</script>

						<script>
						function setView(dataList){
							var view ="";
							var temp = "xhg";
							alert(temp);
					// 		$jq.each(dataList,function(index,data){
					// 			alert(temp);
					// 			view+="<a class='listIteam' href='index.php?r=leavebill/content&uid='"+data['userid']+"&id="+data['id']+"'>ddd"
					// 		        view+="<a class='listIteam' href='index.php?r=leavebill/content&uid="+temp+"'>ddd"
					// 			view+="<form action='index.php' name='form'>";
					// 			view+="<a href='javascript:form.submit;' class='ListIteam'>"
					// 			view+="<input type='hidden' value='leavebill/content' name='r'>";
					// 			view+="<input type='hidden' value='"+data['userid']+"' name='uid'>";
					// 			view+="<input type='hidden' value='"+data['id']+ "' name='id'>";	
					// 			view +="ddd";
					// 			view +="</a>";
					// 			view+="</form>"
					//			});
							//$jq(".list-group").append(view);
						}
						</script>

			
</body>
</html>
