<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * Wikilog article comment database entry.
 */
class WikilogComment
{
	/**
	 * Comment statuses.
	 */
	const S_OK				= 'OK';			///< Comment is published.
	const S_PENDING			= 'PENDING';	///< Comment is pending moderation.
	const S_DELETED			= 'DELETED';	///< Comment was removed.

	/**
	 * Mapping of comment statuses to readable messages. System messages are
	 * "wikilog-comment-{$statusMap[$status]}", except when false (for S_OK).
	 */
	public static $statusMap = array(
		self::S_OK				=> false,
		self::S_PENDING			=> 'pending',
		self::S_DELETED			=> 'deleted',
	);

	/**
	 * Wikilog article item this comment is associated to.
	 */
	public  $mItem			= null;

	/**
	 * General data about the comment.
	 */
	public  $mID			= null;		///< Comment ID.
	public  $mParent		= null;		///< Parent comment ID.
	public  $mThread		= null;		///< Comment thread.
	public  $mUserID		= null;		///< Comment author user id.
	public  $mUserText		= null;		///< Comment author user name.
	public  $mAnonName		= null;		///< Comment anonymous author name.
	public  $mStatus		= null;		///< Comment status.
	public  $mTimestamp		= null;		///< Date the comment was published.
	public  $mUpdated		= null;		///< Date the comment was last updated.
	public  $mCommentPage	= null;		///< Comment page id.
	public  $mCommentTitle  = null;		///< Comment page title.
	public  $mCommentRev	= null;		///< Comment revision id.
	public  $mText			= null;		///< Comment text.

	/**
	 * Whether the text was changed, and thus a database update is required.
	 */
	private $mTextChanged	= false;

	/**
	 * Constructor.
	 */
	public function __construct( WikilogItem &$item ) {
		$this->mItem = $item;
	}

	/**
	 * Returns the wikilog comment id.
	 */
	public function getID() {
		return $this->mID;
	}

	/**
	 * Set the author of the comment to the given (authenticated) user.
	 *
	 * This function can also be used when $user->getId() == 0
	 * (i.e. anonymous). In this case, a call to $this->setAnon() should
	 * follow, in order to set the anonymous name.
	 */
	public function setUser( $user ) {
		$this->mUserID = $user->getId();
		$this->mUserText = $user->getName();
		$this->mAnonName = null;
	}

	/**
	 * Set the anonymous (i.e. not logged in) author name.
	 */
	public function setAnon( $name ) {
		$this->mAnonName = $name;
	}

	/**
	 * Returns the wikitext of the comment.
	 */
	public function getText() {
		return $this->mText;
	}

	/**
	 * Changes the wikitext of the comment.
	 */
	public function setText( $text ) {
		$this->mText = $text;
		$this->mTextChanged = true;
	}

	/**
	 * Returns whether the comment is visible (not pending or deleted).
	 */
	public function isVisible() {
		return $this->mStatus == self::S_OK;
	}

	/**
	 * Returns whether the comment text is changed (DB update required).
	 */
	public function isTextChanged() {
		return $this->mTextChanged;
	}

	/**
	 * Load current revision of comment wikitext.
	 */
	public function loadText() {
		$dbr = wfGetDB( DB_SLAVE );
		$rev = Revision::loadFromId( $dbr, $this->mCommentRev );
		if ( $rev ) {
			$this->mText = $rev->getText();
			$this->mTextChanged = false;
		}
	}

	/**
	 * Saves comment data in the database.
	 */
	public function saveComment() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		$data = array(
			'wlc_parent'    => $this->mParent,
			'wlc_post'      => $this->mItem->getID(),
			'wlc_user'      => $this->mUserID,
			'wlc_user_text' => $this->mUserText,
			'wlc_anon_name' => $this->mAnonName,
			'wlc_status'    => $this->mStatus,
			'wlc_timestamp' => $dbw->timestamp( $this->mTimestamp ),
			'wlc_updated'   => $dbw->timestamp( $this->mUpdated )
		);

		$delayed = array();

