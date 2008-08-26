<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

class SpamRegexBatch {
	/**
	 * Build a set of regular expressions matching URLs with the list of regex fragments.
	 * Returns an empty list if the input list is empty.
	 *
	 * @param array $lines list of fragments which will match in URLs
	 * @param int $batchSize largest allowed batch regex;
	 *                       if 0, will produce one regex per line
	 * @return array
	 * @private
	 * @static
	 */
	function __construct ($list = "blacklist", $settings = array())
	{
		$this->list = $list;
		#---
		if (!empty($settings)) {
			foreach ( $settings as $name => $value )
				$this->$name = $value;
		}
	}

	static function buildRegexes( $lines, $batchSize=4096) {
		global $useSpamRegexNoHttp;
		# Make regex
		# It's faster using the S modifier even though it will usually only be run once
		//$regex = 'https?://+[a-z0-9_\-.]*(' . implode( '|', $lines ) . ')';
		//return '/' . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) ) . '/Si';
		$regexes = array();
		$regexStart = (!empty($useSpamRegexNoHttp)) ? '/(' : '/https?:\/\/+[a-z0-9_\-.]*(';
		$regexEnd = ($batchSize > 0 ) ? ')/Si' : ')/i';
		$build = false;
		foreach( $lines as $line ) {
			// FIXME: not very robust size check, but should work. :)
			if( $build === false ) {
				$build = $line;
			} elseif( strlen( $build ) + strlen( $line ) > $batchSize ) {
				$regexes[] = $regexStart .
					str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) .
					$regexEnd;
				$build = $line;
			} else {
				$build .= '|';
				$build .= $line;
			}
		}
		if( $build !== false ) {
			$regexes[] = $regexStart .
				str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) .
				$regexEnd;
		}
		return $regexes;
	}

	/**
	 * Confirm that a set of regexes is either empty or valid.
	 * @param array $lines set of regexes
	 * @return bool true if ok, false if contains invalid lines
	 * @private
	 * @static
	 */
	static function validateRegexes( $regexes ) {
		foreach( $regexes as $regex ) {
			wfSuppressWarnings();
			$ok = preg_match( $regex, '' );
			wfRestoreWarnings();

			if( $ok === false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Strip comments and whitespace, then remove blanks
	 * @private
	 * @static
	 */
	static function stripLines( $lines ) {
		return array_filter(
			array_map( 'trim',
				preg_replace( '/#.*$/', '',
					$lines ) ) );
	}

	/**
	 * Do a sanity check on the batch regex.
	 * @param lines unsanitized input lines
	 * @param string $fileName optional for debug reporting
	 * @return array of regexes
	 * @private
	 * @static
	 */
	static function buildSafeRegexes( $lines, $fileName=false ) {
		$lines = self::stripLines( $lines );
		$regexes = self::buildRegexes( $lines );
		if( self::validateRegexes( $regexes ) ) {
			return $regexes;
		} else {
			// _Something_ broke... rebuild line-by-line; it'll be
			// slower if there's a lot of blacklist lines, but one
			// broken line won't take out hundreds of its brothers.
			if( $fileName ) {
				wfDebugLog( 'SpamRegexBatch', "Spam list warning: bogus line in $fileName\n" );
			}
			return self::buildRegexes( $lines, 0 );
		}
	}

	/**
	 * @param array $lines
	 * @return array of input lines which produce invalid input, or empty array if no problems
	 * @static
	 */
	static function getBadLines( $lines ) {
		$lines = self::stripLines( $lines );
		$regexes = self::buildRegexes( $lines );
		if( self::validateRegexes( $regexes ) ) {
			// No problems!
			return array();
		}

		$badLines = array();
		foreach( $lines as $line ) {
			$regexes = self::buildRegexes( array( $line ) );
			if( !self::validateRegexes( $regexes ) ) {
				$badLines[] = $line;
			}
		}
		return $badLines;
	}

	/**
	 * Build a set of regular expressions from the given multiline input text,
	 * with empty lines and comments stripped.
	 *
	 * @param string $source
	 * @param string $fileName optional, for reporting of bad files
	 * @return array of regular expressions, potentially empty
	 * @static
	 */
	static function regexesFromText( $source, $fileName=false ) {
		$lines = explode( "\n", $source );
		return self::buildSafeRegexes( $lines, $fileName );
	}

	/**
	 * Build a set of regular expressions from a MediaWiki message.
	 * Will be correctly empty if the message isn't present.
	 * @param string $source
	 * @return array of regular expressions, potentially empty
	 * @static
	 */
	static function regexesFromMessage( $message ) {
		$source = wfMsgForContent( $message );
		if( $source && !wfEmptyMsg( $message, $source ) ) {
			return self::regexesFromText( $source );
		} else {
			return array();
		}
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
					$wgMemc->delete("$wgDBname:spam_".$this->list."_regexes");
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

	/**
	 * @deprecated back-compat
	 */
	public function getRegexes() {
		return $this->getRegexlists();
	}

	/**
	 * Fetch local and (possibly cached) remote regex lists.
	 * Will be cached locally across multiple invocations.
	 * @return array set of regular expressions, potentially empty.
	 */
	function getRegexlists() {
		if( $this->regexes === false ) {
			$this->regexes = array_merge(
				$this->getLocallists(),
				$this->getSharedlists() );
		}
		return $this->regexes;
	}

	/**
	 * Fetch (possibly cached) remote regex lists.
	 * @return array
	 */
	function getSharedlists() {
		global $wgMemc, $wgDBname;
		$fname = 'SpamRegexBatch::getSharedlists';
		wfProfileIn( $fname );

		wfDebugLog( 'SpamRegexBatch', "Loading spam regex..." );

		if ( count( $this->files ) == 0 ){
			# No lists
			wfDebugLog( 'SpamRegexBatch', "no files specified\n" );
			wfProfileOut( $fname );
			return array();
		}
		
		// This used to be cached per-site, but that could be bad on a shared
		// server where not all wikis have the same configuration.
		$key = "$wgDBname:spam_".$this->list."_regexes";

		$cachedRegexes = $wgMemc->get( $key );
		if( is_array( $cachedRegexes ) ) {
			wfDebugLog( 'SpamRegexBatch', "Got shared spam regexes from cache\n" );
			wfProfileOut( $fname );
			return $cachedRegexes;
		}

		wfDebugLog( 'SpamRegexBatch', "Get shared spam regexes from article\n" );
		$regexes = $this->buildSharedSpamlists();
		$wgMemc->set( $key, $regexes, $this->expiryTime );

		wfProfileOut( $fname );

		return $regexes;
	}

	function buildSharedSpamlists() {
		wfProfileIn( __METHOD__ );
		$regexes = array();
		# Load lists
		wfDebugLog( 'SpamRegexBatch', "Constructing spam ".$this->list."\n" );
		foreach ( $this->files as $fileName ) {
			if ( preg_match( '/^DB: ([\w-]*) (.*)$/', $fileName, $matches ) ) {
				$text = $this->getArticleText( $matches[1], $matches[2] );
			} elseif ( preg_match( '/^http:\/\//', $fileName ) ) {
				$text = $this->getHttpText( $fileName );
			} else {
				$text = file_get_contents( $fileName );
				wfDebugLog( 'SpamRegexBatch', "got from file $fileName\n" );
			}

			// Build a separate batch of regexes from each source.
			// While in theory we could squeeze a little efficiency
			// out of combining multiple sources in one regex, if
			// there's a bad line in one of them we'll gain more
			// from only having to break that set into smaller pieces.
			$regexes = array_merge( $regexes,
				self::regexesFromText( $text, $fileName ) );
		}
		wfProfileOut( __METHOD__ );
		return $regexes;
	}

	function getHttpText( $fileName ) {
		global $wgDBname, $messageMemc;
		wfProfileIn( __METHOD__ );
		# HTTP request
		# To keep requests to a minimum, we save results into $messageMemc, which is
		# similar to $wgMemc except almost certain to exist. By default, it is stored
		# in the database
		#
		# There are two keys, when the warning key expires, a random thread will refresh
		# the real key. This reduces the chance of multiple requests under high traffic
		# conditions.
		$key = "spam_".$this->list."_file:$fileName";
		$warningKey = "$wgDBname:spamfilewarning:$fileName";
		$httpText = $messageMemc->get( $key );
		$warning = $messageMemc->get( $warningKey );

		if ( !is_string( $httpText ) || ( !$warning && !mt_rand( 0, $this->warningChance ) ) ) {
			wfDebugLog( 'SpamRegexBatch', "Loading spam ".$this->list." from $fileName\n" );
			$httpText = $this->getHTTP( $fileName );
			if( $httpText === false ) {
				wfDebugLog( 'SpamRegexBatch', "Error loading ".$this->list." from $fileName\n" );
			}
			$messageMemc->set( $warningKey, 1, $this->warningTime );
			$messageMemc->set( $key, $httpText, $this->expiryTime );
		} else {
			wfDebugLog( 'SpamRegexBatch', "Got spam ".$this->list." from HTTP cache for $fileName\n" );
		}
		#---
		wfProfileOut( __METHOD__ );
		return $httpText;
	}

	function getLocallists() {
		return self::regexesFromMessage( 'spam-'.$this->list );
	}

	function getWhitelists() {
		return self::regexesFromMessage( 'spam-whitelist' );
	}

	/**
	 * Fetch an article from this or another local MediaWiki database.
	 * This is probably *very* fragile, and shouldn't be used perhaps.
	 * @param string $db
	 * @param string $article
	 */
	function getArticleText( $db, $article ) {
		wfDebugLog( 'SpamRegexBatch', "Fetching local spam ".$this->list." from '$article' on '$db'...\n" );
		global $wgDBname;
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_READ );
		$dbr->selectDB( $db );
		$text = false;
		if ( $dbr->tableExists( 'page' ) ) {
			// 1.5 schema
			$dbw =& wfGetDB( DB_READ );
			$dbw->selectDB( $db );
			$revision = Revision::newFromTitle( Title::newFromText( $article ) );
			if ( $revision ) {
				$text = $revision->getText();
			}
			$dbw->selectDB( $wgDBname );
		} else {
			// 1.4 schema
			$title = Title::newFromText( $article );
			$text = $dbr->selectField( 'cur', 'cur_text', array( 'cur_namespace' => $title->getNamespace(),
				'cur_title' => $title->getDBkey() ), 'SpamRegexBatch::getArticleText' );
		}
		$dbr->selectDB( $wgDBname );
		wfProfileOut( __METHOD__ );
		return strval( $text );
	}

	function getHTTP( $url ) {
		// Use wfGetHTTP from MW 1.5 if it is available
		global $IP;
		include_once( "$IP/includes/HttpFunctions.php" );
		wfSuppressWarnings();
		if ( function_exists( 'wfGetHTTP' ) ) {
			$text = wfGetHTTP( $url );
		} else {
			$url_fopen = ini_set( 'allow_url_fopen', 1 );
			$text = file_get_contents( $url );
			ini_set( 'allow_url_fopen', $url_fopen );
		}
		wfRestoreWarnings();
		return $text;
	}

	static function spamPage( $match = false, $title = null ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addWikiText( wfMsg( 'spamprotectiontext' ) );
		if ( $match )
			$wgOut->addWikiText( wfMsg( 'spamprotectionmatch', "<nowiki>{$match}</nowiki>" ) );

		$wgOut->returnToMain( false, $title );
	}

	public function getMemcacheFile() { return $this->memcache_file; }
	public function getMemcacheRegex() { return $this->memcache_regexes; }
	public function getVarRegexes() { return $this->regexes; }
	public function getPreviousFilter() { return $this->previousFilter; }
	public function getFiles() { return $this->files; }
	public function getWarningTime() { return $this->warningTime; }
	public function getExpiryTime() { return $this->expiryTime; }
	public function getWarningChance() { return $this->warningChance; }
	public function getTitle() { return $this->title; }
	public function getText() { return $this->text; }
	public function getSection() { return $this->section; }

}
