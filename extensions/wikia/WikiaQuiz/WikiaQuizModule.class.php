<?php

class WikiaQuizModule extends Module {

	var $data;
	var $wgBlankImgUrl;

	/**
	 * Render HTML Quiz namespace pages
	 */
	
	public function executeIndex($params) {
		if (!empty($params['quiz'])) {
			$this->quiz = $params['quiz'];
			$this->data = $this->quiz->getData();
		}		
	}
	
	public function executeArticleIndex($params) {
		if (!empty($params['quizElement'])) {
			$this->quizElement = $params['quizElement'];
			$this->data = $this->quizElement->getData();
		}
	}
	
	public function executeSampleQuiz() {
		$this->executeGetQuiz();
	}

	// 2nd prototype
	public function executeSampleQuiz2() {
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

	public function executeCreateQuiz() {
		
	}
	
	public function executeEditQuiz($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_QUIZ) ;

		if (is_object($title) && $title->exists()) {
			$this->quiz = WikiaQuiz::NewFromTitle($title);
			$this->data = $this->quiz->getData();
		}
	}

	public function executeCreateQuizArticle() {

	}

	public function executeEditQuizArticle($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_QUIZARTICLE) ;

		if (is_object($title) && $title->exists()) {
			$this->quizElement = WikiaQuizElement::NewFromTitle($title);
			$this->data = $this->quizElement->getData();
		}
	}

}
