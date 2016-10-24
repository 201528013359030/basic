<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Leavebill;
use app\models\LeavebillSearch;

class UtilsModel extends Model {
	/**
	 * a_leaveBill表的Id设置
	 *
	 * @param unknown $type      类型  	
	 * @param unknown $digits    ID 共多少位   	
	 * @return string
	 */
	public function saveGetmaxNum($type, $digits) {
		$command = Yii::$app->db->createCommand ( "select XMBH_GETSEQNOS( :type )" )->bindValue ( ':type', $type );
		$result_set = $command->queryAll ();
		$index = 'XMBH_GETSEQNOS( \'' . $type . '\' )';
		$result = $result_set [0] [$index];
		$str = '';
		if ($digits == 0) {
			$str = $type . $result;
		} else {
			while ( strlen ( $result ) < $digits ) {
				$result = "0" . $result;
			}
			$str = $type . $result;
		}
		return $str;
	}
	/**
	 * 数组转换成object类型
	 *
	 * @param unknown $array        	
	 * @return \app\models\StdClass|unknown
	 */
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
	
	/**
	 * object转换为数组类型
	 *
	 * @param unknown $object        	
	 * @return unknown
	 */
	function object2array($object) {
		if (is_object ( $object )) {
			foreach ( $object as $key => $value ) {
				$array [$key] = $value;
			}
		} else {
			$array = $object;
		}
		return $array;
	}
	
	// 功能：计算两个时间戳之间相差的日时分秒
	// $begin_time 开始时间戳
	// $end_time 结束时间戳
	public function timeDiff($begin_time, $end_time) {
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
}