<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mtest extends CI_Model{
	private $_name = 'test';
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function count_all(){
		return $this->db->count_all($this->_name);
	}

	function deletetest($id){
		$this->db->where('id', $id)->limit(1)->delete($this->_name);
	}

	function deletequestion($testid){
		$this->db->where('testid',$testid)->delete('question');
	}
	function get_test_detail($id){
	$query = $this->db->select('q.type, q.question, q.answer, test.id, test.name, test.madethi, q.level, q.correct, q.ans_explained, question.score')
			->from('test')
			->where('test.id',$id)
			->join('question','test.id = question.testid')
			->join('questionbank as q','q.id = question.questionid')
			->limit(20)
			->get();
	if($query->num_rows()>0)
		return $query->result_array();
	else return false;
	}

	// lay thong tin de testid
	function get_test_info($testid){
		$query = $this->db->select('id, name, madethi, time, sl')
				->where('id', $testid)
				->limit(1)
				->get('test');
		if($query->num_rows()>0)
			return $query->row_array();
		else return false;
	}
	
	function addtest($result){
		$this->db->insert('responses', $result);
	}

	function insert_test($data) {
		$str_query = $this->db->insert_string($data);
		$this->db->query($str_query);
	}
}