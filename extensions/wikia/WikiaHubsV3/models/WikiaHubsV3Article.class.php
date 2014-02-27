<?php
class WikiaHubsV3Article extends Article {
	protected $verticalId = null;
	protected $hubTimestamp;

	public function __construct($title, $hubTimestamp = null) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);
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
		if (isset($this->hubTimestamp)) {
			$params['hubTimestamp'] = $this->hubTimestamp;
		}

		//render hub page
		$app = F::app();
		$app->wg->Out->addHTML( $app->sendRequest('WikiaHubsV3Controller', 'index', $params) );
		wfProfileOut(__METHOD__);
	}
}
