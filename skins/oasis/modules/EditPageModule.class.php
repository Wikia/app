<?php
/**
 * Modified edit page for Oasis
 *
 * @author Maciej Brencz
 */

class EditPageModule extends Module {

	/**
	 * Disables edit form when in read-only mode (RT #85688) and loads YUI on edit pages
	 */
	public static function onAlternateEdit($editPage) {
		global $wgOut, $wgTitle, $wgJsMimeType;
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

		// macbre: load YUI on edit page (it's always loaded using $.loadYUI)
		// PLB has problems with $.loadYUI not working correctly in Firefox (callback is fired to early)
		$StaticChute = new StaticChute('js');
		$StaticChute->useLocalChuteUrl();
		$yui = $StaticChute->getChuteUrlForPackage('yui');

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$yui}\"></script>");

		wfProfileOut(__METHOD__);
		return true;
	}
}