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
	var $DEFAULT_WIDTH = 480;
	var $DEFAULT_HEIGHT = 320;

	/**
	 * Like all WikiaController subclasses, this is called before any time that other endpoints are triggered.
	 */
	public function init(){
		global $wgExtensionsPath;
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages( 'PhotoPop' );
		$this->BG_IMAGE = "$wgExtensionsPath/wikia/PhotoPop/images/main_bg.png";
		$this->PHOTOPOP_LOGO = "$wgExtensionsPath/wikia/PhotoPop/images/photopop_logo.png";
		$this->POWERED_BY_LOGO = "$wgExtensionsPath/wikia/PhotoPop/images/brought_to_you_by.png";
		
		$this->isTutorial = false; // cleaner to set it here than have empty() checks all over.

		wfProfileOut(__METHOD__);
	} // end init()

	/**
	 * Endpoint for the first screen that the player will see.  Essentially serves as a menu.
	 */
	public function homeScreen(){
		global $wgExtensionsPath;
		wfProfileIn( __METHOD__ );
		
		$this->boardWidth = $this->getVal('width', $this->DEFAULT_WIDTH);
		$this->boardHeight = $this->getVal('height', $this->DEFAULT_HEIGHT);

		$this->cssLink = "<link rel=\"stylesheet\" href=\"{$wgExtensionsPath}/wikia/PhotoPop/css/homescreen.css\" />";

		$this->buttonSrc_scores = "$wgExtensionsPath/wikia/PhotoPop/images/button_scores.png";
		$this->buttonSrc_tutorial = "$wgExtensionsPath/wikia/PhotoPop/images/button_tutorial.png";
		$this->buttonSrc_volumeOn = "$wgExtensionsPath/wikia/PhotoPop/images/button_volume_on.png";
		$this->buttonSrc_volumeOff = "$wgExtensionsPath/wikia/PhotoPop/images/button_volume_off.png";
		$this->buttonSrc_play = "$wgExtensionsPath/wikia/PhotoPop/images/button_play.png";

		$this->playButtonUrl = $this->getSelectorScreenUrl();
		$this->tutorialButtonUrl = $this->getTutorialScreenUrl();

		wfProfileOut(__METHOD__);
	} // end homeScreen()

	/**
	 * Shows a screen which lets the player choose from a number of configured games.  Each game
	 * will be served from the wiki on which the game is played regardless of where this selector screen is shown.
	 */
	public function selectorScreen(){
		global $wgExtensionsPath;
		wfProfileIn(__METHOD__);

		$this->boardWidth = $this->getVal('width', $this->DEFAULT_WIDTH);
		$this->boardHeight = $this->getVal('height', $this->DEFAULT_HEIGHT);

		// Configuration for the different available games.
		$this->games = $this->getGameConfigs();
		$this->numItems = count($this->games);
		$this->iconWidth = 120;
		$this->iconHeight = 120;

		$this->buttonWidth = 38;
		$this->buttonHeight = 39;
		$this->buttonSrc = "$wgExtensionsPath/wikia/PhotoPop/images/down_arrow_button.png";
		$this->backHomeUrl = $this->getHomeScreenUrl();
		
		$this->textOffset = 7;
		$this->textHeight = 24;


		// TODO: PERFORMANCE TASKS
			// TODO: Make local copies of the remote files (less DNS lookups & lets us combine them).
			// TODO: Combine as many of these files as possible (but keep them below 25k)
			// TODO: Make a cache-manifest to cache the files (since some are already too big) then combine into just ONE js file.
		// TODO: PERFORMANCE TASKS
		$this->jQueryMobile = <<<JQUERY_INCLUDE
			<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
			<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
			<script>
				// Has to be done before including jQueryMobile
				$(document).bind("mobileinit", function(){
					$.extend(  $.mobile , { ajaxEnabled : false });
				});
			</script>
			<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>
			
			<link rel="stylesheet" href="{$wgExtensionsPath}/wikia/PhotoPop/css/jquery.mobile.scrollview.css" />
			<script src="{$wgExtensionsPath}/wikia/PhotoPop/js/jquery.easing.1.3.js"></script>
			<script src="{$wgExtensionsPath}/wikia/PhotoPop/js/jquery.mobile.scrollview.js"></script>
			<script src="{$wgExtensionsPath}/wikia/PhotoPop/js/scrollview.js"></script>
JQUERY_INCLUDE;

		wfProfileOut(__METHOD__);
	} // end selectorScreen()

	/**
	 * Shows the tutorial screen which will start off as just a static page showing a brief tutorial (won't be a single image though because
	 * of resizing-issues... we'll have to actually construct a board).
	 */
	public function tutorialScreen(){
		wfProfileIn(__METHOD__);
		
		$this->boardWidth = $this->getVal('width', $this->DEFAULT_WIDTH);
		$this->boardHeight = $this->getVal('height', $this->DEFAULT_HEIGHT);
		
		$this->isTutorial = true;

		wfProfileOut(__METHOD__);
	} // end tutorialScreen()

	/**
	 * Since the canvas approach was very slow on mobile devices, this method was
	 * created to return a quick experimental version which uses just HTML and CSS
	 * instead of canvas.
	 */
	 public function playGame(){
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgRequest, $wgScriptPath;
		wfProfileIn( __METHOD__ );

		// Sometimes we want to generate the game-screen without any functionality but with a tutorial overlay... allow that tutorial mode here.
		$this->isTutorial = $this->getVal('isTutorial', $this->isTutorial);

		$this->boardWidth = $this->getVal('width', $this->DEFAULT_WIDTH);
		$this->boardHeight = $this->getVal('height', $this->DEFAULT_HEIGHT);
		$this->numRows = 4;
		$this->numCols = 6;
		$this->tileWidth = ceil($this->boardWidth / $this->numCols); // the tiles at the very bottom and right of the board may be slightly too large. their extra pixels will just fall outside of the visible board and not be seen.
		$this->tileHeight = ceil($this->boardHeight / $this->numRows);

		$this->photosPerGame = 10;

		$this->frontImageSrc = $this->getWatermarkSrc();

		$this->backImageSrc = ''; // this is the one that's obscured... will be figured out in JS using the API.
		$this->answerButtonSrc_toOpen = $wgExtensionsPath.'/wikia/PhotoPop/images/answer-button-to-open.png';
		$this->answerButtonSrc_toClose = $wgExtensionsPath.'/wikia/PhotoPop/images/answer-button-to-close.png';
		$this->answerButtonWidth = 40;
		$this->continueButtonWidth = 48;
		$this->answerDrawerWidth = 150;
		$this->answerDrawerHeight = 250;
		$this->answerEdgeExtra = 12; // this is the amount to make it peek out slightly past the half-the-button mark
		$this->continueButtonSrc = $wgExtensionsPath.'/wikia/PhotoPop/images/continue-button.png';
		
		$this->homeButtonSrc = $wgExtensionsPath.'/wikia/PhotoPop/images/home.png';
		$this->homeButtonWidth = 27;
		$this->homeButtonHeight =25;

		// Settings for the end-game screen.
		$this->endGame_overlayWidth = 300;
		$this->endGame_overlayHeight = 150; // this is the height of just the green portion, not counting the high-score flag on top
		$this->endGame_highScoreHeight = 24;
		$this->endGameButtonSize = 54;
		$this->endGame_playAgainSrc = $wgExtensionsPath.'/wikia/PhotoPop/images/end_replay.png';
		$this->endGame_goHomeSrc = $wgExtensionsPath.'/wikia/PhotoPop/images/end_home.png';
		$this->endGame_goToHighScoresSrc = $wgExtensionsPath.'/wikia/PhotoPop/images/end_scores.png';
		$this->url_goHome = $this->getHomeScreenUrl();

		$this->mwJsApiUrl = $wgExtensionsPath."/wikia/JavascriptAPI/Mediawiki.js?$wgStyleVersion";
		$this->gameJs_FlipBoard = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPop_FlipBoard.js?$wgStyleVersion";
		$this->gameJs = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPop.js?$wgStyleVersion";
		$this->jsMessagesUrl = $wgExtensionsPath."/wikia/JSMessages/js/JSMessages.js?$wgStyleVersion";
		$this->category = $wgRequest->getVal('category', '');

		// For <title> tag.  Site name and name of category (without the prefix).
		$catTitle = Title::newFromText($this->category);
		if(is_object($catTitle)){
			$this->categoryReadable = $catTitle->getText();
		} else {
			$this->categoryReadable = $this->category;
		}

		$vars = array();
		F::build('JSMessages')->enqueuePackage('PhotoPop', JSMessages::INLINE);
		F::build('JSMessages')->onMakeGlobalVariablesScript(&$vars);
 		$this->globalVariablesScript = Skin::makeVariablesScript( $vars );

		wfProfileOut( __METHOD__ );
	} // end playGame()
	
	/**
	 * Endpoint for the Canvas demo-version of the game.
	 *
	 * @WARNING: This demo showed that the game was just way too slow on actual mobile
	 * devices, so it was rewritten in normal HTML 5 without canvas.  This version should
	 * not be used for anything except the tech-demo that it is.
	 */
	public function getCanvas() {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );

		$this->canvasWidth = $this->getVal('width', 480);
		$this->canvasHeight = $this->getVal('height', 320);

		$this->gameJs = $wgExtensionsPath."/wikia/PhotoPop/js/PhotoPop_canvasDemo.js?$wgStyleVersion";

		wfProfileOut( __METHOD__ );
	} // end getCanvas()
	
	/**
	 * Returns all of the possible game configs currently set up.  Slightly more efficient to create these objects in a separate function, only when needed
	 * than to do it in the init() function.
	 *
	 * Make sure to set the boardWidth and boardHeight prior to calling this method (otherwise they'll be using the defaults).
	 */
	private function getGameConfigs(){
		global $wgExtensionsPath;
		$iconDir = "$wgExtensionsPath/wikia/PhotoPop/gameicons";
		$watermarkDir = "$wgExtensionsPath/wikia/PhotoPop/watermarks";
		return array(
			new PhotoPopGameConfig("True Blood", "Category:Characters", "trueblood", "$iconDir/thumb_trueblood.png", "$watermarkDir/trueblood.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("Glee Wiki", "Category:Characters", "glee", "$iconDir/thumb_glee.png", "$watermarkDir/glee.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("LyricWiki", "Category:Albums_released_in_2011", "lyrics", "$iconDir/thumb_lyrics.png", "$watermarkDir/lyrics.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("Muppet Wiki", "Category:The_Muppets_Characters", "muppet", "$iconDir/thumb_muppet.png", "$watermarkDir/muppet.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("Dexter Wiki", "Category:Characters", "dexter", "$iconDir/thumb_dexter.png", "$watermarkDir/dexter.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("Futurama", "Category:Characters", "futurama", "$iconDir/thumb_futurama.png", "$watermarkDir/futurama.png", $this->boardWidth, $this->boardHeight),
			new PhotoPopGameConfig("Twilight Saga", "Category:Twilight_characters", "twilightsaga", "$iconDir/thumb_twilight.png", "$watermarkDir/twilight.png", $this->boardWidth, $this->boardHeight)
		);
	} // end getGameConfigs()
	
	/**
	 * Returns a link to the specified screen (will probably not be on the same wiki where the game is being played since
	 * we try to run that separately (makes it easier to track stats)).
	 *
	 * NOTE: Make sure boardWidth and boardHeight are set before calling these functions.
	 */
	private function getHomeScreenUrl(){ return $this->getLinkToMethod( 'homeScreen' ); }
	private function getSelectorScreenUrl(){ return $this->getLinkToMethod( 'selectorScreen' ); }
	private function getTutorialScreenUrl(){ return $this->getLinkToMethod( 'tutorialScreen' ); }

	/**
	 * Returns an absolute URL to the specified method name on this controller.  This uses Community wiki since the non-wiki-specific screens will
	 * all be served from there.
	 *
	 * WARNING: This is not made for linking to playGame since that should be served up from the domain of the wiki whose content
	 * you want to play the game with.
	 */
	private function getLinkToMethod($methodName){
		$sld = $this->getSecondLevelDomain();
		return "http://community.$sld/wikia.php?controller=PhotoPop&method={$methodName}&width={$this->boardWidth}&height={$this->boardHeight}";
	}
	
	/**
	 * Small helper to return the second-level domain along with the top-level domain.  This helps us build links
	 * from devboxes to devboxes and from production wikis to other production wikis.
	 */
	private function getSecondLevelDomain(){
		global $wgDevelEnvironment;
		if(empty($wgDevelEnvironment)){
			$sld = "wikia.com"; // second-level domain
		} else {
			$sld = "sean.wikia-dev.com";
		}
		return $sld;
	} // end getSecondLevelDomain()

	/**
	 * Returns the watermark url of the current wiki (if there is one in the config... otherwise returns a blank image).
	 */
	private function getWatermarkSrc(){
		global $wgBlankImgUrl, $wgServer;
		wfProfileIn( __METHOD__ );
		
		$watermarkSrc = $wgBlankImgUrl;
		$games = $this->getGameConfigs();
		foreach($games as $game){
			if( startsWith($game->gameUrl, $wgServer) ){
				$watermarkSrc = $game->watermarkSrc;
			}
		}

		return $watermarkSrc;
		wfProfileOut( __METHOD__ );
	} // end getWatermarkSrc()

} // end class SpecialPhotoPop
