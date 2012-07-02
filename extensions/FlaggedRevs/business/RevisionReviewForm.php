<?php
/**
 * Class containing revision review form business logic
 */
class RevisionReviewForm extends FRGenericSubmitForm {
	/* Form parameters which can be user given */
	protected $page = null;                 # Target Title obj
	protected $article = null;              # Target Page obj
	protected $approve = false;             # Approval requested
	protected $unapprove = false;           # De-approval requested
	protected $reject = false;              # Rejection requested
	protected $oldid = 0;                   # ID being reviewed (last "bad" ID for rejection)
	protected $refid = 0;                   # Old, "last good", ID (used for rejection)
	protected $templateParams = '';         # Included template versions (flat string)
	protected $imageParams = '';            # Included file versions (flat string)
	protected $fileVersion = '';            # File page file version (flat string)
	protected $validatedParams = '';        # Parameter key
	protected $comment = '';                # Review comments
	protected $dims = array();              # Review flags (for approval)
	protected $lastChangeTime = null;       # Conflict handling
	protected $newLastChangeTime = null;    # Conflict handling

	protected $oldFrev = null;              # Prior FlaggedRevision for Rev with ID $oldid
	protected $oldFlags = array();          # Prior flags for Rev with ID $oldid

	protected $sessionKey = '';             # User session key
	protected $skipValidationKey = false;   # Skip validatedParams check

	protected function initialize() {
		foreach ( FlaggedRevs::getTags() as $tag ) {
			$this->dims[$tag] = 0; // default to "inadequate"
		}
	}

	public function getPage() {
		return $this->page;
	}

	public function setPage( Title $value ) {
		$this->trySet( $this->page, $value );
	}

	public function setApprove( $value ) {
		$this->trySet( $this->approve, $value );
	}

	public function setUnapprove( $value ) {
		$this->trySet( $this->unapprove, $value );
	}

	public function setReject( $value ) {
		$this->trySet( $this->reject, $value );
	}

	public function setLastChangeTime( $value ) {
		$this->trySet( $this->lastChangeTime, $value );
	}

	public function getNewLastChangeTime() {
		return $this->newLastChangeTime;
	}

	public function getRefId() {
		return $this->refid;
	}

	public function setRefId( $value ) {
		$this->trySet( $this->refid, (int)$value );
	}

	public function getOldId() {
		return $this->oldid;
	}

	public function setOldId( $value ) {
		$this->trySet( $this->oldid, (int)$value );
	}

	public function getTemplateParams() {
		return $this->templateParams;
	}

	public function setTemplateParams( $value ) {
		$this->trySet( $this->templateParams, $value );
	}

	public function getFileParams() {
		return $this->imageParams;
	}

	public function setFileParams( $value ) {
		$this->trySet( $this->imageParams, $value );
	}

	public function getFileVersion() {
		return $this->fileVersion;
	}

	public function setFileVersion( $value ) {
		$this->trySet( $this->fileVersion, $value );
	}

	public function getValidatedParams() {
		return $this->validatedParams;
	}

	public function setValidatedParams( $value ) {
		$this->trySet( $this->validatedParams, $value );
	}

	public function getComment() {
		return $this->comment;
	}

	public function setComment( $value ) {
		$this->trySet( $this->comment, $value );
	}

	public function getDims() {
		return $this->dims;
	}

	public function setDim( $tag, $value ) {
		if ( !in_array( $tag, FlaggedRevs::getTags() ) ) {
			throw new MWException( "FlaggedRevs tag $tag does not exist.\n" );
		}
		$this->trySet( $this->dims[$tag], (int)$value );
	}

	public function setSessionKey( $sessionId ) {
		$this->sessionKey = $sessionId;
	}

	public function bypassValidationKey() {
		$this->skipValidationKey = true;
	}

