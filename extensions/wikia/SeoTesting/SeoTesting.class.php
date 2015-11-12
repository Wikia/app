<?php

class SeoTesting {
	const NO_SUCH_TEST = -1;
	const TEST_NOT_ENABLED_HERE = -2;
	const TEST_NOT_ENABLED_TODAY = -3;
	const NOT_AN_ARTICLE = -4;

	// For reading wgSeoTestingExperiments from community.wikia.com:
	const COMMUNITY_CENTRAL_CITY_ID = 177;

	/**
	 * Returns group for SEO testing
	 *
	 * Group 1 is about 40% of article traffic
	 * Groups 2, 3 and 4 are about 20% of article traffic each
	 *
	 * Negative group means we should not experiment:
	 *
	 * Group -1 (NO_SUCH_TEST) means there no such test
	 * Group -2 (TEST_NOT_ENABLED_HERE) means test is not enabled on this wiki
	 * Group -3 (TEST_NOT_ENABLED_TODAY) means test is not enabled today
	 * Group -4 (NOT_AN_ARTICLE) means not an article
	 *
	 * @param $experimentName string experiment name
	 * @return int group number
	 */
	public static function getGroup( $experimentName ) {
		global $wgDBname;

		static $wgSeoTestingExperiments = null;

		if ( is_null( $wgSeoTestingExperiments ) ) {
			$wgSeoTestingExperiments = WikiFactory::getVarValueByName(
				'wgSeoTestingExperiments',
				self::COMMUNITY_CENTRAL_CITY_ID
			);
		}

		if ( empty( $wgSeoTestingExperiments[ $experimentName ] ) ) {
			return self::NO_SUCH_TEST;
		}

		$experimentConfig = $wgSeoTestingExperiments[ $experimentName ];
		if ( !in_array( $wgDBname, $experimentConfig[ 'dbNames' ] ) ) {
			return self::TEST_NOT_ENABLED_HERE;
		}

		$today = date( 'Y-m-d' );
		if ( $today < $experimentConfig[ 'startDay' ] || $today > $experimentConfig[ 'endDay' ] ) {
			return self::TEST_NOT_ENABLED_TODAY;
		}

		return self::getBucket();
	}

	/**
	 * Returns bucket for SEO testing
	 *
	 * Group 1 is about 40% of article traffic
	 * Groups 2, 3 and 4 are about 20% of article traffic each
	 *
	 * Group -4 (NOT_AN_ARTICLE) means not an article
	 *
	 * @return int group number
	 */
	public static function getBucket() {
		global $wgTitle, $wgRequest;

		static $bucket = null;

		if ( !is_null( $bucket ) ) {
			return $bucket;
		}

		if ( ! WikiaPageType::isArticlePage() ) {
			$bucket = self::NOT_AN_ARTICLE;
			return $bucket;
		}

		// Mapping based on 7th to last character in the URL
		$url = $wgTitle->getLocalURL();
		$char = substr( $url, strlen( $url ) - 7, 1 );
		$charModulus = ord( $char ) % 5;
		$bucket = min( $charModulus, 3 ) + 1;

		return $bucket;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		// This is for analytics
		$vars[ 'wgSeoTestingBucket' ] = self::getBucket();
		return true;
	}
}
