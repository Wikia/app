<?php

/**
 * This class is used to render QuizArticle namespace page
 */

class WikiaQuizArticle extends Article {

	private $mQuizElement;

	function __construct($title) {
		parent::__construct($title);

		$this->mQuizElement = WikiaQuizElement::newFromArticle($this);
	}

	/**
	 * Render Quiz namespace page
	 */
	public function view() {
		global $wgOut, $wgTitle, $wgRequest;
		wfProfileIn(__METHOD__);

		// let MW handle basic stuff
		parent::view();

		// don't override history pages
		$action = $wgRequest->getVal('action');
		if (in_array($action, array('history', 'historysubmit'))) {
			wfProfileOut(__METHOD__);
			return;
		}

		// poll doesn't exist
		if (!$wgTitle->exists() || empty($this->mQuizElement)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// set page title
		$question = $this->mQuizElement->getTitle();
		$wgOut->setPageTitle($question);

		// add CSS/JS
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'));

		// render poll page
		$wgOut->clearHTML();
		$wgOut->addHTML($this->mQuizElement->render());

		wfProfileOut(__METHOD__);
	}

	/**
	 * Purge quizElement's Article and QuizElement
	 */
	public function doPurge() {
		parent::doPurge();

		wfDebug(__METHOD__ . "\n");

		// purge poll's data
		if (!empty($this->mQuizElement)) {
			$this->mQuizElement->purge();
		}
	}
}