	/**
	 * Check that a target is given (e.g. from GET/POST request)
	 * @return mixed (true on success, error string on failure)
	 */
	public function doCheckTargetGiven() {
		if ( is_null( $this->page ) ) {
			return 'review_page_invalid';
		}
		return true;
	}

	/**
	 * Load any objects after ready() called
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doBuildOnReady() {
		$this->article = FlaggableWikiPage::getTitleInstance( $this->page );
		return true;
	}

	/**
	 * Check that the target is valid (e.g. from GET/POST request)
	 * @param int $flags FOR_SUBMISSION (set on submit)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckTarget( $flags = 0 ) {
		$flgs = ( $flags & self::FOR_SUBMISSION ) ? Title::GAID_FOR_UPDATE : 0;
		if ( !$this->page->getArticleId( $flgs ) ) {
			return 'review_page_notexists';
		}
		$flgs = ( $flags & self::FOR_SUBMISSION ) ? FR_MASTER : 0;
		if ( !$this->article->isReviewable( $flgs ) ) {
			return 'review_page_unreviewable';
		}
		return true;
	}

	/**
	 * Validate and clean up parameters (e.g. from POST request).
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckParameters() {
		$action = $this->getAction();
		if ( $action === null ) {
			return 'review_param_missing'; // no action specified (approve, reject, de-approve)
		} elseif ( !$this->oldid ) {
			return 'review_no_oldid'; // no revision target
		}
		# Get the revision's current flags (if any)
		$this->oldFrev = FlaggedRevision::newFromTitle( $this->page, $this->oldid, FR_MASTER );
		$this->oldFlags = ( $this->oldFrev )
			? $this->oldFrev->getTags()
			: FlaggedRevision::expandRevisionTags( '' ); // default
		# Set initial value for newLastChangeTime (if unchanged on submit)
		$this->newLastChangeTime = $this->lastChangeTime;
		# Fill in implicit tag data for binary flag case
		$iDims = $this->implicitDims();
		if ( $iDims ) {
			$this->dims = $iDims; // binary flag case
		}
		if ( $action === 'approve' ) {
			# We must at least rate each category as 1, the minimum
			if ( in_array( 0, $this->dims, true ) ) {
				return 'review_too_low';
			}
			# Special token to discourage fiddling with templates/files...
			if ( !$this->skipValidationKey ) {
				$k = self::validationKey(
					$this->templateParams, $this->imageParams, $this->fileVersion,
					$this->oldid, $this->sessionKey );
				if ( $this->validatedParams !== $k ) {
					return 'review_bad_key';
				}
			}
			# Sanity check tags
			if ( !FlaggedRevs::flagsAreValid( $this->dims ) ) {
				return 'review_bad_tags';
			}
			# Check permissions with tags
			if ( !FlaggedRevs::userCanSetFlags( $this->user, $this->dims, $this->oldFlags ) ) {
				return 'review_denied';
			}
		} elseif ( $action === 'unapprove' ) {
			# Check permissions with old tags
			if ( !FlaggedRevs::userCanSetFlags( $this->user, $this->oldFlags ) ) {
				return 'review_denied';
			}
		}
		return true;
	}

	public function isAllowed() {
		// Basic permission check
		return ( $this->page
			&& $this->page->userCan( 'review' )
			&& $this->page->userCan( 'edit' )
		);
	}

	// implicit dims for binary flag case
	private function implicitDims() {
		$tag = FlaggedRevs::binaryTagName();
		if ( $tag ) {
			if ( $this->approve ) {
				return array( $tag => 1 );
			} elseif ( $this->unapprove ) {
				return array( $tag => 0 );
			}
		}
		return null;
	}

	/**
	 * Get the action this submission is requesting
	 * @return string (approve,unapprove,reject)
	 */
	public function getAction() {
		if ( !$this->reject && !$this->unapprove && $this->approve ) {
			return 'approve';
		} elseif ( !$this->reject && $this->unapprove && !$this->approve ) {
			return 'unapprove';
		} elseif ( $this->reject && !$this->unapprove && !$this->approve ) {
			return 'reject';
		}
		return null; // nothing valid asserted
	}

