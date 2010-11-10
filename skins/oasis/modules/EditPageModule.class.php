<?php
/**
 * Modified edit page for Oasis
 *
 * @author Maciej Brencz
 */

class EditPageModule extends Module {

	/**
	 * Disables edit form when in read-only mode (RT #85688)
	 */
	public static function onAlternateEdit($editPage) {
		global $wgOut, $wgTitle;
		wfProfileIn(__METHOD__);

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
}