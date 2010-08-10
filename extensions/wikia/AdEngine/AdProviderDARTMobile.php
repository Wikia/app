<?php
require_once dirname(__FILE__) . '/AdProviderDART.php';

class AdProviderDARTMobile extends AdProviderDART {

	public function getAd($slotname, $slot, $params = null){
		$slot['size']='5x5'; // Odd convention for mobile

		$url = 'http://ad.mo.doubleclick.net/DARTProxy/mobile.handler?k=' .
			$this->getDartSite($this->getHub()) . '/' .
			$this->getZone1() . '/' .
			$this->getZone2() . ';' .
			$this->getProviderValues($slot) . 
			$this->getArticleKV() . 
			$this->getDomainKV($_SERVER['HTTP_HOST']) .
			'pos=' . $slotname . ';' .
			$this->getKeywordsKV() .
			$this->getLocKV($slotname) .
			$this->getDcoptKV($slotname) .
			"sz=" . $slot['size'] . ';' .
			$this->getTileKV($slotname) . 
			'&dw=1'; 

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";
		$out .= '<script type="text/javascript" src="' . $url . '"></script>';

		return $out;
	}

        public static function getInstance() {
                if(self::$instance == false) {
                        self::$instance = new AdProviderDARTMobile();
                }
                return self::$instance;
        }

}
