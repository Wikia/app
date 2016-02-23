<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\Loggable;

class ExactTargetClient {
	use Loggable;

	const EXACT_TARGET_LABEL = 'ExactTarget client';
	const RETRIES_LIMIT = 1;

	public function updateUser( array $userData ) {
		$request = ExactTargetRequestBuilder::createUpdate()
			->withUserData( [ $userData ] )
			->build();

		$this->sendRequest( 'Update', $request );
	}

	/**
	 * Deletes Subscriber object in ExactTarget by API request
	 */
	public function deleteSubscriber( $userEmail ) {
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

		$this->sendRequest( 'Update', $request );

		return 'OK';
	}

	public function retrieveEmailByUserId( $userId ) {
		$result = $this->retrieve( [ 'user_email' ], 'user_id', [ $userId ], ResourceEnum::USER );

		return ( new UserEmailAdapter( $result ) )->getEmail();
	}

	public function retrieveUsersEdits( $usersIds ) {
		$result = $this->retrieve(
			[ 'user_id', 'wiki_id', 'contributions' ], 'user_id', $usersIds, ResourceEnum::USER_WIKI );

		return ( new UserEditsAdapter( $result ) )->getEdits();
	}

	public function retrieveUserIdsByEmail( $email ) {
		$result = $this->retrieve( [ 'user_id' ], 'user_email', [ $email ], ResourceEnum::USER );

		return ( new UserIdsAdapter( $result ) )->getUsersIds();
	}

	private function retrieve( array $properties, $filterProperty, array $filterValues, $resource ) {
		$request = ExactTargetRequestBuilder::createRetrieve()
			->withResource( $resource )
			->withProperties( $properties )
			->withFilterProperty( $filterProperty )
			->withFilterValues( $filterValues )
			->build();

		return $this->sendRequest( 'Retrieve', $request );
	}

	protected function sendRequest( $type, $request ) {
		// send first call
		$response = $this->doCall( $type, $request, 0 );
		if ( $response->OverallStatus === 'OK' ) {
			return $response->Results;
		}

		$exception = $response ? new ExactTargetException( $response->Results->StatusMessage )
			: new ExactTargetException( "Request failed" );
		$this->error( self::EXACT_TARGET_LABEL, [ 'exception' => $exception ] );
		throw $exception;
	}

	protected function doCall( $method, $request, $retry ) {
		try {
			$results = $this->getExactTargetClient()->$method( $request );
		} catch ( \Exception $e ) {
			$this->error( self::EXACT_TARGET_LABEL, [ 'exception' => $e, 'retries' => $retry ] );
			// retry on failure till limit reached
			return $retry < self::RETRIES_LIMIT ? $this->doCall( $method, $request, $retry + 1 ) : false;
		}
		$this->info( self::EXACT_TARGET_LABEL, [ 'retries' => $retry ] );
		return $results;
	}

	protected function getLoggerContext() {
		$client = $this->getExactTargetClient();

		$requestHeaders = $client->__getLastRequestHeaders();
		$data = $client->__getLastRequest();
		$status = strtok( $client->__getLastResponseHeaders(), "\n" );
		$response = $client->__getLastResponse();
		return [
			'request.headers' => $requestHeaders ? $requestHeaders : '',
			'request.data' => $data ? $data : '',
			'response.status' => $status ? $status : '',
			'response.data' => $response ? $response : ''
		];
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
