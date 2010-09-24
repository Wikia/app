<?php
class SpotlightsModule extends Module {

	var $wgEnableAdsLazyLoad;
	var $wgBlankImgUrl;
	var $wgSingleH1;
	var $mode;
	var $adslots;
	var $n_adslots;
	var $sectionId;
	var $titleMsg;

	public function executeIndex($params) {
		$this->mode = $params['mode'];
		$this->adslots = $params['adslots'];
		$this->n_adslots = sizeof($this->adslots);
		if (!empty($params['sectionId'])) {
			$this->sectionId = $params['sectionId'];
		}
		$this->titleMsg = 'oasis-spotlights-' . strtolower($params['mode']) . '-title';
	}

}
