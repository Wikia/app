<?php
/**
 * AdsInContent Extension main class
 */
class AdsInContent {

	const googleAdClient = 'pub-4086838842346968';

	static $instances = 0;

	private $mContent;
	private $mContentLength = 0;
	private $aConfig;
	private $lastUsedAdUnit = null;
	private $lastUsedAdUnitIndex = false;
	private $mAdsCounter = 0; // we want top and bottom ads always displayed
	private $mAdsProvider = 'google';
	private $ads;

//	private $topAdGoogleAdChannel = '9100000010';
//	private $bottomAdGoogleAdChannel = '9100000013';
	private $topAdGoogleAdChannel = '9100000014';
	private $bottomAdGoogleAdChannel = '9100000017';

	private $topAdYieldbuildLocation = 'top_right';
	private $bottomAdYieldbuildLocation = 'footer';

	public function __construct(&$content, $config) {
		$this->mContent =& $content;
		$this->mContentLength = strlen(strip_tags($content));
		$this->aConfig = $config;
		self::$instances++;
	}

	public function execute() {
		global $wgRequest;

		wfProfileIn(__METHOD__);

		// handle edit pages
		$action = $wgRequest->getVal('action');
		if( $action == 'edit' || ($action == 'submit' && self::$instances > 1)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$this->chooseAdsProvider();
		//echo "Provider: " . $this->mAdsProvider . "<br />";

		// mark the end of content (will be used in JS "fix").
		$this->mContent = $this->mContent . '<!--BeginSect:e--><a name="lastSectionEnd" id="lastSectionEnd"></a>';

		if(is_array($this->aConfig['insideAdUnit']) && count($this->aConfig['insideAdUnit'])) {
			$this->addInsideAds();
		}

		if($this->aConfig['topAdUnit']) {
			$this->addTopAd();
		}

		if($this->aConfig['bottomAdUnit'] && ($this->mContentLength > 1440)) {
			$this->addBottomAd();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	private function chooseAdsProvider() {
		srand(time());
		$iRandomValue = rand(0, 100);
		//if($iRandomValue < 66) {
		//	$this->mAdsProvider = 'yieldbuild';
		//}
		//else {
			$this->mAdsProvider = 'google';
		//}
	}

	private function addTopAd() {
		$adBody = AdServer::getInstance()->getAd('c_tr');
		if(empty($adBody)) {
			$adBody = self::getAdUnit( array('width' => 300, 'height' => 250, 'googleAdChannel' => $this->topAdGoogleAdChannel, 'yieldbuildLocation' => $this->topAdYieldbuildLocation) );
		}
		$this->mContent = '<div class="contentAdTop" id="contentAdTop" style="float: right;"><div class="noprint">' . $adBody . '</div></div>' . $this->mContent;
	}

	private function addBottomAd() {
		// TODO: "Ads by Google" text tmp removed
		//$adBody = '<h2 class="noprint"><span class="mw-headline">Ads by Google</span></h2>';
		$adBody = AdServer::getInstance()->getAd('c_b');
		if(empty($adBody)) {
			$adBody= self::getAdUnit( array('width' => 468, 'height' => 60, 'googleAdChannel' => $this->bottomAdGoogleAdChannel, 'yieldbuildLocation' => $this->bottomAdYieldbuildLocation) );
		}
		$this->mContent .= '<div class="contentAdBottom noprint">' . $adBody . '</div>';
	}

	/**
	 * @param $sectionNo int number of section, will be used to get valid ad box from ad server
	 */
	private function getRandomInsideAd($sectionNo) {
		$adBody = AdServer::getInstance()->getAd('c_3');
		if(empty($adBody)) {
			$aAdUnits = $this->aConfig['insideAdUnitConfig'][$this->mAdsProvider];
			$iMaxAdUnitIndex = count($aAdUnits) - 1;

			if($this->lastUsedAdUnitIndex === false) {
				$this->lastUsedAdUnitIndex = rand(0, $iMaxAdUnitIndex);
			}

			$iIndex = $this->lastUsedAdUnitIndex;
			$aSelectedAdUnit = $aAdUnits[$iIndex];
			$this->lastUsedAdUnit = $aSelectedAdUnit;

			$iIndex++;
			$this->lastUsedAdUnitIndex = ($iIndex <= $iMaxAdUnitIndex) ? $iIndex : 0;

			$adBody = '<div class="contentAdInside noprint" ';
			if (!empty($aSelectedAdUnit['float'])) {
				$adBody .= 'style="margin-bottom: 2em; margin-top: 2em margin-' .
					( $aSelectedAdUnit['align'] == 'left' ? 'right' : 'left' ) .
					': 3em; float: ' . $aSelectedAdUnit['align'] . '"'; 
			}
			$adBody .= '>' . self::getAdUnit( $aSelectedAdUnit ) . '</div>';
		}
		return $adBody;
	}

	private function addInsideAds() {
		$iSectionsNum = 0;
		// add tag to the end of each section header
		$this->mContent = preg_replace_callback(
			'/<\/span><\/h2>/siU',
			create_function(
				'$matches',
				'static $count; $count = $count ? $count : 1; return $matches[0]."<!--AdBox:".($count++)."-->";'
			),
			$this->mContent,
			-1,
			$iSectionsNum
		);

		// add tag to the begining of each seaction header
		$this->mContent = preg_replace_callback(
			'/<h2><span/siU',
			create_function(
				'$matches',
				'static $count; $count = $count ? $count : 1; return ($count==1?"<a name=\"firstSectionBegin\" id=\"firstSectionBegin\"></a>":"")."<!--BeginSect:".($count++)."-->".$matches[0];'
			),
			$this->mContent
		);


		if($iSectionsNum > 0) {
			$aAllowedAdSections = array();
			foreach($this->aConfig['insideAdUnit'] as $sLimits => $aSections) {
				$aLimits = explode('-', $sLimits);
				$lowerLimit = (isset($aLimits[0]) && $aLimits[0] != '*') ? $aLimits[0] : 0;
				$upperLimit = (isset($aLimits[1]) && $aLimits[1] != '*') ? $aLimits[1] : 999999999;
				if(($iSectionsNum >= $lowerLimit) && ($iSectionsNum <= $upperLimit)) {
					$aAllowedAdSections = $aSections;
				}
			}

			foreach($aAllowedAdSections as $iSectionNo) {
				if($this->mAdsCounter < $this->aConfig['limit'][$this->mAdsProvider]) {
					$sAdBody = $this->getRandomInsideAd($iSectionNo);

					if(($this->lastUsedAdUnit != null) && ($this->lastUsedAdUnit['align'] == 'right') && $this->isContentInTable($iSectionNo)) {
					 // if table was found at the begining of the section, and right-aligned box, get left aligned box
					 do {
							$sAdBody = $this->getRandomInsideAd($iSectionNo);
					 }
					 while($this->lastUsedAdUnit['align'] == 'right');
					}

					$this->mContent = preg_replace('/<!--AdBox:'.$iSectionNo.'-->/siU', $sAdBody, $this->mContent);
					if(($this->lastUsedAdUnit != null) && ($this->lastUsedAdUnit['align'] == 'right')) {
						$this->mContent = preg_replace('/<!--BeginSect:('.($iSectionNo+1).'|e)-->/siU', '<br clear="both" />', $this->mContent);
					}
					$this->mAdsCounter++;
				}
				else {
					break;
				}
			}

		}

	}

	private function isContentInTable($sectionNo) {
		preg_match('/<!--AdBox:'.$sectionNo.'-->.{1,1440}(<table).*<!--BeginSect:('.($sectionNo+1).'|e)-->/siU',$this->mContent, $matches);
		if(isset($matches[1])) {
			return true;
		}
		else {
			return false;
		}
	}

	private function getAdUnit($aConfig) {
		$sAdBody = '';
		switch($this->mAdsProvider) {
			case 'google':
				$sAdBody = self::getGoogleAdUnit($aConfig['width'], $aConfig['height'], $aConfig['googleAdChannel']);
				break;
			case 'yieldbuild':
				$sAdBody = self::getYieldbuildAdUnit($aConfig['yieldbuildLocation']);
				break;
			default:
				$sAdBody = self::getGoogleAdUnit($aConfig['width'], $aConfig['height'], $aConfig['googleAdChannel']);
		}
		return $sAdBody;

	}

	public static function getGoogleAdUnit($width, $height, $adChannel = '') {
		global $wgUser;

/*	$googleAdClient = self::googleAdClient;

		$body = <<<END
<script type="text/javascript">
<!--
	google_ad_client = "$googleAdClient";
	google_ad_width = $width;
	google_ad_height = $height;
	google_ad_format = "{$width}x{$height}_as";
	google_ad_channel = "$adChannel";
	google_ad_type = "text";
END;

if ( $wgUser->getSkin() instanceof SkinMonaco ) {
	$body .= 'google_color_border = top.AdEngine.getAdColor("text");
	google_color_bg     = top.AdEngine.getAdColor("bg");
	google_color_link   = top.AdEngine.getAdColor("link");
	google_color_text   = top.AdEngine.getAdColor("text");
	google_color_url    = top.AdEngine.getAdColor("url");';
} else {
	$body .= 'google_color_border = "FFFFFF";
	google_color_bg = "FFFFFF";
	google_color_link = "002BB8";
	google_color_text = "000000";
	google_color_url = "002BB8";';
}

$body .= '//--></script><script src="http://pagead2.googlesyndication.com/pagead/show_ads.js" type="text/javascript"></script>';
*/
		$body = '<script type="text/javascript">GA_googleFillSlot("' . $adChannel . '");</script>';

		return $body;
	}

	public static function getYieldbuildAdUnit($location = 'top_right', $layout = 'es_pokemon') {
		$body = <<<END
<!-- YB: $location -->
<script type="text/javascript"><!--
yieldbuild_client = 961;
yieldbuild_layout = "$layout";
yieldbuild_loc = "$location";
yieldbuild_options = {};
//--></script>
<script type="text/javascript" src="http://hook.yieldbuild.com/s_ad.js"></script>
END;

		return $body;
	}


	/**
	 * check whether we are on main page
	 */
	public static function isMainPage() {
		global $wgTitle;

		// main page of wiki
		$mainPage = wfMsgForContent('Mainpage');

		return ($wgTitle->getText() == $mainPage);
	}

	/**
	 * dirty JS fixes
	 */
	public static function applyTopSectionJSFix( $skin, & $bottomScripts)  {
		$bottomScripts .= <<<END
<!-- AdsInContent -->
<style type="text/css">
.contentAdTop {
	margin: -5px 0 10px 5px;
	float: right;
/*	width: 302px;*/
}

.contentAdInside {
	margin: 0px 10px 10px 0;
	/*width: 470px;*/
	/*border: 1px solid #ccc;*/
}

.contentAdBottom {
	margin: 20px 10px;
	/*width: 470px;*/
	/*border: 1px solid #ccc;*/
}
</style>
<script type="text/javascript">
	var element = YAHOO.util.Dom.get('contentAdTop');

	if(element != null) {
		checkChildNode(element.nextSibling);
	}

	function checkChildNode(element) {
		if(element != null) {
			do {
				//alert('nodeName:'+element.nodeName+' id:'+element.getAttribute('id'));

				if((element.nodeName == 'A') && ((element.getAttribute('id') == 'firstSectionBegin') || (element.getAttribute('id') == 'lastSectionEnd'))) {
					// we've found next section or reached the end of content
					break;
				}

				if((element.nodeName == 'DIV') || (element.nodeName == 'TABLE')) {
					if((YAHOO.util.Dom.getStyle(element, 'float') == 'right') || (element.align == 'right')) {
						YAHOO.util.Dom.setStyle(element, 'clear', 'right');
					}
					else {
						if(YAHOO.util.Dom.getStyle(element, 'width') && (YAHOO.util.Dom.getStyle(element, 'width') != 'auto')) {
							var width =  YAHOO.util.Dom.getStyle(element, 'width');
							if(width.substr(width.length-1, width.length) == '%' ) {
								width = width.substr(0, width.length-1);
								if(Number(width) > 70) {
									//alert(width);
									YAHOO.util.Dom.setStyle(element, 'width', '65%');
									//YAHOO.util.Dom.setStyle(element, 'width', 'auto');
									//YAHOO.util.Dom.setStyle(element, 'margin-right', '315px');
								}
							}
							else {
								//alert('test: '+width.substr(width.length-2, width.length));
								if(width.substr(width.length-2, width.length) == 'px' ) {
									width = width.substr(0, width.length-2);
									if(Number(width) > 750) {
										//alert(width);
										YAHOO.util.Dom.setStyle(element, 'width', '65%');
										//YAHOO.util.Dom.setStyle(element, 'width', 'auto');
										//YAHOO.util.Dom.setStyle(element, 'margin-right', '315px');
									}
								}
							}

						}
					}

				}
				else {
					// other node found, dig in...
					if(element.hasChildNodes) {
						checkChildNode(element.firstChild);
					}
				}

				element = element.nextSibling;
			}
			while(element != null);
		}
	}

</script>
END;

		return true;
	}

}
