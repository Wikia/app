<?php

/**
 * Provides an API for tracking page views on Lyrics Wiki
 */
class LyricFindTrackingService extends WikiaService {

	// LyricFind API response codes
	const CODE_LYRIC_IS_AVAILABLE = 101;
	const CODE_LYRIC_IS_INSTRUMENTAL = 102;
	const CODE_LRC_IS_AVAILABLE  = 111;
	const CODE_LYRIC_IS_BLOCKED  = 206;

	const DEFAULT_USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19';

	const LOG_GROUP = 'lyricfind-tracking';

	/**
	 * Marks given page with lyric for removal
	 *
	 * @param $pageId int article ID
	 * @return bool result
	 */
	private function markLyricForRemoval($pageId) {
		$this->wf->SetWikiaPageProp(WPP_LYRICFIND_MARKED_FOR_REMOVAL, $pageId, 1);

		self::log(__METHOD__, "marked page #{$pageId} for removal");
		return true;
	}

	/**
	 * Returns properly formatted "trackid" parameter for LyricFind API from given data
	 *
	 * Example: trackid=amg:2033,gnlyricid:123,trackname:mony+mony,artistname:tommy+james
	 *
	 * @param $data array containing amgid, gnlyricid and title of the lyric
	 */
	private function formatTrackId($data) {
		$parts = [];

		if (!empty($data['amg'])) {
			$parts[] = sprintf('amg:%d', $data['amg']);
		}

		if (!empty($data['gracenote'])) {
			$parts[] = sprintf('gnlyricid:%d', $data['gracenote']);
		}

		list($artistName, $trackName) = explode(':', $data['title'], 2);

		// artist and track name needs to be lowercase and without commas or colons
		$encode = function($item) {
			return mb_strtolower(strtr($item, [
				',' => ' ',
				':' => ' ',
			]));
		};

		$parts[] = sprintf('trackname:%s', $encode($trackName));
		$parts[] = sprintf('artistname:%s', $encode($artistName));

		return join(',', $parts);
	}

	/**
	 * @param $amgId int|bool AMG (All Music Guide) lyric ID to track page view for (or false if not found)
	 * @param $gracenoteId int|bool Gracenote lyric ID to track page view for (or false if not found)
	 * @param $title Title page with the lyric to track
	 * @return Status success
	 */
	public function track($amgId, $gracenoteId, Title $title) {
		wfProfileIn(__METHOD__);

		$status = Status::newGood();

		// format trackid parameter
		$trackId = $this->formatTrackId([
			'amg' => $amgId,
			'gracenote' => $gracenoteId,
			'title' => $title->getText()
		]);

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
		$data = [
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'offlineviews',
			'count' => 1,
			'trackid' => $trackId,
			'output' => 'json',
			'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : self::DEFAULT_USER_AGENT
		];

		wfDebug(__METHOD__ . ': ' . json_encode($data) . "\n");

		$resp = Http::post($url, ['postData' => $data]);

		if ($resp !== false) {
			wfDebug(__METHOD__ . ": API response - {$resp}\n");
		}

		// get the code from API response
		if ($resp !== false) {
			$json = json_decode($resp, true);

			$code = !empty($json['response']['code']) ? intval($json['response']['code']) : false;
			$status->value = $code;

			switch ($code) {
				case self::CODE_LYRIC_IS_BLOCKED:
					$this->markLyricForRemoval($this->wg->Title->getArticleID());
					break;

				case self::CODE_LRC_IS_AVAILABLE:
				case self::CODE_LYRIC_IS_INSTRUMENTAL:
				case self::CODE_LYRIC_IS_AVAILABLE:
					break;

				default:
					$status->fatal('not expected response code');
					self::log(__METHOD__, "got #{$code} response code from API (track amg#{$amgId} / gn#{$gracenoteId} / '{$title->getPrefixedText()}')");
			}
		}
		else {
			$status = Status::newFatal("API request failed!");
			self::log(__METHOD__, "LyricFind API request failed!");
		}

		wfProfileOut(__METHOD__);
		return $status;
	}

	/**
	 * Log to /var/log/private file
	 *
	 * @param $method string method
	 * @param $msg string message to log
	 */
	private static function log($method, $msg) {
		Wikia::log(self::LOG_GROUP . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
	}
}
