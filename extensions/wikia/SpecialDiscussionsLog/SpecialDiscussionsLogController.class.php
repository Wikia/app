<?php

/**
 * Discussion user log page
 */
class SpecialDiscussionsLogController extends WikiaSpecialPageController {
	// @todo
	//1. Pagination
	//2. Add date range input field
	//3. Use handlebar templates

	const KIBANA_BASEURL = 'http://query.es.service.sjc.consul:9200';
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
			return;
		}

		$this->setHeaders();

		$this->wg->Out->clearHTML();
		$this->wg->Out->setPageTitle( wfMessage( 'discussionslog-pagetitle' )->plain() );

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
			[]
		);
	}

	private function constructKibanaUrl( $dayOffset ) {
		$date = time() - ( $dayOffset * 24 * 60 * 60 );
		return self::KIBANA_BASEURL . '/logstash-' . date( 'Y.m.d', $date ) . '/_search';
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
		$userErrorMessage = null;
		$noUserLogRecords = false;
		$displayedUserLogRecords = [];
		$userId = null;
		$userErrorMessage = '';

		try {
			$userId = $this->getUserIdByUsername( $userName );
		} catch ( Exception $e ) {
			$userErrorMessage = $e->getMessage();
		}

		$userLogRecords = $this->aggregateLogSearches( $userId, $userName );

		if ( count( $userLogRecords ) == 0 ) {
			$noUserLogRecords = true;
		}

		foreach ( $userLogRecords as $userLogRecord ) {
			array_push( $displayedUserLogRecords, [
				'ip' => $userLogRecord->getIp(),
				'location' => $userLogRecord->getLocation(),
				'language' => $userLogRecord->getLanguage(),
				'userAgent' => $userLogRecord->getUserAgent(),
				'app' => $userLogRecord->getApp(),
				'timestamp' => $userLogRecord->getTimestamp(),
			] );
		}

		return \MustacheService::getInstance()->render(
			self::$userLogTemplate,
			[
				'userName' => $userName,
				'userId' => $userId,
				'userErrorMessage' => $userErrorMessage,
				'noUserLogRecords' => $noUserLogRecords,
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
				continue;
			}

			if ( $response->getStatusCode() !== self::HTTP_STATUS_OK ) {
				$logger->warning(
					sprintf( 'Elasticsearch request error; status code %d', $response->getStatusCode() )
				);
				continue;
			}

			$resultObject = json_decode( $response->getBody() );
			$hits = $resultObject->hits->hits;
			foreach ( $hits as $hit ) {
				$record = $hit->_source;

				$userLogRecord = new UserLogRecord();
				$userLogRecord->setApp(
					$record->{'mobile_app.data.app_name'} . ' ' . $record->{'mobile_app.data.app_version'}
				);
				$userLogRecord->setIp( $record->{'mobile_app.client_ip'} );
				$userLogRecord->setLanguage( $record->{'mobile_app.event.device_language'} );
				$userLogRecord->setLocation(
					$record->{'mobile_app.geo_ip.city'} . ', ' . $record->{'mobile_app.geo_ip.country_name'}
				);
				$userLogRecord->setTimestamp( date( DATE_RFC2822, $record->{'mobile_app.event.timestamp'} / 1000 ) );
				$userLogRecord->setUserAgent(
					$record->{'mobile_app.data.platform'} . ' ' . $record->{'mobile_app.data.platform_version'}
				);
				$userLogRecord->setUserId( $userId );
				$userLogRecord->setUserName( $userName );
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
		if ( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed( 'forumadmin' ) ) {

			$this->wg->Out->clearHTML();
			$this->wg->Out->setPageTitle( wfMessage( 'badaccess' )->plain() );
			$this->wg->Out->addHTML( wfMessage( 'badaccess' )->parse() );

			return false;
		}

		return true;
	}
}
