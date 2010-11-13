<?php
/**
 * @author Inez Korczyñski
 */

error_reporting(E_ALL);

require_once(dirname(__FILE__)."/../commandLine.inc");
require_once(dirname(__FILE__)."/../../lib/gapi/gapi.class.php");

class GoogleAnalyticsPageSpeed {
	
	private $profileId = null;
	private $gapi = null;
	
	public function __construct($login, $password, $profileId, $proxy = null) {
		$this->gapi = new gapi($login, $password, null, 'curl', $proxy);
		$this->profileId = $profileId;
	}
	
	private function getGAResultSet($date, $i) {
		$limit = 2000;
		$start = $i * $limit + 1;

		$this->gapi->requestReportData($this->profileId, array('pagePath', 'hour'), array('pageviews'), array('pageviews'), 'pagePath=~^\/oasis.* && pageviews >= 100',	$date, $date, $start, $limit);
		return $this->gapi->getResults();
	}
	
	public function getResults($date) {

		$results = array();

		$i = 0;

		do {

			$resultSet = $this->getGAResultSet($date, $i);
			
			foreach($resultSet as $result) {
				
				$loadtime = null;
				$hour = $result->getHour();
				$pageviews = $result->getPageviews();

				$pagePath = split('/', $result);
				if(count($pagePath) == 3) {
					if($pagePath[2] >= 0) {
						$loadtime = $pagePath[2] * 1000;
					}
				} else if(count($pagePath) == 4) {
					if($pagePath[2] >= 0 && $pagePath[3] >= 0 &&  $pagePath[3] < 10) {
						$loadtime = $pagePath[2] * 1000 + $pagePath[3] * 100;
					}
				}
				
				if($loadtime !== null) {
					if(!isset($results[$hour])) {
						$results[$hour] = array();
					}
					if(!isset($results[$hour][$loadtime])) {
						$results[$hour][$loadtime] = 0;
					}	
					$results[$hour][$loadtime] += $pageviews;
				}

			}
			$i++;

		} while (count($resultSet) > 0);

		return $results;

	}
	
	public function getReport($data, $thresholds) {
		$report = array();
		
		foreach($data as $hour => $results) {
			$report[$hour] = $this->getOneReport($results, $thresholds);
		}
		
		ksort($report);

		return $report;
	}
	
	private function getOneReport($data, $thresholds) {
		$onereport = array();
		ksort($data);
		$visits = array_sum($data);

		foreach($thresholds as $relative) {
			$onereport[] = array(	'relative' => $relative,
									'absolute' => (int) ($relative * 0.01 * $visits));
		}
		
		$i = 0;
		foreach($data as $loadtime => $pageviews) {
			$i += $pageviews;
			
			foreach($onereport as $key => &$val) {
				if(!isset($val['loadtime'])) {
					if($i >= $val['absolute']) {
						$val['loadtime'] = $loadtime;
					}
				}
			}
		}

		return $onereport;
	}

}

function loadData($date) {
	global $wgWikiaGALogin, $wgWikiaGAPassword;
	$ga = new GoogleAnalyticsPageSpeed($wgWikiaGALogin, $wgWikiaGAPassword, '19262743', '127.0.0.1:6081');
	$results = $ga->getResults($date);
	$report = $ga->getReport($results, array(99, 95, 75, 50));
	
	$dbw = wfGetDB(DB_MASTER, array(), 'stats');

	foreach($report as $hour => $val) {
		foreach($val as $data) {
			$dbw->replace('pagespeed', array(), array(
				'date' => "{$date} {$hour}:00:00",
				'relative' => $data['relative'],
				'absolute' => $data['absolute'],
				'loadtime' => $data['loadtime']));
		}
		
	}
	
}

//loadData('2010-11-11');