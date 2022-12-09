<?php
class MY_Model extends CI_Model{
	private $total_rows=0;
	function __construct()
	{
		parent::__construct();
	}

	protected function count_rows() {
		$this->total_rows = 0;
		$query = $this->db->query('SELECT FOUND_ROWS() as total');
		if( $rows = $query->result_array() ) {
			$this->total_rows = $rows[0]['total'];
		}
	}

	function getTotalCount() {
		return $this->total_rows;
	}
}
