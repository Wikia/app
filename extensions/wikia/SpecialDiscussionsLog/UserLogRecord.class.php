<?php

/**
 * Class UserLogRecord
 */
class UserLogRecord {
	private $ip;
	private $location;
	private $language;
	private $userAgent;
	private $app;
	private $timestamp;
	private $userId;
	private $userName;

	public function getApp() {
		return $this->app;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getLocation() {
		return $this->location;
	}

	public function getIp() {
		return $this->ip;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function getUserAgent() {
		return $this->userAgent;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function setApp( $app ) {
		$this->app = $app;
	}

	public function setIp( $ip ) {
		$this->ip = $ip;
	}

	public function setLanguage( $language ) {
		$this->language = $language;
	}

	public function setLocation( $location ) {
		$this->location = $location;
	}

	public function setTimestamp( $timestamp ) {
		$this->timestamp = $timestamp;
	}

	public function setUserAgent( $userAgent ) {
		$this->userAgent = $userAgent;
	}

	public function setUserId( $userId ) {
		$this->userId = $userId;
	}

	public function setUserName( $userName ) {
		$this->userName = $userName;
	}
}
