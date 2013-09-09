<?php
/**
 * Integragion tests for Analytics Engine
 * User: mech
 * Date: 8/14/12
 * Time: 1:33 PM
 *
 * @group Integration
 */
class AnalyticsProviderIVWTest extends WikiaBaseTest {

	/**
	 * Check the page source for analytics tracking and return used tag
	 *
	 * @param $url page address to fetch
	 * @return string|null analytics parameter used in this page
	 *
	 */
	private function getAnalyticsProviderIVWTag($url) {
		$page = Http::get($url, 'default', array('noProxy' => true));
		if (preg_match('/<img src="([^">]+)" [^>]+ alt="szmtag"/', $page, $m)) {
			$path = parse_url($m[1], PHP_URL_PATH);
			$arr = explode('/', $path);
			return array_pop($arr);
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

			array('http://de.wikia.com/Spezial:Suche?search=elder&fulltext=Search', 'RC_WIKIA_SEARCH'),

			array('http://de.elderscrolls.wikia.com/wiki/Elder_Scrolls_Wiki', 'RC_WIKIA_UGCGAMES'),
			array('http://de.swtor.wikia.com/wiki/Star_Wars_-_The_Old_Republic_Wiki', 'RC_WIKIA_UGCGAMES'),

			array('http://de.community.wikia.com/wiki/Forum:%C3%9Cbersicht', 'RC_WIKIA_PIN'),

			array('http://shaun.wikia.com/wiki/Shaun', 'RC_WIKIA_UGCENT'),
			array('http://de.marvel-filme.wikia.com/wiki/Marvel-Filme', 'RC_WIKIA_UGCENT'),

			array('http://de.gta.wikia.com/wiki/Hauptseite', 'RC_WIKIA_UGCGAMES'),
			array('http://de.green.wikia.com/wiki/Hauptseite', 'RC_WIKIA_UGCLIFESTYLE'),
			array('http://de.naruto.wikia.com/wiki/Narutopedia', 'RC_WIKIA_UGCANIME'),

			array('http://de.wikia.com/Entertainment/Anime', 'RC_WIKIA_START'),
		);
	}

	/**
	 * Test the IVW provider
	 * @param $url string page address
	 * @param $result string expected result
	 * @group Infrastructure
	 * @dataProvider analyticsDataProvider
	 */
	public function testAnalyticsProviderIVW($url, $result) {
		$this->assertEquals($result, $this->getAnalyticsProviderIVWTag($url));
	}
}