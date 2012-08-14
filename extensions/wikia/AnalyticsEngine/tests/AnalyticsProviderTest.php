<?php
/**
 * Integragion tests for Analytics Engine
 * User: mech
 * Date: 8/14/12
 * Time: 1:33 PM
 */
class AnalyticsProviderTest extends WikiaBaseTest {

	/**
	 * given an URL, fetch the page source
	 *
	 * @param $url page address
	 * @return mixed page content
	 */
	private function fetch_page($url)
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	/**
	 * Check the page source for analytics tracking and return used tag
	 *
	 * @param $url page address to fetch
	 * @return string|null analytics parameter used in this page
	 *
	 */
	private function getAnalyticsProviderTag($url) {
		$page = $this->fetch_page($url);
		if (preg_match('/<img src="([^">]+)" [^>]+ alt="szmtag"/', $page, $m)) {
			$path = parse_url($m[1], PHP_URL_PATH);
			return array_pop(explode('/', $path));
		} else {
			$this->fail('Cannot find the analytics image on page ' . $url);
		}
	}

	/**
	 * Return test data for testAnalyticsProviderIVW test
	 * @static
	 * @return array
	 */
	public static function analyticsDataProvider()
	{
		return array(
			array('http://shaun.wikia.com/wiki/Shaun', 'RC_WIKIA_UGCENT'),
			array('http://de.wikia.com/Videospiele', 'RC_WIKIA_START'),
		);
	}

	/**
	 * Test the IVW provider
	 * @param $url page address
	 * @param $result expected result
	 * @group Infrastructure
	 * @dataProvider analyticsDataProvider
	 */
	public function testAnalyticsProviderIVW($url, $result) {
		$this->assertEquals($this->getAnalyticsProviderTag($url), $result);
	}
}

