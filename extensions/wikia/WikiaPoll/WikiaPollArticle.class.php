<?php

/**
 * This class is used to render Poll namespace page
 */

class WikiaPollArticle extends Article {

	private $mPoll;

	function __construct($title) {
		parent::__construct($title);

		$this->mPoll = WikiaPoll::newFromArticle($this);
	}

	/**
	 * Render Poll namespace page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		// let MW handle basic stuff
		parent::view();

		$wg = F::app()->wg;

		// poll doesn't exist
		if (!$wg->Title->exists() || empty($this->mPoll)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// set page title
		$question = wfMsg('wikiapoll-question', $this->mPoll->getTitle());
		$wg->Out->setPageTitle($question);

		// add CSS/JS
		$wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaPoll/css/WikiaPoll.scss'));
		$jsFile = JSSnippets::addToStack(
			array( '/extensions/wikia/WikiaPoll/js/WikiaPoll.js' ),
			array(),
			'WikiaPoll.init'
		);

		// render poll page
		$wg->Out->clearHTML();
		$wg->Out->addHTML($jsFile);
		$wg->Out->addHTML($this->mPoll->render());

		wfProfileOut(__METHOD__);
	}

	/**
	 * Purge poll (and articles embedding it) when poll's page is purged
	 */
	public function doPurge() {
		parent::doPurge();

		wfDebug(__METHOD__ . "\n");

		// purge poll's data
		if (!empty($this->mPoll)) {
			$this->mPoll->purge();
		}
	}
}
