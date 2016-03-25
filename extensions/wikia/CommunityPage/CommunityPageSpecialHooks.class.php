<?php

class CommunityPageSpecialHooks {

	public static function onBeforePageDisplay( OutputPage &$out, &$skin ) {
		OasisController::addBodyClass( 'special-community-page' );
		return true;
	}

	/**
	 * Render the community page header outside of the .WikiaPage element
	 *
	 * @param $html
	 * @return bool
	 */
	public static function getHTMLBeforeWikiaPage( &$html ) {
		if ( F::app()->wg->Title->isSpecial( 'Community' ) ) {
			$html .= F::app()->renderView( 'CommunityPageSpecialController', 'header' );
		}
		return true;
	}
}