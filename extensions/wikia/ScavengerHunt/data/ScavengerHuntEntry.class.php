<?php

	class ScavengerHuntGameEntry {

		protected $userId = 0;
		protected $name = '';
		protected $email = '';
		protected $answer = '';

		public function getUserId() {
			return $this->userId;
		}

		public function setUserId( $userId ) {
			$this->userId = $userId;
		}

		public function getName() {
			return $this->name;
		}

		public function setName( $name ) {
			$this->name = $name;
		}

		public function getEmail() {
			return $this->email;
		}

		public function setEmail( $email ) {
			$this->email = $email;
		}

		public function getAnswer() {
			return $this->answer;
		}

		public function setAnswer( $answer ) {
			$this->answer = $answer;
		}

		protected function loadFromDbData( $row ) {
			$this->userId = $row->user_id;
			$this->name = $row->name;
			$this->email = $row->email;
			$this->answer = $row->answer;
		}

		static public function newFromRow( $row ) {
			$entryObj = WF::build('ScavengerHuntEntry');
			$entryObj->loadFromDbData($row);
			return $entryObj;
		}

	}
