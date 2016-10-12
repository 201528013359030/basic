<?php

namespace app\models;
use Yii;
use yii\base\Model;
use app\models\Leavebill;
use app\models\LeavebillSearch;

class WorkflowModel extends Model{
	//开启请假条流程
	public function saveStartProcess($leaveBillId,$uid){
		$searchModel = new LeavebillSearch ();
		$leaveBill = LeavebillSearch::find()->where ( [
				// 'username'=> '3@15'
				'id' => $leaveBillId
		] )->asArray ()->One();
	//	$leaveBill['state']=1;
		$key = "LeaveBill";
		$bussinessKey=$key.".".$leaveBill['id'];
// 		$variables->inputUser=$approvalPerson;
// 		$variables->objId=$bussinessKey;
		//$variables=[['inputUser'=>$approvalPerson,'objId'=>$bussinessKey]];
		//$variables=[['name'=>'inputUser','value'=>$uid],['name'=>'objId','value'=>$bussinessKey]];
		$variables=[['name'=>'inputUser','value'=>$uid],['name'=>'isAbandon','value'=>'1']];
		//var_dump($variables);
		$activitiModel=new ActivitiModel();
		$result=$activitiModel->StartProcessInstance($key,$bussinessKey,$variables);
		
		$processInstanceId=$result->id;
		//var_dump($processInstanceId);
		$task=$activitiModel->queryTasks($processInstanceId);
		//var_dump($task);
		$taskId=$task->data[0]->id;
		$variables2=[['name'=>'approvalPerson','value'=>$leaveBill['approvalPerson']],['name'=>'isAbandon','value'=>'1']];
		$result2=$activitiModel->completeTask($taskId,$variables2);
		//var_dump($result2);
		//$activitiModel->c
		//var_dump($result);
		if($result2==null||count($result2)<=0){
			return "error";
		}else{
			return "success";
		}
	}
	//public function submit
	
	//获取请假条信息
	public function findCommentByLeaveBillId($leaveBillId){
		$activitiModel=new ActivitiModel();
		$key = "LeaveBill";
		$processBusinessKey=$key.'.'.$leaveBillId;
		$result=$activitiModel->queryHistoricProcessInstances($processBusinessKey);
		if($result!=null&&count($result)>0){
			$processInstanceId=$result[0]->id;			
		}else{
			return null;
		}
		
		//var_dump($processInstanceId);
		//$processInstanceId=$result->id;
		//echo $processInstanceId;
		//$taskList=$activitiModel->queryHistoricProcessInstances($processInstanceId)->data;
		$utils = new UtilsModel();
		$taskList=$activitiModel->queryHistoricTaskInstancesById($processInstanceId);
		$result=array();
//		var_dump($taskList);
		foreach ($taskList as $task){
			//var_dump($task);
			$comments=$activitiModel->getCommentOnTask($task->id);
 			//var_dump($comments);
 			$task=$utils->object2array($task); 		
 			$task['comments']=$comments;
 			array_push($result,$task);
 			//$result->add($task);
 			//var_dump($task);
		}
		//var_dump($result);
		//var_dump($result);
		//$taskList=$activitiModel->getAllCommentsAHistoricProcessInstances($processInstanceId);
		return $result;
	}
	
	//审批
	public function saveSubmitTaskByLeaveBillId($leaveBill,$outcome,$uid,$comment){
		$activitiModel=new ActivitiModel();
// 		$leaveBillId=$leaveBill['id'];
		$leaveBillId=$leaveBill->id;
		$key="LeaveBill";
		$businessKey=$key.'.'.$leaveBillId;
		$result=$activitiModel->queryHistoricProcessInstances($businessKey);
		if($result!=null&&count($result)>0){
			$processInstanceId=$result[0]->id;
		}else{ 
			return null;
		}
		echo $processInstanceId;
		
		$task=$activitiModel->queryTasks($processInstanceId);
		//var_dump($task);
		if(count($task->data)<=0){
			return "null";
		}
		//print_r($task);
		//var_dump($task);
		echo "-----------------------------------";
		$task=$task->data[0];
		$taskId=$task->id;
		if($task!=null){
			if("1"==$outcome){
				$leaveBill->state=2;
				$message=$uid."已同意.		".$comment;
				$activitiModel->createCommentOnTask($taskId,$message);
				$variables=[['name'=>'outcome','value'=>$outcome]];
				// 				$variables=[['outcome'=>$outcome]];
				$activitiModel->completeTask($taskId,$variables);
				//保存leaveBill
				
				$leaveBill->save();
				
			}elseif("0"==$outcome){
				$leaveBill->state=3;
				$message=$uid."已拒绝.		".$comment;
				$activitiModel->createCommentOnTask($taskId,$message);
				$variables=[['name'=>'outcome','value'=>$outcome],['name'=>'approvalPerson','value'=>$uid]];
				//$variables=[['outcome'=>$outcome,'approvalPerson'=>$uid]];
				$activitiModel->completeTask($taskId,$variables);
				$leaveBill->save();
				//保存leaveBill
			}elseif("3"==$outcome){
				$leaveBill->state=4;
				$message=$uid."已放弃".$comment;
				$activitiModel->createCommentOnTask($taskId,$message);
				//$variables=[['outcome'=>$outcome]];
				$variables=[['name'=>'isAbandon','value'=>'0']];
				$activitiModel->completeTask($taskId,$variables);
				$leaveBill->save();
				//保存leaveBill
			}
		}
	

	}
}