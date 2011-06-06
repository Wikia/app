<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'ApertureAudience',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'ApertureAudience::onMakeGlobalVariablesScript';

class ApertureAudience {
	/**
	 * Adds global JS variables. Switches for enabling Aperture audience targeting
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgCityId, $wgEnableAperture, $wgDevelEnvironment;
		wfProfileIn( __METHOD__ );

		$vars['aperturePageId'] = HubService::getAperturePageId($wgCityId);
		$vars['wgEnableAperture'] = $wgEnableAperture && empty($wgDevelEnvironment);

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()
}
