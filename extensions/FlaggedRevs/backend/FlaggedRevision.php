<?php
/**
 * Class representing a stable version of a MediaWiki revision
 *
 * This contains a page revision, a file version, and versions
 * of templates and files (to determine template inclusion and thumbnails)
 */
class FlaggedRevision {
	private $mRevision;         // base revision
	private $mTemplates;        // included template versions
	private $mFiles;            // included file versions
	private $mFileSha1;         // file version sha-1 (for revisions of File pages)
	private $mFileTimestamp;    // file version timestamp (for revisions of File pages)
	/* Flagging metadata */
	private $mTimestamp;        // review timestamp
	private $mQuality;          // review tier
	private $mTags;             // review tags
	private $mFlags;            // flags (for auto-review ect...)
	private $mUser;             // reviewing user
	private $mFileName;         // file name when reviewed
	/* Redundant fields for lazy-loading */
	private $mTitle;            // page title
	private $mStableTemplates;  // stable versions of template version used
	private $mStableFiles;      // stable versions of file versions used

	/**
	 * @param Row|array $row (DB row or array)
	 * @return void
	 */
	public function __construct( $row ) {
		if ( is_object( $row ) ) {
			$this->mTimestamp = $row->fr_timestamp;
			$this->mQuality = intval( $row->fr_quality );
			$this->mTags = self::expandRevisionTags( strval( $row->fr_tags ) );
			$this->mFlags = explode( ',', $row->fr_flags );
			$this->mUser = intval( $row->fr_user );
			# Base Revision object
			$this->mRevision = new Revision( $row );
			# Image page revision relevant params
			$this->mFileName = $row->fr_img_name ? $row->fr_img_name : null;
			$this->mFileSha1 = $row->fr_img_sha1 ? $row->fr_img_sha1 : null;
			$this->mFileTimestamp = $row->fr_img_timestamp ?
				$row->fr_img_timestamp : null;
			# Optional fields
			$this->mTitle = isset( $row->page_namespace ) && isset( $row->page_title )
				? Title::makeTitleSafe( $row->page_namespace, $row->page_title )
				: null;
		} elseif ( is_array( $row ) ) {
			$this->mTimestamp = $row['timestamp'];
			$this->mQuality = intval( $row['quality'] );
			$this->mTags = self::expandRevisionTags( strval( $row['tags'] ) );
			$this->mFlags = explode( ',', $row['flags'] );
			$this->mUser = intval( $row['user_id'] );
			# Base Revision object
			$this->mRevision = $row['rev'];
			# Image page revision relevant params
			$this->mFileName = $row['img_name'] ? $row['img_name'] : null;
			$this->mFileSha1 = $row['img_sha1'] ? $row['img_sha1'] : null;
			$this->mFileTimestamp = $row['img_timestamp'] ?
				$row['img_timestamp'] : null;
			# Optional fields
			$this->mTemplates = isset( $row['templateVersions'] ) ?
				$row['templateVersions'] : null;
			$this->mFiles = isset( $row['fileVersions'] ) ?
				$row['fileVersions'] : null;
		} else {
			throw new MWException( 'FlaggedRevision constructor passed invalid row format.' );
		}
		if ( !( $this->mRevision instanceof Revision ) ) {
			throw new MWException( 'FlaggedRevision constructor passed invalid Revision object.' );
		}
	}

