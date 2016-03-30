<?php

class CommunityPageSpecialHooks {

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