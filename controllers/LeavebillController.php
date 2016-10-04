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

/**
 * LeavebillController implements the CRUD actions for Leavebill model.
 */
class LeavebillController extends Controller {
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
	 * index
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionIndex() {


		// print_r($_SERVER['HTTP_ACCEPT']);
		// echo "</br>";
		// echo $_SERVER['HTTP_ACCEPT'];
		// echo "</br>";
		// echo $_SERVER['SCRIPT_FILENAME'];
		// echo "</br>";
		// echo $_SERVER['SERVER_ADDR'];
		// echo "</br>";
		// echo $_SERVER['SERVER_NAME'];
		// echo "</br>";

		// echo $_SERVER['SERVER_NAME'];
		$request = Yii::$app->request;
		// $GLOBALS ['auth_token'] = $request->queryParams ['auth_token'];
		$uid = $request->queryParams ['uid'];

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
	public function actionList($uid) {
		$customers = Employee::find ()->where ( [
				// 'username'=> '3@15'
				'username' => $uid
		] )->asArray ()->all ();

		if ($customers) {

			$searchModel = new LeavebillSearch ();
			// $dataProvider = $searchModel->search ( $request->queryParams )->asArray();

			// 查询当前用户的请假信息---未被审核的
			$limit =array();
			$limit[0] = 3;
			$limit[1]=3;
			$limit[2]=5;
			$limit[3]=3;

			$dataDisagree = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'userid' => $uid,
					'state' => '1'
			] )
			->limit ( $limit[0] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// 查询当前用户的请假信息---已同意
			$dataAgree = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'userid' => $uid,
					'state' => '2'
			] )->limit ( $limit[1] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// 查询需要当前用户审批的请假信息--待审批
			$dataDisapproval = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'approvalPerson' => $uid,
					'state' => '1'
			] )->limit ( $limit[2] )->orderBy ( [
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
			] )->limit ( $limit[3] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// print_r ( $dataDisagree );
			// echo "</br>";
			// print_r ( $dataAgree );echo "</br>";
			// print_r ( $dataDisapproval );echo "</br>";
			// print_r ( $dataApproval );

			return $this->renderFile ( '@app/views/leavebill/list.php', [
					'dataDisagree' => $dataDisagree,
					'dataAgree' => $dataAgree,
					'dataDisapproval' => $dataDisapproval,
					'dataApproval' => $dataApproval,
					'uid' => $uid
			] );
			echo $uid;
		} else {
			echo "用户不存在";
		}
	}

	/**
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionCreate() {
		$uid = Yii::$app->request->get ( 'uid' );

		$model = Employee::find ()->where ( [
				// 'username'=> '3@15'
				'username' => $uid
		] )->asArray ()->all ();

		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		if ($model) {
			return $this->renderFile ( '@app/views/leavebill/create.php', [
					'model' => $model,
					'uid' => $uid
			] );
		} else { // echo "无此用户";
			return $this->renderFile ( '@app/views/leavebill/create.php', [
					'model' => $model,
					'uid' => $uid
			] );
		}
		// }
	}
	public function actionWhere() {

		// $uid = Yii::$app->request->get ( 'uid' );
		$posts = Yii::$app->db->createCommand ( 'SELECT * FROM leavebill where userid = :uid and id > :id and applyTime < :applyTime' )->bindValue ( ':uid', '8@15' )->bindValue ( ':id', 502 )->bindValue ( ':applyTime', date ( 'Y-m-d H:i:s' ) )->queryAll ();

		// $model = Leavebill::find ()->where(['>','id','500'])->asArray()->all();

		// $model->andWhere([ 'leaveType'=>'1']);

		print_r ( $posts );

		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		// if ($model) {
		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		// 'model' => $model,
		// 'uid' => $uid
		// ] );
		// } else { // echo "无此用户";
		// return $this->renderFile ( '@app/views/leavebill/create.php', [
		// 'model' => $model,
		// 'uid' => $uid
		// ] );
	}
	// }

	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionSave() {
		// $model = new Leavebill ();
		$request = Yii::$app->request;
		$uid = $request->get ( 'uid' );
		// $uid = $request->get ( 'uid' );
		$model1 = Leavebill::find ()->where ( [
				'userid' => $uid
		] )->asArray ()->all ();

		echo "-----------------------------------------</br>";

		$tag = 0;
		// echo count ( $model1 );

		for($i = 0; $i < count ( $model1 ); $i ++) {

			if ($model1 [$i] ['leaveEndTime'] > $request->get ( 'leaveStartTime' ) && $request->get ( 'leaveStartTime' ) <= date ( 'Y-m-d H:i:s' )) {

				// $tag = 1;
			}
		}
		if ($tag == 0) {
			$model = new Leavebill ();
			// print_r($model);

			$diff = date_diff ( date_create ( $request->get ( 'leaveStartTime' ) ), date_create ( $request->get ( 'leaveEndTime' ) ) )->format ( "%R%a days" ) + 0;

			// $model->userid = $request->get ( 'userid', '0' ); // $GLOBALS['uid']

			// $model->id = '6';

			echo $model->userid = $request->get ( 'userid', $uid ); // $GLOBALS['uid']
			echo $model->leaveType = $request->get ( 'leaveType', '0' );
			$model->leaveStartTime = $request->get ( 'leaveStartTime', '0' );
			$model->leaveEndTime = $request->get ( 'leaveEndTime', '0' );
			echo $model->reason = $request->get ( 'reason', '0' );
			$model->approvalPerson = $request->get ( 'approvalPerson', '0' ); // id
			echo $model->remark = $request->get ( 'remark', '0' );
			$model->applyTime = date ( 'Y-m-d H:i:s' );
			$model->state = $request->get ( 'state', '1' );
			$model->username = $request->get ( 'username', '0' );
			$model->days = $diff;
			$model->dep = $request->get ( 'dep', '0' );
			$model->spuser = $request->get ( 'spuser', '0' ); // name
			$model->tzuser = $request->get ( 'tzuser', '0' ); // name
			$model->tongzhi = $request->get ( 'tongzhi', '0' ); // id
			$model->token = $request->get ( 'token', '0' ); // $GLOBALS['auth_token'];

			echo "***********************************</br>";
			$model->save ();

			// print_r($model);
			// echo "保存成功";
			if ($request->get ( 'approvalPerson' )) {

				// $this->actionSendnotice ( $uid,$request->get ( 'approvalPerson' ) );
				return $this->redirect ( [
						'list',
						'uid' => $uid
				] );
				// return $this->actionList($uid);
			} else {
				echo "审批人id为空";
				$this->actionList ( $uid );
			}
		} else {
			echo "开始时间小于历史请假结束时间！";
		}
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

	/**
	 * Updates an existing Leavebill model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id ); // $id为请假条记录id

		if ($model->load ( Yii::$app->request->get () ) && $model->save ()) {
			return $this->redirect ( [
					'view',
					'id' => $model->id
			] );
		} else {
			return $this->render ( 'update', [
					'model' => $model
			] );
		}
	}

	/**
	 * Displays more data.
	 *
	 * @param
	 *
	 * @return mixed
	 * @author fyq
	 */
	// public function actionMore() {
	// $request = Yii::$app->request;

	// $searchModel = new LeavebillSearch ();

	// // echo "你好".$request->get( 'uid' );

	// if ($request->get ( 'uid' )) {

	// // 查询当前用户的请假信息-
	// $dataUserLeavebill = LeavebillSearch::find ()->where ( [

	// 'userid' => $request->get ( 'uid' )
	// ] )->orderBy ( [
	// 'applyTime' => SORT_DESC
	// ] )->asArray ()->all ();

	// // 查询需要当前用户审批的请假信息--已审批
	// $dataApproval = LeavebillSearch::find ()->where ( [
	// 'approvalPerson' => $request->get ( 'uid' )
	// ] )->orderBy ( [
	// 'applyTime' => SORT_DESC
	// ] )->asArray ()->all ();

	// return $this->renderFile ( '@app/views/leavebill/list-more.php', [
	// 'approvalPerson' => $dataUserLeavebill,
	// 'dataApproval' => $dataApproval,
	// 'uid' => $request->get ( 'uid' )
	// ] );
	// } else {
	// return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [ ] );
	// // 'approvalPerson' => $dataUserLeavebill,
	// // 'dataApproval' => $dataApproval,
	// // 'uid' => $request->get ( 'uid' )
	// }
	// }

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

		$searchModel = new LeavebillSearch ();

		// 查询当前用户的请假信息-

		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) )->toArray ();

		return $this->renderFile ( '@app/views/leavebill/content.php', [
				'dataDetail' => $dataDetail,
				'uid' => $request->get ( 'uid' )
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

		$searchModel = new LeavebillSearch ();

		// 查询当前用户的请假信息-

		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) )->toArray ();

		return $this->renderFile ( '@app/views/leavebill/contentsp.php', [
				'dataDetail' => $dataDetail,
				'uid' => $request->get ( 'uid' )
		] );
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
		$params ['auth_token'] = '239d48513662381f07243c238145ed9d'; // $GLOBALS['auth_token']
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
	public function actionSendmessage() {
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
		$id = 'QJDH00000000000'; // 函数参数--测试
		$model = $this->findModel ( $id );
		// print_r($model);
		if ($model ['state'] == 2) {

			$to_uids = explode ( ",", $model ['tongzhi'] );

			// 请假天数
			$diff = date_diff ( date_create ( $model ['leaveStartTime'] ), date_create ( $model ['leaveEndTime'] ) )->format ( "%R%a days" ) + 0;
			print_r ( $diff );

			// 请假起止时间
			$startdate = date ( "Y-m-d", strtotime ( $model ['leaveStartTime'] ) );
			$enddate = date ( "Y-m-d", strtotime ( $model ['leaveEndTime'] ) );

			for($i = 0; $i < count ( $to_uids ); $i ++) {

				$params ['to_uids[' . $i . ']'] = $to_uids [$i];
			}

			$params ['from_uid'] = '4@15'; // $model->userid;
			                               // $params['to_uids[0]'] = '8@15';
			                               // $params['to_uids[0]'] ="8@15";
			$params ['text'] = '[请假通知]	本人需请假' . $diff . '天。时间:' . $startdate . '到' . $enddate . '。	望周知。';
			$params ['type'] = '0';
			$params ['auth_token'] = '239d48513662381f07243c238145ed9d'; // $model ->token;
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
		] )->offset ( $page * $pageSize )//从第$page * $pageSize行开始返回数据
		->limit ( $pageSize ) // 一次返回$pageSize行数据
		->asArray ()
		->all ();
		echo json_encode ( [
				'dataApproval' => $dataApproval
		] );
	}
