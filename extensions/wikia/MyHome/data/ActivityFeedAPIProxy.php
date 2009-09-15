<?php

class ActivityFeedAPIProxy implements iAPIProxy {

	var $APIparams;

	public function __construct() {
		$this->APIparams = array();
		$this->APIparams['action'] = 'query';
		$this->APIparams['list'] = 'recentchanges';
		$this->APIparams['rcprop'] = 'comment|timestamp|ids|title|loginfo|user|wikiamode';
		$this->APIparams['rcshow'] = '!bot';
	}

	public function get($limit, $start = null) {
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

		return $out;
	}

}
