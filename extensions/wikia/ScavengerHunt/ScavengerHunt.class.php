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

	/* @var $parser Parser */
	protected $parser = null;
	protected $parserOptions = null;
	protected $fakeTitle = null;
	protected $app = null;

	protected $game = null;

	public function __construct(){
		 $this->app = F::app();
	}

	/*
	 * hook handler - initialize game
	 *
	 * @author Marooned
	 */
	static public function onBeforePageDisplay( OutputPage $out, $skin ) {
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

	/**
	 * @return ScavengerHuntGame
	 */
	public function getActiveGame() {
		if ( empty( $this->game ) ) {
			$huntId = $this->getHuntId();
			if ( empty( $huntId ) ) {
				return 0;
			}
			$games = new ScavengerHuntGames();
			$this->game = $games->findEnabledById((int)$huntId);
		}
		return $this->game;
	}

	protected function generateHunterId() {
		return md5( session_id() . self::HASH_SALT );
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
		$oTitle = Title::newFromText( $articleTitle );
		$huntId = $this->getHuntId();
		if ( $oTitle->exists() && !empty( $huntId ) ){
			$games = new ScavengerHuntGames();
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
		$articleIdentifier = self::makeIdentifier( $wikiId, $articleName );

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
		$aJSData['progressBarBg'] = self::formatSpriteForJS( $aData, 'progressBarBackgroundSprite' );
		$aJSData['progressBarClose'] = self::formatSpriteForJS( $aData, 'progressBarExitSprite' );
		$aJSData['startingDialog'] = self::formatSpriteForJS( $aData, 'startPopupSprite' );
		$aJSData['goodbyeDialog'] = self::formatSpriteForJS( $aData, 'finishPopupSprite' );
		$aJSData['hintLabel'] = self::formatSpriteForJS( $aData, 'progressBarHintLabel' );
		foreach( $game->getArticles() as $article ){
			$aArticle = array();
			$articleData = $article->getAll();
			$aArticle['huntItem'] = self::formatSpriteForJS( $articleData, 'spriteNotFound' );
			$aArticle['notFound'] = self::formatSpriteForJS( $articleData, 'spriteInProgressBarNotFound' );
			$aArticle['found'] = self::formatSpriteForJS( $articleData, 'spriteInProgressBar' );
			$aArticle['active'] = self::formatSpriteForJS( $articleData, 'spriteInProgressBarHover' );
			$aArticle['articleTitle'] = $article->getTitle();
			$aArticle['articleClue'] = $article->getClueText();
			$aArticle['articleName'] = $article->getArticleName();
			$aArticle['congrats'] = $article->getCongrats().' '.wfMsg( 'scavengerhunt-game-more-to-go' );;
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
			$template = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
			$template->set_vars( array(
				'game' => $game
			));
			$aReturn['text'] = $template->render('modal-form');
			$aReturn['title'] = $game->getEntryFormTitle();
			$aReturn['image'] = ScavengerHunt::formatSpriteForJS( $game->getFinishPopupSprite() );
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
		$oTitle = Title::newFromId( $articleId );
		if ( (!$oTitle instanceof Title) || !$oTitle->exists() ) {
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

	public static function formatSpriteForJS( $data, $key = false ){
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

	/**
	 * hook handler - add JS vars to starting page
	 *
	 * @author Marooned
	 */
	static public function onMakeGlobalVariablesScript( Array &$vars ) {
		wfProfileIn(__METHOD__);

		$games = new ScavengerHuntGames();

		$params = $games->getJSParamsForCurrent();
		if( !empty( $params ) ){
			foreach( $params as $key => $param ){
				$vars[$key] = $param;
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/*
	 * Cache function
	 */
	public function getCacheKey() {
		$huntId = $this->getHuntId();
		if ( empty( $huntId ) ){
			return false;
		}
		$userId = F::app()->wg->user->getId();
		return wfSharedMemcKey(
				'ScavengerHuntUserProgress',
				$userId,
				( $userId > 0  ) ? 0 : wfGetBeaconId()
			);
	}

	public function getDataFromCache() {
		$wgMemc = $this->getCache();
		$memcData = $wgMemc->get( $this->getCacheKey() );
		$return = false;
		if ( !empty( $memcData ) && isset( $memcData['gameId'] ) ){
			if ( $this->getHuntId() != $memcData['gameId'] ){
				$return = $this->saveDataToCache(array());
			}
			$return = $memcData;
		}
		return $return;
	}

	public function saveDataToCache( $visitedArticlesId ) {
		$wgMemc = $this->getCache();
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
		$games = (new ScavengerHuntGames);
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
					$entry = (new EmailsStorage)->newEntry(EmailsStorage::SCAVENGER_HUNT);
					$entry->setPageId($game->getId());
					$entry->setEmail($email);
					$entry->setFeedback($answer);

					if ($entry->store()) {
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

	/**
	 * @return MemCachedClientforWiki
	 */
	protected function getCache() {
		return F::app()->getGlobal('wgMemc');
	}

	protected function getMemcKey( $arguments = null ) {
		$args = func_get_args();
		array_unshift($args, 'wfMemcKey');
		return call_user_func_array(array(F::app(), 'runFunction'), $args);
	}

	public function parse( $text ) {
		if (empty($this->parser)) {
			$this->parser = new Parser();
			$this->parser->setOutputType(OT_HTML);
			$this->parserOptions = new ParserOptions();
			$this->fakeTitle = new Title('FakeTitle');
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

	public function getGoodbyeHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$template->set_vars(array(
			'title' => $game->getGoodbyeTitle(),
			'text' => $this->parseCached( $game->getGoodbyeText() ),
			'shareUrl' => $game->getLandingTitle(),
			'imageSrc' => $game->getSpriteImg(),
			'imgSprite' => $game->getFinishPopupSprite()
		));
		return $template->render('modal-clue');
	}

	public static function makeIdentifier( $cityId, $articleName ){
		return ( $cityId.'|'.urldecode( $articleName ) );
	}

	static public function onOpenGraphMetaBeforeCustomFields( $articleId, &$titleImage, &$titleDescription) {
		$games = (new ScavengerHuntGames); /* @var $games ScavengerHuntGames */
		$elements = $games->getOpenGraphMetaElements();
		if (
			!empty( $elements ) &&
			isset( $elements['facebookImg'] ) &&
			isset( $elements['facebookDescription'] )
		) {
			if ( !empty( $elements['facebookImg'] ) ) $titleImage = $elements['facebookImg'];
			if ( !empty( $elements['facebookDescription'] ) ) $titleDescription = $elements['facebookDescription'];
		}
		return true;
	}
}
