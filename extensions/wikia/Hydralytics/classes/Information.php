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
		$editsLoggedIn = [];
		$editsLoggedOut = [];
		for ($i = 0; $i < $days; $i++) {
			$editsLoggedIn[strtotime('Today - '.$i.' days')] = 0;
			$editsLoggedOut[strtotime('Today - '.$i.' days')] = 0;
		}
		return ['in' => $editsLoggedIn, 'out' => $editsLoggedOut];
	}

	/**
	 * Return the top searchs by rank for the given time period.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Top search terms by rank in descending order.  [[rank, term], [rank, term]]
	 */
	static public function getTopSearchTerms($startTimestamp = null, $endTimestamp = null) {
		return ['phrase1' => 110];
	}

	/**
	 * Return geolocation data.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Geolocation by: [percentage => Country Code]
	 */
	static public function getGeolocation($startTimestamp = null, $endTimestamp = null) {
		return ['pageviews' => ['Poland' => 100, 'USA' => 80], 'sessions' => []];
	}

	/**
	 * Return the top view pages for this wiki.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Top Viewed Pages
	 */
	static public function getTopViewedPages($startTimestamp = null, $endTimestamp = null) {
		return ['pageviews' => ['Interesting article' => 100, 'Nice one' => 80], 'sessions' => []];
	}

	/**
	 * Return the top view file for this wiki.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Top Viewed Files
	 */
	static public function getTopViewedFiles($startTimestamp = null, $endTimestamp = null) {
		return ['pageviews' => ['file1' => 100, 'file2' => 80], 'sessions' => []];
	}

	/**
	 * Return daily sessions and page views.
	 *
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Daily sessions and page views.
	 */
	static public function getDailyTotals($startTimestamp = null, $endTimestamp = null) {
		return ['pageviews' => ['2019-05-01' => 40]]; // TODO add deltas
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
	 * @access	public
	 * @param	integer	[Optional] Start Timestamp, Unix Style
	 * @param	integer	[Optional] End Timestamp, Unix Style
	 * @return	array	Device Breakdown
	 */
	static public function getDeviceBreakdown($startTimestamp = null, $endTimestamp = null) {
		return ["browser" => ["Chrome" => 40, "Firefox" => 50], "deviceCategory" => ["desktop" => 10, "mobile" => 20]];
	}

	/**
	 * Return mocked per-day data with sine wave
	 *
	 * @param int $days
	 * @param int $amplitude
	 * @param int $offset
	 * @return array
	 */
	static private function getMockedSine(int $days = 30, int $amplitude = 10, int $offset = 25) : array {
		$noise_level = 20;

		$data = [];
		for ($i = 0; $i < $days; $i++) {
			$value = sin( $i ) * $amplitude + $offset;
			$value += mt_rand( -$noise_level, $noise_level );

			$data[strtotime('Today - '.$i.' days')] = $value;
		}

		return $data;
	}
}
