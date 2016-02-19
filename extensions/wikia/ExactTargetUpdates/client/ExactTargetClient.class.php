<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\WikiaLogger;

class ExactTargetClient implements Client {

	public function createUser( array $aUserData ) {
		$oRequest = ExactTargetRequestBuilder::createUpdate()
			->withUserData( [ $aUserData ] )
			->build();

		$oCreateUserResult = $this->sendRequest( 'Update', $oRequest );

		//		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateUserResult->OverallStatus );
		//		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oCreateUserResult ) );

		if ( $oCreateUserResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oCreateUserResult->Results->StatusMessage
			);
		}
	}

	/**
	 * Deletes Subscriber object in ExactTarget by API request if email is not used by other user
	 */
	public function deleteSubscriber( $userId ) {
		$sUserEmail = $this->retrieveEmailByUserId( $userId );

		/* Skip deletion if no email found */
		if ( empty( $sUserEmail ) ) {
			//			$this->info(__METHOD__ . ": No email found for the user or there's no user record. Deletion skipped.");
			return;
		}

		/* Skip deletion if email is used by other account */
		if ( $this->isEmailInUse( $sUserEmail, $userId ) ) {
			//			$this->info(__METHOD__ . ': Email in use by different account (record). Deletion skipped.');
			return;
		}

		$oDeleteRequest = ExactTargetRequestBuilder::createDelete()
			->withUserEmail( $sUserEmail )
			->build();

		$oResults = $this->sendRequest( 'Delete', $oDeleteRequest );
		//		$this->info( __METHOD__ . ' OverallStatus: ' . $oDeleteSubscriberResult->OverallStatus );
		//		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oDeleteSubscriberResult ) );
	}

	public function createSubscriber( $userEmail ) {
		//		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oRequest = ExactTargetRequestBuilder::createCreate()
			->withUserEmail( $userEmail )
			->build();

		$oResults = $this->sendRequest( 'Create', $oRequest );

		//		$this->info( __METHOD__ . ' OverallStatus: ' . $createSubscriberResult->OverallStatus );
		//		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$createSubscriberResult ) );
	}

	public function createUserProperties( $iUserId, array $aUserProperties ) {
		$oRequest = ExactTargetRequestBuilder::createUpdate()
			->withUserId( $iUserId )
			->withProperties( $aUserProperties )
			->build();

		$oCreateUserPropertiesResult = $this->sendRequest( 'Update', $oRequest );

		//		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateUserPropertiesResult->OverallStatus );
		//		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oCreateUserPropertiesResult ) );

		if ( $oCreateUserPropertiesResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oCreateUserPropertiesResult->Results[ 0 ]->StatusMessage
			);
		}

		$oUserDataVerificationTask = new ExactTargetUserDataVerificationTask();
		$oUserDataVerificationTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$bUserDataVerificationResult = $oUserDataVerificationTask->verifyUserPropertiesData( $iUserId );

		return $bUserDataVerificationResult;
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
