<?php

class AnalyticsProviderQuantServe extends ContextSource implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function trackEvent( $event, $eventDetails = [] ) {
		if ( $event === AnalyticsEngine::EVENT_PAGEVIEW ){
			$this->getOutput()->addJsConfigVars( 'wgQuantcastConfiguration', [
				'account' => $this->account,
				'url' => 'https://secure.quantserve.com/quant.js'
			] );
		}
	}

	public function getSetupHtml( $params = [] ) {
		return '';
	}
}
