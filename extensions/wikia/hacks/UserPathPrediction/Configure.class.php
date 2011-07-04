<?php
class Config {
	var $config = array();

	function Config() {
		$this->__construct();
	}

	function __construct() {
		$this->config["490"] = array("db_name" => "wowwiki", "domain_name" => "wowwiki.com");
		$this->config["10150"] = array("db_name" => "dragonage", "domain_name" => "dragonage.wikia.com");
		$this->config["3125"] = array("db_name" => "callofduty", "domain_name" => "callofduty.wikia.com");
	}

	function getWikiData($cityId) {
		$helper = $this->config[$cityId];
		return $helper;
	}
	
	function getDomains() {
		foreach($this->config as $wikiSite) {
			$helper[] = $wikiSite["domain_name"];
		}
		return $helper;
	}	
}
