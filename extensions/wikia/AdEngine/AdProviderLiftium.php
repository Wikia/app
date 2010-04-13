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

		global $wgDBname, $wgLang, $wgUser, $wgTitle, $wgLiftiumDevHosts;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = 'http://liftium.wikia.com/';
		$options['kv_wgDBname'] = $wgDBname;
                if (is_object($wgTitle)){
                       $options['kv_article_id'] = $wgTitle->getArticleID();
		}
		$cat = AdEngine::getCachedCategory();
		$options['kv_hub'] = $cat['name'];
		$options['kv_skin'] = $wgUser->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];

		// LiftiumOptions as json
		$out = '<script type="text/javascript">' . "\n";
		$out .= "LiftiumOptions = " . json_encode($options) . ';</script>';

		// Call the script
		if (!empty($_GET['liftium_dev_hosts']) || !empty($wgLiftiumDevHosts)){
			$base = "http://liftium.dev.wikia-inc.com/";
			$version = mt_rand();
			$out .= "<script type=\"text/javascript\">var liftium_dev_hosts = 1;</script>";
		} else if ($wgDevelEnvironment){
			$base = "http://liftium.wikia.com/";
			$version = 1;
		} else {
			$base = "/__varnish_liftium/";
			$version = 1;
		}
		$out .=  '<script type="text/javascript" src="'. $base .'/js/Liftium.js?' . $version . '"></script>' . "\n";

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
		$out .= '<script type="text/javascript">LiftiumOptions.placement = "' . $slotname . '";Liftium.callAd("' . $slot['size'] . '");</script>' . "\n";
		return $out;
        }

	/*
	public function getIframeFillHtml($slotname) {
		$sl = addslashes($slotname);
		return "<script type=\"text/javascript\">Athena.callIframeAdDirect(\"$sl\");</script>\n";
	}
	*/
}
