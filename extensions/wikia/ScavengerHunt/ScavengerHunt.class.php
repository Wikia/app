<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @copyright Copyright (C) 2010 jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class ScavengerHunt {

	const HASH_SALT = 'ScavengerHuntSalt';
	const CACHE_TTL = 604800;
//	const HUNTER_ID = 'ScavengerHunterId';
	const HUNT_ID = 'ScavengerHuntInProgress';
	const VISITED_ART_KEY = 'visitedArticleIdentifiers';

	protected $parser = null;
	protected $parserOptions = null;
	protected $fakeTitle = null;
	protected $app = null;

	protected $game = null;

	public function __construct(){
		 $this->app = F::build('App');
	}

	/*
	 * hook handler - initialize game
	 *
	 * @author Marooned
	 */
	public function onBeforePageDisplay( $out, $skin ) {
		global $wgExtensionsPath;

		wfProfileIn(__METHOD__);

		$out->addScript('<script src="' . $wgExtensionsPath . '/wikia/ScavengerHunt/js/scavenger-game.js"></script>');
		$out->addScript('<script src="' . $wgExtensionsPath . '/wikia/ScavengerHunt/js/sprite.js"></script>');
		$out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ScavengerHunt/css/scavenger-game.scss'));

		wfProfileOut(__METHOD__);
		return true;
	}

	public function setGame( $game ){
		$this->game = $game;
	}

	public function getActiveGame() {
		if ( empty( $this->game ) ) {
			$huntId = $this->getHuntId();
			if ( empty( $huntId ) ) {
				return 0;
			}
			$games = WF::build('ScavengerHuntGames');
			$this->game = $games->findEnabledById((int)$huntId);
		}
		return $this->game;
	}

	protected function generateHunterId() {
		return md5( session_id() + self::HASH_SALT );
	}

	public function getHuntId() {
		$huntKey = $this->getHuntIdKey();
		return isset( $_COOKIE[ $huntKey ] ) ? $_COOKIE[ $huntKey ] : 0;
	}

	public function getHuntIdKey(){
		$userName = ( F::app()->wg->user->isAnon() ) ? '' : str_replace( ' ', '_', F::app()->wg->user->getName() );
		return self::HUNT_ID . $userName;
	}

	public function markItemAsFound( $articleTitle ){
		$oTitle = F::build( 'Title', array( $articleTitle ), 'newFromText' );
		$huntId = $this->getHuntId();
		if ( $oTitle->exists() && !empty( $huntId ) ){
			$games = WF::build('ScavengerHuntGames');
			$game = $games->findEnabledById((int)$huntId);
			if ( empty($game) ){
				return false;
			} else {
				return $this->addItemToCache( $articleTitle, $this->app->wg->cityId );
			}
		}
		return false;
	}

	public function addItemToCache( $articleName, $wikiId ){

		$game = $this->getActiveGame();

		if ( empty( $game ) ){
			return array();
		}
		$aAllGameArticles = $game->getArticleIdentifier();
		$articleIdentifier = $game->makeIdentifier( $wikiId, $articleName );

		if ( in_array( $articleIdentifier, $aAllGameArticles ) ){
			$aFoundArticles = $this->getDataFromCache();
			$aFoundArticles = isset( $aFoundArticles[ self::VISITED_ART_KEY ] )
				? $aFoundArticles[ self::VISITED_ART_KEY ]
				: array();

			if ( !is_array( $aFoundArticles ) ){
				$aFoundArticles = array();
			}
			array_push( $aFoundArticles, $articleIdentifier );
			$aUniqueArray = array_unique( $aFoundArticles );
			$this->saveDataToCache( array_intersect( $aUniqueArray, $aAllGameArticles ) );
			return true;
		}
		return false;
	}

	public function getFoundIndexes() {

		$game = $this->getActiveGame();
		if ( empty( $game ) ){
			return array();
		}
		$aAllGameArticles = $game->getArticleIdentifier();
		$aFoundArticles = $this->getDataFromCache();

		$aFoundArticles = isset( $aFoundArticles[ self::VISITED_ART_KEY ] )
			? $aFoundArticles[ self::VISITED_ART_KEY ]
			: array();

		if ( !is_array( $aFoundArticles ) ){
			$aFoundArticles = array();
		}
		$aResuls = array();

		foreach( $aAllGameArticles as $key => $gameArticleIdentifier ){
			if ( in_array( $gameArticleIdentifier, $aFoundArticles ) ){
				array_push( $aResuls, $key );
			}
		}
		return $aResuls;
	}

	public function generateFullInfo(){
		$game = $this->getActiveGame();
		if ( empty( $game ) ) {
			$this->resetCache();
			return array( 'noGame' => true );
		}
		$aData = $game->getAll();
		$aJSData['gameId'] = $game->getId();
		$aJSData['spriteUrl'] = $game->getSpriteImg();
		$aJSData['hash'] = $game->getHash();
		$aJSData['clueFont'] = $game->getClueFont();
		$aJSData['clueSize'] = $game->getClueSize();
		$aJSData['clueColor'] = $game->getClueColor();
		$aJSData['progressBarBg'] = $this->formatSpriteForJS( $aData, 'progressBarBackgroundSprite' );
		$aJSData['progressBarClose'] = $this->formatSpriteForJS( $aData, 'progressBarExitSprite' );
		$aJSData['startingDialog'] = $this->formatSpriteForJS( $aData, 'startPopupSprite' );
		$aJSData['goodbyeDialog'] = $this->formatSpriteForJS( $aData, 'finishPopupSprite' );
		$aJSData['hintLabel'] = $this->formatSpriteForJS( $aData, 'progressBarHintLabel' );
		foreach( $game->getArticles() as $article ){
			$aArticle = array();
			$articleData = $article->getAll();
			$aArticle['huntItem'] = $this->formatSpriteForJS( $articleData, 'spriteNotFound' );
			$aArticle['notFound'] = $this->formatSpriteForJS( $articleData, 'spriteInProgressBarNotFound' );
			$aArticle['found'] = $this->formatSpriteForJS( $articleData, 'spriteInProgressBar' );
			$aArticle['active'] = $this->formatSpriteForJS( $articleData, 'spriteInProgressBarHover' );
			$aArticle['articleTitle'] = $article->getTitle();
			$aArticle['articleClue'] = $article->getClueText();
			$aArticle['articleName'] = $article->getArticleName();
			$aArticle['congrats'] = $article->getCongrats().' '.$this->app->wf->msg( 'scavengerhunt-game-more-to-go' );;
			$aJSData['articles'][] = $aArticle;
		}
		$aJSData['closeBox'] = array(
			'title' => wfMsg('scavengerhunt-common-modal-title'),
			'content' => wfMsg('scavengerhunt-quit-game-content'),
			'switching' => wfMsg('scavengerhunt-switch-game-content'),
			'buttonQuit' => wfMsg('scavengerhunt-quit-game-button-quit'),
			'buttonStay' => wfMsg('scavengerhunt-quit-game-button-stay')
		);
		$completed = $this->getFinalModalArray();
		if (!empty($completed)) {
			$aJSData['completed'] = $this->getFinalModalArray();
		}

		return $aJSData;
	}

	private function getFinalModalArray(){

		$aReturn = array();
		$game = $this->getActiveGame();

		if ( $this->isGameCompleated() ){
			$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
			$template->set_vars( array(
				'game' => $game
			));
			$aReturn['text'] = $template->render('modal-form');
			$aReturn['title'] = $game->getEntryFormTitle();
			$aReturn['image'] = $this->formatSpriteForJS( $game->getFinishPopupSprite() );
		}

		return $aReturn;
	}

	private function isGameCompleated(){
		return (
			count( $this->getActiveGame()->getArticles() ) <= count( $this->getFoundIndexes() )
		);
	}

	public function articleHuntIndex( $articleId = 0 ){
		if ( empty( $articleId ) ){
			return -1;
		}

		$game = $this->getActiveGame();
		if ( empty( $game ) ){
			return -1;
		}
		$oTitle = F::build( 'Title', array( $articleId ), 'newFromId' );
		if ( !$oTitle->exists() ){
			return -1;
		}
		foreach( $game->getArticles() as $index => $article ){

			if (
				( $this->app->wg->cityId == $article->getWikiId() ) &&
				( $oTitle->getPrefixedURL() == $article->getArticleName() )
			){
				return $index;
			}
		}
		return -1;
	}

	private function formatSpriteForJS( $data, $key = false ){
		if ( !empty( $key ) ){
			if ( isset( $data[$key] ) ){
				$source = $data[$key];
			} else {
				return array();
			}
		} else {
			$source = $data;
		}

		return array(
			'name' => $key,
			'pos' => array (
				'x' => $source['X'],
				'y' => $source['Y']
			),
			'spriteTL' => array (
				'x' => $source['X1'],
				'y' => $source['Y1']
			),
			'spriteBR' => array (
				'x' => $source['X2'],
				'y' => $source['Y2']
			)
		);
	}

	/*
	 * hook handler - add JS vars to starting page
	 *
	 * @author Marooned
	 */
	public function onMakeGlobalVariablesScript( &$vars ) {
		wfProfileIn(__METHOD__);

		$out = $this->app->wg->out;
		$games = F::build( 'ScavengerHuntGames' );
		$title = $this->app->wg->title;
		$cityId = $this->app->wg->cityId;
		$articleName = $title->getPartialURL();

		$localGames = $games->findAllEnabled();
		if( !empty( $localGames ) ){
			foreach( $localGames as $game ){

				$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
				$template->set_vars(array(
					'game' => $game
				));
				if ( $game->getLandingArticleName() == $articleName ){
					$vars['wgScavengerHuntStart'][] = (int)$game->getId();
					$vars['wgScavengerHuntStartMsg'][] = $game->getLandingButtonText();
					$vars['wgScavengerHuntStartPosition'][] = array( 'X' => $game->getLandingButtonX(), 'Y' => $game->getLandingButtonY() );
					$vars['wgScavengerHuntStartClueTitle'][] = $game->getStartingClueTitle();
					$vars['wgScavengerHuntSpriteImg'][] = $game->getSpriteImg();
					$vars['wgScavengerHuntSprite'][] = $this->formatSpriteForJS( array('sprite' => $game->getStartPopupSprite() ), 'sprite' );
					$vars['wgScavengerHuntStartClueHtml'][] = $template->render('modal-starting');
				}
			}
			$vars['wgCookieDomain'] = $this->app->wg->cookieDomain;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/*
	 * Cache function
	 */
	protected function getCacheKey() {
		$huntId = $this->getHuntId();
		if ( empty( $huntId ) ){
			return false;
		}
		$userId = F::app()->wg->user->getId();
		return wfSharedMemcKey( 'ScavengerHuntUserProgress', $userId );
	}

	public function getDataFromCache() {
		$wgMemc = $this->app->getGlobal('wgMemc');
		$memcData = $wgMemc->get( $this->getCacheKey() );
		$return = false;
		if ( !empty( $memcData ) && isset( $memcData['gameId'] ) ){
			if ( $this->getHuntId() != $memcData['gameId'] ){

				$return = $this->saveDataToCache();
			}
			$return = $memcData;
		}

		return $return;
	}

	public function saveDataToCache( $visitedArticlesId ) {
		$wgMemc = $this->app->getGlobal('wgMemc');
		$value = array(
				'gameId' => $this->getHuntId(),
				self::VISITED_ART_KEY => $visitedArticlesId,
			);
		$wgMemc->set(
			$this->getCacheKey(),
			$value,
			self::CACHE_TTL
		);

		return $value;
	}

	public function resetCache() {
		return $this->saveDataToCache( array() );
	}

	public function isVersionValid( $hash ){
		 $game = $this->getActiveGame();
		 if ( empty( $game ) || empty( $hash ) ){
			 return false;
		 }
		 if ( $game->getHash() != $hash ){
			 return false;
		 } else {
			return true;
		 }
	}

	public function pushEntry( $name, $email, $answer ){
		$games = WF::build( 'ScavengerHuntGames' );
		$game = $this->getActiveGame();
		if ( !empty( $game ) ) {
			if ( $this->isGameCompleated() ) {
				$reqUsername = $game->getEntryFormUsername();
				$reqEmail = $game->getEntryFormEmail();
				$reqQuestion = $game->getEntryFormQuestion();
				if (
					( !empty( $name ) || empty( $reqUsername ) ) &&
					( !empty( $email ) || empty( $reqEmail ) ) &&
					( !empty( $answer ) || empty( $reqQuestion ) )
				) {
					$user = $this->app->getGlobal( 'wgUser' );
					$entry = $games->getEntries()->newEntry();
					$entry->setUserId( $user->getId() );
					$entry->setName( $name );
					$entry->setEmail( $email );
					$entry->setAnswer( $answer );

					if ( $game->addEntry( $entry ) ) {
						$result = array(
							'status' => true,
							'goodbyeTitle' => $game->getGoodbyeTitle(),
							'goodbyeContent' => $this->getGoodbyeHtml($game)
						);
					} else {
						// entry could not be added
						$result = array(
							'status' => false,
							'error' => 'entry-save-error',
						);
					}
				} else {
					// validation failed
					$result = array(
						'status' => false,
						'error' => 'validation-failed',
					);
				}
			} else {
				// game was not completed
				$result = array(
					'status' => false,
					'error' => 'game-was-not-completed',
				);
			}
		} else {
			// game not found
			$result = array(
				'status' => false,
				'error' => 'game-not-found',
			);
		}
		return $result;
	}

	protected function getCache() {
		return WF::build('App')->getGlobal('wgMemc');
	}

	protected function getMemcKey( $arguments = null ) {
		$args = func_get_args();
		array_unshift($args, 'wfMemcKey');
		return call_user_func_array(array(WF::build('App'), 'runFunction'), $args);
	}

	public function parse( $text ) {
		if (empty($this->parser)) {
			$this->parser = WF::build('Parser');
			$this->parser->setOutputType(OT_HTML);
			$this->parserOptions = WF::build('ParserOptions');
			$this->fakeTitle = WF::build('FakeTitle', array(''));
		}

		return $this->parser->parse($text, $this->fakeTitle, $this->parserOptions, false)->getText();
	}

	public function parseCached( $text ) {
		$hash = md5(self::HASH_SALT . $text);
		$key = $this->getMemcKey(__CLASS__, 'parse-text-cache', $hash);
		$cache = $this->getCache();
		$parsed = $cache->get($key);
		if (!is_string($parsed)) {
			$parsed = $this->parse($text);
			$cache->set($key, $parsed, self::CACHE_TTL);
		}
		return $parsed;
	}
//
//	protected function getStyleForImageOffset( $offset ) {
//		return sprintf("left: %dpx; top: %dpx;",
//			intval(@$offset['left']), intval(@$offset['top']));
//	}
//
//	public function getStartingClueHtml( ScavengerHuntGame $game ) {
//		// build entry form html
//		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
//		$template->set_vars(array(
//			'text' => $this->parseCached( $game->getStartingClueText() ),
//			'buttonText' => $game->getStartingClueButtonText(),
//			'buttonTarget' => $game->getStartingClueButtonTarget(),
//			'imageSrc' => $game->getStartingClueImage(),
//			'imageOffset' => $game->getStartingClueImageOffset(),
//		));
//		return $template->render('modal-clue');
//	}
//
//	//TODO: candidate for FB#5854
//	public function getClueHtml( ScavengerHuntGameArticle $article ) {
//		return 'TODO: get clue message';
///*
//		// build entry form html
//		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
//		$template->set_vars(array(
//			'text' => $this->parseCached( $article->getClueText() ),
//			'buttonText' => $article->getClueButtonText(),
//			'buttonTarget' => $article->getClueButtonTarget(),
//			'imageSrc' => $article->getClueImage(),
//			'imageOffset' => $article->getClueImageOffset(),
//		));
//		return $template->render('modal-clue');
//*/
//	}
//
//	public function getEntryFormHtml( ScavengerHuntGame $game ) {
//		// build entry form html
//		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
//		$template->set_vars(array(
//			'title' => $game->getEntryFormTitle(),
//			'text' => $this->parseCached( $game->getEntryFormText() ),
//			'question' => $this->parseCached( $game->getEntryFormQuestion() ),
//			'imageSrc' => $game->getEntryFormImage(),
//			'imageOffset' => $game->getEntryFormImageOffset(),
//		));
//		return $template->render('modal-form');
//	}
//
	public function getGoodbyeHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'title' => $game->getGoodbyeTitle(),
			'text' => $this->parseCached( $game->getGoodbyeText() ),
			'shareUrl' => $game->getLandingTitle(),
			'imageSrc' => $game->getSpriteImg(),
			'imgSprite' => $game->getFinishPopupSprite()
		));
		return $template->render('modal-clue');
	}
