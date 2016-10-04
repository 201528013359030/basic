
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>请假条列表-重申</title>
<link href="${basePath}/css/leave.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
	<div class="row">
		<form  data-abide action="leaveBillAction_updateStart.action" method="POST">
		<input type="hidden"  name="userid" value='<s:property value="#bill.userid"/>'/>
		<input type="hidden"  name="dep" value='<s:property value="#bill.dep"/>'/>
		<input type="hidden"  name="username" value='<s:property value="#bill.username"/>'/>
		<input type="hidden"  name="token" value='<s:property value="#bill.token"/>'/>
		<input type="hidden"  name="id" value='<s:property value="#bill.id"/>'/>
			<!--表单主体-->
			<div class="form-group">
				<div class="row">
			        <div class="small-3 columns">
			            <label class="center inline">请假人</label>
			        </div>
			        <div class="small-9 columns">
			            <label class="inline">${sessionScope.globle_user.position }</label>
			        </div>
			    </div>
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">类型</label>
			        </div>
			        <div class="small-9 columns">
			          <select data-invalid aria-invalid="true" required name="leaveType" >
			          <!-- 此处判断目前选择的结果 -->
				          <option value="">请选择</option>
				          <option value="1"  >事假</option>
				          <option value="2"  >病假</option>
				          <option value="3" >婚假</option>
				          <option value="4" >丧假</option>
				          <option value="5" >年假</option>
				          <option value="6"  >其他</option>
				        </select>
				        <small class="error">请正确选择类型</small>
			        </div>
			    </div>
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">开始</label>
			        </div>
			        <div class="small-9 columns">
			          <input id="starTime" class="datesel" name="startTime"  type="text" placeholder="请选择" required value='<s:property value="#bill.startTime"/>' />
			          <small class="error">请选择开始时间</small>
			        </div>
			    </div>
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">结束</label>
			        </div>
			        <div class="small-9 columns">
			          <input class="datesel" name="endTime"  type="text" placeholder="请选择"  required data-greatthan="starTime" data-abide-validator="greatThan" value='<s:property value="#bill.endTime"/>' />
			          <small class="error">结束时间不能小于开始时间</small>
			        </div>
			    </div>
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">审批人</label>
			        </div>
			        <!--这里需要把获取到的人名 放在 a里显示，也要放到hid input中显示-->
			        <div class="small-9 columns timeBox">
			          <a href="javascript:void(0);" class="btn-link" id="approver"><s:property value="#bill.spuser"/></a>
			          <input id="spuser-input" class="hid-input" value='<s:property value="#bill.spuser"/>' type="text" name="spuser" required />
			          <input id="approver-input" class="hid-input" value='<s:property value="#bill.approvalPerson"/>' type="text" name="approvalPerson" required />
			          <small class="error">请选择审批人</small>
			        </div>
			    </div>			    
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">通知人</label>
			        </div>
			        <div class="small-9 columns timeBox">
			          <!--这里需要把获取到的人名 放在 a里显示，也要放到hid input中显示-->
			          <a href="javascript:void(0);" class="btn-link" id="member"><s:property value="#bill.tzuser"/></a>
			          <input id="tzuser-input" class="hid-input" value='<s:property value="#bill.tzuser"/>' type="text" name="tzuser" required />
			          <input id="member-input" class="hid-input" value='<s:property value="#bill.tongzhi"/>'  type="text" name="tongzhi" required />
			          <small class="error">请选择通知人</small>
			        </div>
			        
			    </div>
				<div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">事由</label>
			        </div>
			        <div class="small-9 columns">
			        <textarea onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入请假事由" required name="reason" ><s:property value="#bill.reason"/> </textarea>	
			          <small class="error">请输入请假事由</small>
			        </div>
			    </div>
			    <div class="row">
			        <div class="small-3 columns">
			          <label for="right-label" class="center inline">交接</label>
			        </div>
			        <!--不是必填-->
			        <div class="small-9 columns">
			          <textarea onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入您请假后的工作安排" name="remark"><s:property value="#bill.remark"/></textarea>
			        </div>
			    </div>			    
		    </div>
		    <!--end 表单主体-->
		    
	  		<div class="small-6 columns">	  			
	  			<button type="submit" class="button expand" >提交</button>
	  		</div>
	  		
	  		<div class="small-6 columns">
	  			<button type="reset" class="button secondary expand">取消</button>
	  		</div>
			  	
		</form>
	</div>
	
	</div>
</div>

<!--这个就是弹出的窗口 可以通过验证来处理隐藏和显示 默认是自动透明度设为0-->
<!--
<div class="pageLoading">
	<p>弹出测试：开始时间必须大于结束时间</p>
