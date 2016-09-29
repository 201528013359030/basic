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
	 * Lists all Leavebill models.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionIndex() {
		$request = Yii::$app->request;
		$customers = Employee::find ()->where ( [
				// 'username'=> '3@15'
				'username' => $request->queryParams ['uid']
		] )->asArray ()->all ();

		if ($customers) {

			$searchModel = new LeavebillSearch ();
			// $dataProvider = $searchModel->search ( $request->queryParams )->asArray();

			// 查询当前用户的请假信息---未同意
			$dataDisagree = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'userid' => $request->queryParams ['uid'],
					'state' => [
							1,
							3,
							4
					]
			] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// 查询当前用户的请假信息---已同意
			$dataAgree = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'userid' => $request->queryParams ['uid'],
					'state' => '2'
			] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// 查询需要当前用户审批的请假信息--待审批
			$dataDisapproval = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'approvalPerson' => $request->queryParams ['uid'],
					'state' => [
							1,
							4
					]
			] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

			// 查询需要当前用户审批的请假信息--已审批
			$dataApproval = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'approvalPerson' => $request->queryParams ['uid'],
					'state' => [
							2,
							3
					]
			] )->orderBy ( [
					'applyTime' => SORT_DESC
			] )->asArray ()->all ();

// 			print_r ( $dataDisagree );
// 			echo "</br>";
			// print_r ( $dataAgree );echo "</br>";
			// print_r ( $dataDisapproval );echo "</br>";
			// print_r ( $dataApproval );

			return $this->renderFile ( '@app/views/leavebill/list.php', [
					'dataDisagree' => $dataDisagree,
					'dataAgree' => $dataAgree,
					'dataDisapproval' => $dataDisapproval,
					'dataApproval' => $dataApproval,
					'uid' => $request->queryParams ['uid']
			] );
		} else {
			echo "用户不存在";
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
	public function actionMore() {
		$request = Yii::$app->request;

		$searchModel = new LeavebillSearch ();



		//echo "你好".$request->get( 'uid' );

		if($request->get ( 'uid' )){

		// 查询当前用户的请假信息-
		$dataUserLeavebill = LeavebillSearch::find ()->where ( [

				'userid' => $request->get ( 'uid' )
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();

		// 查询需要当前用户审批的请假信息--已审批
		$dataApproval = LeavebillSearch::find ()->where ( [
				'approvalPerson' => $request->get ( 'uid' )
		] )->orderBy ( [
				'applyTime' => SORT_DESC
		] )->asArray ()->all ();

		// print_r ( $dataDisagree );echo "</br>";
		// print_r ( $dataAgree );echo "</br>";
		// print_r ( $dataDisapproval );echo "</br>";
		// print_r ( $dataApproval );

		return $this->renderFile ( '@app/views/leavebill/list-more.php', [
				'approvalPerson' => $dataUserLeavebill,
				'dataApproval' => $dataApproval,
				'uid' => $request->get ( 'uid' )
		] );
		}
		else{
			return $this->renderFile ( '@app/views/leavebill/list-empty-error.php', [
// 					'approvalPerson' => $dataUserLeavebill,
// 					'dataApproval' => $dataApproval,
// 					'uid' => $request->get ( 'uid' )
			] );
		}
	}

	/**
	 * Displays detail infomation about leavebill.
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

		$dataDetail = LeavebillSearch::findOne ( $request->get ( 'id' ) );

		return $this->renderFile ( '@app/views/leavebill/content.php', [
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
	public function actionSendnotice() {
		$params ['id'] = '80';
		$params ['eid'] = '3';
		$params ['title'] = '新版上线了，请下载更新。';
		$params ['url'] = 'http://uc.sipsys.com/lanou/html/lanou_down.html';
		$params ['uids[0]'] = '3@3';
		$params ['auth_token'] = '239d48513662381f07243c238145ed9d';
		$params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
		$webService = "http://192.168.139.162/elgg/services/api/rest/json/?method=lapp.notice";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );

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

		echo "<pre>";
		echo "参数</br>";
		var_dump ( $params );
		echo "结果</br>";
		var_dump ( $result );
		// $this->display ();

		// return $this->render ( 'view', [
		// 'model' => $this->findModel ( $id )
		// ] );
	}

	/**
	 * Sendmessage.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionSendmessage($id) {
		$params ['id'] = '80';
		$params ['eid'] = '3';
		$params ['title'] = '新版上线了，请下载更新。';
		$params ['url'] = 'http://uc.sipsys.com/lanou/html/lanou_down.html';
		$params ['uids[0]'] = '3@3';
		$params ['auth_token'] = '239d48513662381f07243c238145ed9d';
		$params ['api_key'] = "36116967d1ab95321b89df8223929b14207b72b1";
		$webService = "http://192.168.139.162/elgg/services/api/rest/json/?method=lapp.notice";
		$curl = new CurlModel ();
		$result = $curl->post ( $webService, $params );

		return $this->render ( 'view', [
				'model' => $this->findModel ( $id )
		] );
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
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionCreate() {
		$uid = Yii::$app->request->get ('uid') ;

		$model = Employee::find ()->where ( [
				// 'username'=> '3@15'
				'username' => $uid
		] )->asArray ()->all ();

			//return $this->renderFile ( '@app/views/leavebill/create.php', [
			if($model){
			return $this->renderFile ( '@app/views/leavebill/create.php', [
					'model' => $model,
					'uid' => $uid
			] );
			}
			else{ //echo "无此用户";
					return $this->renderFile ( '@app/views/leavebill/create.php', [
					'model' => $model,
					'uid' => $uid
			] );
			}
		//}
	}

	/**
	 * Creates a new Leavebill model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @author fyq
	 */
	public function actionSave() {
		$model = new Leavebill ();
		$request = Yii::$app->request;
	    $uid = $request->get ('uid');

		// if ($model->load ( Yii::$app->request->get () ) && $model->save ()) {
		// echo date('Y-m-d H:i:s');

		if (Yii::$app->request->get ('uid')) {



			$model->userid = $request->get ( 'userid', '0' );
			$model->leaveType = $request->get ( 'leaveType', '0' );
			$model->leaveStartTime = $request->get ( 'leaveStartTime', '0' );
			$model->leaveEndTime = $request->get ( 'leaveEndTime', '0' );
			$model->reason = $request->get ( 'reason', '0' );
			$model->approvalPerson = $request->get ( 'approvalPerson', '0' );
			$model->remark = $request->get ( 'remark', '0' );
			$model->applyTime = date ( 'Y-m-d H:i:s' );
			$model->state = $request->get ( 'state', '0' );
			$model->username = $request->get ( 'username', '0' );
			$model->days = $request->get ( 'days', '0' );
			$model->dep = $request->get ( 'dep', '0' );
			$model->spuser = $request->get ( 'spuser', '0' );
			$model->tzuser = $request->get ( 'tzuser', '0' );
			$model->tongzhi = $request->get ( 'tongzhi', '0' );
			$model->token = $request->get ( 'token', '0' );

			$model->save ();




			$this->actionIndex();

			// echo $model->id;
			// print_r(Yii::$app->request->post( 1)) ;
			// return $this->redirect ( [
			// 'view',
			// 'id' => $model->id
			// ] );
		} else {

			//return $this->renderFile ( '@app/views/leavebill/create.php', [
			return $this->renderFile ( '@app/views/leavebill/create.php', [
					'model' => $model,
					//'request' => $request->get ( 'ffff', 'e' )
			] );
		}
	}

	/**
	 * Updates an existing Leavebill model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );

		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
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
	 * Finds the Leavebill model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param string $id
	 * @return Leavebill the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Leavebill::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
