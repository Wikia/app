<?php

use Swagger\Client\Swagger\Client\CurationCMS\Api\TopicsApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;
use \Wikia\Logger\WikiaLogger;

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

require_once(dirname(__FILE__) . '/../../Maintenance.php');

class updateCurationCMSTopicRanks extends Maintenance {

	const SERVICE_NAME = "curation-cms";
	const TIMEOUT = 60;
	const NO_CONTENT = 204;

	const SUCCESS_MESSAGE = "Updated topic ranks in the Curation CMS";
	const FAILURE_MESSAGE = "Got bad status when trying to update topic ranks";
	const EXCEPTION_MESSAGE = "An unknown error occurred while updating topic ranks";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Trigger the Curation CMS to update its Topic rankings";
	}

	public function execute() {
		$api = $this->getTopicsApi();
		try {
			$startTime = microtime( true );
			list( $notUsed, $statusCode, $httpHeader ) = $api->updateRank();
			if ( $statusCode == self::NO_CONTENT ) {
				$this->logSuccess( $startTime );
			} else {
				$this->logFailure( $statusCode, $httpHeader );
			}
		} catch ( Exception $e ) {
			$this->logException( $e );
		}
	}

	private function logSuccess( $startTime ) {
		WikiaLogger::instance()->info( self::SUCCESS_MESSAGE,
			[
				'elapsedTime' => microtime( true ) - $startTime
			]
		);
	}

	private function logFailure( $statusCode, $httpHeader ) {
		WikiaLogger::instance()->error( self::FAILURE_MESSAGE,
			[
				'status_code' => $statusCode,
				'httpHeader' => $httpHeader
			]
		);
	}

	private function logException( Exception $e ) {
		WikiaLogger::instance()->error( self::EXCEPTION_MESSAGE,
			[
				'exception' => $e
			]
		);
	}

	private function getTopicsApi(): TopicsApi {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		$api = $apiProvider->getApi(self::SERVICE_NAME, TopicsApi::class);
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}
}

$maintClass = "updateCurationCMSTopicRanks";
require_once(RUN_MAINTENANCE_IF_MAIN);