		# Main update.
		if ( $this->mID ) {
			$dbw->update( 'wikilog_comments', $data,
				array( 'wlc_id' => $this->mID ), __METHOD__ );
		} else {
			$cid = $dbw->nextSequenceValue( 'wikilog_comments_wlc_id' );
			$data = array( 'wlc_id' => $cid ) + $data;
			$dbw->insert( 'wikilog_comments', $data, __METHOD__ );
			$this->mID = $dbw->insertId();

			# Now that we have an ID, we can generate the thread.
			$this->mThread = self::getThreadHistory( $this->mID, $this->mParent );
			$delayed['wlc_thread'] = implode( '/', $this->mThread );
		}

		# Save article with comment text.
		if ( $this->mTextChanged ) {
			$this->mCommentTitle = $this->getCommentArticleTitle();
			$art = new Article( $this->mCommentTitle );
			$art->doEdit( $this->mText, $this->getAutoSummary() );
			$this->mTextChanged = false;

			$this->mCommentPage = $art->getID();
			$delayed['wlc_comment_page'] = $this->mCommentPage;
		}

		# Delayed updates.
		if ( !empty( $delayed ) ) {
			$dbw->update( 'wikilog_comments', $delayed,
				array( 'wlc_id' => $this->mID ), __METHOD__ );
		}

		# Update number of comments
		$this->mItem->updateNumComments( true );

		# Commit
		$dbw->commit();

