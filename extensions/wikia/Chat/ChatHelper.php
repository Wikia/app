<?php

class ChatHelper {
	private static $serversBasket = "ChatServersBasket";
	private static $operationMode = "ChatOperationMode";
	private static $CentralCityId = 177;
	private static $configFile = array();	
	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// Above spotlights, below everything else. BugzId: 4597.
		$modules[1175] = array('ChatRail', 'Placeholder', null);

		wfProfileOut(__METHOD__);
		return true;
	}
	
	/**
	 * $mode - true = operation, false = failover
	 */
	
	static public function changeMode($mode = true){
		if(self::getMode() == false) { //just promote server to operation mode
			self::setMode(true);
			return true;
		} 

		$basket = self::getServerBasket();
		self::setServerBasket(($basket)%2 + 1);
		self::setMode(false);
		return false;
	}
	
	static public function getMode(){
		$mode = WikiFactory::getVarValueByName(self::$operationMode, self::$CentralCityId );
		if(is_null($mode)) {
			return true;
		}
		
		return $mode; 
	}
	
	static public function setMode($mode){
		WikiFactory::setVarByName(self::$operationMode, self::$CentralCityId, $mode);
	}

	static public function getServer($type = 'Main'){
		$server = self::getChatConfig($type.'ChatServers');
		//TODO: load balans
		$out = explode(':', $server[self::getServerBasket()][0]);
		return array('host' => $out[0], 'port' => $out[1]); 
	}
	
	/**
	 * 
	 * laod Config of chat from json file (we need to use jsone file becasue w)
	 * @param string $name
	 */
	static function getChatConfig($name) {
		global $wgWikiaLocalSettingsPath, $wgDevelEnvironment;
		
		if(empty(self::$configFile)) {
			$string = file_get_contents(dirname($wgWikiaLocalSettingsPath) . '/../ChatConfig.json' );
			self::$configFile = json_decode($string, true);
		} 
		
		if(isset(self::$configFile[empty($wgDevelEnvironment) ? 'prod':'dev'][$name])) {
			return self::$configFile[empty($wgDevelEnvironment) ? 'prod':'dev'][$name];
		}
		
		if(isset(self::$configFile[$name])) {
			return self::$configFile[$name];
		}
		
		return false;
	}
	
	static private function getServerBasket() {
		$basket	= WikiFactory::getVarValueByName(self::$serversBasket, self::$CentralCityId);
		if(empty($basket)) {
			return 1;
		}
		return $basket;
	}
	
	static private function setServerBasket($basket) {
		WikiFactory::setVarByName(self::$serversBasket, self::$CentralCityId, $basket);
	}
}
