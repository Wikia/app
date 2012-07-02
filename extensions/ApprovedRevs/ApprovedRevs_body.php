<?php

/**
 * Main class for the Approved Revs extension.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Yaron Koren
 */
class ApprovedRevs {

	// Static arrays to prevent querying the database more than necessary.
	static $mApprovedContentForPage = array();
	static $mApprovedRevIDForPage = array();
	static $mUserCanApprove = null;
	
	/**
	 * Gets the approved revision ID for this page, or null if there isn't
	 * one.
	 */
	public static function getApprovedRevID( $title ) {
		$pageID = $title->getArticleID();
		if ( array_key_exists( $pageID, self::$mApprovedRevIDForPage ) ) {
			return self::$mApprovedRevIDForPage[$pageID];
		}

		if ( ! self::pageIsApprovable( $title ) ) {
			return null;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$revID = $dbr->selectField( 'approved_revs', 'rev_id', array( 'page_id' => $pageID ) );
		self::$mApprovedRevIDForPage[$pageID] = $revID;
		return $revID;
	}

	/**
	 * Returns whether or not this page has a revision ID.
	 */
	public static function hasApprovedRevision( $title ) {
		$revision_id = self::getApprovedRevID( $title );
		return ( ! empty( $revision_id ) );
	}

	/**
	 * Returns the content of the approved revision of this page, or null
	 * if there isn't one.
	 */
	public static function getApprovedContent( $title ) {
		$pageID = $title->getArticleID();
		if ( array_key_exists( $pageID, self::$mApprovedContentForPage ) ) {
			return self::$mApprovedContentForPage[$pageID];
		}

		$revision_id = self::getApprovedRevID( $title );
		if ( empty( $revision_id ) ) {
			return null;
		}
		$article = new Article( $title, $revision_id );
		$text = $article->getContent();
		self::$mApprovedContentForPage[$pageID] = $text;
		return $text;
	}

	/**
	 * Helper function - returns whether the user is currently requesting
	 * a page via the simple URL for it - not specfying a version number,
	 * not editing the page, etc.
	 */
	public static function isDefaultPageRequest() {
		// this first test seems to no longer work with MW 1.16
		/*
		if ( $title->mArticleID > -1 ) {
			return true;
		}
		*/
		global $wgRequest;
		if ( $wgRequest->getCheck( 'oldid' ) ) {
			return false;
		}
		// check if it's an action other than viewing
		global $wgRequest;
		if ( $wgRequest->getCheck( 'action' ) &&
			$wgRequest->getVal( 'action' ) != 'view' &&
			$wgRequest->getVal( 'action' ) != 'purge' &&
			$wgRequest->getVal( 'action' ) != 'render' ) {
				return false;
		}
		return true;
	}

	/**
	 * Returns whether this page can be approved - either because it's in
	 * a supported namespace, or because it's been specially marked as
	 * approvable. Also stores the boolean answer as a field in the page
	 * object, to speed up processing if it's called more than once.
	 */
	public static function pageIsApprovable( Title $title ) {
		// if this function was already called for this page, the
		// value should have been stored as a field in the $title object
		if ( isset( $title->isApprovable ) ) {
			return $title->isApprovable;
		}

		if ( !$title->exists() ) {
			$title->isApprovable = false;
			return $title->isApprovable;			
		}
		
		// check the namespace
		global $egApprovedRevsNamespaces;
		if ( in_array( $title->getNamespace(), $egApprovedRevsNamespaces ) ) {
			$title->isApprovable = true;
			return $title->isApprovable;
		}

		// it's not in an included namespace, so check for the page
		// property - for some reason, calling the standard
		// getProperty() function doesn't work, so we just do a DB
		// query on the page_props table
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page_props', 'COUNT(*)',
			array(
				'pp_page' => $title->getArticleID(),
				'pp_propname' => 'approvedrevs',
				'pp_value' => 'y'
			)
		);
		$row = $dbr->fetchRow( $res );
		$isApprovable = ( $row[0] == '1' );
		$title->isApprovable = $isApprovable;
		return $isApprovable;
	}

