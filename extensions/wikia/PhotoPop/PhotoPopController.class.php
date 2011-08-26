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
class PhotoPopController extends WikiaController {

/**
	 * Manage forms to be shown according to posted data.
	 *
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function getCanvas() {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );
	
		wfLoadExtensionMessages( 'PhotoPop' );

		$this->canvasWidth = $this->getVal('width', 480);
		$this->canvasHeight = $this->getVal('height', 320);

		$this->gameJs = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPop.js?$wgStyleVersion";

		wfProfileOut( __METHOD__ );
	} // end getCanvas()

	/**
	 * Since the canvas approach was very slow on mobile devices, this method was
	 * created to return a quick experimental version which uses just HTML and CSS
	 * instead of canvas.
	 */
	 public function getDivs(){
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgScriptPath, $wgRequest;
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( 'PhotoPop' );

		$this->boardWidth = $this->getVal('width', 480);
		$this->boardHeight = $this->getVal('height', 320);
		$this->numRows = 4;
		$this->numCols = 6;
		$this->tileWidth = ($this->boardWidth / $this->numCols);
		$this->tileHeight = ($this->boardHeight / $this->numRows);
		$this->photosPerGame = 10;

		$this->frontImageSrc = $wgExtensionsPath.'/wikia/PhotoPop/glee_front.png'; // this shows up immediately
		$this->backImageSrc = ''; // this is the one that's obscured... will be figured out in JS using the API.
		$this->answerButtonSrc_toOpen = $wgExtensionsPath.'/wikia/PhotoPop/answer-button-to-open.png';
		$this->answerButtonSrc_toClose = $wgExtensionsPath.'/wikia/PhotoPop/answer-button-to-close.png';
		$this->answerButtonWidth = 48;
		$this->answerDrawerWidth = 150;
		$this->answerDrawerHeight = 250;
		$this->continueButtonSrc = $wgExtensionsPath.'/wikia/PhotoPop/continue-button.png';

		$this->wgScriptPath = $wgScriptPath;
		$this->mwJsApiUrl = $wgExtensionsPath."/wikia/JavascriptAPI/Mediawiki.js?$wgStyleVersion";
		$this->gameJs_FlipBoard = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPop_FlipBoard.js?$wgStyleVersion";
		$this->gameJs = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPopByDivs.js?$wgStyleVersion";
		$this->jsMessagesUrl = $wgExtensionsPath."/wikia/JSMessages/js/JSMessages.js?$wgStyleVersion";
		$this->category = $wgRequest->getVal('category', '');

		$vars = array();
		F::build('JSMessages')->enqueuePackage('PhotoPop', JSMessages::INLINE);
		F::build('JSMessages')->onMakeGlobalVariablesScript(&$vars);
 		$this->globalVariablesScript = Skin::makeVariablesScript( $vars );

		wfProfileOut( __METHOD__ );
	} // end getDivs()

} // end class SpecialPhotoPop