	/**
	 * Submit the form parameters for the page config to the DB.
	*
	 * @return mixed (true on success, error string on failure)
	 */
	public function doSubmit() {
		# Double-check permissions
		if ( !$this->isAllowed() ) {
			return 'review_denied';
		}
		# We can only approve actual revisions...
		if ( $this->getAction() === 'approve' ) {
			$rev = Revision::newFromTitle( $this->page, $this->oldid );
			# Check for archived/deleted revisions...
			if ( !$rev || $rev->getVisibility() ) {
				return 'review_bad_oldid';
			}
			# Check for review conflicts...
			if ( $this->lastChangeTime !== null ) { // API uses null
				$lastChange = $this->oldFrev ? $this->oldFrev->getTimestamp() : '';
				if ( $lastChange !== $this->lastChangeTime ) {
					return 'review_conflict_oldid';
				}
			}
			$status = $this->approveRevision( $rev, $this->oldFrev );
		# We can only unapprove approved revisions...
		} elseif ( $this->getAction() === 'unapprove' ) {
			# Check for review conflicts...
			if ( $this->lastChangeTime !== null ) { // API uses null
				$lastChange = $this->oldFrev ? $this->oldFrev->getTimestamp() : '';
				if ( $lastChange !== $this->lastChangeTime ) {
					return 'review_conflict_oldid';
				}
			}
			# Check if we can find this flagged rev...
			if ( !$this->oldFrev ) {
				return 'review_not_flagged';
			}
			$status = $this->unapproveRevision( $this->oldFrev );
		} elseif ( $this->getAction() === 'reject' ) {
			$newRev = Revision::newFromTitle( $this->page, $this->oldid );
			$oldRev = Revision::newFromTitle( $this->page, $this->refid );
			# Do not mess with archived/deleted revisions
			if ( !$oldRev || $oldRev->isDeleted( Revision::DELETED_TEXT ) ) {
				return 'review_bad_oldid';
			} elseif ( !$newRev || $newRev->isDeleted( Revision::DELETED_TEXT ) ) {
				return 'review_bad_oldid';
			}
			# Check that the revs are in order
			if ( $oldRev->getTimestamp() > $newRev->getTimestamp() ) {
				return 'review_cannot_undo';
			}
			# Make sure we are only rejecting pending changes
			$srev = FlaggedRevision::newFromStable( $this->page, FR_MASTER );
			if ( $srev && $oldRev->getTimestamp() < $srev->getRevTimestamp() ) {
				return 'review_cannot_reject'; // not really a use case
			}
			$article = new WikiPage( $this->page );
			# Get text with changes after $oldRev up to and including $newRev removed
			$new_text = $article->getUndoText( $newRev, $oldRev );
			if ( $new_text === false ) {
				return 'review_cannot_undo';
			}
			$baseRevId = $newRev->isCurrent() ? $oldRev->getId() : 0;

			# Actually make the edit...
			$editStatus = $article->doEdit(
				$new_text, $this->getComment(), 0, $baseRevId, $this->user );

			$status = $editStatus->isOK() ? true : 'review_cannot_undo';
			# If this undid one edit by another logged-in user, update user tallies
			if ( $status === true
				&& $newRev->getParentId() == $oldRev->getId()
				&& $newRev->getRawUser() )
			{
				if ( $newRev->getRawUser() != $this->user->getId() ) { // no self-reverts
					FRUserCounters::incCount( $newRev->getRawUser(), 'revertedEdits' );
				}
			}
		}
		# Watch page if set to do so
		if ( $status === true ) {
			if ( $this->user->getOption( 'flaggedrevswatch' ) && !$this->page->userIsWatching() ) {
				$this->user->addWatch( $this->page );
			}
		}
		return $status;
	}

