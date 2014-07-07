<?php
/**
 * Class representing a MediaWiki article and history
 *
 * FlaggableWikiPage::getTitleInstance() is preferred over constructor calls
 */
class FlaggableWikiPage extends WikiPage {
	/* Process cache variables */
	protected $stable = 0;
	protected $stableRev = null;
	protected $revsArePending = null;
	protected $pendingRevCount = null;
	protected $pageConfig = null;
	protected $syncedInTracking = null;

	protected $file = null; // for file pages

	/**
	 * Get a FlaggableWikiPage for a given title
	 * @param $title Title
	 * @return FlaggableWikiPage
	 */
	public static function getTitleInstance( Title $title ) {
		// Check if there is already an instance on this title
		if ( !isset( $title->flaggedRevsArticle ) ) {
			$title->flaggedRevsArticle = new self( $title );
		}
		return $title->flaggedRevsArticle;
	}

	/**
	 * Clear object process cache values
	 * @return void
	 */
	public function clear() {
		$this->stable = 0;
		$this->stableRev = null;
		$this->revsArePending = null;
		$this->pendingRevCount = null;
		$this->pageConfig = null;
		$this->syncedInTracking = null;
		$this->file = null;
		parent::clear(); // call super!
	}

	/**
	 * Get the current file version (null if this not a File page)
	 * @return File|null|false
	 */
	public function getFile() {
		if ( $this->file === null && $this->mTitle->getNamespace() == NS_FILE ) {
			$this->file = wfFindFile( $this->mTitle );
		}
		return $this->file;
	}

	/**
	 * Is the stable version shown by default for this page?
	 * @return bool
	 */
	public function isStableShownByDefault() {
		if ( !$this->isReviewable() ) {
			return false; // no stable versions can exist
		}
		$config = $this->getStabilitySettings(); // page configuration
		return (bool)$config['override'];
	}

	/**
	 * Do edits have to be reviewed before being shown by default (going live)?
	 * @return bool
	 */
	public function editsRequireReview() {
		return (
			$this->isReviewable() && // reviewable page
			$this->isStableShownByDefault() && // and stable versions override
			$this->getStableRev() // and there is a stable version
		);
	}

	/**
	 * Are edits to this page currently pending?
	 * @return bool
	 */
	public function revsArePending() {
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		return $this->revsArePending;
	}

