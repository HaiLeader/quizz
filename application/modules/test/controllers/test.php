<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('mtest');
		$this->load->helper(array('form_vali'));
	}
	function index(){
		redirect(base_url());
	}

	function testdetail($testid){
		$user = check_login(1);
		if(!isset($testid)||!is_numeric($testid))
			redirect(base_url());
		$data = array(
				'test' => $this->mtest->get_test_detail($testid),
				'meta_title' => 'Test Detail',
			);
		if(!$this->input->post('submit')&&!$this->input->post('submit_rs')){
			$data['template'] = 'home/frontend/home/testdetail'; 
			$this->load->view('home/frontend/layouts/home',isset($data)?$data:NULL);
		}else{
			$answer = $this->input->post('answer');
			$total_score = 0; $total_question = 0;
			$score = 0; $correct_question = 0;
			foreach ($data['test'] as $key => $value) {
				$total_score += $value['score'];
				$total_question+=1;
				if( isset($answer[$key]) && $answer[$key] == $value['correct']){
					$score +=$value['score'];
					$correct_question +=1;
				}
			}
			$answer = json_encode($answer);

			$result_db = array(
					'userid' => $user['id'],
					'testid' => $testid,
					'score' => $score*10/$total_score,
					'answer_choice' => $answer
				);
			$this->mtest->addtest($result_db);

			$result = array(
					'correct_question' => $correct_question,
					'total_question' => $total_question,
					'score' => $score*10/$total_score
				);
			$this->result($result);
		}
	}

	function result($result){
		if(!$this->input->post('submit_rs')){
			$data['result'] = $result;
			$data['meta_title'] = 'result';
			$data['template'] = 'home/result';			
			$this->load->view('home/frontend/layouts/home',isset($data)?$data:NULL);
		}else{
			redirect(base_url());
		}
	}

}