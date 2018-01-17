<?php

class ListUsersEditUpdate extends ListUsersUpdate  {
	use JsonDeserializerTrait;

	/** @var int $latestRevisionId */
	private $latestRevisionId;

	/** @var string $latestRevisionTimestamp */
	private $latestRevisionTimestamp;

	/**
	 * @return int
	 */
	public function getLatestRevisionId(): int {
		return $this->latestRevisionId;
	}

	/**
	 * @return string
	 */
	public function getLatestRevisionTimestamp(): string {
		return $this->latestRevisionTimestamp;
	}

	/**
	 * @param int $latestRevisionId
	 */
	public function setLatestRevisionId( int $latestRevisionId ) {
		$this->latestRevisionId = $latestRevisionId;
	}

	/**
	 * @param string $latestRevisionTimestamp
	 */
	public function setLatestRevisionTimestamp( string $latestRevisionTimestamp ) {
		$this->latestRevisionTimestamp = $latestRevisionTimestamp;
	}

	public function jsonSerialize() {
		return [
			'userId' => $this->userId,
			'userGroups' => $this->userGroups,
			'latestRevisionId' => $this->latestRevisionId,
			'latestRevisionTimestamp' => $this->latestRevisionTimestamp
		];
	}
}
