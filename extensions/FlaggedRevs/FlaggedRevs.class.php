<?php

class FlaggedRevs {
	protected static $dimensions = array();
	protected static $minQL = array();
	protected static $minPL = array();
	protected static $feedbackTags = array();
	protected static $feedbackTagWeight = array();
	protected static $loaded = false;
	protected static $qualityVersions = false;
	protected static $pristineVersions = false;
	protected static $includeVersionCache = array();

	public static function load() {
		global $wgFlaggedRevTags, $wgFlaggedRevsFeedbackTags;
		if( self::$loaded ) return true;
		# Assume true, then set to false if needed
		if( !empty($wgFlaggedRevTags) ) {
			self::$qualityVersions = true;
			self::$pristineVersions = true;
		}
		foreach( $wgFlaggedRevTags as $tag => $levels ) {
			# Sanity checks
			$safeTag = htmlspecialchars($tag);
			if( !preg_match('/^[a-zA-Z]{1,20}$/',$tag) || $safeTag !== $tag ) {
				throw new MWException( 'FlaggedRevs given invalid tag name!' );
			}
			# Define "quality" and "pristine" reqs
			if( is_array($levels) ) {
				$minQL = $levels['quality'];
				$minPL = $levels['pristine'];
				$ratingLevels = $levels['levels'];
			# B/C, $levels is just an integer (minQL)
			} else {
				global $wgFlaggedRevPristine, $wgFlaggedRevValues;
				$ratingLevels = isset($wgFlaggedRevValues) ? $wgFlaggedRevValues : 1;
				$minQL = $levels; // an integer
				$minPL = isset($wgFlaggedRevPristine) ? $wgFlaggedRevPristine : $ratingLevels+1;
			}
			# Set FlaggedRevs tags
			self::$dimensions[$tag] = array();
			for( $i=0; $i <= $ratingLevels; $i++ ) {
				self::$dimensions[$tag][$i] = "{$tag}-{$i}";
			}
			# Sanity checks
			if( !is_integer($minQL) || !is_integer($minPL) ) {
				throw new MWException( 'FlaggedRevs given invalid tag value!' );
			}
			if( $minQL > $ratingLevels ) {
				self::$qualityVersions = false;
				self::$pristineVersions = false;
			}
			if( $minPL > $ratingLevels ) {
				self::$pristineVersions = false;
			}
			self::$minQL[$tag] = $minQL;
			self::$minPL[$tag] = $minPL;
		}
		foreach( $wgFlaggedRevsFeedbackTags as $tag => $weight ) {
			# Tag names used as part of file names. "Overall" tag is a
			# weighted aggregate, so it cannot be used either.
			if( !preg_match('/^[a-zA-Z]{1,20}$/',$tag) || $tag === 'overall' ) {
				throw new MWException( 'FlaggedRevs given invalid tag name!' );
			}
			self::$feedbackTagWeight[$tag] = $weight;
			for( $i=0; $i <= 4; $i++ ) {
				self::$feedbackTags[$tag][$i] = "feedback-{$tag}-{$i}";
			}
		}
		self::$loaded = true;
	}
	
	################# Basic accessors #################
	
	/**
	 * Are quality versions enabled?
	 * @returns bool
	 */
	public static function qualityVersions() {
		self::load();
		return self::$qualityVersions;
	}
	
	/**
	 * Are pristine versions enabled?
	 * @returns bool
	 */
	public static function pristineVersions() {
		self::load();
		return self::$pristineVersions;
	}

	/**
	 * Should this be using a simple icon-based UI?
	 * Check the user's preferences first, using the site settings as the default.
	 * @returns bool
	 */
	public static function useSimpleUI() {
		global $wgUser, $wgSimpleFlaggedRevsUI;
		return $wgUser->getOption( 'flaggedrevssimpleui', intval($wgSimpleFlaggedRevsUI) );
	}
	
	/**
	 * Should this user see stable versions by default?
	 * @returns bool
	 */
	public static function showStableByDefault() {
		global $wgFlaggedRevsOverride;
		return (bool)$wgFlaggedRevsOverride;
	}
	
