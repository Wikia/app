<?php

class AdProviderGoogle implements iAdProvider {

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
			self::$instance = new AdProviderGoogle();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot, $params = null){
                global $wgUser;
                $dim=AdEngine::getHeightWidthFromSize($slot['size']);

                $out = "<!-- " . __CLASS__ . " slot: $slotname -->";
                $out .= '<script type="text/javascript">/*<![CDATA[*/
                        google_ad_client    = "pub-4086838842346968";
                        google_ad_width     = "' . $dim['width'] . '";
			google_ad_height    = "' . $dim['height'] . '";
                        google_ad_format    = google_ad_width + "x" + google_ad_height + "_as";
                        google_ad_type      = "text";
                        google_ad_region    = "region";' . "\n";

                $skin_name = null;
                if (is_object($wgUser)){
                        $skin_name = $wgUser->getSkin()->getSkinName();
                }
                if ( $skin_name == 'monaco' ){
		  // getAdColor only works in monaco
		  $out.='google_color_border = AdEngine.getAdColor("text");
                        google_color_bg     = AdEngine.getAdColor("bg");
                        google_color_link   = AdEngine.getAdColor("link");
                        google_color_text   = AdEngine.getAdColor("text");
                        google_color_url    = AdEngine.getAdColor("url");' . "\n";
		}

		$channel = $this->getChannel();
	       	$out.= 'google_ad_channel      = "' . addslashes($channel) . '";' . "\n";
		/* Channel is how we do bucket tests.
		 * Testing the effectiveness of google_page_url and google_hints here
		 * The first test showed that hints performed better than the control and page_url
		 * Now testing control vs hints alone vs hints + page_url
		 */
		if ($channel == '9000000009'){
			// page_url + hints. Rumor has it these two are mutually exclusive, but we are trying it anyway.
                        $out .= 'google_page_url     = "' . addslashes($this->getPageUrl()) . '";' . "\n";
                        $out .= $this->getGoogleHints() . "\n";
		} else if ($channel == '9000000010') {
			// Control
		} else if ($channel == '9000000011') {
			// Hints alone
                        $out .= $this->getGoogleHints() . "\n";
		}
		$out .= '/*]]>*/</script>
			<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
                return $out;
        }


	/* Note: This function won't really do any good right now, because we don't have ads
	 * on the search results pages
	 */
	public function getGoogleHints(){
		if(!empty($_GET['search'])) {
			return 'google_keywords        = "' . addslashes($_GET['search']) . '";';
//			return 'google_hints        = "' . addslashes($_GET['search']) . '";';
		} else {
			// Pull in the same keywords we use for the page.
			return 'google_keywords        = AdEngine.getKeywords();';
//			return 'google_hints        = AdEngine.getKeywords();';
		}
	}


	static public function getPageUrl(){
		global $wgTitle;
		if (is_object($wgTitle) && method_exists($wgTitle, 'getFullUrl')){
			return $wgTitle->getFullUrl();
		} else {
			return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		}
	}

	public function getChannel(){
		// Channel is a way to do bucket testing.
		static $channel;
		if (!empty($channel)){
			return $channel;
		}

		switch (mt_rand(1,3)){
			case 1: $channel = 9000000009; break;
			case 2: $channel = 9000000010; break;
			case 3: $channel = 9000000011; break;
		}
		return $channel;
	}



	// https://www.google.com/adsense/support/bin/answer.py?hl=en&answer=9727
	public function getSupportedLanguages(){
		return array('ar', 'bg', 'zh', 'hr', 'cs', 'da', 'nl', 'en', 'fi', 'fr', 'de', 'el', 'he',
			     'hu', 'it', 'ja', 'ko', 'no', 'pl', 'pt', 'ro', 'ru', 'sr', 'sk', 'es', 'sv', 'tr');
	}

}
