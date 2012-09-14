<?php

/**
 *
 */
class WikiaSearchAdsController extends WikiaController {

	/**
	 * @param array $vars
	 * @return bool
	 */
	public function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgEnableAdsInContent'] = 0;

		return true;
	}

	/**
	 *
	 */
	public function getAds() {
		$query = $this->request->getVal('query');
		$ip = $this->app->wg->Request->getIP();
		$header = $this->request->getVal('header');

		$url = self::getUrl($query, $ip, $header);
		$xml = $this->getSearchResults($url);
		$ads = $this->parseXml($xml);

		$this->response->setVal('ads', $ads);
	}

	/**
	 * @param $url
	 * @return string
	 */
	protected function getSearchResults($url) {
		$xml = '';

		try {
			if (($xml = Http::get($url)) !== false) {
				return $xml;
			}
		} catch (Exception $e) {}

		return $xml;
	}

	/**
	 * @param $xml
	 * @return array
	 */
	private function parseXml($xml) {
		$results = array();

		try {
			$sxe = new SimpleXmlElement($xml);
			foreach ($sxe->xpath('//result') as $r) {
				$results[] = (array) $r;
			}
			//var_dump($results);
		} catch(Exception $e) {}

		return $results;
	}

	/**
	 * @static
	 * @param null $query
	 * @param null $ip
	 * @param null $header
	 * @return string
	 */
	public static function getURL($query = null, $ip = null, $header = null) {
		$url = '';

		if (!empty($query) && !empty($ip) && !empty($header)) {
			$partner_id = self::getPartnerId();
			$url = 'http://wikia.infospace.com/' . urlencode($partner_id) . '/wsapi/results' .
					'?query=' . urlencode($query) .
					'&category=web' .
					'&resultsBy=relevance' .
					'&enduserip=' . urlencode($ip) .
					'&X-Insp-User-Headers=' . urlencode("User-Agent:{$header}") .
					'&family-friendly=on' .
					'&bold=on' .
					'&qi=1';
		}

		return $url;
	}

	/**
	 * @static
	 * @return string
	 */
	public static function getPartnerId() {
		$partner_id = 'wikiagy';

		// TODO get rid of global...
		global $wgInfospaceSearchSub_IDS;
		if (!empty($wgInfospaceSearchSub_IDS)) {
			$partner_id = $partner_id . '_' . $wgInfospaceSearchSub_IDS;
		}

		return $partner_id;
	}
}
