<?php

class CommunityPageSpecialHooks {

	public static function onBeforePageDisplay( OutputPage &$out, &$skin ) {
		OasisController::addBodyClass( 'special-community-page' );
		return true;
	}

	public static function getHTMLBeforeWikiaPage( &$html ) {
		$html .= F::app()->renderView( 'CommunityPageSpecialController', 'header' );
		return true;
	}
}