<?php

	class ScavengerHuntGame {

		/**
		 * @var WikiaApp
		 */
		protected $app = null;
		/**
		 * @var ScavengerHuntGames
		 */
		protected $games = null;

		protected $id = 0;
		protected $wikiId = 0;
		protected $isEnabled = false;
		protected $name = '';
		protected $landingTitle = ''; //:nosetter
		protected $landingArticleId = 0; //:nosetter
		protected $landingButtonText = '';
		protected $startingClueTitle = '';
		protected $startingClueText = '';
		protected $startingClueImage = '';
		protected $startingClueButtonText = '';
		protected $startingClueButtonTarget = '';
		protected $articles = array();
		protected $entryFormTitle = '';
		protected $entryFormImage = '';
		protected $entryFormQuestion = '';
		protected $goodbyeText = '';
		protected $goodbyeImage = '';

		public function __construct( WikiaApp $app, $id = 0 ) {
			$this->app = $app;
			$this->id = $id;
		}

		/** GETTER FOR GAMES OBJECT **/
		public function setGames( $games ) {
			$this->games = $games;
		}

		/** GETTERS AND SETTERS **/
		public function setLandingTitle( $landingTitle ) {
			$this->landingTitle = $landingTitle;
			$titleObj = WF::build('Title',array($this->landingTitle),'newFromText');
			$this->landingArticleId = $titleObj ? $titleObj->getArticleId() : 0;
		}

		public function setLandingTitleAndId( $landingTitle, $landingArticleId ) {
			$this->landingTitle = $landingTitle;
			$this->landingArticleId = $landingArticleId;
		}

		public function setId( $id ) { $this->id = $id; }
		public function setWikiId( $wikiId ) { $this->wikiId = $wikiId; }
		public function setEnabled( $isEnabled ) { $this->isEnabled = $isEnabled; }
		public function setName( $name ) { $this->name = $name; }
		public function setLandingButtonText( $landingButtonText ) { $this->landingButtonText = $landingButtonText; }
		public function setStartingClueTitle( $startingClueTitle ) { $this->startingClueTitle = $startingClueTitle; }
		public function setStartingClueText( $startingClueText ) { $this->startingClueText = $startingClueText; }
		public function setStartingClueImage( $startingClueImage ) { $this->startingClueImage = $startingClueImage; }
		public function setStartingClueButtonText( $startingClueButtonText ) { $this->startingClueButtonText = $startingClueButtonText; }
		public function setStartingClueButtonTarget( $startingClueButtonTarget ) { $this->startingClueButtonTarget = $startingClueButtonTarget; }
		public function setArticles( $articles ) { $this->articles = $articles; }
		public function setEntryFormTitle( $entryFormTitle ) { $this->entryFormTitle = $entryFormTitle; }
		public function setEntryFormImage( $entryFormImage ) { $this->entryFormImage = $entryFormImage; }
		public function setEntryFormQuestion( $entryFormQuestion ) { $this->entryFormQuestion = $entryFormQuestion; }
		public function setGoodbyeText( $goodbyeText ) { $this->goodbyeText = $goodbyeText; }
		public function setGoodbyeImage( $goodbyeImage ) { $this->goodbyeImage = $goodbyeImage; }

		public function getId() { return $this->id; }
		public function getWikiId() { return $this->wikiId; }
		public function isEnabled() { return $this->isEnabled; }
		public function getName() { return $this->name; }
		public function getLandingTitle() { return $this->landingTitle; }
		public function getLandingArticleId() { return $this->landingArticleId; }
		public function getLandingButtonText() { return $this->landingButtonText; }
		public function getStartingClueTitle() { return $this->startingClueTitle; }
		public function getStartingClueText() { return $this->startingClueText; }
		public function getStartingClueImage() { return $this->startingClueImage; }
		public function getStartingClueButtonText() { return $this->startingClueButtonText; }
		public function getStartingClueButtonTarget() { return $this->startingClueButtonTarget; }
		public function getArticles() { return $this->articles; }
		public function getEntryFormTitle() { return $this->entryFormTitle; }
		public function getEntryFormImage() { return $this->entryFormImage; }
		public function getEntryFormQuestion() { return $this->entryFormQuestion; }
		public function getGoodbyeText() { return $this->goodbyeText; }
		public function getGoodbyeImage() { return $this->goodbyeImage; }

		protected function getDataProperties() {
			return array( 'landingTitle', 'landingArticleId', 'landingButtonText', 'startingClueTitle',
				'startingClueText', 'startingClueImage', 'startingClueButtonText', 'startingClueButtonTarget', 'articles',
				'entryFormTitle', 'entryFormImage', 'entryFormQuestion', 'goodbyeText', 'goodbyeImage' );
		}

		public function getData() {
			$result = array();
			foreach ($this->getDataProperties() as $varName)
				$result[$varName] = $this->$varName;
			return $result;
		}

		public function setData( $data ) {
			foreach ($this->getDataProperties() as $varName)
				if (array_key_exists($varName, $data))
					$this->$varName = $data[$varName];
			// special cases
			if (array_key_exists('landingTitle',$data) && !array_key_exists('landingArticleId',$data))
				$this->setLandingTitle($data['landingTitle']);
		}

		protected function getAllProperties() {
			return array( 'id', 'wikiId', 'isEnabled', 'name',
				'landingTitle', 'landingArticleId', 'landingButtonText', 'startingClueTitle',
				'startingClueText', 'startingClueImage', 'startingClueButtonText', 'startingClueButtonTarget', 'articles',
				'entryFormTitle', 'entryFormImage', 'entryFormQuestion', 'goodbyeText', 'goodbyeImage' );
		}

		public function getAll() {
			$result = array();
			foreach ($this->getAllProperties() as $varName)
				$result[$varName] = $this->$varName;
			return $result;
		}

		public function setAll( $data ) {
			foreach ($this->getAllProperties() as $varName)
				if (array_key_exists($varName, $data))
					$this->$varName = $data[$varName];
			// special cases
			if (array_key_exists('landingTitle',$data) && !array_key_exists('landingArticleId',$data))
				$this->setLandingTitle($data['landingTitle']);
		}


		/** BASIC OPERATIONS **/
		public function save() {
			return $this->games->save($this);
		}

		public function load() {
			// already loaded - nothing to do
		}

		public function delete() {
			return $this->games->delete($this);
		}

		/** HELPER METHODS **/
		public function newGameArticle() {
			return $this->games->newGameArticle();
		}

		public function findArticleByTitle( Title $title ) {
			$articleId = $title->getArticleId();
			if (!empty($articleId)) {
				foreach ($this->articles as $article) {
					if ($articleId === $article->getArticleId()) {
						return $article;
					}
				}
			}
			return false;
		}

		public function isGameCompleted( $visitedIds ) {
			$ids = array();
			foreach ($visitedIds as $v) $ids[(int)$v] = true;
			foreach ($this->articles as $article) {
				if (!isset($ids[$article->getArticleId()])) {
					return false;
				}
			}

			return true;
		}

		protected function getEntries() {
			return $this->games->getEntries();
		}

		/** ENTRIES MANAGEMENT **/
		public function addEntry( ScavengerHuntEntry $entry ) {
			if ($this->getId() == 0) {
				return false;
			}

			$entry->setGameId($this->getId());
			$entries = $this->getEntries();
			return $entries->save($entry);
		}

		public function listEntries() {
			if ($this->getId() == 0) {
				return array();
			}

			$entries = $this->getEntries();
			return $entries->findAllByGameId($this->getId());
		}

	}
