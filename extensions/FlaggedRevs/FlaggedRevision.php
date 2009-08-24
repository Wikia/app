<?php

class FlaggedRevision {
	private $mTitle = null;
	private $mRevId, $mPageId;
	private $mTimestamp;
	private $mComment;
	private $mQuality;
	private $mTags;
	private $mText = null;
	private $mFlags;
	private $mUser;
	private $mRevision;
	private $mFileName, $mFileSha1, $mFileTimestamp;

	/**
	 * @param Row $row (from database)
	 */
	public function __construct( $row ) {
		if( is_object($row) ) {
			$this->mRevId = intval( $row->fr_rev_id );
			$this->mPageId = intval( $row->fr_page_id );
			$this->mTimestamp = $row->fr_timestamp;
			$this->mComment = $row->fr_comment;
			$this->mQuality = intval( $row->fr_quality );
			$this->mTags = self::expandRevisionTags( strval($row->fr_tags) );
			# Image page revision relevant params
			$this->mFileName = $row->fr_img_name ? $row->fr_img_name : null;
			$this->mFileSha1 = $row->fr_img_sha1 ? $row->fr_img_sha1 : null;
			$this->mFileTimestamp = $row->fr_img_timestamp ? $row->fr_img_timestamp : null;
			$this->mUser = intval( $row->fr_user );
			# Optional fields
			$this->mTitle = isset($row->page_namespace) && isset($row->page_title) ?
				Title::makeTitleSafe( $row->page_namespace, $row->page_title ) : null;
			$this->mFlags = isset($row->fr_flags) ? explode(',',$row->fr_flags) : null;
		} else if( is_array($row) ) {
			$this->mRevId = intval( $row['fr_rev_id'] );
			$this->mPageId = intval( $row['fr_page_id'] );
			$this->mTimestamp = $row['fr_timestamp'];
			$this->mComment = $row['fr_comment'];
			$this->mQuality = intval( $row['fr_quality'] );
			$this->mTags = self::expandRevisionTags( strval($row['fr_tags']) );
			# Image page revision relevant params
			$this->mFileName = $row['fr_img_name'] ? $row['fr_img_name'] : null;
			$this->mFileSha1 = $row['fr_img_sha1'] ? $row['fr_img_sha1'] : null;
			$this->mFileTimestamp = $row['fr_img_timestamp'] ? $row['fr_img_timestamp'] : null;
			$this->mUser = intval( $row['fr_user'] );
			# Optional fields
			$this->mFlags = isset($row['fr_flags']) ? explode(',',$row['fr_flags']) : null;
		} else {
			throw new MWException( 'FlaggedRevision constructor passed invalid row format.' );
		}
	}
	
	/**
	 * @param Title $title
	 * @param int $revId
	 * @param int $flags
	 * @returns mixed FlaggedRevision (null on failure)
	 * Will not return a revision if deleted
	 */
	public static function newFromTitle( $title, $revId, $flags = 0 ) {
		$columns = self::selectFields();
		# If we want the text, then get the text flags too
		if( $flags & FR_TEXT ) {
			$columns += self::selectTextFields();
		}
		$options = array();
		# User master/slave as appropriate
		if( $flags & FR_FOR_UPDATE || $flags & FR_MASTER ) {
			$db = wfGetDB( DB_MASTER );
			if( $flags & FR_FOR_UPDATE )
				$options[] = 'FOR UPDATE';
		} else {
			$db = wfGetDB( DB_SLAVE );
		}
		$pageId = $title->getArticleID( $flags & FR_FOR_UPDATE ? GAID_FOR_UPDATE : 0 );
		# Short-circuit query
		if( !$pageId ) {
			return null;
		}
		# Skip deleted revisions
		$row = $db->selectRow( array('flaggedrevs','revision'),
			$columns,
			array( 'fr_page_id' => $pageId,
				'fr_rev_id' => $revId,
				'rev_id = fr_rev_id',
				'rev_page = fr_page_id',
				'rev_deleted & '.Revision::DELETED_TEXT => 0 ),
			__METHOD__,
			$options
		);
		# Sorted from highest to lowest, so just take the first one if any
		if( $row ) {
			$frev = new FlaggedRevision( $row );
			$frev->mTitle = $title;
			return $frev;
		}
		return null;
	}
	
