<?php
class SpotlightsModule extends Module {

	var $wgBlankImgUrl;
	var $wgSingleH1;
	var $wgNoExternals;
	var $wgEnableOpenXSPC;
	var $mode;
	var $adslots;
	var $n_adslots;
	var $sectionId;
	var $titleMsg;
	var $adGroupName;
	var $useLazyLoadAdClass;
	var $forceContent; # array that overrides declared spotlight display, used for for example in Related Videos

/**
 * This method displays spotlights.  Since they appear in two places, it has a required parameter.
 *
 * @param Array params All params are contained in this array.
 * @param String mode  Must be either 'rail' or 'footer'
 *
 * This param is used to choose the title message, currently one of:
 * 'oasis-spotlights-rail-title' => 'Wikia Spotlights',
 * 'oasis-spotlights-footer-title' => "Around Wikia's Network",
 *
 */

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

		wfRunHooks('BeforeExecuteSpotlightsIndex', array( &$this ));

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
