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

		$params = array();
		if (!empty($this->verticalId)) {
			$params['verticalid'] = $this->verticalId;
		}

		//render hub page
		$app = F::app();
		$app->wg->Out->clearHTML();
		$app->wg->Out->addHTML( $app->sendRequest('SpecialWikiaHubsV2Controller', 'index', $params) );
		wfProfileOut(__METHOD__);
	}
}
