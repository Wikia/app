<?php
class OnlineStatusTest extends PHPUnit_Framework_TestCase {
	/**
	 * @group Monitoring
	 * @dataProvider websitesProvider
	 */
	public function testWebsiteIsNotDown($website) {
		$searchText = '<h1>Wikia</h1>';
		$this->assertTrue($this->isOnline($website, $searchText), sprintf('Website "%s" is down', $website));
	}
	
	public function websitesProvider() {
		global $config;
		$data = array();
		foreach ($config->onlineStatus->website as $website) {
			$data[$website] = array($website);
		}
		return $data;
	}
	
	private function isOnline($url, $searchText) {
		$defaults = array(
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $url,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_FOLLOWLOCATION => 1
		);
		$retries = 3;
		
		do {
			$retries--;
			$ch = curl_init();
			curl_setopt_array($ch, $defaults);
			$result = curl_exec($ch);
			$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			$error = curl_error($ch);
			
			$result = $error == ''
				&& $httpCode == 200
				&& strpos($result, $searchText) !== false;
			if (!$result) {
				sleep(1);
			}
		} while ($result === false && $retries >= 0);
		
		return $result;
	}
}
