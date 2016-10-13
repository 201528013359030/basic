<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Leavebill;
use app\models\LeavebillSearch;

class UtilsModel extends Model {
	public function saveGetmaxNum($type, $digits) {
		// $hostname = "localhost";
		// $username = "root";
		// $password = "123456";
		// $database = "activiti_bak";
		// SELECT * FROM leavebill where userid = :uid and id > :id and applyTime < :applyTime' )->bindValue ( ':uid', '8@15' )->bindValue ( ':id', 502 )->bindValue ( ':applyTime', date ( 'Y-m-d H:i:s' ) )->queryAll ();
		$command = Yii::$app->db->createCommand ( "select XMBH_GETSEQNOS( :type )" )->bindValue ( ':type', $type );
		$result_set = $command->queryAll ();
		// print_r($result_set);
		$index = 'XMBH_GETSEQNOS( \'' . $type . '\' )';
		$result = $result_set [0] [$index];
		// $result="";
		// $result = $result_set[0]['XMBH_GETSEQNOS( "QJDH" )'];
		// print_r();
		// new mysqli($hostname, $username, $password, $database);
		$str = '';
		/* check connection */
		// if (mysqli_connect_errno()) {
		// printf("Connect failed: %sn", mysqli_connect_error());
		// //exit ();
		// }
		// $result_set = $dbh->query("call XMBH_GETSEQNOS( $type )");
		if ($digits == 0) {
			$str = $type . $result;
		} else {
			while ( strlen ( $result ) < $digits ) {
				$result = "0" . $result;
			}
			$str = $type . $result;
		}
		// echo $str;
		return $str;
	}
	function array2object($array) {
		if (is_array ( $array )) {
			$obj = new StdClass ();
			foreach ( $array as $key => $val ) {
				$obj->$key = $val;
			}
		} else {
			$obj = $array;
		}
		return $obj;
	}
	function object2array($object) {
		if (is_object ( $object )) {
			foreach ( $object as $key => $value ) {
				$array [$key] = $value;
			}
  }
  else {
    $array = $object;
  }
  return $array;
}
//	public function 
}