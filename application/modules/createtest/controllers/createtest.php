<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class CreateTest extends MX_Controller {
	private $_form_create_test = 'create_test';
	private $_data ;
	private $_subs_selected = null;

	function __construct(){
		parent::__construct();
		$this->load->model('mtest');
		$this->load->model('category/mcategory');
		$this->load->model('subject/msubject');
		$this->load->model('level/mlevel');
		$this->load->model('question/mquestion');
		$this->load->helper(array('form','array','test'));
	}

	function get_subject() {
		if (isset($_POST['cat_id']) && strcmp($_POST['cat_id'],'non_select') != 0)
		{
			$subjects = $this->msubject->select_subject($_POST['cat_id']);
		}
		print "<option value=\"non_select\">Select Subject</option>\n";
		if (strcmp($_POST['cat_id'],'non_select') == 0) {
			return;
		}
		foreach($subjects as $key => $value) {
			$id = $value['id'];
			$name = $value['name'];
			print "<option value=\"$id\">$name</option>\n";
		}
	}

	function get_level() {
		if (isset($_POST['cat_id']) && strcmp($_POST['cat_id'],'non_select') != 0) {
			$sub_id = $_POST['cat_id'];
			$levels = $this->mlevel->get_level($sub_id);
		}
		print "<option value = \"non_select\">Select Level</option>\n";
		if (strcmp($_POST['cat_id'],'non_select') == 0) {
			return;
		}

		foreach($levels as $key => $value) {
			$id = $value['id'];
			$name = $value['name'];
			print "<option value = \"$id\">$name</option>\n";
		}
	}

	function get_input() {
		if($this->input->post('submit')){
			vali_test();// check validate_form su dung helper
			if($this->form_validation->run() == TRUE){
				$data = json_decode(stripslashes($_POST['data']));
				$input_data = get_info_test();//get info user using helper
				foreach($data as $key => $value) {
					array_push($input_data['subjects'],
						array('id' => $value->id, 'name' => $value->name, 'num_question' => $value->numQuestion, 'score_question' => $value->scoreQuestion, 'level' => $value->level, 'level_name' => $value->levelName));
					$input_data['current_num_question'] += $value->numQuestion;
				}

				if ($input_data['current_num_question'] == $input_data['max_question']) {
					echo "MAX";
				}
				$this->create_test($input_data);
			}
		}
		
	}

	function create_test($input_data) {
		$test_question = array();
		$get_question_info = array();
		$question_not_enough = false;
		$num_general_question = $input_data['max_question'] - $input_data['current_num_question'];

		foreach($input_data['subjects'] as $key => $value) {
			$input_data['subjects'][$key]['questions'] = array();
			$result = $this->mquestion->get_questions_with_subject_level($value['id'], $value['level']);

			if (sizeof($result) < $value['num_question']){
				$question_not_enough = true;
				$get_question_info[$value['id']] = "phan hoc " . $value['name'] .  "voi level " . $value['level_name']. " khong du cau hoi";
			} else if ($result != null)
				$input_data['subjects'][$key]['questions'] = $result;
		
		

		if ($questions_not_enough == true)  {
			echo "Khong du cau hoi";
			return;
		}

		if ($input_data['current_num_question'] < $input_data['max_question'])  {
			$result = $this->mquestion->get_questions_with_category($input_data['category']);
			if (sizeof($result) < $num_general_question) {
				$get_question_info['generral'] = "Khong du du lieu cho cau hoi tong hop";
				$question_not_enough = true;

			}
			$input_data['general_question_bank'] = $result;
		}

		//random lay cau hoi
		foreach ($input_data['subjects'] as $key => $value) { // voi moi phan hoc
			$num_question = $value['num_question']; //lay so luong cau hoi trong moi phan
			$input_data['subjects'][$key]['result'] = array();
			while ($num_question > 0) { //trong khi so luong cau hoi > 0
				$question_index = rand(0,sizeof($value['questions']) - 1); //lay random tu 0 den so luong cau hoi trong phan hoc - 1
				$question_id = $value['questions'][$question_index]; //lay id cua cau hoi
				array_push($test_question, array('questionid' => $question_id['id'], 'score' => $value['score_question']));//them vao trong ket qua
 	   			array_splice($input_data['subjects'][$key]['questions'], $question_index,1);
				--$num_question ;
			}
		}

		

		//cau hoi tong hop
		$avg_score = 0;
		foreach ($input_data['subjects'] as $key => $value) {
			$avg_score += $value['score_question'] / sizeof($input_data['subjects']);
		}


		while ($num_general_question > 0) {
			$question_index = rand(0, sizeof($input_data['general_question_bank']) - 1);
			$question_id = $input_data['general_question_bank'][$question_index];
			array_push($test_question, array('questionid' => $question_id['id'], 'score' => $avg_score));
			array_slice($input_data['general_question_bank'], $question_index);
			--$num_general_question;
		}

		//save to database
		$data['test_info']['name'] = $input_data['test_name'];
		$data['test_info']['time'] = $input_data['test_time'];
		$data['test_info']['decription']= $input_data['test_des'];
		$data['test_info']['sl'] = $input_data['max_question'];
		$data['test_info']['madethi'] = $input_data['madethi'];
		$data['test_question'] = $test_question;

		$this->mtest->insert_test($data);
	}
}

