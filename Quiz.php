<?php

namespace MyApp;

class Quiz {

	private $_quizSet = [];

	public function __construct() {
		$this->_setup();
		Token::create();

		//var_dump($this->_quizSet);
		//exit;

		if(!isset($_SESSION['current_num'])){
			$this->_initSession();
		}
	}

	public function getCurrentQuiz() {
		return $this->_quizSet[$_SESSION['current_num']];
	}

	public function checkAnswer() {
		Token::validate('token');
		$correctAnser = $this->_quizSet[$_SESSION['current_num']]['a'][0];
		if(!isset($_POST['answer'])) {
			throw new \Exception('answer not set');
		}
		if($correctAnser === $_POST['answer']){
			$_SESSION['correct_count']++;
		}
		$_SESSION['current_num'] ++;	// 次の問題に進める
		return $correctAnser;
	}

	public function getScore() {
		return round($_SESSION['correct_count'] / count($this->_quizSet) * 100);
	}

	// 問題を全部消化した?
	public function isFinished() {
		return count($this->_quizSet) === $_SESSION['current_num'];
	}

	// 最後の問題を表示中?
	public function isLast() {
		return count($this->_quizSet) - 1 === $_SESSION['current_num'];
	}

	public function reset() {
		$this->_initSession();
	}

	private function _setup() {

		$this->_quizSet[] = [
			'q' => 'What is A?',
			'a' => ['A0', 'A1', 'A2', 'A3']
		];
		$this->_quizSet[] = [
			'q' => 'What is B?',
			'a' => ['B0', 'B1', 'B2', 'B3']
		];
		$this->_quizSet[] = [
			'q' => 'What is C?',
			'a' => ['C0', 'C1', 'C2', 'C3']
		];
	}

	private function _initSession() {
		$_SESSION['current_num'] = 0;
		$_SESSION['correct_count'] = 0;
	}

}
