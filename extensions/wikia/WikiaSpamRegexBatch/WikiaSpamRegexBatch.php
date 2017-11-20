<?php

/**
 * Utility class for working with blacklists
 */
class WikiaSpamRegexBatch extends SpamRegexBatch{
	protected $memcache_file = false;
	protected $memcache_regexes = false;
	protected $regexes = false;
	protected $previousFilter = false;
	protected $files = array();
	protected $warningTime = false;
	protected $expiryTime = false;
	protected $warningChance = false;
	protected $title = false;
	protected $text = false;
	protected $list = '' ;
	protected $whitelist = '';
	protected $section = false;

	function __construct ($list = "blacklist", $settings = array()) {
		$this->list = $list;
		if (!empty($settings)) {
			foreach ( $settings as $name => $value )
				$this->$name = $value;
		}
	}

	public function getRegexes() {
		return self::getRegexlists();
	}

	/**
	 * Fetch local and (possibly cached) remote regex lists.
	 * Will be cached locally across multiple invocations.
	 * @return array set of regular expressions, potentially empty.
	 */
	function getRegexlists() {
		if ($this->regexes === false) {
			$this->regexes = array_merge(
				self::getLocallists(),
				self::getSharedlists());
		}
		return $this->regexes;
	}

	/**
	 * Fetch (possibly cached) remote regex lists.
	 * @return array
	 */
	function getSharedlists() {
		global $wgMemc, $wgDBname;
		$fname = 'WikiaSpamRegexBatch::getSharedlists';
		wfProfileIn($fname);

		wfDebugLog('WikiaSpamRegexBatch', "Loading spam regex...");

		if (count($this->files) == 0) {
			# No lists
			wfDebugLog($fname, "no files specified\n");
			wfProfileOut($fname);
			return array();
		}

		// This used to be cached per-site, but that could be bad on a shared
		// server where not all wikis have the same configuration.
		$key = "$wgDBname:spam_" . $this->list . "_regexes:v2";

		$cachedRegexes = $wgMemc->get($key);
		if (is_array($cachedRegexes)) {
			wfDebugLog('WikiaSpamRegexBatch', "Got shared spam regexes from cache\n");
			wfProfileOut($fname);
			return $cachedRegexes;
		}

		wfDebugLog('WikiaSpamRegexBatch', "Get shared spam regexes from article\n");
		$regexes = self::buildSharedSpamlists();
		$wgMemc->set($key, $regexes, $this->expiryTime);

		wfProfileOut($fname);

		return $regexes;
	}

	function buildSharedSpamlists() {
		wfProfileIn(__METHOD__);
		$regexes = array();
		# Load lists
		wfDebugLog('WikiaSpamRegexBatch', "Constructing spam " . $this->list . "\n");
		foreach ($this->files as $fileName) {
			if (preg_match('/^DB: ([\w-]*) (.*)$/', $fileName, $matches)) {
				$text = self::getArticleText($matches[1], $matches[2]);
			} elseif (preg_match('/^https?:\/\//', $fileName)) {
				$text = self::getHttpText($fileName);
			} else {
				$text = file_get_contents($fileName);
				wfDebugLog('WikiaSpamRegexBatch', "got from file $fileName\n");
			}

			// Build a separate batch of regexes from each source.
			// While in theory we could squeeze a little efficiency
			// out of combining multiple sources in one regex, if
			// there's a bad line in one of them we'll gain more
			// from only having to break that set into smaller pieces.
			$regexes = array_merge($regexes,
				self::regexesFromText($text, new SpamBlacklist(), $fileName));
		}
		wfProfileOut(__METHOD__);
		return $regexes;
	}

	function getHttpText($fileName) {
		global $wgDBname, $messageMemc;
		wfProfileIn(__METHOD__);
		# HTTP request
		# To keep requests to a minimum, we save results into $messageMemc, which is
		# similar to $wgMemc except almost certain to exist. By default, it is stored
		# in the database
		#
		# There are two keys, when the warning key expires, a random thread will refresh
		# the real key. This reduces the chance of multiple requests under high traffic
		# conditions.
		$key = "spam_" . $this->list . "_file:$fileName";
		$warningKey = "$wgDBname:spamfilewarning:$fileName";
		$httpText = $messageMemc->get($key);
		$warning = $messageMemc->get($warningKey);

		if (!is_string($httpText) || (!$warning && !mt_rand(0, $this->warningChance))) {
			wfDebugLog('WikiaSpamRegexBatch', "Loading spam " . $this->list . " from $fileName\n");
			$httpText = self::getHTTP($fileName);
			if ($httpText === false) {
				wfDebugLog('WikiaSpamRegexBatch', "Error loading " . $this->list . " from $fileName\n");
			}
			$messageMemc->set($warningKey, 1, $this->warningTime);
			$messageMemc->set($key, $httpText, $this->expiryTime);
		} else {
			wfDebugLog('WikiaSpamRegexBatch', "Got spam " . $this->list . " from HTTP cache for $fileName\n");
		}
		#---
		wfProfileOut(__METHOD__);
		return $httpText;
	}

