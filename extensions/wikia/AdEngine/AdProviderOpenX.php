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
		'HOME_TOP_LEADERBOARD' => 626,
		'HOME_TOP_RIGHT_BOXAD' => 627,
		'HOME_LEFT_SKYSCRAPER_1' => 628,
		'HOME_LEFT_SKYSCRAPER_2' => 629,
		'TOP_LEADERBOARD' => 630,
		'TOP_RIGHT_BOXAD' => 631,
		'LEFT_SKYSCRAPER_1' => 632,
		'LEFT_SKYSCRAPER_2' => 633,
		'LEFT_SKYSCRAPER_3' => 652, 
		'FOOTER_BOXAD' => 634,
		'RIGHT_SKYSCRAPER_1' => 452 // Monobook
	);

	private $spotlightCategoryZones = array(
		'2' => 635, // Gaming
		'3' => 636, // Entertainment
		'5' => 637,
		'9' => 637,
		'12' => 637,
		'15' => 637,
		'16' => 637,
		'18' => 637,
		'19' => 637,
		'default' => 638
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
		$zoneId = $this->getZoneId($slotname, $cat['id']);

$cat = array("id" => 1);
$zoneId = 3;

		if(empty($zoneId)){
			$nullAd = new AdProviderNull("Invalid slotname, no zoneid for $slotname in " . __CLASS__);
			return $nullAd->getAd($slotname, $slot);
		}

		$adtag = <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'>/*<![CDATA[*/

	var source = Array();
	source.push('slot=$slotname');
	source.push('catid={$cat['id']}');
	source.push('lang=' + wgContentLanguage);

	document.write('<scr'+'ipt type="text/javascript">');
	document.write('var base_url = "http://spotlights.wikia.com/ajs.php";');
	document.write('base_url += "?loc=" + escape(window.location);');
	document.write('if(typeof document.referrer != "undefined") base_url += "&referer=" + escape(document.referrer);');
	document.write('if(typeof document.context != "undefined") base_url += "&context=" + escape(document.context);');
	document.write('if(typeof document.mmm_fo != "undefined") base_url += "&mmm_fo=1";');
	document.write('base_url += "&zoneid=$zoneId";');
	document.write('base_url += "&cb=" + AdsCB;');
	document.write('if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url += "&exclude=" + document.MAX_used;');
	document.write('base_url += "&source='+source.join(';')+'";');
	document.write('base_url += "&block=1";');
	document.write('</scr'+'ipt>');
	document.write('<scr'+'ipt type="text/javascript" src="'+base_url+'"></scr'+'ipt>');

/*]]>*/</script>
EOT;
		return $adtag;

	}

	// Logic for zoneids documented here: http://staff.wikia-inc.com/wiki/Ad_Slots
	public function getZoneId($slotname, $catid){
		if(isset($this->zoneIds[$slotname])){
			return $this->zoneIds[$slotname];
		} else if (AdEngine::getInstance()->getAdType($slotname) == 'spotlight'){
			// For spotlights, they all have the same zoneid, determined by category.
			if(isset($this->spotlightCategoryZones[$catid])){
				return $this->spotlightCategoryZones[$catid];
			} else {
				return $this->spotlightCategoryZones['default'];
			}
		} else {
			return null;
		}
	}

}
