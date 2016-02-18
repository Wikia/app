<?php

/**
 * Discussion user log page
 */
class SpecialDiscussionsLogController extends WikiaSpecialPageController {
	// @todo
	//1. Pagination
	//2. Add date range input field

	const PAGINATION_SIZE = 50;
	const DAYS_RANGE = 15;
	const HTTP_STATUS_OK = 200;
	const NO_USER_MATCH_ERROR = "Provided username did not match any user";

	static $inputFormTemplate = 'extensions/wikia/SpecialDiscussionsLog/templates/SpecialDiscussionsLog_inputForm.mustache';
	static $userLogTemplate = 'extensions/wikia/SpecialDiscussionsLog/templates/SpecialDiscussionsLog_userLog.mustache';

	public function __construct() {
		parent::__construct( 'DiscussionsLog' );
	}

	public function execute( $subpage ) {

		if ( !$this->checkAccess() ) {
			throw new \PermissionsError('specialdiscussionslog');
		}

		$this->setHeaders();

		$this->wg->Out->clearHTML();
		$this->wg->Out->setPageTitle( wfMessage( 'discussionslog-pagetitle' )->escaped() );

		$output = $this->getInputForm();

		$userName = null;
		if ( $this->wg->request->wasPosted() ) {
			$userName = $this->wg->request->getVal( 'username', null );
			$output .= $this->getUserLog( $userName );
		}

		$this->wg->Out->addHtml( $output );
	}

	private function getInputForm() {
		return \MustacheService::getInstance()->render(
			self::$inputFormTemplate,
			[
				'userNameLabel' => wfMessage( 'discussionslog-username-label' )
						->escaped(),
				'viewLogsAction' => wfMessage( 'discussionslog-view-logs' )
						->escaped()
			]
		);
	}

	private function constructKibanaUrl( $dayOffset ) {
		global $wgConsulUrl;

		$esUrl = (new  Wikia\Service\Gateway\ConsulUrlProvider( $wgConsulUrl, 'query', 'sjc' ))->getUrl( 'es' );
		$date = time() - ( $dayOffset * 24 * 60 * 60 );

		return 'http://' . $esUrl . '/logstash-' . date( 'Y.m.d', $date ) . '/_search';
	}

	private function getUserIdByUsername( $userName ) {
		if ( empty( $userName ) ) {
			throw new InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		$user = User::newFromName( $userName );
		if ( !$user || empty( $user->getId() ) ) {
			throw new InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		return $user->getId();
	}

	private function getUserLog( $userName ) {
		$userLogRecords = [];
		$displayedUserLogRecords = [];
		$hasNoUserLogRecords = false;
		$hasUserError = false;
		$userId = null;
		$userErrorMessage = null;

		try {
			$userId = $this->getUserIdByUsername( $userName );
		} catch ( Exception $e ) {
			$hasUserError = true;
		}

		if ( $hasUserError !== true ) {
			$userLogRecords = $this->aggregateLogSearches( $userId, $userName );
		}

		if ( count( $userLogRecords ) == 0 ) {
			$hasNoUserLogRecords = true;
		}

		foreach ( $userLogRecords as $userLogRecord ) {
			array_push( $displayedUserLogRecords, [
				'app' => $userLogRecord->app,
				'ip' => $userLogRecord->ip,
				'language' => $userLogRecord->language,
				'location' => $userLogRecord->location,
				'timestamp' => $userLogRecord->timestamp,
				'userAgent' => $userLogRecord->userAgent,
			] );
		}

		return \MustacheService::getInstance()->render(
			self::$userLogTemplate,
			[
				'appHeader' => wfMessage( 'discussionslog-app-header' )
						->escaped(),
				'hasUserError' => $hasUserError,
				'ipAddressHeader' => wfMessage( 'discussionslog-ip-address-header' )
						->escaped(),
				'languageHeader' => wfMessage( 'discussionslog-language-header')
						->escaped(),
				'locationHeader' => wfMessage( 'discussionslog-location-header' )
						->escaped(),
				'logTableCaption' => wfMessage( 'discussionslog-table-caption' )
						->params( [$userName, $userId] )
						->escaped(),
				'userErrorMessage' => wfMessage( 'discussionslog-no-user-match-error' )
						->escaped(),
				'hasNoUserLogRecords' => $hasNoUserLogRecords,
				'noUserLogRecordsMessage' => wfMessage( 'discussionslog-no-mobile-activity-error' )
						->params( $userName )
						->escaped(),
				'timestampHeader' => wfMessage( 'discussionslog-timestamp-header' )
						->escaped(),
				'userAgentHeader' => wfMessage( 'discussionslog-user-agent-header' )
						->escaped(),
				'userLogRecords' => $displayedUserLogRecords
			]
		);
	}

	private function aggregateLogSearches( $userId, $userName ) {
		$logger = Wikia\Logger\WikiaLogger::instance();
		$query = $this->getQuery( $userId );
		$client = new GuzzleHttp\Client();
		$records = [];
		$dayOffset = 0;
		while ( count( $records ) < self::PAGINATION_SIZE && $dayOffset < self::DAYS_RANGE ) {
			$url = $this->constructKibanaUrl( $dayOffset++ );
			try {
				$response = $client->post(
					$url, [
						'body' => $query,
					]
				);
			} catch ( \GuzzleHttp\Exception\RequestException $requestException ) {
				$logger->warning(
					sprintf( 'Request to elasticsearch failed: %s', $requestException->getMessage() )
				);
				break;
			}

			if ( $response->getStatusCode() !== self::HTTP_STATUS_OK ) {
				$logger->warning(
					sprintf( 'Elasticsearch request error; status code %d', $response->getStatusCode() )
				);
				break;
			}

			$resultObject = json_decode( $response->getBody() );
			$hits = $resultObject->hits->hits;

			foreach ( $hits as $hit ) {
				$record = $hit->_source;

				$userLogRecord = new UserLogRecord();
				$userLogRecord->app =
					$record->{'mobile_app.data.app_name'} . ' ' . $record->{'mobile_app.data.app_version'};
				$userLogRecord->ip = $record->{'mobile_app.client_ip'};
				$userLogRecord->language = $record->{'mobile_app.event.device_language'};
				$userLogRecord->location =
					$record->{'mobile_app.geo_ip.city'} . ', ' . $record->{'mobile_app.geo_ip.country_name'};
				$userLogRecord->timestamp = date( DATE_RFC2822, $record->{'mobile_app.event.timestamp'} / 1000 );
				$userLogRecord->userAgent =
					$record->{'mobile_app.data.platform'} . ' ' . $record->{'mobile_app.data.platform_version'};
				$userLogRecord->userId = $userId;
				$userLogRecord->userName = $userName;
				$records[] = $userLogRecord;
			}
		}

		return $records;
	}

	private function getQuery( $userId ) {
		$pagination_size = self::PAGINATION_SIZE;
		return <<<JSON_BODY
{
	"query": {
		"filtered": {
			"query": {
				"bool": {
					"should": [{
						"query_string": {
							"query":"mobile_app.event.user_id:$userId"
						}
					}]
				}
			}
		}
	},
	"size":$pagination_size,
	"sort":[{
		"@timestamp": {
			"order": "desc"
		}
	}]
}
JSON_BODY;
	}

	private function checkAccess() {
		if ( !$this->wg->User->isAllowed('specialdiscussionslog') ) {
			return false;
		}

		return true;
	}
}
