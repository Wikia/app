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

	public function deleteSubscriber() {

	}

	protected function sendRequest( $sType, $oRequestObject ) {
		try {
			$oResults = $this->getClient()->$sType( $oRequestObject );
			WikiaLogger::instance()->info( $this->getClient()->__getLastResponse() );
			return $oResults;
		} catch ( \SoapFault $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
			return false;
		}
	}

	protected function getClient() {
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
