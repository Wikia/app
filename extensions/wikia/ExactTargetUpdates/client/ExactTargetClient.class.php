<?php
namespace Wikia\ExactTarget;

use Predis\Transaction\AbortedMultiExecException;
use Wikia\Logger\Loggable;
use Wikia\ExactTarget\ResourceEnum as Enum;

class ExactTargetClient {
	use Loggable;

	const UPDATE_CALL = 'Update';
	const DELETE_CALL = 'Delete';
	const CREATE_CALL = 'Create';
	const RETRIEVE_CALL = 'Retrieve';

	const STATUS_OK = 'OK';
	const STATUS_MORE_DATA_AVAILABLE = 'MoreDataAvailable';
	const EXACT_TARGET_LABEL = 'ExactTarget client';
	const EXACT_TARGET_REQUEST_FAILED = 'Request failed';
	const RETRIES_LIMIT = 1;

	const OBJECTS_PER_REQUEST_LIMIT = 2500;

	private $client;

	public function __construct( $client = null ) {
		if ( isset( $client ) ) {
			$this->client = $client;
		}
	}

	public function updateUser( array $userData ) {
		$request = ExactTargetRequestBuilder::getUserUpdateBuilder()
			->withUserData( [ $userData ] )
			->build();

		return $this->sendRequest( self::UPDATE_CALL, $request );
	}

