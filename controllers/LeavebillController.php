<?php

namespace app\controllers;

use Yii;
use app\models\Leavebill;
use app\models\LeavebillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Employee;
use app\models\CurlModel;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\WorkflowModel;
use app\models\UtilsModel;

/**
 * LeavebillController implements the CRUD actions for Leavebill model.
 */
class LeavebillController extends Controller {
	public $enableCsrfValidation = false;
	public $layout = 'false';
	public $auth_token;

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
				'verbs' => [
						'class' => VerbFilter::className (),
						'actions' => [
								'delete' => [
										'POST'
								]
						]
				]
		];
	}

	/**
	 * auth.gettoken 获取用户认证信息
	 *
	 * @param
	 *        	array
	 * @return mixed
	 * @author fyq
	 */
	public function actionGetAuth_Token($params) {

		// auth_token认证
		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
		$params = [
				'name' => $params ['name'],
				'password' => $params ['password'],
				'api_key' => $api_key
		];
		$webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=auth.gettoken";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );

		$result = json_decode ( $result );
		return $result;
	}


	/**
	 * CheckAuth_Token athh_token验证
	 *
	 * @param
	 *        	array
	 * @return mixed
	 * @author fyq
	 */
	public function actionCheckAuth_Token($params) {

		// auth_token认证
		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
		$params = [
				'uid' => $params ['uid'],
				'auth_token' => $params ['auth_token'],
				'api_key' => $api_key
		];
		$webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=check.user.token";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );

		$result = json_decode ( $result );
		return $result;
	}

	/**
	 * index
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionIndex() {
		$request = Yii::$app->request;
		$uid = $request->get ( 'uid', '0' );
		// echo $uid;
		// return;
		$eguid = $request->get ( 'eguid', '0' );
		$auth_token = $request->get ( 'auth_token', '0' );
		$api_key = $request->get ( 'api_key', '36116967d1ab95321b89df8223929b14207b72b1' );
		$gid = $request->get ( 'gid', '0' );
		$nid = $request->get ( 'nid', '0' );
		$provider = $request->get ( 'provider', '0' );



/************************** 临时获取token测试用  begin***********************************/
		if($auth_token=='0'){
		$params = [
				'name' => '18900913303',
				'password' => '123456'
		];
		$result = $this->actionGetAuth_Token ( $params );

		var_dump($result);
// 		echo $result->result->auth_token;
// 		return;

		$uid=$result->result->uid;
		$auth_token=$result->result->auth_token;
		$eguid=$result->result->eguid;
}

/************************** 临时获取token测试用 end***********************************/
		// token验证
		$params = [
				'uid' => $uid,
				'auth_token' => $auth_token
		];
		$result = $this->actionCheckAuth_Token ( $params );

