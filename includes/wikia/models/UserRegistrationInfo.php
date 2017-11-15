<?php

class UserRegistrationInfo implements JsonSerializable {
	/** @var string $registrationDomain */
	private $registrationDomain;
	/** @var string $userName */
	private $userName;
	/** @var int $userId */
	private $userId;
	/** @var int $wikiId */
	private $wikiId;
	/** @var string $clientIp */
	private $clientIp;
	/** @var string $langCode */
	private $langCode;
	/** @var bool $emailConfirmed */
	private $emailConfirmed;

	/**
	 * Deserialize an UserRegistrationInfo instance from a JSON object or associative array
	 * @param array|stdClass|object $jsonData
	 * @return UserRegistrationInfo
	 */
	public static function newFromJson( $jsonData ): UserRegistrationInfo {
		$userRegistrationInfo = new UserRegistrationInfo();

		foreach ( get_object_vars( $userRegistrationInfo ) as $propName => $value ) {
			if ( isset( $jsonData[$propName] ) ) {
				$userRegistrationInfo->$propName = $jsonData[$propName];
			}
		}

		return $userRegistrationInfo;
	}

	public function jsonSerialize() {
		return get_object_vars( $this );
	}

	/**
	 * @return string
	 */
	public function getRegistrationDomain() {
		return $this->registrationDomain;
	}

	/**
	 * @return string
	 */
	public function getUserName() {
		return $this->userName;
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return int
	 */
	public function getWikiId() {
		return $this->wikiId;
	}

	/**
	 * @return string
	 */
	public function getClientIp() {
		return $this->clientIp;
	}

	/**
	 * @return string
	 */
	public function getLangCode() {
		return $this->langCode;
	}

	/**
	 * @return bool
	 */
	public function isEmailConfirmed() {
		return $this->emailConfirmed;
	}

	public function toUser(): User {
		$user = User::newFromName( $this->userName, false /* already validated */ );

		// it is not possible to use User::setId() because of bad design - it clears instance cache
		$user->setUserId( $this->userId );

		return $user;
	}
}
