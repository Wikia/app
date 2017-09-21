<?php

use Swagger\Client\OnSiteNotifications\Api\MaintenanceApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;
use \Wikia\Logger\WikiaLogger;

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

require_once(dirname(__FILE__) . '/../../Maintenance.php');

class deleteOldOnSiteNotifications extends Maintenance {

	const SERVICE_NAME = "on-site-notifications";
	const TIMEOUT = 15;
	const REQUIRED_HEADER_ARG = 1;
	const NO_CONTENT = 204;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Clears out old entries from the on-site notifications service";
	}

	public function execute() {
		$api = $this->getMaintenanceApi();
		try {
			$startTime = microtime( true );
			list( $notUsed, $statusCode, $httpHeader ) = $api->clearOldNotificationsWithHttpInfo( self::REQUIRED_HEADER_ARG );
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
		WikiaLogger::instance()->info( 'ONSITE_NOTIFICATIONS Successfully cleared old notifications',
			[
				'elapsedTime' => microtime( true ) - $startTime
			]
		);
	}

	private function logFailure( $statusCode, $httpHeader ) {
		WikiaLogger::instance()->error( 'ONSITE_NOTIFICATIONS Unable to clear old notifications',
			[
				'status_code' => $statusCode,
				'httpHeader' => $httpHeader
			]
		);
	}

	private function logException( Exception $e ) {
		WikiaLogger::instance()->error( 'ONSITE_NOTIFICATIONS exception occurred when attempting to clear old notifications',
			[
				'exception' => $e
			]
		);
	}

	private function getMaintenanceApi(): MaintenanceApi {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		$api = $apiProvider->getApi(self::SERVICE_NAME, MaintenanceApi::class);
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}

}

$maintClass = "deleteOldOnSiteNotifications";
require_once(RUN_MAINTENANCE_IF_MAIN);
