<?php
/**
 * TimeZonePicker extension: hooks
 * @copyright 2011 Brion Vibber <brion@pobox.com>
 */

class TimeZonePickerHooks {
	/* Static Methods */

	/**
	 * BeforePageDisplay hook
	 *
	 * Adds the modules to the page
	 *
	 * @param $out OutputPage output page
	 * @param $skin Skin current skin
	 */
	public static function beforePageDisplay( $out, $skin ) {
		$title = $out->getTitle();
		if( $title->isSpecial( 'Preferences' ) ) {
			$out->addModules('ext.tzpicker');
			$out->addInlineScript("window.mw_ext_tzpicker_ZoneInfo=" .
					FormatJson::encode(self::zoneInfo()));
		}
		return true;
	}

	/**
	 * Return a set of timezone information relevant to this joyful stuff :D
	 */
	public static function zoneInfo() {
		$zones = array();
		$now = date_create();
		foreach( timezone_identifiers_list() as $tz ) {
			$zone = timezone_open( $tz );

			$name = timezone_name_get( $zone );
			$location = timezone_location_get( $zone );
			$offset = timezone_offset_get( $zone, $now ) / 60; // convert seconds to minutes

			$zones[] = array('name' => $name, 'offset' => $offset, 'location' => $location);
		}
		return $zones;
	}
}
