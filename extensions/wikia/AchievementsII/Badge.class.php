<?php

class Badge {

	private $mBadgeTypeId;
	private $mBadgeLap;

	public function __construct($badgeTypeId, $badgeLap = null) {
		$this->mBadgeTypeId = $badgeTypeId;
		$this->mBadgeLap = $badgeLap;
	}

	public function getTypeId() {
		return $this->mBadgeTypeId;
	}

	public function getLap() {
		return $this->mBadgeLap;
	}

	public function getName() {
		return "- mBadgeTypeId={$this->mBadgeTypeId} - mBadgeLap={$this->mBadgeLap} -";
	}

}