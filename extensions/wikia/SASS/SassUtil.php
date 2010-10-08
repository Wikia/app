<?php
/**
 * @author Sean Colombo
 *
 * This class is designed to help MediaWiki classes use SASS files.
 *
 * NOTE: This class does the setup necessary for the wfGetSassUrl() JavaScript function
 * to work, but that function is in sassUtil.js.  Also, the wfGetSassUrl() PHP function
 * is in /includes/wikia/GlobalFunctions.php since that is where our 'wf' functions are
 * expected to be.
 */

$wgHooks['MakeGlobalVariablesScript'][] = 'SassUtil::onMakeGlobalVariablesScript';
//$wgHooks['BeforePageDisplay'][] = 'SassUtil::BeforePageDisplay'; // not needed right now - js is in StaticChute

define('DEFAULT_OASIS_THEME', 'oasis');

class SassUtil{

	/**
	 * Creates a hash which serves as a (admittedly weak) cryptographic signature so that
	 * users can't easily request billions/trillions of permutations of colors to force our
	 * servers to waste a ton of time running sass parsing.
	 *
	 * The hash is just based on the color-combination.
	 */
	public static function getSecurityHash($styleVersion, $sassParams){
		global $wgSassPrivateKey;
		$wgSassPrivateKey = (isset($wgSassPrivateKey)?$wgSassPrivateKey:"");
		return sha1("$styleVersion|$sassParams|$wgSassPrivateKey");
	} // end getSecurityHash()

	/**
	 * Gets theme settings from following places:
	 *  - theme designer ($wgOasisThemeSettings)
	 *  - theme chosen using usetheme URL param
	 */
	private static function getOasisSettings() {
		global $wgOasisThemes, $wgUser, $wgAdminSkin, $wgRequest, $wgOasisThemeSettings, $wgContLang;
		wfProfileIn(__METHOD__);

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		static $oasisSettings = array();

		if (!empty($oasisSettings)) {
			wfProfileOut(__METHOD__);
			return $oasisSettings;
		}

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$oasisSettings["color-body"] = $settings["color-body"].' ';
		$oasisSettings["color-page"] = $settings["color-page"];
		$oasisSettings["color-buttons"] = $settings["color-buttons"];
		$oasisSettings["color-links"] = $settings["color-links"];
		$oasisSettings["color-header"] = $settings["color-header"];
		$oasisSettings["background-image"] = $settings["background-image"];
		$oasisSettings["background-align"] = $settings["background-align"];
		$oasisSettings["background-tiled"] = $settings["background-tiled"];

		if($wgContLang && $wgContLang->isRTL()){
			$oasisSettings['rtl'] = 'true';
		}
		
		// RT:70673
		foreach ($oasisSettings as $key => $val) {
			if(!empty($val)) {
				$oasisSettings[$key] = trim($val);
			}
		}

		wfDebug(__METHOD__ . ': ' . Wikia::json_encode($oasisSettings) . "\n");

		wfProfileOut(__METHOD__);
		return $oasisSettings;
	}

	/**
	 * Get default theme settings
	 */
	private static function getDefaultOasisSettings() {
		global $wgOasisThemes;
		return $wgOasisThemes[DEFAULT_OASIS_THEME];
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
	} // end getSassParams()

	/**
	 * Calculates whether currently used theme is light or dark
	 */
	public static function isThemeDark() {
		wfProfileIn(__METHOD__);

		$oasisSettings = self::getOasisSettings();
		if (empty($oasisSettings)) {
			$oasisSettings = self::getDefaultOasisSettings();
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

		$clrR = ($rgb[0] / 255);
		$clrG = ($rgb[1] / 255);
		$clrB = ($rgb[2] / 255);

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

		//wfDebug(__METHOD__ . ": {$rgbhex} -> {$H}, {$S}, {$L}\n");

		wfProfileOut(__METHOD__);
		return array($H, $S, $L);
	}

	/**
	 * Adds a global JS variable containing the hash which acts as a signature for
	 * the current color-settings.  This allows for a javascript version of wfGetSassUrl()
	 * to be safely created & used.
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgStyleVersion, $wgCdnRootUrl;
		wfProfileIn( __METHOD__ );

		$sassParams = self::getSassParams();
		$vars['sassHash'] = self::getSecurityHash($wgStyleVersion, $sassParams);
		$vars['wgCdnRootUrl'] = $wgCdnRootUrl;

		// Convert to slashed-string.
		$sassParams = str_replace(" ", "/", $sassParams);
		$vars['sassParams'] = $sassParams;

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()

	/**
	 * Makes sure that we include the Sass javascript.
	 *
	 * Not needed at the moment since the js file is now in StaticChute (only for Oasis at the time of this writing, but that may change).
	 */
	/*public static function BeforePageDisplay( &$out, &$sk ) {
		wfProfileIn( __METHOD__ );
		if(Wikia::isOasis()){
			global $wgScriptPath, $wgStyleVersion;
			$out->addScriptFile("$wgScriptPath/extensions/wikia/SASS/sassUtil.js?$wgStyleVersion");
		}
		wfProfileOut( __METHOD__ );
		return true;
	} // end BeforePageDisplay()
	*/

} // end class SassUtil
