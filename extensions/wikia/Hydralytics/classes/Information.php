<?php
/**
 * Curse Inc.
 * Hydralytics
 * Information Class
 *
 * @author		Alexia E. Smith
 * @copyright	(c) 2018 Curse Inc.
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
 * @link		https://gitlab.com/hydrawiki
 *
 **/

namespace Hydralytics;

class Information {
	// by default plot last X days of data
	const LAST_DAYS = 30;

	/**
	 * Property Being Used for GA
	 *
	 * @var 	string
	 */
	static private $property = null;

	/**
	 * Extract a single Google Analytics property that should be the one for this wiki from a list.
	 *
	 * @access	public
	 * @param	string	Newline separated property IDs.
	 * @return	string	Google Analytics Property ID
	 */
	static public function extractGAProperty($properties) {
		$config = \ConfigFactory::getDefaultInstance()->makeConfig('main');
		$stripGAProperties = $config->get('StripGAProperties');
		foreach ($stripGAProperties as $property) {
			$properties = str_replace($property, '', $properties);
		}
		$properties = trim($properties);
		list($property) = explode("\n", $properties);
		return $property;
	}

	/**
	 * Return the property we have set
	 *
	 * @return string
	 */
	static public function getProperty() {
		return self::$property;
	}

	/**
	 * Get the wiki managers on this wiki.
	 *
	 * @access	public
	 * @return	array	Wiki Managers
	 */
	static public function getWikiManagers() {
		global $wgWikiManagers;
		return (array) $wgWikiManagers;
	}

	/**
	 * Get a link to the FAQ page.
	 *
	 * @access	public
	 * @return	string	HTML Link
	 */
	static public function getFaqLink() {
		return \Linker::makeExternalLink(
			'link to faq TODO',
			wfMessage('hlfaqurl-text')
		);
	}

	/**
	 * Get a link to the Feedback page.
	 *
	 * @access	public
	 * @return	string	HTML Link
	 */
	static public function getFeedbackLink() {
		return \Linker::makeExternalLink(
			'feedback link TODO',
			wfMessage('hlfeedbackurl-text')
		);
	}

	/**
	 * Get a link to the Slack page.
	 *
	 * @access	public
	 * @return	string	HTML Link
	 */
	static public function getSlackLink() {
		return \Linker::makeExternalLink(
			'slack link todo',
			wfMessage('hlslackurl-text')
		);
	}

	/**
	 * Get the number of edit per day for this wiki over the past X days.
	 *
	 * @access	public
	 * @param	integer	[Optional] Number of days in the past to retrieve.
	 * @return	array	[day timestamp => points]
	 */
	static public function getEditsPerDay($days = 30) {
		return self::getMockedSine($days, 10, 200);
	}

	/**
	 * Get the top editors for the wiki over all time or optionally with monthly counts.
	 *
	 * @access	public
	 * @param	boolean	[Optional] Group by month.
	 * @return	array	[['points' => 0, 'month' => null for global or month display, 'user' => User object]]
	 */
	static public function getTopEditors($isMonthly = false) {
		return [
			['points' => 40, 'month' => ($isMonthly ? '2019-05' : null), 'user' => ['user-page' => 'active-editor']]
		];
	}

	/**
	 * Get the percentage of edits per day, logged in and out, for this wiki over the past X days.
	 *
	 * @access	public
	 * @param	integer	[Optional] Number of days in the past to retrieve.
	 * @return	array	[day timestamp => points]
	 */
	static public function getEditsLoggedInOut($days = 30) {
		return [
			'in' => self::getMockedSine($days, 5, 20),
			'out' => self::getMockedSine($days, 15, 50)
		];
	}

