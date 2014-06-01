<?php
class WikiaHubsV2Article extends Article {
	protected $verticalId = null;
	protected $hubTimestamp;

	public function __construct($title, $verticalId, $hubTimestamp = null) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
		$this->verticalId = $verticalId;
		$this->hubTimestamp = $hubTimestamp;

		$this->mPage = new WikiaHubsV2Page($title);

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
		if (isset($this->hubTimestamp)) {
			$params['hubTimestamp'] = $this->hubTimestamp;
		}

		//render hub page
		$app = F::app();
		$app->wg->Out->clearHTML();
		$app->wg->Out->addHTML( $app->sendRequest('WikiaHubsV2Controller', 'index', $params) );
		wfProfileOut(__METHOD__);
	}
}
