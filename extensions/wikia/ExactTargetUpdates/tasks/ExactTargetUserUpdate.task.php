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
		Assert::true( !empty( $userData[ 'user_id' ] ), 'User ID missing' );
		Assert::true( !empty( $userData[ 'user_email' ] ), 'User email missing' );

		/* Delete subscriber (email address) used by touched user */
		$this->getClient()->deleteSubscriber( $userData[ 'user_id' ] );

		/* Create Subscriber with new email */
		$this->getClient()->createSubscriber( $userData[ 'user_email' ] );

		/* Update or create User in external service */
		$this->getClient()->updateUser( $userData );

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