	function getLocallists() {
		$regexes = array();
		if(!empty($this->files)) {
			foreach($this->files as $file) {
				$regexes = array_merge($regexes, self::regexesFromMessage($file, (new SpamBlacklist)));
			}
		}
		return $regexes;
	}

	/**
	 * Fetch an article from this or another local MediaWiki database.
	 * This is probably *very* fragile, and shouldn't be used perhaps.
	 * @param string $db
	 * @param string $article
	 */
	function getArticleText($db, $article) {
		wfProfileIn(__METHOD__);

		wfDebugLog('WikiaSpamRegexBatch', "Fetching local spam " . $this->list . " from '$article' on '$db'...\n");

		$title = Title::newFromText($article);
		$dbr = wfGetDB(DB_SLAVE, array(), $db);
		$row = $dbr->selectRow(
			array(
				"page",
				"revision",
				"text"
			),
			array('*'),
			array(
				'page_namespace' => $title->getNamespace(),
				'page_title' => $title->getDBkey(),
				'page_latest = rev_id',
				'old_id = rev_text_id'
			)
		);
		wfProfileOut(__METHOD__);
		if ($row) {
			return Revision::getRevisionText($row);
		} else {
			return null;
		}
	}

	function getHTTP($url) {
		// Use wfGetHTTP from MW 1.5 if it is available
		global $IP;
		include_once("$IP/includes/HttpFunctions.php");
		wfSuppressWarnings();
		if (class_exists('HTTP')) {
			$text = HTTP::Get($url);
		} else {
			if (function_exists('wfGetHTTP')) {
				$text = wfGetHTTP($url);
			} else {
				$url_fopen = ini_set('allow_url_fopen', 1);
				$text = file_get_contents($url);
				ini_set('allow_url_fopen', $url_fopen);
			}
		}
		wfRestoreWarnings();
		return $text;
	}

	static function spamPage($match = false, $title = null) {
		global $wgOut;

		$wgOut->setPageTitle(wfMsg('spamprotectiontitle'));
		$wgOut->setRobotPolicy('noindex,nofollow');
		$wgOut->setArticleRelated(false);

		$wgOut->addWikiMsg('spamprotectiontext');
		$wgOut->addHTML('<p>( Call #5 )</p>');
		if ($match) {
			$wgOut->addWikiMsg('spamprotectionmatch', "<nowiki>{$match}</nowiki>");
		}

		$wgOut->returnToMain(false, $title);
	}

	public function getMemcacheFile() {
		return $this->memcache_file;
	}

	public function getMemcacheRegex() {
		return $this->memcache_regexes;
	}

	public function getVarRegexes() {
		return $this->regexes;
	}

	public function getPreviousFilter() {
		return $this->previousFilter;
	}

	public function getFiles() {
		return $this->files;
	}

	public function setFiles($files) {
		$this->files = $files;
	}

	public function getWarningTime() {
		return $this->warningTime;
	}

	public function getExpiryTime() {
		return $this->expiryTime;
	}

	public function getWarningChance() {
		return $this->warningChance;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getText() {
		return $this->text;
	}

	public function getSection() {
		return $this->section;
	}

	/**
	 * clear memcache if needed
	 */
	public function clearListMemCache()
	{
		global $messageMemc, $wgMemc, $wgDBname, $wgTitle;

		if (is_array($this->files) && (is_object($wgTitle)) )
		{
			foreach ( $this->files as $fileName )
			{
				$fullUrl = $wgTitle->getFullURL('action=raw');
				wfDebug( "Check title of current page\n" );
				if (strpos($fullUrl,$fileName) !== false)
				{
					wfDebug( "Match! \n" );
					$wgMemc->delete($this->memcache_regexes);
					wfDebug( "Clear cache - " . $this->memcache_regexes . "\n" );
					$wgMemc->delete("$wgDBname:spam_".$this->list."_regexes:v2");
					wfDebug( "Clear cache with spam list: $wgDBname:spam_".$this->list."_regexes" );
					$key = "spam_".$this->list."_file:$fileName";
					$warningKey = "$wgDBname:spamfilewarning:$fileName";
					wfDebug( "Clear cache - " . $key . "\n" );
					$httpText = $messageMemc->delete( $key );
					wfDebug( "Clear cache - " . $warningKey . "\n" );
					$warning = $messageMemc->delete( $warningKey );
				}
			}
		}

		return 1;
	}
}

