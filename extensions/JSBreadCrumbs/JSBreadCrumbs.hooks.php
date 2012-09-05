<?php
class JSBreadCrumbsHooks {
	/**
	 * BeforePageDisplay hook
	 */
	public static function addResources( $out ) {
		global $wgExtensionAssetsPath;

		if ( self::enableBreadCrumbs() ) {
			$out->addScriptFile( "$wgExtensionAssetsPath/JSBreadCrumbs/js/BreadCrumbs.js", 7 );
			$out->addExtensionStyle( "$wgExtensionAssetsPath/JSBreadCrumbs/css/BreadCrumbs.css?1" );
		}

		return true;
	}

	/**
	 * MakeGlobalVariablesScript hook
	 */
	public static function addJSVars( &$vars ) {
		global $wgJSBreadCrumbsSeparator, $wgJSBreadCrumbsCookiePath;
		global $wgUser;

		if ( !self::enableBreadCrumbs() ) {
			return true;
		}



		// Allow localized separator to be overriden
		if ( $wgJSBreadCrumbsSeparator !== '' ) {
			$separator = $wgJSBreadCrumbsSeparator;
		} else {
			$separator = wfMsg( "jsbreadcrumbs-separator" );
		}

		$variables = array();

		$variables['wgJSBreadCrumbsMaxCrumbs'] = $wgUser->getOption( "jsbreadcrumbs-numberofcrumbs" );
		$variables['wgJSBreadCrumbsSeparator'] = $separator;
		$variables['wgJSBreadCrumbsCookiePath'] = $wgJSBreadCrumbsCookiePath;
		$variables['wgJSBreadCrumbsLeadingDescription'] = wfMsg( "jsbreadcrumbs-leading-description" );
		$variables['wgJSBreadCrumbsShowSiteName'] = $wgUser->getOption( "jsbreadcrumbs-showsite" );

		$vars = array_merge( $vars, $variables );

		return true;
	}

	/**
	 * GetPreferences hook
	 *
	 * Add module-releated items to the preferences
	 */
	public static function addPreferences( $user, $defaultPreferences ) {
		$defaultPreferences['jsbreadcrumbs-showcrumbs'] = array(
			'type' => 'toggle',
			'label-message' => 'prefs-jsbreadcrumbs-showcrumbs',
			'section' => 'rendering/jsbreadcrumbs',
		);

		$defaultPreferences['jsbreadcrumbs-showsite'] = array(
			'type' => 'toggle',
			'label-message' => 'prefs-jsbreadcrumbs-showsite',
			'section' => 'rendering/jsbreadcrumbs',
		);

		$defaultPreferences['jsbreadcrumbs-numberofcrumbs'] = array(
			'type' => 'int',
			'min' => 1,
			'max' => 20,
			'section' => 'rendering/jsbreadcrumbs',
			'help' => wfMsgHtml( 'prefs-jsbreadcrumbs-numberofcrumbs-max' ),
			'label-message' => 'prefs-jsbreadcrumbs-numberofcrumbs',
		);

		return true;
	}

	static function enableBreadCrumbs() {
		global $wgUser;

		// Ensure we only enable bread crumbs if we are using vector and
		// the user has them enabled
		if ( $wgUser->getSkin() instanceof SkinVector && $wgUser->getOption( "jsbreadcrumbs-showcrumbs" ) ) {
			return true;
		}
	}
}
