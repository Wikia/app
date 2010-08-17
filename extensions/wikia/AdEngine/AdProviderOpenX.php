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
	document.write('<scr'+'ipt type="text/javascript" src="'+base_url+'"></scr'+'ipt>');

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
	var base_url = "$base_url";
	base_url += "?loc=" + escape(window.location);
	if(typeof document.referrer != "undefined") base_url += "&referer=" + escape(document.referrer);
	if(typeof document.context != "undefined") base_url += "&context=" + escape(document.context);
	if(typeof document.mmm_fo != "undefined") base_url += "&mmm_fo=1";
	base_url += "&zoneid=$zoneId";
	base_url += "&cb=" + AdsCB;
	if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url += "&exclude=" + document.MAX_used;
	base_url += "&hub={$cat['short']}";
	base_url += "&skin_name=" + skin;
	base_url += "&cont_lang=" + wgContentLanguage;
	base_url += "&user_lang=" + wgUserLanguage;
	base_url += "&dbname=" + wgDB;
	base_url += "&slotname={$slotname}";
	base_url += "&tags=" + wgWikiFactoryTagNames.join(",");
	base_url += "{$additional_params}";
	base_url += "&block=1";
EOT;
	
		return $adUrlScript;
	}

        protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		$this->useIframe = true;

		$adUrlScript = $this->getAdUrlScript($slotname, null, true);
                $out = '<script type="text/javascript">' .
			$adUrlScript .
                        $function_name . ' = function() { ' .
			'document.getElementById("' . addslashes($slotname) .'_iframe").src = base_url; }</script>';

                return $out;
        }

}
