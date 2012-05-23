<?php

class AdProviderOpenX extends AdProviderIframeFiller implements iAdProvider {

	public $enable_lazyload = true;
	private $useIframe = false;

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderOpenX();
		}
		return self::$instance;
	}

	protected static $adSlotInLazyLoadGroup = array();

	// TODO, get these out of code and configurable
	private $zoneIds = array(
		'FOOTER_SPOTLIGHT_LEFT' => 3,
		'FOOTER_SPOTLIGHT_MIDDLE' => 3,
		'FOOTER_SPOTLIGHT_RIGHT' => 3,
		'FOOTER_SPOTLIGHT_MIDDLE_LEFT' => 3,
		'FOOTER_SPOTLIGHT_MIDDLE_RIGHT' => 3,

		'LEFT_NAV_205x400' => 4,

		'CORP_TOP_RIGHT_BOXAD' => 5,
		'EXIT_STITIAL_BOXAD_1' => 5,
		'EXIT_STITIAL_BOXAD_2' => 5,
		'HOME_TOP_RIGHT_BOXAD' => 5,
		'PREFOOTER_LEFT_BOXAD' => 5,
		'PREFOOTER_RIGHT_BOXAD' => 5,
		'SPECIAL_INTERSTITIAL_BOXAD_1' => 5,
		'TOP_RIGHT_BOXAD' => 5,

		// will: moving init of spotlights to __construct(). temporary move.
		//'SPOTLIGHT_GLOBALNAV_1' => 20,
		//'SPOTLIGHT_GLOBALNAV_2' => 21,
		//'SPOTLIGHT_GLOBALNAV_3' => 22,
		//'SPOTLIGHT_RAIL_1' => 17,
		//'SPOTLIGHT_RAIL_2' => 18,
		//'SPOTLIGHT_RAIL_3' => 19,
		//'SPOTLIGHT_FOOTER_1' => 14,
		//'SPOTLIGHT_FOOTER_2' => 15,
		//'SPOTLIGHT_FOOTER_3' => 16,

		'default' => 0, // FIXME
	);

        private $slotsToCall = array();

		const WIKIA_AFFILIATE_ID = 2;
		const OASIS_SPOTLIGHTS_AFFILIATE_ID = 3;

	public function __construct() {

		global $wgEnableSpotlightsV2_GlobalNav, $wgEnableSpotlightsV2_Rail, $wgEnableSpotlightsV2_Footer;
		global $wgEnableOpenXSPC;

		if($wgEnableSpotlightsV2_GlobalNav) {
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_1'] = 20;
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_2'] = 21;
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_3'] = 22;
		} else {
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_1'] = 6;
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_2'] = 6;
			$this->zoneIds['SPOTLIGHT_GLOBALNAV_3'] = 6;
		}

		if($wgEnableSpotlightsV2_Rail) {
			$this->zoneIds['SPOTLIGHT_RAIL_1'] = 17;
			$this->zoneIds['SPOTLIGHT_RAIL_2'] = 18;
			$this->zoneIds['SPOTLIGHT_RAIL_3'] = 19;
		} else {
			$this->zoneIds['SPOTLIGHT_RAIL_1'] = 6;
			$this->zoneIds['SPOTLIGHT_RAIL_2'] = 6;
			$this->zoneIds['SPOTLIGHT_RAIL_3'] = 6;
		}

		if($wgEnableSpotlightsV2_Footer) {
			$this->zoneIds['SPOTLIGHT_FOOTER_1'] = 14;
			$this->zoneIds['SPOTLIGHT_FOOTER_2'] = 15;
			$this->zoneIds['SPOTLIGHT_FOOTER_3'] = 16;
		} else {
			$this->zoneIds['SPOTLIGHT_FOOTER_1'] = 6;
			$this->zoneIds['SPOTLIGHT_FOOTER_2'] = 6;
			$this->zoneIds['SPOTLIGHT_FOOTER_3'] = 6;
		}

		// OpenX SPC should not be used with zone 6. If zone 6 is used, turn off SPC
		if (!$wgEnableSpotlightsV2_GlobalNav || !$wgEnableSpotlightsV2_Rail || !$wgEnableSpotlightsV2_Footer) {
			$wgEnableOpenXSPC = false;
		}

	}

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

        public function batchCallAllowed(){ return false; }
        public function getSetupHtml(){ return false; }
        public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot, $params = null) {
		wfProfileIn(__METHOD__);

		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad, $wgEnableOpenXSPC;

		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			$nullAd = new AdProviderNull("Invalid slotname, no zoneid for $slotname in " . __CLASS__);
			wfProfileOut(__METHOD__);
			return $nullAd->getAd($slotname, $slot);
		}

		if (!empty(self::$adSlotInLazyLoadGroup[$slotname])) {
			wfProfileOut(__METHOD__);
			return;
		}

		$adtag = '';
		$adtag .= <<<EOT
