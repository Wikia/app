<?php

class AchRankedUser {
	private $mUserId;
	private $mScore;
	private $mUserName;
	private $mAvatarURL;
	private $mUserPageUrl;
	private $mCurrentRanking;
	private $mPreviousRanking;
	
	function __construct($userObj, $score, $currentRanking = null, $previousRanking = null) {
	    wfProfileIn(__METHOD__);

	    $this->mUserId = $userObj->getID();
	    $this->mUsername = $userObj->getName();
	    $this->mScore = $score;
	    $this->mAvatarURL = Masthead::newFromUser($userObj)->getUrl();
	    $this->mUserPageUrl = $userObj->getUserPage()->getLocalURL();
	    $this->mCurrentRanking = $currentRanking;
	    $this->mPreviousRanking = $previousRanking;

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

	public function getCurrentRanking() {
	    return $this->mCurrentRanking;
	}

	public function getPreviousRanking() {
	    return $this->mPreviousRanking;
	}
}