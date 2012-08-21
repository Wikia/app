<?php
class WikiaHubsV2Article extends Article {
	protected $verticalId = null;

	public function __construct($title, $verticalId) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
		$this->verticalId = $verticalId;

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Render hubs page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		// let MW handle basic stuff
		parent::view();

		//render hub page
		$app = F::app();
		if( !empty($this->verticalId) ) {
			RequestContext::getMain()->getRequest()->setVal('verticalid', $this->verticalId);
		}
		$app->wg->Out->clearHTML();
		$app->wg->Out->addHTML( $app->sendRequest('SpecialWikiaHubsV2Controller', 'index') );

		wfProfileOut(__METHOD__);
	}
}
