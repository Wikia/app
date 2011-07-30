<?php
/**
 * @author Sean Colombo
 *
 * Displays the HTML5 + Canvas mobile game which will be inside of a Titanium app. Currently,
 * we're not sure how stand-alone the canvas part will be and how much it will communicate with the
 * Titanium code.
 *
 * @file
 * @ingroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * The entry point for the HTML/Canvas page containing the game.
 *
 * @ingroup SpecialPage
 */
class FoggyFotoController extends WikiaController {

/**
	 * Manage forms to be shown according to posted data.
	 *
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function getMain() {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );
	
		wfLoadExtensionMessages( 'FoggyFoto' );

		$this->canvasWidth = $this->getVal('width', 480);
		$this->canvasHeight = $this->getVal('height', 320);

		$this->gameJs = $wgExtensionsPath."/wikia/FoggyFoto/js/FoggyFoto.js?$wgStyleVersion";

		wfProfileOut( __METHOD__ );
	} // end execute()

} // end class SpecialFoggyFoto
