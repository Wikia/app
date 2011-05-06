<?php

/**
 * This class is used to render Quiz namespace page
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
		global $wgOut, $wgUser, $wgTitle, $wgJsMimeType, $wgExtensionsPath;
		wfProfileIn(__METHOD__);
		
		wfLoadExtensionMessages('WikiaQuiz');

		// let MW handle basic stuff
		parent::view();

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
	 * Purge poll (and articles embedding it) when poll's page is purged
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