		# Invalidate some caches.
		$this->mCommentTitle->invalidateCache();
		$this->mItem->mTitle->invalidateCache();
		$this->mItem->mTitle->getTalkPage()->invalidateCache();
		$this->mItem->mParentTitle->invalidateCache();
	}

	/**
	 * Deletes comment data from the database.
	 */
	public function deleteComment() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		$dbw->delete( 'wikilog_comments', array( 'wlc_id' => $this->mID ), __METHOD__ );
		$this->mItem->updateNumComments( true );

		$dbw->commit();

		$this->mItem->mTitle->invalidateCache();
		$this->mItem->mTitle->getTalkPage()->invalidateCache();
		$this->mItem->mParentTitle->invalidateCache();
		$this->mID = null;
	}

	/**
	 * Returns comment article title.
	 */
	public function getCommentArticleTitle() {
		if ( $this->mCommentTitle ) {
			return $this->mCommentTitle;
		} elseif ( $this->mCommentPage ) {
			return Title::newFromID( $this->mCommentPage, Title::GAID_FOR_UPDATE );
		} else {
			$it = $this->mItem->mTitle;
			return Title::makeTitle(
				MWNamespace::getTalk( $it->getNamespace() ),
				$it->getText() . '/c' . self::padID( $this->mID )
			);
		}
	}

	/**
	 * Returns automatic summary (for recent changes) for the posted comment.
	 */
	public function getAutoSummary() {
		global $wgContLang;
		$user = $this->mUserID ? $this->mUserText : $this->mAnonName;
		$summ = $wgContLang->truncate( str_replace( "\n", ' ', $this->mText ),
			max( 0, 200 - strlen( wfMsgForContent( 'wikilog-comment-autosumm' ) ) ),
			'...' );
		return wfMsgForContent( 'wikilog-comment-autosumm', $user, $summ );
	}

	/**
	 * Returns the discussion history for a given comment. This is used to
	 * populate the $comment->mThread of a new comment whose id is @a $id
	 * and parent is @a $parent.
	 *
	 * @param $id Comment id of the new comment.
	 * @param $parent Comment id of its parent.
	 * @return Array of ids from the history since the first comment until
	 *   the given one.
	 */
	public static function getThreadHistory( $id, $parent ) {
		$thread = array();

		if ( $parent ) {
			$dbr = wfGetDB( DB_SLAVE );
			$thread = $dbr->selectField(
				'wikilog_comments',
				'wlc_thread',
				array( 'wlc_id' => intval( $parent ) ),
				__METHOD__
			);
			if ( $thread !== false ) {
				$thread = explode( '/', $thread );
			} else {
				throw new MWException( 'Invalid parent history.' );
			}
		}

		$thread[] = self::padID( $id );
		return $thread;
	}

	/**
	 * Formats the id of a comment as a string, padding it with zeros if
	 * necessary.
	 */
	public static function padID( $id ) {
		return str_pad( intval( $id ), 6, '0', STR_PAD_LEFT );
	}

	/**
	 * Creates a new comment object from a database row.
	 * @param $row Row from database.
	 * @return New WikilogComment object.
	 */
	public static function newFromRow( &$item, $row ) {
		$comment = new WikilogComment( $item );
		$comment->mID           = intval( $row->wlc_id );
		$comment->mParent       = intval( $row->wlc_parent );
		$comment->mThread       = explode( '/', $row->wlc_thread );
		$comment->mUserID       = intval( $row->wlc_user );
		$comment->mUserText     = strval( $row->wlc_user_text );
		$comment->mAnonName     = strval( $row->wlc_anon_name );
		$comment->mStatus       = strval( $row->wlc_status );
		$comment->mTimestamp    = wfTimestamp( TS_MW, $row->wlc_timestamp );
		$comment->mUpdated      = wfTimestamp( TS_MW, $row->wlc_updated );
		$comment->mCommentPage  = $row->wlc_comment_page;

		# This information may not be available for deleted comments.
		if ( $row->wlc_page_title && $row->wlc_page_latest ) {
			$comment->mCommentTitle = Title::makeTitle( $row->wlc_page_namespace, $row->wlc_page_title );
			$comment->mCommentRev = $row->wlc_page_latest;
		}
		return $comment;
	}

	/**
	 * Creates a new comment object for a new comment, given the text and
	 * the parent comment.
	 * @param $item Wikilog article object this is a comment for.
	 * @param $text Comment wikitext as a string.
	 * @param $parent Parent comment id.
	 * @return New WikilogComment object.
	 */
	public static function newFromText( &$item, $text, $parent = null ) {
		$ts = wfTimestamp( TS_MW );
		$comment = new WikilogComment( $item );
		$comment->mParent    = $parent;
		$comment->mStatus    = self::S_OK;
		$comment->mTimestamp = $ts;
		$comment->mUpdated   = $ts;
		$comment->setText( $text );
		return $comment;
	}

	/**
	 * Creates a new comment object from an existing comment id.
	 * Data is fetched from the database.
	 * @param $item Wikilog article item.
	 * @param $id Comment id.
	 * @return New WikilogComment object, or NULL if comment doesn't exist.
	 */
	public static function newFromID( &$item, $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$row = self::loadFromID( $dbr, $id );
		if ( $row ) {
			return self::newFromRow( $item, $row );
		}
		return null;
	}

	/**
	 * Creates a new comment object from an existing comment page id.
	 * Data is fetched from the database.
	 * @param $item Wikilog article item.
	 * @param $pageid Comment page id.
	 * @return New WikilogComment object, or NULL if comment doesn't exist.
	 */
	public static function newFromPageID( &$item, $pageid ) {
		$dbr = wfGetDB( DB_SLAVE );
		$row = self::loadFromPageID( $dbr, $pageid );
		if ( $row && $row->wlc_post == $item->getID() ) {
			return self::newFromRow( $item, $row );
		}
		return null;
	}

	/**
	 * Load information about a comment from the database given a set of
	 * conditions.
	 * @param $dbr Database connection object.
	 * @param $conds Conditions.
	 * @return Database row, or false.
	 */
	private static function loadFromConds( $dbr, $conds ) {
		$tables = self::selectTables( $dbr );
		$fields = self::selectFields();
		$row = $dbr->selectRow(
			$tables['tables'],
			$fields,
			$conds,
			__METHOD__,
			array(),
			$tables['join_conds']
		);
		return $row;
	}

	/**
	 * Load information about a comment from the database given a set a
	 * comment id.
	 * @param $dbr Database connection object.
	 * @param $id Comment id.
	 * @return Database row, or false.
	 */
	private static function loadFromID( $dbr, $id ) {
		return self::loadFromConds( $dbr, array( 'wlc_id' => $id ) );
	}

	/**
	 * Load information about a comment from the database given a set of
	 * conditions.
	 * @param $dbr Database connection object.
	 * @param $pageid Comment page id.
	 * @return Database row, or false.
	 */
	private static function loadFromPageID( $dbr, $pageid ) {
		return self::loadFromConds( $dbr, array( 'wlc_comment_page' => $pageid ) );
	}

	/**
	 * Fetch all comments given a set of conditions.
	 * @param $dbr Database connection object.
	 * @param $conds Query conditions.
	 * @param $options Query options.
	 * @return Database query result object.
	 */
	private static function fetchFromConds( $dbr, $conds, $options = array() ) {
		$tables = self::selectTables( $dbr );
		$fields = self::selectFields();
		$result = $dbr->select(
			$tables['tables'],
			$fields,
			$conds,
			__METHOD__,
			$options,
			$tables['join_conds']
		);
		return $result;
	}

	/**
	 * Fetch all comments given a wikilog article item.
	 * @param $dbr Database connection object.
	 * @param $itemid Wikilog article item id.
	 * @return Database query result object.
	 */
	public static function fetchAllFromItem( $dbr, $itemid ) {
		return self::fetchFromConds( $dbr,
			array( 'wlc_post' => $itemid ),
			array( 'ORDER BY' => 'wlc_thread, wlc_id' )
		);
	}

	/**
	 * Fetch all comments given a wikilog article item and a thread.
	 * @param $dbr Database connection object.
	 * @param $itemid Wikilog article item id.
	 * @param $thread Thread description (array of comment ids).
	 * @return Database query result object.
	 */
	public static function fetchAllFromItemThread( $dbr, $itemid, $thread ) {
		if ( is_array( $thread ) ) {
			$thread = implode( '/', $thread );
		}
		return self::fetchFromConds( $dbr,
			array( 'wlc_post' => $itemid, "wlc_thread " . $dbr->buildLike( $thread . '/', $dbr->anyString() ) ),
			array( 'ORDER BY' => 'wlc_thread, wlc_id' )
		);
	}

	/**
	 * Return the list of database tables required to create a new instance
	 * of WikilogComment.
	 */
	public static function selectTables( $dbr = null ) {
		if ( !$dbr ) $dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		return array(
			'tables' => array(
				'wikilog_comments',
				"{$page} AS c"
			),
			'join_conds' => array(
				"{$page} AS c" => array( 'LEFT JOIN', 'c.page_id = wlc_comment_page' )
			)
		);
	}

	/**
	 * Return the list of post fields required to create a new instance of
	 * WikilogComment.
	 */
	public static function selectFields() {
		return array(
			'wlc_id',
			'wlc_parent',
			'wlc_thread',
			'wlc_post',
			'wlc_user',
			'wlc_user_text',
			'wlc_anon_name',
			'wlc_status',
			'wlc_timestamp',
			'wlc_updated',
			'wlc_comment_page',
			'c.page_namespace AS wlc_page_namespace',
			'c.page_title AS wlc_page_title',
			'c.page_latest AS wlc_page_latest'
		);
	}
}

