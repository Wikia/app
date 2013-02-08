<?php
class ApiService extends Service {

	/**
	 * string constant for mediawiki api endpoint
	 * @var string
	 */
	const API = 'api.php';
	
	/**
	 * string constant for wikia api endpoint
	 * @var string
	 */
	const WIKIA = 'wikia.php';
	
	/**
	 * Simple wrapper for calling MW API
	 */
	static function call(Array $params) {
		wfProfileIn(__METHOD__);

		$res = false;

		try {
			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();
		}
		catch(Exception $e) {};

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * Do cross-wiki API call
	 *
	 * @param string database name
	 * @param array API query parameters
	 * @param string endpoint (api.php or wikia.php, generally)
	 * @return mixed API response
	 */
	static function foreignCall($dbname, Array $params, $endpoint = self::API) {
		wfProfileIn(__METHOD__);
		$hostName = self::getHostByDbName($dbname);

		// request JSON format of API response
		$params['format'] = 'json';

		$parts = array();
		foreach($params as $key => $value) {
			$parts[] = urlencode($key) . '=' . urlencode($value);
		}

		$url = "{$hostName}/{$endpoint}?" . implode('&', $parts);
		wfDebug(__METHOD__ . ": {$url}\n");

		// send request and parse response
		$resp = Http::get($url);

		if ($resp === false) {
			wfDebug(__METHOD__ . ": failed!\n");
			$res = false;
		}
		else {
			$res = json_decode($resp, true /* $assoc */);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Get domain for a wiki using given database name
	 *
	 * @param string database name
	 * @return string HTTP domain
	 */
	private static function getHostByDbName($dbname) {
		global $wgDevelEnvironment, $wgDevelEnvironmentName;
		if (!empty($wgDevelEnvironment)) {
			$hostName = "http://{$dbname}.{$wgDevelEnvironmentName}.wikia-dev.com";
		}
		else {
			$cityId = WikiFactory::DBtoID($dbname);
			$hostName = WikiFactory::getVarValueByName('wgServer', $cityId);
		}

		return rtrim($hostName, '/');
	}
}