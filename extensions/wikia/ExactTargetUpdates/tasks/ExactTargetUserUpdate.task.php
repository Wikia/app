<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetUserUpdate extends BaseTask {

	private $client;

	const STATUS_OK = 'OK';

	public function __construct( $client = null ) {
		$this->client = $client;
	}

	/**
	 * Update user or create if doesn't exist
	 * @param array $userData
	 * @return string
	 * @throws \Wikia\Util\AssertionException
	 */
	public function updateUser( array $userData ) {
		$userId = $userData[ 'user_id' ];
		$userEmailNew = $userData[ 'user_email' ];

		Assert::true( !empty( $userId ), 'User ID missing' );
		Assert::true( !empty( $userEmailNew ), 'User email missing' );

		$client = $this->getClient();
		$userEmailOld = $client->retrieveEmailByUserId( $userId );

		$this->updateSubscriber( $userEmailOld, $userEmailNew, $userId, $client );

		/* Update or create User in external service */
		$client->updateUser( $userData );

		return self::STATUS_OK;
	}

	/**
	 * Update or create User Properties DataExtension with provided properties
	 * @param int $userId
	 * @param array $userProperties
	 * @return string
	 */
	public function updateUserProperties( $userId, array $userProperties ) {
		$this->getClient()->updateUserProperties( $userId, $userProperties );
		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}

	/**
	 * @param string $userEmailOld
	 * @param string $userEmailNew
	 * @param int $userId
	 * @param ExactTargetClient $client
	 */
	private function updateSubscriber( $userEmailOld, $userEmailNew, $userId, ExactTargetClient $client ) {
		// Remove old email if necessary
		if ( !empty( $userEmailOld ) && $userEmailOld !== $userEmailNew ) {
			// Remove old email if used only by this user account
			$idsOld = $client->retrieveUserIdsByEmail( $userEmailOld );
			if ( count( $idsOld ) === 1 && $idsOld[ 0 ] === $userId ) {
				$client->deleteSubscriber( $userEmailOld );
			}
		}

		// Create new email if necessary
		if ( empty( $userEmailOld ) || $userEmailOld !== $userEmailNew ) {
			// Create new email if doesn't already exist
			$idsNew = $client->retrieveUserIdsByEmail( $userEmailNew );
			if ( empty( $idsNew ) ) {
				$client->createSubscriber( $userEmailNew );
			}
		}
	}
}