	/**
	 * Adds or updates the flagged revision table for this page/id set
	 * @param Revision $rev The revision to be accepted
	 * @param FlaggedRevision $oldFrev Currently accepted version of $rev or null
	 * @return true on success, array of errors on failure
	 */
	private function approveRevision( Revision $rev, FlaggedRevision $oldFrev = null ) {
		wfProfileIn( __METHOD__ );
		# Revision rating flags
		$flags = $this->dims;
		$quality = 0; // quality tier from flags
		if ( FlaggedRevs::isQuality( $flags ) ) {
			$quality = FlaggedRevs::isPristine( $flags ) ? 2 : 1;
		}
		# Our template/file version pointers
		list( $tmpVersions, $fileVersions ) = self::getIncludeVersions(
			$this->templateParams, $this->imageParams
		);
		# If this is an image page, store corresponding file info
		$fileData = array( 'name' => null, 'timestamp' => null, 'sha1' => null );
		if ( $this->page->getNamespace() == NS_FILE && $this->fileVersion ) {
			# Stable upload version for file pages...
			$data = explode( '#', $this->fileVersion, 2 );
			if ( count( $data ) == 2 ) {
				$fileData['name'] = $this->page->getDBkey();
				$fileData['timestamp'] = $data[0];
				$fileData['sha1'] = $data[1];
			}
		}

		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_MASTER );

		# Is this a duplicate review?
		if ( $oldFrev &&
			$oldFrev->getTags() == $flags && // tags => quality
			$oldFrev->getFileSha1() == $fileData['sha1'] &&
			$oldFrev->getFileTimestamp() == $fileData['timestamp'] &&
			$oldFrev->getTemplateVersions( FR_MASTER ) == $tmpVersions &&
			$oldFrev->getFileVersions( FR_MASTER ) == $fileVersions )
		{
			wfProfileOut( __METHOD__ );
			return true; // don't record if the same
		}

		# The new review entry...
		$flaggedRevision = new FlaggedRevision( array(
			'rev'               => $rev,
			'user_id'           => $this->user->getId(),
			'timestamp'         => wfTimestampNow(),
			'quality'           => $quality,
			'tags'              => FlaggedRevision::flattenRevisionTags( $flags ),
			'img_name'          => $fileData['name'],
			'img_timestamp'     => $fileData['timestamp'],
			'img_sha1'          => $fileData['sha1'],
			'templateVersions'  => $tmpVersions,
			'fileVersions'      => $fileVersions,
			'flags'             => ''
		) );
		# Delete the old review entry if it exists...
		if ( $oldFrev ) {
			$oldFrev->delete();
		}
		# Insert the new review entry...
		if ( !$flaggedRevision->insert() ) {
			throw new MWException(
				"Flagged revision with ID {$rev->getId()} exists with unexpected fr_page_id" );
		}

		# Update the article review log...
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;
		FlaggedRevsLog::updateReviewLog( $this->page, $this->dims, $this->oldFlags,
			$this->comment, $this->oldid, $oldSvId, true );

		# Get the new stable version as of now
		$sv = FlaggedRevision::determineStable( $this->page, FR_MASTER /*consistent*/ );
		# Update recent changes...
		self::updateRecentChanges( $rev, 'patrol', $sv );
		# Update page and tracking tables and clear cache
		$changed = FlaggedRevs::stableVersionUpdates( $this->page, $sv, $oldSv );
		if ( $changed ) {
			FlaggedRevs::HTMLCacheUpdates( $this->page ); // purge pages that use this page
		}

		# Caller may want to get the change time
		$this->newLastChangeTime = $flaggedRevision->getTimestamp();

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param FlaggedRevision $frev
	 * Removes flagged revision data for this page/id set
	 */
	private function unapproveRevision( FlaggedRevision $frev ) {
		wfProfileIn( __METHOD__ );

		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_MASTER );

