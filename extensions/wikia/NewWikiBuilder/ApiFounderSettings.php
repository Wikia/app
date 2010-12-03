<?php
/* 
 * API module that allows for selected Wiki Factory settings to be viewed/changed
 *
 */

class ApiFounderSettings extends ApiBase {

	protected $readSettings;
	protected $writeSettings;

        public function __construct($main, $action) {
                parent :: __construct($main, $action);
		$this->writeSettings = array(
			'wgDefaultTheme',
			'wgDefaultSkin',
			'wgAdminSkin'
		);

		$this->readSettings = array_merge($this->writeSettings, array(
			'wgArticlePath','wgScriptPath','wgScript','wgServer',
			'wgLanguageCode','wgCityId','wgContentNamespaces'
			)
		);
        }

	private function changeSetting($params){
                $this->getMain()->requestWriteMode();

		// Logged in?
		global $wgUser;
		if ( !$wgUser->isAllowed('newwikibuilder') || $wgUser->isBlocked() ) {
			$this->dieUsageMsg(array("badaccess-groups"));
		} 

                if (empty($params['changesetting'])){ 
                        $this->dieUsageMsg(array('missingparam', 'changesetting'));
                } else if (empty($params['value'])){ 
                        $this->dieUsageMsg(array('missingparam', 'value'));
                }

		if (! in_array($params['changesetting'], $this->writeSettings)){
                        $this->dieUsageMsg(array("readonlysetting"));
		}

		global $wgCityId;
		if (empty($wgCityId)) { 
			// WTF?
                        $this->dieUsageMsg(array('Missing wgCityId'));
		}

		if ( WikiFactory::setVarByName( $params['changesetting'], $wgCityId, $params['value'], 'NWB') ){
			WikiFactory::clearCache($wgCityId);
			return "success";
		} else {
			return "fail";
		}
	}

	private function getSettings($params){
                if (empty($params['settingnames'])){ 
                        $this->dieUsageMsg(array('missingparam', 'settingnames'));
		}

		$out = array();
		foreach (explode('|', $params['settingnames']) as $setting){
			if (in_array($setting, $this->readSettings)){
				if (isset($GLOBALS[$setting])){
					$out[$setting] = $GLOBALS[$setting];
				} else {
				//	$out[$setting] = "NOTFOUND";
				}
			} else {
			//	$out[$setting] = "PROTECTED";
			}
		}
		return $out;
	}


	public function execute() {

                $params = $this->extractRequestParams();

		if (!empty($params['changesetting'])){
			$r = $this->changeSetting($params);
		} else if (!empty($params['settingnames'])){
			$r = $this->getSettings($params);
		} else {
                        $this->dieUsageMsg(array('notarget'));
		}
		
		$this->getResult()->addValue(null, "settings", $r);
	}

	public function mustBePosted() { 
                $params = $this->extractRequestParams();

		if (!empty($params['changesetting'])){
			return true;
		} else {
			return false;
		}
	}

	public function getAllowedParams() {
		return array (
			'settingnames' => null,
			'changesetting' => null,
			'value' => null
		);
	}

	public function getParamDescription() {
		return array (
			'settingnames' => 'The setting(s) to view. Multiple separated by |. Ex: wgDefaultTheme|wgScriptPath',
			'changesetting' => 'The setting to change. Ex: wgDefaultTheme',
			'value' => 'The value to change the changesetting to.'
		);
	}

	public function getDescription() {
		return array(
			'Module that allows for selected Wiki settings to be viewed/changed'
		);
	}

	protected function getExamples() {
		return array (
			'api.php?action=foundersettings&settingnames=wgAdminSkin|wgScriptPath',
			'api.php?action=foundersettings&changesetting=wgDefaultTheme&value=slate'
		);
	}
        public function getVersion() { return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $'; }

}


