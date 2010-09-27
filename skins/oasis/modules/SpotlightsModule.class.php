<?php
class SpotlightsModule extends Module {

	var $wgBlankImgUrl;
	var $wgSingleH1;
	var $wgNoExternals;
	var $mode;
	var $adslots;
	var $n_adslots;
	var $sectionId;
	var $titleMsg;
	var $adGroupName;
	var $useLazyLoadAdClass;

	public function executeIndex($params) {
		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		$this->mode = $params['mode'];
		$this->adslots = $params['adslots'];
		$this->n_adslots = sizeof($this->adslots);
		if (!empty($params['sectionId'])) {
			$this->sectionId = $params['sectionId'];
		}
		$this->titleMsg = 'oasis-spotlights-' . strtolower($params['mode']) . '-title';
		$this->adGroupName = $params['adGroupName'];

		$this->useLazyLoadAdClass = true;
		if (empty($wgEnableAdsLazyLoad)) {
			$this->useLazyLoadAdClass = false;
		}
		else {
			for ($i=0; $i<$this->n_adslots; $i++) {
				$slotname =& $this->adslots[$i];
				if (empty($wgAdslotsLazyLoad[$slotname])) {
					$this->useLazyLoadAdClass = false;
					break;
				}
			}
		}
	}

}
