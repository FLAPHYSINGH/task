<?php

class Task_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function saveTask($postVal)
	{
		$data = ['title'=>$postVal['title'],'is_delete'=>'N','due-date'=>$postVal['due-date'],'created_on'=>date('Y-m-d H:i:s')];
		if ((isset($postVal['title']) && $postVal['title'])) {
			$this->db->insert(TBL_TASK,$data);
			return array('status' => STATUS_SUCCESS, 'msg' => 'Added successfully!', 'data' => array());
		} else {
			return array('status' => STATUS_FAIL, 'msg' => 'Something went wrong', 'data' => array());
		}
	}
	function saveSubTask($postVal)
	{$data = ['title'=>$postVal['title'],'id'=>$postVal['id'],'is_delete'=>'N','due-date'=>$postVal['due-date'],'created_on'=>date('Y-m-d H:i:s')];
		if ((isset($postVal['title']) && $postVal['title'])) {
			$this->db->insert(TBL_SUB_TASK,$data);
			return array('status' => STATUS_SUCCESS, 'msg' => 'Added successfully!', 'data' => array());
		} else {
			return array('status' => STATUS_FAIL, 'msg' => 'Something went wrong', 'data' => array());
		}
	}

	function getTaskId($postVal){
		$row = array();
		$fields = "t.id";
		$this->db->select($fields);
		$this->db->from(TBL_TASK.' t');
		if(isset($postVal['task_title']) && !empty($postVal['task_title'])){
			$where = array("t.title" => $postVal['task_title']);
			$this->db->where($where);
		}
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
		}
		return $row;
	}
	function deleteTask($postVal=array())
	{
		$data = array(
			'is_delete' => 'Y',
			'deleted_on' => date('Y-m-d H:i:s')
		);
		$this->db->set($data);
		$this->db->where('id', $postVal['id']);
		$return = $this->db->update(TBL_TASK);
		if($return){
			$this->db->set($data);
			$this->db->where('id', $postVal['id']);
			return $this->db->update(TBL_SUB_TASK);
		}
		return FALSE;
	}
	function updateTask($postVal=array()){
		$data = array(
			'is_completed' => 'Y'
		);
		$this->db->set($data);
		$this->db->where('id', $postVal['id']);
		$return = $this->db->update(TBL_TASK);
		if($return){
			$this->db->set($data);
			$this->db->where('id', $postVal['id']);
			return $this->db->update(TBL_SUB_TASK);
		}
		return FALSE;
	}
	function pendingTask($postVal=array()){
		$finalResult = [];
		$fields = ['t.*'];
		$this->db->select($fields);
		$this->db->from(TBL_TASK.' t');
		$where["t.is_completed"] = $postVal['is_completed'];
		$this->db->where($where);
		$this->db->order_by("t.is_completed","DESC");
		$query = $this->db->get();
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$id_group = $value['id'];
			$fields = ['st.id','st.title','st.is_delete','st.is_completed','st.due-date'];
			$this->db->select($fields);
			$this->db->from(TBL_SUB_TASK.' st');
			$where1["st.id"] = $id_group;
			$this->db->where($where1);
			$responseQuery = $this->db->get();
			if(count($responseQuery->result_array())>0){
				$finalResult[]=$responseQuery->result_array();
			}
		}
		return $finalResult;
	}
	function getDateYmd($date){
		return date('Y-m-d',strtotime($date));
	}
	function searchTask($postVal = array()){
		$finalResult = [];
		$fields = ['t.*'];
		$this->db->select($fields);
		$this->db->from(TBL_TASK.' t');
		if(isset($postVal['from_date']) && !empty($postVal['from_date'])){
			$this->db->where('DATE(t.due-date) >=', date('Y-m-d',strtotime($postVal['from_date'])));
		}
		if(isset($postVal['to_date']) && !empty($postVal['to_date'])){
			$this->db->where('DATE(t.due-date) <=',date('Y-m-d',strtotime($postVal['to_date'])));
		}
		if(isset($postVal['title']) && !empty($postVal['title'])){
			$this->db->like('t.title',$postVal['title']);
		}
		$this->db->order_by("t.is_completed","DESC");
		$query = $this->db->get();
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$id_group = $value['id'];
			$fields = ['st.id','st.title','st.is_delete','st.is_completed','st.due-date'];
			$this->db->select($fields);
			$this->db->from(TBL_SUB_TASK.' st');
			$where1["st.id"] = $id_group;
			$this->db->where($where1);
			$responseQuery = $this->db->get();
			if(count($responseQuery->result_array())>0){
				$finalResult[]=$responseQuery->result_array();
			}
		}
		return $finalResult;
	}

	function getallDetails()
	{
		$row = array();
		$fields = "t.title as task,st.title as sub_task";
		$this->db->select($fields);
		$this->db->from(TBL_TASK.' t');
		$this->db->join(TBL_SUB_TASK.' st','st.id = t.id');
		//$this->db->group_by(array("s.name"));
		$this->db->order_by("t.id","DESC");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row = $query->result_array();
		}
		return $row;
	}
	function getTaskDetaisl($postVal=array()){

		$row = array();
		$fields = "t.*";
		$this->db->select($fields);
		$this->db->from(TBL_TASK.' t');
		$where["t.is_delete"] = 'Y';
		$this->db->where($where);
		$this->db->limit($postVal['limit']);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row = $query->result_array();
		}
		return $row;
	}

	function deleteTaskData($id){
		$this->db->where('id', $id);
		$return = $this->db->delete(TBL_TASK);
		if($return){
			$this->db->where('id', $id);
			$this->db->delete(TBL_SUB_TASK);
		}
		return array('status' => STATUS_FAIL, 'msg' => 'Deleted successfully!', 'data' => array());
	}
}
