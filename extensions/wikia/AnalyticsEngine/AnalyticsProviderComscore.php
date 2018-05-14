<?php

class AnalyticsProviderComscore extends ContextSource implements iAnalyticsProvider {

	private static $PARTNER_ID = 6177433;

	function getSetupHtml($params=array()){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		if ( $event === AnalyticsEngine::EVENT_PAGEVIEW ) {
			$c7 = static::getC7Value();

			if ( $c7 ) {
				$configuration = [
					'partnerId' => static::$PARTNER_ID,
					'c7value' => $c7,
					'url' => 'https://sb.scorecardresearch.com/beacon.js'
				];

				$this->getOutput()->addJsConfigVars( 'wgComscoreConfiguration', $configuration );
			}
		}
	}

	public static function getC7Value() {
		global $wgCityId;

		$verticalName = HubService::getVerticalNameForComscore( $wgCityId );

		$categoryOverride = HubService::getComscoreCategoryOverride( $wgCityId );
		if ( $categoryOverride ) {
			$verticalName = $categoryOverride;
		}

		if ( !$verticalName ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Vertical not set for comscore', [
				'cityId' => $wgCityId,
				'exception' => new Exception()
			] );
			return false;
		} else {
			return 'wikiacsid_' . $verticalName;
		}
	}
}