/**
 * Comment formatter.
 * @since Wikilog v1.1.0.
 */
class WikilogCommentFormatter
{
	protected $mSkin;               ///< Skin used when rendering comments.
	protected $mAllowReplies;       ///< Whether to show reply links.
	protected $mAllowModeration;    ///< User is allowed to moderate.
	protected $mPermalinkTitle;     ///< Optional title used for permalinks.

	/// Whether to show the item title.
	protected $mShowItem = false;

	/// Comment stack for thread formatting.
	protected $mThreadStack = array();
	protected $mThreadRoot = array();

	/**
	 * Constructor.
	 *
	 * @param $title Title of the page.
	 * @param $wi WikilogInfo object with information about the wikilog and
	 *   the item.
	 */
	public function __construct( $skin = false, $allowReplies = false ) {
		global $wgUser;
		$this->mSkin = $skin ? $skin : $wgUser->getSkin();
		$this->mAllowReplies = $allowReplies;
		$this->mAllowModeration = $wgUser->isAllowed( 'wl-moderation' );
	}

	/**
	 * Set page title used for permanent links. If not set, permalinks point
	 * to their own comment page.
	 *
	 * @param $title Title object to use for permalinks.
	 */
	public function setPermalinkTitle( $title = null ) {
		return wfSetVar( $this->mPermalinkTitle, $title );
	}

	/**
	 * Set whether the item the comment is about is to be printed.
	 */
	public function setShowItem( $value = true ) {
		return wfSetVar( $this->mShowItem, $value );
	}

