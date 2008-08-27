<?php

// Not fully implemented

$wgExtensionCredits['other'][] = array(
	'name' => 'Null ad provider for AdEngine'
);

class AdProviderGoogle implements iAdProvider {

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderGoogle();
		}
		return self::$instance;
	}


        public function getAd($slotname, $slot){
                global $AdEngine;
                $dim=AdEngine::getHeightWidthFromSize($slot['size']);

                $out = "<!-- " . __CLASS__ . " slot: $slotname -->";
                $out .= '<script type="text/javascript">/*<![CDATA[*/
                        bannerid=\'__GO____\';
                        
                        google_ad_client = "pub-4086838842346968";
                        
                        google_ad_width = ' . $dim['width'] . ';google_ad_height = ' .$dim['height'] .';
                                
                        google_ad_format = google_ad_width+"x"+google_ad_height+"_as";
                                
                        google_ad_type = "text";
                        // TODO: implement the colors for this wiki
                        google_color_border = "FFFFFF";
                        google_color_bg     = "FFFFFF";
                        google_color_link   = "0000FF";
                        google_color_text   = "000000";
                        google_color_url    = "002BB8";
                                
                        //google_ad_channel = "90000000xx";
                        google_hints= "' . addslashes($this->getGoogleHints()) . '"; 
                        //google_page_url = "";
                        //google_ui_features = "rc:6";
                        //document.write(\'<scr\' + \'ipt type="text/javascript"  src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr\' + \'ipt>\');
                        /*]]>*/</script>
                        <script type="text/javascript"  src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
                return $out;
        }


	/* Note: This function won't really do any good right now, because we don't have ads
	 * on the search results pages 
	 */
	public function getGoogleHints(){
		if(!empty($_GET['search'])){
                        return $_GET['search'];
                } else {
                        return '';
                }
	}

}
