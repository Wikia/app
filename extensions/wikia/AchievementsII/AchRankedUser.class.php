<?php

class AchRankedUser {
	private $mUserId;
	private $mScore;
	private $mUserName;
	private $mAvatarURL;
	private $mUserPageUrl;
	
	function __construct($userObj, $score) {
		wfProfileIn(__METHOD__);
		
		$this->mUserId = $userObj->getID();
		$this->mUsername = $userObj->getName();
		$this->mScore = $score;
		$this->mAvatarURL = Masthead::newFromUser($userObj)->getUrl();
		$this->mUserPageUrl = $userObj->getUserPage()->getLocalURL();
		
		wfProfileOut(__METHOD__);
	}
	
	public function getId() {
		return $this->mUserId;
	}
	
	public function getName() {
		return $this->mUsername;
	}
	
	public function getScore() {
		return $this->mScore;
	}
	
	public function getAvatarUrl() {
		return $this->mAvatarURL;
	}
	
	public function getUserPageUrl() {
		return $this->mUserPageUrl;
	}
}