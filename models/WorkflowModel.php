<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Leavebill;
use app\models\LeavebillSearch;

class WorkflowModel extends Model {
	// 开启请假条流程
	public function saveStartProcess($leaveBill, $uid) {
		$searchModel = new LeavebillSearch ();
		$leaveBill->state = 1;
		$key = "LeaveBill";
		$bussinessKey = "LeaveBill" . "." . $leaveBill ['id'];
		$variables = [ 
				[ 
						'name' => 'inputUser',
						'value' => $uid 
				] 
		]
		// 修改 zyr 10.24
		// [
		// 'name' => 'isAbandon',
		// 'value' => '1'
		// ]
		;
		$activitiModel = new ActivitiModel ();
		// 开启流程
		$result = $activitiModel->StartProcessInstance ( $key, $bussinessKey, $variables );
		
		// var_dump ( $result );
		if (! isset ( $result->id )) {
			return $result = [ 
					'status' => 'error' 
			];
		}
		
		// 获取流程ID
		// isset($result->id) or die('创建流程失败');
		$processInstanceId = $result->id;
		// 获取任务
		$task = $activitiModel->queryTasks ( $processInstanceId );
		
		// isset($task->data) or die('创建任务失败');
		
		$taskId = $task->data [0]->id;
		$variables2 = [ 
				[ 
						'name' => 'approvalPerson',
						'value' => $leaveBill ['approvalPerson'] 
				],
				[ 
						'name' => 'isAbandon',
						'value' => '1' 
				] 
		];
		// 完成任务
		$result2 = $activitiModel->completeTask ( $taskId, $variables2 );
		if ($result2 == null) {
			if ($leaveBill->save ()) {
				return $result = [ 
						'status' => 'success',
						'model' => $leaveBill 
				];
			} else {
				$activitiModel->deleteProcessInstance ( $processInstanceId );
				return $result = [ 
						'status' => 'error' 
				];
			}
		} else {
			// echo "创建请假流程失败"
			$activitiModel->deleteProcessInstance ( $processInstanceId );
			return $result = [ 
					'status' => 'error' 
			];
		}
	}
	// 修改请假条（重新请求）
	public function updateStartLeaveBill($leaveBill) {
		$key = "LeaveBill";
		$leaveBillId = $leaveBill->id;
		$activitiModel = new ActivitiModel ();
		$processBusinessKey = $key . '.' . $leaveBillId;
		// 获取流程ID
		$result = $activitiModel->queryHistoricProcessInstances ( $processBusinessKey )->data;
		if ($result != null && count ( $result ) > 0) {
			$processInstanceId = $result [0]->id;
		} else {
			return $result = [ 
					'status' => 'error' 
			];
		}
		// 查询此任务
		$task = $activitiModel->queryTasks ( $processInstanceId )->data;
		if (count ( $task ) > 0) {
			$taskId = $task [0]->id;
			$variables2 = [ 
					[ 
							'name' => 'approvalPerson',
							'value' => $leaveBill ['approvalPerson'] 
					],
					[ 
							'name' => 'isAbandon',
							'value' => '1' 
					] 
			];
			// 完成任务
			$result2 = $activitiModel->completeTask ( $taskId, $variables2 );
		} else {
			// 修改 zyr 10.24
			return $result = [ 
					'status' => 'error' 
			];
			// return "无此请假任务";
		}
		// echo "<br/>";
		// 保存请假条
		if ($leaveBill->save ()) {
			return $result = [ 
					'status' => 'success' 
			];
		} else {
			// 此处处理未解决（将当前完成的任务由完成状态改为进行中）
			// var_dump ( $leaveBill->getErrors () );
			return $result = [ 
					'status' => 'error' 
			];
		}
	}
	// 获取请假条信息
	public function findCommentByLeaveBillId($leaveBillId) {
		$activitiModel = new ActivitiModel ();
		$key = "LeaveBill";
		$processBusinessKey = $key . '.' . $leaveBillId;
		$result = $activitiModel->queryHistoricProcessInstances ( $processBusinessKey )->data;
		if ($result != null && count ( $result ) > 0) {
			$processInstanceId = $result [0]->id;
		} else {
			// return null;
			// 修改 zyr 10.24
			return $result = [ 
					'status' => 'error' 
			];
		}
		$utils = new UtilsModel ();
		$taskList = $activitiModel->queryHistoricTaskInstancesById ( $processInstanceId )->data;
		$resultList = array ();
		foreach ( $taskList as $task ) {
			$comments = $activitiModel->getCommentOnTask ( $task->id );
			$task = $utils->object2array ( $task );
			$task ['comments'] = $comments;
			array_push ( $resultList, $task );
		}
		// var_dump($resultList);
		// 修改 zyr 10.24
		return $result = [ 
				'status' => 'success',
				'taskList' => $resultList 
		];
		// return $result;
	}
	
