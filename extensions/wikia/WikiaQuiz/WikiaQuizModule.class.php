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

	// 2nd prototype
	public function executeSampleQuiz2() {
		$this->executeGetQuiz();
		hyunbug($this->data);
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

	public function executeSpecialPage() {

	}

	public function executeSpecialPageEdit($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_QUIZ) ;

		if (is_object($title) && $title->exists()) {
			$this->quizElement = WikiaQuizElement::NewFromTitle($title);
			$this->data = $this->quizElement->getData();
		}
	}

}