// 	public function actionMyapproval() {
// 		$request = Yii::$app->request;
// 		$page = $request->get ( 'page' );
// 		$applyTime = $request->get ( 'applyTime' );
// 		$pageSize = $request->get ( 'pageSize' );
// 		$dataApproval = LeavebillSearch::find ()->where ( [
// 				'approvalPerson' => $request->get ( 'uid' )
// 		] )->andwhere ( [
// 				'<',
// 				'applyTime',
// 				$applyTime
// 		] )->orderBy ( [
// 				'applyTime' => SORT_DESC
// 		] )->offset ( $page * $pageSize )->limit ( $pageSize )->asArray ()->all ();
// 		echo json_encode ( [
// 				'dataApproval' => $dataApproval
// 		] );
// 	}
// 	public function actionMore() {
// 		$request = Yii::$app->request;
// 		$pageSize = 4;
// 		$curTime = date ( 'Y-m-d H:i:s' );

// 		$searchModel = new LeavebillSearch ();
// 		$panel1Total = LeavebillSearch::find ()->where ( [
// 				'userid' => $request->get ( 'uid' )
// 		] )->andwhere ( [
// 				'<',
// 				'applyTime',
// 				$curTime
// 		] )->count ();
// 		$panel1TotalPage = ceil ( $panel1Total / $pageSize );
// 		$panel2Total = LeavebillSearch::find ()->where ( [
// 				'approvalPerson' => $request->get ( 'uid' )
// 		] )->andwhere ( [
// 				'<',
// 				'applyTime',
// 				$curTime
// 		] )->count ();