	// 审批
	public function saveSubmitTaskByLeaveBillId($leaveBill, $outcome, $comment = null) {
		$session = Yii::$app->session;
		$name = $session->get ( 'name' );
		$activitiModel = new ActivitiModel ();
		$leaveBillId = $leaveBill->id;
		$key = "LeaveBill";
		$businessKey = $key . '.' . $leaveBillId;
		$result1 = $activitiModel->queryHistoricProcessInstances ( $businessKey )->data;
		//var_dump($result1);
		if ($result1 != null && count ( $result1 ) > 0) {
			$processInstanceId = $result1 [0]->id;
		} else {
			// 修改 zyr 10.24
			return $result = [ 
					'status' => 'error' 
			];
		}
		$task = $activitiModel->queryTasks ( $processInstanceId );			
		if (count ( $task->data ) <= 0) {
			// 修改 zyr 10.24
// 			 return "无此任务";
				return $result = [
						'status' => 'error'
				];
		}
		$task = $task->data [0];
		$taskId = $task->id;
		if ($task != null) {
			if ("1" == $outcome) {
				$leaveBill->state = 2;
				if ($comment != null) {
					$message = $session->get ( 'name' ) . "已同意.  意见:" . $comment;
				} else {
					$message = $session->get ( 'name' ) . "已同意.";
				}
				$activitiModel->createCommentOnTask ( $taskId, $message );
				$variables = [ 
						[ 
								'name' => 'outcome',
								'value' => $outcome 
						] 
				];
				$activitiModel->completeTask ( $taskId, $variables );
				// //保存leaveBill
				$leaveBill->save ();
				//修改 zyr 10.24
				return $result = [
						'status' => 'success'
				];
			} elseif ("0" == $outcome) {
				$leaveBill->state = 3;
				if ($comment != null) {
					$message = $session->get ( 'name' ) . "已拒绝.   意见:" . $comment;
				} else {
					$message = $session->get ( 'name' ) . "已拒绝.";
				}
				$activitiModel->createCommentOnTask ( $taskId, $message );
				$variables = [ 
						[ 
								'name' => 'outcome',
								'value' => $outcome 
						],
						[ 
								'name' => 'approvalPerson',
								'value' => $session->get ( 'uid' ) 
						] 
				];
				$activitiModel->completeTask ( $taskId, $variables );
				// 保存leaveBill
				$leaveBill->save ();
				//修改 zyr 10.24
				return $result = [
						'status' => 'success'
				];
			} elseif ("3" == $outcome) {
				$leaveBill->state = 4;
				if ($comment != null) {
					$message = $session->get ( 'name' ) . "已放弃.  原因:" . $comment;
				} else {
					$message = $session->get ( 'name' ) . "已放弃.";
				}
				$activitiModel->createCommentOnTask ( $taskId, $message );
				$variables = [ 
						[ 
								'name' => 'isAbandon',
								'value' => '0' 
						] 
				];
				$activitiModel->completeTask ( $taskId, $variables );
				// 保存leaveBill
				$leaveBill->save ();
				//修改 zyr 10.24
				return $result = [
						'status' => 'success'
				];
			}
		}else {
			return $result = [
					'status' => 'error'
			];
		}
		return $result = [
				'status' => 'success'
		];
	}
}