<?php

class AdProviderOpenX implements iAdProvider {

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
		'default' => 0, // FIXME
	);


        private $slotsToCall = array();

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

        public function batchCallAllowed(){ return false; }
        public function getSetupHtml(){ return false; }
        public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot) {
		$cat=AdEngine::getCachedCategory();
		$zoneId = $this->getZoneId($slotname);

		if(empty($zoneId)){
			$nullAd = new AdProviderNull("Invalid slotname, no zoneid for $slotname in " . __CLASS__);
			return $nullAd->getAd($slotname, $slot);
		}

		$adtag = <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'>/*<![CDATA[*/

	document.write('<scr'+'ipt type="text/javascript">');
	document.write('var base_url = "http://spotlights.wikia.com/ajs.php";');
	document.write('base_url += "?loc=" + escape(window.location);');
	document.write('if(typeof document.referrer != "undefined") base_url += "&referer=" + escape(document.referrer);');
	document.write('if(typeof document.context != "undefined") base_url += "&context=" + escape(document.context);');
	document.write('if(typeof document.mmm_fo != "undefined") base_url += "&mmm_fo=1";');
	document.write('base_url += "&zoneid=$zoneId";');
	document.write('base_url += "&cb=" + AdsCB;');
	document.write('if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url += "&exclude=" + document.MAX_used;');
	document.write('base_url += "&hub={$cat['name']}";');
	document.write('base_url += "&skin_name=" + skin;');
	document.write('base_url += "&cont_lang=" + wgContentLanguage;');
	document.write('base_url += "&user_lang=" + wgUserLanguage;');
	document.write('base_url += "&dbname=" + wgDB;');
	document.write('base_url += "&slotname={$slotname}";');
	document.write('base_url += "&block=1";');
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

}
