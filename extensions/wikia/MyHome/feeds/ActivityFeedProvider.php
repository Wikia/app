<?php
class ActivityFeedProvider extends FeedProvider {

	/**
	 * @param int $limit maximal number of results to return
	 * @param timestamp $start the timestamp to start enumerating from
	 * @return array/mixed TODO
	 */
	public function get($limit = 10, $start = null) {
		$results = array();
		while(count($results) < $limit+1) {
			list($bundle, $start) = $this->getData($start);
			$results = $results + $bundle;
			if($start == null) {
				break;
			}
		}

		$out = array();
		$keys = array_keys($results);
		if(isset($keys[$limit])) {
			$out['query-continue'] = $results[$keys[$limit]]['timestamp'];
		}
		$out['results'] =  array_slice($results, 0, $limit);

		return $out;
	}

	/**
	 * @param timestamp $start the timestamp to start enumerating from
	 * @return array/mixed TODO
	 */
	public function getData($start) {
		$params = array();
		$params['action'] = 'query';
		$params['list'] = 'recentchanges';
		$params['rcprop'] = 'comment|timestamp|ids|title|loginfo|user|wikiamode';
		$params['rclimit'] = 25; // Limit is so high because we are excluding a lot of items later

		if(!empty($start)) {
			$params['rcstart'] = $start;
		}

		$api = new ApiMain(new FauxRequest($params));
		$api->execute();
		$res = &$api->GetResultData();

		$results = array();
		if(isset($res['query']) && isset($res['query']['recentchanges'])) {
			$results = $this->filter($res['query']['recentchanges']);
		}

		$rcstart = null;
		if(isset($res['query-continue'])) {
			$rcstart = $res['query-continue']['recentchanges']['rcstart'];
		}

		return array($results, $rcstart);
	}

}