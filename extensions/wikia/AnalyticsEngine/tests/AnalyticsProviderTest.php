<?php
/**
 * Integragion tests for Analytics Engine
 * User: mech
 * Date: 8/14/12
 * Time: 1:33 PM
 */
class AnalyticsProviderTest extends WikiaBaseTest {

	/**
	 * Check the page source for analytics tracking and return used tag
	 *
	 * @param $url page address to fetch
	 * @return string|null analytics parameter used in this page
	 *
	 */
	private function getAnalyticsProviderTag($url) {
		$page = Http::get($url);
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
			array('http://de.wikia.com/Wikia', 'RC_WIKIA_HOME'),
			
			array('http://de.wikia.com/Spezial:Kontakt', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/%C3%9Cber_Wikia', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/Presse', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/Stellen', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/Projekt:Datenschutz', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/Spezial:Kontakt', 'RC_WIKIA_SVCE'),
			array('http://de.wikia.com/Spezial:UserSignup', 'RC_WIKIA_SVCE'),
 
			array('http://de.wikia.com/Videospiele', 'RC_WIKIA_START'),
			array('http://de.wikia.com/Entertainment', 'RC_WIKIA_START'),
			array('http://de.wikia.com/Lifestyle', 'RC_WIKIA_START'),

			array('http://de.wikia.com/Mobil', 'RC_WIKIA_MOBIL'),
			array('http://de.wikia.com/Mobil/LyricWiki', 'RC_WIKIA_MOBIL'),
			array('http://de.wikia.com/Mobil/GameGuides', 'RC_WIKIA_MOBIL'),

			array('http://de.community.wikia.com/wiki/Admin-Bereich:Hauptseite', 'RC_WIKIA_COMMUNITY'),
			array('http://de.community.wikia.com/wiki/Community_Deutschland', 'RC_WIKIA_COMMUNITY'),
			array('http://de.community.wikia.com/wiki/Blog%3AWikia_Deutschland_News', 'RC_WIKIA_COMMUNITY'),

			array('http://de.wikia.com/index.php?search=elder&fulltext=Search', 'RC_WIKIA_SEARCH'),

			array('http://de.elderscrolls.wikia.com/wiki/Elder_Scrolls_Wiki', 'RC_WIKIA_UGC'),
			array('http://de.swtor.wikia.com/wiki/Star_Wars_-_The_Old_Republic_Wiki', 'RC_WIKIA_UGC'),

			array('http://de.community.wikia.com/wiki/Forum:%C3%9Cbersicht', 'RC_WIKIA_PIN'),

			array('http://shaun.wikia.com/wiki/Shaun', 'RC_WIKIA_UGCENT'),
			array('http://de.marvel-filme.wikia.com/wiki/Marvel-Filme', 'RC_WIKIA_UGCENT'),
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

