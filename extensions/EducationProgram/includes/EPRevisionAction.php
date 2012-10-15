<?php

class EPRevisionAction {

	protected $user;
	protected $isMinor = false;
	protected $isDelete = false;
	protected $comment = '';
	protected $time = false;

	public function __construct() {

	}

	public function isMinor() {
		return $this->isMinor;
	}

	public function isDelete() {
		return $this->isDelete;
	}

	public function getComment() {
		return $this->comment;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	public function getTime() {
		return $this->time === false ? wfTimestampNow() : $this->time;
	}

	public function setUser( User $user ) {
		$this->user = $user;
	}

	public function setComment( $comment ) {
		$this->comment = $comment;
	}

	public function setDelete( $isDelete ) {
		$this->isDelete = $isDelete;
	}

	public function setMinor( $isMinor ) {
		$this->isMinor = $isMinor;
	}

	public function setTime( $time ) {
		$this->time = $time;
	}

}
