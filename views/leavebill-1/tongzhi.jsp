<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ include file="/js/main.jspf" %>
<%@taglib uri="/struts-tags" prefix="s" %>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>通知</title>
<link href="${basePath}/css/leave.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		
		<!--请假条内容部分-->
		<div class="row">
			
			<div class="row-tab">&nbsp;</div>
			
			<div class="content">
				
				<div class="conInfo">
					<p>您好，我是<span class="fb"><s:property value="#bill.username"/>-<s:property value="#bill.dep"/></span>,需请假<s:property value="#bill.day"/>天</span>
					</p>
					<p><mark class="fmak"><s:date name="#bill.leaveStartTime" format="YYYY-MM-dd HH:mm"/> ~ <s:date name="#bill.leaveEndTime" format="YYYY-MM-dd HH:mm"/></mark></p>
					<p><s:property value="#bill.remark"/></p>
					<br>
					<br>
					<span class="send_time"><s:property value="#bill.applyTime"/></span>&nbsp;<span><s:property value="#bill.username"/>发送</span>
				</div>
				
				
			</div>
			
		</div>
		<!--end 请假条内容部分-->
		
		<div class="row-tab">&nbsp;</div>
		
		<!--跟踪流程-->
		<!--end 跟踪流程-->
		
	</div>
</div>
</body>
</html>