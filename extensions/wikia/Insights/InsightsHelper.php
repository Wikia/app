<?php

class InsightsHelper {

	public static $insightsMessageKeys = [
		'uncategorized' => [
			'subtitle' => 'insights-list-uncategorized-subtitle',
			'description' => 'insights-list-uncategorized-description',
		],
		'withoutimages' => [
			'subtitle' => 'insights-list-withoutimages-subtitle',
			'description' => 'insights-list-withoutimages-description',
		],
		'wantedpages' => [
			'subtitle' => 'insights-list-wantedpages-subtitle',
			'description' => 'insights-list-wantedpages-description',
		],
	];

	public static function getSubpageLocalUrl( $key ) {
		if ( isset( self::$insightsMessageKeys[$key] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $key )->getLocalURL();
		}
		return null;
	}
}
