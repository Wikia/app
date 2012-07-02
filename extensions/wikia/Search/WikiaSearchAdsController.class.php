<?php

class WikiaSearchAdsController extends WikiaController {

	public function getAds() {
		$query = $this->request->getVal('query');
		$ip = $this->request->getVal('ip');
		$header = $this->request->getVal('header');
		
		$url = $this->getUrl($query, $ip, $header);
		$xml = $this->getSearchResults($url);
		$ads = $this->parseXml($xml);

		$this->response->setVal('ads', $ads);
	}
	
	protected function getSearchResults($url) {
		$xml = '';
		
		try {
			if (($xml = Http::get($url)) !== false) {
				return $xml;
			}
		} catch (Exception $e) {}
		
		return $xml;
	}

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
	
	public function getURL($query = null, $ip = null, $header = null) {
		$ip = wfGetIp();

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
