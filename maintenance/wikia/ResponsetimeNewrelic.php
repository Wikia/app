<?php

/* Fetch dashboard information from newrelic and insert into stats db
 * Author: Owen Davis
 *
 * DB schema in performance_stats database
 *
 * CREATE TABLE `newrelic` (
 * `date` datetime NOT NULL,
 * `response_time` int(11) NOT NULL,
 * `error_count` decimal(11,2) DEFAULT NULL,
 * `request_count` int(11) NOT NULL,
 * PRIMARY KEY (`date`)
 * ) ENGINE=InnoDB
 *
 */

error_reporting(E_ALL);

require_once(dirname(__FILE__)."/../commandLine.inc");

class ResponseTimeNewRelic {
	private $licenceKey = "";
	private $appID = "";
	private $accountID = "";
	private $summaryDataURL = "https://rpm.newrelic.com/accounts/:account_id/applications/:app_id/threshold_values.xml";

	public function __construct ($accountID, $appID, $licenceKey) {
		$this->appID = $appID;
		$this->accountID = $accountID;
		$this->licenceKey = $licenceKey;
		$this->summaryDataURL = str_replace(array(':account_id', ':app_id'), array($accountID, $appID), $this->summaryDataURL);
	}

	public function getData () {

		// Crazy workaround for HttpRequest not accepting user options
		$req = MWHttpRequest::factory( $this->summaryDataURL, array ('method' => "GET", 'timeout' => 'default') );
		$req->setHeader("http-x-license-key", $this->licenceKey);
		$status = $req->execute();
		$response = $req->getContent();
		$data = array();

		if ($response) {
			// chop up xml
			$xml = simplexml_load_string($response);
			$data = array();
			foreach ($xml->threshold_value as $node) {
				$label = (string)$node['name'];

				// just grab the time from the first field since we are rounding to the nearest hour anyway
				if (empty($data['Time'])) {
					$time = (string)$node['end_time'];
					$date = strtotime($time);  // raw mysql date format should parse ok
					$data['Time'] = $date;
				}
				// we only want to use some of the fields returned from new relic
				if (in_array($label, array('Errors', 'Response Time', 'Throughput')))
					$data[$label] = (string)$node['metric_value'];
			}
		} else {
//			print_pre("null response from newrelic");
		}
		return $data;
	}

	public function saveData ($data) {

		if (empty($data)) return false;

		// 2011-01-01 01:00:00 collect stats once an hour for now
		$formatted_date = date("Y-m-d H", $data['Time']) . ":00:00";
		$dbw = wfGetDB(DB_MASTER, array(), 'performance_stats');
		$dbw->replace('newrelic', array(), array('date' => $formatted_date, 'response_time' => $data['Response Time'], 'error_count' => $data['Errors'], 'request_count' => $data['Throughput']));

		return true;
	}
}

// newrelic AccountID, AppID, LicenceKey are defined in CommonSettings.php
// Request has to go directly through squid because it is https so we override CommonSettings value here
$wgHTTPProxy = "squid-proxy.local:3128";

// Simple driver
$rt = new ResponseTimeNewRelic($wgNewRelicAccountID, $wgNewRelicAppID, $wgNewRelicLicenceKey);
$data = $rt->getData();
$rt->saveData($data);


