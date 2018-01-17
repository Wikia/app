<?php

class ListUsersUpdate implements JsonSerializable {
	use JsonDeserializerTrait;

	/** @var int $userId */
	protected $userId;

	/** @var string[] $userGroups */
	protected $userGroups;

	/**
	 * @return int
	 */
	public function getUserId(): int {
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId( int $userId ) {
		$this->userId = $userId;
	}

	/**
	 * @return string[]
	 */
	public function getUserGroups(): array {
		return $this->userGroups;
	}

	/**
	 * @param string[] $userGroups
	 */
	public function setUserGroups( array $userGroups ) {
		$this->userGroups = $userGroups;
	}

	public function jsonSerialize() {
		return [
			'userId' => $this->userId,
			'userGroups' => $this->userGroups,
		];
	}
}
