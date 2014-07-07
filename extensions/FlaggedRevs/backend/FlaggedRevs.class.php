<?php
/**
 * Class containing utility functions for a FlaggedRevs environment
 *
 * Class is lazily-initialized, calling load() as needed
 */
class FlaggedRevs {
	# Tag name/level config
	protected static $dimensions = array();
	protected static $minSL = array();
	protected static $minQL = array();
	protected static $minPL = array();
	protected static $qualityVersions = false;
	protected static $pristineVersions = false;
	protected static $tagRestrictions = array();
	protected static $binaryFlagging = true;
	# Namespace config
	protected static $reviewNamespaces = array();
	# Restriction levels/config
	protected static $restrictionLevels = array();
	# Autoreview config
	protected static $autoReviewConfig = 0;

	protected static $loaded = false;

	protected static function load() {
		global $wgFlaggedRevsTags, $wgFlaggedRevTags;
		if ( self::$loaded ) {
			return true;
		}
		if ( !FlaggedRevsSetup::isReady() ) { // sanity
			wfDebugDieBacktrace( 'FlaggedRevs config loaded too soon! Possibly before LocalSettings.php!' );
		}
		self::$loaded = true;
		$flaggedRevsTags = null;
		if ( isset( $wgFlaggedRevTags ) ) {
			$flaggedRevsTags = $wgFlaggedRevTags; // b/c
			wfWarn( 'Please use $wgFlaggedRevsTags instead of $wgFlaggedRevTags in config.' );
		} elseif ( isset( $wgFlaggedRevsTags ) ) {
			$flaggedRevsTags = $wgFlaggedRevsTags;
		}
		# Assume true, then set to false if needed
		if ( !empty( $flaggedRevsTags ) ) {
			self::$qualityVersions = true;
			self::$pristineVersions = true;
			self::$binaryFlagging = ( count( $flaggedRevsTags ) <= 1 );
		}
		foreach ( $flaggedRevsTags as $tag => $levels ) {
			# Sanity checks
			$safeTag = htmlspecialchars( $tag );
			if ( !preg_match( '/^[a-zA-Z]{1,20}$/', $tag ) || $safeTag !== $tag ) {
				die( 'FlaggedRevs given invalid tag name!' );
			}
			# Define "quality" and "pristine" reqs
			if ( is_array( $levels ) ) {
				$minQL = $levels['quality'];
				$minPL = $levels['pristine'];
				$ratingLevels = $levels['levels'];
			# B/C, $levels is just an integer (minQL)
			} else {
				global $wgFlaggedRevPristine, $wgFlaggedRevValues;
				$ratingLevels = isset( $wgFlaggedRevValues ) ?
					$wgFlaggedRevValues : 1;
				$minQL = $levels; // an integer
				$minPL = isset( $wgFlaggedRevPristine ) ?
					$wgFlaggedRevPristine : $ratingLevels + 1;
				wfWarn( 'Please update the format of $wgFlaggedRevsTags in config.' );
			}
			# Set FlaggedRevs tags
			self::$dimensions[$tag] = array();
			for ( $i = 0; $i <= $ratingLevels; $i++ ) {
				self::$dimensions[$tag][$i] = "{$tag}-{$i}";
			}
			if ( $ratingLevels > 1 ) {
				self::$binaryFlagging = false; // more than one level
			}
			# Sanity checks
			if ( !is_integer( $minQL ) || !is_integer( $minPL ) ) {
				die( 'FlaggedRevs given invalid tag value!' );
			}
			if ( $minQL > $ratingLevels ) {
				self::$qualityVersions = false;
				self::$pristineVersions = false;
			}
			if ( $minPL > $ratingLevels ) {
				self::$pristineVersions = false;
			}
			self::$minQL[$tag] = max( $minQL, 1 );
			self::$minPL[$tag] = max( $minPL, 1 );
			self::$minSL[$tag] = 1;
		}
		global $wgFlaggedRevsTagsRestrictions, $wgFlagRestrictions;
		if ( isset( $wgFlagRestrictions ) ) {
			self::$tagRestrictions = $wgFlagRestrictions; // b/c
			wfWarn( 'Please use $wgFlaggedRevsTagsRestrictions instead of $wgFlagRestrictions in config.' );
		} else {
			self::$tagRestrictions = $wgFlaggedRevsTagsRestrictions;
		}
		# Make sure that the restriction levels are unique
		global $wgFlaggedRevsRestrictionLevels;
		self::$restrictionLevels = array_unique( $wgFlaggedRevsRestrictionLevels );
		self::$restrictionLevels = array_filter( self::$restrictionLevels, 'strlen' );
		# Make sure no talk namespaces are in review namespace
		global $wgFlaggedRevsNamespaces;
		foreach ( $wgFlaggedRevsNamespaces as $ns ) {
			if ( MWNamespace::isTalk( $ns ) ) {
				die( 'FlaggedRevs given talk namespace in $wgFlaggedRevsNamespaces!' );
			} elseif ( $ns == NS_MEDIAWIKI ) {
				die( 'FlaggedRevs given NS_MEDIAWIKI in $wgFlaggedRevsNamespaces!' );
			}
		}
		self::$reviewNamespaces = $wgFlaggedRevsNamespaces;
		# Handle $wgFlaggedRevsAutoReview settings
		global $wgFlaggedRevsAutoReview, $wgFlaggedRevsAutoReviewNew;
		if ( is_int( $wgFlaggedRevsAutoReview ) ) {
			self::$autoReviewConfig = $wgFlaggedRevsAutoReview;
		} else { // b/c
			if ( $wgFlaggedRevsAutoReview ) {
				self::$autoReviewConfig = FR_AUTOREVIEW_CHANGES;
			}
			wfWarn( '$wgFlaggedRevsAutoReview is now a bitfield instead of a boolean.' );
		}
		if ( isset( $wgFlaggedRevsAutoReviewNew ) ) { // b/c
			self::$autoReviewConfig = ( $wgFlaggedRevsAutoReviewNew )
				? self::$autoReviewConfig |= FR_AUTOREVIEW_CREATION
				: self::$autoReviewConfig & ~FR_AUTOREVIEW_CREATION;
			wfWarn( '$wgFlaggedRevsAutoReviewNew is deprecated; use $wgFlaggedRevsAutoReview.' );
		}
	}

