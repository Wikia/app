<?php

class WikiaSearchAdsController extends WikiaController {

	public function getAds() {
		$this->response->setVal('ads', $this->getParsedSearchResults());
	}
	
	private function getParsedSearchResults() {
		return $this->parseSearchResults($this->getSearchResults());
	}

	protected function getSearchResults() {
		$xml = '';
		
		try {
			if (($xml = Http::get($this->getURL())) !== false) {
				return $xml;
			}
		} catch (Exception $e) {}
		
		return $xml;
	}

	private function parseSearchResults($xml) {
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
	
	private function getURL() {
		return 'http://wikia.infospace.com/wikiagy/wsapi/results' .
				'?query=camera' .
				'&category=web' .
				'&resultsBy=relevance' .
				'&enduserip=10.10.10.10' .
				'&X-Insp-User-Headers=User-Agent%3aMozilla%2F4.0' .
				'&family-friendly=off' .
				'&bold=on' .
				'&qi=1';
	}
}