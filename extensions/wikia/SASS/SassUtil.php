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
	 * Returns an associative array of the parameters to pass to SASS.  These are based on the theme
	 * for the wiki and potentially user-specific overrides.
	 */
	public static function getSassParams(){
		global $wgOasisThemes, $wgUser, $wgAdminSkin, $wgRequest, $wgContLang, $wgOasisThemeSettings;
		wfProfileIn( __METHOD__ );

		static $sassParams = null;

		if (!is_null($sassParams)) {
			wfProfileOut( __METHOD__ );
			return $sassParams;
		}

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		$oasisSettings = array();
		$skin = $wgUser->getSkin();

		// try to load settings from ThemeDesigner
		if (!empty($wgOasisThemeSettings)) {
			$keys = array_keys($wgOasisThemes['sapphire']);

			// get color settings
			foreach($keys as $key) {
				$oasisSettings[$key] = $wgOasisThemeSettings[$key];
			}
		}
		else if(isset($skin->themename)) {
			if($skin->themename == 'custom'){
				// If this is a custom theme, we need to load it from a different spot if it's an admin custom theme than a user custom theme.
				$overwriteUserSkin = (bool)$wgUser->getOption("skinoverwrite"); // allow Admin's theme to overwrite user skin.
				if($overwriteUserSkin && !empty($wgAdminSkin)){
					global $wgOasisSettings;
					$oasisSettings = unserialize($wgOasisSettings);
				} else {
					// NOTE: THIS MIGHT NOT BE USED AT ALL (depending on how Product specs the theme chooser).
					// ...users might not be allowed to make their own custom skins... currently only Admins do that (for sites... not for themselves).
					$oasisSettings = unserialize($wgUser->getOption('oasis_settings'));
				}
			} else if(isset($wgOasisThemes[$skin->themename])){
				$oasisSettings = $wgOasisThemes[$skin->themename];
			}
		}

		// Get the SASS parameters (in the same format that sassServer::getSassParamsFromUrl() returns - "=" separating key/value and " " separating pairs).
		$sassParams = "";
		if($wgContLang && $wgContLang->isRTL()){
			$sassParams .= "rtl=true";
		}
		if(is_array($oasisSettings)){
			foreach($oasisSettings as $key=>$value){
				$sassParams .= ($sassParams == ""?"":" ");
				$sassParams .= "$key=".urlencode($value);
			}
		}

		wfDebug(__METHOD__ . ": {$sassParams}\n");

		wfProfileOut( __METHOD__ );
		return $sassParams;
	} // end getSassParams()

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