	# ################ Basic config accessors #################

	/**
	 * Is there only one tag and it has only one level?
	 * @return bool
	 */
	public static function binaryFlagging() {
		self::load();
		return self::$binaryFlagging;
	}

	/**
	 * If there only one tag and it has only one level, return it
	 * @return string
	 */
	public static function binaryTagName() {
		self::load();
		if ( !self::binaryFlagging() ) {
			return null;
		}
		$tags = array_keys( self::$dimensions );
		return empty( $tags ) ? null : $tags[0];
	}

	/**
	 * Are quality versions enabled?
	 * @return bool
	 */
	public static function qualityVersions() {
		self::load();
		return self::$qualityVersions;
	}

	/**
	 * Are pristine versions enabled?
	 * @return bool
	 */
	public static function pristineVersions() {
		self::load();
		return self::$pristineVersions;
	}

	/**
	 * Get the highest review tier that is enabled
	 * @return int One of FR_PRISTINE,FR_QUALITY,FR_CHECKED
	 */
	public static function highestReviewTier() {
		self::load();
		if ( self::$pristineVersions ) {
			return FR_PRISTINE;
		} elseif ( self::$qualityVersions ) {
			return FR_QUALITY;
		}
		return FR_CHECKED;
	}

	/**
	 * Allow auto-review edits directly to the stable version by reviewers?
	 * @return bool
	 */
	public static function autoReviewEdits() {
		self::load();
		return self::$autoReviewConfig & FR_AUTOREVIEW_CHANGES;
	}

	/**
	 * Auto-review new pages with the minimal level?
	 * @return bool
	 */
	public static function autoReviewNewPages() {
		self::load();
		return self::$autoReviewConfig & FR_AUTOREVIEW_CREATION;
	}

	/**
	 * Auto-review of new pages or edits to pages enabled?
	 * @return bool
	 */
	public static function autoReviewEnabled() {
		return self::autoReviewEdits() || self::autoReviewNewPages();
	}