	/**
	 * Should this user ignore the site and page default version settings?
	 * @returns bool
	 */
	public static function ignoreDefaultVersion() {
		global $wgFlaggedRevsExceptions, $wgUser;
		# Viewer sees current by default (editors, insiders, ect...) ?
		foreach( $wgFlaggedRevsExceptions as $group ) {
			if( $group == 'user' ) {
				if( !$wgUser->isAnon() )
					return true;
			} else if( in_array( $group, $wgUser->getGroups() ) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Should tags only be shown for unreviewed content for this user?
	 * @returns bool
	 */
	public static function lowProfileUI() {
		global $wgFlaggedRevsLowProfile;
		self::load();
		return $wgFlaggedRevsLowProfile;
	}
	/**
	 * Should comments be allowed on pages and forms?
	 * @returns bool
	 */
	public static function allowComments() {
		global $wgFlaggedRevsComments;
		self::load();
		return $wgFlaggedRevsComments;
	}
	
	/**
	 * Get the array of tag dimensions and level messages
	 * @returns array
	 */
	public static function getDimensions() {
		self::load();
		return self::$dimensions;
	}
	
	/**
	 * Get min level this tag needs to be for a rev to be "quality"
	 * @returns int
	 */
	public static function getMinQL( $tag ) {
		self::load();
		return self::$minQL[$tag];
	}
	
	/**
	 * Get min level this tag needs to be for a rev to be "pristine"
	 * @returns int
	 */
	public static function getMinPL( $tag ) {
		self::load();
		return self::$minPL[$tag];
	}
	
	/**
	 * Get the array of tag dimensions
	 * @returns array
	 */
	public static function getTags() {
		self::load();
		return array_keys( self::$dimensions );
	}
	
	/**
	 * Get the array of tag feedback tags
	 * @returns array
	 */
	public static function getFeedbackTags() {
		self::load();
		return self::$feedbackTags;
	}
	
	/**
	 * Get the the weight of a feedback tag
	 * @param string $tag
	 * @returns array
	 */
	public static function getFeedbackWeight( $tag ) {
		self::load();
		return self::$feedbackTagWeight[$tag];
	}
	
	/**
	 * Get the message name for a tag
	 * @param string $tag
	 * @returns string
	 */
	public static function getTagMsg( $tag ) {
		self::load();
		wfLoadExtensionMessages( 'FlaggedRevs' );
		return wfMsgExt( "revreview-$tag", array( 'escapenoentities' ) );
	}
	
	/**
	 * Get the levels for a tag. Gives map of level to message name.
	 * @param string $tag
	 * @returns associative array (integer -> string)
	 */
	public static function getTagLevels( $tag ) {
		self::load();
		return isset(self::$dimensions[$tag]) ? self::$dimensions[$tag] : array();
	}
	
	/**
	 * Get the the message name for a value of a tag
	 * @param string $tag
	 * @param int $value
	 * @returns string
	 */
	public static function getTagValueMsg( $tag, $value ) {
		self::load();
		if( !isset(self::$dimensions[$tag]) )
			return "";
		# Return empty string if not there
		return isset(self::$dimensions[$tag][$value]) ? self::$dimensions[$tag][$value] : "";
	}
	
	/**
	 * Are there no actual dimensions?
	 * @returns bool
	 */
	public static function dimensionsEmpty() {
		self::load();
		return empty(self::$dimensions);
	}

	/**
	 * Get corresponding text for the api output of flagging levels
	 *
	 * @param int $level
	 * @return string
	 */
	public static function getQualityLevelText( $level ) {
		static $levelText = array(
			0 => 'stable',
			1 => 'quality',
			2 => 'pristine'
		);
		if( isset( $levelText[$level] ) ) {
			return $levelText[$level];
		} else {
			return '';
		}
	}
	
	/**
	 * Get global revision status precedence settings
	 * @return int
	 */
	public static function getPrecedence() {
		global $wgFlaggedRevsPrecedence;
		switch( $wgFlaggedRevsPrecedence )
		{
			case 2:
				$select = FLAGGED_VIS_PRISTINE;
				break;
			case 1:
				$select = FLAGGED_VIS_QUALITY;
				break;
			default:
				$select = FLAGGED_VIS_LATEST;
				break;
		}
		return $select;
	}
	
	################# Parsing functions #################

	/**
	 * @param string $text
	 * @param Title $title
	 * @param integer $id, revision id
	 * @return array( string, array, array, array, int )
	 * All included pages/arguments are expanded out
	 */
	public static function expandText( $text='', $title, $id ) {
		global $wgParser;
		# Make our hooks trigger (force unstub so setting doesn't get lost)
		$wgParser->firstCallInit();
		$wgParser->fr_isStable = true;
		# Parse with default options
		$options = self::makeParserOptions();
		$outputText = $wgParser->preprocess( $text, $title, $options, $id );
		$out =& $wgParser->mOutput;
		$data = array( $outputText, $out->mTemplates, $out->mTemplateIds, 
			$out->fr_includeErrors, $out->fr_newestTemplateID );
		# Done!
		$wgParser->fr_isStable = false;
		# Return data array
		return $data;
	}

	/**
	 * Get the HTML output of a revision based on $text.
	 * @param Article $article
	 * @param string $text
	 * @param int $id
	 * @return ParserOutput
	 */
	public static function parseStableText( $article, $text='', $id ) {
		global $wgParser;
		$title = $article->getTitle(); // avoid pass-by-reference error
		# Make our hooks trigger (force unstub so setting doesn't get lost)
		$wgParser->firstCallInit();
		$wgParser->fr_isStable = true;
		# Don't show section-edit links, they can be old and misleading
		$options = self::makeParserOptions();
		# Parse the new body, wikitext -> html
	   	$parserOut = $wgParser->parse( $text, $title, $options, true, true, $id );
	   	# Done with parser!
	   	$wgParser->fr_isStable = false;
	   	return $parserOut;
	}
	
	/**
	* Get standard parser options
	*/
	public static function makeParserOptions() {
		global $wgUser;
		$options = ParserOptions::newFromUser($wgUser);
		# Show inclusion/loop reports
		$options->enableLimitReport();
		# Fix bad HTML
		$options->setTidy( true );
		return $options;
	}
	
	/**
	* @param Article $article
	* @return ParserOutput
	* Get the page cache for the top stable revision of an article
	*/
	public static function getPageCache( $article ) {
		global $wgUser, $parserMemc, $wgCacheEpoch;
		wfProfileIn( __METHOD__ );
		# Make sure it is valid
		if( !$article->getId() )
			return null;

		$parserCache = ParserCache::singleton();
		$key = self::getCacheKey( $parserCache, $article, $wgUser );
		# Get the cached HTML
		wfDebug( "Trying parser cache $key\n" );
		$value = $parserMemc->get( $key );
		if( is_object( $value ) ) {
			wfDebug( "Found.\n" );
			# Delete if article has changed since the cache was made
			$canCache = $article->checkTouched();
			$cacheTime = $value->getCacheTime();
			$touched = $article->mTouched;
			if( !$canCache || $value->expired( $touched ) ) {
				if( !$canCache ) {
					wfIncrStats( "pcache_miss_invalid" );
					wfDebug( "Invalid cached redirect, touched $touched, epoch $wgCacheEpoch, cached $cacheTime\n" );
				} else {
					wfIncrStats( "pcache_miss_expired" );
					wfDebug( "Key expired, touched $touched, epoch $wgCacheEpoch, cached $cacheTime\n" );
				}
				$parserMemc->delete( $key );
				$value = false;
			} else {
				if( isset( $value->mTimestamp ) ) {
					$article->mTimestamp = $value->mTimestamp;
				}
				wfIncrStats( "pcache_hit" );
			}
		} else {
			wfDebug( "Parser cache miss.\n" );
			wfIncrStats( "pcache_miss_absent" );
			$value = false;
		}

		wfProfileOut( __METHOD__ );
		return $value;
	}

	/**
	 * Like ParserCache::getKey() with stable-pcache instead of pcache
	 */
	public static function getCacheKey( $parserCache, $article, &$user ) {
		$key = $parserCache->getKey( $article, $user );
		$key = str_replace( ':pcache:', ':stable-pcache:', $key );
		return $key;
	}

	/**
	* @param Article $article
	* @param parerOutput $parserOut
	* Updates the stable cache of a page with the given $parserOut
	*/
	public static function updatePageCache( $article, $parserOut=null ) {
		global $wgUser, $parserMemc, $wgParserCacheExpireTime, $wgEnableParserCache;
		# Make sure it is valid and $wgEnableParserCache is enabled
		if( !$wgEnableParserCache || is_null($parserOut) )
			return false;

		$parserCache = ParserCache::singleton();
		$key = self::getCacheKey( $parserCache, $article, $wgUser );
		# Add cache mark to HTML
		$now = wfTimestampNow();
		$parserOut->setCacheTime( $now );
		# Save the timestamp so that we don't have to load the revision row on view
		$parserOut->mTimestamp = $article->getTimestamp();
		$parserOut->mText .= "\n<!-- Saved in stable version parser cache with key $key and timestamp $now -->";
		# Set expire time
		if( $parserOut->containsOldMagic() ){
			$expire = 3600; // 1 hour
		} else {
			$expire = $wgParserCacheExpireTime;
		}
		# Save to objectcache
		$parserMemc->set( $key, $parserOut, $expire );

		return true;
	}
	
	/**
	 * @param int $revId
	 * @param array $tmpParams (like ParserOutput template IDs)
	 * @param array $imgParams (like ParserOutput image time->sha1 pairs)
	 * Set the template/image versioning cache for parser
	 */
	public static function setIncludeVersionCache( $revId, $tmpParams, $imgParams ) {
		self::load();
		self::$includeVersionCache[$revId] = array();
		self::$includeVersionCache[$revId]['templates'] = $tmpParams;
		self::$includeVersionCache[$revId]['files'] = $imgParams;
	}
	
	/**
	 * Destroy the template/image versioning cache instance for parser
	 */
	public static function clearIncludeVersionCache( $revId ) {
		self::load();
		if( isset(self::$includeVersionCache[$revId]) ) {
			unset(self::$includeVersionCache[$revId]);
		}
	}

	/**
	 * Should the params be in the process cache?
	 */
	public static function useProcessCache( $revId ) {
		self::load();
		if( isset(self::$includeVersionCache[$revId]) ) {
			return true;
		}
		return false;
	}
	
	/**
	 * Get template versioning cache for parser
	 * @param int $revID
	 * @param int $namespace
	 * @param string $dbKey
	 * @returns mixed (integer/null)
	 */
	public static function getTemplateIdFromCache( $revId, $namespace, $dbKey ) {
		self::load();
		if( isset(self::$includeVersionCache[$revId]) ) {
			if( isset(self::$includeVersionCache[$revId]['templates'][$namespace]) ) {
				if( isset(self::$includeVersionCache[$revId]['templates'][$namespace][$dbKey]) ) {
					return self::$includeVersionCache[$revId]['templates'][$namespace][$dbKey];
				}
			}
			return false; // missing?
		}
		return null; // cache not found
	}
	
	/**
	 * Get image versioning cache for parser
	 * @param int $revID
	 * @param string $dbKey
	 * @returns mixed (array/null)
	 */
	public static function getFileVersionFromCache( $revId, $dbKey ) {
		self::load();
		if( isset(self::$includeVersionCache[$revId]) ) {
			# All NS_FILE, no need to check namespace
			if( isset(self::$includeVersionCache[$revId]['files'][$dbKey]) ) {
				$time_SHA1 = self::$includeVersionCache[$revId]['files'][$dbKey];
				foreach( $time_SHA1 as $time => $sha1 ) {
					// Should only be one, but this is an easy check
					return array($time,$sha1);
				}
				return array(false,""); // missing?
			}
		}
		return null; // cache not found
	}
	
	################# Synchronization and link update functions #################
	
	/**
	* @param FlaggedRevision $srev, the stable revision
	* @param Article $article
	* @param ParserOutput $stableOutput, will fetch if not given
	* @param ParserOutput $currentOutput, will fetch if not given
	* @return bool
	* See if a flagged revision is synced with the current.
	* This function is pretty expensive...
	*/	
	public static function stableVersionIsSynced( $srev, $article, $stableOutput=null, $currentOutput=null ) {
		global $wgMemc, $wgEnableParserCache;
		# Must be the same revision as the current
		if( $srev->getRevId() < $article->getTitle()->getLatestRevID() ) {
			return false;
		}
		# Must have same file
		if( $article instanceof ImagePage && $article->getFile() ) {
			if( $srev->getFileTimestamp() < $article->getFile()->getTimestamp() ) {
				return false;
			}
		}
		# Try the cache...
		$key = wfMemcKey( 'flaggedrevs', 'includesSynced', $article->getId() );
		$value = self::getMemcValue( $wgMemc->get($key), $article );
		if( $value === "true" ) {
			return true;
		} else if( $value === "false" ) {
			return false;
		}
		# If parseroutputs not given, fetch them...
		if( is_null($stableOutput) || !isset($stableOutput->fr_newestTemplateID) ) {
			# Get parsed stable version
			$stableOutput = self::getPageCache( $article );
			if( $stableOutput == false ) {
				$text = $srev->getRevText();
	   			$stableOutput = self::parseStableText( $article, $text, $srev->getRevId() );
	   			# Update the stable version cache
				self::updatePageCache( $article, $stableOutput );
	   		}
		}
		if( is_null($currentOutput) || !isset($currentOutput->fr_newestTemplateID) ) {
			global $wgUser, $wgParser;
			# Get parsed current version
			$parserCache = ParserCache::singleton();
			$currentOutput = false;
			# If $text is set, then the stableOutput is new. In that case,
			# the current must also be new to avoid sync goofs.
			if( !isset($text) ) {
				# Try anon user cache first...
				if( $wgUser->getId() ) {
					$anon = User::newFromId( 0 );
					$currentOutput = $parserCache->get( $article, $anon );
				}
				# Cache for this user...
				if( $currentOutput == false )
					$currentOutput = $parserCache->get( $article, $wgUser );
			}
			# Regenerate the parser output as needed...
			if( $currentOutput == false ) {
				$rev = Revision::newFromTitle( $article->getTitle() );
				$text = $rev ? $rev->getText() : false;
				$title = $article->getTitle();
				$options = self::makeParserOptions();
				$currentOutput = $wgParser->parse( $text, $title, $options );
				# Might as well save the cache while we're at it
				if( $wgEnableParserCache )
					$parserCache->save( $currentOutput, $article, $wgUser );
			}
		}
		# Only current of revisions of inclusions can be reviewed. Since the stable and current revisions
		# have the same text, the only thing that can make them different is updating a template or image.
		# If this is the case, the current revision will have a newer template or image version used somewhere. 
		if( $currentOutput->fr_newestImageTime > $stableOutput->fr_newestImageTime ) {
			$synced = false;
		} else if( $currentOutput->fr_newestTemplateID > $stableOutput->fr_newestTemplateID ) {
			$synced = false;
		} else {
			$synced = true;
		}
		# Save to cache. This will be updated whenever the page is re-parsed as well. This means
		# that MW can check a light-weight key first.
		global $wgParserCacheExpireTime;
		$data = self::makeMemcObj( $synced ? "true" : "false" );
		$wgMemc->set( $key, $data, $wgParserCacheExpireTime );

		return $synced;
	}

	/**
	 * @param string $val
	 * @return obj array
	 * Get a memcache storage object
	 */
	public static function makeMemcObj( $val ) {
		$data = (object) array();
		$data->value = $val;
		$data->time = wfTimestampNow();
		return $data;
	}
	
	/**
	* @param mixed $data Memc data returned
	* @param Article $article
	* @return mixed
	* Return memc value if not expired
	*/		
	public static function getMemcValue( $data, $article ) {
		if( is_object($data) && $data->time >= $article->getTouched() ) {
			return $data->value;
		}
		return false;
	}
	
	/**
	 * @param Article $article
	 * @param int $revId, the *stable* rev ID
	 * @param bool $forUpdate, use master?
	 * @return int
	 * Get number of revs since the stable revision
	 */
	public static function getRevCountSince( $article, $revId, $forUpdate=false ) {
		global $wgMemc, $wgParserCacheExpireTime;
		# Try the cache
		$count = null;
		$key = wfMemcKey( 'flaggedrevs', 'unreviewedrevs', $article->getId() );
		if( !$forUpdate ) {
			$val = $wgMemc->get($key);
			$count = is_integer($val) ? $val : null;
		}
		if( is_null($count) ) {
			$db = $forUpdate ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$count = $db->selectField( 'revision', 'COUNT(*)',
				array('rev_page' => $article->getId(), "rev_id > " . intval($revId) ),
				__METHOD__ );
			# Save to cache
			$wgMemc->set( $key, intval($count), $wgParserCacheExpireTime );
		}
		return $count;
	}
	
	/**
	 * @param Article $article
	 * @param string $tag
	 * @param bool $forUpdate, use master?
	 * @return array(real,int)
	 * Get article rating for this tag for the last few days
	 */
	public static function getAverageRating( $article, $tag, $forUpdate=false ) {
		global $wgFlaggedRevsFeedbackAge;
		$cutoff_unixtime = time() - $wgFlaggedRevsFeedbackAge;
		$db = $forUpdate ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$row = $db->selectRow( 'reader_feedback_history', 
			array('SUM(rfh_total)/SUM(rfh_count) AS ave, SUM(rfh_count) AS count'),
			array( 'rfh_page_id' => $article->getId(), 'rfh_tag' => $tag,
				"rfh_date >= {$cutoff_unixtime}" ),
			__METHOD__ );
		$data = $row ? array($row->ave,$row->count) : array(0,0);
		return $data;
	}
	
 	/**
	* @param Article $article
	* @param Revision $rev, the new stable version
	* @param mixed $latest, the latest rev ID (optional)
	* Updates the flaggedpages fields
	*/
	public static function updateArticleOn( $article, $rev, $latest=NULL ) {
		if( !$article->getId() ) return true; // no bogus entries
		$revId = $rev->getId();
		# Get the latest revision ID
		$lastID = $latest ? $latest : $article->getTitle()->getLatestRevID(GAID_FOR_UPDATE);
		# Get the highest quality revision (not necessarily this one)
		$dbw = wfGetDB( DB_MASTER );
		$maxQuality = $dbw->selectField( array('flaggedrevs','revision'),
			'fr_quality',
			array( 'fr_page_id' => $article->getId(),
				'rev_id = fr_rev_id',
				'rev_page = fr_page_id',
				'rev_deleted & '.Revision::DELETED_TEXT => 0
			),
			__METHOD__,
			array( 'ORDER BY' => 'fr_quality DESC', 'LIMIT' => 1 ) 
		);
		# Get the timestamp of the edit after the stable version (if any)
		if( $lastID != $revId ) {
			# Get the latest revision ID
			$timestamp = $rev->getTimestamp();
			$nextTimestamp = $dbw->selectField( 'revision',
				'rev_timestamp',
				array( 'rev_page' => $article->getId(),
					"rev_timestamp > ".$dbw->addQuotes( $dbw->timestamp($timestamp) ) ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 1 )
			);
		} else {
			$nextTimestamp = null;
		}
		# Alter table metadata
		$dbw->replace( 'flaggedpages',
			array( 'fp_page_id' ),
			array( 'fp_stable'     => $revId,
				'fp_reviewed'      => ($lastID == $revId) ? 1 : 0,
				'fp_quality'       => ($maxQuality === false) ? null : $maxQuality,
				'fp_page_id'       => $article->getId(),
				'fp_pending_since' => $nextTimestamp ? $dbw->timestamp($nextTimestamp) : null ),
			__METHOD__ 
		);
		# Alter pending edit tracking table
		$data = array();
		$level = self::pristineVersions() ? 2 : 1;
		if( !self::qualityVersions() ) $level--;
		# Update pending times for each level
		while( $level >= 0 ) {
			# Get the latest revision of this level...
			$row = $dbw->selectRow( array('flaggedrevs','revision'),
				array( 'fr_rev_id', 'rev_timestamp' ),
				array( 'fr_page_id' => $article->getId(),
					'fr_quality' => $level,
					'rev_id = fr_rev_id',
					'rev_page = fr_page_id',
					'rev_deleted & '.Revision::DELETED_TEXT => 0 ),
				__METHOD__,
				array( 'ORDER BY' => 'fr_rev_id DESC', 'LIMIT' => 1 ) 
			);
			# If there is a revision of this level, track it...
			if( $row ) {
				$revId = intval( $row->fr_rev_id );
				# Get the timestamp of the edit after this version (if any)
				if( $lastID != $revId ) {
					$nextTimestamp = $dbw->selectField( 'revision',
						'rev_timestamp',
						array( 'rev_page' => $article->getId(),
							"rev_timestamp > ".$dbw->addQuotes( $row->rev_timestamp ) ),
						__METHOD__,
						array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 1 )
					);
					$data[] = array(
						'fpp_page_id'       => $article->getId(),
						'fpp_quality'       => $level,
						'fpp_rev_id'        => $revId,
						'fpp_pending_since' => $nextTimestamp
					);
				}
			}
			$level--;
		}
		# Clear any old junk, and insert new rows
		$dbw->delete( 'flaggedpage_pending', array('fpp_page_id' => $article->getId()), __METHOD__ );
		$dbw->insert( 'flaggedpage_pending', $data, __METHOD__ );
		# Updates the count cache
		$count = self::getRevCountSince( $article, $revId, true );

		return true;
	}
	
	/**
	* Clears cache for a page when merges are done.
	* We may have lost the stable revision to another page.
	*/
	public static function articleLinksUpdate( $article ) {
		global $wgUser, $wgParser;
		# Update the links tables as the stable version may now be the default page...
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if( $poutput==false ) {
			$text = $article->getContent();
			$options = self::makeParserOptions();
			$poutput = $wgParser->parse($text, $article->getTitle(), $options);
		}
		$u = new LinksUpdate( $article->getTitle(), $poutput );
		$u->doUpdate(); // this will trigger our hook to add stable links too...
		return true;
	}

	/**
	* Clears cache for a page when revisiondelete/undelete is used
	*/
	public static function titleLinksUpdate( $title ) {
		return self::articleLinksUpdate( new Article($title) );
	}
	
	################# Revision functions #################
	
	/**
	 * Get flags for a revision
	 * @param Title $title
	 * @param int $rev_id
	 * @return Array
	*/
	public static function getRevisionTags( $title, $rev_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$tags = $dbr->selectField( 'flaggedrevs', 'fr_tags',
			array( 'fr_rev_id' => $rev_id,
				'fr_page_id' => $title->getArticleId() ),
			__METHOD__ );
		$tags = $tags ? $tags : "";
		return FlaggedRevision::expandRevisionTags( strval($tags) );
	}
	
	/**
	 * @param Title $title
	 * @param int $rev_id
	 * @param $flags, GAID_FOR_UPDATE
	 * @returns mixed (int or false)
	 * Get quality of a revision
	 */
	public static function getRevQuality( $title, $rev_id, $flags=0 ) {
		$db = ($flags & GAID_FOR_UPDATE) ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$quality = $db->selectField( 'flaggedrevs', 
			'fr_quality',
			array( 'fr_page_id' => $title->getArticleID( $flags ),
				'fr_rev_id' => $rev_id ),
			__METHOD__,
			array( 'USE INDEX' => 'PRIMARY' )
		);
		return $quality;
	}
	
	/**
	 * @param Title $title
	 * @param int $rev_id
	 * @param $flags, GAID_FOR_UPDATE
	 * @returns bool
	 * Useful for quickly pinging to see if a revision is flagged
	 */
	public static function revIsFlagged( $title, $rev_id, $flags=0 ) {
		$quality = self::getRevQuality( $title, $rev_id, $flags );
		return ($quality !== false);
	}
	
	/**
	 * Get the "prime" flagged revision of a page
	 * @param Article $article
	 * @returns mixed (integer/false)
	 * Will not return a revision if deleted
	 */
	public static function getPrimeFlaggedRevId( $article ) {
		$dbr = wfGetDB( DB_SLAVE );
		# Get the highest quality revision (not necessarily this one).
		$oldid = $dbr->selectField( array('flaggedrevs','revision'),
			'fr_rev_id',
			array( 'fr_page_id' => $article->getId(),
				'rev_page = fr_page_id',
				'rev_id = fr_rev_id'),
			__METHOD__,
			array( 'ORDER BY' => 'fr_quality DESC, fr_rev_id DESC',
				'USE INDEX' => array('flaggedrevs' => 'page_qal_rev','revision' => 'PRIMARY') )
		);
		return $oldid;
	}
	
	/**
	 * Mark a revision as patrolled if needed
	 * @param Revision $rev
	 * @returns bool DB write query used
	 */
	public static function markRevisionPatrolled( $rev ) {
		$rcid = $rev->isUnpatrolled();
		# Make sure it is now marked patrolled...
		if( $rcid ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 1 ),
				array( 'rc_id' => $rcid ),
				__METHOD__
			);
			return true;
		}
		return false;
	}
	
