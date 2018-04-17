<?php

class AchRankedUser {
	private $mUserId;
	private $mScore;
	private $mUsername;
	private $mUserPageUrl;
	private $mCurrentRanking;

	public function __construct( User $userObj, $score, $currentRanking = null ) {
	    wfProfileIn(__METHOD__);

	    $this->mUserId = $userObj->getID();
	    $this->mUsername = $userObj->getName();
	    $this->mScore = $score;
	    $this->mUserPageUrl = $userObj->getUserPage()->getLocalURL();
	    $this->mCurrentRanking = $currentRanking;

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

	public function getUserPageUrl() {
		return $this->mUserPageUrl;
	}

	public function getCurrentRanking() {
	    return $this->mCurrentRanking;
	}
}