	public static function userCanApprove( $title ) {
		global $egApprovedRevsSelfOwnedNamespaces;

		// $mUserCanApprove is a static variable used for
		// "caching" the result of this function, so that
		// it only has to be called once.
		if ( self::$mUserCanApprove ) {
			return true;
		} elseif ( self::$mUserCanApprove === false ) {
			return false;
		} elseif ( $title->userCan( 'approverevisions' ) ) {
			self::$mUserCanApprove = true;
			return true;
		} else {
			// If the user doesn't have the 'approverevisions'
			// permission, they still might be able to approve
			// revisions - it depends on whether the current
			// namespace is within the admin-defined
			// $egApprovedRevsSelfOwnedNamespaces array.
			global $wgUser;
			$namespace = $title->getNamespace();
			if ( in_array( $namespace, $egApprovedRevsSelfOwnedNamespaces ) ) {
				if ( $namespace == NS_USER ) {
					// If the page is in the 'User:'
					// namespace, this user can approve
					// revisions if it's their user page.
					if ( $title->getText() == $wgUser->getName() ) {
						self::$mUserCanApprove = true;
						return true;
					}
				} else {
					// Otherwise, they can approve revisions
					// if they created the page.
					// We get that information via a SQL
					// query - is there an easier way?
					$dbr = wfGetDB( DB_SLAVE );
					$row = $dbr->selectRow(
						array( 'revision', 'page' ),
						'revision.rev_user_text',
						array( 'page.page_title' => $title->getDBkey() ),
						null,
						array( 'ORDER BY' => 'revision.rev_id ASC' ),
						array( 'revision' => array( 'JOIN', 'revision.rev_page = page.page_id' ) )
					);
					if ( $row->rev_user_text == $wgUser->getName() ) {
						self::$mUserCanApprove = true;
						return true;
					}
				}
			}
		}
		self::$mUserCanApprove = false;
		return false;
	}

	public static function saveApprovedRevIDInDB( $title, $rev_id ) {
		$dbr = wfGetDB( DB_MASTER );
		$page_id = $title->getArticleID();
		$old_rev_id = $dbr->selectField( 'approved_revs', 'rev_id', array( 'page_id' => $page_id ) );
		if ( $old_rev_id ) {
			$dbr->update( 'approved_revs', array( 'rev_id' => $rev_id ), array( 'page_id' => $page_id ) );
		} else {
			$dbr->insert( 'approved_revs', array( 'page_id' => $page_id, 'rev_id' => $rev_id ) );
		}
	}

	/**
	 * Sets a certain revision as the approved one for this page in the
	 * approved_revs DB table; calls a "links update" on this revision
	 * so that category information can be stored correctly, as well as
	 * info for extensions such as Semantic MediaWiki; and logs the action.
	 */
	public static function setApprovedRevID( $title, $rev_id, $is_latest = false ) {
		self::saveApprovedRevIDInDB( $title, $rev_id );
		$parser = new Parser();

		// If the revision being approved is definitely the latest
		// one, there's no need to call the parser on it.
		if ( !$is_latest ) {
			$parser->setTitle( $title );
			$article = new Article( $title, $rev_id );
			$text = $article->getContent();
			$options = new ParserOptions();
			$parser->parse( $text, $title, $options, true, true, $rev_id );
			$u = new LinksUpdate( $title, $parser->getOutput() );
			$u->doUpdate();
		}

		$log = new LogPage( 'approval' );
		$rev_url = $title->getFullURL( array( 'old_id' => $rev_id ) );
		$rev_link = Xml::element(
			'a',
			array( 'href' => $rev_url ),
			$rev_id
		);
		$logParams = array( $rev_link );
		$log->addEntry(
			'approve',
			$title,
			'',
			$logParams
		);

		wfRunHooks( 'ApprovedRevsRevisionApproved', array( $parser, $title, $rev_id ) );
	}

	public static function deleteRevisionApproval( $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$page_id = $title->getArticleID();
		$dbr->delete( 'approved_revs', array( 'page_id' => $page_id ) );
	}

	/**
	 * Unsets the approved revision for this page in the approved_revs DB
	 * table; calls a "links update" on this page so that category
	 * information can be stored correctly, as well as info for
	 * extensions such as Semantic MediaWiki; and logs the action.
	 */
	public static function unsetApproval( $title ) {
		global $egApprovedRevsBlankIfUnapproved;

		self::deleteRevisionApproval( $title );

		$parser = new Parser();
		$parser->setTitle( $title );
		if ( $egApprovedRevsBlankIfUnapproved ) {
			$text = '';
		} else {
			$article = new Article( $title );
			$text = $article->getContent();
		}
		$options = new ParserOptions();
		$parser->parse( $text, $title, $options );
		$u = new LinksUpdate( $title, $parser->getOutput() );
		$u->doUpdate();

		$log = new LogPage( 'approval' );
		$log->addEntry(
			'unapprove',
			$title,
			''
		);

		wfRunHooks( 'ApprovedRevsRevisionUnapproved', array( $parser, $title ) );
	}

	public static function addCSS() {
		global $wgOut, $egApprovedRevsScriptPath;
		$link = array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => "screen",
			'href' => "$egApprovedRevsScriptPath/ApprovedRevs.css"
		);
		$wgOut->addLink( $link );
	}
}
