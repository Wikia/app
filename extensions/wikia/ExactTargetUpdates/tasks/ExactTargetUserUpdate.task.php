<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\WikiaLogger;
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
	 * @param array $userProperties
	 * @return bool
	 * @throws \Exception
	 * @throws \Wikia\Util\AssertionException
	 */
	public function update( array $userData, array $userProperties ) {
		Assert::true( !empty( $userData[ 'user_id' ] ), 'User ID missing' );
		Assert::true( !empty( $userData[ 'user_email' ] ), 'User email missing' );

		/* Delete subscriber (email address) used by touched user */
		$this->getClient()->deleteSubscriber( $userData[ 'user_id' ] );

		/* Create Subscriber with new email */
		$this->getClient()->createSubscriber( $userData[ 'user_email' ] );

		/* Update or create User in external service */
		$this->getClient()->updateUser( $userData );

		/* Update or create User Properties DataExtension with provided properties */
		if ( !empty( $userProperties ) ) {
			$this->getClient()->updateUserProperties( $userData[ 'user_id' ], $userProperties );
		}

		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
