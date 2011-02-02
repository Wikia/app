<?php

	class ScavengerHuntGame {

		protected $app = null;
		protected $readWrite = false;

		protected $id = 0;
		protected $wikiId = null;
		protected $isEnabled = false;
		protected $landingTitle = '';
		protected $landingArticleId = 0;
		protected $startingClueText = '';
		protected $articles = array();
		protected $finalFormText = '';
		protected $finalFormQuestion = '';
		protected $goodbyeText = '';

		public function __construct( WikiaApp $app, $id = 0, $readWrite = false ) {
			$this->app = $app;
			$this->id = $id;
		}

		public function getWikiId() {
			return $this->wikiId;
		}

		public function setWikiId( $wikiId ) {
			$this->wikiId = $wikiId;
		}

		public function isEnabled() {
			return $this->isEnabled;
		}

		public function setEnabled( $isEnabled ) {
			$this->isEnabled = $isEnabled;
		}

		public function getLandingTitle() {
			return $this->landingTitle;
		}

		public function setLandingTitle( $title ) {
			$this->landingTitle = $title;
			$titleObj = WF::build('Title',array($this->title),'newFromText');
			$this->landingArticleId = $titleObj ? $titleObj->getArticleId() : 0;
		}

		public function getLandingArticleId() {
			return $this->landingArticleId;
		}

		public function getStartingClueText() {
			return $this->startingClueText;
		}

		public function setStartingClueText( $startingClueText ) {
			$this->startingClueText = $startingClueText;
		}

		public function getArticles() {
			return $this->articles;
		}

		public function setArticles( $articles ) {
			$this->articles = $articles;
		}

		public function getFinalFormText() {
			return $this->finalFormText;
		}

		public function setFinalFormText( $finalFormText ) {
			$this->finalFormText = $finalFormText;
		}

		public function getFinalFormQuestion() {
			return $this->finalFormQuestion;
		}

		public function setFinalFormQuestion( $finalFormQuestion ) {
			$this->finalFormQuestion = $finalFormQuestion;
		}

		public function getGoodbyeText() {
			return $this->goodbyeText;
		}

		public function setGoodbyeText( $goodbyeText ) {
			$this->goodbyeText = $goodbyeText;
		}



		/**
		 * get db handler
		 * @return DatabaseBase
		 */
		protected function getDb( $type = DB_SLAVE ) {
			return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
		}

		protected function loadFromDbData( $game ) {
			$data = unserialize( $game->game_data );
			$this->isEnabled = $game->game_is_enabled;
			$this->landingTitle = $data['landingTitle'];
			$this->landingArticleId = $data['landingArticleId'];
			$this->startingClueText = $data['startingClueText'];
			$this->articles = $data['articles'];
			$this->finalFormText = $data['finalFormText'];
			$this->finalFormQuestion = $data['finalFormQuestion'];
			$this->goodbyeText = $data['goodbyeText'];
		}

		protected function loadFromDb( $game = null ) {
			if (is_null($data)) {
				$db = null;
				$options = array();
				if ($readWrite === true) {
					$db = $this->getDb(DB_MASTER);
					$options[] = 'FOR UPDATE';
				} else {
					$db = $this->getDb();
				}

				// read data
				$game = $db->selectRow(
					array( 'sh_games' ),
					array( 'game_id', 'wiki_id', 'game_is_enabled', 'game_data' ),
					array( "game_id" => $this->id ),
					__METHOD__,
					$options
				);
			}

			if(!empty($game)) {
				$this->loadFromDbData($game);
			}
		}

		protected function saveToDb() {
			if (!$this->readWrite) {
				return false;
			}

			$data = array(
				'landingTitle' => $this->landingTitle,
				'landingArticleId' => $this->landingArticleId,
				'startingClueText' => $this->startingClueText,
				'articles' => $this->articles,
				'finalFormText' => $this->finalFormText,
				'finalFormQuestion' => $this->finalFormQuestion,
				'goodbyeText' => $this->goodbyeText,
			);

			if (!isset($this->wikiId)) {
				$this->wikiId = $this->app->getGlobal('wgCityId');
			}

			// save data
			$fields = array(
				'wiki_id' => $this->wikiId,
				'game_is_enabled' => $this->isEnabled,
				'game_data' => $data,
			);

			$db = $this->getDb(DB_MASTER);
			if($this->getId()) {
				$db->update(
					'sh_games',
					$fields,
					array( "game_id" => $this->getId() ),
					__METHOD__
				);
			}
			else {
				$db->insert(
					'sh_games',
					$fields,
					__METHOD__
				);
				$this->id = $db->insertId();
			}
			$db->commit();
			return true;
		}

		static public function newFromRow( WikiaApp $app, $row ) {
			$id = $row->game_id;
			$game = WF::build('ScavengerHuntGame',array('app'=>$app,'id'=>$id));
			$game->loadFromDb($row);
			return $game;
		}


		/*** ENTRIES MANAGEMENT ***/
		public function addEntry( ScavengerHuntEntry $entry ) {
			if (empty($this->id)) {
				throw new WikiaException("Cannot add entry to non persistent game");
			}

			$fields = array(
				'game_id' => $this->getId(),
				'user_id' => $entry->getUserId(),
				'name' => $entry->getName(),
				'email' => $entry->getEmail(),
				'answer' => $entry->getAnswer(),
			);

			$this->getDb(DB_MASTER)->insert(
				'sh_entries',
				$fields,
				__METHOD__
			);
			$entryId = $db->insertId();
			$db->commit();

			return $entryId;
		}

		public function listEntries() {
			if (empty($this->id)) {
				return array();
			}

			$whereClause = array(
				'game_id' => $this->getId(),
			);
			$res = $this->getDb()->select(
				array( 'sh_entries' ),
				array( 'user_id', 'name', 'email', 'answer' ),
				$whereClause,
				__METHOD__
			);

			$entries = array();
			while( $row = $res->fetchObject( $res ) ) {
				$entries[] = WF::build( 'ScavengerHuntEntry', array( $row ), 'newFromRow' );
			}

			return $entries;
		}

	}