	public function deleteUser( $userId ) {
		$request = ExactTargetRequestBuilder::getUserDeleteBuilder()
			->withUserId( $userId )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $request );
	}

	/**
	 * Deletes Subscriber object in ExactTarget by API request
	 * @param string $userEmail
	 * @return bool
	 * @throws ExactTargetException
	 */
	public function deleteSubscriber( $userEmail ) {
		$deleteRequest = ExactTargetRequestBuilder::getSubscriberDeleteBuilder()
			->withUserEmail( $userEmail )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $deleteRequest );
	}

	public function createSubscriber( $userEmail ) {
		$oRequest = ExactTargetRequestBuilder::getSubscriberCreateBuilder()
			->withUserEmail( $userEmail )
			->build();

		return $this->sendRequest( self::CREATE_CALL, $oRequest );
	}

	public function deleteUserGroup( $userId, $group ) {
		$request = ExactTargetRequestBuilder::getUserGroupDeleteBuilder()
			->withUserId( $userId )
			->withGroup( $group )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $request );
	}

	public function createUserGroup( $userId, $group ) {
		$request = ExactTargetRequestBuilder::getUserGroupCreateBuilder()
			->withUserId( $userId )
			->withGroup( $group )
			->build();

		return $this->sendRequest( self::CREATE_CALL, $request );
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
		$request = ExactTargetRequestBuilder::getPropertiesUpdateBuilder()
			->withUserId( $userId )
			->withProperties( $userProperties )
			->build();

		return $this->sendRequest( self::UPDATE_CALL, $request );
	}

	public function deleteUserProperties( $userId, $properties ) {
		$request = ExactTargetRequestBuilder::getPropertiesDeleteBuilder()
			->withUserId( $userId )
			->withProperties( $properties )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $request );
	}

	public function retrieveEmailByUserId( $userId ) {
		$result = $this->retrieve(
			[ Enum::USER_EMAIL ],
			Enum::USER_ID,
			[ $userId ],
			Enum::CUSTOMER_KEY_USER
		);

		return ( new UserEmailAdapter( $result ) )->getEmail();
	}

	public function retrieveUsersEdits( $usersIds ) {
		$result = $this->retrieve(
			[ Enum::USER_ID, Enum::USER_WIKI_ID, Enum::USER_WIKI_FIELD_CONTRIBUTIONS ],
			Enum::USER_ID,
			$usersIds,
			Enum::CUSTOMER_KEY_USER_ID_WIKI_ID
		);

		return ( new UserEditsAdapter( $result ) )->getEdits();
	}

	public function retrieveUserIdsByEmail( $email ) {
		$result = $this->retrieve( [ Enum::USER_ID ], Enum::USER_EMAIL, [ $email ], Enum::CUSTOMER_KEY_USER );

		return ( new UserIdsAdapter( $result ) )->getUsersIds();
	}

	public function updateUserEdits( $edits ) {
		$request = ExactTargetRequestBuilder::getEditsUpdateBuilder()
			->withEdits( $edits )
			->build();

		return $this->sendRequest( self::UPDATE_CALL, $request );
	}

	public function updateWiki( $wikiId, array $wikiData ) {
		$request = ExactTargetRequestBuilder::getWikiUpdateBuilder()
			->withWikiData( $wikiId, $wikiData )
			->build();

		return $this->sendRequest( self::UPDATE_CALL, $request );
	}

	public function deleteWiki( $wikiId ) {
		$request = ExactTargetRequestBuilder::getWikiDeleteBuilder()
			->withWikiId( $wikiId )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $request );
	}

	public function retrieveWikiCategories( $wikiId ) {
		$result = $this->retrieve(
			[ Enum::WIKI_ID, Enum::WIKI_CAT_ID ],
			Enum::WIKI_ID,
			[ $wikiId ],
			Enum::CUSTOMER_KEY_WIKI_CAT_MAPPING
		);

		return ( new WikiCategoriesAdapter( $result ) )->getCategoriesMapping();
	}

	public function updateWikiCategoriesMapping( array $categories ) {
		$request = ExactTargetRequestBuilder::getWikiCategoriesMappingUpdateBuilder()
			->withWikiCategories( $categories )
			->build();

		return $this->sendRequest( self::UPDATE_CALL, $request );
	}

	public function deleteWikiCategoriesMapping( array $categories ) {
		$request = ExactTargetRequestBuilder::getWikiCategoriesMappingDeleteBuilder()
			->withWikiCategories( $categories )
			->build();

		return $this->sendRequest( self::DELETE_CALL, $request );
	}

	private function retrieve( array $properties, $filterProperty, array $filterValues, $resource ) {
		$request = ExactTargetRequestBuilder::getRetrieveBuilder()
			->withResource( $resource )
			->withProperties( $properties )
			->withFilterProperty( $filterProperty )
			->withFilterValues( $filterValues )
			->build();

		return $this->sendRetrieveRequest( $request );
	}

	protected function sendRequest( $type, $request ) {
		// send first call
		$response = $this->doCall( $type, $request, 0 );
		if ( $response instanceof \stdClass && $response->OverallStatus === self::STATUS_OK ) {
			return $response->Results ? $response->Results : true;
		}

		throw $this->responseException( $response );
	}

	protected function sendRetrieveRequest( $request ) {
		$response = null;
		$results = [ ];
		do {
			$response = $this->doCall( self::RETRIEVE_CALL, $request, 0 );
			if ( $response instanceof \stdClass ) {
				$responseResults = $response->Results ? $response->Results : [ ];
				$responseResults = is_array( $responseResults ) ? $responseResults : [ $responseResults ];
				$results = array_merge( $results, $responseResults );

				$request->RetrieveRequest->ContinueRequest = $response->RequestID;
			}
		} while ( $response instanceof \stdClass && $response->OverallStatus === self::STATUS_MORE_DATA_AVAILABLE);

		if ( $response instanceof \stdClass && $response->OverallStatus === self::STATUS_OK ) {
			return $results;
		}

		throw $this->responseException( $response );
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
		$soapClient = $this->getExactTargetClient();

		$requestHeaders = $soapClient->__getLastRequestHeaders();
		$data = $soapClient->__getLastRequest();
		$status = strtok( $soapClient->__getLastResponseHeaders(), "\n" );
		$response = $soapClient->__getLastResponse();
		return [
			'request.headers' => $requestHeaders ? $requestHeaders : '',
			'request.data' => $data ? strlen( $data ) : '',
			'response.status' => $status ? $status : '',
			'response.data' => $response ? strlen( $response ) : ''
		];
	}

	protected function getExactTargetClient() {
		if ( !isset( $this->client ) ) {
			global $wgExactTargetApiConfig, $wgExactTargetSoapOptions;
			$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
			$oClient = new \ExactTargetSoapClient( $wsdl, $wgExactTargetSoapOptions );
			$oClient->username = $wgExactTargetApiConfig[ 'username' ];
			$oClient->password = $wgExactTargetApiConfig[ 'password' ];
			$this->client = $oClient;
		}
		return $this->client;
	}

	private function responseException( $response ) {
		$message = $response && isset( $response->Results->StatusMessage )
			? $response->Results->StatusMessage
			: self::EXACT_TARGET_REQUEST_FAILED;
		$exception = new ExactTargetException( $message );

		$this->error( self::EXACT_TARGET_LABEL, [
			'exception' => $exception,
			'response.overallStatus' => $response && isset ( $response->OverallStatus )
				? $response->OverallStatus : ''
		] );
		return $exception;
	}
}
