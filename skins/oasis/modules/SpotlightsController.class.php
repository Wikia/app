<?php
class SpotlightsController extends WikiaController {

	/*
	var $wgBlankImgUrl;
	var $wgNoExternals;
	var $wgEnableOpenXSPC;
	var $wgEnableSpotlightsV2_Footer;
	var $wgEnableSpotlightsV2_Rail;
	var $adslots;
	var $n_adslots;
	var $sectionId;
	var $titleMsg;
	var $adGroupName;
	var $useLazyLoadAdClass;
	var $forceContent; # array that overrides declared spotlight display, used for for example in Related Videos
	*/
/**
 * This method displays spotlights.  Since they appear in two places, it has a required parameter.
 *
 * @param Array params All params are contained in this array.
 *
 */
	
	public function init() {
		$this->sectionId = null;
		$this->useLazyLoadAdClass = true;
	}

	public function executeIndex($params) {
		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad, $wgSuppressSpotlights;
		
		//introducing new global var to remove
		//spotlights on hubs
		if( !empty($wgSuppressSpotlights) ) {
			$this->skipRendering();
			return;
		}
		
		$this->adslots = $params['adslots'];
		$this->n_adslots = sizeof($this->adslots);
		if (!empty($params['sectionId'])) {
			$this->sectionId = $params['sectionId'];
		}
		$this->titleMsg = 'oasis-spotlights-footer-title';
		$this->adGroupName = $params['adGroupName'];

		if (empty($wgEnableAdsLazyLoad)) {
			$this->useLazyLoadAdClass = false;
		}
		else {
			for ($i=0; $i<$this->n_adslots; $i++) {
				if(isset($this->adslots[$i])) {
					$slots = $this->adslots;
					$slotname =& $slots[$i];
					if (empty($wgAdslotsLazyLoad[$slotname])) {
						$this->useLazyLoadAdClass = false;
						break;
					}
				}
			}
		}
	}
}