<script type='text/javascript'>
	wgAfterContentAndJS.push(function() {
EOT;
		$adtag .= $this->getAdUrlScripts(array($slotname), array($zoneId), $params);
		if ($wgEnableOpenXSPC || 
		(!empty($wgEnableAdsLazyLoad) && !empty($wgAdslotsLazyLoad[$slotname]) && !empty($this->enable_lazyload))) {
			$functionName = AdEngine::fillElemFunctionPrefix . $slotname;
			$fill_elem_script = $this->getFillElemFunctionDefinition($functionName, array($slotname));
			$adtag .= <<<EOT
	$fill_elem_script
EOT;
			if (empty($wgEnableAdsLazyLoad) || empty($wgAdslotsLazyLoad[$slotname]) || empty($this->enable_lazyload)) {
				// setTimeout makees it much more likely that the OpenX SPC will have completed by the time
				// the call to display the ad is made
				$adtag .= <<<EOT
	setTimeout($functionName, 1000);
EOT;
			}
		}
		else {
			$adtag .= <<<EOT
	document.write('<scr'+'ipt type="text/javascript" src="'+base_url_{$slotname}+'"></scr'+'ipt>');
EOT;
		}

		$adtag .= <<<EOT
	});
</script>
EOT;

		wfProfileOut(__METHOD__);

		return $adtag;

	}

	/**
	 * call to this method must precede calls to getAd()
	 */
	public function getLazyLoadableAdGroup($adGroupName, Array $slotnames, $params=null) {
		wfProfileIn(__METHOD__);

		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		if (empty($wgEnableAdsLazyLoad) || empty($this->enable_lazyload)) {
			wfProfileOut(__METHOD__);
			return '';
		}

		$n_slotnames = sizeof($slotnames);
		if (!$n_slotnames) {
			wfProfileOut(__METHOD__);
			return '';
		}

		$zoneIds = array();
		foreach ($slotnames as $slotname) {
			$zoneId = $this->getZoneId($slotname);
			if(empty($zoneId)){
				wfProfileOut(__METHOD__);
				return '';
			}
			elseif (empty($wgAdslotsLazyLoad[$slotname])) {
				wfProfileOut(__METHOD__);
				return '';
			}
			else {
				$zoneIds[] = $zoneId;
			}
		}

		$adtag = <<<EOT
<script type='text/javascript'>
	wgAfterContentAndJS.push(function() {
EOT;
		// urls of scripts for slots
		$adtag .= $this->getAdUrlScripts($slotnames, $zoneIds, $params);
		// fillElem function definitions
		$functionName = AdEngine::fillElemFunctionPrefix . $adGroupName;
		$fill_elem_script = $this->getFillElemFunctionDefinition($functionName, $slotnames);
		$adtag .= <<<EOT
		$fill_elem_script
	});
</script>
EOT;

		// leave marker that these slots are in a lazy load group.
		// getAd() will use these markers
		foreach ($slotnames as $slotname) {
			self::$adSlotInLazyLoadGroup[$slotname] = true;
		}

		wfProfileOut(__METHOD__);

		return $adtag;
	}

	private function getAdUrlScripts($slotnames, $zoneIds, $params) {
		wfProfileIn(__METHOD__);
	
		$n_slotnames = sizeof($slotnames);
		$adtag = "";
		for ($i=0; $i<$n_slotnames; $i++) {
			$slotname =& $slotnames[$i];
			$adUrlScript = $this->getAdUrlScript($slotname, $params);
			$adUrlScript = $this->fixNewLines($adUrlScript);
			$adtag .= $adUrlScript;
		}

		wfProfileOut(__METHOD__);

		return $adtag;
	}

	private function getFillElemFunctionDefinition($functionName, Array $slotnames) {
		wfProfileIn(__METHOD__);

		// This function addresses two cases: OpenX SPC is fully loaded before LazyLoadAds.js
		// displays this Spotlight, and OpenXSPC is not fully loaded yet.

		// In both cases, the code that actually displays the contents of the Spotlight is
		// the same. Here is that code.
		$out = <<<EOT
	{$functionName}_helper = function() {
		if (typeof OA_output != 'undefined') {
EOT;
		for ($i = 0; $i < count($slotnames); $i++) {
			$out .= <<<EOT
			if (typeof OA_output['{$this->zoneIds[$slotnames[$i]]}'] != 'undefined') {
				$('#{$slotnames[$i]}').html(OA_output['{$this->zoneIds[$slotnames[$i]]}']);
			}
EOT;
		}
		$out .= <<<EOT
		}
	};
EOT;

		// The following function is called by LazyLoadAds.js to show this Spotlight.
		$out .= <<<EOT
	{$functionName} = function () {
		{$functionName}_helper();
	};
EOT;

		// The following code covers the case when OpenX SPC has not finished loading.
		// Here, we have to define a new function, because LazyLoadAds.js has redefined the
		// function above to null.
		$out .= <<<EOT
	if (typeof OA_output == 'undefined') {
		{$functionName}_callback = function() {
			{$functionName}_helper();	
		};
EOT;
		// After defining this function, register it as a callback for the OpenX SPC loader.
		// (See AdProviderOpenX.js for more info.)
		$out .= <<<EOT
		if (typeof window.spcCallbacks == 'undefined') {
			window.spcCallbacks = new Array();
		}
		window.spcCallbacks.push('{$functionName}_callback');
	}
EOT;
		wfProfileOut(__METHOD__);

		return $out;
	}

	public function getZoneId($slotname){
		if(isset($this->zoneIds[$slotname])){
			return $this->zoneIds[$slotname];
			} else {
				return $this->zoneIds['default'];
			}
	}

	protected function getAdUrlScript($slotname, $params=null, $is_iframe=false) {
		wfProfileIn(__METHOD__);
		
		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			wfProfileOut(__METHOD__);
			return;
		}

		global $wgEnableOpenXSPC;
		if ( F::app()->checkSkin( 'oasis' ) && $wgEnableOpenXSPC && substr($slotname, 0, 10) == 'SPOTLIGHT_') {	// only for Oasis spotlights (e.g. slotname = "SPOTLIGHT_ ...")
			wfProfileOut(__METHOD__);
			// don't need a url. will show ad using local Javascript
			return;
		}
		else {
			if ($is_iframe) {
				$base_url = '/__spotlights/afr.php';
			}
			else {
				$base_url = '/__spotlights/ajs.php';
			}

			$url_script = self::getUrlScript($base_url, $slotname, $zoneId, '', $params);
		}

		$adUrlScript = <<<EOT
	{$url_script}
	var base_url_{$slotname} = base_url;
