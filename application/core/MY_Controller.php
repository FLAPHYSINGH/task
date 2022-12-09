<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abhishek
 */
class MY_Controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	function setSuccessFailMessage($data){
		$css_class = ADDED_MSG_FAIL_CLASS;
		if($data['status']==STATUS_SUCCESS) {
			$css_class = ADDED_MSG_SUCC_CLASS;
		}
		$this->session->set_flashdata('message', $data['msg']);
		$this->session->set_flashdata('color', $css_class);
		return true;
	}

}
?>
