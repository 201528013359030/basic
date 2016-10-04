<?php

namespace app\controllers;

use yii\web\Controller;
use yii\base\Request;

class HelloController extends Controller {
	public function actionIndex() {
		$request = \YII::$app->request;
		
		// echo $request->get ( 'id', 20 );
		// echo $request->post ( 'name', 333 );
		// if ($request->isGet) {
		// echo 'this is get method';
		// }
		
		echo $request->userIP;
		
		// echo 'hello world';
	}
}