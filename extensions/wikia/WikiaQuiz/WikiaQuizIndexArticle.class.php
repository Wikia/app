<?php

/**
 * This class is used to render Quiz namespace page
 */

class WikiaQuizIndexArticle extends Article {

	private $mQuiz;

	function __construct($title) {
		parent::__construct($title);

		$this->mQuiz = WikiaQuiz::newFromArticle($this);
	}

	/**
	 * Render Quiz namespace page
	 */
	public function view() {
		global $wgOut, $wgUser, $wgTitle, $wgRequest;
		wfProfileIn(__METHOD__);

		// let MW handle basic stuff
		parent::view();

		// don't override history pages
		$action = $wgRequest->getVal('action');
		if (in_array($action, array('history', 'historysubmit'))) {
			wfProfileOut(__METHOD__);
			return;
		}

		// quiz doesn't exist
		if (!$wgTitle->exists() || empty($this->mQuiz)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// set page title
		$title = $this->mQuiz->getTitle();
		$wgOut->setPageTitle($title);

		// add CSS/JS
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'));

		// render quiz page
		$wgOut->clearHTML();
		$wgOut->addHTML($this->mQuiz->render());

		wfProfileOut(__METHOD__);
	}

	/**
	 * Purge quiz (and articles embedding it) when quiz's page is purged
	 */
	public function doPurge() {
		parent::doPurge();

		wfDebug(__METHOD__ . "\n");

		// purge quiz's data
		if (!empty($this->mQuiz)) {
			$this->mQuiz->purge();
		}

		// purge QuizPlay article
		$quizPlayTitle = Title::newFromText($this->getTitle()->getText(), NS_WIKIA_PLAYQUIZ);
		$quizPlayArticle = new Article($quizPlayTitle);
		$quizPlayArticle->doPurge();
	}
}