	/**
	 * Get a FlaggedRevision for a title and rev ID.
	 * Note: will return NULL if the revision is deleted.
	 * @param Title $title
	 * @param int $revId
	 * @param int $flags (FR_MASTER, FR_FOR_UPDATE)
	 * @return FlaggedRevision|null (null on failure)
	 */
	public static function newFromTitle( Title $title, $revId, $flags = 0 ) {
		if ( !FlaggedRevs::inReviewNamespace( $title ) ) {
			return null; // short-circuit
		}
		$options = array();
		# User master/slave as appropriate...
		if ( $flags & FR_FOR_UPDATE || $flags & FR_MASTER ) {
			$db = wfGetDB( DB_MASTER );
			if ( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
			$pageId = $title->getArticleID( Title::GAID_FOR_UPDATE );
		} else {
			$db = wfGetDB( DB_SLAVE );
			$pageId = $title->getArticleID();
		}
		if ( !$pageId || !$revId ) {
			return null; // short-circuit query
		}
		# Skip deleted revisions
		$row = $db->selectRow(
			array( 'flaggedrevs', 'revision' ),
			self::selectFields(),
			array(
				'fr_page_id' => $pageId,
				'fr_rev_id'  => $revId,
				'rev_id = fr_rev_id',
				'rev_page = fr_page_id', // sanity
				$db->bitAnd( 'rev_deleted', Revision::DELETED_TEXT ) . ' = 0'
			),
			__METHOD__,
			$options
		);
		# Sorted from highest to lowest, so just take the first one if any
		if ( $row ) {
			$frev = new self( $row );
			$frev->mTitle = $title;
			return $frev;
		}
		return null;
	}

	/**
	 * Get a FlaggedRevision of the stable version of a title.
	 * Note: will return NULL if the revision is deleted, though this
	 * should never happen as fp_stable is updated as revs are deleted.
	 * @param Title $title, page title
	 * @param int $flags (FR_MASTER, FR_FOR_UPDATE)
	 * @return FlaggedRevision|null (null on failure)
	 */
	public static function newFromStable( Title $title, $flags = 0 ) {
		if ( !FlaggedRevs::inReviewNamespace( $title ) ) {
			return null; // short-circuit
		}
		$options = array();
		# User master/slave as appropriate...
		if ( $flags & FR_FOR_UPDATE || $flags & FR_MASTER ) {
			$db = wfGetDB( DB_MASTER );
			if ( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
			$pageId = $title->getArticleID( Title::GAID_FOR_UPDATE );
		} else {
			$db = wfGetDB( DB_SLAVE );
			$pageId = $title->getArticleID();
		}
		if ( !$pageId ) {
			return null; // short-circuit query
		}
		# Check tracking tables
		$row = $db->selectRow(
			array( 'flaggedpages', 'flaggedrevs', 'revision' ),
			self::selectFields(),
			array(
				'fp_page_id' => $pageId,
				'fr_rev_id = fp_stable',
				'rev_id = fr_rev_id',
				'rev_page = fr_page_id', // sanity
				$db->bitAnd( 'rev_deleted', Revision::DELETED_TEXT ) . ' = 0', // sanity
			),
			__METHOD__,
			$options
		);
		if ( $row ) {
			$frev = new self( $row );
			$frev->mTitle = $title;
			return $frev;
		}
		return null;
	}

	/**
	 * Get a FlaggedRevision for a rev ID.
	 * Note: will return NULL if the revision is deleted.
	 * @param int $revId
	 * @param int $flags (FR_MASTER, FR_FOR_UPDATE)
	 * @return FlaggedRevision|null (null on failure)
	 */
	public static function newFromId( $revId, $flags = 0 ) {
		$options = array();
		# User master/slave as appropriate...
		if ( $flags & FR_FOR_UPDATE || $flags & FR_MASTER ) {
			$db = wfGetDB( DB_MASTER );
			if ( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
		} else {
			$db = wfGetDB( DB_SLAVE );
		}
		if ( !$revId ) {
			return null; // short-circuit query
		}
		# Skip deleted revisions
		$row = $db->selectRow(
			array( 'flaggedrevs', 'revision', 'page' ),
			self::selectFields(),
			array(
				'fr_rev_id' => $revId,
				'rev_id = fr_rev_id',
				'rev_page = fr_page_id', // sanity
				'page_id = rev_page',
				$db->bitAnd( 'rev_deleted', Revision::DELETED_TEXT ) . ' = 0',
			),
			__METHOD__,
			$options
		);
		if ( $row ) {
			$frev = new self( $row );
			$frev->mTitle = Title::newFromRow( $row );
			return $frev;
		}
		return null;
	}

	/**
	 * Get the ID of the stable version of a title.
	 * @param Title $title, page title
	 * @param int $flags (FR_MASTER, FR_FOR_UPDATE)
	 * @return int (0 on failure)
	 */
	public static function getStableRevId( Title $title, $flags = 0 ) {
		$srev = self::newFromStable( $title, $flags );
		return $srev ? $srev->getRevId() : 0;
	}

	/**
	 * Get a FlaggedRevision of the stable version of a title.
	 * Skips tracking tables to figure out new stable version.
	 * @param Title $title, page title
	 * @param int $flags (FR_MASTER, FR_FOR_UPDATE)
	 * @param array $config, optional page config (use to skip queries)
	 * @param string $precedence (latest,quality,pristine)
	 * @return FlaggedRevision|null (null on failure)
	 */
	public static function determineStable(
		Title $title, $flags = 0, $config = array(), $precedence = 'latest'
	) {
		if ( !FlaggedRevs::inReviewNamespace( $title ) ) {
			return null; // short-circuit
		}
		$options = array();
		# User master/slave as appropriate...
		if ( $flags & FR_FOR_UPDATE || $flags & FR_MASTER ) {
			$db = wfGetDB( DB_MASTER );
			if ( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
			$pageId = $title->getArticleID( Title::GAID_FOR_UPDATE );
		} else {
			$db = wfGetDB( DB_SLAVE );
			$pageId = $title->getArticleID();
		}
		if ( !$pageId ) {
			return null; // short-circuit query
		}
		# Get visiblity settings to see if page is reviewable...
		if ( FlaggedRevs::useOnlyIfProtected() ) {
			if ( empty( $config ) ) {
			   $config = FRPageConfig::getStabilitySettings( $title, $flags );
			}
			if ( !$config['override'] ) {
				return null; // page is not reviewable; no stable version
			}
		}
		$baseConds = array(
			'fr_page_id' => $pageId,
			'rev_id = fr_rev_id',
			'rev_page = fr_page_id', // sanity
			'rev_deleted & ' . Revision::DELETED_TEXT => 0
		);
		$options['ORDER BY'] = 'fr_rev_timestamp DESC';

		$row = null;
		if ( $precedence !== 'latest' ) {
			# Look for the latest pristine revision...
			if ( FlaggedRevs::pristineVersions() ) {
				$prow = $db->selectRow(
					array( 'flaggedrevs', 'revision' ),
					self::selectFields(),
					array_merge( $baseConds, array( 'fr_quality' => FR_PRISTINE ) ),
					__METHOD__,
					$options
				);
				# Looks like a plausible revision
				$row = $prow ? $prow : $row;
			}
			if ( $row && $precedence === 'pristine' ) {
				// we have what we want already
			# Look for the latest quality revision...
			} elseif ( FlaggedRevs::qualityVersions() ) {
				// If we found a pristine rev above, this one must be newer...
				$newerClause = $row
					? array( 'fr_rev_timestamp > '.$db->addQuotes( $row->fr_rev_timestamp ) )
					: array();
				$qrow = $db->selectRow(
					array( 'flaggedrevs', 'revision' ),
					self::selectFields(),
					array_merge( $baseConds, array( 'fr_quality' => FR_QUALITY ), $newerClause ),
					__METHOD__,
					$options
				);
				$row = $qrow ? $qrow : $row;
			}
		}
		# Do we have one? If not, try the latest reviewed revision...
		if ( !$row ) {
			$row = $db->selectRow(
				array( 'flaggedrevs', 'revision' ),
				self::selectFields(),
				$baseConds,
				__METHOD__,
				$options
			);
			if ( !$row ) {
				return null;
			}
		}
		$frev = new self( $row );
		$frev->mTitle = $title;
		return $frev;
	}

	/*
	 * Insert a FlaggedRevision object into the database
	*
	 * @return bool success
	 */
	public function insert() {
		$dbw = wfGetDB( DB_MASTER );
		# Set any flagged revision flags
		$this->mFlags = array_merge( $this->mFlags, array( 'dynamic' ) ); // legacy
		# Build the inclusion data chunks
		$tmpInsertRows = array();
		foreach ( (array)$this->mTemplates as $namespace => $titleAndID ) {
			foreach ( $titleAndID as $dbkey => $id ) {
				$tmpInsertRows[] = array(
					'ft_rev_id'     => $this->getRevId(),
					'ft_namespace'  => (int)$namespace,
					'ft_title'      => $dbkey,
					'ft_tmp_rev_id' => (int)$id
				);
			}
		}
		$fileInsertRows = array();
		foreach ( (array)$this->mFiles as $dbkey => $timeSHA1 ) {
			$fileInsertRows[] = array(
				'fi_rev_id'         => $this->getRevId(),
				'fi_name'           => $dbkey,
				'fi_img_sha1'       => strval( $timeSHA1['sha1'] ),
				'fi_img_timestamp'  => $timeSHA1['time'] ? // false => NULL
					$dbw->timestamp( $timeSHA1['time'] ) : null
			);
		}
		# Sanity check for partial revisions
		if ( !$this->getPage() || !$this->getRevId() ) {
			return false; // bogus entry
		}
		# Our new review entry
		$revRow = array(
			'fr_page_id'       => $this->getPage(),
			'fr_rev_id'        => $this->getRevId(),
			'fr_rev_timestamp' => $dbw->timestamp( $this->getRevTimestamp() ),
			'fr_user'          => $this->mUser,
			'fr_timestamp'     => $dbw->timestamp( $this->mTimestamp ),
			'fr_quality'       => $this->mQuality,
			'fr_tags'          => self::flattenRevisionTags( $this->mTags ),
			'fr_flags'         => implode( ',', $this->mFlags ),
			'fr_img_name'      => $this->mFileName,
			'fr_img_timestamp' => $dbw->timestampOrNull( $this->mFileTimestamp ),
			'fr_img_sha1'      => $this->mFileSha1
		);
		# Update the main flagged revisions table...
		$dbw->insert( 'flaggedrevs', $revRow, __METHOD__, 'IGNORE' );
		if ( !$dbw->affectedRows() ) {
			return false; // duplicate review
		}
		# ...and insert template version data
		if ( $tmpInsertRows ) {
			$dbw->insert( 'flaggedtemplates', $tmpInsertRows, __METHOD__, 'IGNORE' );
		}
		# ...and insert file version data
		if ( $fileInsertRows ) {
			$dbw->insert( 'flaggedimages', $fileInsertRows, __METHOD__, 'IGNORE' );
		}
		return true;
	}

	/*
	 * Remove a FlaggedRevision object from the database
	*
	 * @return bool success
	 */
	public function delete() {
		$dbw = wfGetDB( DB_MASTER );
		# Delete from flaggedrevs table
		$dbw->delete( 'flaggedrevs',
			array( 'fr_rev_id' => $this->getRevId() ), __METHOD__ );
		# Wipe versioning params...
		$dbw->delete( 'flaggedtemplates',
			array( 'ft_rev_id' => $this->getRevId() ), __METHOD__ );
		$dbw->delete( 'flaggedimages',
			array( 'fi_rev_id' => $this->getRevId() ), __METHOD__ );
		return true;
	}

	/**
	 * Get select fields for FlaggedRevision DB row (flaggedrevs/revision tables)
	 * @return array
	 */
	public static function selectFields() {
		return array_merge(
			Revision::selectFields(),
			array( 'fr_rev_id', 'fr_page_id', 'fr_rev_timestamp',
				'fr_user', 'fr_timestamp', 'fr_quality', 'fr_tags', 'fr_flags',
				'fr_img_name', 'fr_img_sha1', 'fr_img_timestamp' )
		);
	}

	/**
	 * @return integer revision ID
	 */
	public function getRevId() {
		return $this->mRevision->getId();
	}

	/**
	 * @return integer page ID
	 */
	public function getPage() {
		return $this->mRevision->getPage();
	}

	/**
	 * @return Title title
	 */
	public function getTitle() {
		if ( is_null( $this->mTitle ) ) {
			$this->mTitle = $this->mRevision->getTitle();
		}
		return $this->mTitle;
	}

	/**
	 * Get timestamp of review
	 * @return string revision timestamp in MW format
	 */
	public function getTimestamp() {
		return wfTimestamp( TS_MW, $this->mTimestamp );
	}

	/**
	 * Get timestamp of the corresponding revision
	 * Note: here for convenience
	 * @return string revision timestamp in MW format
	 */
	public function getRevTimestamp() {
		return $this->mRevision->getTimestamp();
	}

	/**
	 * Get the corresponding revision
	 * @return Revision
	 */
	public function getRevision() {
		return $this->mRevision;
	}

	/**
	 * Check if the corresponding revision is the current revision
	 * Note: here for convenience
	 * @return bool
	 */
	public function revIsCurrent() {
		return $this->mRevision->isCurrent();
	}

	/**
	 * Get text of the corresponding revision
	 * Note: here for convenience
	 * @return string|false revision timestamp in MW format
	 */
	public function getRevText() {
		return $this->mRevision->getText();
	}

	/**
	 * @return integer the user ID of the reviewer
	 */
	public function getUser() {
		return $this->mUser;
	}

	/**
	 * @return integer quality level (FR_CHECKED,FR_QUALITY,FR_PRISTINE)
	 */
	public function getQuality() {
		return $this->mQuality;
	}

	/**
	 * @return array tag metadata
	 */
	public function getTags() {
		return $this->mTags;
	}

	/**
	 * @return string, filename accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileName() {
		return $this->mFileName;
	}

	/**
	 * @return string, sha1 key accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileSha1() {
		return $this->mFileSha1;
	}

	/**
	 * @return string, timestamp accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileTimestamp() {
		return wfTimestampOrNull( TS_MW, $this->mFileTimestamp );
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function userCanSetFlags( $user ) {
		return FlaggedRevs::userCanSetFlags( $user, $this->mTags );
	}

	/**
	 * Get original template versions at time of review
	 * @param int $flags FR_MASTER
	 * @return array template versions (ns -> dbKey -> rev Id)
	 * Note: 0 used for template rev Id if it didn't exist
	 */
	public function getTemplateVersions( $flags = 0 ) {
		if ( $this->mTemplates == null ) {
			$this->mTemplates = array();
			$db = ( $flags & FR_MASTER ) ?
				wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $db->select( 'flaggedtemplates',
				array( 'ft_namespace', 'ft_title', 'ft_tmp_rev_id' ),
				array( 'ft_rev_id' => $this->getRevId() ),
				__METHOD__
			);
			foreach ( $res as $row ) {
				if ( !isset( $this->mTemplates[$row->ft_namespace] ) ) {
					$this->mTemplates[$row->ft_namespace] = array();
				}
				$this->mTemplates[$row->ft_namespace][$row->ft_title] = $row->ft_tmp_rev_id;
			}
		}
		return $this->mTemplates;
	}

	/**
	 * Get original template versions at time of review
	 * @param int $flags FR_MASTER
	 * @return array file versions (dbKey => array('time' => MW timestamp,'sha1' => sha1) )
	 * Note: false used for file timestamp/sha1 if it didn't exist
	 */
	public function getFileVersions( $flags = 0 ) {
		if ( $this->mFiles == null ) {
			$this->mFiles = array();
			$db = ( $flags & FR_MASTER ) ?
				wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $db->select( 'flaggedimages',
				array( 'fi_name', 'fi_img_timestamp', 'fi_img_sha1' ),
				array( 'fi_rev_id' => $this->getRevId() ),
				__METHOD__
			);
			foreach ( $res as $row ) {
				$reviewedTS = $reviewedSha1 = false;
				$fi_img_timestamp = trim( $row->fi_img_timestamp ); // may have \0's
				if ( $fi_img_timestamp ) {
					$reviewedTS = wfTimestamp( TS_MW, $fi_img_timestamp );
					$reviewedSha1 = strval( $row->fi_img_sha1 );
				}
				$this->mFiles[$row->fi_name] = array();
				$this->mFiles[$row->fi_name]['time'] = $reviewedTS;
				$this->mFiles[$row->fi_name]['sha1'] = $reviewedSha1;
			}
		}
		return $this->mFiles;
	}

	/**
	 * Get the current stable version of the templates used at time of review
	 * @param int $flags FR_MASTER
	 * @return array template versions (ns -> dbKey -> rev Id)
	 * Note: 0 used for template rev Id if it doesn't exist
	 */
	public function getStableTemplateVersions( $flags = 0 ) {
		if ( $this->mStableTemplates == null ) {
			$this->mStableTemplates = array();
			$db = ( $flags & FR_MASTER ) ?
				wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $db->select(
				array( 'flaggedtemplates', 'page', 'flaggedpages' ),
				array( 'ft_namespace', 'ft_title', 'fp_stable' ),
				array( 'ft_rev_id' => $this->getRevId() ),
				__METHOD__,
				array(),
				array(
					'page' => array( 'LEFT JOIN',
						'page_namespace = ft_namespace AND page_title = ft_title'),
					'flaggedpages' => array( 'LEFT JOIN', 'fp_page_id = page_id' )
				)
			);
			foreach ( $res as $row ) {
				if ( !isset( $this->mStableTemplates[$row->ft_namespace] ) ) {
					$this->mStableTemplates[$row->ft_namespace] = array();
				}
				$revId = (int)$row->fp_stable; // 0 => none
				$this->mStableTemplates[$row->ft_namespace][$row->ft_title] = $revId;
			}
		}
		return $this->mStableTemplates;
	}

	/**
	 * Get the current stable version of the files used at time of review
	 * @param int $flags FR_MASTER
	 * @return array file versions (dbKey => array('time' => MW timestamp,'sha1' => sha1) )
	 * Note: false used for file timestamp/sha1 if it didn't exist
	 */
	public function getStableFileVersions( $flags = 0 ) {
		if ( $this->mStableFiles == null ) {
			$this->mStableFiles = array();
			$db = ( $flags & FR_MASTER ) ?
				wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $db->select(
				array( 'flaggedimages', 'page', 'flaggedpages', 'flaggedrevs' ),
				array( 'fi_name', 'fr_img_timestamp', 'fr_img_sha1' ),
				array( 'fi_rev_id' => $this->getRevId() ),
				__METHOD__,
				array(),
				array(
					'page'          => array( 'LEFT JOIN',
					'page_namespace = ' . NS_FILE . ' AND page_title = fi_name' ),
					'flaggedpages'  => array( 'LEFT JOIN', 'fp_page_id = page_id' ),
					'flaggedrevs'   => array( 'LEFT JOIN', 'fr_rev_id = fp_stable' )
				)
			);
			foreach ( $res as $row ) {
				$reviewedTS = $reviewedSha1 = false;
				if ( $row->fr_img_timestamp ) {
					$reviewedTS = wfTimestamp( TS_MW, $row->fr_img_timestamp );
					$reviewedSha1 = strval( $row->fr_img_sha1 );
				}
				$this->mStableFiles[$row->fi_name] = array();
				$this->mStableFiles[$row->fi_name]['time'] = $reviewedTS;
				$this->mStableFiles[$row->fi_name]['sha1'] = $reviewedSha1;
			}
		}
		return $this->mStableFiles;
	}

	/**
	 * Fetch pending template changes for this reviewed page version.
	 * For each template, the "version used" (for stable parsing) is:
	 *    (a) (the latest rev) if FR_INCLUDES_CURRENT. Might be non-existing.
	 *    (b) newest( stable rev, rev at time of review ) if FR_INCLUDES_STABLE
	 *    (c) ( rev at time of review ) if FR_INCLUDES_FREEZE
	 * Pending changes exist for a template iff the template is used in
	 * the current rev of this page and one of the following holds:
	 *    (a) Current template is newer than the "version used" above (updated)
	 *    (b) Current template exists and the "version used" was non-existing (created)
	 *    (c) Current template doesn't exist and the "version used" existed (deleted)
	 *
	 * @return array of (title, rev ID in reviewed version, has stable rev) tuples
	 */
	public function findPendingTemplateChanges() {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return array(); // short-circuit
		}
		$dbr = wfGetDB( DB_SLAVE );
		# Only get templates with stable or "review time" versions.
		# Note: ft_tmp_rev_id is nullable (for deadlinks), so use ft_title
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
			$reviewed = "ft_title IS NOT NULL OR fp_stable IS NOT NULL";
		} else {
			$reviewed = "ft_title IS NOT NULL";
		}
		$ret = $dbr->select(
			array( 'templatelinks', 'flaggedtemplates', 'page', 'flaggedpages' ),
			array( 'tl_namespace', 'tl_title', 'fp_stable', 'ft_tmp_rev_id', 'page_latest' ),
			array( 'tl_from' => $this->getPage(), $reviewed ), // current version templates
			__METHOD__,
			array(), /* OPTIONS */
			array(
				'flaggedtemplates'  => array( 'LEFT JOIN',
					array( 'ft_rev_id' => $this->getRevId(),
						'ft_namespace = tl_namespace AND ft_title = tl_title' ) ),
				'page'              => array( 'LEFT JOIN',
					'page_namespace = tl_namespace AND page_title = tl_title' ),
				'flaggedpages'      => array( 'LEFT JOIN', 'fp_page_id = page_id' )
			)
		);
		$tmpChanges = array();
		foreach ( $ret as $row ) { // each template
			$revIdDraft = (int)$row->page_latest; // may be NULL
			$revIdStable = (int)$row->fp_stable; // may be NULL
			$revIdReviewed = (int)$row->ft_tmp_rev_id; // review-time version
			# Get template ID used in this FlaggedRevision when parsed
			$revIdUsed = self::templateIdUsed( $revIdStable, $revIdReviewed );
			# Check for edits/creations/deletions...
			if ( self::templateChanged( $revIdDraft, $revIdUsed ) ) {
				$title = Title::makeTitleSafe( $row->tl_namespace, $row->tl_title );
				$tmpChanges[] = array( $title, $revIdUsed, (bool)$revIdStable );
			}
		}
		return $tmpChanges;
	}

	protected function templateIdUsed( $revIdStable, $revIdReviewed ) {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
			# Select newest of (stable rev, rev when reviewed) as "version used"
			$revIdUsed = max( $revIdStable, $revIdReviewed );
		} else {
			$revIdUsed = $revIdReviewed; // may be NULL
		}
		return (int)$revIdUsed;
	}

	protected function templateChanged( $revIdDraft, $revIdUsed ) {
		if ( $revIdDraft && !$revIdUsed ) {
			return true; // later created
		}
		if ( !$revIdDraft && $revIdUsed ) {
			return true; // later deleted
		}
		if ( $revIdDraft && $revIdUsed && $revIdDraft != $revIdUsed ) {
			$dRev = Revision::newFromId( $revIdDraft );
			$sRev = Revision::newFromId( $revIdUsed );
			if ( !$sRev || $sRev->isDeleted( Revision::DELETED_TEXT ) ) {
				return true; // rev deleted
			}
			# Don't do this for null edits (like protection) (bug 25919)
			if ( $dRev && $sRev && $dRev->getTextId() != $sRev->getTextId() ) {
				return true; // updated
			}
		}
		return false;
	}

	/**
	 * Fetch pending file changes for this reviewed page version.
	 * For each file, the "version used" (for stable parsing) is:
	 *    (a) (the latest rev) if FR_INCLUDES_CURRENT. Might be non-existing.
	 *    (b) newest( stable rev, rev at time of review ) if FR_INCLUDES_STABLE
	 *    (c) ( rev at time of review ) if FR_INCLUDES_FREEZE
	 * Pending changes exist for a file iff the file is used in
	 * the current rev of this page and one of the following holds:
	 *    (a) Current file is newer than the "version used" above (updated)
	 *    (b) Current file exists and the "version used" was non-existing (created)
	 *    (c) Current file doesn't exist and the "version used" existed (deleted)
	 *
	 * @param string $noForeign Using 'noForeign' skips foreign file updates (bug 15748)
	 * @return array of (title, MW file timestamp in reviewed version, has stable rev) tuples
	 */
	public function findPendingFileChanges( $noForeign = false ) {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return array(); // short-circuit
		}
		$dbr = wfGetDB( DB_SLAVE );
		# Only get templates with stable or "review time" versions.
		# Note: fi_img_timestamp is nullable (for deadlinks), so use fi_name
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
			$reviewed = "fi_name IS NOT NULL OR fr_img_timestamp IS NOT NULL";
		} else {
			$reviewed = "fi_name IS NOT NULL";
		}
		$ret = $dbr->select(
			array( 'imagelinks', 'flaggedimages', 'page', 'flaggedpages', 'flaggedrevs' ),
			array( 'il_to', 'fi_img_timestamp', 'fr_img_timestamp' ),
			array( 'il_from' => $this->getPage(), $reviewed ), // current version files
				__METHOD__,
			array(), /* OPTIONS */
			array(
				'flaggedimages' => array( 'LEFT JOIN',
					array( 'fi_rev_id' => $this->getRevId(), 'fi_name = il_to' ) ),
				'page'          => array( 'LEFT JOIN',
					'page_namespace = ' . NS_FILE . ' AND page_title = il_to' ),
				'flaggedpages'  => array( 'LEFT JOIN', 'fp_page_id = page_id' ),
				'flaggedrevs'   => array( 'LEFT JOIN', 'fr_rev_id = fp_stable' )
			)
		);
		$fileChanges = array();
		foreach ( $ret as $row ) { // each file
			$reviewedTS = trim( $row->fi_img_timestamp ); // may have \0's
			$reviewedTS = $reviewedTS ? wfTimestamp( TS_MW, $reviewedTS ) : null;
			$stableTS = wfTimestampOrNull( TS_MW, $row->fr_img_timestamp );
			# Get file timestamp used in this FlaggedRevision when parsed
			$usedTS = self::fileTimestampUsed( $stableTS, $reviewedTS );
			# Check for edits/creations/deletions...
			$title = Title::makeTitleSafe( NS_FILE, $row->il_to );
			if ( self::fileChanged( $title, $usedTS, $noForeign ) ) {
				$fileChanges[] = array( $title, $usedTS, (bool)$stableTS );
			}
		}
		return $fileChanges;
	}

	protected function fileTimestampUsed( $stableTS, $reviewedTS ) {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
			# Select newest of (stable rev, rev when reviewed) as "version used"
			$usedTS = max( $stableTS, $reviewedTS );
		} else {
			$usedTS = $reviewedTS;
		}
		return $usedTS;
	}

	protected function fileChanged( $title, $usedTS, $noForeign ) {
		$file = wfFindFile( $title ); // current file version
		# Compare this version to the current version and check for things
		# that would make the stable version unsynced with the draft...
		if ( $file instanceof File ) { // file exists
			if ( $noForeign === 'noForeign' && !$file->isLocal() ) {
				# Avoid counting edits to Commons files, which can effect
				# many pages, as there is no expedient way to review them.
				$updated = !$usedTS; // created (ignore new versions)
			} else {
				$updated = ( $file->getTimestamp() > $usedTS ); // edited/created
			}
			$deleted = $usedTS // included file deleted after review
				&& $file->getTimestamp() != $usedTS
				&& !wfFindFile( $title, array( 'time' => $usedTS ) );
		} else { // file doesn't exists
			$updated = false;
			$deleted = (bool)$usedTS; // included file deleted after review
		}
		return ( $deleted || $updated );
	}

	/**
	 * Fetch pending template changes for this reviewed page
	 * version against a list of current versions of templates.
	 * See findPendingTemplateChanges() for details.
	 *
	 * @return array of (title, rev ID in reviewed version, has stable rev) tuples
	 */
	public function findTemplateChanges( array $newTemplates ) {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return array(); // short-circuit
		}
		$tmpChanges = array();
		$rTemplates = $this->getTemplateVersions();
		$sTemplates = $this->getStableTemplateVersions();
		foreach ( $newTemplates as $ns => $tmps ) {
			foreach ( $tmps as $dbKey => $revIdDraft ) {
				$title = Title::makeTitle( $ns, $dbKey );
				$revIdDraft = (int)$revIdDraft;
				$revIdStable = isset( $sTemplates[$ns][$dbKey] )
					? (int)$sTemplates[$ns][$dbKey]
					: self::getStableRevId( $title );
				$revIdReviewed = isset( $rTemplates[$ns][$dbKey] )
					? (int)$rTemplates[$ns][$dbKey]
					: 0;
				# Get template used in this FlaggedRevision when parsed
				$revIdUsed = self::templateIdUsed( $revIdStable, $revIdReviewed );
				# Check for edits/creations/deletions...
				if ( self::templateChanged( $revIdDraft, $revIdUsed ) ) {
					$tmpChanges[] = array( $title, $revIdUsed, (bool)$revIdStable );
				}
			}
		}
		return $tmpChanges;
	}

	/**
	 * Fetch pending file changes for this reviewed page
	 * version against a list of current versions of files.
	 * See findPendingFileChanges() for details.
	 *
	 * @param string $noForeign Using 'noForeign' skips foreign file updates (bug 15748)
	 * @return array of (title, MW file timestamp in reviewed version, has stable rev) tuples
	 */
	public function findFileChanges( array $newFiles, $noForeign = false ) {
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return array(); // short-circuit
		}
		$fileChanges = array();
		$rFiles = $this->getFileVersions();
		$sFiles = $this->getStableFileVersions();
		foreach ( $newFiles as $dbKey => $sha1Time ) {
			$reviewedTS = isset( $rFiles[$dbKey]['time'] )
				? $rFiles[$dbKey]['time']
				: null;
			$stableTS = isset( $sFiles[$dbKey]['time'] )
				? $sFiles[$dbKey]['time']
				: null;
			# Get file timestamp used in this FlaggedRevision when parsed
			$usedTS = self::fileTimestampUsed( $stableTS, $reviewedTS );
			# Check for edits/creations/deletions...
			$title = Title::makeTitleSafe( NS_FILE, $dbKey );
			if ( self::fileChanged( $title, $usedTS, $noForeign ) ) {
				$fileChanges[] = array( $title, $usedTS, (bool)$stableTS );
			}
		}
		return $fileChanges;
	}

	/**
	 * @param int $rev_id
	 * @param $flags FR_MASTER
	 * @return mixed (int or false)
	 * Get quality of a revision
	 */
	public static function getRevQuality( $rev_id, $flags = 0 ) {
		$db = ( $flags & FR_MASTER ) ?
			wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		return $db->selectField( 'flaggedrevs',
			'fr_quality',
			array( 'fr_rev_id' => $rev_id ),
			__METHOD__
		);
	}

	/**
	 * @param int $rev_id
	 * @param $flags FR_MASTER
	 * @return bool
	 * Useful for quickly pinging to see if a revision is flagged
	 */
	public static function revIsFlagged( $rev_id, $flags = 0 ) {
		return ( self::getRevQuality( $rev_id, $flags ) !== false );
	}

	/**
	 * Get flags for a revision
	 * @param string $tags
	 * @return array
	 */
	public static function expandRevisionTags( $tags ) {
		$flags = array();
		foreach ( FlaggedRevs::getTags() as $tag ) {
			$flags[$tag] = 0; // init all flags values to zero
		}
		$tags = str_replace( '\n', "\n", $tags ); // B/C, old broken rows
		// Tag string format is <tag:val\ntag:val\n...>
		$tags = explode( "\n", $tags );
		foreach ( $tags as $tuple ) {
			$set = explode( ':', $tuple, 2 );
			if ( count( $set ) == 2 ) {
				list( $tag, $value ) = $set;
				$value = max( 0, (int)$value ); // validate
				# Add only currently recognized tags
				if ( isset( $flags[$tag] ) ) {
					$levels = FlaggedRevs::getTagLevels( $tag );
					# If a level was removed, default to the highest...
					$flags[$tag] = min( $value, count( $levels ) - 1 );
				}
			}
		}
		return $flags;
	}

	/**
	 * Get flags for a revision
	 * @param array $tags
	 * @return string
	 */
	public static function flattenRevisionTags( array $tags ) {
		$flags = '';
		foreach ( $tags as $tag => $value ) {
			# Add only currently recognized ones
			if ( FlaggedRevs::getTagLevels( $tag ) ) {
				$flags .= $tag . ':' . intval( $value ) . "\n";
			}
		}
		return $flags;
	}
}
