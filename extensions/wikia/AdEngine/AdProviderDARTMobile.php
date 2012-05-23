<?php
require_once dirname(__FILE__) . '/AdProviderDART.php';

class AdProviderDARTMobile extends AdProviderDART {

	public function getAd($slotname, $slot, $params = null){
		wfProfileIn(__METHOD__);

		$slot['size']='5x5'; // Odd convention for mobile

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";
                $out .= '<script type="text/javascript">' .
                "var url = AdConfig.DART.getMobileUrl('$slotname', '{$slot['size']}', true, 'DARTMobile');\n" .
		"document.write('<scr' + 'ipt type=\"text/javascript\" src=\"' + url + '\"></scr' + 'ipt>');\n" .
                "</script>";
		
		wfProfileOut(__METHOD__);
                return $out;
	}

        public static function getInstance() {
                if(self::$instance == false) {
                        self::$instance = new AdProviderDARTMobile();
                }
                return self::$instance;
        }

}
