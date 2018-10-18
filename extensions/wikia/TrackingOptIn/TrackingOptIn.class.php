<?php

class TrackingOptIn {
	const ASSET_GROUP_TRACKING_OPT_IN = 'tracking_opt_in_js';
	const TEMPLATE = 'extensions/wikia/TrackingOptIn/templates/tracking-opt-in.mustache';

	public static function onOasisSkinAssetGroupsBlocking( &$jsAssets ) {
		$jsAssets[] = static::ASSET_GROUP_TRACKING_OPT_IN;

		return true;
	}

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgEnableTrackingOptInModal';
		// TODO: Remove variable once @wikia/tracking-opt-in#1.0.36 is released
		$vars[] = 'wgEnableCMPCountries';

		return true;
	}

	public static function renderScript() {
		return \MustacheService::getInstance()->render(self::TEMPLATE, []);
	}
}