		# Delete from flaggedrevs table
		$frev->delete();

		# Update the article review log
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;
		FlaggedRevsLog::updateReviewLog( $this->page, $this->dims, $this->oldFlags,
			$this->comment, $this->oldid, $oldSvId, false );

		# Get the new stable version as of now
		$sv = FlaggedRevision::determineStable( $this->page, FR_MASTER /*consistent*/ );
		# Update recent changes
		self::updateRecentChanges( $frev->getRevision(), 'unpatrol', $sv );
		# Update page and tracking tables and clear cache
		$changed = FlaggedRevs::stableVersionUpdates( $this->page, $sv, $oldSv );
		if ( $changed ) {
			FlaggedRevs::HTMLCacheUpdates( $this->page ); // purge pages that use this page
		}

		# Caller may want to get the change time
		$this->newLastChangeTime = '';

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get a validation key from template/file versioning metadata
	 * @param string $tmpP
	 * @param string $imgP
	 * @param string $imgV
	 * @param integer $rid rev ID
	 * @param string $sessKey Session key
	 * @return string
	 */
	public static function validationKey( $tmpP, $imgP, $imgV, $rid, $sessKey ) {
		global $wgSecretKey, $wgProxyKey;
		$key = md5( $wgSecretKey ? $wgSecretKey : $wgProxyKey ); // fall back to $wgProxyKey
		$keyBits = $key[3] . $key[9] . $key[13] . $key[19] . $key[26];
		return md5( "{$imgP}{$tmpP}{$imgV}{$rid}{$sessKey}{$keyBits}" );
	}

