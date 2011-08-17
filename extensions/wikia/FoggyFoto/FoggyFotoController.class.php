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
	public function getCanvas() {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );
	
		wfLoadExtensionMessages( 'FoggyFoto' );

		$this->canvasWidth = $this->getVal('width', 480);
		$this->canvasHeight = $this->getVal('height', 320);

		$this->gameJs = $wgExtensionsPath."/wikia/FoggyFoto/js/FoggyFoto.js?$wgStyleVersion";

		wfProfileOut( __METHOD__ );
	} // end getCanvas()

	/**
	 * Since the canvas approach was very slow on mobile devices, this method was
	 * created to return a quick experimental version which uses just HTML and CSS
	 * instead of canvas.
	 */
	 public function getDivs(){
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgScriptPath;
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( 'FoggyFoto' );

		$this->boardWidth = $this->getVal('width', 480);
		$this->boardHeight = $this->getVal('height', 320);
		$this->numRows = 4;
		$this->numCols = 6;
		$this->tileWidth = ($this->boardWidth / $this->numCols);
		$this->tileHeight = ($this->boardHeight / $this->numRows);

		$this->frontImageSrc = 'http://sean.wikia-dev.com/extensions/wikia/FoggyFoto/front.png'; // this shows up immediately
		$this->backImageSrc = ''; // this is the one that's obscured
		$this->photosPerGame = 10;

		$this->gameJs = $wgExtensionsPath."/wikia/FoggyFoto/js/FoggyFotoByDivs.js?$wgStyleVersion";
		$this->mwJsApiUrl = $wgExtensionsPath."/wikia/JavascriptAPI/Mediawiki.js?$wgStyleVersion";
		$this->wgScriptPath = $wgScriptPath;

		wfProfileOut( __METHOD__ );
	} // end getDivs()

} // end class SpecialFoggyFoto
