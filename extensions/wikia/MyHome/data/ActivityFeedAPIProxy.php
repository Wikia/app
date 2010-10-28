<?php

class ActivityFeedAPIProxy implements iAPIProxy {

	var $APIparams;

	public function __construct($includeNS = null, $userName = null) {
		$this->APIparams = array();
		$this->APIparams['action'] = 'query';
		$this->APIparams['list'] = 'recentchanges';
		$this->APIparams['rcprop'] = 'comment|timestamp|ids|title|loginfo|user|wikiamode';
		$this->APIparams['rcshow'] = '!bot';
		if (!is_null($includeNS)) $this->APIparams['rcnamespace'] = $includeNS;
		if (!empty($userName)) $this->APIparams['rcuser'] = $userName;
	}

	public function get($limit, $start = null) {
		wfProfileIn(__METHOD__);
		if(!empty($start)) {
			$this->APIparams['rcstart'] = $start;
		} else {
			unset($this->APIparams['rcstart']);
		}

		$this->APIparams['rclimit'] = $limit;

		$api = new ApiMain(new FauxRequest($this->APIparams));
		$api->execute();
		$res = &$api->GetResultData();

		$out = array();

		if(isset($res['query']) && isset($res['query']['recentchanges'])) {
			$out['results'] = $res['query']['recentchanges'];
		}

		if(isset($res['query-continue'])) {
			$out['query-continue'] = $res['query-continue']['recentchanges']['rcstart'];
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

}