	/**
	 * Format a single comment in HTML.
	 *
	 * @param $comment Comment to be formatted.
	 * @param $highlight Whether the comment should be highlighted.
	 * @return Generated HTML.
	 */
	public function formatComment( $comment, $highlight = false ) {
		global $wgUser, $wgOut;

		$hidden = WikilogComment::$statusMap[ $comment->mStatus ];

		# div class.
		$divclass = array( 'wl-comment' );
		if ( !$comment->isVisible() ) {
			$divclass[] = "wl-comment-{$hidden}";
		}
		if ( $comment->mUserID ) {
			$divclass[] = 'wl-comment-by-user';
			if ( isset( $comment->mItem->mAuthors[$comment->mUserText] ) ) {
				$divclass[] = 'wl-comment-by-author';
			}
		} else {
			$divclass[] = 'wl-comment-by-anon';
		}

		# If user is has moderator privileges and the comment is pending
		# approval, highlight it.
		if ( $this->mAllowModeration && $comment->mStatus == WikilogComment::S_PENDING ) {
			$highlight = true;
		}

		if ( !$comment->isVisible() && !$this->mAllowModeration ) {
			# Placeholder.
			$status = wfMsg( "wikilog-comment-{$hidden}" );
			$html = WikilogUtils::wrapDiv( 'wl-comment-placeholder', $status );
		} else {
			# The comment.
			$params = $this->getCommentMsgParams( $comment );
			$html = $this->formatCommentHeader( $comment, $params );

			if ( $comment->mID && $comment->mCommentRev ) {
				list( $article, $parserOutput ) = WikilogUtils::parsedArticle( $comment->mCommentTitle );
				$text = $parserOutput->getText();
			} else {
				$text = $comment->getText();
			}

			if ( $text ) {
				$html .= WikilogUtils::wrapDiv( 'wl-comment-text', $text );
			}

			$html .= $this->formatCommentFooter( $comment, $params );
			$html .= $this->getCommentToolLinks( $comment );
		}

		# Enclose everything in a div.
		if ( $highlight ) {
			$divclass[] = 'wl-comment-highlight';
		}
		return Xml::tags( 'div', array(
			'class' => implode( ' ', $divclass ),
			'id' => ( $comment->mID ? "c{$comment->mID}" : 'cpreview' )
		), $html );
	}

	/**
	 * Format and return the header of a comment. This processes the
	 * 'wikilog-comment-header' system message with the given parameters,
	 * possibly adds some status messages (for pending or deleted posts),
	 * and returns the result.
	 *
	 * @param $comment Comment.
	 * @param $params Message parameters, from getCommentMsgParams().
	 * @return HTML-formatted comment header.
	 */
	public function formatCommentHeader( $comment, $params ) {
		$status = "";
		if ( !$comment->isVisible() ) {
			# If comment is not visible to non-moderators, make note of it.
			$hidden = WikilogComment::$statusMap[ $comment->mStatus ];
			$status = WikilogUtils::wrapDiv( 'wl-comment-status', wfMsg( "wikilog-comment-{$hidden}" ) );
		}

		$header = wfMsgExt( 'wikilog-comment-header', array( 'content', 'parsemag', 'replaceafter' ), $params );
		if ( $header ) {
			$header = WikilogUtils::wrapDiv( 'wl-comment-header', $header );
		}

		return $status . $header;
	}

	/**
	 * Format and return the footer of a comment. This processes the
	 * 'wikilog-comment-footer' system message with the given parameters
	 * and returns the result.
	 *
	 * @param $comment Comment.
	 * @param $params Message parameters, from getCommentMsgParams().
	 * @return HTML-formatted comment footer.
	 */
	public function formatCommentFooter( $comment, $params ) {
		$footer = wfMsgExt( 'wikilog-comment-footer', array( 'content', 'parsemag', 'replaceafter' ), $params );
		if ( $footer ) {
			return WikilogUtils::wrapDiv( 'wl-comment-footer', $footer );
		} else {
			return "";
		}
	}

