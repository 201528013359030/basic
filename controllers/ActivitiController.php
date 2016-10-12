<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\CurlModel;
//use yii\web\Controller;
class ActivitiController extends Controller{
	public function  actionTest(){
		return $this->renderFile ( '@app/views/activiti/test.php');
	}
	public function actionGetUserInfo(){
		$client = new SoapClient();
		
	}
	public function actionGetDeployments(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//获得数据为：$result->data
		
// 		foreach ($result as $res){
// 			var_dump($res[0]);
// 		}
		//var_dump($result);
// 		foreach ($result->data as $res){
// 			echo "id:".$res->id;
// 		}
// 		var_dump($result->data);
 		var_dump ( $result );
	}
	public function actionGetDeploymentById(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/40';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		var_dump($result);
	}
	public function actionDeleteDeployment($deploymentId='20'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/'.$deploymentId;
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->delete( $webService));
		var_dump($result);
	}
	
	public function actionCreateNewDeployment(){
		//@app/views/leavebill/list-empty-error.php
// 		$filename = "../controllers/resources/leaveBill02.zip";
// 		$handle = fopen($filename,"r");
		//$param=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"));
		$param = array("Content-Type"=>"multipart/form-data;charset=UTF8");
		//$data = array('file-field'=>'resources/leaveBill02.zip',"Content-Type"=>"multipart/form-data;charset=UTF8");
		//$param=array();
		$data = array('file-name'=>'../controllers/resources/leaveBill02.zip');
		//$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"multipart/form-data;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->post( $webService,$data,$param));
		var_dump($result);
	}
	public function actionListResources($deploymentId=20){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/'.$deploymentId.'/resources';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		var_dump($result);
	}
	public function actionDeploymentResourceById($deploymentId=20,$resourceId='FixSystemFailureProcess.png'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/'.$deploymentId.'/resources/'.$resourceId;
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		var_dump($result);
	}
	/*
	 * 返回null
	 */
	public function actionDeploymentResourceContent($deploymentId=20,$resourceId='FixSystemFailureProcess.png'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/'.$deploymentId.'/resourcedata/'.$resourceId;
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionListProcess(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionProcessById($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId;
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionUpdateCategory($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId;
		$curl = new CurlModel ();
		$data=json_encode(array("category" =>"updatedcategory"));
		$result = json_decode($result=$curl->setHeaders($head)->put( $webService,$data));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	/*
	 * 返回null
	 */
	public function actionProcessDefinitionResourceContent($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId.'/resourcedata';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionProcessDefinitionBpmnMode($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId.'/model';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionSuspendProcessDefinition($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId;
		$curl = new CurlModel ();
		$data=json_encode(array( "action" => "suspend","includeProcessInstances" =>"false","date" => "2013-04-15T00:42:12Z"));
		$result = json_decode($result=$curl->setHeaders($head)->put( $webService,$data));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionActivateProcessDefinition($processDefinitionId='createTimersProcess:1:31'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId;
		$curl = new CurlModel ();
		$data=json_encode(array( "action" => "activate","includeProcessInstances" =>"false","date" => "2013-04-15T00:42:12Z"));
		$result = json_decode($result=$curl->setHeaders($head)->put( $webService,$data));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	/*
	 * 返回为空数组
	 */
	public function actionGetAllCandidateStarters($processDefinitionId='oneTaskProcess:1:34'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/repository/process-definitions/'.$processDefinitionId.'/identitylinks';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionStartProcessInstance($key,$businessKey,$variables){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/runtime/process-instances';
		$curl = new CurlModel ();
	//	String $businessKey=$key."."
// 		$variables=json_encode(array("name"=>"myVar",
// 					"value"=>"This is a variable",));
		$data=json_encode([
				"processDefinitionKey"=>$key,
				"businessKey"=>$businessKey,
				//"tenantId"=>"tenant1",
				"variables"=> $variables,
		]);
		$result = json_decode($result=$curl->setHeaders($head)->post( $webService,$data));
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionListHistoricProcessInstances(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/history/historic-process-instances';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		$processList=$result->data;
		foreach ($processList as $process){
				if($process->businessKey=='LeaveBill.QJDH00000000009'){
					echo $process->processDefinitionId;
					break;
				}
		}
		//echo count($result);
		//print_r($result);
		var_dump($result->data);
	}
	public function actionQueryHistoricProcessInstancesByKey(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/query/historic-process-instances';
		$curl = new CurlModel ();
		$data=json_encode(['processBusinessKey'=>'LeaveBill.QJDH00000000009']);
		//$param=['businessKey'=>'LeaveBill.QJDH00000000009'];
		$result = json_decode($result=$curl->setHeaders($head)->post( $webService,$data));
		//$processList=$result->data;
		//foreach ($processList as $process){
// 			if($process->businessKey=='LeaveBill.QJDH00000000009'){
// 				echo $process->processDefinitionId;
// 				break;
// 			}
// 		}
		//echo count($result);
		//print_r($result);
		var_dump($result);
	}
	public function actionQueryTasks(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/query/tasks';
		$data=json_encode(['processInstanceId'=>'1101']);
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->post( $webService,$data));
		var_dump($result->data);
	}
	//public function actionQueryTasks()
	public function actionQueryHistoricProcessInstancesById($processInstanceId='1101'){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/query/historic-task-instances';
		$curl = new CurlModel ();
		$data=json_encode(['processInstanceId'=>$processInstanceId]);
		//$param=['businessKey'=>'LeaveBill.QJDH00000000009'];
		$result = json_decode($result=$curl->setHeaders($head)->post( $webService,$data));
		var_dump($result);
		//return $result->data;
	}
	
	public function actionListProcessInstances(){
		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
		$webService = 'http://localhost:8080/activiti-rest/service/runtime/process-instances';
		$curl = new CurlModel ();
		$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
		var_dump($result->data);
// 		$processList=$result->data;
// 		foreach ($processList as $process){
// 			if($process->businessKey=='LeaveBill.QJDH00000000009'){
// 				echo $process->processDefinitionId;
// 				break;
// 			}
// 		}
	}
	//public function action
// 	public function actionFindCommentById($id='QJDH00000000009'){
// 		$objectName='LeaveBill';
// 		$objId=$objectName.".".$id;
// 		$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
// 		$webService = 'http://localhost:8080/activiti-rest/service/query/historic-process-instances';
// 		$curl = new CurlModel ();
//  		//$variables=[['name'=>'businessKey','value'=>'LeaveBill.QJDH00000000009','operation'=>'equals','type'=>'string']];
//  		$data =json_encode(["processDefinitionId" =>"LeaveBill:1:304",'businessKey'=>'LeaveBill.QJDH00000000009']);
// 		var_dump($data);
// 		$result = json_decode($result=$curl->setHeaders($head)->post( $webService,$data));
// 		//echo count($result);
// 		//print_r($result);
// 		var_dump($result);
// 	}
	
	public function actionActivitirest() {
	// print_r($_SERVER['HTTP_ACCEPT']);
	
	// $GLOBALS['uid']='3@15';
	//$params='';
	$head=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"Content-Type"=>"application/json;charset=UTF8","Accept"=>"application/json;charset=UTF8");
	//$webService = 'http://localhost:8080/activiti-rest/service/identity/users';
	//http://host/activiti-rest/service/
	$webService = 'http://localhost:8080/activiti-rest/service/repository/deployments/20';
	//$webService = 'http://127.0.0.1:8080/activiti-rest/service/identity/groups';
	// 		$webService ='http://demo.kafeitu.me:8080/kft-activiti-demo/rest/management/properties';
	$curl = new CurlModel ();
	
	// 		$curl->setHeaders($head);
	$result = json_decode($result=$curl->setHeaders($head)->get( $webService));
	//$result = json_decode($result=$curl->setHeaders($head)->post( $webService));
	// 	 $result = json_decode($curl->post ( $webService,$params));
	
	//echo "<pre>";
	//echo "参数</br>";
	//var_dump ( $params );
	//echo "结果</br>";
	var_dump ( $result );
	//print_r($result);
	
	// 获取form post 参数
	// $uid = I ( 'uid' );
	// $uid = '3@3';
	
	// $params ['id'] = 5; // 轻应用id （企业门户添加轻应用后生成）
	// $params ['eid'] = explode ( "@", $uid ) [1]; // 企业id可在uid中解析到，@ 符后面数字为eid。
	// $params ['title'] = 'text' ; // 通知内容
	// $params ['url'] = "http://uc.sipsys.com"; // 通知的链接地址
	// $params ['uids[0]'] = $uid; // 接收者uid (数组)
	// $params ['auth_token'] = 'auth_token' ; // 用户认证
	// $params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
	
	// // 接口地址
	// $webService = "http://192.168.139.162/elgg/services/api/rest/json/?method=lapp.notice";
	// $curl = new CurlModel ();
	// $result = json_decode ( $curl->post ( $webService, $params ), true );
	
	// $this->display ();
	
	// return $this->render ( 'view', [
	// 'model' => $this->findModel ( $id )
	// ] );
	}

}