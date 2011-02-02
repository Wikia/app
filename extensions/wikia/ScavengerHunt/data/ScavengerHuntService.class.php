<?php

	class ScavengerHuntService {

		protected $app = null;

		public function __construct( WikiaApp $app ) {
			$this->app = $app;
		}

		public function createGameArticle() {
			return WF::build('ScavengerHuntGameArticle');
		}

		public function createGame() {
			return WF::build('ScavengerHuntGame');
		}

		public function getGameById( $id ) {
			return WF::build('ScavengerHuntGame',array('id' => $id));
		}

	}
