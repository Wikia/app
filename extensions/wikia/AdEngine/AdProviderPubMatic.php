<?php

class AdProviderPubMatic implements iAdProvider {

	private $pubId = "15208";
	private $siteId = "15209";

	private $kadids = array(
		'skyscraper' => '9743',
		'leaderboard' => '9744',
		'boxad' => '9745'
	);

	protected static $instance = false;

        private $slotsToCall = array();

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

	public function batchCallAllowed(){
		return false;
	}

	public function getBatchCallHtml(){
		return false;
	}

	public function getSetupHtml(){
		// TODO, see if we can call show_ads.js only once, and then just call a function multiple times
		return false;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderPubMatic();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot, $params = null){

		$kadid = $this->getKadid($slotname);
		if (empty($kadid)){
			$NullAd = new AdProviderNull("This slotname not available for AdProviderPubMatic", true);
			return $NullAd->getAd($slotname);
		}

                $dim=AdEngine::getHeightWidthFromSize($slot['size']);


                $out = "<!-- " . __CLASS__ . " slot: $slotname -->";
                $out .= '<script type="text/javascript">
			var pubId="' . addslashes($this->pubId) . '";
			var siteId="' . addslashes($this->siteId) . '";
			var kadId="' . addslashes($kadid) . '";
			var kadwidth="' . addslashes($dim['width']) . '";
			var kadheight="' . addslashes($dim['height']) . '";
			var kadtype=1;' .
			'</script>' . "\n" .
			'<script type="text/javascript" src="http://ads.pubmatic.com/AdServer/js/showad.js"></script>';
                return $out;
        }

	private function getKadId($slotname){
		$adtype = AdEngine::getInstance()->getAdType($slotname);
		if (isset($this->kadids[$adtype])){
			return $this->kadids[$adtype];
		} else {
			return false;
		}
	}

}
