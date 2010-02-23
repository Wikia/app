<?php
require_once dirname(__FILE__) . '/AdProviderDART.php';

class AdProviderDARTMobile extends AdProviderDART {

	/* 
 	<script type="text/javascript" src="http://ad.mo.doubleclick.net/DARTProxy/mobile.handler?k=wka.gaming/_Phantasystar/home;sz=5x5&ip=[device IP]&ua=[device user agent]&dw=1"></script>
 */
	public function getAd($slotname, $slot){
		$slot['size']='5x5'; // Odd convention for mobile

		$url = 'http://ad.mo.doubleclick.net/DARTProxy/mobile.handler?k=' .
			$this->getDartSite() . '/' .
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
			$this->getTileKV($slotname); 

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";
		$out .= '<script type="text/javascript">/*<![CDATA[*/' . "\n";
		// Ug. Heredocs suck, but with all the combinations of quotes, it was the cleanest way.
		$out .= <<<EOT
		dartUrl = "$url";
		document.write("<scr"+"ipt type='text/javascript' src='"+ dartUrl +"'><\/scr"+"ipt>");
EOT;
		$out .= "/*]]>*/</script>\n";

		return $out;
	}

        public static function getInstance() {
                if(self::$instance == false) {
                        self::$instance = new AdProviderDARTMobile();
                }
                return self::$instance;
        }

}
