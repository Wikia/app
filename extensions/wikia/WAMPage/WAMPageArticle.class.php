<?php
class WAMPageArticle extends Article {
	public function __construct($title) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
		
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
		$app->wg->Out->addHTML( $app->sendRequest('WAMPageSpecialController', 'index') );
		
		wfProfileOut(__METHOD__);
	}
	
}
