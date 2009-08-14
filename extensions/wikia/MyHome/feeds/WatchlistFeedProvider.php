<?php
class WatchlistFeedProvider extends FeedProvider {

	/**
	 * @return array/mixed TODO
	 */
	public function get() {
		$params = array();
		$params['action'] = 'query';
		$params['list'] = 'watchlist';
		$params['wlprop'] = 'ids|title|flags|user|comment|timestamp|patrol|sizes|wikiamode';
		$params['wllimit'] = 1000; // Limit is so high because we are excluding a lot of items later

		if(!empty($start)) {
			$params['wlstart'] = $start;
		}

		$api = new ApiMain(new FauxRequest($params));
		$api->execute();
		$res = &$api->GetResultData();

		if(isset($res['query']) && isset($res['query']['watchlist'])) {
			return array('results' => $this->filter($res['query']['watchlist']));
		}

	}

}
