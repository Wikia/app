<?php

class AdProviderContextWeb implements iAdProvider {

        protected static $instance = false;

	private $cwpid = 504082; // Context Web Account id

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
                        self::$instance = new AdProviderContextWeb();
                }
                return self::$instance;
        }


        public function getAd($slotname, $slot, $params = null){

		$cwtagid = self::getCwtagid($slot);

		if (empty($cwtagid)){
			$NullAd = new AdProviderNull("cwtagid must be supplied", true);
			return $NullAd->getAd($slotname, $slot);
		}

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";

                $dim=AdEngine::getHeightWidthFromSize($slot['size']);

		$url = "http://tag.contextweb.com/TagPublish/getjs.aspx?action=VIEWAD&cwrun=200&cwadformat=" . $slot['size'] .
		        "&cwpid=" . $this->cwpid . "&cwwidth=" . $dim['width'] . "&cwheight=" . $dim['height'] .
			"&cwpnet=1&cwtagid=" . urlencode($cwtagid);

                $out .= '<script type="text/javascript" src="' . $url . '"></script>';
		return $out;
        }


	public function getCwtagid($slot){
		switch ($slot['size']){
		  case '160x600': return '45460';
		}
		
	}
}
