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
		protected $wikiId = null;
		protected $isEnabled = false;
		protected $name = '';
		protected $landingTitle = '';
		protected $landingArticleId = 0;
		protected $startingClueText = '';
		protected $startingClueImage = '';
		protected $articles = array();
		protected $finalFormText = '';
		protected $finalFormQuestion = '';
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
		public function getId() {
			return $this->id;
		}

		public function setId( $id ) {
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

		public function getName() {
			return $this->name;
		}

		public function setName( $name ) {
			$this->name = $name;
		}

		public function getLandingTitle() {
			return $this->landingTitle;
		}

		public function setLandingTitle( $landingTitle ) {
			$this->landingTitle = $landingTitle;
			$titleObj = WF::build('Title',array($this->landingTitle),'newFromText');
			$this->landingArticleId = $titleObj ? $titleObj->getArticleId() : 0;
		}

		public function getLandingArticleId() {
			return $this->landingArticleId;
		}

		public function setLandingTitleAndId( $landingTitle, $landingArticleId ) {
			$this->landingTitle = $landingTitle;
			$this->landingArticleId = $landingArticleId;
		}

		public function getStartingClueText() {
			return $this->startingClueText;
		}

		public function setStartingClueText( $startingClueText ) {
			$this->startingClueText = $startingClueText;
		}

		public function getStartingClueImage() {
			return $this->startingClueImage;
		}

		public function setStartingClueImage( $startingClueImage ) {
			$this->startingClueImage = $startingClueImage;
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

		public function getGoodbyeImage() {
			return $this->goodbyeImage;
		}

		public function setGoodbyeImage( $goodbyeImage ) {
			$this->goodbyeImage = $goodbyeImage;
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