	/**
	 * Returns an array with common header and footer system message
	 * parameters that are used in 'wikilog-comment-header' and
	 * 'wikilog-comment-footer'.
	 *
	 * Note: *Content* language should be used for everything but final
	 * strings (like tooltips). These messages are intended to be customized
	 * by the wiki admin, and we don't want to require changing it for the
	 * 300+ languages suported by MediaWiki.
	 *
	 * Parameters should be HTML-formated. They are substituded using
	 * 'replaceafter' parameter to wfMsgExt().
	 *
	 * @param $comment Comment.
	 * @return Array with message parameters.
	 */
	public function getCommentMsgParams( $comment ) {
		global $wgContLang;

		if ( $comment->mUserID ) {
			$authorPlain = htmlspecialchars( $comment->mUserText );
			$authorFmt = wfMsgExt( 'wikilog-simple-signature',
				array( 'content', 'parseinline', 'replaceafter' ),
				Xml::wrapClass( $this->mSkin->userLink( $comment->mUserID, $comment->mUserText ), 'wl-comment-author' ),
				$this->mSkin->userTalkLink( $comment->mUserID, $comment->mUserText ),
				$comment->mUserText
			);
		} else {
			$authorPlain = htmlspecialchars( $comment->mAnonName );
			$authorFmt = wfMsgForContent( 'wikilog-comment-anonsig',
				Xml::wrapClass( $this->mSkin->userLink( $comment->mUserID, $comment->mUserText ), 'wl-comment-author' ),
				$this->mSkin->userTalkLink( $comment->mUserID, $comment->mUserText ),
				htmlspecialchars( $comment->mAnonName )
			);
		}

		list( $date, $time, $tz ) = WikilogUtils::getLocalDateTime( $comment->mTimestamp );
		$permalink = $this->getCommentPermalink( $comment, $date, $time, $tz );

		$extra = array();
		if ( $this->mShowItem && $comment->mItem ) {
			# Display item title.
			$extra[] = wfMsgForContent( 'wikilog-comment-note-item',
				$this->mSkin->link( $comment->mItem->mTitle, $comment->mItem->mName )
			);
		}
		if ( $comment->mID && $comment->mCommentTitle &&
				$comment->mCommentTitle->exists() )
		{
			if ( $comment->mUpdated != $comment->mTimestamp ) {
				# Comment was edited.
				list( $updDate, $updTime, $updTz ) = WikilogUtils::getLocalDateTime( $comment->mUpdated );
				$extra[] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsgForContent( 'wikilog-comment-note-edited', $updDate, $updTime, $updTz ),
					array( 'title' => wfMsg( 'wikilog-comment-history' ) ),
					array( 'action' => 'history' ), 'known'
				);
			}
		}
		if ( $extra ) {
			$extra = wfMsgForContent( 'parentheses', $wgContLang->pipeList( $extra ) );
		} else {
			$extra = "";
		}