	/**
	 * Return the top searchs by rank for the given time period.
	 *
	 * @access	public
	 * @param	int $limit
	 * @return	array	Top search terms by rank in descending order.  [[rank, term], [rank, term]]
	 */
	static public function getTopSearchTerms($limit = 10) {
		global $wgCityId;

		$res = Redshift::query(
			'SELECT search_phrase, COUNT(*) as search_count FROM wikianalytics.searches ' .
			'WHERE wiki_id = :wiki_id GROUP BY search_phrase  ' .
			'ORDER BY search_count DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$phrases = [];
		foreach($res as $row) {
			// e.g. foo -> 5765
			$phrases[ $row->search_phrase ] = $row->search_count;
		}

		return $phrases;
	}

	/**
	 * Return geolocation data.
	 *
	 * @access	public
	 * @param	int $limit
	 * @return	array	Geolocation by: [percentage => Country Code]
	 */
	static public function getGeolocation($limit = 10) {
		global $wgCityId;

		$res = Redshift::query(
			'SELECT country, COUNT(*) as views FROM wikianalytics.sessions ' .
			'WHERE wiki_id = :wiki_id GROUP BY country ' .
			'ORDER BY views DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$pageviews = [];
		foreach($res as $row) {
			// e.g. United States of America -> 558336
			$pageviews[ $row->country ] = $row->views;
		}

		return ['pageviews' => $pageviews];
	}

	/**
	 * Return the top view pages for this wiki.
	 *
	 * @access	public
	 * @param int $limit
	 * @return	array	Top Viewed Pages
	 */
	static public function getTopViewedPages($limit = 10) {
		global $wgCityId;

		$res = Redshift::query(
			'SELECT url, COUNT(*) as views FROM wikianalytics.pageviews ' .
			'WHERE wiki_id = :wiki_id GROUP BY url ' .
			'ORDER BY views DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$pageviews = [];
		foreach($res as $row) {
			// e.g. /wiki/Elmo%27s_World_episodes -> 5765
			$pageviews[ $row->url ] = $row->views;
		}

		return ['pageviews' => $pageviews];
	}

	/**
	 * Return the top view file for this wiki.
	 *
	 * @access	public
	 ** @param int $limit
	 * @return	array	Top Viewed Files
	 */
	static public function getTopViewedFiles($limit = 10) {
		global $wgCityId;

		$res = Redshift::query(
			'SELECT url, COUNT(*) as views FROM wikianalytics.pageviews ' .
			'WHERE wiki_id = :wiki_id AND is_file=True GROUP BY url ' .
			'ORDER BY views DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$pageviews = [];
		foreach($res as $row) {
			// e.g. /wiki/Elmo%27s_World_episodes -> 5765
			$pageviews[ $row->url ] = $row->views;
		}

		return ['pageviews' => $pageviews];
	}

	/**
	 * Return daily sessions and page views.
	 *
	 * @param int $days
	 * @return	array	Daily sessions and page views.
	 */
	static public function getDailyTotals($days = self::LAST_DAYS) {
		global $wgCityId;

		$res = Redshift::query(
			'SELECT dt, COUNT(*) AS views FROM wikianalytics.pageviews ' .
			'WHERE wiki_id = :wiki_id GROUP BY dt ' .
			'ORDER BY dt DESC LIMIT :days',
			[ ':wiki_id' => $wgCityId, ':days' => $days ]
		);

		$pageviews = [];
		foreach($res as $row) {
			// e.g. 2019-06-28 -> 166107
			$pageviews[ $row->dt ] = $row->views;
		}

		// sort dates ascending
		ksort($pageviews);

		return [
			'pageviews' => $pageviews
		];
	}

	/**
	 * Return cumulative thirty day sessions and page views.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Cumulative thirty day sessions and page views.
	 */
	static public function getMonthlyTotals($startTimestamp = null, $endTimestamp = null) {
		return ['sessions' => 100, 'pageviews' => 1000, 'users' => 30, 'newUsers' => 5];
	}

	/**
	 * Return device break down information.
	 *
	 * Pageviews are grouped by browser type (Chrome, Safari, Firefox, Internet Explorer, ...)
	 * and device category (other, desktop, mobile, tablet, bot).
	 *
	 * @param	int $limit
	 * @return	array	Device Breakdown
	 */
	static public function getDeviceBreakdown($limit = 10) {
		global $wgCityId;

		// by browser
		$res = Redshift::query(
			'SELECT browser, COUNT(*) AS views FROM wikianalytics.sessions ' .
			'WHERE wiki_id = :wiki_id GROUP BY browser ' .
			'ORDER BY views DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$browsers = [];
		foreach($res as $row) {
			// e.g. Chrome -> 434927
			$browsers[ $row->browser ] = $row->views;
		}

		// by device type
		$res = Redshift::query(
			'SELECT device_type, COUNT(*) AS views FROM wikianalytics.sessions ' .
			'WHERE wiki_id = :wiki_id GROUP BY device_type ' .
			'ORDER BY views DESC LIMIT :limit',
			[ ':wiki_id' => $wgCityId, ':limit' => $limit ]
		);

		$devices = [];
		foreach($res as $row) {
			// e.g. desktop -> 295008
			$devices[ $row->device_type ] = $row->views;
		}

		return ["browser" => $browsers, "deviceCategory" => $devices];
	}

	/**
	 * Return mocked per-day data with sine wave
	 *
	 * @param int $days
	 * @param int $amplitude
	 * @param int $offset
	 * @param bool $formatDate Returns "Y-m-d" timestamp when set to true
	 * @return array
	 */
	static private function getMockedSine(
		int $days = 30, int $amplitude = 10, int $offset = 25, $formatDate = false
	) : array {
		$noise_level = $amplitude / 2;

		$data = [];
		for ($i = 0; $i < $days; $i++) {
			$value = sin( $i ) * $amplitude + $offset;
			$value += mt_rand( -$noise_level, $noise_level );

			// getDailyTotals requires Y-m-d index
			$index = strtotime('Today - '.$i.' days');
			if ($formatDate) {
				$index = date('Y-m-d', $index);
			}

			$data[$index] = intval($value);
		}

		return $data;
	}
}
