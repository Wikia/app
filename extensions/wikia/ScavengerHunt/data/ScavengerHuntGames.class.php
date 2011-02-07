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

		public function findById( $id, $readWrite = false ) {
			$db = null;
			$options = array();
			if ($readWrite === true) {
				$db = $this->getDb(DB_MASTER);
				$options[] = 'FOR UPDATE';
			} else {
				$db = $this->getDb();
			}

			// read data
			$row = $db->selectRow(
				array( self::GAMES_TABLE_NAME ),
				array( 'game_id', 'wiki_id', 'game_name', 'game_is_enabled', 'game_data' ),
				array( 'game_id' => (int)$id ),
				__METHOD__,
				$options
			);

			if (empty($row)) {
				return false;
			}

			$game = $this->newGameFromRow($row);

			return $game;
		}

		public function findAllByWikiId( $wikiId ) {
			$set = $db->select(
				array( self::GAMES_TABLE_NAME ),
				array( 'game_id', 'wiki_id', 'game_name', 'game_is_enabled', 'game_data' ),
				array( 'wiki_id' => (int)$wikiId ),
				__METHOD__,
				$options
			);

			$games = array();
			while( $row = $res->fetchObject( $res ) ) {
				$games[] = $this->newGameFromRow($row);
			}

			return $games;
		}



		/**
		 * get db handler
		 * @return DatabaseBase
		 */
		protected function getDb( $type = DB_SLAVE ) {
			return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
		}

		protected function newGameFromRow( $row ) {
			$game = $this->newGame();

			$data = unserialize( $row->game_data );
			$game->setId( $row->game_id );
			$game->setWikiId( $row->wiki_id );
			$game->setName( $row->game_name );
			$game->setEnabled( $row->game_is_enabled );
			$game->setLandingTitleAndId( $data['landingTitle'], $data['landingArticleId'] );
			$game->setStartingClueText( $data['startingClueText'] );
			$game->setStartingClueImage( $data['startingClueImage'] );
			$game->setArticles( $data['articles'] );
			$game->setFinalFormText( $data['finalFormText'] );
			$game->setFinalFormQuestion( $data['finalFormQuestion'] );
			$game->setGoodbyeText( $data['goodbyeText'] );
			$game->setGoodbyeImage( $data['goodbyeImage'] );

			return $game;
		}

		public function save( ScavengerHuntGame $game ) {
			$fields = array(
				'wiki_id' => $game->getWikiId(),
				'game_name' => $game->getName(),
				'game_is_enabled' => $game->isEnabled(),
				'game_data' => serialize( array(
					'landingTitle' => $game->getLandingTitle(),
					'landingArticleId' => $game->getLandingArticleId(),
					'startingClueText' => $game->getStartingClueText(),
					'startingClueImage' => $game->getStartingClueImage(),
					'articles' => $game->getArticles(),
					'finalFormText' => $game->getFinalFormText(),
					'finalFormQuestion' => $game->getFinalFormQuestion(),
					'goodbyeText' => $game->getGoodbyeText(),
					'goodbyeImage' => $game->getGoodbyeImage(),
				) ),
			);

			$db = $this->getDb(DB_MASTER);
			if($game->getId()) {
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

			return true;
		}

	}
