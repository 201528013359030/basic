<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;

class SiteController extends Controller {
	//public $enableCsrfValidation = false;
	/**
	 * @fyq
	 */
	public function actionEntry() {
		$model = new EntryForm ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			return $this->render ( 'entry-confirm', [ 
					'model' => $model 
			] );
		} else {
			return $this->render ( 'entry', [  // content
					'model' => $model 
			] );
		}
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'logout' 
						],
						'rules' => [ 
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				] 
		];
	}
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		return $this->render ( 'index' );
		// return $this->render ( 'entry' );
	}
	
	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}
		
		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		}
		return $this->render ( 'login', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();
		
		return $this->goHome ();
	}
	
	/**
	 * Displays contact page.
	 *
	 * @return string
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->contact ( Yii::$app->params ['adminEmail'] )) {
			Yii::$app->session->setFlash ( 'contactFormSubmitted' );
			
			return $this->refresh ();
		}
		return $this->render ( 'contact', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout() {
		return $this->render ( 'about' );
	}
	public function actionTest(){
		echo "ddd";
		
	}
	public function actionTest1(){
		return $this->render('formtest');
	}
}