	/**
	 * Update rc_patrolled fields in recent changes after (un)accepting a rev.
	 * This maintains the patrolled <=> reviewed relationship for reviewable namespaces.
	 *
	 * RecentChange should only be passed in when an RC item is saved.
	 *
	 * @param $rev Revision|RecentChange
	 * @param $patrol string "patrol" or "unpatrol"
	 * @param $srev FlaggedRevsion|null The new stable version
	 * @return void
	 */
	public static function updateRecentChanges( $rev, $patrol, $srev ) {
		global $wgUseRCPatrol;

		if ( $rev instanceof RecentChange ) {
			$pageId = $rev->mAttribs['rc_cur_id'];
		} else {
			$pageId = $rev->getPage();
		}
		$sTimestamp = $srev ? $srev->getRevTimestamp() : null;

		$dbw = wfGetDB( DB_MASTER );
		$limit = 100; // sanity limit to avoid slave lag (most useful when FR is first enabled)
		$conds = array( 'rc_cur_id' => $pageId );
		if ( !$wgUseRCPatrol ) {
			# No sense in updating all the rows, only the new page one is used.
			# If $wgUseNPPatrol is off, then not even those are used.
			$conds['rc_type'] = RC_NEW; // reduce rows to UPDATE
		}
		# If we accepted this rev, then mark prior revs as patrolled...
		if ( $patrol === 'patrol' ) {
			if ( $sTimestamp ) { // sanity check; should always be set
				$conds[] = 'rc_timestamp <= ' . $dbw->addQuotes( $dbw->timestamp( $sTimestamp ) );
				$dbw->update( 'recentchanges',
					array( 'rc_patrolled' => 1 ),
					$conds,
					__METHOD__,
					array( 'USE INDEX' => 'rc_cur_id', 'LIMIT' => $limit ) // performance
				);
			}
		# If we un-accepted this rev, then mark now-pending revs as unpatrolled...
		} elseif ( $patrol === 'unpatrol' ) {
			if ( $sTimestamp ) {
				$conds[] = 'rc_timestamp > ' . $dbw->addQuotes( $dbw->timestamp( $sTimestamp ) );
			}
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 0 ),
				$conds,
				__METHOD__,
				array( 'USE INDEX' => 'rc_cur_id', 'LIMIT' => $limit ) // performance
			);
		}
	}

	/**
	 * Get template and image parameters from parser output to use on forms.
	 * @param $templateIDs Array (from ParserOutput/OutputPage->mTemplateIds)
	 * @param $imageSHA1Keys Array (from ParserOutput/OutputPage->mImageTimeKeys)
	 * @param $fileVersion Array|null version of file for File: pages (time,sha1)
	 * @return array( templateParams, imageParams, fileVersion )
	 */
	public static function getIncludeParams(
		array $templateIDs, array $imageSHA1Keys, $fileVersion
	) {
		$templateParams = $imageParams = $fileParam = '';
		# NS -> title -> rev ID mapping
		foreach ( $templateIDs as $namespace => $t ) {
			foreach ( $t as $dbKey => $revId ) {
				$temptitle = Title::makeTitle( $namespace, $dbKey );
				$templateParams .= $temptitle->getPrefixedDBKey() . "|" . $revId . "#";
			}
		}
		# Image -> timestamp -> sha1 mapping
		foreach ( $imageSHA1Keys as $dbKey => $timeAndSHA1 ) {
			$imageParams .= $dbKey . "|" . $timeAndSHA1['time'] . "|" . $timeAndSHA1['sha1'] . "#";
		}
		# For File: pages, note the displayed image version
		if ( is_array( $fileVersion ) ) {
			$fileParam = $fileVersion['time'] . "#" . $fileVersion['sha1'];
		}
		return array( $templateParams, $imageParams, $fileParam );
	}

	/**
	 * Get template and image versions from form value for parser output.
	 * @param string $templateParams
	 * @param string $imageParams
	 * @return array( templateIds, fileSHA1Keys )
	 * templateIds like ParserOutput->mTemplateIds
	 * fileSHA1Keys like ParserOutput->mImageTimeKeys
	 */
	public static function getIncludeVersions( $templateParams, $imageParams ) {
		$templateIds = array();
		$templateMap = explode( '#', trim( $templateParams ) );
		foreach ( $templateMap as $template ) {
			if ( !$template ) {
				continue;
			}
			$m = explode( '|', $template, 2 );
			if ( !isset( $m[0] ) || !isset( $m[1] ) || !$m[0] ) {
				continue;
			}
			list( $prefixed_text, $rev_id ) = $m;
			# Get the template title
			$tmp_title = Title::newFromText( $prefixed_text ); // Normalize this to be sure...
			if ( is_null( $tmp_title ) ) {
				continue; // Page must be valid!
			}
			if ( !isset( $templateIds[$tmp_title->getNamespace()] ) ) {
				$templateIds[$tmp_title->getNamespace()] = array();
			}
			$templateIds[$tmp_title->getNamespace()][$tmp_title->getDBkey()] = $rev_id;
		}
		# Our image version pointers
		$fileSHA1Keys = array();
		$imageMap = explode( '#', trim( $imageParams ) );
		foreach ( $imageMap as $image ) {
			if ( !$image ) {
				continue;
			}
			$m = explode( '|', $image, 3 );
			# Expand our parameters ... <name>#<timestamp>#<key>
			if ( !isset( $m[0] ) || !isset( $m[1] ) || !isset( $m[2] ) || !$m[0] ) {
				continue;
			}
			list( $dbkey, $time, $key ) = $m;
			# Get the file title
			$img_title = Title::makeTitle( NS_FILE, $dbkey ); // Normalize
			if ( is_null( $img_title ) ) {
				continue; // Page must be valid!
			}
			$fileSHA1Keys[$img_title->getDBkey()] = array();
			$fileSHA1Keys[$img_title->getDBkey()]['time'] = $time ? $time : false;
			$fileSHA1Keys[$img_title->getDBkey()]['sha1'] = strlen( $key ) ? $key : false;
		}
		return array( $templateIds, $fileSHA1Keys );
	}
}
