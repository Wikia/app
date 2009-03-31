<?php
if (!defined('MEDIAWIKI')) die();

class CodeRevision {
	public static function newFromSvn( CodeRepository $repo, $data ) {
		$rev = new CodeRevision();
		$rev->mRepoId = $repo->getId();
		$rev->mRepo = $repo;
		$rev->mId = intval($data['rev']);
		$rev->mAuthor = $data['author'];
		$rev->mTimestamp = wfTimestamp( TS_MW, strtotime( $data['date'] ) );
		$rev->mMessage = rtrim( $data['msg'] );
		$rev->mPaths = $data['paths'];
		$rev->mStatus = 'new';

		$common = null;
		if( $rev->mPaths ) {
			if (count($rev->mPaths) == 1)
				$common = $rev->mPaths[0]['path'];
			else {
				$first = array_shift( $rev->mPaths );

				$common = explode( '/', $first['path'] );

				foreach( $rev->mPaths as $path ) {
					$compare = explode( '/', $path['path'] );

					// make sure $common is the shortest path
					if ( count($compare) < count($common) )
						list( $compare, $common ) = array( $common, $compare );

					$tmp = array();
					foreach ( $common as $k => $v )
						if ( $v==$compare[$k] ) $tmp[]= $v;
						else break;
					$common = $tmp;
				}
				$common = implode( '/', $common);

				array_unshift( $rev->mPaths, $first );
			}
		}
		$rev->mCommonPath = $common;
		return $rev;
	}

	public static function newFromRow( CodeRepository $repo, $row ) {
		$rev = new CodeRevision();
		$rev->mRepoId = intval($row->cr_repo_id);
		if( $rev->mRepoId != $repo->getId() ) {
			throw new MWException( "Invalid repo ID in " . __METHOD__ );
		}
		$rev->mRepo = $repo;
		$rev->mId = intval($row->cr_id);
		$rev->mAuthor = $row->cr_author;
		$rev->mTimestamp = wfTimestamp( TS_MW, $row->cr_timestamp );
		$rev->mMessage = $row->cr_message;
		$rev->mStatus = $row->cr_status;
		$rev->mCommonPath = $row->cr_path;
		return $rev;
	}

	public function getId() {
		return intval( $this->mId );
	}
	
	public function getRepoId() {
		return intval( $this->mRepoId );
	}

	public function getAuthor() {
		return $this->mAuthor;
	}
	
	public function getWikiUser() {
		return $this->mRepo->authorWikiUser( $this->getAuthor() );
	}

	public function getTimestamp() {
		return $this->mTimestamp;
	}

	public function getMessage() {
		return $this->mMessage;
	}
	
	public function getStatus() {
		return $this->mStatus;
	}

	public function getCommonPath() {
		return $this->mCommonPath;
	}
	
	public static function getPossibleStates() {
		return array( 'new', 'fixme', 'reverted', 'resolved', 'ok', 'deferred' );
	}
	
	public function isValidStatus( $status ) {
		return in_array( $status, self::getPossibleStates(), true );
	}
	
	public function setStatus( $status, $user ) {
		if( !$this->isValidStatus( $status ) ) {
			throw new MWException( "Tried to save invalid code revision status" );
		}
		// Get the old status from the master
		$dbw = wfGetDB( DB_MASTER );
		$oldStatus = $dbw->selectField( 'code_rev',
			'cr_status',
			array( 'cr_repo_id' => $this->mRepoId, 'cr_id' => $this->mId ),
			__METHOD__
		);
		if( $oldStatus === $status ) {
			return false; // nothing to do here
		}
		// Update status
		$this->mStatus = $status;
		$dbw->update( 'code_rev',
			array( 'cr_status' => $status ),
			array(
				'cr_repo_id' => $this->mRepoId,
				'cr_id' => $this->mId ),
			__METHOD__
		);
		// Log this change
		if( $user && $user->getId() ) {
			$dbw->insert( 'code_prop_changes',
				array( 
					'cpc_repo_id'   => $this->getRepoId(),
					'cpc_rev_id'    => $this->getId(),
					'cpc_attrib'    => 'status',
					'cpc_removed'   => $oldStatus,
					'cpc_added'     => $status,
					'cpc_timestamp' => $dbw->timestamp(),
					'cpc_user'      => $user->getId(),
					'cpc_user_text' => $user->getName()
				),
				__METHOD__
			);
		}
		return true;
	}

