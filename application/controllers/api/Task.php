<?php
require APPPATH . 'libraries/REST_Controller.php';
class Task extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Task_model');
	}

	function index_get()
	{
		$this->response(array('status' => STATUS_FAIL, 'message' => 'Something wrong', 'data' => array()), REST_Controller::HTTP_BAD_REQUEST);
	}
	/**
	 * Get Post Data From API Request
	 */
	public function getAPIRequestPostData()
	{
		$json = file_get_contents('php://input');

		$jsonData = array();
		if(!empty($json)) {
			$jsonData = (array)json_decode($json);
		}
		if(empty($jsonData)) {
			$jsonData = $_REQUEST;
			//$jsonData = parse_url($json);
		}
		if(empty($jsonData)) {
			if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET') {
				$jsonData = $this->input->get();
			} elseif(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') {
				$jsonData = $this->input->post();
			}
		}
		return $jsonData;
	}
	function addTask_post(){
		//$jsonObj = $this->post();
		$jsonObj =  $this->getAPIRequestPostData();
		if ((isset($jsonObj['title']) && !empty($jsonObj['title'])) &&(isset($jsonObj['due-date']) && !empty($jsonObj['due-date']))) {
			$amenityPrev = $this->Task_model->saveTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Task added successfully!','data'=>$amenityPrev), REST_Controller::HTTP_OK);
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	function addSubtask_post(){
		//$jsonObj = $this->post();
		$jsonObj =  $this->getAPIRequestPostData();
		if(isset($jsonObj['task_title']) && !empty($jsonObj['task_title'])){
			$idTask = $this->Task_model->getTaskId($jsonObj);
			$jsonObj['id'] = (int)$idTask;
			if ((isset($jsonObj['title']) && !empty($jsonObj['title'])) &&(isset($jsonObj['due-date']) && !empty($jsonObj['due-date']))) {
				$amenityPrev = $this->Task_model->saveSubTask($jsonObj);
				$this->response(array('status'=>STATUS_SUCCESS,'message'=>'SubTask added successfully!','data'=>$amenityPrev), REST_Controller::HTTP_OK);
			}else{
				$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please add Task Title'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	function deleteTask_post(){
		$jsonObj =  $this->getAPIRequestPostData();
		if (isset($jsonObj['id']) && $jsonObj['id'] > 0) {
			$resp = $this->Task_model->deleteTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Task Deleted successfully!','data'=>$resp), REST_Controller::HTTP_OK);
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	function updateTask_post(){
		$jsonObj =  $this->getAPIRequestPostData();
		if (isset($jsonObj['id']) && $jsonObj['id'] > 0) {
			$resp = $this->Task_model->updateTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Task Updated successfully!','data'=>$resp), REST_Controller::HTTP_OK);
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	function getPendingTask_get(){
		$jsonObj =  $this->getAPIRequestPostData();
		if (isset($jsonObj['is_completed']) && $jsonObj['is_completed'] =='N') {
			$resp = $this->Task_model->pendingTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Get Pending Task Details','data'=>$resp), REST_Controller::HTTP_OK);
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	function getSearchTask_get(){
		$jsonObj =  $this->getAPIRequestPostData();
		if (isset($jsonObj['due-date']) && !empty($jsonObj['due-date'])) {
			if($jsonObj['due-date'] == 'This Week'){
				$to_date   = date('Y-m-d', strtotime(date('Y-m-d'). ' +1 days'));
				$from_date = strtotime($to_date . ' -7 day');
				$from_date = date("Y-m-d",$from_date);
			}elseif($jsonObj['due-date'] == 'Next Week'){
				$to_date   = date('Y-m-d', strtotime(date('Y-m-d'). ' +1 days'));
				$from_date = strtotime($to_date . ' -14 day');
				$from_date = date("Y-m-d",$from_date);
			}elseif($jsonObj['due-date'] == 'Overdue'){
				$to_date   = date('Y-m-d', strtotime(date('Y-m-d'). ' +1 days'));
				$from_date = strtotime($to_date . ' -31 day');
				$from_date = date("Y-m-d",$from_date);
			}else{
				$to_date   = date('Y-m-d', strtotime(date('Y-m-d'). ' +1 days'));
				$from_date = strtotime($to_date . ' -0 day');
				$from_date = date("Y-m-d",$from_date);
			}
			$resp = $this->Task_model->searchTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Task Details','data'=>$resp), REST_Controller::HTTP_OK);
		}elseif(isset($jsonObj['title']) && !empty($jsonObj['title'])) {
			$resp = $this->Task_model->searchTask($jsonObj);
			$this->response(array('status'=>STATUS_SUCCESS,'message'=>'Task Details','data'=>$resp), REST_Controller::HTTP_OK);
		}else{
			$this->response(array('status' => STATUS_FAIL, 'message' => 'Please try again!'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
?>