	################# Page configuration functions #################

	/**
	 * Get visibility restrictions on page
	 * @param Title $title, page title
	 * @param bool $forUpdate, use master DB?
	 * @returns Array (select,override)
	 */
	public static function getPageVisibilitySettings( &$title, $forUpdate=false ) {
		$db = $forUpdate ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$row = $db->selectRow( 'flaggedpage_config',
			array( 'fpc_select', 'fpc_override', 'fpc_level', 'fpc_expiry' ),
			array( 'fpc_page_id' => $title->getArticleID() ),
			__METHOD__
		);
		if( $row ) {
			$now = wfTimestampNow();
			# This code should be refactored, now that it's being used more generally.
			$expiry = Block::decodeExpiry( $row->fpc_expiry );
			# Only apply the settings if they haven't expired
			if( !$expiry || $expiry < $now ) {
				$row = null;
				self::purgeExpiredConfigurations();
				$title->invalidateCache();
			}
		}
		if( !$row ) {
			global $wgFlaggedRevsOverride, $wgFlaggedRevsPrecedence;
			# Keep this consistent across settings. 1 -> override, 0 -> don't
			$override = $wgFlaggedRevsOverride ? 1 : 0;
			# Keep this consistent across settings: 
			## 2 = pristine -> quality -> stable; 
			## 1 = quality -> stable
			## 0 = none
			$select = self::getPrecedence();
			return array( 'select' => $select, 'override' => $override,
				'autoreview' => '', 'expiry' => 'infinity' );
		}
		return array('select' => $row->fpc_select, 'override' => $row->fpc_override,
			'autoreview' => $row->fpc_level, 'expiry' => $row->fpc_expiry );
	}
	
