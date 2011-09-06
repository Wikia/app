<?php

class CacheToolController extends WikiaSpecialPageController {
	
	// list of "boring" keys 
	private static $filter = array (
		"linkcache:", "file:", "image_redirect:", "preprocess-xml:", "interwiki:"
	);
	
	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'CacheTool', 'cachetool', false );
	}
	
	public function index() {
		
		if (!$this->wg->User->isAllowed( 'cachetool' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		
		$this->response->addAsset('extensions/wikia/hacks/CacheTool/js/CacheTool.js');
		$this->redisError = false;
		$getDetails = $this->getVal("details", null);
		if ($getDetails != null) {
			$this->forward('CacheToolController', 'details');
		} else {
			// show list of wikis
			try {
				$wikiList = $this->wg->Redis->keys("*");
				foreach ($wikiList as $name) {
					if ($name == "_getcounter" || $name == "_setcounter" || $name == "_size") continue;
					$keyCount[$name] = $this->wg->Redis->scard($name);
				}
				$this->keys = $keyCount;
			} catch (Exception $e) {
				$this->redisError = true;
			}
		}
	}
	
	public function details() {
		$wikiName = $this->getVal("details", null);
		try {
			$keyList = $this->wg->Redis->smembers($wikiName);
			foreach ($keyList as $k) {
				$getcount = $this->wg->Redis->hget('_getcounter', $k);
				$setcount = $this->wg->Redis->hget('_setcounter', $k);
				$size = $this->wg->Redis->hget('_size', $k);
				$keyData[$k] = array('getcount' => $getcount, 'setcount' => $setcount, 'size' => $size);
			}
			uasort($keyData, array('CacheToolController', 'sorter'));
		} catch (Exception $e) {
			$this->redisError = true;
			$keyData = array();
		}
		$this->keys = $keyData;
	}

	public function startGathering() {
		// set WF variable
		$this->result = "ok";
	}
	
	public function stopGathering() {
		// unset WF Variable
		$this->result = "ok";
	}
	
	public function clearStats() {
		$keyList = $this->wg->Redis->keys("*");
		foreach ($keyList as $key) {
			$this->wg->Redis->del($key);
		}		
		$this->result = "ok";
	}
	
	public function showContents() {
		$keyToShow = $this->getVal("key", null);
		$data = $this->wg->memc->get($keyToShow);
		if ($data == null) {
			$data = "Null contents.";
		}
		$this->result = "ok";
		$this->key= "<pre>" . print_r($data, true) . "</pre>";		
	}
	
	public function deleteKey() {
		$keyToDelete = $this->getVal("key", null);
		$this->wg->memc->delete($keyToDelete);
		$this->result = "ok";
		$this->key= $keyToDelete;
	}
	
	private function sorter($a, $b) {
		return ($a['getcount'] < $b['getcount']);
	}
	
	public static function getCounter($ret, $rkey) {
		global $wgRedis;
		if (!$wgRedis) return;
		// filter out "boring" keys
		foreach (self::$filter as $f) {
			if (stripos($rkey, $f) > 0) return;
		}
		$dbnameIdx = stripos($rkey, ":");
		$dbname = substr($rkey, 0, $dbnameIdx);
		if (is_numeric($dbname) || empty($dbname)) return;	// skip ad keys which use ints
		try {
			$wgRedis->sadd($dbname, $rkey);				// record the set of keys on a per-wiki basis
			$wgRedis->hincrby('_getcounter', $rkey, 1);	// record a counter for the memcachekeys
			$wgRedis->hset('_size', $rkey, strlen($ret[$rkey]));	// record the size of each key
		} catch (Exception $e) {
			// Exception connecting to redis
		}
	}
	
	public static function setCounter($key, $len) {
		global $wgRedis;
		if (!$wgRedis) return;
		// filter out "boring" keys
		foreach (self::$filter as $f) {
			if (stripos($key, $f) > 0) return;
		}
		$dbnameIdx = stripos($key, ":");
		$dbname = substr($key, 0, $dbnameIdx);
		if (is_numeric($dbname) || empty($dbname)) return;	// skip ad keys which use ints
		try {
			$wgRedis->sadd($dbname, $key);			// record the set of keys on a per-wiki basis
			$wgRedis->hincrby('_setcounter', $key, 1);	// record a counter for the memcachekeys
			$wgRedis->hset('_size', $key, $len);		// record the size of each key
		} catch (Exception $e) {
			// Connection error
		}
 	}
	
}
