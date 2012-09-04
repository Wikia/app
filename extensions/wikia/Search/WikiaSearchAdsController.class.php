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
			$url = 'http://wikia.infospace.com/wikiagy/wsapi/results' .
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
}
