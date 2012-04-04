<?php
/**
 * Modified edit page for Oasis
 *
 * @author Maciej Brencz
 */

class EditPageModule extends Module {

	private static $editFormType = '';

	/**
	 * Disables edit form when in read-only mode (RT #85688)
	 */
	public static function onAlternateEdit($editPage) {
		global $wgOut, $wgTitle;
		wfProfileIn(__METHOD__);

		// disable edit form when in read-only mode
		if (wfReadOnly()) {
			$wgOut->setPageTitle(wfMsg('editing', $wgTitle->getPrefixedText()));
			$wgOut->addHtml(
				'<div id="mw-read-only-warning">'.
				wfMsg('oasis-editpage-readonlywarning', wfReadOnlyReason()).
				'</div>');

			wfDebug(__METHOD__ . ": edit form disabled because read-only mode is on\n");
			wfProfileOut(__METHOD__);
			return false;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Loads YUI on edit pages
	 */
	public static function onShowEditFormInitial($editPage) {
		global $wgOut, $wgHooks;
		wfProfileIn(__METHOD__);

		// BugId:2435 - add wgIsEditPage global JS variable on edit pages to simplify checks
		$wgHooks['MakeGlobalVariablesScript'][] = 'EditPageModule::onMakeGlobalVariablesScript';

		// BugId:2700 - detect edit form type
		self::$editFormType = $editPage->formtype;

		// macbre: load YUI on edit page (it's always loaded using $.loadYUI)
		// PLB has problems with $.loadYUI not working correctly in Firefox (callback is fired to early)
		$yuiUrl = array_pop(AssetsManager::getInstance()->getGroupCommonURL('yui', array(), true /* $combine */, true /* $minify */));
		$wgOut->addScript($yuiUrl);

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add wgIsEditPage global JS variable on edit pages
	 */
	public static function onMakeGlobalVariablesScript($vars) {
		$vars['wgIsEditPage'] = true;
		$vars['wgEditFormType'] = self::$editFormType;
		return true;
	}
}