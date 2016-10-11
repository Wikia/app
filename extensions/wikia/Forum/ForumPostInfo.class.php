<?php

class ForumPostInfo {

	private $username;
	private $userprofile;
	private $timestamp;

	public function __construct( $array = [ ] ) {
		foreach ( $array as $key => $val ) {
			$this->$key = $val;
		}
	}

	public function setUsername( $username ) {
		$this->username = $username;
	}

	public function setUserProfile( $userprofile ) {
		$this->userprofile = $userprofile;
	}

	public function setTimestamp( $timestamp ) {
		$this->timestamp = $timestamp;
	}

	public function toArray() {
		return get_object_vars( $this );
	}
}