	public function save() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		
		$dbw->insert( 'code_rev',
			array(
				'cr_repo_id' => $this->mRepoId,
				'cr_id' => $this->mId,
				'cr_author' => $this->mAuthor,
				'cr_timestamp' => $dbw->timestamp( $this->mTimestamp ),
				'cr_message' => $this->mMessage,
				'cr_status' => $this->mStatus,
				'cr_path' => $this->mCommonPath ),
			__METHOD__,
			array( 'IGNORE' ) );
		// Already exists? Update the row!
		if( !$dbw->affectedRows() ) {
			$dbw->update( 'code_rev',
				array(
					'cr_author' => $this->mAuthor,
					'cr_timestamp' => $dbw->timestamp( $this->mTimestamp ),
					'cr_message' => $this->mMessage,
					'cr_path' => $this->mCommonPath ), 
				array(
					'cr_repo_id' => $this->mRepoId,
					'cr_id' => $this->mId ),
				__METHOD__ );
		}
		// Update path tracking used for output and searching
		if( $this->mPaths ) {
			$data = array();
			foreach( $this->mPaths as $path ) {
				$data[] = array(
					'cp_repo_id' => $this->mRepoId,
					'cp_rev_id' => $this->mId,
					'cp_path' => $path['path'],
					'cp_action' => $path['action'] );
			}
			$dbw->insert( 'code_paths',
				$data,
				__METHOD__,
				array( 'IGNORE' ) );
		}

