<?php
class ScavengerHuntGames {

	const GAMES_TABLE_NAME = "scavenger_hunt_games";
	const CACHE_VERSION = 1;

	protected $app = null;
	protected $gamesFound = array();

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function getCurrentWikiId() {
		return $this->app->getGlobal('wgCityId');
	}

	public function newGameArticle() {
		return WF::build('ScavengerHuntGameArticle');
	}

	/**
	 * @return ScavengerHuntGame
	 */
	public function newGame() {
		$game = WF::build('ScavengerHuntGame');
		$game->setGames($this);
		return $game;
	}

	public function findById( $id, $readWrite = false, $where = array(), $raw = false ) {
		$db = null;
		$options = array();
		if ($readWrite === true) {
			$db = $this->getDb(DB_MASTER);
			$options[] = 'FOR UPDATE';
		} else {
			$db = $this->getDb();
		}

		$where = array_merge($where, array(
			'game_id' => (int)$id,
		));

		// read data
		$row = $db->selectRow(
			array( self::GAMES_TABLE_NAME ),
			array( 'game_id', 'wiki_id', 'game_name', 'game_is_enabled', 'game_data' ),
			$where,
			__METHOD__,
			$options
		);

		if ( empty( $row ) ) {
			return false;
		}

		if ( $raw ) return $row;

		$game = $this->newGameFromRow($row);

		return $game;
	}

	public function findEnabledById( $id, $readWrite = false ) {
		$key = wfSharedMemcKey( 'ScavengerHuntGameIndex', $id, ( $readWrite ? 1 : 0 ), self::CACHE_VERSION );
		$row = $this->getCache()->get( $key );
		if ( empty( $row ) ){
			$row = $this->findById(
				$id,
				$readWrite,
				array_merge( array( 'game_is_enabled' => 1 ) ),
				true
			);
			self::log( 'performance', __METHOD__ );
			$this->getCache()->set( $key, $row, self::CACHE_TTL );
		} else {
			self::log( 'performance(cached)', __METHOD__ );
		}

		return $this->newGameFromRow( $row );
	}

	public function findAll( $where = array() ) {
		self::log( 'performance', __METHOD__ );
		$db = $this->getDb();
		$set = $db->select(
			array( self::GAMES_TABLE_NAME ),
			array( 'game_id', 'wiki_id', 'game_name', 'game_is_enabled', 'game_data' ),
			$where,
			__METHOD__
		);

		$games = array();
		while( $row = $set->fetchObject( $set ) ) {
			$games[] = $this->newGameFromRow($row);
		}

		return $games;
	}

