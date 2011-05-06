<?php

/**
 * This class is used to render Quiz namespace page
 */

class WikiaQuizIndexArticle extends Article {

	private $mQuizElement;

	function __construct($title) {
		parent::__construct($title);

		$this->mQuiz = WikiaQuiz::newFromArticle($this);
	}

	/**
	 * Render Quiz namespace page
	 */
	public function view() {
		global $wgOut, $wgUser, $wgTitle, $wgJsMimeType, $wgExtensionsPath;
		wfProfileIn(__METHOD__);
		
		wfLoadExtensionMessages('WikiaQuiz');

		// let MW handle basic stuff
		parent::view();

		// poll doesn't exist
		if (!$wgTitle->exists() || empty($this->mQuiz)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// set page title
		$title = $this->mQuiz->getTitle();
		$wgOut->setPageTitle($title);

		// add CSS/JS
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'));

		// render poll page
		$wgOut->clearHTML();
		$wgOut->addHTML($this->mQuiz->render());

		wfProfileOut(__METHOD__);
	}

	/**
	 * Purge poll (and articles embedding it) when poll's page is purged
	 */
	public function doPurge() {
		parent::doPurge();

		wfDebug(__METHOD__ . "\n");

		// purge poll's data
		if (!empty($this->mQuiz)) {
			$this->mQuiz->purge();
		}
	}
}
