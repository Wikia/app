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

	public function getAd($slotname, $slot) {

		return "<!-- Google Ad: $slotname, " . print_r($slot, true) . "-->";

	}

        public function getHeightWidthFromSize($size){
                if (preg_match('/^([0-9]{2,4})x([0-9]{2,4})/', $size, $matches)){
                        return array('width'=>$matches[1], 'height'=>$matches[2]);
                } else {
                        return false;
                }
        }



        public function getAdTag(){
                global $AdEngine;
                $dim=$this->getHeightWidthFromSize($this->slotInfo['size']);

                $out='<script type="text/javascript">
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
                        google_hints= "' . addslashes($AdEngine->getSearchKeywords()) . '"; 
                        //google_page_url = "";
                        //google_ui_features = "rc:6";
                        //document.write(\'<scr\' + \'ipt type="text/javascript"  src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr\' + \'ipt>\');
                        </script>
                        <script type="text/javascript"  src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
                $this->lastAdTag=$out;
                return $out;
        }


}
