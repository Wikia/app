<?php
/* 
 * API module that allows for selected Wiki Factory settings to be viewed/changed
 *
 * @TODO: Comments / docs
 * @TODO: Is this file even used anymore? It's pretty attrocious... would be nice to either clean it up or remove it.  Since
 * there are many versions of NewWikiBuilder/WikiCreator/AutoWikiCreate/etc., it's possible this whole extension is unused.
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

	/**
	 * Changes a wiki factory variable and returns either the string "success" or the
	 * string "fail".
	 *
	 * Expects 'params' array to have a value for key 'changesetting' (name of the setting to change) and
	 * the value to change that setting to is kept in the value for the key 'value'.
	 */
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
			$result = $this->changeSetting($params);
		} else if (!empty($params['settingnames'])){
			$result = $this->getSettings($params);
		} else {
			$this->dieUsageMsg(array('notarget'));
		}
		
		$this->getResult()->addValue(null, "settings", $result);
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
