<?php
/**
 * Hooks for WebFonts extension
 *
 * @file
 * @ingroup Extensions
 */

// WebFonts hooks
class WebFontsHooks {

	/**
	 * BeforePageDisplay hook handler.
	 * @param $out OutputPage
	 * @param $skin Skin
	 * @return bool
	 */
	public static function addModules( $out, $skin ) {

		if ( $out->getUser()->getOption( 'webfontsEnable' ) ) {
			$out->addModules( 'ext.webfonts.init' );
		}

		return true;
	}
	/**
	 * ResourceLoaderTestModules hook handler.
	 * @param $testModules: array of javascript testing modules. 'qunit' is fed using tests/qunit/QUnitTestResources.php.
	 * @param $resourceLoader object
	 * @return bool
	 */
	public static function addTestModules( array &$testModules, ResourceLoader &$resourceLoader ) { 
		$testModules['qunit']['ext.webfonts.tests'] = array(
			'scripts' => array( 'tests/qunit/ext.webfonts.tests.js' ),
			'dependencies' => array( 'ext.webfonts.core' ),
			'localBasePath' => dirname( __FILE__ ),
			'remoteExtPath' => 'WebFonts',
		);
		return true;
	}

	/**
	 * GetPreferences hook handler.
	 * @param $user User
	 * @param $preferences array
	 * @return bool
	 */
	public static function addPreference( $user, &$preferences ) {
		// A checkbox in preferences to enable WebFonts
		$preferences['webfontsEnable'] = array(
			'type' => 'toggle',
			'label-message' => 'webfonts-enable-preference', // a system message
			'section' => 'rendering/advancedrendering', // under 'Advanced options' section of 'Editing' tab
			'default' => $user->getOption( 'webfontsEnable' )
		);

		return true;
	}

	/**
	 * Hook: ResourceLoaderGetConfigVars
	 */
	public static function addConfig( &$vars ) {
		$vars['wgWebFontsHelpPage'] = wfMsgForContent( 'webfonts-help-page' );
		return true;
	}

	/**
	 * UserGetDefaultOptions hook handler.
	 * @param $defaultOptions array
	 * @return bool
	 */
	public static function addDefaultOptions( &$defaultOptions ) {
		global $wgWebFontsEnabledByDefault;
		// By default, the preference page option to enable webfonts is set to wgWebFontsEnabledByDefault value.
		$defaultOptions['webfontsEnable'] = $wgWebFontsEnabledByDefault;
		return true;
	 }
}
