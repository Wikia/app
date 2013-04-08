<?php
class WAMPageArticle extends Article {
	const WAM_PAGE_NAME = 'WAM';
	const WAM_FAQ_PAGE_NAME = 'WAM/FAQ';

	public function __construct($title) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
		$this->mPage = new WAMPage($title);
		
		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Render hubs page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		// let MW handle basic stuff
		parent::view();

		$app = F::app();
		$app->wg->Out->clearHTML();
		
		if( $this->isWAMFAQPage($this->getTitle()) ) {
			$action = 'faq';
		} else {
			$action = 'index';
		}
		
		$app->wg->Out->addHTML( $app->sendRequest('WAMPageController', $action, $app->wg->request->getValues()) );
		wfProfileOut(__METHOD__);
	}

	protected function isWAMFAQPage(Title $title) {
		return $title->isSubpage() && $title->getDBKey() == self::WAM_FAQ_PAGE_NAME;
	}
	
}
