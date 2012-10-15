<?php
/**
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

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once ( "ApiBase.php" );
}

/**
 * This action returns LiquidThreads threads/posts in RSS/Atom formats.
 *
 * @ingroup API
 */
class ApiFeedLQTThreads extends ApiBase {
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	/**
	 * This module uses a custom feed wrapper printer.
	 * @return ApiFormatFeedWrapper
	 */
	public function getCustomPrinter() {
		return new ApiFormatFeedWrapper( $this->getMain() );
	}

	/**
	 * Make a nested call to the API to request items in the last $hours.
	 * Wrap the result as an RSS/Atom feed.
	 */
	public function execute() {
		global $wgFeedClasses;

		$params = $this->extractRequestParams();

		$db = wfGetDB( DB_SLAVE );

		$feedTitle = self::createFeedTitle( $params );
		$feedClass = $wgFeedClasses[$params['feedformat']];
		$feedItems = array();

		$feedUrl = Title::newMainPage()->getFullURL();

		$tables = array( 'thread' );
		$fields = array( $db->tableName( 'thread' ) . ".*" );
		$conds = $this->getConditions( $params, $db );
		$options = array( 'LIMIT' => 200, 'ORDER BY' => 'thread_created DESC' );

		$res = $db->select( $tables, $fields, $conds, __METHOD__, $options );

		foreach ( $res as $row ) {
			$feedItems[] = $this->createFeedItem( $row );
		}

		$feed = new $feedClass( $feedTitle, '', $feedUrl );

		ApiFormatFeedWrapper :: setResult( $this->getResult(), $feed, $feedItems );
	}

	private function createFeedItem( $row ) {
		global $wgOut;
		$thread = Thread::newFromRow( $row );
		$linker = new Linker;

		$titleStr = $thread->subject();
		$completeText = $thread->root()->getContent();
		$completeText = $wgOut->parse( $completeText );
		$threadTitle = clone $thread->topmostThread()->title();
		$threadTitle->setFragment( '#' . $thread->getAnchorName() );
		$titleUrl = $threadTitle->getFullURL();
		$timestamp = $thread->created();
		$user = $thread->author()->getName();

		// Grab the title for the superthread, if one exists.
		$stTitle = null;
		if ( $thread->hasSuperThread() ) {
			$stTitle = clone $thread->topmostThread()->title();
			$stTitle->setFragment( '#' . $thread->superthread()->getAnchorName() );
		}

		// Prefix content with a quick description
		$userLink = $linker->userLink( $thread->author()->getId(), $user );
		$talkpageLink = $linker->link( $thread->getTitle() );
		$superthreadLink = $linker->link( $stTitle );
		$description = wfMsgExt(
			$thread->hasSuperThread()
				? 'lqt-feed-reply-intro'
				: 'lqt-feed-new-thread-intro',
			array( 'parse', 'replaceafter' ),
			array( $talkpageLink, $userLink, $superthreadLink )
		);
		$completeText = $description . $completeText;

		return new FeedItem( $titleStr, $completeText, $titleUrl, $timestamp, $user );
	}

	public static function createFeedTitle( $params ) {
		$fromPlaces = array();

		foreach ( (array)$params['thread'] as $thread ) {
			$t = Title::newFromText( $thread );
			$fromPlaces[] = $t->getPrefixedText();
		}

		foreach ( (array)$params['talkpage'] as $talkpage ) {
			$t = Title::newFromText( $talkpage );
			$fromPlaces[] = $t->getPrefixedText();
		}

		global $wgLang;
		$fromCount = count( $fromPlaces );
		$fromPlaces = $wgLang->commaList( $fromPlaces );

		// What's included?
		$types = (array)$params['type'];

		if ( !count( array_diff( array( 'replies', 'newthreads' ), $types ) ) ) {
			$msg = 'lqt-feed-title-all';
		} elseif ( in_array( 'replies', $types ) ) {
			$msg = 'lqt-feed-title-replies';
		} elseif ( in_array( 'newthreads', $types ) ) {
			$msg = 'lqt-feed-title-new-threads';
		} else {
			throw new MWException( "Unable to determine appropriate display type" );
		}

		if ( $fromCount ) {
			$msg .= '-from';
		}

		return wfMsgExt( $msg, array( 'parsemag' ), $fromPlaces, $fromCount );
	}

	/**
	 * @param $params array
	 * @param $db DatabaseBase
	 * @return array
	 */
	function getConditions( $params, $db ) {
		$conds = array();

		// Types
		$conds['thread_type'] = Threads::TYPE_NORMAL;

		// Limit
		$cutoff = time() - intval( $params['days'] * 24 * 3600 );
		$cutoff = $db->timestamp( $cutoff );
		$conds[] = 'thread_created > ' . $db->addQuotes( $cutoff );

		// Talkpage conditions
		$pageConds = array();

		$talkpages = (array)$params['talkpage'];
		foreach ( $talkpages as $page ) {
			$title = Title::newFromText( $page );
			$pageCond = array(
				'thread_article_namespace' => $title->getNamespace(),
				'thread_article_title' => $title->getDBkey()
			);
			$pageConds[] = $db->makeList( $pageCond, LIST_AND );
		}

		// Thread conditions
		$threads = (array)$params['thread'];
		foreach ( $threads as $thread ) {
			$root = new Article( Title::newFromText( $thread ) );
			$thread = Threads::withRoot( $root );

			if ( ! $thread ) {
				continue;
			}

			$threadCond = array(
				'thread_ancestor' => $thread->id(),
				'thread_id' => $thread->id()
			);
			$pageConds[] = $db->makeList( $threadCond, LIST_OR );
		}
		if ( count( $pageConds ) ) {
			$conds[] = $db->makeList( $pageConds, LIST_OR );
		}

		// New thread v. Reply
		$types = (array)$params['type'];
		if ( !in_array( 'replies', $types ) ) {
			$conds[] = Threads::topLevelClause();
		} elseif ( !in_array( 'newthreads', $types ) ) {
			$conds[] = '!' . Threads::topLevelClause();
		}

		return $conds;
	}

	public function getAllowedParams() {
		global $wgFeedClasses;
		$feedFormatNames = array_keys( $wgFeedClasses );
		return array (
			'feedformat' => array (
				ApiBase :: PARAM_DFLT => 'rss',
				ApiBase :: PARAM_TYPE => $feedFormatNames
			),
			'days' => array (
				ApiBase :: PARAM_DFLT => 7,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => 30,
			),
			'type' => array (
				ApiBase :: PARAM_DFLT => 'newthreads',
				ApiBase :: PARAM_TYPE => array( 'replies', 'newthreads' ),
				ApiBase :: PARAM_ISMULTI => true,
			),
			'talkpage' => array (
				ApiBase :: PARAM_ISMULTI => true,
			),
			'thread' => array (
				ApiBase :: PARAM_ISMULTI => true,
			),
		);
	}

	public function getParamDescription() {
		return array (
			'feedformat' => 'The format of the feed',
			'days'      => 'Number of days of threads to show',
			'type'      => 'Types of posts to show',
			'talkpage' => 'Limit results to threads on these talk pages',
			'thread' => 'Limit results to these threads and their descendants',
		);
	}

	public function getDescription() {
		return 'This module returns a feed of discussion threads';
	}

	public function getExamples() {
		return array (
			'api.php?action=feedthreads',
			'api.php?action=feedthreads&type=replies&thread=Thread:Foo',
			'api.php?action=feedthreads&type=newthreads&talkpage=Talk:Main_Page',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiFeedLQTThreads.php 108908 2012-01-14 15:27:30Z reedy $';
	}
}
