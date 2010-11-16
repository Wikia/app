<?php
/**
 * @author Inez Korczyñski
 */

error_reporting(E_ALL);

require_once(dirname(__FILE__)."/../commandLine.inc");

class ResponseTimePingdom {
	
	private $client = null;
	private $sessionId = null;
	private $apikey = null;

	public function __construct($username, $password, $apikey, $proxy_host = null, $proxy_port = null) {
		$this->client = new SoapClient('https://ws.pingdom.com/soap/PingdomAPI.wsdl', array('proxy_host' => $proxy_host, 'proxy_port' => $proxy_port));
		$this->apikey = $apikey;
		
		$login_data->username = $username;
		$login_data->password = $password;

		$login_response = $this->client->Auth_login($this->apikey, $login_data);
		$this->sessionId = $login_response->sessionId;
	}
	
	public function getResponseTime($date, $checkName) {
		$yesterday = strtotime(date('Y-m-d', strtotime($date)));

		$get_responsetimes_request->checkName = $checkName;
		$get_responsetimes_request->from = $yesterday - 86400;
		$get_responsetimes_request->to = $yesterday;
		$get_responsetimes_request->resolution = 'DAILY';
		$get_responsetimes_request->locations = array();;
		$get_responsetimes_response = $this->client->Report_getResponseTimes($this->apikey, $this->sessionId, $get_responsetimes_request);
		
		return $get_responsetimes_response->responseTimesArray[0]->responseTime;
	}
}

$pingdom = new ResponseTimePingdom($wgPingdomLogin, $wgPingdomPassword, $wgPingdomApikey, '127.0.0.1', 6081);

$checkNames = array('glbdns - http', 'glbdns - ping');

foreach($checkNames as $checkName) {
	$date = date('Y-m-d', strtotime('-1 day'));
	
	$responseTime = $pingdom->getResponseTime($date, $checkName);

	$dbw = wfGetDB(DB_MASTER, array(), 'performance_stats');
	$dbw->replace('responsetime', array(), array('checkName' => $checkName, 'responseTime' => $responseTime, 'date' => $date));
}