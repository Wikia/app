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

		'SPOTLIGHT_GLOBALNAV_1' => 6,
		'SPOTLIGHT_GLOBALNAV_2' => 6,
		'SPOTLIGHT_GLOBALNAV_3' => 6,
		'SPOTLIGHT_RAIL_1' => 6,
		'SPOTLIGHT_RAIL_2' => 6,
		'SPOTLIGHT_RAIL_3' => 6,
		'SPOTLIGHT_FOOTER_1' => 6,
		'SPOTLIGHT_FOOTER_2' => 6,
		'SPOTLIGHT_FOOTER_3' => 6,

		'default' => 0, // FIXME
	);


        private $slotsToCall = array();

		const WIKIA_AFFILIATE_ID = 2;

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

        public function batchCallAllowed(){ return false; }
        public function getSetupHtml(){ return false; }
        public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot, $params = null) {
		global $wgEnableOpenXSPC, $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			$nullAd = new AdProviderNull("Invalid slotname, no zoneid for $slotname in " . __CLASS__);
			return $nullAd->getAd($slotname, $slot);
		}

		$fillElemFunctionPrefix = AdEngine::fillElemFunctionPrefix;

		if ($wgEnableOpenXSPC) {
			$adtag = <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'>/*<![CDATA[*/
	document.write('<scr'+'ipt type="text/javascript">');
	document.write('OA_show($zoneId);');
	document.write('</scr'+'ipt>');
/*]]>*/</script>
EOT;
			//@todo use lazy loading
		}
		else {
			$adtag = '';

			if (!empty($wgEnableAdsLazyLoad) && !empty($wgAdslotsLazyLoad[$slotname]) && !empty($this->enable_lazyload)) {
				$adtag .= '<div class="'.AdEngine::lazyLoadAdClass.'" id="'.$slotname.'"></div>';
			}

			$adUrlScript = $this->getAdUrlScript($slotname, $params);
			$adUrlScript = str_replace("\n", " ", $adUrlScript);
			$adtag .= <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'>/*<![CDATA[*/
	document.write('<scr'+'ipt type="text/javascript">');
	document.write('$adUrlScript');
	document.write('</scr'+'ipt>');
EOT;
			if (!empty($wgEnableAdsLazyLoad) && !empty($wgAdslotsLazyLoad[$slotname]) && !empty($this->enable_lazyload)) {
				$fill_elem_script = <<<EOT
	{$fillElemFunctionPrefix}{$slotname} = function () {
		bezen.domwrite.capture();
		var parent = document.getElementById("{$slotname}"); 
		bezen.load.script(parent, base_url_{$slotname}, function(){
			bezen.domwrite.render(parent);
		});
		/* bezen.domwrite.restore(); */
	};
EOT;
				$fill_elem_script = str_replace("\n", ' ', $fill_elem_script);
				$adtag .= <<<EOT
	document.write('<scr'+'ipt type="text/javascript">{$fill_elem_script}</scr'+'ipt>');
/*]]>*/</script>
EOT;
			}
			else {
				$adtag .= <<<EOT
	document.write('<scr'+'ipt type="text/javascript" src="'+base_url_{$slotname}+'"></scr'+'ipt>');
/*]]>*/</script>
EOT;
			}
		}

		return $adtag;

	}

	public function getZoneId($slotname){
		if(isset($this->zoneIds[$slotname])){
			return $this->zoneIds[$slotname];
			} else {
				return $this->zoneIds['default'];
			}
	}

	protected function getAdUrlScript($slotname, $params=null, $is_iframe=false) {
		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			return;
		}

		if ($is_iframe) {
			$base_url = '/__spotlights/afr.php';
		}
		else {
			$base_url = '/__spotlights/ajs.php';
		}

		$url_script = self::getUrlScript($base_url, $slotname, $zoneId, '', $params);
		$adUrlScript = <<<EOT
	{$url_script}
	var base_url_{$slotname} = base_url;
EOT;

		return $adUrlScript;
	}

	public static function getOpenXSPCUrlScript() {
		$base_url = '/__spotlights/spcjs.php';

		$url_script = self::getUrlScript($base_url, '', '', self::WIKIA_AFFILIATE_ID);
		$openxspc_url_script = <<<EOT
	{$url_script}
	var openxspc_base_url = base_url;
EOT;

		return $openxspc_url_script;
	}

	protected static function getUrlScript($base_url, $slotname='', $zone_id='', $affiliate_id='', $params=null) {
		$cat=AdEngine::getCachedCategory();

		$additional_params = "";
		if (!empty($params) && is_array($params)) {
			foreach ($params as $key => $val) {
				$additional_params .= "&" . urlencode($key) . "=" . urlencode($val);
			}
		}

		$adUrlScript = <<<EOT
	var base_url = "$base_url";
	base_url += "?loc=" + escape(window.location);
	if(typeof document.referrer != "undefined") base_url += "&referer=" + escape(document.referrer);
	if(typeof document.context != "undefined") base_url += "&context=" + escape(document.context);
	if(typeof document.mmm_fo != "undefined") base_url += "&mmm_fo=1";
	base_url += "&target=_top";
	if(typeof AdsCB != "undefined") { base_url += "&cb=" + AdsCB; } else { base_url += "&cb=" + Math.floor(Math.random()*99999999); }
	if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url += "&exclude=" + document.MAX_used;
	base_url += "&hub={$cat['short']}";
	base_url += "&skin_name=" + skin;
	base_url += "&cont_lang=" + wgContentLanguage;
	base_url += "&user_lang=" + wgUserLanguage;
	base_url += "&dbname=" + wgDB;
	base_url += "&tags=" + wgWikiFactoryTagNames.join(",");
	base_url += "{$additional_params}";
	base_url += "&block=1";
EOT;

		if (!empty($slotname)) {
			$adUrlScript .= <<<EOT
	base_url += "&slotname={$slotname}";
EOT;
		}
		if (!empty($zone_id)) {
			$adUrlScript .= <<<EOT
	base_url += "&zoneid=$zone_id";
EOT;
		}
		if (!empty($affiliate_id)) {
			$adUrlScript .= <<<EOT
	base_url += "&id=$affiliate_id";
EOT;
		}
		
		return $adUrlScript;
	}

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
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

                return $out;
        }

}