EOT;

		wfProfileOut(__METHOD__);

		return $adUrlScript;
	}

	public static function getOpenXSPCUrlScript($affiliate_id=self::WIKIA_AFFILIATE_ID) {
		wfProfileIn(__METHOD__);

		$base_url = '/__spotlights/spcjs.php';

		$url_script = self::getUrlScript($base_url, '', '', $affiliate_id);
		$openxspc_url_script = <<<EOT
	{$url_script}
	var openxspc_base_url = base_url;
EOT;

		wfProfileOut(__METHOD__);

		return $openxspc_url_script;
	}

	protected static function getUrlScript($base_url, $slotname='', $zone_id='', $affiliate_id='', $params=null) {
		wfProfileIn(__METHOD__);

		$cat=AdEngine::getCachedCategory();

		$additional_params = "";
		if (!empty($params) && is_array($params)) {
			foreach ($params as $key => $val) {
				$additional_params .= "&" . urlencode($key) . "=" . urlencode($val);
			}
		}

		$adUrlScript = <<<EOT
	base_url = AdProviderOpenX.getUrl("$base_url", "$slotname", "$zone_id", "$affiliate_id", "{$cat['short']}", "$additional_params");
EOT;

		wfProfileOut(__METHOD__);

		return $adUrlScript;
	}

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		wfProfileIn(__METHOD__);
		
		$this->useIframe = true;

		$adUrlScript = $this->getAdUrlScript($slotname, null, true);
		// wlee: removing property 'display' is a hack to force FOOTER_SPOTLIGHT_LEFT to show up. not sure
		// why this ad slot has "display: none" in the first place
		// RT #65988: must clone iframe, set src then append to parentNode. Setting src on original iframe creates unnecessary entry in browser history
		$out = '<script type="text/javascript">' .
			$adUrlScript .
                        $function_name . ' = function() { ' .
			'var ad_iframeOld = document.getElementById("' . addslashes($slotname) ."_iframe\"); " .
			'if (typeof ad_iframeOld == "undefined") { return; } ' .
			"var parent_node = ad_iframeOld.parentNode; ad_iframe = ad_iframeOld.cloneNode(true); " .
			"ad_iframe.src=base_url_".addslashes($slotname) .
			"; parent_node.removeChild(ad_iframeOld); parent_node.appendChild(ad_iframe); " .
			"if (ad_iframe.style.removeAttribute) {ad_iframe.style.removeAttribute(\"display\");} else {ad_iframe.style.removeProperty(\"display\");} }</script>";
			//'var ad_iframe = document.getElementById("' . addslashes($slotname) ."_iframe\"); ad_iframe.src=base_url_".addslashes($slotname)."; if (ad_iframe.style.removeAttribute) {ad_iframe.style.removeAttribute(\"display\");} else {ad_iframe.style.removeProperty(\"display\");} }</script>";

		wfProfileOut(__METHOD__);

		return $out;
	}

	protected function fixNewLines( $text ) {
		$order = array("\r\n", "\n", "\r");
		$replace = ' ';
		return str_replace($order,$replace,$text);
	}

}

