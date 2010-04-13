<?php

class AdProviderAthena implements iAdProvider {

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

		// Page vars are variables that you want available in javascript for serving ads
		$pageVars = array();
		$pageVars['pubid'] = 999;
		$pageVars['kv_wgDBname'] = $wgDBname;
                if (is_object($wgTitle)){
                       $pageVars['kv_article_id'] = $wgTitle->getArticleID();
		}
		$cat = AdEngine::getCachedCategory();
		$pageVars['kv_hub'] = $cat['name'];
		$pageVars['kv_skin'] = $wgUser->getSkin()->getSkinName();
		$pageVars['kv_user_lang'] = $wgLang->getCode();
		$pageVars['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];

		// LiftiumOptions javascript
		$out .= '<script type="text/javascript">' . "\n";
		$out .= "LiftiumOptions = {\n";
		foreach ($pageVars as $name => $value){
			$out.= "$name: \"" . addslashes($value) . '";' . "\n";
		}
		$out .= '};</script>';

		// Call the script
		if (!empty($_GET['liftium_dev_hosts']) || !empty($wgLiftiumDevHosts)){
			$base = "http://liftium.dev.wikia-inc.com/";
			$version = mt_rand();
			$out = "<script type=\"text/javascript\">var liftium_dev_hosts = 1;</script>";
		} else {
			$base = "/__varnish_liftium/";
			$version = "1";
			$out = '';
		}
		$out .=  '<script type="text/javascript" src="'. $base .'/js/Liftium.js?' . $version . '"></script>' . "\n";

		return $out;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderAthena();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot){
		$out = $this->getSetupHtml();
		$out .= '<script type="text/javascript">Liftium.callAd("' . $slotname . '");</script>' . "\n";
		return $out;
        }

	/*
	public function getIframeFillHtml($slotname) {
		$sl = addslashes($slotname);
		return "<script type=\"text/javascript\">Athena.callIframeAdDirect(\"$sl\");</script>\n";
	}
	*/
}
