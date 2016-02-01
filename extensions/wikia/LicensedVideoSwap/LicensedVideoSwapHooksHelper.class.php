<?php

/**
 * Class LicensedVideoSwapHooksHelper
 */
class LicensedVideoSwapHooksHelper {

	/**
	 * Handler for the hook that allows HTML to be placed after the main <h1> page title.
	 * Use this to add the history page button
	 *
	 * @param array $extraButtons An array of strings to add extra buttons to
	 * @return bool true
	 */
	public static function onPageHeaderIndexExtraButtons( array &$extraButtons ) {
		$app = F::app();

		if (
			$app->wg->Title->isSpecial( 'LicensedVideoSwap' ) &&
			$app->wg->User->isAllowed( 'licensedvideoswap' ) 
		) {

			// Get the user preference skin, not the current skin of the page
			$skin = $app->wg->User->getGlobalPreference( 'skin' );

			// for monobook users, specify wikia skin in querystring
			$query = '';

			if ( $skin == 'monobook' ) {
				$query = 'useskin=wikia';
			}

			$href = SpecialPage::getTitleFor( 'LicensedVideoSwap/History' )
				->escapeLocalURL( $query );

			$extraButtons[] = Xml::element(
				'a',
				[
					'class' => 'button lvs-history-btn',
					'href' => $href,
					'rel' => 'tooltip',
					'title' => wfMessage( 'lvs-tooltip-history' )->escaped(),
				],
				wfMessage( 'lvs-history-button-text' )->escaped()
			);
		}

		return true;
	}

	/**
	 * Hook: skip confirmation message in banner notification
	 * when file page is deleted (set message to blank)
	 * @param Title $title
	 * @param string $message
	 * @return true
	 */
	public static function onOasisAddPageDeletedConfirmationMessage( &$title, &$message ) {
		$app = F::app();
		$controller = $app->wg->Request->getVal( 'controller', '' );
		$method = $app->wg->Request->getVal( 'method', '' );
		if ( $title instanceof Title && $title->getNamespace() == NS_FILE && $controller == 'LicensedVideoSwapSpecial' && $method == 'swapVideo' ) {
			$message = '';
		}

		return true;
	}

}
