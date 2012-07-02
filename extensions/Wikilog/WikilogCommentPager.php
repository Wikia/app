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
 * Common wikilog comment pager interface.
 * @since Wikilog v1.1.0.
 */
abstract class WikilogCommentPager
	extends IndexPager
{
	/// Wikilog comment query data.
	protected $mQuery = null;

	/// Wikilog comment formatter.
	protected $mFormatter = null;

	/// If the pager is being included.
	protected $mIncluding = false;

	/// If displaying comments for a single article.
	protected $mSingleItem = false;

	/// Trigger for displaying a reply comment form.
	protected $mReplyTrigger = null;
	protected $mReplyCallback = null;

	/**
	 * Constructor.
	 * @param $query WikilogCommentQuery  Query object, containing the
	 *   parameters that will select which comments will be shown.
	 * @param $formatter WikilogCommentFormatter  Comment formatter object.
	 * @param $including boolean  Whether the listing is being included in
	 *   another page.
	 */
	function __construct( WikilogCommentQuery $query, $formatter = null,
			$including = false )
	{
		global $wgUser, $wgParser;
		global $wgWikilogNumComments, $wgWikilogExpensiveLimit;

		# WikilogCommentQuery object drives our queries.
		$this->mQuery = $query;
		$this->mIncluding = $including;

		# Prepare the comment formatter.
		$this->mFormatter = $formatter ? $formatter :
			new WikilogCommentFormatter( $this->getSkin() );

		# Parent constructor.
		parent::__construct();

		# Fix our limits, Pager's defaults are too high.
		$this->mDefaultLimit = $wgWikilogNumComments;
		list( $this->mLimit, /* $offset */ ) =
			$this->mRequest->getLimitOffset( $wgWikilogNumComments, '' );

		# This is too expensive, limit listing.
		if ( $this->mLimit > $wgWikilogExpensiveLimit )
			$this->mLimit = $wgWikilogExpensiveLimit;
	}

	/**
	 * Set the comment formatter.
	 * @param $formatter Comment formatter object.
	 * @return WikilogCommentFormatter Previous value.
	 */
	public function setFormatter( WikilogCommentFormatter $formatter ) {
		return wfSetVar( $this->mFormatter, $formatter );
	}

	/**
	 * Set the reply trigger. This makes getBody() function to call back
	 * the given function $callback when the comment $id is displayed.
	 * This is used to inject a reply comment form after the comment.
	 *
	 * @param $id integer  Comment ID that will trigger the callback.
	 * @param $callback callback  Callback function, receives the comment
	 *   as argument and should return an HTML fragment.
	 */
	public function setReplyTrigger( $id, $callback = null ) {
		$this->mReplyTrigger = $id;
		$this->mReplyCallback = $callback;
	}

	function getQueryInfo() {
		return $this->mQuery->getQueryInfo( $this->mDb );
	}

	function getDefaultQuery() {
		return parent::getDefaultQuery();
	}

	function doQuery() {
		# If displaying comments for a single item, save the item.
		# Otherwise, set query option to return items along with their
		# comments.
		if ( ( $item = $this->mQuery->getItem() ) ) {
			$this->mSingleItem = $item;
		} else {
			$this->mQuery->setOption( 'include-item' );
		}
		return parent::doQuery();
	}

	function getStartBody() {
		return Xml::openElement( 'div', array( 'class' => 'wl-threads' ) );
	}

	function getEndBody() {
		return Xml::closeElement( 'div' ); // wl-threads
	}

	function getEmptyBody() {
		return WikilogUtils::wrapDiv( 'wl-empty', wfMsgExt( 'wikilog-pager-empty', array( 'parsemag' ) ) );
	}

	function getNavigationBar() {
		if ( !$this->isNavigationBarShown() ) return '';
		if ( !isset( $this->mNavigationBar ) ) {
			$navbar = new WikilogNavbar( $this );
			$this->mNavigationBar = $navbar->getNavigationBar( $this->mLimit );
		}
		return $this->mNavigationBar;
	}
}

/**
 * Comment list pager.
 *
 * Lists wikilog comments in list format. If there are more comments than
 * some threshold, navigation links are used to visit other pages of comments.
 */
class WikilogCommentListPager
	extends WikilogCommentPager
{
	public $mDefaultDirection = true;

	/**
	 * Constructor.
	 * @param $query WikilogCommentQuery  Query object, containing the
	 *   parameters that will select which comments will be shown.
	 * @param $formatter WikilogCommentFormatter  Comment formatter object.
	 * @param $including boolean  Whether the listing is being included in
	 *   another page.
	 */
	function __construct( WikilogCommentQuery $query, $formatter = null,
			$including = false )
	{
		parent::__construct( $query, $formatter, $including );
	}

	function getIndexField() {
		return 'wlc_timestamp';
	}

	function formatRow( $row ) {
		# Retrieve comment data.
		$item = $this->mSingleItem ? $this->mSingleItem : WikilogItem::newFromRow( $row );
		$comment = WikilogComment::newFromRow( $item, $row );
		$comment->loadText();
		return $this->mFormatter->formatComment( $comment );
	}
}

/**
 * Comment thread pager.
 *
 * Lists wikilog comments in thread format. If there are more comments than
 * some threshold, navigation links are used to visit other pages of comments.
 * The thread pager also supports injecting a reply form below any comment.
 */
class WikilogCommentThreadPager
	extends WikilogCommentPager
{
	/**
	 * Constructor.
	 * @param $query WikilogCommentQuery  Query object, containing the
	 *   parameters that will select which comments will be shown.
	 * @param $formatter WikilogCommentFormatter  Comment formatter object.
	 * @param $including boolean  Whether the listing is being included in
	 *   another page.
	 */
	function __construct( WikilogCommentQuery $query, $formatter = false,
			$including = false )
	{
		parent::__construct( $query, $formatter, $including );
	}

	function getIndexField() {
		return 'wlc_thread';
	}

	function getEndBody() {
		return $this->mFormatter->closeCommentThreads() . parent::getEndBody();
	}

	public function formatRow( $row ) {
		# Retrieve comment data.
		$item = $this->mSingleItem ? $this->mSingleItem : WikilogItem::newFromRow( $row );
		$comment = WikilogComment::newFromRow( $item, $row );
		$comment->loadText();

		$doReply = $this->mReplyTrigger && $comment->mID == $this->mReplyTrigger;

		$html = $this->mFormatter->startCommentThread( $comment );
		$html .= $this->mFormatter->formatComment( $comment, $doReply );

		if ( $doReply && is_callable( $this->mReplyCallback ) ) {
			if ( ( $res = call_user_func( $this->mReplyCallback, $comment ) ) ) {
				$html .= WikilogUtils::wrapDiv( 'wl-indent', $res );
			}
		}
		return $html;
	}
}
