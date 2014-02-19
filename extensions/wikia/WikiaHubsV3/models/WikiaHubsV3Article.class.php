<?php
class WikiaHubsV3Article extends Article {
	protected $verticalId = null;
	protected $hubTimestamp;

	public function __construct($title, $verticalId, $hubTimestamp = null) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
		$this->verticalId = $verticalId;
		$this->hubTimestamp = $hubTimestamp;

		$this->mPage = new WikiaHubsV3Page($title);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render hubs page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		$params = array();
		if (!empty($this->verticalId)) {
			$params['verticalid'] = $this->verticalId;
		}
		if (isset($this->hubTimestamp)) {
			$params['hubTimestamp'] = $this->hubTimestamp;
		}

		//render hub page
		$app = F::app();
		//$app->wg->Out->clearHTML();
		$app->wg->Out->addHTML( $app->sendRequest('WikiaHubsV3Controller', 'index', $params) );
		wfProfileOut(__METHOD__);
	}
}
