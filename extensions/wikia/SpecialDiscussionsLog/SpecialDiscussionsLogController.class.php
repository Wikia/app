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
		return '<form method="post">
<label for="username">Username: </label>
<input id="username" name="username" type="text" required>
<input type="submit" value="View Logs"></form><br>';
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
		try {
			$userId = $this->getUserIdByUsername( $userName );
		} catch ( Exception $e ) {
			return "<p>{$e->getMessage()}</p>";
		}
		$userLogRecords = $this->aggregateLogSearches( $userId, $userName );
		if ( count( $userLogRecords ) == 0 ) {
			return "<p>No mobile app activity by $userName in the past two weeks!</p>";
		}

		$resultHtml = "<p>Log data for user \"$userName\" (ID: $userId)</p>";
		$resultHtml .= '<table>
  <thead>
    <tr>
      <th style="padding-right:8px">IP Address</th>
      <th style="padding-right:8px">Location</th>
      <th style="padding-right:8px">Language</th>
      <th style="padding-right:8px">User Agent</th>
      <th style="padding-right:8px">App</th>
      <th style="padding-right:8px">Timestamp</th>
    </tr>
  </thead>';

		foreach ( $userLogRecords as $userLogRecord ) {
			$resultHtml .= "<tr>
				<td style=\"padding-right:8px\">{$userLogRecord->getIp()}</td>
				<td style=\"padding-right:8px\">{$userLogRecord->getLocation()}</td>
				<td style=\"padding-right:8px\">{$userLogRecord->getLanguage()}</td>
				<td style=\"padding-right:8px\">{$userLogRecord->getUserAgent()}</td>
				<td style=\"padding-right:8px\">{$userLogRecord->getApp()}</td>
				<td style=\"padding-right:8px\">{$userLogRecord->getTimestamp()}</td>
			</tr>";
		}
		$resultHtml .= '</table>';

		return $resultHtml;
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
