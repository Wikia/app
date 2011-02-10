<?php
class ScavengerHuntEntry {

	protected $entries = null;

	protected $gameId = 0;
	protected $userId = 0;
	protected $name = '';
	protected $email = '';
	protected $answer = '';

	public function setEntries( $entries ) {
		$this->entries = $entries;
	}

	public function getGameId() {
		return $this->gameId;
	}

	public function setGameId( $gameId ) {
		$this->gameId = $gameId;
	}

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

	public function save() {
		return $this->entries->save($this);
	}
}