<?php

class AbTestingController extends WikiaController {

	protected $abTesting;
	protected $externalData;
	protected $externalDataLoaded = false;

	/**
	 * @return AbTesting
	 */
	protected function getAbTesting() {
		if ( !$this->abTesting ) {
			$this->abTesting = new AbTesting();
		}
		return $this->abTesting;
	}

	protected function getExternalData() {
		if ( !$this->externalDataLoaded ) {
			$this->externalDataLoaded = true;
			$this->externalData = $this->getAbTesting()->getConfigExternalData();
		}
		return $this->externalData;
	}

	public function externalData() {
		$request = $this->getVal('ids');
		$request = !empty($request) && is_string($request) ? explode(',',$request) : array();
		foreach ($request as $groupSpec) {
			$parts = explode('.',$groupSpec);
			if ( count($parts) != 3 ) {
				continue;
			}
			list( $expName, $versionId, $groupId ) = $parts;
			$data = $this->getGroupData( $expName, $versionId, $groupId );
			if ( $data ) {
				$this->setVal($groupSpec,$data);
			}
		}

		// force output format to be JSONP
		$response = $this->getResponse();
		$response->setFormat(WikiaResponse::FORMAT_JSONP);

		// set appropriate cache TTL
		$cacheTTL = $this->getCacheTTL();
		$response->setCacheValidity(null,$cacheTTL['client'],array(WikiaResponse::CACHE_TARGET_BROWSER));
		$response->setCacheValidity(null,$cacheTTL['server'],array(WikiaResponse::CACHE_TARGET_VARNISH));
	}

	protected function getGroupData( $expName, $versionId, $groupId ) {
		$externalData = $this->getExternalData();
		if ( !isset( $externalData[$expName][$versionId][$groupId] ) ) {
			return false;
		}
		$data = $externalData[$expName][$versionId][$groupId];
		return $this->processData($data);
	}

	protected function processData( $input ) {
		$result = array();
		if ( isset($input['styles']) ) {
			$styles = $input['styles'];
			try {
				$sassService = SassService::newFromString($input['styles'],0,'');
				$sassService->setFilters(
					  SassService::FILTER_IMPORT_CSS
					| SassService::FILTER_CDN_REWRITE
					| SassService::FILTER_BASE64
					| SassService::FILTER_JANUS
					| SassService::FILTER_MINIFY
				);
				$styles = '/*SASS*/' . $sassService->getCss();
			} catch (Exception $e) {
				$styles = "/* SASS processing failed */\n\n";
				$styles .= $input['styles'];
			}
			$result['styles'] = $styles;
		}
		if ( isset($input['scripts']) ) {
			$result['scripts'] = $input['scripts'];
		}
		return $result;
	}

	protected function getCacheTTL() {
		return $this->wg->ResourceLoaderMaxage['unversioned'];
	}

}