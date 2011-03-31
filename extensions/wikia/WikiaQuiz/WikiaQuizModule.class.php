<?php

class WikiaQuizModule extends Module {

	var $data;
	var $quiz;

	/**
	 * Render HTML Quiz namespace pages
	 */
	public function executeIndex($params) {
		if (!empty($params['quiz'])) {
			$this->quiz = $params['quiz'];
			$this->data = $this->quiz->getData();
		}
	}

	public function executeGetQuizElement() {
		$wgRequest = F::app()->getGlobal('wgRequest');
		$elementId = $wgRequest->getVal('elementId');
		if ($elementId) {
			$this->quizElement = WikiaQuizElement::newFromId($elementId);
			$this->data = $this->quizElement->getData();
		}
	}

	public function executeGetQuiz() {

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
