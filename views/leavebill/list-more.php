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
</head>
<body onLoad=Init();>
	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">
			<div class="row">
				<div class="row-button">
					<?= Html::tag('a', Html::encode("创建请假条"), ['href'=>'index.php?r=leavebill/create&uid='.$uid])?>
				</div>
				<!--做好的 tab 切换两个内容-->
				<ul class="tabs row" data-tab>
					<li class="tab-title active small-6" id="tab1"><a href="#panel1">我的假条</a>
					</li>
					<li class="tab-title small-6" id="tab2"><a href="#panel2">我审批的</a></li>
				</ul>
				<div id="scrollwrap">
					<div id="scroller">
						<!-- 	<div id="pullDown"> -->
						<!-- 	<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span> -->
						<!--  	</div> -->
						<div class="tabs-content">
							<!--tab1的内容区域-->
							<div class="content active" id="panel1">
								<div class="list-group"></div>
							</div>
							<!--end tab1的内容区域-->

							<!--tab2的内容区域-->
							<div class="content" id="panel2">
								<div class="list-group"></div>
							</div>
							<!--end tab2的内容区域-->
						</div>
						<!--tabs-content-->

						<div id="pullUp" onclick=getData();>
							<!-- <span class="pullUpIcon"></span><span class="pullUpLabel" >上拉加载更多...</span> -->
							<!-- <span class="pullUpIcon"></span> -->
							<span class="pullUpLabel">点击加载更多...</span>
						</div>
						<!-- end pullUp -->
					</div>
					<!--end scroller-->
					<input type="hidden" value=<?=$uid?> class="uid">
				</div>
				<!-- end scrollwrap -->
			</div>
			<!-- end row -->
		</div>
		<!-- end inner-wrap -->
	</div>
	<!-- end off-canvas-wrap -->

	<script src="../views/js/vendor/jquery.js"></script>
	<script src="../views/js/foundation.min.js"></script>
	<script>
//初始化fundation
		$(document).foundation();
	</script>
	<script>
		var $jq = jQuery.noConflict();
		var uid=$jq(".uid").val();
		var panel1CurPage = 1; //当前页码
		var panel1Total,panel1PageSize,panel1TotalPage;
		var panel1Page=2;
		var panel2Page=2;
		var panel2CurPage = 1; //当前页码
		var panel2Total,panel2PageSize,panel2TotalPage;
		var curTime="";
		var index=0;
		function Init(){
			panel1Total = <?=$panel1Total?>; //总记录数
    		panel1PageSize = <?=$pageSize?>; //每页显示条数
   	 		panel1CurPage = 1; //当前页
    		panel1TotalPage = <?=$panel1TotalPage?>; //总页数
    		panel2Total = <?=$panel2Total?>; //总记录数
    		panel2PageSize = <?=$pageSize?>; //每页显示条数
    		panel2CurPage = 1; //当前页
   	 		panel2TotalPage = <?=$panel2TotalPage?>; //总页数
    		curTime=<?=(string)$curTime?>;
			setPanel1View(<?=$dataBill?>);
			setPanel2View(<?=$dataApproval?>);
		}
		$jq(".tabs li").bind("click",function(){
			index=$jq(this).index();
			if(index==0){
				if(panel1TotalPage-panel1CurPage>0){
					$jq(".pullUpLabel").html("点击加载更多....");
				}else{
					$jq(".pullUpLabel").html("没有更多数据了...");
			}
		}else if(index==1){
			if(panel2TotalPage-panel2CurPage>0){
				$jq(".pullUpLabel").html("点击加载更多....");
			}else{
				$jq(".pullUpLabel").html("没有更多数据了...");
			}
		}
	//console.log(index);
	});
	function getData(){
		if(index==0){
			if(panel1TotalPage-panel1CurPage>0){
				panel1CurPage+=1;
				getPanel1Data(panel1CurPage);
			}else{
				$jq(".pullUpLabel").html("没有更多数据了...");
			}
		}else if(index==1){
			if(panel2TotalPage-panel2CurPage>0){
				panel2CurPage+=1;
				getPanel2Data(panel2CurPage);
			}else{
				$jq(".pullUpLabel").html("没有更多数据了...");
			}
		}
	}
function getPanel1Data(page){
	$jq.ajax({
        type: 'GET',
        url: 'index.php?r=leavebill/mybill',
        data: {'page':page-1,'uid':uid,'applyTime':curTime,'pageSize':panel1PageSize},
        dataType:'json',
        afterSend:function(){
        	   $(".pullUpLabel").html("loading...");
        },
        success:function(json){
            dataApproval=json.dataApproval;
            //console.log(dataApproval.length);
            if(dataApproval!=null&&dataApproval.length>0){
            	setPanel1View(dataApproval);
            }else{
            	$jq(".pullUpLabel").html("没有更多数据了...");
            }
        },
        complete:function(){ //生成分页条
            //getPageBar();
        },
        error:function(){
        	$jq(".pullUpLabel").html("数据加载失败...");
//             alert("数据加载失败");
        }
    });
}

