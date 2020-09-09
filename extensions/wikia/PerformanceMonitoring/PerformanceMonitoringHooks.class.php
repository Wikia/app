<?php

class PerformanceMonitoringHooks {

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgPerformanceMonitoringSamplingFactor;

		$wikiVariables['wgPerformanceMonitoringSamplingFactor'] = $wgPerformanceMonitoringSamplingFactor;
		$wikiVariables['wgPerformanceMonitoringSoftwareVersion'] = class_exists( 'WikiaSpecialVersion' ) ? (
			WikiaSpecialVersion::getWikiaCodeVersion() ?? '' ) : '';
		$wikiVariables['wgPerformanceMonitoringEndpointUrl'] = self::getViewTrackURL();

		return true;
	}

	private static function getViewTrackURL(): string {
		global $wgWikiaDatacenter, $wgWikiaEnvironment, $wgCityId, $wgContLang, $wgDBname, $wgUser,
			   $wgPerformanceMonitoringBaseUrl;

		$params = [
			'w' => $wgCityId,
			'lc' => $wgContLang->getCode(),
			'd' => $wgDBname,
			's' => 'mobilewiki',
			'u' => ( $wgUser->isLoggedIn() ? 1 : 0 ),
			'a' => '0',
			'i' => ( getenv('HOSTNAME_OVERRIDE') ?? $wgWikiaDatacenter . '-' . $wgWikiaEnvironment ) . '-app',
		];

		return $wgPerformanceMonitoringBaseUrl . '/special/performance_metrics?' . http_build_query( $params );
	}
}