	protected function findAllEnabled( ) {
		self::log('performance', __METHOD__);
		return $this->findAll( array(
			'game_is_enabled' => 1,
		));
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	public function getDb( $type = DB_SLAVE ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
	}

	public function getCache() {
		return $this->app->getGlobal('wgMemc');
	}

	public function newGameFromRow( $row ) {
		$game = $this->newGame();

		$data = unserialize( $row->game_data );
		foreach($data['articles'] as $k => $v) {
			if (! ($v instanceof ScavengerHuntGameArticle)) {
				$article = $this->newGameArticle();
				$article->setAll($v);
				$data['articles'][$k] = $article;
			}
		}

		$game->setId( $row->game_id );
		$game->setWikiId( $row->wiki_id );
		$game->setName( $row->game_name );
		$game->setEnabled( $row->game_is_enabled );

		if (is_array($data)) {
			$game->setData($data);
		}

		return $game;
	}

	public function save( ScavengerHuntGame $game ) {
		$data = $game->getData();
		foreach ($data['articles'] as $k => $v)
			$data['articles'][$k] = $v->getAll();

		$fields = array(
			'wiki_id' => $game->getWikiId(),
			'game_name' => $game->getName(),
			'game_is_enabled' => $game->isEnabled(),
			'game_data' => serialize( $data ),
		);

		$oldGame = null;
		$db = $this->getDb(DB_MASTER);
		if($game->getId()) {
			$oldGame = $this->findById($game->getId());
			$db->update(
				self::GAMES_TABLE_NAME,
				$fields,
				array( "game_id" => $game->getId() ),
				__METHOD__
			);
		}
		else {
			$db->insert(
				self::GAMES_TABLE_NAME,
				$fields,
				__METHOD__
			);
			$game->setId( $db->insertId() );
		}
		$db->commit();

		$this->clearCache($oldGame, $game);
		return true;
	}

	public function delete( ScavengerHuntGame $game ) {
		if (!$game->getId()) {
			return false;
		}

		$db = $this->getDb(DB_MASTER);
		$db->delete(self::GAMES_TABLE_NAME, array(
			'game_id' => $game->getId(),
		));
		$db->commit();
		$game->setId(0);

		$this->clearCache($game, null);

		return true;
	}

	const CACHE_TTL = 3600;

	protected function getIndexMemcKey() {
		return wfSharedMemcKey( 'ScavengerHuntIndexer2' );
	}

	protected function getTitleDbKey( $text ) {
		$title = WF::build('Title', array($text), 'newFromText');
		return $title ? $title->getPrefixedDBkey() : false;
	}


	public function isPagePartOfAnyHunt( $cityId, $articleName ) {
		$identifier = ScavengerHunt::makeIdentifier( $cityId, $articleName );
		$indexCache = $this->getIndexCache();
		$found = false;

		if ( is_array( $indexCache ) ){
			foreach( $indexCache as $index ){
				if ( $index['landingPage'] == $identifier ) {
					return true;
				}
			}
		} else {
			return false;
		}
	}

	protected function makeIdentifier( $cityId, $articleName ){
		return ScavengerHunt::makeIdentifier( $cityId, $articleName );
	}

	public function getJSParamsForCurrent(){
		$cityId = $this->app->wg->cityId;
		$articleName = $this->app->wg->title->getPartialURL();
		if ( !$this->isPagePartOfAnyHunt( $cityId, $articleName ) ){
			return false;
		}
		$key = wfSharedMemcKey( 'ScavengerHuntIndexer', $cityId, md5( $articleName ) );
		$value = $this->getCache()->get( $key );
		if ( empty( $value )){
			self::log('performance', __METHOD__);
			$enabledGames = $this->getEnabledGames();
			$value = array();
			foreach( $enabledGames as $game ){
				$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/../templates/'));
				$template->set_vars(array(
					'game' => $game
				));
				if ( $game->getLandingArticleName() == $articleName ){
					$value['wgScavengerHuntStart'][] = (int)$game->getId();
					$value['wgScavengerHuntStartMsg'][] = $game->getLandingButtonText();
					$value['wgScavengerHuntStartPosition'][] = array( 'X' => $game->getLandingButtonX(), 'Y' => $game->getLandingButtonY() );
					$value['wgScavengerHuntStartClueTitle'][] = $game->getStartingClueTitle();
					$value['wgScavengerHuntSpriteImg'][] = $game->getSpriteImg();
					$value['wgScavengerHuntSprite'][] = ScavengerHunt::formatSpriteForJS( array('sprite' => $game->getStartPopupSprite() ), 'sprite' );
					$value['wgScavengerHuntStartClueHtml'][] = $template->render('modal-starting');
				}
			}
			$value['wgCookieDomain'] = $this->app->wg->cookieDomain;
			$this->getCache()->set( $key, $value, self::CACHE_TTL );
		} else {
			self::log('performance(cache)', __METHOD__);
		}
		return $value;
	}

	protected function clearCache( $oldGame, $newGame ) {
		$this->clearIndexCache();

		if ( (!$oldGame || !$oldGame->isEnabled()) && (!$newGame || !$newGame->isEnabled()) ) {
			// no squid purges required - game not enabled
			return;
		}
		$titles = array();

		foreach( array( $oldGame, $newGame ) as $game ){
			if ( !empty( $game ) ) {
				$this	->getCache()
					->delete( wfSharedMemcKey(
						'ScavengerHuntIndexer',
						$game->getLandingArticleWikiId(),
						md5( $game->getLandingArticleName() )
					));
				$this	->getCache()
					->delete( wfSharedMemcKey(
						'ScavengerHuntGameIndex',
						$game->getId(),
						0,
						self::CACHE_VERSION
					));
				$this	->getCache()
					->delete( wfSharedMemcKey(
						'ScavengerHuntGameIndex',
						$game->getId(),
						1,
						self::CACHE_VERSION
					));
				$this->purgeURL( $url );
				foreach( $oldGame->getArticleURLs() as $url ){
					$this->purgeURL( $oldGame->getLandingTitle() );
				}
			}
		};
	}

	protected function purgeURL( $url ){
		if ( empty( $url ) ){
			return false;
		}
		$url = $title;
		if ( strpos( $title, '?' ) === false ){
			$url.= '?action=purge';
		} else {
			$url.= '&action=purge';
		}
		Http::post( $url );
		return true;
	}

	protected function clearIndexCache() {
		$this->getCache()->delete($this->getIndexMemcKey());
	}

	public function getEnabledGames() {
		if ( empty( $this->gamesFound ) ) $this->gamesFound = $this->findAllEnabled();
		return $this->gamesFound;
	}

	public function getIndexCache() {
		$data = $this->getCache()->get( $this->getIndexMemcKey() );
		if (!is_array($data)) {
			self::log('performance', __METHOD__ );
			$enabledGames = $this->getEnabledGames();
			$data = array();
			foreach ( $enabledGames as $game ) {
				$data[ $game->getId() ] = array(
					'articles'		=> $game->getArticleIdentifier(),
					'landingPage'		=> $game->getLandingPageIdentifier(),
					'facebookImg'		=> $game->getFacebookImg(),
					'facebookDescription'	=> $game->getFacebookDescription()
				);
			}
			$this->getCache()->set($this->getIndexMemcKey(), $data, self::CACHE_TTL);

		} else {
			self::log('performance(cache)', __METHOD__ );
		}
		return $data;
	}

	public function getOpenGraphMetaElements(){
		$identifier = $this->makeIdentifier(
			$this->app->wg->cityId,
			$this->app->wg->title->getPartialURL()
		);
		$enabledGames = $this->getIndexCache();
		foreach( $enabledGames as $gameShortenedData ){
			if ( $gameShortenedData['landingPage'] == $identifier ) {
				return $gameShortenedData;
			}
		}
		return false;
	}

	static public function log( $text, $method ){
		if ( F::app()->getGlobal('wgDevelEnvironment') ){
			Wikia::log( 'ScavengerHunt', $method, $text );
		}
	}
}
