<?php
/**
 * @author Sean Colombo
 */

class SassUtil {

	const DEFAULT_OASIS_THEME = 'oasis';

	/**
	 * Returns complete set of sass parameters including theme settings set by user
	 * and webapp application settings.
	 */
	public static function getSassSettings() {
		$params = self::getOasisSettings();

		$params = array_merge($params, self::getApplicationThemeSettings());

		ksort( $params );

		return $params;
	}

	/**
	 * Returns a set of sass parameters set by the webapp that should not be saved to wiki themesettings
	 * For example, skin width is an webapp, application, setting.  It is not user controllable.
	 * Rationale: User-set theme settings and skin logic should be kept separate.
	 *            User-set theme settings should be saved.
	 *            Non-settable settings should be driven programmatically.
	 */
	public static function getApplicationThemeSettings() {
		global $wgOasisGrid, $wgOasisHD, $wgOasisResponsive;

		$params = array();

		if ( $wgOasisHD ) {
			$params['widthType'] = 1;
		}

		if ( $wgOasisGrid ) {
			$params['widthType'] = 3;
		}

		// Should be last so it can override wgOasisGrid
		if ( class_exists( 'BodyController' ) && BodyController::isResponsiveLayoutEnabled() ) {
			$params['widthType'] = 2;
		}

		return $params;
	}

	/**
	 * Gets theme settings from following places:
	 *  - theme designer ($wgOasisThemeSettings)
	 *  - theme chosen using usetheme URL param
	 */
	public static function getOasisSettings() {
		global $wgOasisThemes, $wgContLang;
		wfProfileIn(__METHOD__);

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		static $oasisSettings = array();

		if (empty($oasisSettings)) {
			$themeSettings = new ThemeSettings();
			$settings = $themeSettings->getSettings();

			$oasisSettings["color-body"] = self::sanitizeColor($settings["color-body"]);
			$oasisSettings["color-page"] = self::sanitizeColor($settings["color-page"]);
			$oasisSettings["color-buttons"] = self::sanitizeColor($settings["color-buttons"]);
			$oasisSettings["color-links"] = self::sanitizeColor($settings["color-links"]);
			$oasisSettings["color-header"] = self::sanitizeColor($settings["color-header"]);
			$oasisSettings["background-image"] = wfReplaceImageServer($settings['background-image'], self::getCacheBuster());

			// sending width and height of background image to SASS
			if ( !empty($settings["background-image-width"]) && !empty($settings["background-image-height"]) ) {
				// strip 'px' from previously cached settings since we removed 'px' (sanity check)
				$oasisSettings["background-image-width"] = str_replace( 'px', '', $settings["background-image-width"] );
				$oasisSettings["background-image-height"] = str_replace( 'px', '', $settings["background-image-height"] );
			} else {
				// if not cached in theme settings
				$bgImage = wfFindFile(ThemeSettings::BackgroundImageName);
				if ( !empty($bgImage) ) {
					$settings["background-image-width"] = $oasisSettings["background-image-width"] = $bgImage->getWidth();
					$settings["background-image-height"] = $oasisSettings["background-image-height"] = $bgImage->getHeight();

					$themeSettings->saveSettings($settings);
				}
			}

			$oasisSettings["background-align"] = $settings["background-align"];
			$oasisSettings["background-tiled"] = $settings["background-tiled"];
			$oasisSettings["background-fixed"] = $settings["background-fixed"];
			$oasisSettings["page-opacity"] = $settings["page-opacity"];
			if (!empty($settings["wordmark-font"]) && $settings["wordmark-font"] != "default") {
				$oasisSettings["wordmark-font"] = $settings["wordmark-font"];
			}

			// RTL
			if($wgContLang && $wgContLang->isRTL()){
				$oasisSettings['rtl'] = 'true';
			}

			// RT:70673
			foreach ($oasisSettings as $key => $val) {
				if(!empty($val)) {
					$oasisSettings[$key] = trim($val);
				}
			}
		}

		wfDebug(__METHOD__ . ': ' . json_encode($oasisSettings) . "\n");

		wfProfileOut(__METHOD__);

		return $oasisSettings;
	}

