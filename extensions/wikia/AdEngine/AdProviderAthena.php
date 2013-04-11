<?php



		// ***************** Athena has been replaced by Liftium
		





class AdProviderAthena extends AdProviderIframeFiller implements iAdProvider {

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

		global $wgDBname, $wgLang, $wgTitle, $wgAthenaDevHosts;

		if (!empty($_GET['athena_dev_hosts']) || !empty($wgAthenaDevHosts)){
			$base = "http://athena.dev.wikia-inc.com/";
			$version = mt_rand();
			$out = "<script type=\"text/javascript\">var athena_dev_hosts = 1;</script>";
		} else {
			$base = "/__varnish_athena/";
			$version = "1";
			$out = '';
		}
		$out .=  '<script type="text/javascript" src="'. $base .'athena/Athena.js?' . $version . '"></script>' . "\n";

		if (!empty($_GET['athena_dev_hosts'])){
		}

		// Page vars are variables that you want available in javascript for serving ads
		$pageVars = array();
		$pageVars['wgDBname'] = $wgDBname;
		$pageVars['hostname'] = getenv('HTTP_HOST');
		$pageVars['request'] = getenv('SCRIPT_URL');
                if (is_object($wgTitle)){
                       $pageVars['article_id'] = $wgTitle->getArticleID();
		}
		$pageVars['isMainPage'] = WikiaPageType::isMainPage();
		$cat = AdEngine2Controller::getCachedCategory();
		$pageVars['hub'] = $cat['name'];
		$pageVars['skin'] = RequestContext::getMain()->getSkin()->getSkinName();
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
			$h = AdEngine2Controller::getCachedCategory();
			// ***************** Athena has been replaced by Liftium
			return self::$instance = new AdProviderLiftium();
		}
		return self::$instance;
	}

        public function getAd($slotname, $slot, $params = null){
		$out = $this->getSetupHtml();
		$out .= '<script type="text/javascript">Athena.callAd("' . $slotname . '");</script>' . "\n";
		return $out;
        }

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
                global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		$sl = addslashes($slotname);
		$out = "<script type=\"text/javascript\">$function_name = function() { Athena.callIframeAdDirect(\"$sl\"); }</script>\n";

                return $out;
	}

}