	/**
	 * Get the maximum level that $tag can be autoreviewed to
	 * @param string $tag
	 * @return int
	 */
	public static function maxAutoReviewLevel( $tag ) {
		global $wgFlaggedRevsTagsAuto;
		self::load();
		if ( !self::autoReviewEnabled() ) {
			return 0; // shouldn't happen
		}
		if ( isset( $wgFlaggedRevsTagsAuto[$tag] ) ) {
			return (int)$wgFlaggedRevsTagsAuto[$tag];
		} else {
			return 1; // B/C (before $wgFlaggedRevsTagsAuto)
		}
	}

	/**
	 * Is a "stable version" used as the default display
	 * version for all pages in reviewable namespaces?
	 * @return bool
	 */
	public static function isStableShownByDefault() {
		global $wgFlaggedRevsOverride;
		if ( self::useOnlyIfProtected() ) {
			return false; // must be configured per-page
		}
		return (bool)$wgFlaggedRevsOverride;
	}

	/**
	 * Are pages reviewable only if they have been manually
	 * configured by an admin to use a "stable version" as the default?
	 * @return bool
	 */
	public static function useOnlyIfProtected() {
		global $wgFlaggedRevsProtection;
		return (bool)$wgFlaggedRevsProtection;
	}

	/**
	 * Return the include handling configuration
	 * @return int
	 */
	public static function inclusionSetting() {
		global $wgFlaggedRevsHandleIncludes;
		return $wgFlaggedRevsHandleIncludes;
	}

	/**
	 * Should tags only be shown for unreviewed content for this user?
	 * @return bool
	 */
	public static function lowProfileUI() {
		global $wgFlaggedRevsLowProfile;
		return $wgFlaggedRevsLowProfile;
	}

	/**
	 * Are there site defined protection levels for review
	 * @return bool
	 */
	public static function useProtectionLevels() {
		global $wgFlaggedRevsProtection;
		return $wgFlaggedRevsProtection && self::getRestrictionLevels();
	}

	/**
	 * Get the autoreview restriction levels available
	 * @return array
	 */
	public static function getRestrictionLevels() {
		self::load();
		return self::$restrictionLevels;
	}

	/**
	 * Get the array of tag dimensions and level messages
	 * @return array
	 */
	public static function getDimensions() {
		self::load();
		return self::$dimensions;
	}

	/**
	 * Get the associative array of tag dimensions
	 * (tags => array(levels => msgkey))
	 * @return array
	 */
	public static function getTags() {
		self::load();
		return array_keys( self::$dimensions );
	}

	/**
	 * Get the associative array of tag restrictions
	 * (tags => array(rights => levels))
	 * @return array
	 */
	public static function getTagRestrictions() {
		self::load();
		return self::$tagRestrictions;
	}

	/**
	 * Get the UI name for a tag
	 * @param string $tag
	 * @return string
	 */
	public static function getTagMsg( $tag ) {
		return wfMsgExt( "revreview-$tag", array( 'escapenoentities' ) );
	}

	/**
	 * Get the levels for a tag. Gives map of level to message name.
	 * @param string $tag
	 * @return associative array (integer -> string)
	 */
	public static function getTagLevels( $tag ) {
		self::load();
		return isset( self::$dimensions[$tag] ) ?
			self::$dimensions[$tag] : array();
	}

	/**
	 * Get the the UI name for a value of a tag
	 * @param string $tag
	 * @param int $value
	 * @return string
	 */
	public static function getTagValueMsg( $tag, $value ) {
		self::load();
		if ( !isset( self::$dimensions[$tag] ) ) {
			return '';
		} elseif ( !isset( self::$dimensions[$tag][$value] ) ) {
			return '';
		}
		# Return empty string if not there
		return wfMsgExt( 'revreview-' . self::$dimensions[$tag][$value],
			array( 'escapenoentities' ) );
	}

	/**
	 * Are there no actual dimensions?
	 * @return bool
	 */
	public static function dimensionsEmpty() {
		self::load();
		return empty( self::$dimensions );
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
		if ( isset( $levelText[$level] ) ) {
			return $levelText[$level];
		} else {
			return '';
		}
	}

