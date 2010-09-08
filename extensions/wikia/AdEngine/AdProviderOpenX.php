<?php

class AdProviderOpenX extends AdProviderIframeFiller implements iAdProvider {

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

		'GLOBAL_NAV_SPOTLIGHT' => 6,

		'default' => 0, // FIXME
	);


        private $slotsToCall = array();

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

        public function batchCallAllowed(){ return false; }
        public function getSetupHtml(){ return false; }
        public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot, $params = null) {
		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			$nullAd = new AdProviderNull("Invalid slotname, no zoneid for $slotname in " . __CLASS__);
			return $nullAd->getAd($slotname, $slot);
		}

		$adUrlScript = $this->getAdUrlScript($slotname, $params);
		$adUrlScript = str_replace("\n", " ", $adUrlScript);
		$adtag = <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'>/*<![CDATA[*/
	document.write('<scr'+'ipt type="text/javascript">');
	document.write('$adUrlScript');
	document.write('</scr'+'ipt>');
	document.write('<scr'+'ipt type="text/javascript" src="'+base_url_{$slotname}+'"></scr'+'ipt>');

/*]]>*/</script>
EOT;

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
		$cat=AdEngine::getCachedCategory();

		if(empty($zoneId)){
			return;
		}

		$additional_params = "";
		if (!empty($params) && is_array($params)) {
			foreach ($params as $key => $val) {
				$additional_params .= "&" . urlencode($key) . "=" . urlencode($val);
			}
		}

		if ($is_iframe) {
			$base_url = '/__spotlights/afr.php';
		}
		else {
			$base_url = '/__spotlights/ajs.php';
		}

		$adUrlScript = <<<EOT
	var base_url_{$slotname} = "$base_url";
	base_url_{$slotname} += "?loc=" + escape(window.location);
	if(typeof document.referrer != "undefined") base_url_{$slotname} += "&referer=" + escape(document.referrer);
	if(typeof document.context != "undefined") base_url_{$slotname} += "&context=" + escape(document.context);
	if(typeof document.mmm_fo != "undefined") base_url_{$slotname} += "&mmm_fo=1";
	base_url_{$slotname} += "&zoneid=$zoneId";
	base_url_{$slotname} += "&target=_top";
	base_url_{$slotname} += "&cb=" + AdsCB;
	if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url_{$slotname} += "&exclude=" + document.MAX_used;
	base_url_{$slotname} += "&hub={$cat['short']}";
	base_url_{$slotname} += "&skin_name=" + skin;
	base_url_{$slotname} += "&cont_lang=" + wgContentLanguage;
	base_url_{$slotname} += "&user_lang=" + wgUserLanguage;
	base_url_{$slotname} += "&dbname=" + wgDB;
	base_url_{$slotname} += "&slotname={$slotname}";
	base_url_{$slotname} += "&tags=" + wgWikiFactoryTagNames.join(",");
	base_url_{$slotname} += "{$additional_params}";
	base_url_{$slotname} += "&block=1";
EOT;

		return $adUrlScript;
	}

        protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		$this->useIframe = true;

		$adUrlScript = $this->getAdUrlScript($slotname, null, true);
                $out = '<script type="text/javascript">' .
			$adUrlScript .
			// wlee: removing property 'display' is a hack to force FOOTER_SPOTLIGHT_LEFT to show up. not sure
			// why this ad slot has "display: none" in the first place
                        $function_name . ' = function() { ' .
			'var ad_iframe = document.getElementById("' . addslashes($slotname) ."_iframe\"); ad_iframe.src = base_url_".addslashes($slotname)."; if (ad_iframe.style.removeAttribute) {ad_iframe.style.removeAttribute(\"display\");} else {ad_iframe.style.removeProperty(\"display\");} }</script>";

                return $out;
        }

}
