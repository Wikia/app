<?php

/**
 * AssetsConfig
 * 
 * In this class word 'item' stands for single entry in configuration array while 'asset' stand for specific path or url
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsConfig {
	
	private /* array */ $mConfig;
	
	/**
	 * Initialize object and loads configuration from config.php file
	 * 
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function __construct() {
		include('config.php');
		$this->mConfig = $config;
	}

	/**
	 * Based on the group name get items assigned to it and pass to resolveItemsToAssets mathod for resolving into particular assets
	 * 
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function resolve(/* string */ $groupName, /* boolean */ $combine = true, /* boolean */ $minify = true, /* array */ $params = array()) {
		if(!isset($this->mConfig[$groupName])) {
			return array();
		}
		return $this->resolveItemsToAssets($this->mConfig[$groupName], $combine, $minify, $params);
	}

	/**
	 * Based on the array of items resolves it into array of assets
	 * Parameters $combine, $minify and $params are eventually passed to custom function (look at #function_) which may deliver different set of assets based on them 
	 * 
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	private function resolveItemsToAssets(/* array */ $items, /* boolean */ $combine, /* boolean */ $minify, /* array */ $params) {

		$assets = array();
		
		foreach($items as $item) {
			if(substr($item, 0, 2) == '//') {

				// filepath - most typical case				
				$assets[] = substr($item, 2);				
			
			} else if(substr($item, 0, 7) == '#group_') {

				// reference to another group
				$assets = array_merge($assets, $this->resolve(substr($item, 7)));			

			} else if(substr($item, 0, 10) == '#function_') {

				// reference to a function that returns array of URIs
				$assets = array_merge($assets, call_user_func(substr($item, 10), $combine, $minify, $params));			

			} else if(substr($item, 0, 7) == 'http://') {
				
				// reference to remote file (only http, not https)
				$assets[] = $item;
				
			}
		}
		
		return $assets;
	}
	
}
