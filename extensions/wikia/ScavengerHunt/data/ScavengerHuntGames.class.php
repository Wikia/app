<?php

	class ScavengerHuntGames {

		const GAMES_TABLE_NAME = "scavenger_hunt_games";

		protected $app = null;

		public function __construct( WikiaApp $app ) {
			$this->app = $app;
		}

		public function getEntries() {
			return WF::build('ScavengerHuntEntries');
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

		public function findById( $id, $readWrite = false, $where = array() ) {
			$db = null;
			$options = array();
			if ($readWrite === true) {
				$db = $this->getDb(DB_MASTER);
				$options[] = 'FOR UPDATE';
			} else {
				$db = $this->getDb();
			}

			$where = array_merge($where,array(
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

			if (empty($row)) {
				return false;
			}

			$game = $this->newGameFromRow($row);

			return $game;
		}

		public function findEnabledById( $id, $readWrite = false ) {
			return $this->findById($id, $readWrite, array(
				'game_is_enabled' => 1,
			));
		}

		public function findAllByWikiId( $wikiId, $where = array() ) {
			$where = array_merge($where,array(
				'wiki_id' => (int)$wikiId,
			));

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

		public function findAllEnabledByWikiId( $wikiId ) {
			return $this->findAllByWikiId($wikiId, array(
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
			$game->setId( $row->game_id );
			$game->setWikiId( $row->wiki_id );
			$game->setName( $row->game_name );
			$game->setEnabled( $row->game_is_enabled );
			$game->setData($data);

			return $game;
		}

		public function save( ScavengerHuntGame $game ) {
			$fields = array(
				'wiki_id' => $game->getWikiId(),
				'game_name' => $game->getName(),
				'game_is_enabled' => $game->isEnabled(),
				'game_data' => serialize( $game->getData() ),
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

			$this->clearCache($oldGame,$game);

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

			$this->clearCache($game,null);

			return true;
		}


		const CACHE_TTL = 3600;

		protected function getIndexMemcKey() {
			return $this->app->runFunction('wfMemcKey',__CLASS__,'index');
		}

		protected function getTitleDbKey() {
			$title = WF::build('Title',array($game->getLandingTitle()),'newFromText');
			return $title ? $title->getPrefixedDBkey() : false;
		}

		public function getIndexCache() {
			$data = $this->getCache()->get($this->getIndexMemcKey());
			if (!is_array($data)) {
				$cityId = $this->app->getGlobal('wgCityId');
				$games = $this->findAllEnabledByWikiId($cityId);
				$data = array();
				foreach ($games as $game) {
					$gameId = $game->getId();
					$title = $this->getTitleDbKey($game->getLandingTitle());
					if (!empty($title)) {
						$data[$title]['start'][] = $gameId;
					}
					$articles = $game->getArticles();
					foreach ($articles as $article) {
						$title = $this->getTitleDbKey($article->getTitle());
						if (!empty($title)) {
							$data[$title]['article'][] = $gameId;
						}
					}
				}
				$this->getCache()->set($this->getIndexMemcKey(),$data,self::CACHE_TTL);
			}
			return $data;
		}

		protected function clearCache( $oldGame, $newGame ) {
			$this->clearIndexCache();

			if ( (!$oldGame || !$oldGame->isEnabled()) && (!$newGame || !$newGame->isEnabled()) ) {
				// no squid purges required - game not enabled
				return;
			}

			$titles = array();
			if ($oldGame) {
				$title = WF::build('Title',array($oldGame->getLandingTitle()),'newFromText');
				if ($title) $titles[$title->getPrefixedDBkey()] = $title;
				foreach ($oldGame->getArticles() as $article) {
					$title = WF::build('Title',array($article->getTitle()),'newFromText');
					if ($title) $titles[$title->getPrefixedDBkey()] = $title;
				}
			}
			if ($newGame) {
				$title = WF::build('Title',array($newGame->getLandingTitle()),'newFromText');
				if ($title) $titles[$title->getPrefixedDBkey()] = $title;
				foreach ($newGame->getArticles() as $article) {
					$title = WF::build('Title',array($article->getTitle()),'newFromText');
					if ($title) $titles[$title->getPrefixedDBkey()] = $title;
				}
			}
			foreach ($titles as $title) {
				$title->invalidateCache();
				$title->purgeSquid();
			}
		}

		protected function clearIndexCache() {
			$this->getCache()->delete($this->getIndexMemcKey());
		}

		public function getTitleTriggers( Title $title ) {
			$data = $this->getIndexCache();
			return (array)@$data[$title->getPrefixedDBkey()];
		}



	}
