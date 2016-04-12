<?php

class AnalyticsProviderSpeedBidder implements iAnalyticsProvider {

	private static $template = 'extensions/wikia/AnalyticsEngine/templates/speedBidder.mustache';

	public static function isEnabled() {
		global $wgAdDriverEnableOpenXSpeedBidder, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgAdDriverEnableOpenXSpeedBidder
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml( $params = array() ) {

		return self::isEnabled() ? \MustacheService::getInstance()->render(
			self::$template,
			[
				'instantGlobalName' => json_encode( 'wgAdDriverOpenXSpeedBidderCountries' )
			]
		) : '/* SpeedBidder integration disabled */';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return null;
	}
}

