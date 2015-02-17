<?php

/**
 * Controller used by Wikia skins to emit tracking codes
 */
class AnalyticsEngineController extends WikiaController {

	/**
	 * Return the list of providers to be used by track method
	 *
	 * @return array
	 */
	private function getProviders() {
		return [
			'Comscore',
			'QuantServe',
			'AmazonMatch',
			'RubiconRTP',
			'DynamicYield',
			'IVW2',
		];
	}

	/**
	 * Render skin tracking code
	 */
	public function track() {
		$items = [];
		foreach($this->getProviders() as $provider) {
			$items[] = AnalyticsEngine::track( $provider, AnalyticsEngine::EVENT_PAGEVIEW );
		}

		$this->response->setVal( 'items', $items );
	}
}