//改进
function getPanel2Data(page){
	$jq.ajax({
        type: 'GET',
        url: 'index.php?r=leavebill/myapproval',
        data: {'page':page-1,'uid':uid,'applyTime':curTime,'pageSize':panel2PageSize},
        dataType:'json',
        afterSend:function(){
            $(".pullUpLabel").html("loading...");
        },
        success:function(json){
            dataApproval=json.dataApproval;
            if(dataApproval!=null&&dataApproval.length>0){
            	setPanel2View(dataApproval);
            }else{
            	$jq(".pullUpLabel").html("没有更多数据了...");
            }
        },
        complete:function(){ //生成分页条
            //getPageBar();
        },
        error:function(){
//             alert("数据加载失败");
        	$jq(".pullUpLabel").html("数据加载失败...");
        }
    });
}
</script>
	<script>
	function setPanel1View(dataList){
		var view="";
		$jq.each(dataList,function(index,data){
			view+="<a class='listIteam' href='index.php?r=leavebill/content&uid="+data['userid']+"&id="+data['id']+"'>";
			if(data['leaveType']==1){
					view+="<i class='icon ic_shi'>事</i>";
			}else if(data['leaveType']==2){
					view+="<i class='icon ic_shi'>病</i>";
			}else if(data['leaveType']==3){
					view+="<i class='icon ic_shi'>婚</i>";
			}else if(data['leaveType']==4){
					view+="<i class='icon ic_shi'>丧</i>";
			}else if(data['leaveType']==5){
				    view+="<i class='icon ic_shi'>年</i>";
			}else if(data['leaveType']==6){
				view+="<i class='icon ic_shi'>其</i>";
			}
			view +="<i class='ficon icon-angle-right'></i>";
			view+="<p class='info clearfix'>";
			view+="<span class='fl name'>";
			view +=data['days'];
			view +="天</span>";
			view +="<span class='fr status'>";
			if(data['state']==1){
				view+="<em class='fc_sucess'>审批中</em>";
			}else if(data['state']==2){
				view+="<em class='fc_sucess'>同意</em>";
			}else if(data['state']==3){
				view+="<em class='fc_error'>拒绝</em>";
			}else if(data['state']==4){
				view +="<em class='fc_sucess'>放弃</em>";
			}
			view +="</span>";
			view +="</p>";
			view +="<p class='info clearfix'>";
			view +="<span class='fl summary textCut'>";
			view+=data['reason'];
			view+="</span>";
			view+="<span class='fr date'>";
			view+=data['applyTime'];
			view+="</span>";
			view+="</p>";
			view+="</a>";

			});
		$jq("#panel1 .list-group").append(view);
}
	function setPanel2View(dataList){
		var view="";
		$jq.each(dataList,function(index,data){
			var temp ='11';
			view+="<a class='listIteam' href='index.php?r=leavebill/contentsp&uid="+data['userid']+"&id="+data['id']+"'>";
			if(data['leaveType']==1){
					view+="<i class='icon ic_shi'>事</i>";
			}else if(data['leaveType']==2){
					view+="<i class='icon ic_shi'>病</i>";
			}else if(data['leaveType']==3){
					view+="<i class='icon ic_shi'>婚</i>";
			}else if(data['leaveType']==4){
					view+="<i class='icon ic_shi'>丧</i>";
			}else if(data['leaveType']==5){
				    view+="<i class='icon ic_shi'>年</i>";
			}else if(data['leaveType']==6){
				view+="<i class='icon ic_shi'>其</i>";
			}
			view +="<i class='ficon icon-angle-right'></i>";
			view+="<p class='info clearfix'>";
			view+="<span class='fl name'>";
			view +=data['username'];
			view +="</span>";
			view +="<span class='fr status'>";
			if(data['state']==1){
				view+="<em class='fc_sucess'>审批中</em>";
			}else if(data['state']==2){
				view+="<em class='fc_sucess'>同意</em>";
			}else if(data['state']==3){
				view+="<em class='fc_error'>拒绝</em>";
			}else if(data['state']==4){
				view +="<em class='fc_sucess'>放弃</em>";
			}
			view +="</span>";
			view +="</p>";
			view +="<p class='info clearfix'>";
			view +="<span class='fl date'>";
			view+=data['days'];
			view+="天</span>";
			view+="<span class='fr date'>";
			view+=data['applyTime'];
			view+="</span>";
			view+="</p>";
			view+="</a>";
			});
		$jq("#panel2 .list-group").append(view);
}
</script>
</body>
</html>