// 		$panel2TotalPage = ceil ( $panel2Total / $pageSize );
// 		// echo "你好".$request->get( 'uid' );

// 		if ($request->get ( 'uid' )) {
// 			return $this->renderFile ( '@app/views/leavebill/list-more.php', [
// 					'pageSize' => $pageSize,
// 					'panel1Total' => $panel1Total,
// 					'panel1TotalPage' => $panel1TotalPage,
// 					'panel2Total' => $panel2Total,
// 					'panel2TotalPage' => $panel2TotalPage,
// 					'curTime' => "'" . $curTime . "'",
// 					'uid' => $request->get ( 'uid' )
// 			] );
// 		} else {
// 			return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [ ] );
// 		}
// <<<<<<< HEAD
// 	}

		public function actionMyapproval() {
			$request = Yii::$app->request;
			$page=$request->get('page');
			$applyTime=$request->get('applyTime');
			$pageSize=$request->get('pageSize');
			$dataApproval = LeavebillSearch::find()->where(['approvalPerson' => $request->get ( 'uid' )])->andwhere(['<','applyTime',$applyTime])->orderBy (['applyTime' => SORT_DESC])->offset ($page*$pageSize )->limit ( $pageSize )->asArray()->all ();
			echo json_encode(['dataApproval'=>$dataApproval]);

		}

		public function actionMore() {
			$request = Yii::$app->request;
			$pageSize=8;
			$curTime=date ( 'Y-m-d H:i:s' );

			$searchModel = new LeavebillSearch ();
			$panel1Total=LeavebillSearch::find()->where(['userid'=>$request->get('uid')])->andwhere(['<','applyTime',$curTime])->count();
			$panel1TotalPage=ceil($panel1Total/$pageSize);
			$panel2Total=LeavebillSearch::find()->where(['approvalPerson' => $request->get ( 'uid' )])->andwhere(['<','applyTime',$curTime])->count();

			$panel2TotalPage=ceil($panel2Total/$pageSize);
			$dataBill = LeavebillSearch::find()->where(['userid'=>$request->get('uid')])->andwhere(['<','applyTime',$curTime])->orderBy (['applyTime' => SORT_DESC])->offset (0 )->limit ( $pageSize )->asArray()->all ();
			$dataApproval = LeavebillSearch::find()->where(['approvalPerson' => $request->get ( 'uid' )])->andwhere(['<','applyTime',$curTime])->orderBy (['applyTime' => SORT_DESC])->offset (0 )->limit ( $pageSize )->asArray()->all ();
			// echo "你好".$request->get( 'uid' );

			if ($request->get ( 'uid' )) {
				return $this->renderFile ( '@app/views/leavebill/list-more.php', [
						'pageSize'=>$pageSize,
						'panel1Total' => $panel1Total,
						'panel1TotalPage' => $panel1TotalPage,
						'panel2Total' => $panel2Total,
                        'panel2TotalPage' => $panel2TotalPage,
						'curTime'=>"'".$curTime."'",
						'dataBill'=>json_encode($dataBill),
						'dataApproval'=>json_encode($dataApproval),
						'uid' => $request->get ( 'uid' )
				] );
			} else {
				return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [ ] );
			}
		}

}
