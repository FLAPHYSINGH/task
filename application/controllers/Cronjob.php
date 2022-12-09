<?php
class Cronjob extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Task_model');
	}

	/**
	 *
	 * Delete All Task After 1 Month
	 * * Command : php -f index.php cronjob/deleteTask
	 */
	function deleteTask()
	{
		$postval['limit']=100;
		$result  = $this->Task_model->getTaskDetaisl($postval);
		foreach ($result as $val){
			$id =$val['id'];
			$due_date = date('Y-m-d H:i',strtotime($val['deleted_on']));
			$late_date = date('Y-m-d H:i', strtotime($due_date . " - 31 day"));
			if($late_date = -date('Y-m-d H:i')){
				$result  = $this->Task_model->deleteTaskData($id);
			}
		}

	}
}


?>
