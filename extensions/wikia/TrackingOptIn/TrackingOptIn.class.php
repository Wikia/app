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

		return true;
	}

	public static function renderScript() {
		return \MustacheService::getInstance()->render(self::TEMPLATE, []);
	}
}