	/**
	 * Get number of revs since the stable revision
	 * Note: slower than revsArePending()
	 * @param int $flags FR_MASTER (be sure to use loadFromDB( FR_MASTER ) if set)
	 * @return int
	 */
	public function getPendingRevCount( $flags = 0 ) {
		global $wgMemc, $wgParserCacheExpireTime;
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		# Pending count deferred even after page data load
		if ( $this->pendingRevCount !== null ) {
			return $this->pendingRevCount; // use process cache
		}
		$srev = $this->getStableRev();
		if ( !$srev ) {
			return 0; // none
		}
		$count = null;
		$sRevId = $srev->getRevId();
		# Try the cache...
		$key = wfMemcKey( 'flaggedrevs', 'countPending', $this->getId() );
		if ( !( $flags & FR_MASTER ) ) {
			$tuple = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $this );
			# Items is cached and newer that page_touched...
			if ( $tuple !== false ) {
				# Confirm that cache value was made against the same stable rev Id.
				# This avoids lengthy cache pollution if $sRevId is outdated.
				list( $cRevId, $cPending ) = explode( '-', $tuple, 2 );
				if ( $cRevId == $sRevId ) {
					$count = (int)$cPending;
				}
			}
		}
		# Otherwise, fetch result from DB as needed...
		if ( is_null( $count ) ) {
			$db = ( $flags & FR_MASTER ) ?
				wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$srevTS = $db->timestamp( $srev->getRevTimestamp() );
			$count = $db->selectField( 'revision', 'COUNT(*)',
				array( 'rev_page' => $this->getId(),
					'rev_timestamp > ' . $db->addQuotes( $srevTS ) ), // bug 15515
				__METHOD__ );
			# Save result to cache...
			$data = FlaggedRevs::makeMemcObj( "{$sRevId}-{$count}" );
			$wgMemc->set( $key, $data, $wgParserCacheExpireTime );
		}
		$this->pendingRevCount = $count;
		return $this->pendingRevCount;
	}

	/**
	 * Checks if the stable version is synced with the current revision
	 * Note: slower than getPendingRevCount()
	 * @return bool
	 */
	public function stableVersionIsSynced() {
		global $wgMemc, $wgParserCacheExpireTime;
		$srev = $this->getStableRev();
		if ( !$srev ) {
			return true;
		}
		# Stable text revision must be the same as the current
		if ( $this->revsArePending() ) {
			return false;
		# Stable file revision must be the same as the current
		} elseif ( $this->mTitle->getNamespace() == NS_FILE ) {
			$file = $this->getFile(); // current upload version
			if ( $file && $file->getTimestamp() > $srev->getFileTimestamp() ) {
				return false;
			}
		}
		# If using the current version of includes, there is nothing else to check.
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return true; // short-circuit
		}
		# Try the cache...
		$key = wfMemcKey( 'flaggedrevs', 'includesSynced', $this->getId() );
		$value = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $this );
		if ( $value === "true" ) {
			return true;
		} elseif ( $value === "false" ) {
			return false;
		}
		# Since the stable and current revisions have the same text and only outputs,
		# the only other things to check for are template and file differences in the output.
		# (a) Check if the current output has a newer template/file used
		# (b) Check if the stable version has a file/template that was deleted
		$synced = ( !$srev->findPendingTemplateChanges()
			&& !$srev->findPendingFileChanges( 'noForeign' ) );
		# Save to cache. This will be updated whenever the page is touched.
		$data = FlaggedRevs::makeMemcObj( $synced ? "true" : "false" );
		$wgMemc->set( $key, $data, $wgParserCacheExpireTime );

		return $synced;
	}

	/**
	 * Are template/file changes and ONLY template/file changes pending?
	 * @return bool
	 */
	public function onlyTemplatesOrFilesPending() {
		return ( !$this->revsArePending() && !$this->stableVersionIsSynced() );
	}

	/**
	 * Is this page less open than the site defaults?
	 * @return bool
	 */
	public function isPageLocked() {
		return ( !FlaggedRevs::isStableShownByDefault() && $this->isStableShownByDefault() );
	}

	/**
	 * Is this page more open than the site defaults?
	 * @return bool
	 */
	public function isPageUnlocked() {
		return ( FlaggedRevs::isStableShownByDefault() && !$this->isStableShownByDefault() );
	}

	/**
	 * Tags are only shown for unreviewed content and this page is not locked/unlocked?
	 * @return bool
	 */
	public function lowProfileUI() {
		return FlaggedRevs::lowProfileUI() &&
			FlaggedRevs::isStableShownByDefault() == $this->isStableShownByDefault();
	}

	/**
	 * Is this article reviewable?
	 * @return bool
	 */
	public function isReviewable() {
		if ( !FlaggedRevs::inReviewNamespace( $this->mTitle ) ) {
			return false;
		}
		# Check if flagging is disabled for this page via config
		if ( FlaggedRevs::useOnlyIfProtected() ) {
			$config = $this->getStabilitySettings(); // page configuration
			return (bool)$config['override']; // stable is default or flagging disabled
		}
		return true;
	}

	/**
	 * Get the stable revision ID
	 * @return int
	 */
	public function getStable() {
		if ( !FlaggedRevs::inReviewNamespace( $this->mTitle ) ) {
			return 0; // short-circuit
		}
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		return (int)$this->stable;
	}

	/**
	 * Get the stable revision
	 * @return mixed (FlaggedRevision/null)
	 */
	public function getStableRev() {
		if ( !FlaggedRevs::inReviewNamespace( $this->mTitle ) ) {
			return null; // short-circuit
		}
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		# Stable rev deferred even after page data load
		if ( $this->stableRev === null ) {
			$srev = FlaggedRevision::newFromTitle( $this->mTitle, $this->stable );
			$this->stableRev = $srev ? $srev : false; // cache negative hits too
		}
		return $this->stableRev ? $this->stableRev : null; // false => null
	}

	/**
	 * Get visiblity restrictions on page
	 * @return array (select,override)
	 */
	public function getStabilitySettings() {
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		return $this->pageConfig;
	}

	/*
	 * Get the fp_reviewed value for this page
	 * @return bool
	 */
	public function syncedInTracking() {
		if ( !$this->mDataLoaded ) {
			$this->loadPageData();
		}
		return $this->syncedInTracking;
	}

	/**
	 * Get the newest of the highest rated flagged revisions of this page
	 * Note: will not return deleted revisions
	 * @return int
	 */
	public function getBestFlaggedRevId() {
		$dbr = wfGetDB( DB_SLAVE );
		# Get the highest quality revision (not necessarily this one).
		$oldid = $dbr->selectField( array( 'flaggedrevs', 'revision' ),
			'fr_rev_id',
			array(
				'fr_page_id' => $this->getId(),
				'rev_page = fr_page_id', // sanity
				'rev_id = fr_rev_id',
				'rev_deleted & ' . Revision::DELETED_TEXT => 0
			),
			__METHOD__,
			array(
				'ORDER BY' 	=> 'fr_quality DESC, fr_rev_timestamp DESC',
				'USE INDEX' => array( 'flaggedrevs' => 'page_qal_time' )
			)
		);
		return (int)$oldid;
	}

	/**
	 * Updates the fp_reviewed field for this article
	 * @param bool $synced
	 */
	public function updateSyncStatus( $synced ) {
		wfProfileIn( __METHOD__ );
		if ( !wfReadOnly() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'flaggedpages',
				array( 'fp_reviewed' => $synced ? 1 : 0 ),
				array( 'fp_page_id'  => $this->getID() ),
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Fetch a page record with the given conditions
	 * @param $dbr Database object
	 * @param $conditions Array
	 * @return mixed Database result resource, or false on failure
	 */
	protected function pageData( $dbr, $conditions ) {
		$row = $dbr->selectRow(
			array( 'page', 'flaggedpages', 'flaggedpage_config' ),
			array_merge(
				WikiPage::selectFields(),
				FRPageConfig::selectFields(),
				array( 'fp_pending_since', 'fp_stable', 'fp_reviewed' ) ),
			$conditions,
			__METHOD__,
			array(),
			array(
				'flaggedpages' 		 => array( 'LEFT JOIN', 'fp_page_id = page_id' ),
				'flaggedpage_config' => array( 'LEFT JOIN', 'fpc_page_id = page_id' ) )
		);
		return $row;
	}

	/**
	 * Set the page field data loaded from some source
	 * @param $data Database row object or "fromdb"
	 * @return void
	 */
	public function loadPageData( $data = 'fromdb' ) {
		$this->mDataLoaded = true; // sanity
		# Fetch data from DB as needed...
		if ( $data === 'fromdb' || $data === 'fromdbmaster' ) {
			$db = ( $data == 'fromdbmaster' )
				? wfGetDB( DB_MASTER )
				: wfGetDB( DB_SLAVE );
			$data = $this->pageDataFromTitle( $db, $this->mTitle );
		}
		# Load in primary page data...
		parent::loadPageData( $data /* Row obj */ );
		# Load in FlaggedRevs page data...
		$this->stable = 0; // 0 => "found nothing"
		$this->stableRev = null; // defer this one...
		$this->revsArePending = false; // false => "found nothing" or "none pending"
		$this->pendingRevCount = null; // defer this one...
		$this->pageConfig = FRPageConfig::getDefaultVisibilitySettings(); // default
		$this->syncedInTracking = true; // false => "unreviewed" or "synced"
		# Load in flaggedrevs Row data if the page exists...(sanity check NS)
		if ( $data && FlaggedRevs::inReviewNamespace( $this->mTitle ) ) {
			if ( $data->fpc_override !== null ) { // page config row found
				$this->pageConfig = FRPageConfig::getVisibilitySettingsFromRow( $data );
			}
			if ( $data->fp_stable !== null ) { // stable rev found	
				$this->stable = (int)$data->fp_stable;
				$this->revsArePending = ( $data->fp_pending_since !== null ); // revs await review
				$this->syncedInTracking = (bool)$data->fp_reviewed;
			}
		}
	}

	/**
	 * Updates the flagging tracking tables for this page
	 * @param FlaggedRevision $srev The new stable version
	 * @param int|null $latest The latest rev ID (optional)
	 * @return bool Updates were done
	 */
	public function updateStableVersion( FlaggedRevision $srev, $latest = null ) {
		$rev = $srev->getRevision();
		if ( !$this->exists() || !$rev ) {
			return false; // no bogus entries
		}
		# Get the latest revision ID if not set
		if ( !$latest ) {
			$latest = $this->mTitle->getLatestRevID( Title::GAID_FOR_UPDATE );
		}
		$dbw = wfGetDB( DB_MASTER );
		# Get the highest quality revision (not necessarily this one)...
		if ( $srev->getQuality() === FlaggedRevs::highestReviewTier() ) {
			$maxQuality = $srev->getQuality(); // save a query
		} else {
			$maxQuality = $dbw->selectField( array( 'flaggedrevs', 'revision' ),
				'fr_quality',
				array( 'fr_page_id' => $this->getId(),
					'rev_id = fr_rev_id',
					'rev_page = fr_page_id',
					'rev_deleted & ' . Revision::DELETED_TEXT => 0
				),
				__METHOD__,
				array( 'ORDER BY' => 'fr_quality DESC', 'LIMIT' => 1 )
			);
			$maxQuality = max( $maxQuality, $srev->getQuality() ); // sanity
		}
		# Get the timestamp of the first edit after the stable version (if any)...
		$nextTimestamp = null;
		if ( $rev->getId() != $latest ) {
			$timestamp = $dbw->timestamp( $rev->getTimestamp() );
			$nextEditTS = $dbw->selectField( 'revision',
				'rev_timestamp',
				array(
					'rev_page' => $this->getId(),
					"rev_timestamp > " . $dbw->addQuotes( $timestamp ) ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 1 )
			);
			if ( $nextEditTS ) { // sanity check
				$nextTimestamp = $nextEditTS;
			}
		}
		# Get the new page sync status...
		$synced = !(
			$nextTimestamp !== null || // edits pending
			$srev->findPendingTemplateChanges() || // template changes pending
			$srev->findPendingFileChanges( 'noForeign' ) // file changes pending
		);
		# Alter table metadata
		$dbw->replace( 'flaggedpages',
			array( 'fp_page_id' ),
			array(
				'fp_page_id'       => $this->getId(),
				'fp_stable'        => $rev->getId(),
				'fp_reviewed'      => $synced ? 1 : 0,
				'fp_quality'       => ( $maxQuality === false ) ? null : $maxQuality,
				'fp_pending_since' => $dbw->timestampOrNull( $nextTimestamp )
			),
			__METHOD__
		);
		# Update pending edit tracking table
		self::updatePendingList( $this->getId(), $latest );
		return true;
	}

	/**
	 * Updates the flagging tracking tables for this page
	 * @return void
	 */
	public function clearStableVersion() {
		if ( !$this->exists() ) {
			return; // nothing to do
		}
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'flaggedpages',
			array( 'fp_page_id' => $this->getId() ), __METHOD__ );
		$dbw->delete( 'flaggedpage_pending',
			array( 'fpp_page_id' => $this->getId() ), __METHOD__ );
	}

	/**
	 * Updates the flaggedpage_pending table
	 * @param int $pageId Page ID
	 * @abstract int $latest Latest revision
	 * @return void
	 */
	protected static function updatePendingList( $pageId, $latest ) {
		$data = array();
		# Get the highest tier used on this wiki
		$level = FlaggedRevs::highestReviewTier();

		$dbw = wfGetDB( DB_MASTER );
		# Update pending times for each level, going from highest to lowest
		$higherLevelId = 0;
		$higherLevelTS = '';
		while ( $level >= 0 ) {
			# Get the latest revision of this level...
			# Any revision of one tier is also a revision of lower tiers.
			# Instead of doing fr_quality > X queries we do exact comparisons
			# for better INDEX usage. However, in order to treat a rev as the
			# latest tier X rev, we make sure it is newer than all tier (X+1) revs.
			$row = $dbw->selectRow(
				array( 'flaggedrevs', 'revision' ),
				array( 'fr_rev_id', 'rev_timestamp' ),
				array(
					'fr_page_id' => $pageId,
					'fr_quality' => $level, // this level
					'fr_rev_timestamp > ' . $dbw->addQuotes( $higherLevelTS ),
					'rev_id = fr_rev_id', // rev exists
					'rev_page = fr_page_id', // sanity
					'rev_deleted & ' . Revision::DELETED_TEXT => 0
				),
				__METHOD__,
				array( 'ORDER BY' => 'fr_rev_timestamp DESC', 'LIMIT' => 1 )
			);
			# If there is a revision of this level, track it...
			# Revisions accepted to one tier count as accepted
			# at the lower tiers (i.e. quality -> checked).
			if ( $row ) {
				$id = $row->fr_rev_id;
				$ts = $row->rev_timestamp;
			} else { // use previous rev of higher tier (if any)
				$id = $higherLevelId;
				$ts = $higherLevelTS;
			}
			# Get edits that actually are pending...
			if ( $id && $latest > $id ) {
				# Get the timestamp of the edit after this version (if any)
				$nextTimestamp = $dbw->selectField( 'revision',
					'rev_timestamp',
					array( 'rev_page' => $pageId, "rev_timestamp > " . $dbw->addQuotes( $ts ) ),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 1 )
				);
				$data[] = array(
					'fpp_page_id'       => $pageId,
					'fpp_quality'       => $level,
					'fpp_rev_id'        => $id,
					'fpp_pending_since' => $nextTimestamp
				);
				$higherLevelId = $id;
				$higherLevelTS = $ts;
			}
			$level--;
		}
		# Clear any old junk, and insert new rows
		$dbw->delete( 'flaggedpage_pending', array( 'fpp_page_id' => $pageId ), __METHOD__ );
		$dbw->insert( 'flaggedpage_pending', $data, __METHOD__ );
	}
}
