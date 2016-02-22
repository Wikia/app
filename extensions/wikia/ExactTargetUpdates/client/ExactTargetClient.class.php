<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\WikiaLogger;

class ExactTargetClient implements Client {

	public function updateUser( array $userData ) {
		$request = ExactTargetRequestBuilder::createUpdate()
			->withUserData( [ $userData ] )
			->build();

		$response = $this->sendRequest( 'Update', $request );

		if ( $response->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $response->Results->StatusMessage
			);
		}
	}

	/**
	 * Deletes Subscriber object in ExactTarget by API request if email is not used by other user
	 */
	public function deleteSubscriber( $userId ) {
		$userEmail = $this->retrieveEmailByUserId( $userId );

		/* Skip deletion if no email found */
		if ( empty( $userEmail ) ) {
			return;
		}

		/* Skip deletion if email is used by other account */
		if ( $this->isEmailInUse( $userEmail, $userId ) ) {
			return;
		}

		$deleteRequest = ExactTargetRequestBuilder::createDelete()
			->withUserEmail( $userEmail )
			->build();

		$this->sendRequest( 'Delete', $deleteRequest );
	}

	public function createSubscriber( $userEmail ) {
		$oRequest = ExactTargetRequestBuilder::createCreate()
			->withUserEmail( $userEmail )
			->build();

		$this->sendRequest( 'Create', $oRequest );
	}

	/**
	 * Update or create user properties DataExtension object in ExactTarget by API request
	 * that reflects Wikia user_properties table
	 * @param int $userId User ID
	 * @param array $userProperties key-value array ['property_name'=>'property_value']
	 * @return bool
	 * @throws \Exception
	 */
	public function updateUserProperties( $userId, array $userProperties ) {
		$request = ExactTargetRequestBuilder::createUpdate()
			->withUserId( $userId )
			->withProperties( $userProperties )
			->build();

		$createUserPropertiesResult = $this->sendRequest( 'Update', $request );

		if ( $createUserPropertiesResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $createUserPropertiesResult->Results[ 0 ]->StatusMessage
			);
		}

		$userDataVerificationTask = new ExactTargetUserDataVerificationTask();
		$userDataVerificationResult = $userDataVerificationTask->verifyUserPropertiesData( $userId );

		return $userDataVerificationResult;
	}

	public function retrieveEmailByUserId( $userId ) {
		try {
			$result = $this->retrieve(
				[ 'user_email' ],
				'user_id',
				[ $userId ],
				\Wikia\ExactTarget\ResourceEnum::USER
			);
		} catch ( EmptyResultException $e ) {
			return '';
		}
		return ( new UserEmailAdapter( $result ) )->getEmail();
	}

	public function retrieveUsersEdits( $usersIds ) {
		try {
			$result = $this->retrieve(
				[ 'user_id', 'wiki_id', 'contributions' ],
				'user_id',
				$usersIds,
				\Wikia\ExactTarget\ResourceEnum::USER_WIKI
			);
		} catch ( EmptyResultException $e ) {
			return [];
		}
		return ( new UserEditsAdapter( $result ) )->getEdits();
	}

	/**
	 * Checks whether there are any users that has provided email
	 * @param string $sEmail Email address to check in ExactTarget
	 * @param int $iSkipUserId Skip this user ID when checking if email is used by any account
	 * @return bool
	 */
	protected function isEmailInUse( $sEmail, $iSkipUserId = null ) {
		$oRetrieveUserTask = new ExactTargetRetrieveUserTask();
		/* @var stdClass $oUsersIds */
		$oUsersIds = $oRetrieveUserTask->retrieveUserIdsByEmail( $sEmail );
		$iUsersCount = count( $oUsersIds->Results );

		// Email is in use when there are more than one user with email
		$ret = ( $iUsersCount > 1 );

		// One or less users
		if ( !$ret ) {
			// Email is in use when there's one user not equal to $iSkipUserId from parameters list
			$ret = $iUsersCount == 1 && $oUsersIds->Results->Properties->Property->Value != $iSkipUserId;
		}

		return $ret;
	}

	/**
	 * @param array $properties
	 * @param string $filterProperty
	 * @param array $filterValues
	 * @return null
	 * @throws \Exception
	 */
	private function retrieve( array $properties, $filterProperty, array $filterValues, $resource ) {
		$request = ExactTargetRequestBuilder::createRetrieve()
			->withResource( $resource )
			->withProperties( $properties )
			->withFilterProperty( $filterProperty )
			->withFilterValues( $filterValues )
			->build();

		$response = $this->sendRequest( 'Retrieve', $request );

		if ( $response->OverallStatus === 'OK' ) {
			if ( empty( $response->Results ) ) {
				throw new EmptyResultException();
			}
			return $response->Results;
		}

		if ( $response->OverallStatus === 'Error' ) {
			$exception = new \Exception( $response->Results->StatusMessage );
			WikiaLogger::instance()->error( $response->Results->StatusMessage, [
				'exception' => $exception,
			] );
			throw $exception;
		}

		// TODO provide more context to logs - e.g. request object
		$exception = new \Exception( $response->OverallStatus );
		WikiaLogger::instance()->error( $response->OverallStatus, [
			'exception' => $exception,
		] );
		throw $exception;
	}

	protected function sendRequest( $sType, $oRequestObject ) {
		try {
			$oResults = $this->getExactTargetClient()->$sType( $oRequestObject );
			WikiaLogger::instance()->info( $this->getExactTargetClient()->__getLastResponse() );
			return $oResults;
		} catch ( \SoapFault $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
			return false;
		}
	}

	protected function getExactTargetClient() {
		if ( !isset( $this->client ) ) {
			global $wgExactTargetApiConfig;
			$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
			$oClient = new \ExactTargetSoapClient( $wsdl, [ 'trace' => 1, 'exceptions' => true ] );
			$oClient->username = $wgExactTargetApiConfig[ 'username' ];
			$oClient->password = $wgExactTargetApiConfig[ 'password' ];
			$this->client = $oClient;
		}
		return $this->client;
	}
}