	/**
	 * Get latest quality rev, if not, the latest reviewed one.
	 * @param Title $title, page title
	 * @param int $flags
	 * @returns mixed FlaggedRevision (null on failure)
	 */
	public static function newFromStable( Title $title, $flags = 0 ) {
		$columns = self::selectFields();
		# If we want the text, then get the text flags too
		if( $flags & FR_TEXT ) {
			$columns += self::selectTextFields();
		}
		$options = array();
		# Short-circuit query
		$pageId = $title->getArticleID( $flags & FR_FOR_UPDATE ? GAID_FOR_UPDATE : 0 );
		# Short-circuit query
		if( !$pageId ) {
			return null;
		}
		# User master/slave as appropriate
		if( !($flags & FR_FOR_UPDATE) && !($flags & FR_MASTER) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow( array('flaggedpages','flaggedrevs'),
				$columns,
				array( 'fp_page_id' => $pageId,
					'fr_page_id = fp_page_id',
					'fr_rev_id = fp_stable' ),
				__METHOD__
			);
			if( !$row ) return null;
		} else {
			global $wgFlaggedRevsReviewForDefault;
			$row = null;
			# Get visiblity settings...
			$config = FlaggedRevs::getPageVisibilitySettings( $title, true );
			if( !$config['override'] && $wgFlaggedRevsReviewForDefault ) {
				return $row; // page is not reviewable; no stable version
			}
			$dbw = wfGetDB( DB_MASTER );
			$options['ORDER BY'] = 'fr_rev_id DESC';
			if( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
			# Look for the latest pristine revision...
			if( FlaggedRevs::pristineVersions() && $config['select'] != FLAGGED_VIS_LATEST ) {
				$prow = $dbw->selectRow( array('flaggedrevs','revision'),
					$columns,
					array( 'fr_page_id' => $pageId,
						'fr_quality = 2',
						'rev_id = fr_rev_id',
						'rev_page = fr_page_id',
						'rev_deleted & '.Revision::DELETED_TEXT => 0 ),
					__METHOD__,
					$options
				);
				# Looks like a plausible revision
				$row = $prow ? $prow : $row;
			}
			if( $row && $config['select'] == FLAGGED_VIS_PRISTINE ) {
				// we have what we want already
			# Look for the latest quality revision...
			} else if( FlaggedRevs::qualityVersions() && $config['select'] != FLAGGED_VIS_LATEST ) {
				// If we found a pristine rev above, this one must be newer...
				$newerClause = $row ? "fr_rev_id > {$row->fr_rev_id}" : "1 = 1";
				$qrow = $dbw->selectRow( array('flaggedrevs','revision'),
					$columns,
					array( 'fr_page_id' => $pageId,
						'fr_quality = 1',
						$newerClause,
						'rev_id = fr_rev_id',
						'rev_page = fr_page_id',
						'rev_deleted & '.Revision::DELETED_TEXT => 0 ),
					__METHOD__,
					$options
				);
				$row = $qrow ? $qrow : $row;
			}
			# Do we have one? If not, try the latest reviewed revision...
			if( !$row ) {
				$row = $dbw->selectRow( array('flaggedrevs','revision'),
					$columns,
					array( 'fr_page_id' => $pageId,
						'rev_id = fr_rev_id',
						'rev_page = fr_page_id',
						'rev_deleted & '.Revision::DELETED_TEXT => 0 ),
					__METHOD__,
					$options
				);
				if( !$row ) return null;
			}
		}
		$frev = new FlaggedRevision( $row );
		$frev->mTitle = $title;
		return $frev;
	}
	
	/*
	* Insert a FlaggedRevision object into the database
	*
	* @param array $tmpRows template version rows
	* @param array $fileRows file version rows
	* @param bool $auto autopatrolled
	* @return bool success
	*/
	public function insertOn( $tmpRows, $fileRows, $auto = false ) {
		$textFlags = 'dynamic';
		if( $auto ) $textFlags .= ',auto';
		$this->mFlags = explode(',',$textFlags);
		$dbw = wfGetDB( DB_MASTER );
		# Our review entry
		$revRow = array(
			'fr_page_id'       => $this->getPage(),
			'fr_rev_id'	       => $this->getRevId(),
			'fr_user'	       => $this->getUser(),
			'fr_timestamp'     => $dbw->timestamp( $this->getTimestamp() ),
			'fr_comment'       => $this->getComment(),
			'fr_quality'       => $this->getQuality(),
			'fr_tags'	       => self::flattenRevisionTags( $this->getTags() ),
			'fr_text'	       => '', # not used anymore
			'fr_flags'	       => $textFlags,
			'fr_img_name'      => $this->getFileName(),
			'fr_img_timestamp' => $this->getFileTimestamp(),
			'fr_img_sha1'      => $this->getFileSha1()
		);
		# Update flagged revisions table
		$dbw->replace( 'flaggedrevs', array( array('fr_page_id','fr_rev_id') ), $revRow, __METHOD__ );
		# Clear out any previous garbage.
		# We want to be able to use this for tracking...
		$dbw->delete( 'flaggedtemplates', array( 'ft_rev_id' => $this->getRevId() ), __METHOD__ );
		$dbw->delete( 'flaggedimages', array( 'fi_rev_id' => $this->getRevId() ), __METHOD__ );
		# Update our versioning params
		if( !empty($tmpRows) ) {
			$dbw->insert( 'flaggedtemplates', $tmpRows, __METHOD__, 'IGNORE' );
		}
		if( !empty($fileRows) ) {
			$dbw->insert( 'flaggedimages', $fileRows, __METHOD__, 'IGNORE' );
		}
		return true;
	}
	
	/**
	 * @returns Array basic select fields (not including text/text flags)
	 */
	public static function selectFields() {
		return array('fr_rev_id','fr_page_id','fr_user','fr_timestamp','fr_comment','fr_quality',
			'fr_tags','fr_img_name', 'fr_img_sha1', 'fr_img_timestamp');
	}
	
	/**
	 * @returns Array text select fields (text/text flags)
	 */
	public static function selectTextFields() {
		return array('fr_flags');
	}

	/**
	 * @returns Integer revision ID
	 */
	public function getRevId() {
		return $this->mRevId;
	}
	
	/**
	 * @returns Title title
	 */
	public function getTitle() {
		if( is_null($this->mTitle) ) {
			$this->mTitle = Title::newFromId( $this->mPageId );
		}
		return $this->mTitle;
	}

	/**
	 * @returns Integer page ID
	 */
	public function getPage() {
		return $this->mPageId;
	}

	/**
	 * Get timestamp of review
	 * @returns String revision timestamp in MW format
	 */
	public function getTimestamp() {
		return wfTimestamp( TS_MW, $this->mTimestamp );
	}
	
	/**
	 * Get the corresponding revision
	 * @returns Revision
	 */
	public function getRevision() {
		if( !is_null($this->mRevision) )
			return $this->mRevision;
		# Get corresponding revision
		$rev = Revision::newFromId( $this->mRevId );
		# Save to cache
		$this->mRevision = $rev ? $rev : false;
		return $this->mRevision;
	}
	
	/**
	 * Get timestamp of the corresponding revision
	 * @returns String revision timestamp in MW format
	 */
	public function getRevTimestamp() {
		# Get corresponding revision
		$rev = $this->getRevision();
		$timestamp = $rev ? $rev->getTimestamp() : "0";
		return $timestamp;
	}

	/**
	 * @returns String review comment
	 */
	public function getComment() {
		return $this->mComment;
	}
	
	/**
	 * @returns Integer the user ID of the reviewer
	 */
	public function getUser() {
		return $this->mUser;
	}

	/**
	 * @returns Integer revision timestamp in MW format
	 */
	public function getQuality() {
		return $this->mQuality;
	}

	/**
	 * @returns Array tag metadata
	 */
	public function getTags() {
		return $this->mTags;
	}
	
	/**
	 * @returns string, filename accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileName() {
		return $this->mFileName;
	}
	
	/**
	 * @returns string, sha1 key accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileSha1() {
		return $this->mFileSha1;
	}
	
	/**
	 * @returns string, timestamp accosciated with this revision.
	 * This returns NULL for non-image page revisions.
	 */
	public function getFileTimestamp() {
		return $this->mFileTimestamp;
	}
	
	/**
	 * @returns bool
	 */
	public function userCanSetFlags() {
		return RevisionReview::userCanSetFlags( $this->mTags );
	}
	
	/**
	 * @returns Array template versions (ns -> dbKey -> rev id)
	 */	
	public function getTemplateVersions() {
		$templates = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'flaggedtemplates', '*', array('ft_rev_id' => $this->getRevId()), __METHOD__ );
		while( $row = $res->fetchObject() ) {
			if( !isset($templates[$row->ft_namespace]) ) {
				$templates[$row->ft_namespace] = array();
			}
			$templates[$row->ft_namespace][$row->ft_title] = $row->ft_tmp_rev_id;
		}
		return $templates;
	}
	
