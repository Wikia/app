<?php

class WikiaQuizModule extends Module {

	var $data;

	/**
	 * Render HTML Quiz namespace pages
	 */
	public function executeIndex() {
	}
	
	public function executeSampleQuiz() {
		$this->executeGetQuiz();
	}

	public function executeGetQuizElement() {
		$wgRequest = F::app()->getGlobal('wgRequest');
		$elementId = $wgRequest->getVal('elementId');
		if ($elementId) {
			$quizElement = F::build('WikiaQuizElement', array($elementId), 'newFromId');
			$this->data = $quizElement->getData();
		}
	}

	public function executeGetQuiz() {
		$wgRequest = F::app()->getGlobal('wgRequest');
		$quizName = $wgRequest->getVal('quiz');
		if ($quizName) {
			$quiz = WikiaQuiz::newFromName($quizName);
			$this->data = $quiz->getData();
		}
	}

}
