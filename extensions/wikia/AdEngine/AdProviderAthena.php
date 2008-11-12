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

		$out =  '<script type="text/javascript" src="/extensions/wikia/AdEngine/Athena.js"></script>' . "\n";

		// Page vars are variables that you want available in javascript for serving ads
		$pageVars = array();
		global $wgDBname;
		$pageVars['wgDBname'] = $wgDBname;
		$pageVars['hostname'] = getenv('HTTP_HOST');
		$pageVars['request'] = getenv('REQUEST_PATH');
		/*
		$pageVars['skin'] = 
		$pageVars['wgCityId'] = 
		$pageVars['wgUserLanguage'] = 
		$pageVars['wgContentLanguage'] = 
		*/

		$out .= '<script type="text/javascript">' . "\n";
		foreach ($pageVars as $name => $value){
			$out.= 'Athena.setPageVar("' . addslashes($name) . '", "' . addslashes($value) . '");' . "\n";
		}

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

	private function getKadId($slotname){
		$adtype = AdEngine::getInstance()->getAdType($slotname);
		if (isset($this->kadids[$adtype])){
			return $this->kadids[$adtype];
		} else {
			return false;
		}
	}

}