	/**
	 * Get the 'diffonly=' value for diff URLs. Either ('1','0','')
	 * @return array
	 */
	public static function diffOnlyCGI() {
		$val = trim( wfMsgForContent( 'flaggedrevs-diffonly' ) );
		if ( strpos( $val, '&diffonly=1' ) !== false ) {
			return array( 'diffonly' => 1 );
		} elseif ( strpos( $val, '&diffonly=0' ) !== false ) {
			return array( 'diffonly' => 0);
		}
		return array();
	}

	# ################ Permission functions #################

	/*
	 * Sanity check a (tag,value) pair
	 * @param string $tag
	 * @param int $value
	 * @return bool
	 */
	public static function tagIsValid( $tag, $value ) {
		$levels = self::getTagLevels( $tag );
		$highest = count( $levels ) - 1;
		if ( !$levels || $value < 0 || $value > $highest ) {
			return false; // flag range is invalid
		}
		return true;
	}

	/**
	 * Check if all of the required site flags have a valid value
	 * @param array $flags
	 * @return bool
	 */
	public static function flagsAreValid( array $flags ) {
		foreach ( self::getDimensions() as $qal => $levels ) {
			if ( !isset( $flags[$qal] ) || !self::tagIsValid( $qal, $flags[$qal] ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Returns true if a user can set $tag to $value
	 * @param User $user
	 * @param string $tag
	 * @param int $value
	 * @return bool
	 */
	public static function userCanSetTag( $user, $tag, $value ) {
		# Sanity check tag and value
		if ( !self::tagIsValid( $tag, $value ) ) {
			return false; // flag range is invalid
		}
		$restrictions = self::getTagRestrictions();
		# No restrictions -> full access
		if ( !isset( $restrictions[$tag] ) ) {
			return true;
		}
		# Validators always have full access
		if ( $user->isAllowed( 'validate' ) ) {
			return true;
		}
		# Check if this user has any right that lets him/her set
		# up to this particular value
		foreach ( $restrictions[$tag] as $right => $level ) {
			if ( $value <= $level && $level > 0 && $user->isAllowed( $right ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns true if a user can set $flags for a revision via review.
	 * Requires the same for $oldflags if given.
	 * @param User $user
	 * @param array $flags, suggested flags
	 * @param array $oldflags, pre-existing flags
	 * @return bool
	 */
	public static function userCanSetFlags( $user, array $flags, $oldflags = array() ) {
		if ( !$user->isAllowed( 'review' ) ) {
			return false; // User is not able to review pages
		}
		# Check if all of the required site flags have
		# a valid value that the user is allowed to set...
		foreach ( self::getDimensions() as $qal => $levels ) {
			if ( !isset( $flags[$qal] ) ) {
				return false; // unspecified
			} elseif ( !self::userCanSetTag( $user, $qal, $flags[$qal] ) ) {
				return false; // user cannot set proposed flag
			} elseif ( isset( $oldflags[$qal] )
				&& !self::userCanSetTag( $user, $qal, $oldflags[$qal] ) )
			{
				return false; // user cannot change old flag
			}
		}
		return true;
	}

	/**
	 * Check if a user can set the autoreview restiction level to $right
	 * @param User $user
	 * @param string $right the level
	 * @return bool
	 */
	public static function userCanSetAutoreviewLevel( $user, $right ) {
		if ( $right == '' ) {
			return true; // no restrictions (none)
		}
		if ( !in_array( $right, FlaggedRevs::getRestrictionLevels() ) ) {
			return false; // invalid restriction level
		}
		# Don't let them choose levels above their own rights
		if ( $right == 'sysop' ) {
			// special case, rewrite sysop to protect and editprotected
			if ( !$user->isAllowed( 'protect' ) && !$user->isAllowed( 'editprotected' ) ) {
				return false;
			}
		} elseif ( !$user->isAllowed( $right ) ) {
			return false;
		}
		return true;
	}

	# ################ Parsing functions #################

	/**
	 * All templates and arguments in $text are expanded out
	 * @param Title $title
	 * @param string $text wikitext
	 * @param int $id Source revision Id
	 * @param ParserOptions $pOpts
	 * @return array( string wikitext, array of template versions )
	 */
	public static function expandText( Title $title, $text, $id, ParserOptions $pOpts ) {
		global $wgParser;
		# Notify Parser if includes should be stabilized
		$resetManager = false;
		$incManager = FRInclusionManager::singleton();
		if ( $id && self::inclusionSetting() != FR_INCLUDES_CURRENT ) {
			# Use FRInclusionManager to do the template/file version query
			# up front unless the versions are already specified there...
			if ( !$incManager->parserOutputIsStabilized() ) {
				$frev = FlaggedRevision::newFromTitle( $title, $id );
				if ( $frev ) {
					$incManager->stabilizeParserOutput( $frev );
					$resetManager = true; // need to reset when done
				}
			}
		}
		$outputText = $wgParser->preprocess( $text, $title, $pOpts, $id );
		$pOutput = $wgParser->getOutput();
		# Stable parse done!
		if ( $resetManager ) {
			$incManager->clear(); // reset the FRInclusionManager as needed
		}
		# Return data array
		return array( $outputText, $pOutput->getTemplateIds() );
	}

	/**
	 * Get the HTML output of a revision based on $text.
	 * @param Title $title
	 * @param string $text
	 * @param int $id Source revision Id
	 * @param ParserOptions $pOpts
	 * @return ParserOutput
	 */
	public static function parseStableText( Title $title, $text, $id, ParserOptions $pOpts ) {
		global $wgParser;
		# Notify Parser if includes should be stabilized
		$resetManager = false;
		$incManager = FRInclusionManager::singleton();
		if ( $id && self::inclusionSetting() != FR_INCLUDES_CURRENT ) {
			# Use FRInclusionManager to do the template/file version query
			# up front unless the versions are already specified there...
			if ( !$incManager->parserOutputIsStabilized() ) {
				$frev = FlaggedRevision::newFromTitle( $title, $id );
				if ( $frev ) {
					$incManager->stabilizeParserOutput( $frev );
					$resetManager = true; // need to reset when done
				}
			}
		}
		# Parse the new body, wikitext -> html
		$parserOut = $wgParser->parse( $text, $title, $pOpts, true, true, $id );
		# Stable parse done!
		if ( $resetManager ) {
			$incManager->clear(); // reset the FRInclusionManager as needed
		}
		return $parserOut;
	}

	/**
	 * Check that ParserOutput object has file/template versions
	 * Note that ParserOutput::mImageTimeKeys wasn't always there
	 * @return bool
	 */
	public static function parserOutputIsVersioned( ParserOutput $pOut ) {
		return ( $pOut->getTemplateIds() !== null && $pOut->getFileSearchOptions() !== null );
	}

	# ################ Tracking/cache update update functions #################

	/**
	 * Update the page tables with a new stable version.
	 * @param Title $title
	 * @param FlaggedRevision|null $sv, the new stable version (optional)
	 * @param FlaggedRevision|null $oldSv, the old stable version (optional)
	 * @param Object editInfo Article edit info about the current revision (optional)
	 * @return bool stable version text/file changed and FR_INCLUDES_STABLE
	 */
	public static function stableVersionUpdates(
		Title $title, $sv = null, $oldSv = null, $editInfo = null
	) {
		$changed = false;
		if ( $oldSv === null ) { // optional
			$oldSv = FlaggedRevision::newFromStable( $title, FR_MASTER );
		}
		if ( $sv === null ) { // optional
			$sv = FlaggedRevision::determineStable( $title, FR_MASTER );
		}
		$article = new FlaggableWikiPage( $title );
		if ( !$sv ) {
			# Empty flaggedrevs data for this page if there is no stable version
			$article->clearStableVersion();
			# Check if pages using this need to be refreshed...
			if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
				$changed = (bool)$oldSv;
			}
		} else {
			# Update flagged page related fields
			$article->updateStableVersion( $sv, $editInfo ? $editInfo->revid : null );
			# Check if pages using this need to be invalidated/purged...
			if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
				$changed = (
					!$oldSv ||
					$sv->getRevId() != $oldSv->getRevId() ||
					$sv->getFileTimestamp() != $oldSv->getFileTimestamp() ||
					$sv->getFileSha1() != $oldSv->getFileSha1()
				);
			}
			# Update template/file version cache...
			if ( $editInfo && $sv->getRevId() != $editInfo->revid ) {
				FRInclusionCache::setRevIncludes( $title, $editInfo->revid, $editInfo->output );
			}
		}
		# Lazily rebuild dependancies on next parse (we invalidate below)
		FlaggedRevs::clearStableOnlyDeps( $title->getArticleID() );
		# Clear page cache
		$title->invalidateCache();
		self::purgeSquid( $title );
		return $changed;
	}

	/**
	 * Clear FlaggedRevs tracking tables for this page
	 * @param int|array $pageId (int or array)
	 */
	public static function clearTrackingRows( $pageId ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'flaggedpages', array( 'fp_page_id' => $pageId ), __METHOD__ );
		$dbw->delete( 'flaggedrevs_tracking', array( 'ftr_from' => $pageId ), __METHOD__ );
		$dbw->delete( 'flaggedpage_pending', array( 'fpp_page_id' => $pageId ), __METHOD__ );
	}

	/**
	 * @param Page $article
	 * @param parserOutput $parserOut
	 * Updates the stable-only cache dependency table
	 */
	public static function updateStableOnlyDeps( Page $article, ParserOutput $stableOut ) {
		wfProfileIn( __METHOD__ );
		if ( !wfReadOnly() ) {
			$frDepUpdate = new FRDependencyUpdate( $article->getTitle(), $stableOut );
			$frDepUpdate->doUpdate();
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Clear tracking table of stable-only links for this page
	 * @param int|array $pageId (int or array)
	 */
	public static function clearStableOnlyDeps( $pageId ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'flaggedrevs_tracking', array( 'ftr_from' => $pageId ), __METHOD__ );
	}

	/**
	 * @param Title $title
	 * Updates squid cache for a title. Defers till after main commit().
	 */
	public static function purgeSquid( Title $title ) {
		global $wgDeferredUpdateList;
		$wgDeferredUpdateList[] = new FRSquidUpdate( $title );
	}

	/**
	 * Do cache updates for when the stable version of a page changed.
	 * Invalidates/purges pages that include the given page.
	 * @param Title $title
	 * @param bool $recursive
	 */
	public static function HTMLCacheUpdates( Title $title ) {
		global $wgDeferredUpdateList;
		# Invalidate caches of articles which include this page...
		$wgDeferredUpdateList[] = new HTMLCacheUpdate( $title, 'templatelinks' );
		if ( $title->getNamespace() == NS_FILE ) {
			$wgDeferredUpdateList[] = new HTMLCacheUpdate( $title, 'imagelinks' );
		}
		$wgDeferredUpdateList[] = new FRExtraCacheUpdate( $title );
	}

	/**
	 * Invalidates/purges pages where only stable version includes this page.
	 * @param Title $title
	 */
	public static function extraHTMLCacheUpdate( Title $title ) {
		global $wgDeferredUpdateList;
		$wgDeferredUpdateList[] = new FRExtraCacheUpdate( $title );
	}

	# ################ Revision functions #################

	/**
	 * Mark a revision as patrolled if needed
	 * @param Revision $rev
	 * @return bool DB write query used
	 */
	public static function markRevisionPatrolled( Revision $rev ) {
		$rcid = $rev->isUnpatrolled();
		# Make sure it is now marked patrolled...
		if ( $rcid ) {
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

	# ################ Other utility functions #################

	/**
	 * Get a memcache storage object
	 * @param string $val
	 * @return Object (val,time) tuple
	 */
	public static function makeMemcObj( $val ) {
		$data = (object) array();
		$data->value = $val;
		$data->time = wfTimestampNow();
		return $data;
	}

	/**
	 * Return memc value if not expired
	 * @param object|false $data makeMemcObj() tuple
	 * @param Page $article
	 * @param $allowStale Use 'allowStale' to skip page_touched check
	 * @return mixed
	 */
	public static function getMemcValue( $data, Page $article, $allowStale = '' ) {
		if ( is_object( $data ) ) {
			if ( $allowStale === 'allowStale' || $data->time >= $article->getTouched() ) {
				return $data->value;
			}
		}
		return false;
	}

	/**
	 * @param array $flags
	 * @return bool, is this revision at basic review condition?
	 */
	public static function isChecked( array $flags ) {
		self::load();
		return self::tagsAtLevel( $flags, self::$minSL );
	}

	/**
	 * @param array $flags
	 * @return bool, is this revision at quality review condition?
	 */
	public static function isQuality( array $flags ) {
		self::load();
		return self::tagsAtLevel( $flags, self::$minQL );
	}

	/**
	 * @param array $flags
	 * @return bool, is this revision at pristine review condition?
	 */
	public static function isPristine( array $flags ) {
		self::load();
		return self::tagsAtLevel( $flags, self::$minPL );
	}

	// Checks if $flags meets $reqFlagLevels
	protected static function tagsAtLevel( array $flags, $reqFlagLevels ) {
		self::load();
		if ( empty( $flags ) ) {
			return false;
		}
		foreach ( self::$dimensions as $f => $x ) {
			if ( !isset( $flags[$f] ) || $reqFlagLevels[$f] > $flags[$f] ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the quality tier of review flags
	 * @param array $flags
	 * @param int $default Return value if one of the tags has value < 0
	 * @return int flagging tier (FR_PRISTINE,FR_QUALITY,FR_CHECKED,-1)
	 */
	public static function getQualityTier( array $flags, $default = -1 ) {
		if ( self::isPristine( $flags ) ) {
			return FR_PRISTINE; // 2
		} elseif ( self::isQuality( $flags ) ) {
			return FR_QUALITY; // 1
		} elseif ( self::isChecked( $flags ) ) {
			return FR_CHECKED; // 0
		}
		return (int)$default;
	}

	/**
	 * Get minimum level tags for a tier
	 * @param int $tier FR_PRISTINE/FR_QUALITY/FR_CHECKED
	 * @return array
	 */
	public static function quickTags( $tier ) {
		self::load();
		if ( $tier == FR_PRISTINE ) {
			return self::$minPL;
		} elseif ( $tier == FR_QUALITY ) {
			return self::$minQL;
		}
		return self::$minSL;
	}

	/**
	 * Get minimum tags that are closest to $oldFlags
	 * given the site, page, and user rights limitations.
	 * @param User $user
	 * @param array $oldFlags previous stable rev flags
	 * @return mixed array or null
	 */
	public static function getAutoReviewTags( $user, array $oldFlags ) {
		if ( !self::autoReviewEdits() ) {
			return null; // shouldn't happen
		}
		$flags = array();
		foreach ( self::getTags() as $tag ) {
			# Try to keep this tag val the same as the stable rev's
			$val = isset( $oldFlags[$tag] ) ? $oldFlags[$tag] : 1;
			$val = min( $val, self::maxAutoReviewLevel( $tag ) );
			# Dial down the level to one the user has permission to set
			while ( !self::userCanSetTag( $user, $tag, $val ) ) {
				$val--;
				if ( $val <= 0 ) {
					return null; // all tags vals must be > 0
				}
			}
			$flags[$tag] = $val;
		}
		return $flags;
	}

	/**
	 * Get the list of reviewable namespaces
	 * @return array
	 */
	public static function getReviewNamespaces() {
		self::load(); // validates namespaces
		return self::$reviewNamespaces;
	}

	/**
	 * Is this page in reviewable namespace?
	 * Note: this checks $wgFlaggedRevsWhitelist
	 * @param Title, $title
	 * @return bool
	 */
	public static function inReviewNamespace( Title $title ) {
		global $wgFlaggedRevsWhitelist;
		if ( in_array( $title->getPrefixedDBKey(), $wgFlaggedRevsWhitelist ) ) {
			return false; // page is one exemption whitelist
		}
		$ns = ( $title->getNamespace() == NS_MEDIA ) ?
			NS_FILE : $title->getNamespace(); // treat NS_MEDIA as NS_FILE
		return in_array( $ns, self::getReviewNamespaces() );
	}

	# ################ Auto-review function #################

	/**
	 * Automatically review an revision and add a log entry in the review log.
	*
	 * This is called during edit operations after the new revision is added
	 * and the page tables updated, but before LinksUpdate is called.
	*
	 * $auto is here for revisions checked off to be reviewed. Auto-review
	 * triggers on edit, but we don't want those to count as just automatic.
	 * This also makes it so the user's name shows up in the page history.
	*
	 * If $flags is given, then they will be the review tags. If not, the one
	 * from the stable version will be used or minimal tags if that's not possible.
	 * If no appropriate tags can be found, then the review will abort.
	 */
	public static function autoReviewEdit(
		Page $article, $user, Revision $rev, array $flags = null, $auto = true
	) {
		wfProfileIn( __METHOD__ );
		$title = $article->getTitle(); // convenience
		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $title, FR_MASTER );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;
		# Set the auto-review tags from the prior stable version.
		# Normally, this should already be done and given here...
		if ( !is_array( $flags ) ) {
			if ( $oldSv ) {
				# Use the last stable version if $flags not given
				if ( $user->isAllowed( 'bot' ) ) {
					$flags = $oldSv->getTags(); // no change for bot edits
				} else {
					# Account for perms/tags...
					$flags = self::getAutoReviewTags( $user, $oldSv->getTags() );
				}
			} else { // new page?
				$flags = self::quickTags( FR_CHECKED ); // use minimal level
			}
			if ( !is_array( $flags ) ) {
				wfProfileOut( __METHOD__ );
				return false; // can't auto-review this revision
			}
		}
		# Get review property flags
		$propFlags = $auto ? array( 'auto' ) : array();

		# Rev ID is not put into parser on edit, so do the same here.
		# Also, a second parse would be triggered otherwise.
		$editInfo = $article->prepareTextForEdit( $rev->getText() );
		$poutput = $editInfo->output; // revision HTML output

		# If this is an image page, store corresponding file info
		$fileData = array( 'name' => null, 'timestamp' => null, 'sha1' => null );
		if ( $title->getNamespace() == NS_FILE ) {
			# We must use WikiFilePage process cache on upload or get bitten by slave lag
			$file = ( $article instanceof WikiFilePage || $article instanceof ImagePage )
				? $article->getFile() // uses up-to-date process cache on new uploads
				: wfFindFile( $title, array( 'bypassCache' => true ) ); // skip cache; bug 31056
			if ( is_object( $file ) && $file->exists() ) {
				$fileData['name'] = $title->getDBkey();
				$fileData['timestamp'] = $file->getTimestamp();
				$fileData['sha1'] = $file->getSha1();
			}
		}

		# Our review entry
		$flaggedRevision = new FlaggedRevision( array(
			'rev'	      		=> $rev,
			'user_id'	       	=> $user->getId(),
			'timestamp'     	=> $rev->getTimestamp(), // same as edit time
			'quality'      	 	=> FlaggedRevs::getQualityTier( $flags, 0 /* sanity */ ),
			'tags'	       		=> FlaggedRevision::flattenRevisionTags( $flags ),
			'img_name'      	=> $fileData['name'],
			'img_timestamp' 	=> $fileData['timestamp'],
			'img_sha1'      	=> $fileData['sha1'],
			'templateVersions' 	=> $poutput->getTemplateIds(),
			'fileVersions'     	=> $poutput->getFileSearchOptions(),
			'flags'				=> implode( ',', $propFlags ),
		) );
		$flaggedRevision->insert();
		# Update the article review log
		FlaggedRevsLog::updateReviewLog( $title,
			$flags, array(), '', $rev->getId(), $oldSvId, true, $auto );

		# Update page and tracking tables and clear cache
		FlaggedRevs::stableVersionUpdates( $title );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get JS script params
	 */
	public static function getJSTagParams() {
		self::load();
		# Param to pass to JS function to know if tags are at quality level
		$tagsJS = array();
		foreach ( self::$dimensions as $tag => $x ) {
			$tagsJS[$tag] = array();
			$tagsJS[$tag]['levels'] = count( $x ) - 1;
			$tagsJS[$tag]['quality'] = self::$minQL[$tag];
			$tagsJS[$tag]['pristine'] = self::$minPL[$tag];
		}
		$params = array( 'tags' => (object)$tagsJS );
		return (object)$params;
	}
}
