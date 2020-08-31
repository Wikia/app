<?php
/**
 * @author Sean Colombo
 */

class SassUtil {

	const DEFAULT_OASIS_THEME = 'oasis';
	const HEX_REG_EXP = '/#([a-f0-9]{3,6})/i';
	const THEME_DESIGNER_COLOR_KEYS = array('color-body', 'color-body-middle', 'color-page', 'color-buttons', 'color-links', 'color-community-header', 'color-header');

	static $oasisSettings = [];

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
		if ( class_exists( 'BodyController' ) && BodyController::isOasisBreakpoints( ) ) {
			$params = [
				'widthType' => 0,
			];
			if ( BodyController::isOasisTypography() ) {
				$params['oasisTypography'] = 1;
			}

			return $params;
		} else {
			$params = [];

			global $wgOasisGrid;
			if ( $wgOasisGrid ) {
				$params['widthType'] = 3;
			}

			// Should be last so it can override wgOasisGrid
			if ( class_exists( 'BodyController' ) && BodyController::isResponsiveLayoutEnabled() ) {
				$params['widthType'] = 2;
			}

			return $params;
		}
	}

	/**
	 * Gets theme settings from following places:
	 *  - theme designer ($wgOasisThemeSettings)
	 *  - theme chosen using usetheme URL param
	 */
	public static function getOasisSettings() {
		wfProfileIn(__METHOD__);

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		if (empty(static::$oasisSettings)) {
			$themeSettings = new ThemeSettings();
			$settings = $themeSettings->getSettings();

			static::$oasisSettings['color-body'] = self::sanitizeColor($settings['color-body']);
			static::$oasisSettings['color-body-middle'] = self::sanitizeColor($settings['color-body-middle']);
			static::$oasisSettings['color-page'] = self::sanitizeColor($settings['color-page']);
			static::$oasisSettings['color-buttons'] = self::sanitizeColor($settings['color-buttons']);
			static::$oasisSettings['color-community-header'] = self::sanitizeColor($settings['color-community-header']);
			static::$oasisSettings['color-links'] = self::sanitizeColor($settings['color-links']);
			static::$oasisSettings['color-header'] = self::sanitizeColor($settings['color-header']);
			static::$oasisSettings['background-image'] = $themeSettings->getBackgroundUrl();

			// sending width and height of background image to SASS
			if ( !empty($settings['background-image-width']) && !empty($settings['background-image-height']) ) {
				// strip 'px' from previously cached settings since we removed 'px' (sanity check)
				static::$oasisSettings['background-image-width'] = str_replace( 'px', '', $settings['background-image-width'] );
				static::$oasisSettings['background-image-height'] = str_replace( 'px', '', $settings['background-image-height'] );
			} else {
				// if not cached in theme settings
				$bgImage = wfFindFile(ThemeSettings::BackgroundImageName);
				if ( !empty($bgImage) ) {
					\Wikia\Logger\WikiaLogger::instance()->warning( 'Theme Designer background dimension not set', [
						'backgroundImageTimestamp' => $bgImage->getTimestamp()
					] );

					$settings['background-image-width'] = static::$oasisSettings['background-image-width'] = $bgImage->getWidth();
					$settings['background-image-height'] = static::$oasisSettings['background-image-height'] = $bgImage->getHeight();
				}
			}

			static::$oasisSettings['background-dynamic'] = $settings['background-dynamic'];
			static::$oasisSettings['page-opacity'] = $settings['page-opacity'];
			if (!empty($settings['wordmark-font']) && $settings['wordmark-font'] != 'default') {
				static::$oasisSettings['wordmark-font'] = $settings['wordmark-font'];
			}

			// RTL
			if(self::isRTL()){
				static::$oasisSettings['rtl'] = 'true';
			}

			// RT:70673
			foreach (static::$oasisSettings as $key => $val) {
				if(!empty($val)) {
					static::$oasisSettings[$key] = trim($val);
				}
			}
		}

		wfDebug(__METHOD__ . ': ' . json_encode(static::$oasisSettings) . "\n");

		wfProfileOut(__METHOD__);

		return static::$oasisSettings;
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

		if (is_null($cb) && is_array($wgOasisThemeSettingsHistory)) {
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
	 * @param string $color
	 * @return string
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
	 * @param string $rgbhex RGB color in hex format (#474646)
	 * @return array HSL set
	 */
	private static function rgb2hsl($rgbhex){
		wfProfileIn(__METHOD__);

		if ( $rgbhex[0] != '#' ) {
			$rgbhex = self::colorNameToHex( $rgbhex );
		}

		// We need to convert hex shorthand format
		if ( strlen( $rgbhex ) == 4 ) {
			$rgbhex[6] = $rgbhex[3];
			$rgbhex[5] = $rgbhex[3];
			$rgbhex[4] = $rgbhex[2];
			$rgbhex[3] = $rgbhex[2];
			$rgbhex[2] = $rgbhex[1];
		}

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

	/**
	 * Detects if the SASS should be returned in RTL "mode"
	 *
	 * @see PLATFORM-408
	 *
	 * RTL should be used if user language is RTL
	 *
	 * @return bool should RTL be used?
	 */
	public static function isRTL() {
		$app = F::app();

		// this will fallback to wiki content language for anons
		$userLang = $app->wg->Lang;

		return ( !empty($userLang) && $userLang->isRTL() );
	}

	/**
	 * Convert HTML color name to hex format
	 * We allow users to use color names in ThemeDesigner so we need to support them
	 *
	 * @param $colorName
	 * @return mixed
	 */
	public static function colorNameToHex($colorName) {
		// standard 147 HTML color names
		$colors  =  array(
			'aliceblue' => '#f0f8ff',
			'antiquewhite' => '#faebd7',
			'aqua' => '#00ffff',
			'aquamarine' => '#7fffd4',
			'azure' => '#f0ffff',
			'beige' => '#f5f5dc',
			'bisque' => '#ffe4c4',
			'black' => '#000000',
			'blanchedalmond ' => '#ffebcd',
			'blue' => '#0000ff',
			'blueviolet' => '#8a2be2',
			'brown' => '#a52a2a',
			'burlywood' => '#deb887',
			'cadetblue' => '#5f9ea0',
			'chartreuse' => '#7fff00',
			'chocolate' => '#d2691e',
			'coral' => '#ff7f50',
			'cornflowerblue' => '#6495ed',
			'cornsilk' => '#fff8dc',
			'crimson' => '#dc143c',
			'cyan' => '#00ffff',
			'darkblue' => '#00008b',
			'darkcyan' => '#008b8b',
			'darkgoldenrod' => '#b8860b',
			'darkgray' => '#a9a9a9',
			'darkgreen' => '#006400',
			'darkgrey' => '#a9a9a9',
			'darkkhaki' => '#bdb76b',
			'darkmagenta' => '#8b008b',
			'darkolivegreen' => '#556b2f',
			'darkorange' => '#ff8c00',
			'darkorchid' => '#9932cc',
			'darkred' => '#8b0000',
			'darksalmon' => '#e9967a',
			'darkseagreen' => '#8fbc8f',
			'darkslateblue' => '#483d8b',
			'darkslategray' => '#2f4f4f',
			'darkslategrey' => '#2f4f4f',
			'darkturquoise' => '#00ced1',
			'darkviolet' => '#9400d3',
			'deeppink' => '#ff1493',
			'deepskyblue' => '#00bfff',
			'dimgray' => '#696969',
			'dimgrey' => '#696969',
			'dodgerblue' => '#1e90ff',
			'firebrick' => '#b22222',
			'floralwhite' => '#fffaf0',
			'forestgreen' => '#228b22',
			'fuchsia' => '#ff00ff',
			'gainsboro' => '#dcdcdc',
			'ghostwhite' => '#f8f8ff',
			'gold' => '#ffd700',
			'goldenrod' => '#daa520',
			'gray' => '#808080',
			'green' => '#008000',
			'greenyellow' => '#adff2f',
			'grey' => '#808080',
			'honeydew' => '#f0fff0',
			'hotpink' => '#ff69b4',
			'indianred' => '#cd5c5c',
			'indigo' => '#4b0082',
			'ivory' => '#fffff0',
			'khaki' => '#f0e68c',
			'lavender' => '#e6e6fa',
			'lavenderblush' => '#fff0f5',
			'lawngreen' => '#7cfc00',
			'lemonchiffon' => '#fffacd',
			'lightblue' => '#add8e6',
			'lightcoral' => '#f08080',
			'lightcyan' => '#e0ffff',
			'lightgoldenrodyellow' => '#fafad2',
			'lightgray' => '#d3d3d3',
			'lightgreen' => '#90ee90',
			'lightgrey' => '#d3d3d3',
			'lightpink' => '#ffb6c1',
			'lightsalmon' => '#ffa07a',
			'lightseagreen' => '#20b2aa',
			'lightskyblue' => '#87cefa',
			'lightslategray' => '#778899',
			'lightslategrey' => '#778899',
			'lightsteelblue' => '#b0c4de',
			'lightyellow' => '#ffffe0',
			'lime' => '#00ff00',
			'limegreen' => '#32cd32',
			'linen' => '#faf0e6',
			'magenta' => '#ff00ff',
			'maroon' => '#800000',
			'mediumaquamarine' => '#66cdaa',
			'mediumblue' => '#0000cd',
			'mediumorchid' => '#ba55d3',
			'mediumpurple' => '#9370d0',
			'mediumseagreen' => '#3cb371',
			'mediumslateblue' => '#7b68ee',
			'mediumspringgreen' => '#00fa9a',
			'mediumturquoise' => '#48d1cc',
			'mediumvioletred' => '#c71585',
			'midnightblue' => '#191970',
			'mintcream' => '#f5fffa',
			'mistyrose' => '#ffe4e1',
			'moccasin' => '#ffe4b5',
			'navajowhite' => '#ffdead',
			'navy' => '#000080',
			'oldlace' => '#fdf5e6',
			'olive' => '#808000',
			'olivedrab' => '#6b8e23',
			'orange' => '#ffa500',
			'orangered' => '#ff4500',
			'orchid' => '#da70d6',
			'palegoldenrod' => '#eee8aa',
			'palegreen' => '#98fb98',
			'paleturquoise' => '#afeeee',
			'palevioletred' => '#db7093',
			'papayawhip' => '#ffefd5',
			'peachpuff' => '#ffdab9',
			'peru' => '#cd853f',
			'pink' => '#ffc0cb',
			'plum' => '#dda0dd',
			'powderblue' => '#b0e0e6',
			'purple' => '#800080',
			'red' => '#ff0000',
			'rosybrown' => '#bc8f8f',
			'royalblue' => '#4169e1',
			'saddlebrown' => '#8b4513',
			'salmon' => '#fa8072',
			'sandybrown' => '#f4a460',
			'seagreen' => '#2e8b57',
			'seashell' => '#fff5ee',
			'sienna' => '#a0522d',
			'silver' => '#c0c0c0',
			'skyblue' => '#87ceeb',
			'slateblue' => '#6a5acd',
			'slategray' => '#708090',
			'slategrey' => '#708090',
			'snow' => '#fffafa',
			'springgreen' => '#00ff7f',
			'steelblue' => '#4682b4',
			'tan' => '#d2b48c',
			'teal' => '#008080',
			'thistle' => '#d8bfd8',
			'tomato' => '#ff6347',
			'turquoise' => '#40e0d0',
			'violet' => '#ee82ee',
			'wheat' => '#f5deb3',
			'white' => '#ffffff',
			'whitesmoke' => '#f5f5f5',
			'yellow' => '#ffff00',
			'yellowgreen' => '#9acd32'
		);

		if ( isset( $colors[ $colorName ] ) ) {
			return $colors[ $colorName ];
		} else {
			return $colorName;
		}
	}

	/**
	 * @desc Converts theme designer color names to hex
	 *
	 * @param $themeSettings
	 * @return mixed
	 */
	public static function normalizeThemeColors( $themeSettings ) {
		foreach ( self::THEME_DESIGNER_COLOR_KEYS as $key ) {
			if ( !preg_match(self::HEX_REG_EXP, $themeSettings[$key]) ) {
				$themeSettings[$key] = self::colorNameToHex( $themeSettings[$key] );
			}
		}

		return $themeSettings;
	}

	/**
	 * @param $themeSettings
	 *
	 * @return mixed
	 */
	public static function convertColorsToRgb( array $themeSettings ): array {
		$settings = [];

		foreach ( self::normalizeThemeColors( $themeSettings ) as $key => $val ) {
			if ( preg_match( self::HEX_REG_EXP, $val ) ) {
				$settings[$key] = self::hexToRgb( $val );
			} else {
				$settings[$key] = $val;
			}
		}

		return $settings;
	}

	/**
	 * @param string $hex
	 *
	 * @return array with r, g and b keys
	 */
	public static function hexToRgb( string $hex ): array {
		$hex      = str_replace('#', '', $hex);
		$length   = strlen($hex);
		$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
		$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
		$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

		return $rgb;
	}
}