// 		var_dump ( $result );
// 		return ;
	  /******************** zyr ***************************/
		if(!isset($result->status)){
			return 'auth_token不存在，认证返回失败!';
		}
		 /******************** zyr ***********************/
		if ('0' != $result->status) {

			return '认证返回失败!';
		}
		if ('1' != $result->result->success) {
			return '认证失败!';
		}

		$session = Yii::$app->session;
		if (! $session->isActive) {

			$session->open ();
		}
		$session->set ( 'uid', $uid );
		$session->set ( 'eguid', $eguid );
		$session->set ( 'auth_token', $auth_token );
		$session->set ( 'api_key', $api_key );
		$session->set ( 'gid', $gid );
		$session->set ( 'nid', $nid );
		$session->set ( 'provider', $provider );

		$result = $this->actionGetUserInfo ();
		$session->set ( 'name', $result->result->membername [0] );
		$session->set ( 'department', $result->result->department [0] );
		return $this->redirect ( [
				'list',
				'uid' => $uid
		] );
	}

	/**
	 * Lists all Leavebill models.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionList() {
		$session = Yii::$app->session;
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// 获取session中的变量值，以下用法是相同的：
		// $uid = $session->get ( 'uid' );

		$searchModel = new LeavebillSearch ();
		// $dataProvider = $searchModel->search ( $request->queryParams )->asArray();

		$limit = array ();
		$limit [0] = 3;
		$limit [1] = 3;
		$limit [2] = 5;
		$limit [3] = 3;

		// 查询当前用户的请假信息---进行中
		$dataDisagree = LeavebillSearch::find ()->where ( [
				// 'username'=> '3@15'
				'userid' => $uid,
				'state' => [
						'1',
						'3'
				]
		] )->limit ( $limit [0] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();

		// 查询当前用户的请假信息---已同意
		$dataAgree = LeavebillSearch::find ()->where ( [
				// 'username'=> '3@15'
				'userid' => $uid,
				'state' => '2'
		] )->limit ( $limit [1] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();

		// 查询需要当前用户审批的请假信息--待审批
		$dataDisapproval = LeavebillSearch::find ()->where ( [
				// 'username'=> '3@15'
				'approvalPerson' => $uid,
				'state' => '1'
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();

		// 查询需要当前用户审批的请假信息--已审批
		$dataApproval = LeavebillSearch::find ()->where ( [
				// 'username'=> '3@15'
				'approvalPerson' => $uid,
				'state' => [
						2,
						3
				]
		] )->limit ( $limit [3] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();
		// <<<<<<< HEAD

		// if($dataDisagree||$dataAgree||$dataDisapproval||$dataApproval){

		// // print_r ( $dataDisagree );
		// // echo "</br>";
		// // print_r ( $dataAgree );echo "</br>";
		// // print_r ( $dataDisapproval );echo "</br>";
		// // print_r ( $dataApproval );

		// =======
		if (($dataDisagree == null || count ( $dataDisagree ) <= 0) && ($dataAgree == null || count ( $dataAgree ) <= 0) && ($dataDisapproval == null || count ( $dataDisapproval ) <= 0) && ($dataApproval == null || count ( $dataApproval ) <= 0)) {
			return $this->renderFile ( '@app/views/leavebill/list-empty.php', [
					'uid' => $uid
			] );
		} else {
			// >>>>>>> refs/remotes/basic/master
			return $this->renderFile ( '@app/views/leavebill/list.php', [
					'dataDisagree' => $dataDisagree,
					'dataAgree' => $dataAgree,
					'dataDisapproval' => $dataDisapproval,
					'dataApproval' => $dataApproval,
					'uid' => $uid
			] );
			// <<<<<<< HEAD
			// }else{
			// return $this->renderFile ( '@app/views/leavebill/list-empty.php',['uid' => $uid]);
			// }

			// =======
			// echo $uid;
		}
		// >>>>>>> refs/remotes/basic/master
	}

	/**
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionCreate() {
		$uid = Yii::$app->request->get ( 'uid', '0' );
		$session = Yii::$app->session;
		// $model = Employee::find ()->where ( [
		// // 'username'=> '3@15'
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// 获取session中的变量值，以下用法是相同的：
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		$username = $session->get ( 'department' ) . '_' . $session->get ( 'name' );
		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		// 'username' => $username,
		// 'uid' => $uid,

		// ] );
		return $this->renderFile ( '@app/views/leavebill/create.php', [
				'username' => $username,
				'uid' => $uid
		] );

		// if ($model) {
		// $model[0]['name']= $session->get('department').'_'.$session->get('name');
		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		// 'model' => $model,
		// 'uid' => $uid,

		// ] );
		// } else { // echo "无此用户";
		// echo "用户不存在";
		// return;
		// }
		// }
	}
	public function actionWhere() {

		// $uid = Yii::$app->request->get ( 'uid' );
		$posts = Yii::$app->db->createCommand ( 'SELECT * FROM leavebill where userid = :uid and id > :id and applyTime < :applyTime' )->bindValue ( ':uid', '8@15' )->bindValue ( ':id', 502 )->bindValue ( ':applyTime', date ( 'Y-m-d H:i:s' ) )->queryAll ();

		// $model = Leavebill::find ()->where(['>','id','500'])->asArray()->all();

		// $model->andWhere([ 'leaveType'=>'1']);

		print_r ( $posts );
	}
	// }

	/**
	 *
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */

	// 修改applyTime的时间？？？？
	public function actionSave() {
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		$uid = $request->post ( 'uid', '0' );
		date_default_timezone_set ( 'PRC' );
		// 获取session中的变量值，以下用法是相同的：
		// if($uid==0){
		// $uid = $session->get ( 'uid' );
		// }
		// if($uid=='0'){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		$auth_token = $session->get ( 'auth_token' );

		// $model = new Leavebill ();
		// $model = Employee::find ()->where ( [
		// // 'username'=> '3@15'
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (! $model) {
		// echo "无此用户";
		// return;
		// }

		$model1 = Leavebill::find ()->where ( [
				'userid' => $uid,
				'state' => [
						1,
						2,
						3
				]
		] )->andWhere ( [
				'>',
				'leaveEndTime',
				date ( 'Y-m-d H:i:s' )
		] )->asArray ()->all ();

		$tag = 0;
		// echo count ( $model1 );

		// 判断是否与已有的请假记录重复
		for($i = 0; $i < count ( $model1 ); $i ++) {

			if (! ($model1 [$i] ['leaveEndTime'] < $request->post ( 'leaveStartTime' ) || $model1 [$i] ['leaveStartTime'] > $request->post ( 'leaveEndTime' ))) {
				$tag = 1;
			}
		}
		if ($tag == 1) {
// <<<<<<< HEAD
// 			echo '<script>alert("请假时间段有重复！");</script>';
// 			$username = $session->get ( 'department' ) . '_' . $session->get ( 'name' );
// 			// echo "请假时间段有重复！";
// 			// return ;
// 			return $this->renderFile ( '@app/views/leavebill/createtest.php', [
// 					'username' => $username,
// 					'uid' => $uid
// 			] );
// 			// return $this->redirect ( [
// 			// 'list',
// 			// 'uid' => $uid
// 			// ] );
// 		}
// 		$model = new Leavebill ();
// 		// print_r($model);
// 		$diff = $this->actionTimeDiff ( strtotime ( $request->post ( 'leaveStartTime' ) ), strtotime ( $request->post ( 'leaveEndTime' ) ) );

// 		$utils = new UtilsModel ();
// 		// $model->id = '6';
// 		$model->id = $utils->saveGetmaxNum ( 'QJDH', 11 );
// 		$model->userid = $request->post ( 'userid', $uid ); // $GLOBALS['uid']
// 		$model->leaveType = $request->post ( 'leaveType', '0' );
// 		$model->leaveStartTime = $request->post ( 'leaveStartTime', '0' );
// 		$model->leaveEndTime = $request->post ( 'leaveEndTime', '0' );
// 		$model->reason = $request->post ( 'reason', '0' );
// 		$model->approvalPerson = $request->post ( 'approvalPerson', '0' ); // id
// 		$model->remark = $request->post ( 'remark', '0' );
// 		$model->applyTime = date ( 'Y-m-d H:i:s' );
// 		$model->state = $request->post ( 'state', '1' );
// 		$model->username = $request->post ( 'username', '0' );
// 		$model->days = $diff;
// 		$model->dep = $request->post ( 'dep', $session->get ( 'department' ) );
// 		$model->spuser = $request->post ( 'spuser', '0' ); // name
// 		$model->tzuser = $request->post ( 'tzuser', '0' ); // name
// 		$model->tongzhi = $request->post ( 'tongzhi', '0' ); // id
// 		$model->token = $auth_token; // $GLOBALS['auth_token'];

// 		$workflowMode = new WorkflowModel ();
// 		$result = $workflowMode->saveStartProcess ( $model, $model->userid );
// 		// return 0;
// 		if ($result ['status'] == 'success') {
// 			if ($result ['model']->save ()) {
// 				if ($request->post ( 'approvalPerson' )) {
// 					$this->actionSendnotice ( $uid, $request->post ( 'approvalPerson' ) );
// 					return $this->redirect ( [
// 							'list',
// 							'uid' => $uid
// 					] );
// 					// return $this->actionList($uid);
// =======

			echo "请假时间段有重复！请重新输入！";
			return ;
// 			return $this->redirect ( [
// 					'list',
// 					'uid' => $uid
// 			] );
		}
			$model = new Leavebill ();
			// print_r($model);
			$diff = $this->actionTimeDiff ( strtotime ( $request->post ( 'leaveStartTime' ) ), strtotime ( $request->post ( 'leaveEndTime' ) ) );

			$utils = new UtilsModel ();
			// $model->id = '6';
			$model->id = $utils->saveGetmaxNum ( 'QJDH', 11 );
			$model->userid = $request->post ( 'userid', $uid ); // $GLOBALS['uid']
			$model->leaveType = $request->post ( 'leaveType', '0' );
			$model->leaveStartTime = $request->post ( 'leaveStartTime', '0' );
			$model->leaveEndTime = $request->post ( 'leaveEndTime', '0' );
			$model->reason = $request->post ( 'reason', '0' );
			$model->approvalPerson = $request->post ( 'approvalPerson', '0' ); // id
			$model->remark = $request->post ( 'remark', '0' );
			$model->applyTime = date ( 'Y-m-d H:i:s' );
			$model->state = $request->post ( 'state', '1' );
			$model->username = $request->post ( 'username', '0' );
			$model->days = $diff;
			$model->dep = $request->post ( 'dep', $session->get('department') );
			$model->spuser = $request->post ( 'spuser', '0' ); // name
			$model->tzuser = $request->post ( 'tzuser', '0' ); // name
			$model->tongzhi = $request->post ( 'tongzhi', '0' ); // id
			$model->token = $auth_token; // $GLOBALS['auth_token'];

			$workflowMode = new WorkflowModel ();
			$result = $workflowMode->saveStartProcess ( $model, $model->userid );
			// return 0;
			if ($result ['status'] == 'success') {
				if ($result ['model']->save ()) {
					if ($request->post ( 'approvalPerson' )) {
						$this->actionSendnotice ( $uid, $request->post ( 'approvalPerson' ) );
						return $this->redirect ( [
								'list',
								'uid' => $uid
						] );
						// return $this->actionList($uid);

// >>>>>>> b2e094b669866dfa80c52f2235d1dc302934629d
				} else {
					echo "审批人id为空";
					$this->actionList ( $uid );
				}
			} else {
				// return "保存数据失败!";
				return $this->renderFile( '@app/views/leavebill/error.php', [
						'result' => '4'
				] );
			}
		} else {
			return $this->renderFile( '@app/views/leavebill/error.php', [
					'result' => '5'
			] );
			// return "创建请假流程失败!";
		}
	}
	// 功能：计算两个时间戳之间相差的日时分秒
	// $begin_time 开始时间戳
	// $end_time 结束时间戳
	public function actionTimeDiff($begin_time, $end_time) {
		if ($begin_time < $end_time) {
			$starttime = $begin_time;
			$endtime = $end_time;
		} else {
			$starttime = $end_time;
			$endtime = $begin_time;
		}

		// 计算天数
		$timediff = $endtime - $starttime;
		$days = intval ( $timediff / 86400 );
		// 计算小时数
		$remain = $timediff % 86400;
		$hours = intval ( $remain / 3600 );
		// 计算分钟数
		$remain = $remain % 3600;
		$mins = intval ( $remain / 60 );
		// 计算秒数
		$secs = $remain % 60;
		$res = array (
				"day" => $days,
				"hour" => $hours,
				"min" => $mins,
				"sec" => $secs
		);

		if ($res ['day'] > 0) {
			$days = $res ['day'] . '天';
		} elseif ($res ['hour'] > 0) {
			$days = $res ['hour'] . '小时';
		} elseif ($res ['min'] > 0) {
			$days = $res ['min'] . '分钟';
		} elseif ($res ['sec'] > 0) {
			$days = $res ['sec'] . '秒';
		} else {
			$days = '0';
		}
		return $days;
	}

	// 开启流程
	public function actionStartProcessInstances($businessKey, $uid) {

		//  启动流程实例
		$header = array (
				"Authorization" => "Basic " . base64_encode ( "kermit:kermit" ),
				"content-type" => "application/json,charset=utf-8"
		);
		$curl->setHeaders ( $header );
		$params = [
				'processDefinitionId' => 'LeaveBill:1:2504',
				'businessKey' => $businessKey,
				'variables' => [
						[
								'name' => 'inputUser',
								'value' => $uid
						]
				]
		];
		$params = json_encode ( $params );
		print_r ( $params );
		$webService = 'http: // ' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances';
		$result = $curl->post ( $webService, $params );
		$result = json_decode ( $result );
		return $result;
	}
	public function actionQueryTask($params) {

		// 查询任务-请假申请状态
		$header = array (
				"Authorization" => "Basic " . base64_encode ( "kermit:kermit" ),
				"content-type" => "application/json,charset=utf-8"
		);
		$curl->setHeaders ( $header );

		$params = json_encode ( $params );
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/tasks';
		$result = $curl->post ( $webService, $params );
		$result = json_decode ( $result );
		return $result;
	}

	/**
	 * Deletes an existing Leavebill model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();

		return $this->redirect ( [
				'index'
		] );
	}
	public function actionCompleteTask($params, $taskId) {

		// 操作任务-完成任务-请假申请
		$header = array (
				"Authorization" => "Basic " . base64_encode ( "kermit:kermit" ),
				"content-type" => "application/json,charset=utf-8"
		);
		$curl->setHeaders ( $header );

		$params = json_encode ( $params );
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/tasks/' . $taskId;
		$result = $curl->post ( $webService, $params );
		$result = json_decode ( $result );
		return $result;
	}
	public function actionQueryProcessInstance() {

		//  查询流程实例
		$header = array (
				"Authorization" => "Basic " . base64_encode ( "kermit:kermit" ),
				"content-type" => "application/json,charset=utf-8"
		);
		$curl->setHeaders ( $header );
		$params = [
				'processDefinitionId' => 'LeaveBill:1:2504',

				'variables' => [
						[
								'name' => 'inputUser',
								'value' => '8@15',
								'operation' => 'equals'
						]
				]
		];
		$params = json_encode ( $params );
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/process-instances';
		$result = $curl->post ( $webService, $params );
		$result = json_decode ( $result );
		return $result;
	}
	public function actionShowProcessInstance($params) {

		//  显示流程实例列表
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances';

		// $params=['businessKey'=>'myBusinessKey'];
		// $params=json_decode($params);
		// $webService ='http://192.168.139.75:8080/activiti-rest/service/runtime/process-instances';
		$result = $curl->get ( $webService, $params );
		$result = json_decode ( $result );
		return $result;
	}
	public function actionAcquireProcessInstance($processInstanceId) {

		// 获得流程实例
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/' . $processInstanceId;
		$result = $curl->get ( $webService );
		$result = json_decode ( $result );
		return $result;
	}

	/**
	 * Updates an existing Leavebill model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate() {
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$uid = $request->get ( "uid", '0' );
		$id = $request->get ( "id" );
		// 待检查用户
		// if($uid=='0'){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		if ($session->has ( "department" ) && $session->has ( "name" )) {
			$username = $session->get ( 'department' ) . '_' . $session->get ( 'name' );
		}
		// $employee = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->one ();
		// print_r ( $employee->name );
		// return 0;
		// if (count ( $employee ) > 0) {
		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) )->toArray ();
		if ($dataDetail != null && count ( $dataDetail ) > 0) {
			return $this->renderFile ( '@app/views/leavebill/update.php', [
					'model' => $dataDetail,
					'uid' => $uid,
					'id' => $id,
					// 'username' => $employee->name
					'username' => $username
			] );
		} else {
			// 返回错误页面
			// echo "无此请假条";
			return $this->renderFile ( '@app/views/leavebill/update.php', [
					'result' => '6'
			] );
		}
		// } else {
		// echo "无此用户";
		// return;
		// }
	}

	// applyTime问题？？？
	public function actionUpdatestart() {
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		date_default_timezone_set ( 'PRC' );
		// 获取session中的变量值，以下用法是相同的：
		// $uid = $session->get ( 'uid' );
		$auth_token = $session->get ( 'auth_token' );

		$uid = $request->post ( 'uid', '0' );
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		// $model = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (! $model) {
		// echo "无此用户";
		// return;
		// }
		// $uid = $request->get ( 'uid' );

		$db = Yii::$app->db;
		// $params=['uid'=>$uid,'']
		// $db->createCommand()
		// $sql = "select * from leavebill where 'userid'=:uid and state in (1,2) and leaveEndTime>date('Y-m-d H:i:s)";
		$model1 = Leavebill::find ()->where ( [
				'userid' => $uid,
				'state' => [
						1,
						2,
						3
				]
		] )->andWhere ( [
				'>',
				'leaveEndTime',
				date ( 'Y-m-d H:i:s' )
		] )->asArray ()->all ();

		// echo "-----------------------------------------</br>";

		$tag = 0;
		// echo count ( $model1 );

		// 判断是否与已有的请假记录重复 ----------除去当前记录
		for($i = 0; $i < count ( $model1 ); $i ++) {

			if (($model1 [$i] ['id'] != $request->post ( 'id' )) && ! ($model1 [$i] ['leaveEndTime'] < $request->post ( 'leaveStartTime' ) || $model1 [$i] ['leaveStartTime'] > $request->post ( 'leaveEndTime' ))) {
				$tag = 1;
			}
		}
		if ($tag == 1) {
// 			echo "重复记录";
// 			return;
			echo '<script>alert("请假时间段有重复！");</script>';
			$username = $session->get ( 'department' ) . '_' . $session->get ( 'name' );
			// echo "请假时间段有重复！";
			// return ;
			return $this->renderFile ( '@app/views/leavebill/create.php', [
					'username' => $username,
					'uid' => $uid
			] );
			// return $this->redirect ( [
			// 'list',
			// // 'uid' => $model->userid
			// 'uid'=>$uid
			// ] );
		}

		$model = Leavebill::findOne ( $request->post ( 'id' ) );
		// var_dump($model);
		// 请假天数
		// $diff = $this->actionTimeDiff ( strtotime ( $request->post ( 'leaveStartTime' ) ), strtotime ( $request->post ( 'leaveEndTime' ) ) );
		// echo 'startTime'.$request->post ( 'leaveStartTime' ).'<br/>endTime'.$request->post ( 'leaveEndTime' ).'<br/>';
		$diff = $this->actionTimeDiff ( strtotime ( $request->post ( 'leaveStartTime' ) ), strtotime ( $request->post ( 'leaveEndTime' ) ) );
		// echo $diff.'<br/>';
		$utils = new UtilsModel ();

		$model->userid = $request->post ( 'userid', $uid ); // $GLOBALS['uid']
		$model->leaveType = $request->post ( 'leaveType', '0' );
		$model->leaveStartTime = $request->post ( 'leaveStartTime', '0' );
		// return 0;
		$model->leaveEndTime = $request->post ( 'leaveEndTime', '0' );
		$model->reason = $request->post ( 'reason', '0' );
		$model->approvalPerson = $request->post ( 'approvalPerson', '0' ); // id
		$model->remark = $request->post ( 'remark', '0' );
		$model->applyTime = date ( 'Y-m-d H:i:s' );
		$model->state = $request->post ( 'state', '1' );
		$model->username = $request->post ( 'username', '0' );
		$model->days = $diff;
		$model->dep = $request->post ( 'dep', $session->get ( 'department' ) );
		$model->spuser = $request->post ( 'spuser', '0' ); // name
		$model->tzuser = $request->post ( 'tzuser', '0' ); // name
		$model->tongzhi = $request->post ( 'tongzhi', '0' ); // id
		$model->token = $auth_token; // $GLOBALS['auth_token'];

		$workflowMode = new WorkflowModel ();
		$result = $workflowMode->updateStartLeaveBill ( $model );
		$this->actionSendnotice ( $uid, $request->post ( 'approvalPerson' ) );

		return $this->redirect ( [
				'list',
				'uid' => $model->userid
		] );
	}

	/**
	 * Displays detail infomation about leavebill.
	 * 详细
	 *
	 * @param
	 *        	@ id uid
	 * @return data
	 * @author fyq
	 */
	public function actionContent() {
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$uid = $request->get ( 'uid', '0' );
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		// $employee = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (count ( $employee ) <= 0) {
		// echo "无此用户";
		// return;
		// }
		$searchModel = new LeavebillSearch ();
		$workflowMode = new WorkflowModel ();
		// 查询当前用户的请假信息-

		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) )->toArray ();
		// <<<<<<< HEAD

		// $param=$dataDetail['userid'].$dataDetail['id'];
		// // $result=$this->actionAcquireProcessInstance($param);
		// $param=['basinessKey'=>$param];
		// $result=$this->actionShowProcessInstance($params);
		// $ProcessInstanceId=$result->data[0]->id;
		// //根据processInstanceId查询任务id

		// =======
		$leaveBillId = $dataDetail ['id'];
		$taskList = $workflowMode->findCommentByLeaveBillId ( $leaveBillId );
		// var_dump($taskList);
		// >>>>>>> basic/master
		return $this->renderFile ( '@app/views/leavebill/content.php', [
				'dataDetail' => $dataDetail,
				'taskList' => $taskList,
				// 'uid' => $request->get ( 'uid' )
				'uid' => $uid
		] );
	}

	/**
	 * Displays detail infomation about leavebill.
	 * 我的审批详细
	 *
	 * @param
	 *        	@ id uid
	 * @return data
	 * @author fyq
	 */
	public function actionContentsp() {
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$uid = $request->get ( 'uid', '0' );
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		// $employee = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (count ( $employee ) <= 0) {
		// echo "无此用户";
		// return;
		// }
		$searchModel = new LeavebillSearch ();
		$workflowMode = new WorkflowModel ();

		// 查询当前用户的请假信息-

		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) )->toArray ();
		$leaveBillId = $dataDetail ['id'];
		$taskList = $workflowMode->findCommentByLeaveBillId ( $leaveBillId );
		// var_dump($taskList);
		return $this->renderFile ( '@app/views/leavebill/contentsp.php', [
				'dataDetail' => $dataDetail,
				'taskList' => $taskList,
				// 'uid' => $request->get ( 'uid' )
				'uid' => $uid
		] );
	}

	// 获取用户信息
	public function actionGetUserInfo() {
		$session = Yii::$app->session;

		// print_r($_SERVER['HTTP_ACCEPT']);

		// $GLOBALS['uid']='3@15';
		// $params ['id'] = '46'; // 和轻应用有关
		// $params ['eid'] = 15; // explode ( "@",$uid ) [1] ;// explode ( "@", $GLOBALS['uid'] ) [1]; // 企业id可在uid中解析到，@ 符后面数字为eid。
		// // $params ['eid'] = '3';
		// $params ['title'] = '有新的请假通知';

		// $params ['url'] = 'http://' . $_SERVER ['HTTP_HOST'] . '/basic/web/index.php?r=leavebill/index&uid=&eguid=&auth_token=';
		$params ['user_id'] = $session->get ( 'uid' );
		$params ['query_id'] = $session->get ( 'uid' );
		$params ['auth_token'] = $session->get ( 'auth_token' ); // $GLOBALS['auth_token']
		$params ['api_key'] = $session->get ( 'api_key' );
		$webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=ldap.client.get.user.info";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );
		$result = json_decode ( $result );

		return $result;
	}

	/**
	 * Sendnotice.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionSendnotice($uid, $to_uid) {

		// print_r($_SERVER['HTTP_ACCEPT']);

		// $GLOBALS['uid']='3@15';
		$params ['id'] = '46'; // 和轻应用有关
		$params ['eid'] = 15; // explode ( "@",$uid ) [1] ;// explode ( "@", $GLOBALS['uid'] ) [1]; // 企业id可在uid中解析到，@ 符后面数字为eid。
		                      // $params ['eid'] = '3';
		$params ['title'] = '有新的请假通知';

		$params ['url'] = 'http://' . $_SERVER ['HTTP_HOST'] . '/basic/web/index.php?r=leavebill/index&uid=&eguid=&auth_token=';
		$params ['uids[0]'] = $to_uid;
		$params ['auth_token'] = Yii::$app->session->get ( 'auth_token' ); // $GLOBALS['auth_token']
		$params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
		$webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=lapp.notice";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );

		// echo "<pre>";
		// echo "参数</br>";
		// var_dump ( $params );
		// echo "结果</br>";
		// var_dump ( $result );

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

	/**
	 * Sendmessage.
	 *
	 * @param string $id
	 *        	被审批的请假条id
	 * @param string $to_uid
	 *        	通知人
	 * @return mixed
	 */
	public function actionSendmessage($model) {
		// $params ['id'] = '80';
		// $params ['eid'] = '15';
		// $params ['title'] = '新版上线了，请下载更新。';
		// $params ['url'] = 'http://uc.sipsys.com/lanou/html/lanou_down.html';
		// $params ['uids[0]'] = '8@15';
		// $params ['auth_token'] = '239d48513662381f07243c238145ed9d';
		// $params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
		// $webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=lapp.notice";
		// $curl = new CurlModel ();
		// $result = $curl->post ( $webService, $params );

		// $model=$this->findModel ( $id );
		// $model1=Leavebill::find()->all();
		// print_r($model1);
		// $id = 'QJDH00000000000'; // 函数参数--测试
		// $model = $this->findModel ( $id );
		// print_r($model);
		if ($model ['state'] == 2) {

			$to_uids = explode ( ",", $model ['tongzhi'] );

			// 请假天数
			// $diff = date_diff ( date_create ( $model ['leaveStartTime'] ), date_create ( $model ['leaveEndTime'] ) )->format ( "%R%a days" ) + 0;
			// print_r ( $diff );
			$diff = $model ['days'];

			// 请假起止时间
			$startdate = date ( "Y-m-d", strtotime ( $model ['leaveStartTime'] ) );
			$enddate = date ( "Y-m-d", strtotime ( $model ['leaveEndTime'] ) );

			for($i = 0; $i < count ( $to_uids ); $i ++) {

				$params ['to_uids[' . $i . ']'] = $to_uids [$i];
			}

			$params ['from_uid'] = '4@15'; // $model->userid;
			                               // $params['to_uids[0]'] = '8@15';
			                               // $params['to_uids[0]'] ="8@15";
			$params ['text'] = '[请假通知]	本人需请假' . $diff . '。时间:' . $startdate . '到' . $enddate . '。	望周知。';
			$params ['type'] = '0';
			$params ['auth_token'] = Yii::$app->session->get ( 'auth_token' ); // $model ->token;
			$params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
			$webService = "http://192.168.139.160/elgg/services/api/rest/json/?method=send.im.to.users";
			$curl = new CurlModel ();
			$result = $curl->post ( $webService, $params );

			echo "<pre>";
			echo "参数</br>";
			var_dump ( $params );
			echo "结果</br>";
			var_dump ( $result );
		} else {
			echo "此请假条未审批!";
		}

		// return $this->render ( 'view', [
		// 'model' => $this->findModel ( $id )
		// ] );
	}

	/**
	 * Displays a single Leavebill model.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', [
				'model' => $this->findModel ( $id )
		] );
	}

	/**
	 * Finds the Leavebill model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param string $id
	 * @return Leavebill the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Leavebill::findOne ( $id )) !== null) {
			return $model->toArray ();
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	public function actionMybill() {
		$request = Yii::$app->request;
		$page = $request->get ( 'page' );
		$applyTime = $request->get ( 'applyTime' );
		$pageSize = $request->get ( 'pageSize' );
		$dataApproval = LeavebillSearch::find ()->where ( [
				'userid' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$applyTime
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->offset ( $page * $pageSize )-> // 从第$page * $pageSize行开始返回数据
limit ( $pageSize )-> // 一次返回$pageSize行数据
asArray ()->all ();
		echo json_encode ( [
				'dataApproval' => $dataApproval
		] );
	}
	// <<<<< HEAD
	// <<
	// =======
	// public function actionMyapproval() {
	// $request = Yii::$app->request;
	// $page = $request->get ( 'page' );
	// $applyTime = $request->get ( 'applyTime' );
	// $pageSize = $request->get ( 'pageSize' );
	// $dataApproval = LeavebillSearch::find ()->where ( [
	// 'approvalPerson' => $request->get ( 'uid' )
	// ] )->andwhere ( [
	// '<',
	// 'applyTime',
	// $applyTime
	// ] )->orderBy ( [
	// 'applyTime' => SORT_DESC
	// ] )->offset ( $page * $pageSize )->limit ( $pageSize )->asArray ()->all ();
	// echo json_encode ( [
	// 'dataApproval' => $dataApproval
	// ] );
	// }
	// public function actionMore() {
	// $request = Yii::$app->request;
	// $pageSize = 4;
	// $curTime = date ( 'Y-m-d H:i:s' );

	// $searchModel = new LeavebillSearch ();
	// $panel1Total = LeavebillSearch::find ()->where ( [
	// 'userid' => $request->get ( 'uid' )
	// ] )->andwhere ( [
	// '<',
	// 'applyTime',
	// $curTime
	// ] )->count ();
	// $panel1TotalPage = ceil ( $panel1Total / $pageSize );
	// $panel2Total = LeavebillSearch::find ()->where ( [
	// 'approvalPerson' => $request->get ( 'uid' )
	// ] )->andwhere ( [
	// '<',
	// 'applyTime',
	// $curTime
	// ] )->count ();

	// $panel2TotalPage = ceil ( $panel2Total / $pageSize );
	// // echo "你好".$request->get( 'uid' );

	// if ($request->get ( 'uid' )) {
	// return $this->renderFile ( '@app/views/leavebill/list-more.php', [
	// 'pageSize' => $pageSize,
	// 'panel1Total' => $panel1Total,
	// 'panel1TotalPage' => $panel1TotalPage,
	// 'panel2Total' => $panel2Total,
	// 'panel2TotalPage' => $panel2TotalPage,
	// 'curTime' => "'" . $curTime . "'",
	// 'uid' => $request->get ( 'uid' )
	// ] );
	// } else {
	// return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [ ] );
	// }
	// <<<<<<< HEAD
	// }
	public function actionGiveup() {
		$workflowModel = new WorkflowModel ();
		$request = Yii::$app->request;
		$uid = $request->get ( 'uid', '0' );
		$session = Yii::$app->session;
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		// $employee = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (count ( $employee ) <= 0) {
		// echo "无此用户";
		// return;
		// }
		$leaveBillId = $request->get ( "id" );
		// $uid=$request->get("uid");
		$outcome = $request->get ( "outcome" );
		if (($model = Leavebill::findOne ( $leaveBillId )) !== null) {
			$workflowModel->saveSubmitTaskByLeaveBillId ( $model, $outcome );
			return $this->redirect ( [
					'list',
					'uid' => $uid
			] );
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	public function actionSaveapproval() {
		$workflowModel = new WorkflowModel ();
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$uid = $request->post ( 'uid', '0' );
		// if($uid==0){
		if ($session->has ( "uid" ) && $session->get ( "uid" ) != '0') {
			$uid = $session->get ( 'uid' );
		} else {
			// echo "用户不存在";
			// return;
			return $this->renderFile ( '@app/views/leavebill/error.php', [
					// 'uid' => $uid
					'result' => '1'
			] );
		}
		// }
		// $employee = Employee::find ()->where ( [
		// 'username' => $uid
		// ] )->asArray ()->all ();
		// if (count ( $employee ) <= 0) {
		// echo "无此用户";
		// return;
		// }
		$leaveBillId = $request->post ( 'id' );
		$outcome = $request->post ( 'outcome' );
		// <<<<<<< HEAD
		// '<br/>';
		// $uid=$request->post('uid');

		// =======
		// >>>>>>> refs/remotes/basic/master
		$comment = $request->post ( 'comment' );
		if (($model = Leavebill::findOne ( $leaveBillId )) !== null) {
			// <<<<<<< HEAD

			// //print_r($leaveBill);
			// //echo $leaveBill['id'];
			// //$key="LeaveBill";
			// //$businessKey=$key.'.'.$leaveBillId;

			// $workflowModel->saveSubmitTaskByLeaveBillId($model,$outcome,$uid,$comment);

			// //return $this->renderFile ( '@app/views/leavebill/index.php',['uid'=>$uid] );
			// =======
			$workflowModel->saveSubmitTaskByLeaveBillId ( $model, $outcome, $comment );
			if ($outcome == '1') {
				$this->actionSendmessage ( $model );
			}
			// 通知
			// >>>>>>> refs/remotes/basic/master
			return $this->redirect ( [
					'list',
					'uid' => $uid
			] );
			// <<<<<<< HEAD

			// //$leaveBillId=$request->get('id');
			// =======
			// >>>>>>> refs/remotes/basic/master
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	// >>>>>>> basic/master
	public function actionMyapproval() {
		$request = Yii::$app->request;
		$page = $request->get ( 'page' );
		$applyTime = $request->get ( 'applyTime' );
		$pageSize = $request->get ( 'pageSize' );
		$dataApproval = LeavebillSearch::find ()->where ( [
				'approvalPerson' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$applyTime
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->offset ( $page * $pageSize )->limit ( $pageSize )->asArray ()->all ();
		echo json_encode ( [
				'dataApproval' => $dataApproval
		] );
	}
	public function actionMore() {
		$request = Yii::$app->request;
		date_default_timezone_set ( 'PRC' );
		$pageSize = 8;
		$curTime = date ( 'Y-m-d H:i:s' );

		$searchModel = new LeavebillSearch ();
		$panel1Total = LeavebillSearch::find ()->where ( [
				'userid' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$curTime
		] )->count ();
		$panel1TotalPage = ceil ( $panel1Total / $pageSize );
		$panel2Total = LeavebillSearch::find ()->where ( [
				'approvalPerson' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$curTime
		] )->count ();

		$panel2TotalPage = ceil ( $panel2Total / $pageSize );
		$dataBill = LeavebillSearch::find ()->where ( [
				'userid' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$curTime
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->offset ( 0 )->limit ( $pageSize )->asArray ()->all ();
		$dataApproval = LeavebillSearch::find ()->where ( [
				'approvalPerson' => $request->get ( 'uid' )
		] )->andwhere ( [
				'<',
				'applyTime',
				$curTime
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->offset ( 0 )->limit ( $pageSize )->asArray ()->all ();
		// echo "你好".$request->get( 'uid' );

		if ($request->get ( 'uid' )) {
			return $this->renderFile ( '@app/views/leavebill/list-more.php', [
					'pageSize' => $pageSize,
					'panel1Total' => $panel1Total,
					'panel1TotalPage' => $panel1TotalPage,
					'panel2Total' => $panel2Total,
					'panel2TotalPage' => $panel2TotalPage,
					'curTime' => "'" . $curTime . "'",
					'dataBill' => json_encode ( $dataBill ),
					'dataApproval' => json_encode ( $dataApproval ),
					'uid' => $request->get ( 'uid' )
			] );
		} else {
			return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [ ] );
		}
	}
	public function actionDeployments() {
		return $this->renderFile ( '@app/views/leavebill/deployments.php' );
	}

	/**
	 * Sendnotice.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionFileform() {
		// echo "2222";
		return $this->renderFile ( '@app/views/leavebill/fileform.php' );
		// echo "2222";
		// $this->renderFile("file_form");
	}
	public function actionUpload() {
		$employee = Employee::getDb ();
		var_dump ( $employee );

		// $model = new UploadForm();

		// if (Yii::$app->request->isPost) {
		// $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
		// print_r($model);
		// if ($model->upload()) {
		// // 文件上传成功
		// echo "文件上传成功";
		// return "文件上传成功";
		// }else {
		// echo "文件上传失败";
		// }
		// }

		// return $this->renderPartial('upload', ['model' => $model]);

		// print_r(readfile("d:/leavebill.bpmn20.xml")) ;
	}

	/**
	 * php 发送流文件
	 *
	 * @param String $url
	 *        	接收的路径
	 * @param String $file
	 *        	要发送的文件
	 * @return boolean
	 */
	public function actionSendStreamFile($url, $file) {
		if (file_exists ( $file )) {

			$opts = array (
					'http' => array (
							'method' => 'POST',
							'header' => [
									'content-type:multipart/form-data',
									'Authorization:Basic ' . base64_encode ( "kermit:kermit" )
							],
							'content' => file_get_contents ( $file )
					)
			);

			$context = stream_context_create ( $opts );
			$response = file_get_contents ( $url, false, $context );
			$ret = json_decode ( $response, true );
			return $ret ['success'];
		} else {
			return false;
		}
	}

	/**
	 * Sendnotice.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionActivitirest() {

		// Yii::$app->request->post();
		// var_dump( Yii::$app->request->bodyParams);
		$curl = new CurlModel ();
		$params = '';

		$Authorization = array (
				"Authorization" => "Basic " . base64_encode ( "kermit:kermit" )
		);
		$curl->setHeaders ( $Authorization );

		// $webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/identity/groups';

		/**
		 * **************************** 部署 ***********************************************
		 */

		// 部署列表
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments';
		// $webService ='http://192.168.139.75:8080/activiti-rest/service/repository/deployments';
		$result = $curl->get ( $webService );

		// 获得一个部署
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments/20';
		// $result=$curl->get($webService);

		// 删除一个部署
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments/54';
		// $webService ='http://192.168.139.75:8080/activiti-rest/service/repository/deployments/40';
		// $result=$curl->delete($webService);

		// 列出部署内的资源
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments/50/resources';
		// $result=$curl->get($webService);

		// 获取部署内的资源
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments/46/resources/leaveBill02.png';
		// $result=$curl->get($webService);

		// 获取部署内的资源内容
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/deployments/50/resourcedata/leaveBill02.bpmn20.xml';
		// $result=$curl->get($webService);

		/**
		 * **************************** 流程定义 ***********************************************
		 */

		// 流程定义列表
		$webService = 'http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions';
		$result = $curl->get ( $webService );

		// 获得一个流程定义
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:49';
		// $result=$curl->get($webService);

		//  更新流程定义的分类
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:49';
		// $result=$curl->put($webService);

		// 获得一个流程定义的资源内容
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:49/resourcedata';
		// $result=$curl->get($webService);

		//  获得流程定义的BPMN模型
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:49/model';
		// $result=$curl->get($webService);

		// 暂停流程定义
		// $params=array('action'=>'suspend','includeProcessInstances'=>'false');
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:2504';
		// $result=$curl->put($webService,$params);

		// 激活流程定义
		// $Authorization=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json");
		// $curl->setHeaders($Authorization);
		// $params=array('action'=>'activate','includeProcessInstances'=>'true');
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:43';
		// $result=$curl->put($webService,$params);

		// 获得流程定义的所有候选启动者
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:2504/identitylinks';
		// $result=$curl->get($webService);

		// 为流程定义添加一个候选启动者
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:2504/identitylinks';
		// $params=['user'=>'kermit'];
		// $params=json_encode($params);
		// $result=$curl->post($webService,$params);

		//  删除流程定义的候选启动者
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:2504/identitylinks/users/kermit';
		// $result=$curl->delete($webService);

		//  获得流程定义的一个候选启动者
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/process-definitions/LeaveBill:1:2504/identitylinks/users/kermit';
		// $result=$curl->get($webService);

		/**
		 * **************************** 模型 ***********************************************
		 */

		//  获得模型列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models';
		// $result=$curl->get($webService);

		//  获得一个模型
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models/37';
		// $result=$curl->get($webService);

		//  获得模型的可编译源码
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models/37/source';
		// $result=$curl->get($webService);

		//  获得模型的附加可编辑源码
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models/37/source-extra';
		// $result=$curl->get($webService);

		//  获得模型列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models';
		// $result=$curl->get($webService);

		//  获得模型列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/repository/models';
		// $result=$curl->get($webService);

		/**
		 * **************************** 流程实例 ***********************************************
		 */

		//  启动流程实例
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json");
		// $curl->setHeaders($header);
		// $params=['processDefinitionId'=>'LeaveBill:1:43',
		// 'businessKey'=>'myBusinessKey',
		// 'variables'=>[[
		// 'name'=>'inputUser',
		// 'value'=>'8@15'
		// ]]
		// ];
		// $params=json_encode($params);
		// print_r($params);
		// $webService ='http://127.0.0.1:8080/activiti-rest/service/runtime/process-instances';

		// // $webService ='http://192.168.139.75:8080/activiti-rest/service/runtime/process-instances';
		// $result=$curl->post($webService,$params);

		//  显示流程实例列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances';

		// $params=['businessKey'=>'myBusinessKey'];
		// // $params=json_decode($params);
		// // $webService ='http://192.168.139.75:8080/activiti-rest/service/runtime/process-instances';
		// $result=$curl->get($webService);

		//  显示历时流程实例列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/history/historic-process-instances';

		// $params=['businessKey'=>'myBusinessKey'];
		// // $params=json_decode($params);
		// // $webService ='http://192.168.139.75:8080/activiti-rest/service/runtime/process-instances';
		// $result=$curl->get($webService);

		//  获得历史流程实例
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/ history/historic-process-instances/2661';
		// $result=$curl->get($webService);

		//  获得流程实例
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2525';
		// $result=$curl->get($webService);

		//  删除流程实例
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/112';
		// $result = json_decode($result);
		// for($i1=0;$i1<7;$i1++){
		// $webService ='http://192.168.139.75:8080/activiti-rest/service/runtime/process-instances/'.$result->data[$i1]->id;
		// $curl->delete($webService);
		// }

		//  激活或挂起流程实例
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['action'=>'suspend'];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553';
		// $result=$curl->put($webService);

		//  查询流程实例
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json");
		// $curl->setHeaders($header);
		// $params=[
		// 'processDefinitionKey'=>'LeaveBill',
		// // 'id'=>'2568',

		// // 'variables'=>[[
		// // 'name'=>'inputUser',
		// // 'value'=>'8@15',
		// // 'operation' => 'equals'

		// // ]
		// // ]
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/process-instances';

		// // $webService ='http://192.168.139.75:8080/activiti-rest/service/query/process-instances';
		// $result=$curl->post($webService,$params);

		//   获得流程实例的流程图
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2586';
		// $result=$curl->get($webService);

		//  获得流程实例的参与者
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/identitylinks';
		// $result=$curl->get($webService);

		// .......  为流程实例添加一个参与者
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['userId'=>'john',
		// 'type'=>'participant'
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/identitylinks';
		// $result=$curl->post($webService,$params);

		//  列出流程实例的变量
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/variables';
		// $result=$curl->get($webService);

		// 获得流程实例的一个变量
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/variables/inputUser';
		// $result=$curl->get($webService);

		// 创建（或更新）流程实例变量 post
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=[['name'=>'intProcVar',
		// // 'type'=>'integer',
		// 'value'=>'123'
		// ]];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/variables';
		// $result=$curl->post($webService,$params);

		// 创建（或更新）流程实例变量 put
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=[['name'=>'intProcVar',
		// // 'type'=>'integer',
		// 'value'=>'123'
		// ]];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/variables';
		// $result=$curl->put($webService,$params);

		//  更新一个流程实例变量
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['name'=>'intProcVar',
		// // 'type'=>'integer',
		// 'value'=>'1234'
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/process-instances/2553/variables/intProcVar';
		// $result=$curl->put($webService,$params);

		/**
		 * ******************************* 任务 ************************************************
		 */

		// 任务列表
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/tasks';
		// // $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/tasks';
		// $result=$curl->get($webService);

		// 获取任务
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/tasks/2567';
		// $result=$curl->get($webService);

		// 获取任务
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/history/historic-task-instances';
		// $result=$curl->get($webService);

		// 查询任务-请假申请状态
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json;charset=UTF8");
		// $curl->setHeaders($header);
		// $params=[
		// // 'name'=>'请假申请',
		// // 'assignee'=>'8@15',
		// 'processInstanceId'=>'2676',
		// // 'type'=>'integer',
		// // 'value'=>'1234'
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/tasks';
		// $result=$curl->post($webService,$params);

		// 查询任务-审批状态
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['name'=>'审批',
		// 'assignee'=>'8@15'
		// // 'type'=>'integer',
		// // 'value'=>'1234'
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/query/tasks';
		// $result=$curl->post($webService,$params);

		// 操作任务-完成任务-请假申请
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['action'=>'complete',
		// 'variables'=>[[
		// 'name'=>'isAbandon',
		// 'type'=>'string',
		// 'value'=>'0'],
		// [
		// 'name'=>'approvalPerson',
		// 'type'=>'string',
		// 'value'=>'4@15'
		// ]]
		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/tasks/2591';
		// $result=$curl->post($webService,$params);

		// 操作任务-完成任务-审批
		// $header=array("Authorization"=>"Basic ".base64_encode("kermit:kermit"),"content-type"=>"application/json,charset=utf-8");
		// $curl->setHeaders($header);
		// $params=['action'=>'complete',
		// 'variables'=>[[
		// 'name'=>'outcome',
		// 'type'=>'string',
		// 'value'=>'1']]

		// ];
		// $params=json_encode($params);
		// $webService ='http://' . $_SERVER ['HTTP_HOST'] . ':8080/activiti-rest/service/runtime/tasks/2582';
		// $result=$curl->post($webService,$params);

		$result = json_decode ( $result );

		// echo $result->data[0]->id;

		// echo $result->id;

		echo "<pre>";
		echo "参数</br>";
		var_dump ( $params );
		echo "结果</br>";
		var_dump ( $result );
		print_r ( $result );
		// echo ($result);

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
