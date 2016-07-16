<?php
use Wikia\SpecialDiscussionsLog\Search\IpAddressQuery;
use Wikia\SpecialDiscussionsLog\Search\UserQuery;

/**
 * Discussion user log page
 */
class SpecialDiscussionsLogController extends WikiaSpecialPageController {
	// @todo
	//1. Pagination
	//2. Add date range input field

	const PAGINATION_SIZE = 50;
	const REQUEST_SIZE = 200;
	const DAYS_RANGE = 15;
	const HTTP_STATUS_OK = 200;
	const NO_USER_MATCH_ERROR = 'discussionslog-no-user-match-error';
	const DISCUSSIONS_LOG_ACTION = 'specialdiscussionslog';

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $logger;
	private $users;
	private $domainCache;

	public function __construct() {
		parent::__construct( 'DiscussionsLog', '', false );
		$this->users = [];
		$this->domainCache = [];
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	public function index() {
		$this->checkAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_log_scss' );

		$this->wg->Out->addModules( 'ext.wikia.SpecialDiscussionsLog' );

		$this->wg->Out->setPageTitle( wfMessage( 'discussionslog-page-title' )->escaped() );

		$userName = $this->getVal( UserQuery::getKeyName() );
		$ipAddress = $this->getVal( IpAddressQuery::getKeyName() );

		if ( !empty( $userName ) && !empty( $ipAddress ) ) {
			throw new \InvalidArgumentException( 'discussionslog-multiple-input-error' );
		}

		$requestParams = $this->request->getParams();
		$this->response->setVal( 'inputForm', $this->sendSelfRequest( 'inputForm', $requestParams ) );
		$this->response->setVal( 'userLog', $this->sendSelfRequest( 'userLog', $requestParams ) );
	}

	public function inputForm() {
		$userName = $this->getVal( UserQuery::getKeyName() );
		$ipAddress = $this->getVal( IpAddressQuery::getKeyName() );

		$this->response->setValues( [
			'userName' => $userName,
			'ipAddress' => $ipAddress,
			'userNameLabel' => wfMessage( 'discussionslog-username-label' )->escaped(),
			'ipAddressLabel' => wfMessage( 'discussionslog-ip-address-header' )->escaped(),
			'orLabel' => wfMessage( 'discussionslog-or-label' )->escaped(),
			'viewLogsAction' => wfMessage( 'discussionslog-view-logs' )->escaped(),
		] );
	}

	private function constructKibanaUrl( $dayOffset ) {
		global $wgConsulUrl;

		$esUrl = (new Wikia\Service\Gateway\ConsulUrlProvider( $wgConsulUrl, 'query', 'sjc' ))->getUrl( 'es' );
		$date = time() - ( $dayOffset * 24 * 60 * 60 );

		return 'http://' . $esUrl . '/logstash-' . date( 'Y.m.d', $date ) . '/_search';
	}

	private function getUserByUsername( $userName ) {
		if ( empty( $userName ) ) {
			throw new \InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		$user = User::newFromName( $userName );
		if ( !$user ) {
			throw new \InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		return $user;
	}

	private function getUserById( $userId ) {
		if ( !$userId ) {
			throw new \InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		// Look at cache first
		if ( !empty( $this->users[ $userId ] ) ) {
			return $this->users[$userId];
		}

		$user = User::newFromId( $userId );
		if ( !$user ) {
			throw new \InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		$user->load();

		// Anonymous users can't have contributions
		if ( $user->mName === false ) {
			throw new \InvalidArgumentException( self::NO_USER_MATCH_ERROR );
		}

		$this->users[ $user->getId() ] = $user;

		return $user;
	}

	public function userLog() {
		$this->checkAccess();

		$userName = $this->getVal( UserQuery::getKeyName() );
		$ipAddress = $this->getVal( IpAddressQuery::getKeyName() );

		$userLogRecords = [];
		$userId = null;

		if ( !empty( $userName ) ) {
			try {
				$userId = $this->getUserByUsername( $userName )->getId();
			} catch ( \Exception $e ) {
				$userId = null;
			}

			if ( $userId ) {
				$userLogRecords = $this->aggregateLogByUserId( $userId );
				$this->response->setValues( [
						'logTableCaption' => wfMessage( 'discussionslog-table-caption' )
							->params( [ $userName, $userId ] )
							->escaped(),

						'noUserLogRecordsMessage' => wfMessage( 'discussionslog-no-contributions-error' )
							->params( $userName )
							->escaped(),
				] );
			} else {
				$this->response->setVal(
					'userErrorMessage',
					wfMessage( self::NO_USER_MATCH_ERROR )->escaped() );
			}

		} else if ( !empty( $ipAddress ) ) {
			if ( IP::isValid( $ipAddress ) ) {
				$userLogRecords = $this->aggregateLogByIpAddress( $ipAddress );

				$this->response->setValues( [
						'logTableCaption' => wfMessage( 'discussionslog-table-ip-caption' )
							->params( [ $ipAddress ] )
							->escaped(),

						'noUserLogRecordsMessage' => wfMessage( 'discussionslog-no-ip-activity-error' )
							->params( $ipAddress )
							->escaped(),
				] );
			} else {
				$this->response->setVal(
					'userErrorMessage',
					wfMessage( 'discussionslog-ip-invalid-error' )->escaped() );
			}

		}

		$this->response->setValues( [
			'hasNoUserLogRecords' => empty( $userLogRecords ),
			'userLogRecords' => $this->buildDisplayedUserLogRecords( $userLogRecords ),
			'siteHeader' => wfMessage( 'discussionslog-site-header' )->escaped(),
			'userNameHeader' => wfMessage( 'discussionslog-user-name-header' )->escaped(),
			'ipAddressHeader' => wfMessage( 'discussionslog-ip-address-header' )->escaped(),
			'locationHeader' => wfMessage( 'discussionslog-location-header' )->escaped(),
			'timestampHeader' => wfMessage( 'discussionslog-timestamp-header' )->escaped(),
			'userAgentHeader' => wfMessage( 'discussionslog-user-agent-header' )->escaped(),
		] );
	}

	private function buildDisplayedUserLogRecords( array $userLogRecords ) {
		$displayedUserLogRecords = [ ];
		foreach ( $userLogRecords as $userLogRecord ) {
			array_push(
				$displayedUserLogRecords, [
					'userName' => $userLogRecord->user->getName(),
					'userUrl' => $this->getTitle()->getLocalURL(
						[ UserQuery::getKeyName() => $userLogRecord->user->getName() ]
					),
					'site' => $userLogRecord->site,
					'ip' => $userLogRecord->ip,
					'ipUrl' => $this->getTitle()->getLocalURL( [ IpAddressQuery::getKeyName() => $userLogRecord->ip ] ),
					'locationUrl' => 'https://geoiptool.com/en/?ip=' . $userLogRecord->ip,
					'moreInfoMsg' => wfMessage( 'discussionslog-more-info' )->escaped(),
					'timestamp' => $userLogRecord->timestamp,
					'userAgent' => $userLogRecord->userAgent,
				]
			);
		}
		return $displayedUserLogRecords;
	}

	private function aggregateLogByUserId( $userId ) {
		$query = UserQuery::getQuery( $userId, self::REQUEST_SIZE );
		return $this->aggregateSearchLogs( $query );
	}

	private function aggregateLogByIpAddress( $ipAddress ) {
		$query = IpAddressQuery::getQuery( $ipAddress, self::REQUEST_SIZE );
		return $this->aggregateSearchLogs( $query );
	}

	private function aggregateSearchLogs( $query ) {
		$records = [];
		$dayOffset = 0;
		$uniqueRecordChecker = [];

		while ( count( $records ) < self::PAGINATION_SIZE && $dayOffset < self::DAYS_RANGE ) {
			$url = $this->constructKibanaUrl( $dayOffset++ );
			$response = $this->getSearchResults( $url, $query );
			if ( !$response ) {
				break;
			}

			$this->appendRecordsFromResponse( $records, $response, $uniqueRecordChecker );
		}

		krsort( $records, SORT_NUMERIC );
		return $records;
	}

	private function getSearchResults( $url, $query ) {
		$client = new \GuzzleHttp\Client();

		try {
			$response = $client->post(
				$url, [
					'body' => $query,
				]
			);
		} catch ( \GuzzleHttp\Exception\RequestException $requestException ) {
			$this->logger->error(
				sprintf( 'Request to elasticsearch failed: %s', $requestException->getMessage() ),
				[ 'exception' => $requestException ]
			);
			return false;
		}

		if ( $response->getStatusCode() !== self::HTTP_STATUS_OK ) {
			$this->logger->error(
				sprintf( 'Elasticsearch request error; status code %d', $response->getStatusCode() )
			);
			return false;
		}

		return $response;
	}

	private function appendRecordsFromResponse( array &$records, $response, array &$uniqueRecordChecker  ) {

		$resultObject = json_decode( $response->getBody() );
		$hits = $resultObject->hits->hits;

		foreach ( $hits as $hit ) {
			$record = $hit->_source;
			$ip = $record->{'fastly_client_ip'};
			$site = $record->{'site_id'};
			$userId = $record->{'user_id'};
			$recordHash = sprintf( '%s:%s:%s', $ip, $site, $userId );

			if ( $uniqueRecordChecker[$recordHash] === true ) {
				continue;
			}

			$uniqueRecordChecker[$recordHash] = true;

			try {
				$user = $this->getUserById( $userId );
			} catch ( \Exception $e ) {
				$this->logger->error(
					sprintf( 'User not found: %s', $e->getMessage() ),
					[ 'exception' => $e ]
				);
				continue;
			}

			if ( !isset($domainCache[$site]) ) {
				$cityTitle = WikiFactory::getWikiByID($site)->city_title;
				$wikiDomain = preg_replace('#^https?://#', '', WikiFactory::getHostById($site));
				if ( empty($cityTitle) && empty($wikiDomain) ) {
					// most likely from a different environment (e.g. prod contribution when this is on dev, or vice versa)
					$this->logger->warning(sprintf( 'Site not found: %d', $site ));
					continue;
				} else {
					$domainCache[$site] = sprintf( '%s (%s)', $cityTitle, $wikiDomain );
				}
			}


			$timestamp = strtotime($record->{'@timestamp'});

			$userLogRecord = new UserLogRecord();
			$userLogRecord->site = $domainCache[$site];
			$userLogRecord->ip = $ip;
			$userLogRecord->timestamp = date(DATE_RFC2822, $timestamp);
			$userLogRecord->userAgent = $record->{'user_agent'};
			$userLogRecord->user = $user;

			$records[$timestamp] = $userLogRecord;
		}
	}

	private function checkAccess() {
		if ( !$this->wg->User->isAllowed( self::DISCUSSIONS_LOG_ACTION ) ) {
			throw new \PermissionsError( self::DISCUSSIONS_LOG_ACTION );
		}
	}
}
