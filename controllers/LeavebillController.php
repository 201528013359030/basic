<?php

namespace app\controllers;

use Yii;
use app\models\Leavebill;
use app\models\LeavebillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Employee;

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
					'state' => [1,3,4]
			] )->orderBy('applyTime')->asArray ()->all ();

			// 查询当前用户的请假信息---已同意
			$dataAgree = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'userid' => $request->queryParams ['uid'],
					'state' => '2'
			] )->orderBy('applyTime')->orderBy('applyTime')->asArray ()->all ();

			// 查询需要当前用户审批的请假信息--待审批
			$dataDisapproval = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'approvalPerson' => $request->queryParams ['uid'],
					'state' =>[1,4]
			] )->orderBy('applyTime')->asArray ()->all ();

			// 查询需要当前用户审批的请假信息--已审批
			$dataApproval = LeavebillSearch::find ()->where ( [
					// 'username'=> '3@15'
					'approvalPerson' => $request->queryParams ['uid'],
					'state' =>[2,3]
			] )->orderBy('applyTime')->asArray ()->all ();

			print_r ( $dataDisagree );echo "</br>";
			print_r ( $dataAgree );echo "</br>";
			print_r ( $dataDisapproval );echo "</br>";
			print_r ( $dataApproval );


			return $this->renderFile( '@app/views/leavebill/list.php', [
			'$dataDisagree' => $dataDisagree,
			'$dataAgree' => $dataAgree,
			'$dataDisapproval'=>$dataDisapproval,
			'$dataApproval'=>$dataApproval,
			'uid'=>$request->queryParams ['uid']
			] );
		} else {
			echo "用户不存在";
		}
	}

	public function actionMore(){

		$request = Yii::$app->request;

		$searchModel = new LeavebillSearch ();

		// 查询当前用户的请假信息-
		$dataUserLeavebill = LeavebillSearch::find ()->where ( [

				'userid' => $request->get('uid'),

		] )->orderBy('applyTime')->asArray ()->all ();


		// 查询需要当前用户审批的请假信息--已审批
		$dataApproval = LeavebillSearch::find ()->where ( [
				'approvalPerson' => $request->get('uid'),
		] )->orderBy('applyTime')->asArray ()->all ();

		// 			print_r ( $dataDisagree );echo "</br>";
		// 			print_r ( $dataAgree );echo "</br>";
		// 			print_r ( $dataDisapproval );echo "</br>";
		// 			print_r ( $dataApproval );


		return $this->renderFile( '@app/views/leavebill/list.php', [
				'$approvalPerson' => $dataUserLeavebill,
				'$dataApproval' => $dataApproval,
				'uid'=>$request->get('uid')
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
	 */
	public function actionCreate() {
		$model = new Leavebill ();

// 		if ($model->load ( Yii::$app->request->get () ) && $model->save ()) {

		if ( count(Yii::$app->request->get())>0) {

			$request = Yii::$app->request;

			$model->userid=$request->get ( 'userid', '0' );
			$model->leaveType=$request->get ( 'leaveType', '0' );
			$model->leaveStartTime=$request->get ( 'leaveStartTime', '0' );
			$model->leaveEndTime=$request->get ( 'leaveEndTime', '0' );
			$model->reason=$request->get ( 'reason', '0' );
			$model->approvalPerson=$request->get ( 'approvalPerson', '0' );
			$model->remark=$request->get ( 'remark', '0' );
			$model->applyTime=$request->get ( 'applyTime', '0' );
			$model->state=$request->get ( 'state', '0' );
			$model->username=$request->get ( 'username', '0' );
			$model->days=$request->get ( 'days', '0' );
			$model->dep=$request->get ( 'dep', '0' );
			$model->spuser=$request->get ( 'spuser', '0' );
			$model->tzuser=$request->get ( 'tzuser', '0' );
			$model->tongzhi=$request->get ( 'tongzhi', '0' );
			$model->token=$request->get ( 'token', '0' );

			$model->save ();



			// echo $model->id;
			// print_r(Yii::$app->request->post( 1)) ;
// 			return $this->redirect ( [
// 					'view',
// 					'id' => $model->id
// 			] );
		} else {

			return $this->renderPartial ( 'create', [
					'model' => $model,
					'request' => $request->get ( 'ffff', 'e' )
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