	/**
	 * Purge expired restrictions from the flaggedpage_config table
	 */
	public static function purgeExpiredConfigurations() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'flaggedpage_config',
			array( 'fpc_expiry < ' . $dbw->addQuotes( $dbw->timestamp() ) ),
			__METHOD__
		);
	}
	
	################# Other utility functions #################

	/**
	* @param Array $flags
	* @return bool, is this revision at quality condition?
	*/
	public static function isQuality( $flags ) {
		if( empty($flags) ) return false;
		foreach( self::$dimensions as $f => $x ) {
			if( !isset($flags[$f]) || self::$minQL[$f] > $flags[$f] )
				return false;
		}
		return true;
	}

	/**
	* @param Array $flags
	* @return bool, is this revision at optimal condition?
	*/
	public static function isPristine( $flags ) {
		if( empty($flags) ) return false;
		foreach( self::$dimensions as $f => $x ) {
			if( !isset($flags[$f]) || self::$minPL[$f] > $flags[$f] )
				return false;
		}
		return true;
	}
	
	/**
	* Is this page in reviewable namespace?
	* @param Title, $title
	* @return bool
	*/
	public static function isPageReviewable( $title ) {
		global $wgFlaggedRevsNamespaces, $wgFlaggedRevsWhitelist;
		# FIXME: Treat NS_MEDIA as NS_FILE
		$ns = ( $title->getNamespace() == NS_MEDIA ) ? NS_FILE : $title->getNamespace();
		# Check for MW: pages and whitelist for exempt pages
		if( $ns == NS_MEDIAWIKI || in_array( $title->getPrefixedDBKey(), $wgFlaggedRevsWhitelist ) ) {
			return false;
		}
		return ( in_array($ns,$wgFlaggedRevsNamespaces) && !$title->isTalkPage() );
	}
	
	/**
	* Is this page in rateable namespace?
	* @param Title, $title
	* @return bool
	*/
	public static function isPageRateable( $title ) {
		global $wgFeedbackNamespaces, $wgFlaggedRevsWhitelist;
		# FIXME: Treat NS_MEDIA as NS_FILE
		$ns = ( $title->getNamespace() == NS_MEDIA ) ? NS_FILE : $title->getNamespace();
		# Check for MW: pages and whitelist for exempt pages
		if( $ns == NS_MEDIAWIKI || in_array( $title->getPrefixedDBKey(), $wgFlaggedRevsWhitelist ) ) {
			return false;
		}
		return ( in_array($ns,$wgFeedbackNamespaces) && !$title->isTalkPage() );
	}
	
	/**
	* Is this page in patrolable namespace?
	* @param Title, $title
	* @return bool
	*/
	public static function isPagePatrollable( $title ) {
		global $wgFlaggedRevsPatrolNamespaces;
		# No collisions!
		if( self::isPageReviewable($title) ) {
			return false;
		}
		# FIXME: Treat NS_MEDIA as NS_FILE
		$ns = ( $title->getNamespace() == NS_MEDIA ) ? NS_FILE : $title->getNamespace();
		return ( in_array($ns,$wgFlaggedRevsPatrolNamespaces) );
	}
	
	/**
	 * Make stable version link and return the css
	 * @param Title $title
	 * @param Row $row, from history page
	 * @returns array (string,string)
	 */
	public static function markHistoryRow( $title, $row, $skin ) {
		if( isset($row->fr_quality) && isset($row->fr_flags) ) {
			wfLoadExtensionMessages( 'FlaggedRevs' );
			$css = FlaggedRevsXML::getQualityColor( $row->fr_quality );
			$user = User::whois( $row->fr_user ); // FIXME: o(N)
			$flags = explode(',',$row->fr_flags);
			if( in_array('auto',$flags) ) {
				$msg = 'hist-autoreviewed';
			} else {
				$msg = ($row->fr_quality >= 1) ? 'hist-quality-user' : 'hist-stable-user';
			}
			$st = $title->getPrefixedDBkey();
			$link = "<span class='fr-$msg plainlinks'>[" .
				wfMsgExt($msg,array('parseinline'),$st,$row->rev_id,$user) . "]</span>";
		} else {
			return array("","");
		}
		return array($link,$css);
	}
	
   	/**
	* Get params for a user
	* @param int $uid
	*/
	public static function getUserParams( $uid ) {
		$dbw = wfGetDB( DB_MASTER );
		$row = $dbw->selectRow( 'flaggedrevs_promote', 'frp_user_params',
			array( 'frp_user_id' => $uid ),
			__METHOD__ );
		# Parse params
		$params = array();
		if( $row ) {
			$flatPars = explode( "\n", trim($row->frp_user_params) );
			foreach( $flatPars as $pair ) {
				$m = explode( '=', trim($pair), 2 );
				$key = $m[0];
				$value = isset($m[1]) ? $m[1] : null;
				$params[$key] = $value;
			}
		}
		return $params;
	}
	
   	/**
	* Save params for a user
	* @param int $uid
	* @param Array $params
	*/
	public static function saveUserParams( $uid, $params ) {
		$flatParams = '';
		foreach( $params as $key => $value ) {
			$flatParams .= "{$key}={$value}\n";
		}
		$dbw = wfGetDB( DB_MASTER );
		$row = $dbw->replace( 'flaggedrevs_promote', 
			array( 'frp_user_id' ),
			array( 'frp_user_id' => $uid, 'frp_user_params' => trim($flatParams) ),
			__METHOD__
		);
		return ( $dbw->affectedRows() > 0 );
	}
	
   	/**
	* Expand feedback ratings into an array
	* @param string $ratings
	* @returns Array
	*/
	public static function expandRatings( $rating ) {
		$dims = array();
		$pairs = explode( "\n", $rating );
		foreach( $pairs as $pair ) {
			if( strpos($pair,'=') ) {
				list($tag,$value) = explode( '=', trim($pair), 2 );
				$dims[$tag] = intval($value);
			}
		}
		return $dims;
	}
	
   	/**
	* Get a table of the vote totals for a page
	* @param Title $page
	* @param int $period, number of days back
	* @param array $add, optional vote to add on (used to visually avoid lag)
	* @param string $cache, optional param to not use cache
	* @returns string HTML table
	*/	
	public static function getVoteAggregates( $page, $period, $add = array(), $cache = 'useCache' ) {
		global $wgLang, $wgMemc;
		if( $period > 93 ) {
			return ''; // too big
		}
		$votes = null;
		$now = time();
		$key = wfMemcKey( 'flaggedrevs', 'ratingtally', $page->getArticleId(), $period );
		// Check cache
		if( $cache == 'useCache' ) {
			$set = $wgMemc->get($key);
			// Cutoff is at the 24 hour mark due to the way the aggregate 
			// schema groups ratings by date for graphs.
			$cache_cutoff = $now - ($now % 86400);
			if( is_array($set) && count($set) == 2 ) {
				list($val,$time) = $set;
				$touched = wfTimestamp( TS_UNIX, RatingHistory::getTouched($page) );
				if( $time > $cache_cutoff && $time > $touched ) {
					$votes = $val;
				}
			}
		}
		// Do query, cache miss
		if( !isset($votes) ) {
			// Set cutoff time for period
			$dbr = wfGetDB( DB_SLAVE );
			$cutoff_unixtime = $now - ($period * 24 * 3600);
			// Use integral number of days to be consistent with graphs
			$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
			$cutoff = $dbr->addQuotes( wfTimestamp( TS_MW, $cutoff_unixtime ) );
			// Get the first revision possibly voted on in the range
			$firstRevTS = $dbr->selectField( 'revision',
				'rev_timestamp',
				array( 'rev_page' => $page->getArticleId(), "rev_timestamp <= $cutoff" ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp DESC' )
			);
			// Find average, median...
			$res = $dbr->select( array( 'revision', 'reader_feedback' ),
				array( 'rfb_ratings' ),
				array( 'rev_page' => $page->getArticleId(),
					"rev_id = rfb_rev_id",
					"rfb_timestamp >= $cutoff",
					// Trigger INDEX usage
					"rev_timestamp >= ".$dbr->addQuotes($firstRevTS) ),
				__METHOD__,
				array( 'USE INDEX' => array('revision' => 'page_timestamp') )
			);
			$votes = array();
			foreach( FlaggedRevs::getFeedbackTags() as $tag => $w ) {
				$votes[$tag] = array( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0 );
			}
			// Read votes and tally the numbers
			while( $row = $dbr->fetchObject($res) ) {
				$dims = FlaggedRevs::expandRatings( $row->rfb_ratings );
				foreach( $dims as $tag => $val ) {
					if( isset($votes[$tag]) && isset($votes[$tag][$val]) ) {
						$votes[$tag][$val]++;
					}
				}
			}
			// Tack on $add for display (used to avoid cache/lag)
			foreach( $add as $tag => $val ) {
				if( isset($votes[$tag]) && isset($votes[$tag][$val]) ) {
					$votes[$tag][$val]++;
				}
			}
			$wgMemc->set( $key, array( $votes, $now ), 24*3600 );
		}
		// Output multi-column list
		$html = "<table class='fr_reader_feedback_table' cellspacing='0'><tr>";
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $w ) {
			// Get tag average...
			$dist = isset($votes[$tag]) ? $votes[$tag] : array();
			$count = array_sum($dist);
			if( $count ) {
				$ave = ($dist[0] + 2*$dist[1] + 3*$dist[2] + 4*$dist[3] + 5*$dist[4])/$count;
				$ave = round($ave,1);
			} else {
				$ave = '-'; // DIV by zero
			}
			$html .= '<td align="center"><b>'.wfMsgHtml("readerfeedback-$tag").'</b>&nbsp;&nbsp;'.
				'<sup>('.wfMsgHtml('ratinghistory-ave',$wgLang->formatNum($ave)).')</sup></td>';
		}
		$html .= '</tr><tr>';
		foreach( $votes as $tag => $dist ) {
			$html .= '<td><table>';
			$html .= '<tr><th align="left">'.wfMsgHtml('ratinghistory-table-rating').'</th>';
			for( $i = 1; $i <= 5; $i++ ) {
				$html .= "<td align='center' class='fr-rating-option-".($i-1)."'>$i</td>";
			}
			$html .= '</tr><tr>';
			$html .= '<th align="left">'.wfMsgHtml("ratinghistory-table-votes").'</th>';
			$html .= '<td align="center">'.$dist[0].'</td>';
			$html .= '<td align="center">'.$dist[1].'</td>';
			$html .= '<td align="center">'.$dist[2].'</td>';
			$html .= '<td align="center">'.$dist[3].'</td>';
			$html .= '<td align="center">'.$dist[4].'</td>';
			$html .= "</tr></table></td>\n";
		}
		$html .= '</tr></table>';
		return $html;
	}
	
	################# Auto-review function #################

	/**
	* Automatically review an edit and add a log entry in the review log.
	* LinksUpdate was already called via edit operations, so the page
	* fields will be up to date. This updates the stable version.
	*
	* $auto is here for revisions checked off to be reviewed. Auto-review
	* triggers on edit, but we don't want it to count as just automatic.
	* This also makes it so the user's name shows up in the page history.
	*/
	public static function autoReviewEdit( $article, $user, $text, $rev, $flags, $auto=true ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		# Default tags to level 1 for each dimension
		if( !is_array($flags) ) {
			$flags = array();
			foreach( self::getDimensions() as $tag => $minQL ) {
				$flags[$tag] = 1;
			}
		}
		$quality = 0;
		if( self::isQuality($flags) ) {
			$quality = self::isPristine($flags) ? 2 : 1;
		}

		$tmpset = $imgset = array();
		$poutput = false;

		$title = $article->getTitle();
		# Rev ID is not put into parser on edit, so do the same here.
		# Also, a second parse would be triggered otherwise.
		$editInfo = $article->prepareTextForEdit( $text ); // Parse the revision HTML output
		$poutput = $editInfo->output;
		
		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $title );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;

		# NS:title -> rev ID mapping
		foreach( $poutput->mTemplateIds as $namespace => $titleAndID ) {
			foreach( $titleAndID as $dbkey => $id ) {
				$tmpset[] = array(
					'ft_rev_id' => $rev->getId(),
					'ft_namespace' => $namespace,
					'ft_title' => $dbkey,
					'ft_tmp_rev_id' => $id
				);
			}
		}
		# Image -> timestamp mapping
		foreach( $poutput->fr_ImageSHA1Keys as $dbkey => $timeAndSHA1 ) {
			foreach( $timeAndSHA1 as $time => $sha1 ) {
				$imgset[] = array(
					'fi_rev_id' => $rev->getId(),
					'fi_name' => $dbkey,
					'fi_img_timestamp' => $time,
					'fi_img_sha1' => $sha1
				);
			}
		}

		# If this is an image page, store corresponding file info
		$fileData = array();
		if( $title->getNamespace() == NS_FILE ) {
			$file = $article instanceof ImagePage ? $article->getFile() : wfFindFile($title);
			if( is_object($file) && $file->exists() ) {
				$fileData['name'] = $title->getDBkey();
				$fileData['timestamp'] = $file->getTimestamp();
				$fileData['sha1'] = $file->getSha1();
			}
		}

		# Our review entry
		$flaggedRevision = new FlaggedRevision( array(
			'fr_page_id'       => $rev->getPage(),
			'fr_rev_id'	       => $rev->getId(),
			'fr_user'	       => $user->getId(),
			'fr_timestamp'     => $rev->getTimestamp(),
			'fr_comment'       => "",
			'fr_quality'       => $quality,
			'fr_tags'	       => FlaggedRevision::flattenRevisionTags( $flags ),
			'fr_img_name'      => $fileData ? $fileData['name'] : null,
			'fr_img_timestamp' => $fileData ? $fileData['timestamp'] : null,
			'fr_img_sha1'      => $fileData ? $fileData['sha1'] : null
		) );
		$flaggedRevision->insertOn( $tmpset, $imgset, $auto );
		# Update the article review log
		RevisionReview::updateLog( $title, $flags, array(), '', $rev->getId(), $oldSvId, true, $auto );

		# If we know that this is now the new stable version 
		# (which it probably is), save it to the cache...
		$sv = FlaggedRevision::newFromStable( $article->getTitle(), FR_FOR_UPDATE );
		if( $sv && $sv->getRevId() == $rev->getId() ) {
			# Update stable cache
			self::updatePageCache( $article, $poutput );
			# Update page fields
			self::updateArticleOn( $article, $rev, $rev->getId() );
			# We can set the sync cache key already.
			global $wgParserCacheExpireTime;
			$key = wfMemcKey( 'flaggedrevs', 'includesSynced', $article->getId() );
			$data = FlaggedRevs::makeMemcObj( "true" );
			$wgMemc->set( $key, $data, $wgParserCacheExpireTime );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * Get JS script params for onloading
	 */
	public static function getJSTagParams() {
		self::load();
		# Param to pass to JS function to know if tags are at quality level
		$tagsJS = array();
		foreach( self::$dimensions as $tag => $x ) {
			$tagsJS[$tag] = self::$minQL[$tag];
		}
		$params = array( 'tags' => (object)$tagsJS );
		return Xml::encodeJsVar( (object)$params );
	}
	
	/**
	 * Get JS script params for onloading
	 */
	public static function getJSFeedbackParams() {
		self::load();
		# Param to pass to JS function to know if tags are at quality level
		global $wgFlaggedRevsFeedbackTags;
		$params = array( 'tags' => (object)$wgFlaggedRevsFeedbackTags );
		return Xml::encodeJsVar( (object)$params );
	}
	
	/**
	 * Get template and image parameters from parser output
	 * @param Article $article
	 * @param array $templateIDs (from ParserOutput/OutputPage->mTemplateIds)
	 * @param array $imageSHA1Keys (from ParserOutput/OutputPage->fr_ImageSHA1Keys)
	 * @returns array( templateParams, imageParams, fileVersion )
	 */
	public static function getIncludeParams( $article, $templateIDs, $imageSHA1Keys ) {
		$templateParams = $imageParams = $fileVersion = '';
		# NS -> title -> rev ID mapping
		foreach( $templateIDs as $namespace => $t ) {
			foreach( $t as $dbKey => $revId ) {
				$temptitle = Title::makeTitle( $namespace, $dbKey );
				$templateParams .= $temptitle->getPrefixedDBKey() . "|" . $revId . "#";
			}
		}
		# Image -> timestamp -> sha1 mapping
		foreach( $imageSHA1Keys as $dbKey => $timeAndSHA1 ) {
			foreach( $timeAndSHA1 as $time => $sha1 ) {
				$imageParams .= $dbKey . "|" . $time . "|" . $sha1 . "#";
			}
		}
		# For image pages, note the displayed image version
		if( $article instanceof ImagePage ) {
			$file = $article->getDisplayedFile();
			$fileVersion = $file->getTimestamp() . "#" . $file->getSha1();
		}
		return array( $templateParams, $imageParams, $fileVersion );
	}
}
