<?php

/**
 * Class LicensedVideoSwapHooksHelper
 */
class LicensedVideoSwapHooksHelper {

	/**
	 * Handler for the hook that allows HTML to be placed after the main <h1> page title.  Use this to add the history
	 * page button
	 * @param $response
	 * @return bool
	 */
	public static function onPageHeaderIndexExtraButtons( $response ) {
		$app = F::app();
		if ( $app->wg->Title->getFullText() == 'Special:LicensedVideoSwap' ) {
			$title = SpecialPage::getTitleFor("LicensedVideoSwap/History")->escapeLocalURL( "useskin=wikia" );
			$extraButtons = $response->getVal('extraButtons');
			$extraButtons[] = '<a class="button lvs-history-btn" href="'.$title.'" rel="tooltip" title="'.wfMessage("lvs-tooltip-history")->plain().'">'.wfMessage("lvs-history-button-text")->plain().'</a>';
			$response->setVal('extraButtons', $extraButtons);
		}
		return true;
	}
}
