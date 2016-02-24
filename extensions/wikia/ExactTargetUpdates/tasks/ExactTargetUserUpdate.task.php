<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;
use Wikia\ExactTarget\ExactTargetUserUpdateDriver as Driver;

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

		// Remove old email if necessary
		if ( Driver::shouldCreateAsEmailChanged( $userEmailOld, $userEmailNew )
			&& !Driver::isUsed( $userId, $client->retrieveUserIdsByEmail( $userEmailOld ) )
		) {
			$client->deleteSubscriber( $userEmailOld );
		}

		// Create new email if necessary
		if ( Driver::shouldCreateAsEmailChanged( $userEmailOld, $userEmailNew )
			&& !Driver::isUsed( $userId, $client->retrieveUserIdsByEmail( $userEmailNew ) )
		) {
			$client->createSubscriber( $userEmailNew );
		}

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
}