//
//	public function updateVisitedIds( ScavengerHuntGame $game, &$visitedIds ) {
//		$articleIds = $game->getArticleIds();
//		$visitedIds = array_unique( array_map( 'intval', $visitedIds ) );
//		$visitedIds = array_intersect( $articleIds, $visitedIds );
//		sort($visitedIds);
//		return count($articleIds) == count($visitedIds);
//	}
//
//
//	protected function getTriggersFor( $title, $games = null ) {
//		if ( !$title || !$title->getArticleID() ) {
//			return false;
//		}
//		if ( empty($games) ) {
//			$games = WF::build('ScavengerHuntGames');
//		}
//		$triggers = $games->getTitleTriggers($title);
//		return $triggers ? $triggers : false;
//	}

//	public function generateInfo( $hash ){
//		if ( $this->isVersionValid( $hash ) ){
//			return $hash;
//		} else {
//			return generateFullInfo();
//		}
//	}

	public function onOpenGraphMetaBeforeCustomFields($articleId, &$titleImage, &$titleDescription) {
		global $wgCityId;
		$games = F::build( 'ScavengerHuntGames' );
		//TODO: add caching in findAllEnabled
		$localGames = $games->findAllEnabled();
		if (!empty($localGames)) {
			$game = $localGames[0];	//get 1st one
			if ($wgCityId == $game->getLandingArticleWikiId()) {
				$title = Title::newFromID($articleId);
				if ($title && $title->getFullURL() == $game->getLandingTitle()) {
					//TODO: add fields to Special:ScavengerHunt for image & description
					//TODO: add 2 methods to Game class
					//$titleImage = $game->getLandingImage();
					//$titleDescription = $game->getLandingDescription();
					$titleDescription = 'dupa';
				}
			}
		}
		return true;
	}
}