	/**
	 * Get default theme settings
	 */
	private static function getDefaultOasisSettings() {
		global $wgOasisThemes;
		return $wgOasisThemes[self::DEFAULT_OASIS_THEME];
	}

	/**
	 * Get cache buster value for current version of theme settings
	 */
	public static function getCacheBuster() {
		global $wgOasisThemeSettingsHistory;
		wfProfileIn(__METHOD__);
		static $cb = null;

		if (is_null($cb)) {
			$currentSettings = end($wgOasisThemeSettingsHistory);
			if (!empty($currentSettings['revision'])) {
				$cb = $currentSettings['revision'];
			}
			else {
				$cb = 1;
			}
		}

		wfProfileOut(__METHOD__);
		return $cb;
	}

	/**
	 * Get normalized color value (RT #74057)
	 */
	public static function sanitizeColor($color) {
		$color = trim(strtolower($color));
		return $color;
	}

	/**
	 * Returns an associative array of the parameters to pass to SASS.  These are based on the theme
	 * for the wiki and potentially user-specific overrides.
	 */
	public static function getSassParams(){
		wfProfileIn( __METHOD__ );

		$sassParams = http_build_query(self::getOasisSettings());

		wfProfileOut( __METHOD__ );
		return $sassParams;
	}

	/**
	 * Calculates whether currently used theme is light or dark
	 */
	public static function isThemeDark($oasisSettings = null) {
		wfProfileIn(__METHOD__);

		if (empty($oasisSettings)) {
			$oasisSettings = self::getOasisSettings();
			if(empty($oasisSettings)) {	// if it's still empty
				$oasisSettings = self::getDefaultOasisSettings();
			}
		}

		$backgroundColor = $oasisSettings['color-page'];

		// convert RGB to HSL
		list($hue, $saturation, $lightness) = self::rgb2hsl($backgroundColor);

		$isDark = ($lightness < 0.5);

		wfDebug(__METHOD__ . ': ' . ($isDark ? 'yes' : 'no') . "\n");

		wfProfileOut(__METHOD__);
		return $isDark;
	}

	/**
	 * Convert RGB colors array into HSL array
	 *
	 * @see http://blog.archive.jpsykes.com/211/rgb2hsl/index.html
	 *
	 * @param string RGB color in hex format (#474646)
	 * @return array HSL set
	 */
	private static function rgb2hsl($rgbhex){
		wfProfileIn(__METHOD__);

		// convert HEX color to rgb values
		// #474646 -> 71, 70, 70
		$rgb = str_split(substr($rgbhex, 1), 2);
		$rgb = array_map('hexdec', $rgb);

		$clrR = (!empty($rgb[0])? ($rgb[0]/255) : 0 );
		$clrG = (!empty($rgb[1])? ($rgb[1]/255) : 0 );
		$clrB = (!empty($rgb[2])? ($rgb[2]/255) : 0 );

		$clrMin = min($clrR, $clrG, $clrB);
		$clrMax = max($clrR, $clrG, $clrB);
		$deltaMax = $clrMax - $clrMin;

		$L = ($clrMax + $clrMin) / 2;

		if (0 == $deltaMax){
			$H = 0;
			$S = 0;
		}
		else{
			if (0.5 > $L){
				$S = $deltaMax / ($clrMax + $clrMin);
			}
			else{
				$S = $deltaMax / (2 - $clrMax - $clrMin);
			}
			$deltaR = ((($clrMax - $clrR) / 6) + ($deltaMax / 2)) / $deltaMax;
			$deltaG = ((($clrMax - $clrG) / 6) + ($deltaMax / 2)) / $deltaMax;
			$deltaB = ((($clrMax - $clrB) / 6) + ($deltaMax / 2)) / $deltaMax;
			if ($clrR == $clrMax){
				$H = $deltaB - $deltaG;
			}
			else if ($clrG == $clrMax){
				$H = (1 / 3) + $deltaR - $deltaB;
			}
			else if ($clrB == $clrMax){
				$H = (2 / 3) + $deltaG - $deltaR;
			}
			if (0 > $H) $H += 1;
			if (1 < $H) $H -= 1;
		}

		wfProfileOut(__METHOD__);
		return array($H, $S, $L);
	}

}