		return array(
			/* $1  */ $authorPlain,
			/* $2  */ $authorFmt,
			/* $3  */ $date,
			/* $4  */ $time,
			/* $5  */ $permalink,
			/* $6  */ $extra
		);
	}

	/**
	 * Define the root thread used to align replies formatted with
	 * startCommentThread() and closeCommentThreads(). This prevents
	 * omitted comment placeholders to be displayed when listing replies
	 * of another comment.
	 *
	 * When in this state, all calls to startCommentThread() MUST be
	 * to comments below the root thread. The thread stack stays in this
	 * state until closeCommentThreads() is called.
	 *
	 * @param $thread Root comment thread that will affect future calls
	 *   to startCommentThread().
	 */
	public function setupRootThread( $thread ) {
		$this->mThreadStack = $this->mThreadRoot = $thread;
	}

	/**
	 * Start a new comment thread. Should be called before formatComment()
	 * when formatting comments in threads. Comments must be displayed in
	 * correct thread sequence when using this function, which means that
	 * the 'wlc_thread' column should be used to sort the query results from
	 * the 'wikilog_comments' table. After the last comment,
	 * closeCommentThreads() must be called.
	 *
	 * @param $comment Comment to be formatted.
	 * @return Generated HTML.
	 */
	public function startCommentThread( $comment ) {
		$top = count( $this->mThreadStack );
		$thread = count( $comment->mThread );

		# Find common ancestors.
		$common = min( $top, $thread );
		for ( $i = 0; $i < $common; $i++ ) {
			if ( $this->mThreadStack[$i] != $comment->mThread[$i] )
				break;
		}

		# Close previous threads.
		$html = str_repeat( "</div>", $top - $i );
		array_splice( $this->mThreadStack, $i );

		# Create omitted comment thread(s).
		for ( ; $i < $thread-1; $i++ ) {
			$msg = wfMsgExt( 'wikilog-comment-omitted-x', array( 'parseinline' ), $comment->mThread[$i] );
			$msg = WikilogUtils::wrapDiv( 'wl-comment-placeholder', $msg );
			$msg = WikilogUtils::wrapDiv( 'wl-comment wl-comment-omitted', $msg );
			$html .= '<div class="wl-thread">' . $msg;
			array_push( $this->mThreadStack, $comment->mThread[$i] );
		}

		# Open the new comment thread.
		$html .= '<div class="wl-thread">';
		array_push( $this->mThreadStack, $comment->mThread[$i] );
		return $html;
	}

	/**
	 * Close all open comment threads.
	 * @return Generated HTML.
	 */
	public function closeCommentThreads() {
		$open = count( $this->mThreadStack ) - count( $this->mThreadRoot );
		$this->mThreadStack = $this->mThreadRoot = array();
		return str_repeat( "</div>", $open );
	}

	/**
	 * Return a permanent link to the comment.
	 *
	 * @param $comment Comment.
	 * @param $date Comment date.
	 * @param $time Comment time.
	 * @param $tz Comment timezone information.
	 * @return HTML fragment.
	 */
	protected function getCommentPermalink( $comment, $date, $time, $tz ) {
		if ( $comment->mID ) {
			if ( $this->mPermalinkTitle ) {
				$title = $this->mPermalinkTitle;
				$title->setFragment( "#c{$comment->mID}" );
			} else {
				$title = $comment->mCommentTitle;
			}
			return $this->mSkin->link( $title,
				wfMsg( 'wikilog-comment-permalink', $date, $time, $tz ),
				array( 'title' => wfMsg( 'permalink' ) )
			);
		} else {
			return wfMsg( 'wikilog-comment-permalink', $date, $time, $tz );
		}
	}

	/**
	 * Return an HTML fragment with various links (tools) that act upon
	 * the comment, like reply, accept, reject, edit, etc.
	 *
	 * @param $comment Comment.
	 * @return HTML fragment containing the links.
	 */
	protected function getCommentToolLinks( $comment ) {
		global $wgUser, $wgRequest;
		$tools = array();

		if ( $comment->mID && $comment->mCommentTitle &&
				$comment->mCommentTitle->exists() ) {
			if ( $this->mAllowReplies && $comment->isVisible() ) {
				$tools['reply'] = Xml::tags( 'a',
					array(
						'title' => wfMsg( 'wikilog-reply-to-comment' ),
						'href' => $wgRequest->appendQueryValue( 'wlParent', $comment->mID )
					),
					wfMsg( 'wikilog-reply-lc' )
				);
			}
			if ( $this->mAllowModeration && $comment->mStatus == WikilogComment::S_PENDING ) {
				$token = $wgUser->editToken();
				$tools['approve'] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsg( 'wikilog-approve-lc' ),
					array( 'title' => wfMsg( 'wikilog-comment-approve' ) ),
					array(
						'action' => 'wikilog',
						'wlActionCommentApprove' => 'approve',
						'wpEditToken' => $token
					),
					'known'
				);
				$tools['reject'] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsg( 'wikilog-reject-lc' ),
					array( 'title' => wfMsg( 'wikilog-comment-reject' ) ),
					array(
						'action' => 'wikilog',
						'wlActionCommentApprove' => 'reject',
						'wpEditToken' => $token
					),
					'known'
				);
			}
			if ( $this->mAllowModeration ) {
				$tools['page'] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsg( 'wikilog-page-lc' ),
					array( 'title' => wfMsg( 'wikilog-comment-page' ) ),
					array(),
					'known'
				);
			}
			if ( $comment->mCommentTitle->quickUserCan( 'edit' ) ) {
				$tools['edit'] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsg( 'wikilog-edit-lc' ),
					array( 'title' => wfMsg( 'wikilog-comment-edit' ) ),
					array( 'action' => 'edit' ),
					'known'
				);
			}
			if ( $comment->mCommentTitle->quickUserCan( 'delete' ) ) {
				$tools['delete'] = $this->mSkin->link( $comment->mCommentTitle,
					wfMsg( 'wikilog-delete-lc' ),
					array( 'title' => wfMsg( 'wikilog-comment-delete' ) ),
					array( 'action' => 'delete' ),
					'known'
				);
			}
		}

		if ( $tools ) {
			$html = '';
			foreach ( $tools as $cls => $tool ) {
				$html .= Xml::tags( 'li', array( 'class' => "wl-comment-action-{$cls}" ), $tool );
			}
			return Xml::tags( 'ul', array( 'class' => 'wl-comment-tools' ), $html );
		} else {
			return '';
		}
	}
}
