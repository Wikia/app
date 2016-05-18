<?php
namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ExactTargetUserUpdateDriver as Driver;
use Wikia\ExactTarget\ResourceEnum as Enum;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetUserTask extends BaseTask {

	private $client;
	private static $propertiesList = [ 'marketingallowed', 'unsubscribed', 'language' ];

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
		$userId = $userData[ Enum::USER_ID ];
		$userEmailNew = $userData[ Enum::USER_EMAIL ];

		Assert::true( !empty( $userId ), 'User ID missing' );
		Assert::true( !empty( $userEmailNew ), 'User email missing' );

		$client = $this->getClient();
		$userEmailOld = $client->retrieveEmailByUserId( $userId );

		// Remove old email if necessary
		if ( Driver::shouldDeleteAsEmailChanged( $userEmailOld, $userEmailNew )
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

	public function removeUserGroup( $userId, $group ) {
		$this->getClient()->deleteUserGroup( $userId, $group );
		return self::STATUS_OK;
	}

	public function addUserGroup( $userId, $group ) {
		$this->getClient()->createUserGroup( $userId, $group );
		return self::STATUS_OK;
	}

	public function deleteUserData( $userId ) {
		$userEmail = $this->getClient()->retrieveEmailByUserId( $userId );
		if ( !empty( $userEmail ) &&
			 /* Skip deletion if no email found or email used by other account */
			 !Driver::isUsed( $userId, $this->getClient()->retrieveUserIdsByEmail( $userEmail ) )
		) {
			$this->getClient()->deleteSubscriber( $userEmail );
		}
		$this->getClient()->deleteUser( $userId );
		$this->getClient()->deleteuserProperties( $userId, self::$propertiesList );

		return self::STATUS_OK;
	}

	public function updateUsersEdits( $userEdits ) {
		// Get number of edits from ExactTarget
		$ids = array_keys( $userEdits );
		$edits = $this->getClient()->retrieveUsersEdits( $ids );

		// sum up with incremental data
		$total = Driver::sumUpEdits( $userEdits, $edits );

		$this->getClient()->updateUserEdits( $total );

		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
