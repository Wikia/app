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

		global $wgDBname, $wgLang, $wgUser, $wgTitle;

		if (empty($_GET['athena_dev_hosts'])){
			$base = "/__varnish_athena/";
			$version = "1";
		} else {
			$base = "http://athena.dev.wikia-inc.com/";
			$version = mt_rand();
		}
		$out =  '<script type="text/javascript" src="'. $base .'athena/Athena.js?' . $version . '"></script>' . "\n";

		// Page vars are variables that you want available in javascript for serving ads
		$pageVars = array();
		$pageVars['wgDBname'] = $wgDBname;
		$pageVars['hostname'] = getenv('HTTP_HOST');
		$pageVars['request'] = getenv('SCRIPT_URL');
                if (is_object($wgTitle)){
                       $pageVars['article_id'] = $wgTitle->getArticleID();
		}
		$pageVars['isMainPage'] = ArticleAdLogic::isMainPage();
		$cat = AdEngine::getCachedCategory();
		$pageVars['hub'] = $cat['name'];
		$pageVars['skin'] = $wgUser->getSkin()->getSkinName();
		$pageVars['user_lang'] = $wgLang->getCode();
		$pageVars['cont_lang'] = $GLOBALS['wgLanguageCode'];

		$out .= '<script type="text/javascript">' . "\n";
		foreach ($pageVars as $name => $value){
			// Type juggling
			if ($value === true){
				$value = "true"; // As a string
			} else if ($value === false){
				$value = "";
			}
			$out.= 'Athena.setPageVar("' . addslashes($name) . '", "' . addslashes($value) . '");' . "\n";
		}

		$out.= 'Athena.setPageVar( "browser", Athena.getBrowser() );' . "\n";

		// Pull the configs
		$out.= 'Athena.pullConfig();';
		$out .= '</script>';

		return $out;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderAthena();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot){
		return '<script type="text/javascript">Athena.callAd("' . $slotname . '");</script>' . "\n";
        }

}
