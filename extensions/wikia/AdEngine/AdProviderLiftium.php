<?php

class AdProviderLiftium implements iAdProvider {

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
                static $called = false;
                if ($called){
                        return false;
                }
                $called = true;

		global $wgDBname, $wgLang, $wgUser, $wgTitle, $wgLiftiumDevHosts, $wgDevelEnvironment;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
                if (is_object($wgTitle)){
                       $options['kv_article_id'] = $wgTitle->getArticleID();
		}
		$cat = AdEngine::getCachedCategory();
		$options['kv_Hub'] = $cat['name'];
		$options['kv_skin'] = $wgUser->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];
		$options['kv_isMainPage'] = ArticleAdLogic::isMainPage();
		$options['kv_page_type'] = ArticleAdLogic::getPageType();
		$options['geoUrl'] = "http://geoiplookup.wikia.com/";

		// LiftiumOptions as json
		$out = '<script type="text/javascript">' . "\n";
		$out .= "LiftiumOptions = " . json_encode($options) . ';</script>';

		// Call the script
		global $wgDevelEnvironment;
		if (!empty($_GET['liftium_dev_hosts']) || !empty($wgLiftiumDevHosts)){
			$base = "http://nick.dev.liftium.com/";
			$version = '?' . mt_rand();
			$out .= "<script type=\"text/javascript\">var liftium_dev_hosts = 1;</script>";
		} else if ($wgDevelEnvironment){
			$base = "http://liftium.wikia.com/";
			$version = '?' . mt_rand();
		} else {
			$base = "/__varnish_liftium/";
			$version = "";
		}
		$out .=  '<script type="text/javascript" src="'. $base .'js/Liftium.js' . $version . '"></script>' . "\n";
		$out .=  '<script type="text/javascript" src="'. $base .'js/Wikia.js' . $version . '"></script>' . "\n";

		return $out;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderLiftium();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot){
		$out = $this->getSetupHtml();
		$out .= '<script type="text/javascript">' . "\n" .
			'LiftiumOptions.placement = "' . $slotname . '";' . "\n" . 
			'LiftiumDART.placement = "' . $slotname . '";' . "\n" . 
			'Liftium.callAd("' . $slot['size'] . '");</script>' . "\n";
		return $out;
        }

	public function getIframeFillHtml($slotname, $slot) {
		global $wgEnableTandemAds, $wgEnableTandemAds_slave, $wgEnableTandemAds_delay;

		if (!empty($wgEnableTandemAds) && !empty($wgEnableTandemAds_slave) && ((is_array($wgEnableTandemAds_slave) && in_array($slotname, $wgEnableTandemAds_slave)) || ($wgEnableTandemAds_slave == $slotname)) && !empty($wgEnableTandemAds_delay)) {
		// FIXME get rid of c&p
		return '<script type="text/javascript">' .
			'window.setTimeout(\'' .
			'LiftiumOptions.placement = "' . $slotname . '";' . 
			'Liftium.callInjectedIframeAd("' . addslashes($slot['size']) . 
			'", document.getElementById("' . addslashes($slotname) .'_iframe"))' .
			'\', ' . $wgEnableTandemAds_delay . ')' .
			';</script>';
		}

		return '<script type="text/javascript">' .
			'LiftiumOptions.placement = "' . $slotname . '";' . "\n" .
			'Liftium.callInjectedIframeAd("' . addslashes($slot['size']) . 
			'", document.getElementById("' . addslashes($slotname) .'_iframe"));</script>';
	}
}