	/**
	 * @returns Array template versions (dbKey -> sha1)
	 */	
	public function getFileVersions() {
		$files = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'flaggedimages', '*', array('fi_rev_id' => $this->getRevId()), __METHOD__ );
		while( $row = $res->fetchObject() ) {
			$files[$row->fi_name] = $row->fi_img_sha1;
		}
		return $files;
	}
	
	/**
	 * Get text of the corresponding revision
	 * @returns mixed (string/false) revision timestamp in MW format
	 */
	public function getRevText() {
		# Get corresponding revision
		$rev = $this->getRevision();
		$text = $rev ? $rev->getText() : false;
		return $text;
	}
	
	/**
	 * Get flags for a revision
	 * @param string $tags
	 * @return Array
	*/
	public static function expandRevisionTags( $tags ) {
		# Set all flags to zero
		$flags = array();
		foreach( FlaggedRevs::getDimensions() as $tag => $levels ) {
			$flags[$tag] = 0;
		}
		$tags = str_replace('\n',"\n",$tags); // B/C, old broken rows
		$tags = explode("\n",$tags);
		foreach( $tags as $tuple ) {
			$set = explode(':',$tuple,2);
			if( count($set) == 2 ) {
				list($tag,$value) = $set;
				$value = intval($value);
				# Add only currently recognized ones
				if( isset($flags[$tag]) ) {
					# If a level was removed, default to the highest
					$flags[$tag] = $value < count($levels) ? $value : count($levels)-1;
				}
			}
		}
		return $flags;
	}

	/**
	 * Get flags for a revision
	 * @param Array $tags
	 * @return string
	*/
	public static function flattenRevisionTags( $tags ) {
		$flags = '';
		foreach( $tags as $tag => $value ) {
			# Add only currently recognized ones
			if( FlaggedRevs::getTagLevels($tag) ) {
				$flags .= $tag . ':' . intval($value) . "\n";
			}
		}
		return $flags;
	}
}
