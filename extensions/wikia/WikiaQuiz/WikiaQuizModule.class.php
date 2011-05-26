<?php

class WikiaQuizModule extends Module {

	var $data;
	var $wgBlankImgUrl;

	/**
	 * Render HTML Quiz namespace pages
	 */
	
	public function executeIndex($params) {
		if (!$this->checkPermissions()) {
			return;
		}

		if (!empty($params['quiz'])) {
			$this->quiz = $params['quiz'];
			$this->data = $this->quiz->getData();
		}		
	}
	
	public function executeArticleIndex($params) {
		if (!$this->checkPermissions()) {
			return;
		}

		if (!empty($params['quizElement'])) {
			$this->quizElement = $params['quizElement'];
			$this->data = $this->quizElement->getData();
		}
	}
	
	/**
	 * depracated, keeping for reference.  Please do not delete the other resources (js, css)
	 * @author Hyun Lim
	 */
	public function executeSampleQuiz() {
		$this->executeGetQuiz();
	}

	/**
	 * depracated, keeping for reference.  Please do not delete the other resources (js, css)
	 * @author Hyun Lim
	 */
	public function executeSampleQuiz2() {
		$this->executeGetQuiz();
	}
	
	/**
	 * Current version.
	 * @author Hyun Lim
	 */
	public function executeSampleQuiz3() {
		global $wgUser, $wgOut, $wgRequest, $wgSiteName;
		$this->executeGetQuiz();
		
		$wgOut->setPageTitle($this->data['name']);
		
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkText = $settings['wordmark-text'];
		if ($this->wordmarkType == 'graphic') {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
		}
		
		// Facebook opengraph meta data
		$wgOut->addMeta('property:og:title', $this->data['titlescreentext']);
		$wgOut->addMeta('property:og:type', 'game');
		$wgOut->addMeta('property:og:url', $wgRequest->getFullRequestURL());
		$wgOut->addMeta('property:og:site_name', $wgSiteName);
		$wgOut->addMeta('property:og:description', $this->data['titlescreentext']);
		$wgOut->addMeta('property:og:image', $this->wordmarkUrl);
		
		$this->username = $wgUser->getName();
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
			$title = Title::newFromText($quizName, NS_WIKIA_QUIZ);
			$quiz = WikiaQuiz::newFromTitle($title);
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
	
	private function checkPermissions() {
		global $wgUser, $wgOut;
		
		if ($wgUser->isBlocked()) {
			$wgOut->blockedPage();
			return false;
		}
		if (!$wgUser->isAllowed('wikiaquiz')) {
			$wgOut->permissionRequired( "" );
			return false;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$wgOut->readOnlyPage();
			return false;
		}
		
		return true;
	}

}