</div>
-->
<?=Html::jsFile("/basic/views/js/vendor/jquery.js")?>
<?=Html::jsFile("/basic/views/js/foundation.min.js")?>
<?=Html::jsFile("/basic/views/js/htmlset.js")?>
<!-- 
<script src="${basePath}/js/vendor/jquery.js"></script>
<script src="${basePath}/js/foundation.min.js"></script>
<script src="${basePath}/js/htmlset.js"></script>  
 -->
<script type="text/javascript">
	
$(document).foundation({
  abide : {
   
    validators : {
        greatThan : function (el, required, parent) {
          var from  = document.getElementById(el.getAttribute(this.add_namespace('data-greatthan'))).value,
              to    = el.value,
              valid = (from < to);

          return valid;
        }
    }
  }
});

/**
 * 说明：调用native对接
 * OnSelectContactsCb 处理回调函数
 *  * 
 * */
API.init();
$('#approver').click(function(){
			
	var op = {
		 "name":"SelectContacts",      //native 的方法名称
		 "callback":"OnSelectContactsCb",  //可没有
		 "params":{"dataType":"shenpi","maxCount":1}  //dateType 记录当前调用的按钮   maxCount 最多能选多少人 
	
		};
	//调用方法 传参数 op
	API.send_tonative(op);
	
		
});
$('#member').click(function(){
	
	var op = {
		 "name":"SelectContacts",      //native 的方法名称
		 "callback":"OnSelectContactsCb",  //可没有
		 "params":{"dataType":"tongzhi","maxCount":99}  //dateType 记录当前调用的按钮   maxCount 最多能选多少人
	
		};
	//调用方法 传参数 op
	API.send_tonative(op);
	
		
});

function OnSelectContactsCb(datas){
	
	var status = datas.result.status,
	 dataType = datas.request.params.dataType,
	 params = datas.result.params,
	 name=[];
	 uid=[];
	if( status==0 ){
		
		for( var i=0; i<params.contactCount; i++ ){
			var _name = params.contacts[i].contactInfo.name;
			var _uid = params.contacts[i].contactInfo.uid;
			name.push(_name);
			uid.push(_uid);
		}
		//判断是审批人否
		if( dataType=='shenpi' ){ 
			$('#approver').html(name.join(','));
			$('#approver-input').val(uid.join(','));
			$('#spuser-input').val(name.join(','));
		}
		//判断是通知人否
		if( dataType=='tongzhi' ){
			$('#member').html(name.join(',')); //把数据转换成字符串 分别赋值给a 和 input
			$('#member-input').val(uid.join(','));
			$('#tzuser-input').val(name.join(','));
		}
		
		
	}else{
	
		showPageError('有错误啦，请重新选择！');
	}
}

/* end  调用native对接*/

//动态显示弹出的提示，暂时没用到 ,要是使用必须删除这个div
function showPageError(txt){
	var b = document.body,
		el = '';
	el = document.createElement('div');
	el.className = 'pageLoading';
	b.appendChild(el);
	_html = '<p>'+txt+'</p>';
	el.innerHTML = _html;
}

	
</script>

<!--时间控件部分-->
<?=Html::cssFile("/basic/views/js/vendor/mobiscroll.mo.min.css")?>
<?=Html::jsFile("/basic/views/js/vendor/mobiscroll.custom.min.js")?>
<!-- 
<link href="${basePath}/js/vendor/mobiscroll.mo.min.css" rel="stylesheet" type="text/css" />
<script src="${basePath}/js/vendor/mobiscroll.custom.min.js" type="text/javascript"></script>
 -->
<script type="text/javascript">
    $(function(){
     	//初始化时间控件 使用的是 mobiscroll
        $(".datesel").mobiscroll().date();
		
		var currYear = (new Date()).getFullYear();  

		var _mode = '';
		
		if (/(Android)/i.test(navigator.userAgent)){
			_mode = 'clickpick';
		}else{
			_mode = 'scroller';
		}
      	//初始化日期控件
		var opt = {
			preset: 'datetime', //日期，可选：date\datetime\time\tree_list\image_text\select
			theme: 'androids', //皮肤样式，可选：default\android\androids\android-ics light\android-ics\ios\jqm\sense-ui\wp light\wp有些样式不可用
			display: 'modal', //显示方式 ，可选：modal\inline\bubble\top\bottom
			mode: 'scroller', //日期选择模式，可选：scroller\clickpick\mixed
			lang:'zh',
			dateFormat: 'yyyy-mm-dd', // 日期格式
			setText: '确定', //确认按钮名称
			cancelText: '取消',//取消按钮名籍我
			dateOrder: 'yyyymmdd', //面板中日期排列格式
			dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字
			showNow: false,  
       		nowText: "今",  
        	startYear:currYear, //开始年份  
        	endYear:currYear + 100, //结束年份  
        	//endYear:2099 //结束年份
        	timeFormat: '00:00:00',
        	timeWheels: ''
		};
        
		$(".datesel").mobiscroll(opt);
		
		
    });
    
    
    
</script>	
</body>
</html>