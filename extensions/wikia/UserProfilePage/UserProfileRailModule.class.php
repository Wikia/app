<?php
class UserProfileRailModule extends Module {

	public function executeTopWikis() {
		global $wgTitle, $wgUser, $wgOut, $wgExtensionsPath, $wgStylePath, $wgStyleVersion;

		// add CSS for this module
		//$wgOut->addStyle(wfGetSassUrl("extensions/wikia/AchievementsII/css/oasis.scss"));
		// add JS for this module
		//$wgOut->addScript("<script src=\"{$wgStylePath}/oasis/js/Achievements.js?{$wgStyleVersion}\"></script>\n");
	}

	public function executeRecentActivity() {}

	public function executeTopPages() {}

	/**
	 * adds the hook for own JavaScript variables in the document
	 */
	/*public function __construct() {
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'UserProfileTopWikisModule::addAchievementsJSVariables';
	}*/


	/**
	 * adds JavaScript variables inside the page source, cl
	 *
	 * @param mixed $vars the main vars for the JavaScript printout
	 *
	 */
	/*static function addAchievementsJSVariables (&$vars) {
		$lang_view_all = wfMsg('achievements-viewall-oasis');
		$lang_view_less = wfMsg('achievements-viewless');
		$vars['wgAchievementsMoreButton'] = array($lang_view_all, $lang_view_less);
		return true;
	}*/
}