		$dbw->commit();
	}

	public function getModifiedPaths() {
		$dbr = wfGetDB( DB_SLAVE );
		return $dbr->select(
			'code_paths',
			array( 'cp_path', 'cp_action' ),
			array( 'cp_repo_id' => $this->mRepoId, 'cp_rev_id' => $this->mId ),
			__METHOD__
		);
	}
	
	public function isDiffable() {
		$paths = $this->getModifiedPaths();
		if( !$paths->numRows() || $paths->numRows() > 20 ) {
			return false; // things need to get done this year
		}
		return true;
	}

	public function previewComment( $text, $review, $parent=null ) {
		$data = $this->commentData( $text, $review, $parent );
		$data['cc_id'] = null;
		return CodeComment::newFromData( $this, $data );
	}
	
	public function saveComment( $text, $review, $parent=null ) {
		global $wgUser;
		if( !strlen($text) ) {
			return 0;
		}
		$dbw = wfGetDB( DB_MASTER );
		$data = $this->commentData( $text, $review, $parent );

		$dbw->begin();
		$data['cc_id'] = $dbw->nextSequenceValue( 'code_comment_cc_id' );
		$dbw->insert( 'code_comment', $data, __METHOD__ );
		$commentId = $dbw->insertId();
		$dbw->commit();

		// Give email notices to committer and commenters
		global $wgCodeReviewENotif, $wgEnableEmail;
		if( $wgCodeReviewENotif && $wgEnableEmail ) {
			// Make list of users to send emails to
			$users = $this->getCommentingUsers();
			if( $user = $this->getWikiUser() ) {
				$users[$user->getId()] = $user;
			}
			// Get repo and build comment title (for url)
			$title = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName().'/'.$this->mId );
			$title->setFragment( "#c{$commentId}" );
			$url = $title->getFullUrl();
			foreach( $users as $userId => $user ) {
				// No sense in notifying this commenter
				if( $wgUser->getId() == $user->getId() ) {
					continue;
				}
				// Send message in receiver's language
				$lang = array( 'language' => $user->getOption( 'language' ) );
				if( $user->canReceiveEmail() ) {
					$user->sendMail(
						wfMsgExt( 'codereview-email-subj', $lang, $this->mRepo->getName(), $this->mId ),
						wfMsgExt( 'codereview-email-body', $lang, $wgUser->getName(), $url, $this->mId, $text )
					);
				}
			}
		}
		
		return $commentId;
	}
	
	protected function commentData( $text, $review, $parent=null ) {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$ts = wfTimestamp( TS_MW );
		$sortkey = $this->threadedSortkey( $parent, $ts );
		return array(
			'cc_repo_id' => $this->mRepoId,
			'cc_rev_id' => $this->mId,
			'cc_text' => $text,
			'cc_parent' => $parent,
			'cc_user' => $wgUser->getId(),
			'cc_user_text' => $wgUser->getName(),
			'cc_timestamp' => $dbw->timestamp( $ts ),
			'cc_review' => $review,
			'cc_sortkey' => $sortkey );
	}

	protected function threadedSortKey( $parent, $ts ) {
		if( $parent ) {
			// We construct a threaded sort key by concatenating the timestamps
			// of all our parent comments
			$dbw = wfGetDB( DB_MASTER );
			$parentKey = $dbw->selectField( 'code_comment',
				'cc_sortkey',
				array( 'cc_id' => $parent ),
				__METHOD__ );
			if( $parentKey ) {
				return $parentKey . ',' . $ts;
			} else {
				// hmmmm
				throw new MWException( 'Invalid parent submission' );
			}
		} else {
			return $ts;
		}
	}

	public function getComments() {
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'code_comment',
			array(
				'cc_id',
				'cc_text',
				'cc_parent',
				'cc_user',
				'cc_user_text',
				'cc_timestamp',
				'cc_review',
				'cc_sortkey' ),
			array(
				'cc_repo_id' => $this->mRepoId,
				'cc_rev_id' => $this->mId ),
			__METHOD__,
			array(
				'ORDER BY' => 'cc_sortkey' )
		);
		$comments = array();
		foreach( $result as $row ) {
			$comments[] = CodeComment::newFromRow( $this, $row );
		}
		$result->free();
		return $comments;
	}
	
	public function getPropChanges() {
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( array('code_prop_changes','user'),
			array(
				'cpc_attrib',
				'cpc_removed',
				'cpc_added',
				'cpc_timestamp',
				'cpc_user',
				'cpc_user_text',
				'user_name'
			), array(
				'cpc_repo_id' => $this->mRepoId,
				'cpc_rev_id' => $this->mId,
			),
			__METHOD__,
			array( 'ORDER BY' => 'cpc_timestamp DESC' ),
			array( 'user' => array('LEFT JOIN','cpc_user = user_id') )
		);
		$changes = array();
		foreach( $result as $row ) {
			$changes[] = CodePropChange::newFromRow( $this, $row );
		}
		$result->free();
		return $changes;
	}
	
	protected function getCommentingUsers() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'code_comment',
			'DISTINCT(cc_user)',
			array(
				'cc_repo_id' => $this->mRepoId,
				'cc_rev_id' => $this->mId,
				'cc_user != 0' // users only
			),
			__METHOD__ 
		);
		$users = array();
		while( $row = $res->fetchObject() ) {
			$users[$row->cc_user] = User::newFromId( $row->cc_user );
		}
		return $users;
	}
	
	public function getTags( $from = DB_SLAVE ) {
		$db = wfGetDB( $from );
		$result = $db->select( 'code_tags',
			array( 'ct_tag' ),
			array(
				'ct_repo_id' => $this->mRepoId,
				'ct_rev_id' => $this->mId ),
			__METHOD__ );
		
		$tags = array();
		foreach( $result as $row ) {
			$tags[] = $row->ct_tag;
		}
		return $tags;
	}
	
	public function changeTags( $addTags, $removeTags, $user = NULL ) {
		// Get the current tags and see what changes
		$tagsNow = $this->getTags( DB_MASTER );
		// Normalize our input tags
		$addTags = $this->normalizeTags( $addTags );
		$removeTags = $this->normalizeTags( $removeTags );
		$addTags = array_diff( $addTags, $tagsNow );
		$removeTags = array_intersect( $removeTags, $tagsNow );
		// Do the queries
		$dbw = wfGetDB( DB_MASTER );
		if( $addTags ) {
			$dbw->insert( 'code_tags',
				$this->tagData( $addTags ),
				__METHOD__,
				array( 'IGNORE' )
			);
		}
		if( $removeTags ) {
			$dbw->delete( 'code_tags',
				array( 
					'ct_repo_id' => $this->mRepoId,
					'ct_rev_id'  => $this->mId,
					'ct_tag'     => $removeTags ),
				__METHOD__
			);
		}
		// Log this change
		if( ($removeTags || $addTags) && $user && $user->getId() ) {
			$dbw->insert( 'code_prop_changes',
				array( 
					'cpc_repo_id'   => $this->getRepoId(),
					'cpc_rev_id'    => $this->getId(),
					'cpc_attrib'    => 'tags',
					'cpc_removed'   => implode(',',$removeTags),
					'cpc_added'     => implode(',',$addTags),
					'cpc_timestamp' => $dbw->timestamp(),
					'cpc_user'      => $user->getId(),
					'cpc_user_text' => $user->getName()
				),
				__METHOD__
			);
		}
	}
	
	protected function normalizeTags( $tags ) {
		$out = array();
		foreach( $tags as $tag ) {
			$out[] = $this->normalizeTag( $tag );
		}
		return $out;
	}
	
	protected function tagData( $tags ) {
		$data = array();
		foreach( $tags as $tag ) {
			$data[] = array(
				'ct_repo_id' => $this->mRepoId,
				'ct_rev_id'  => $this->mId,
				'ct_tag'     => $this->normalizeTag( $tag ) );
		}
		return $data;
	}
	
	public function normalizeTag( $tag ) {
		global $wgContLang;
		$lower = $wgContLang->lc( $tag );
		
		$title = Title::newFromText( $tag );
		if( $title && $lower === $wgContLang->lc( $title->getPrefixedText() ) ) {
			return $lower;
		} else {
			return false;
		}
	}
	
	public function isValidTag( $tag ) {
		return ($this->normalizeTag( $tag ) !== false );
	}
	
	public function getPrevious() {
		// hack!
		if( $this->mId > 1 ) {
			return $this->mId - 1;
		} else {
			return false;
		}
	}
	
	public function getNext() {
		$dbr = wfGetDB( DB_SLAVE );
		$encId = $dbr->addQuotes( $this->mId );
		$row = $dbr->selectRow( 'code_rev',
			'cr_id',
			array(
				'cr_repo_id' => $this->mRepoId,
				"cr_id > $encId" ),
			__METHOD__,
			array(
				'ORDER BY' => 'cr_repo_id, cr_id',
				'LIMIT' => 1 ) );
		
		if( $row ) {
			return intval($row->cr_id);
		} else {
			return false;
		}
	}
	
	public function getNextUnresolved() {
		$dbr = wfGetDB( DB_SLAVE );
		$encId = $dbr->addQuotes( $this->mId );
		$row = $dbr->selectRow( 'code_rev',
			'cr_id',
			array(
				'cr_repo_id' => $this->mRepoId,
				"cr_id > $encId",
				'cr_status' => array('new','fixme') ),
			__METHOD__,
			array(
				'ORDER BY' => 'cr_repo_id, cr_id',
				'LIMIT' => 1 )
		);
		if( $row ) {
			return intval($row->cr_id);
		} else {
			return false;
		}
	}
}
