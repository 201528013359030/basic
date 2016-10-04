/*
 *version 2.0
 * 此版本的将对ID 的定义进行重新定义说明
 * 
 * 
 * 
 * */


//封装一个函数来判断当前设备，并搭建与三个终端沟通的方法
var Global_id =0;
var Global_bridge;
var Global_back_data = '';
var os = 0;
var API = {
	"os":"",
	/**
	 * 浏览器打开页面时的初始化方法
	 * 判断当前是什么终端
	 * 1:ios
	 * 2:android
	 * 3:pc
	 * 
	 */
	init: function(){
		if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
		     //alert( "ios" );
		     os=1;
		     
		    window.onerror = function(err) {
				console.log('window.onerror: ' + err);
			};
			
			this.connectWebViewJavascriptBridge(function(bridge) {
				Global_bridge = bridge;
				bridge.init(function(message, responseCallback) {
					//log('JS got a message', message)
					//responseCallback(data);
				});
				bridge.registerHandler('SendToJs',function(data, responseCallback) {
					API.send_tojs(data);
					
					if(responseCallback){
						responseCallback(data);
					}
				});
				bridge.registerHandler('JsCallback',function(data, responseCallback) {
					//alert(data);
					API.JsCallback(data);
					if(responseCallback){
						responseCallback(data);
					}
				});
			});
			 
					     
		 } else if (/(Android)/i.test(navigator.userAgent)) {
		     //alert( "android" );
		     os=2;
		 } else {
		 //	alert( "pc" ); 
		 	 os=3;
		 };
		 //console.log(os);
		
	},
	
	connectWebViewJavascriptBridge:function(callback){
		if (window.WebViewJavascriptBridge) {
			callback(WebViewJavascriptBridge);
		} else {
			document.addEventListener('WebViewJavascriptBridgeReady', function() {
				callback(WebViewJavascriptBridge)
			}, false);
		}
	},
	/**
	 * send_tonative 请求消息
	 * params 参数
	 * callback 无用
	 * 
	 */
	send_tonative:function(param,callback){
		
		var json = {
			"request":{
				"id":Global_id,
				"name":param.name,
				"callback":param.callback||null,
				"params":param.params||null
				
			}
		};
		if(os==2){ 
			window.JavaScriptInterface.sendToNative(JSON.stringify(json));
		}
		if(os==1){ 
			
			Global_bridge.callHandler('SendToNative', JSON.stringify(json), function(data) {
				if(callback){
					callback(json);
				}
			});
			
		}
		if(os==3){ 
			 
			window.HandleEvent('SendToNative', JSON.stringify(json));
		}

		
		Global_id++;
		
	},
	/**
	 * send_tojs
	 * 
	 * */
	send_tojs:function(data){
	},
	/*
	 * JsCallback 移动端调用这个函数
	 * 
	 * 
	 * */
	JsCallback:function(data){
		
		var datas = JSON.parse(data);
		var callback = datas.request.callback;
		eval(callback+'(datas)');
		
	}
		
}//api end

