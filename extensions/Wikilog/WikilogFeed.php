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
 * Syndication feed driver base class.
 * Loosely based on Pager/IndexPager classes.
 */
abstract class WikilogFeed
{
	/// Feed title object, used for identification and self URL.
	protected $mTitle;

	/// Feed format, either 'atom' or 'rss'.
	protected $mFormat;

	/// Wikilog query object. Contains the options that drives the database
	/// queries.
	protected $mQuery;

	/// Number of feed items to output.
	protected $mLimit;

	/// Database object.
	protected $mDb;

	/// The index to use for ordering.
	protected $mIndexField;

	/// Result object for the query.
	protected $mResult;

	/// Copyright notice.
	protected $mCopyright;

	/**
	 * List of query parameters that are allowed for feeds. Note that adding
	 * to this list means that feed caching should be revisited. Parameters
	 * must be listed as keys.
	 */
	public static $paramWhitelist = array( 'wikilog' => true, 'show' => true );

	/**
	 * WikilogFeed constructor.
	 *
	 * @param $title Title  Feed title and URL.
	 * @param $format string  Feed format ('atom' or 'rss').
	 * @param $query WikilogQuery  Query options.
	 * @param $limit integer  Number of items to generate.
	 */
	public function __construct( Title $title, $format, WikilogQuery $query, $limit )
	{
		global $wgUser;

		$this->mTitle = $title;
		$this->mFormat = $format;
		$this->mQuery = $query;
		$this->mLimit = $limit;
		$this->mDb = wfGetDB( DB_SLAVE );
		$this->mIndexField = $this->getIndexField();

		# Retrieve copyright notice.
		$skin = $wgUser->getSkin();
		$saveExpUrls = WikilogParser::expandLocalUrls();
		$this->mCopyright = $skin->getCopyright( 'normal' );
		WikilogParser::expandLocalUrls( $saveExpUrls );
	}

	/**
	 * Execute the feed driver, generating the syndication feed and printing
	 * the results.
	 */
	public function execute() {
		global $wgOut;

		if ( !$this->checkFeedOutput() )
			return;

		$feed = $this->getFeedObject();

		if ( !$feed ) {
			wfHttpError( 404, "Not found",
				"There is no such wikilog feed available from this site." );
			return;
		}

		list( $timekey, $feedkey ) = $this->getCacheKeys();
		FeedUtils::checkPurge( $timekey, $feedkey );

		if ( $feed->isCacheable() ) {
			# Check if client cache is ok.
			if ( $wgOut->checkLastModified( $feed->getUpdated() ) ) {
				# Client cache is fresh. OutputPage takes care of sending
				# the appropriate headers, nothing else to do.
				return;
			}

			# Try to load the feed from our cache.
			$cached = $this->loadFromCache( $feed->getUpdated(), $timekey, $feedkey );

			if ( is_string( $cached ) ) {
				wfDebug( __METHOD__ . ": Outputting cached feed\n" );
				$feed->httpHeaders();
				echo $cached;
			} else {
				wfDebug( __METHOD__ . ": rendering new feed and caching it\n" );
				ob_start();
				$this->printFeed( $feed );
				$cached = ob_get_contents();
				ob_end_flush();
				$this->saveToCache( $cached, $timekey, $feedkey );
			}
		} else {
			# This feed is not cacheable.
			$this->printFeed( $feed );
		}
	}

	/**
	 * Generates the list of entries for a given feed and print the resulting
	 * feed document.
	 * @param $feed Prepared syndication feed object.
	 */
	public function printFeed( $feed ) {
		global $wgOut, $wgFavicon;

		$feed->outHeader();

		$this->doQuery();
		$numRows = min( $this->mResult->numRows(), $this->mLimit );

		wfDebug( __METHOD__ . ": Feed query returned $numRows results.\n" );

		if ( $numRows ) {
			$this->mResult->rewind();
			for ( $i = 0; $i < $numRows; $i++ ) {
				$row = $this->mResult->fetchObject();
				$feed->outEntry( $this->formatFeedEntry( $row ) );
			}
		}

		$feed->outFooter();
	}

	/**
	 * Performs the database query that returns the syndication feed entries
	 * and store the result wrapper in $this->mResult.
	 */
	public function doQuery() {
		$fname = __METHOD__ . ' (' . get_class( $this ) . ')';
		wfProfileIn( $fname );

		$this->mResult = $this->reallyDoQuery( $this->mLimit );

		wfProfileOut( $fname );
	}

	/**
	 * Performs the database query and return the result wrapper.
	 * @param $limit Maximum number of entries to return.
	 * @return ResultWrapper  The database query ResultWrapper object.
	 */
	public function reallyDoQuery( $limit ) {
		$fname = __METHOD__ . ' (' . get_class( $this ) . ')';
		$info = $this->getQueryInfo();
		$tables = $info['tables'];
		$fields = $info['fields'];
		$conds = isset( $info['conds'] ) ? $info['conds'] : array();
		$options = isset( $info['options'] ) ? $info['options'] : array();
		$join_conds = isset( $info['join_conds'] ) ? $info['join_conds'] : array();
		$options['ORDER BY'] = $this->mIndexField . ' DESC';
		$options['LIMIT'] = intval( $limit );
		$res = $this->mDb->select( $tables, $fields, $conds, $fname, $options, $join_conds );
		return new ResultWrapper( $this->mDb, $res );
	}

	/**
	 * Returns the query information.
	 */
	public function getQueryInfo() {
		return $this->mQuery->getQueryInfo( $this->mDb );
	}

	/**
	 * Save feed output to cache.
	 *
	 * @param $feed Feed output.
	 * @param $timekey Object cache key for the cached feed timestamp.
	 * @param $feedkey Object cache key for the cached feed output.
	 */
	public function saveToCache( $feed, $timekey, $feedkey ) {
		global $messageMemc;
		$messageMemc->set( $feedkey, $feed );
		$messageMemc->set( $timekey, wfTimestamp( TS_MW ), 24 * 3600 );
	}

	/**
	 * Load feed output from cache.
	 *
	 * @param $tsData Timestamp of the last change of the local data.
	 * @param $timekey Object cache key for the cached feed timestamp.
	 * @param $feedkey Object cache key for the cached feed output.
	 * @return The cached feed output if cache is good, false otherwise.
	 * @todo Remove Mw1.15- guard for OutputPage::setLastModified().
	 */
	public function loadFromCache( $tsData, $timekey, $feedkey ) {
		global $wgFeedCacheTimeout, $wgOut, $messageMemc;
		$tsCache = $messageMemc->get( $timekey );

		if ( ( $wgFeedCacheTimeout > 0 ) && $tsCache ) {
			$age = time() - wfTimestamp( TS_UNIX, $tsCache );

			if ( $age < $wgFeedCacheTimeout ) {
				wfDebug( "Wikilog: loading feed from cache -- " .
					"too young: age ($age) < timeout ($wgFeedCacheTimeout) " .
					"($feedkey; $tsCache; $tsData)\n" );

				$wgOut->setLastModified( $tsCache );

				return $messageMemc->get( $feedkey );
			} elseif ( $tsCache >= $tsData ) {
				wfDebug( __METHOD__ . ": loading feed from cache -- " .
					"not modified: cache ($tsCache) >= data ($tsData)" .
					"($feedkey)\n" );
				return $messageMemc->get( $feedkey );
			} else {
				wfDebug( __METHOD__ . ": cached feed timestamp check failed -- " .
					"cache ($tsCache) < data ($tsData)\n" );
			}
		}
		return false;
	}

	/**
	 * This function should be overridden to return the index that will be
	 * used to perform the query.
	 */
	abstract public function getIndexField();

	/**
	 * This function should be overridden to return a WlSyndicationFeed
	 * object representing the top-level feed object.
	 */
	abstract public function getFeedObject();

	/**
	 * This function should be overriden to format a database result row
	 * into a WlSyndicationEntry object.
	 */
	abstract public function formatFeedEntry( $row );

	/**
	 * Returns the keys for the timestamp and feed output in the object
	 * cache.
	 */
	abstract public function getCacheKeys();

	/**
	 * Shadowed from FeedUtils::checkFeedOutput(). The difference is that
	 * this version checks against $wgWikilogFeedClasses instead of
	 * $wgFeedClasses.
	 */
	protected function checkFeedOutput() {
		global $wgOut, $wgFeed, $wgWikilogFeedClasses;
		if ( !$wgFeed ) {
			$wgOut->addWikiMsg( 'feed-unavailable' );
			return false;
		}
		if ( !isset( $wgWikilogFeedClasses[$this->mFormat] ) ) {
			wfHttpError( 500, "Internal Server Error", "Unsupported feed type." );
			return false;
		}
		return true;
	}

	/**
	 * Find and add categories for the given feed or entry.
	 */
	protected function addCategories( WlSyndicationBase $obj, $pageid ) {
		$scheme = SpecialPage::getTitleFor( 'Categories' )->getFullUrl();
		$res = $this->mDb->select(
			array( 'categorylinks', 'page', 'page_props' ),
			array( 'page_title' ),
			array( /* conds */
				'cl_from' => $pageid,
				'page_title IS NOT NULL',
				'pp_value IS NULL'
			), __METHOD__,
			array( /* options */ ),
			array( /* joins */
				'page' => array( 'LEFT JOIN', array(
					'page_namespace' => NS_CATEGORY,
					'page_title = cl_to'
				) ),
				'page_props' => array( 'LEFT JOIN', array(
					'pp_propname' => 'hiddencat',
					'pp_page = page_id'
				) )
			)
		);
		foreach ( $res as $row ) {
			$term = $row->page_title;
			$label = preg_replace( '/(?:.*\/)?(.+?)(?:\s*\(.*\))?/', '$1', $term );
			$label = str_replace( '_', ' ', $label );
			$obj->addCategory( $term, $scheme, $label );
		}
	}
}

/**
 * Syndication item feed generator. Creates feeds from a list of wikilog
 * articles, given a format and a query object.
 */
class WikilogItemFeed
	extends WikilogFeed
{
	/// Whether this is a site feed (Special:Wikilog) or not.
	protected $mSiteFeed;

	/**
	 * WikilogItemFeed constructor.
	 *
	 * @param $title Title  Feed title and URL.
	 * @param $format string  Feed format ('atom' or 'rss').
	 * @param $query WikilogItemQuery  Query options.
	 * @param $limit integer  Number of items to generate.
	 */
	public function __construct( Title $title, $format, WikilogItemQuery $query,
			$limit = false )
	{
		global $wgWikilogNumArticles;

		if ( !$limit ) $limit = $wgWikilogNumArticles;
		parent::__construct( $title, $format, $query, $limit );
		$this->mSiteFeed = $this->mQuery->getWikilogTitle() === null;
	}

	public function getIndexField() {
		return 'wlp_pubdate';
	}

	public function doQuery() {
		$this->mQuery->setOption( 'last-comment-timestamp' );
		return parent::doQuery();
	}

	public function getFeedObject() {
		if ( $this->mQuery->getWikilogTitle() ) {
			return $this->getWikilogFeedObject( $this->mQuery->getWikilogTitle() );
		} elseif ( $this->mQuery->getNamespace() !== false ) {
			return $this->getNamespaceFeedObject( $this->mQuery->getNamespace() );
		} else {
			return $this->getSiteFeedObject();
		}
	}

	/**
	 * Generates and populates a WlSyndicationFeed object for the site.
	 *
	 * @return Feed object.
	 */
	protected function getSiteFeedObject() {
		global $wgContLanguageCode, $wgWikilogFeedClasses, $wgFavicon, $wgLogo;
		$title = wfMsgForContent( 'wikilog-specialwikilog-title' );
		$subtitle = wfMsgExt( 'wikilog-feed-description', array( 'parse', 'content' ) );

		$updated = $this->mDb->selectField( 'wikilog_wikilogs',
			'MAX(wlw_updated)', false, __METHOD__ );
		if ( !$updated ) $updated = wfTimestampNow();

		$feed = new $wgWikilogFeedClasses[$this->mFormat](
			$this->mTitle->getFullUrl(),
			wfMsgForContent( 'wikilog-feed-title', $title, $wgContLanguageCode ),
			$updated,
			$this->mTitle->getFullUrl()
		);
		$feed->setSubtitle( new WlTextConstruct( 'html', $subtitle ) );
		$feed->setLogo( wfExpandUrl( $wgLogo ) );
		if ( $wgFavicon !== false ) {
			$feed->setIcon( wfExpandUrl( $wgFavicon ) );
		}
		if ( $this->mCopyright ) {
			$feed->setRights( new WlTextConstruct( 'html', $this->mCopyright ) );
		}
		return $feed;
	}

	/**
	 * Generates and populates a WlSyndicationFeed object for a given namespace.
	 *
	 * @param $ns Namespace.
	 * @return Feed object.
	 */
	protected function getNamespaceFeedObject( $ns ) {
		global $wgWikilogFeedClasses, $wgFavicon, $wgLogo;
		global $wgContLang, $wgContLanguageCode;

		$title = wfMsgForContent( 'wikilog-feed-ns-title', $wgContLang->getFormattedNsText( $ns ) );
		$subtitle = wfMsgExt( 'wikilog-feed-description', array( 'parse', 'content' ) );

		$updated = $this->mDb->selectField(
			array( 'wikilog_wikilogs', 'page' ),
			'MAX(wlw_updated)',
			array(
				'wlw_page = page_id',
				'page_namespace' => $ns
			),
			__METHOD__
		);
		if ( !$updated ) $updated = wfTimestampNow();

		$feed = new $wgWikilogFeedClasses[$this->mFormat](
			$this->mTitle->getFullUrl(),
			wfMsgForContent( 'wikilog-feed-title', $title, $wgContLanguageCode ),
			$updated,
			$this->mTitle->getFullUrl()
		);
		$feed->setSubtitle( new WlTextConstruct( 'html', $subtitle ) );
		$feed->setLogo( wfExpandUrl( $wgLogo ) );
		if ( $wgFavicon !== false ) {
			$feed->setIcon( wfExpandUrl( $wgFavicon ) );
		}
		if ( $this->mCopyright ) {
			$feed->setRights( new WlTextConstruct( 'html', $this->mCopyright ) );
		}
		return $feed;
	}

	/**
	 * Generates and populates a WlSyndicationFeed object for the given
	 * wikilog. Caches objects whenever possible.
	 *
	 * @param $wikilogTitle Title object for the wikilog.
	 * @return Feed object, or NULL if wikilog doesn't exist.
	 */
	protected function getWikilogFeedObject( $wikilogTitle, $forsource = false ) {
		static $wikilogCache = array();
		global $wgContLanguageCode, $wgWikilogFeedClasses;
		global $wgWikilogFeedCategories;

		$title = $wikilogTitle->getPrefixedText();
		if ( !isset( $wikilogCache[$title] ) ) {
			$row = $this->mDb->selectRow( 'wikilog_wikilogs',
				array(
					'wlw_page', 'wlw_subtitle',
					'wlw_icon', 'wlw_logo', 'wlw_authors',
					'wlw_updated'
				),
				array( 'wlw_page' => $wikilogTitle->getArticleId() ),
				__METHOD__
			);
			if ( $row !== false ) {
				$self = $forsource
					 ? $wikilogTitle->getFullUrl( "feed={$this->mFormat}" )
					 : null;
				$feed = new $wgWikilogFeedClasses[$this->mFormat](
					$wikilogTitle->getFullUrl(),
					wfMsgForContent( 'wikilog-feed-title', $title, $wgContLanguageCode ),
					$row->wlw_updated, $wikilogTitle->getFullUrl(), $self
				);
				if ( $row->wlw_subtitle ) {
					$st = @ unserialize( $row->wlw_subtitle );
					if ( is_array( $st ) ) {
						$feed->setSubtitle( new WlTextConstruct( $st[0], $st[1] ) );
					} elseif ( is_string( $st ) ) {
						$feed->setSubtitle( $st );
					}
				}
				if ( $row->wlw_icon ) {
					$t = Title::makeTitle( NS_IMAGE, $row->wlw_icon );
					$feed->setIcon( wfFindFile( $t ) );
				}
				if ( $row->wlw_logo ) {
					$t = Title::makeTitle( NS_IMAGE, $row->wlw_logo );
					$feed->setLogo( wfFindFile( $t ) );
				}
				if ( $wgWikilogFeedCategories ) {
					$this->addCategories( $feed, $row->wlw_page );
				}
				if ( $row->wlw_authors ) {
					$authors = unserialize( $row->wlw_authors );
					foreach ( $authors as $user => $userid ) {
						$usertitle = Title::makeTitle( NS_USER, $user );
						$feed->addAuthor( $user, $usertitle->getFullUrl() );
					}
				}
				if ( $this->mCopyright ) {
					$feed->setRights( new WlTextConstruct( 'html', $this->mCopyright ) );
				}
			} else {
				$feed = false;
			}
			$wikilogCache[$title] =& $feed;
		}
		return $wikilogCache[$title];
	}

	/**
	 * Generates and returns a single feed entry.
	 * @param $row The wikilog article database entry.
	 * @return A new WlSyndicationEntry object.
	 */
	public function formatFeedEntry( $row ) {
		global $wgMimeType;
		global $wgWikilogFeedSummary, $wgWikilogFeedContent;
		global $wgWikilogFeedCategories, $wgWikilogFeedRelated;
		global $wgWikilogEnableComments;

		# Make titles.
		$wikilogName = str_replace( '_', ' ', $row->wlw_title );
		$wikilogTitle =& Title::makeTitle( $row->wlw_namespace, $row->wlw_title );
		$itemName = str_replace( '_', ' ', $row->wlp_title );
		$itemTitle =& Title::makeTitle( $row->page_namespace, $row->page_title );

		# Retrieve article parser output
		list( $article, $parserOutput ) = WikilogUtils::parsedArticle( $itemTitle, true );

		# Generate some fixed bits
		$authors = unserialize( $row->wlp_authors );

		# Create new syndication entry.
		$entry = new WlSyndicationEntry(
			self::makeEntryId( $itemTitle ),
			$itemName,
			$row->wlp_updated,
			$itemTitle->getFullUrl()
		);

		# Comments link.
		$cmtLink = array(
			'href' => $itemTitle->getTalkPage()->getFullUrl(),
			'type' => $wgMimeType
		);
		if ( $wgWikilogEnableComments ) {
			$cmtLink['thr:count'] = $row->wlp_num_comments;
			if ( !is_null( $row->_wlp_last_comment_timestamp ) ) {
				$cmtLink['thr:updated'] = wfTimestamp( TS_ISO_8601, $row->_wlp_last_comment_timestamp );
			}
		}
		$entry->addLinkRel( 'replies', $cmtLink );

		# Source feed.
		if ( $this->mSiteFeed ) {
			$privfeed = $this->getWikilogFeedObject( $wikilogTitle, true );
			if ( $privfeed ) {
				$entry->setSource( $privfeed );
			}
		}

		# Retrieve summary and content.
		list( $summary, $content ) = WikilogUtils::splitSummaryContent( $parserOutput );

		if ( $wgWikilogFeedSummary && $summary ) {
			$entry->setSummary( new WlTextConstruct( 'html', $summary ) );
		}
		if ( $wgWikilogFeedContent && $content ) {
			$entry->setContent( new WlTextConstruct( 'html', $content ) );
		}

		# Authors.
		foreach ( $authors as $user => $userid ) {
			$usertitle = Title::makeTitle( NS_USER, $user );
			$entry->addAuthor( $user, $usertitle->getFullUrl() );
		}

		# Automatic list of categories.
		if ( $wgWikilogFeedCategories ) {
			$this->addCategories( $entry, $row->wlp_page );
		}

		# Automatic list of related links.
		if ( $wgWikilogFeedRelated ) {
			$externals = array_keys( $parserOutput->getExternalLinks() );
			foreach ( $externals as $ext ) {
				$entry->addLinkRel( 'related', array( 'href' => $ext ) );
			}
		}

		if ( $row->wlp_publish ) {
			$entry->setPublished( $row->wlp_pubdate );
		}

		return $entry;
	}

	/**
	 * Returns the keys for the timestamp and feed output in the object cache.
	 */
	public function getCacheKeys() {
		if ( ( $title = $this->mQuery->getWikilogTitle() ) ) {
			$id = 'id:' . $title->getArticleId();
		} elseif ( ( $ns = $this->mQuery->getNamespace() ) ) {
			$id = 'ns:' . $ns;
		} else {
			$id = 'site';
		}
		$ft = 'show:' . $this->mQuery->getPubStatus() .
			':limit:' . $this->mLimit;
		return array(
			wfMemcKey( 'wikilog', $this->mFormat, $id, 'timestamp' ),
			wfMemcKey( 'wikilog', $this->mFormat, $id, $ft )
		);
	}

	/**
	 * Creates an unique ID for a feed entry. Tries to use $wgTaggingEntity
	 * if possible in order to create an RFC 4151 tag, otherwise, we use the
	 * page URL.
	 */
	public static function makeEntryId( $title ) {
		global $wgTaggingEntity;
		if ( $wgTaggingEntity ) {
			$qstr = wfArrayToCGI( array( 'wk' => wfWikiID(), 'id' => $title->getArticleId() ) );
			return "tag:{$wgTaggingEntity}:/MediaWiki/Wikilog?{$qstr}";
		} else {
			return $title->getFullUrl();
		}
	}
}

/**
 * Syndication feed generator for wikilog comments.
 */
class WikilogCommentFeed
	extends WikilogFeed
{
	/**
	 * If displaying comments for a single article.
	 */
	protected $mSingleItem = false;

	/**
	 * WikilogCommentFeed constructor.
	 *
	 * @param $title Title  Feed title and URL.
	 * @param $format string  Feed format ('atom' or 'rss').
	 * @param $query WikilogCommentQuery  Query parameters.
	 * @param $limit integer  Number of items to generate.
	 */
	public function __construct( Title $title, $format,
			WikilogCommentQuery $query, $limit = false )
	{
		global $wgWikilogNumComments;

		if ( !$limit ) $limit = $wgWikilogNumComments;
		parent::__construct( $title, $format, $query, $limit );
	}

	public function getIndexField() {
		return 'wlc_timestamp';
	}

	public function getFeedObject() {
		if ( ( $item = $this->mQuery->getItem() ) ) {
			return $this->getItemFeedObject( $item );
		} else {
			return $this->getSiteFeedObject();
		}
	}

	/**
	 * Generates and populates a WlSyndicationFeed object for the site.
	 *
	 * @return WlSyndicationFeed object.
	 */
	public function getSiteFeedObject() {
		global $wgContLanguageCode, $wgWikilogFeedClasses, $wgFavicon, $wgLogo;

		$title = wfMsgForContent( 'wikilog-feed-title',
			wfMsgForContent( 'wikilog-specialwikilogcomments-title' ),
			$wgContLanguageCode
		);
		$subtitle = wfMsgExt( 'wikilog-comment-feed-description', array( 'parse', 'content' ) );

		$updated = $this->mDb->selectField( 'wikilog_comments',
			'MAX(wlc_updated)', false, __METHOD__
		);
		if ( !$updated ) $updated = wfTimestampNow();

		$url = $this->mTitle->getFullUrl();

		$feed = new $wgWikilogFeedClasses[$this->mFormat](
			$url, $title, $updated, $url
		);
		$feed->setSubtitle( new WlTextConstruct( 'html', $subtitle ) );
		if ( $wgFavicon !== false ) {
			$feed->setIcon( wfExpandUrl( $wgFavicon ) );
		}
		if ( $this->mCopyright ) {
			$feed->setRights( new WlTextConstruct( 'html', $this->mCopyright ) );
		}
		return $feed;
	}

	/**
	 * Generates and populates a WlSyndicationFeed object for the given
	 * wikilog article.
	 *
	 * @param $item WikilogItem  Wikilog article that owns this feed.
	 * @return WlSyndicationFeed object, or NULL if not possible.
	 */
	public function getItemFeedObject( WikilogItem $item ) {
		global $wgContLanguageCode, $wgWikilogFeedClasses, $wgFavicon;

		$title = wfMsgForContent( 'wikilog-feed-title',
			wfMsgForContent( 'wikilog-title-comments', $item->mName ),
			$wgContLanguageCode
		);
		$subtitle = wfMsgExt( 'wikilog-comment-feed-description', array( 'parse', 'content' ) );
		$updated = $this->mDb->selectField( 'wikilog_comments',
			'MAX(wlc_updated)', array( 'wlc_post' => $item->mID ), __METHOD__
		);
		if ( !$updated ) $updated = wfTimestampNow();

		$url = $this->mTitle->getFullUrl();

		$feed = new $wgWikilogFeedClasses[$this->mFormat](
			$url, $title, $updated, $url
		);
		$feed->setSubtitle( new WlTextConstruct( 'html', $subtitle ) );
		if ( $wgFavicon !== false ) {
			$feed->setIcon( wfExpandUrl( $wgFavicon ) );
		}
		if ( $this->mCopyright ) {
			$feed->setRights( new WlTextConstruct( 'html', $this->mCopyright ) );
		}
		return $feed;
	}

	/**
	 * Generates and returns a single feed entry.
	 * @param $row The wikilog comment database entry.
	 * @return A new WlSyndicationEntry object.
	 */
	function formatFeedEntry( $row ) {
		global $wgMimeType;

		# Create comment object.
		$item = $this->mSingleItem ? $this->mSingleItem : WikilogItem::newFromRow( $row );
		$comment = WikilogComment::newFromRow( $item, $row );

		# Prepare some strings.
		if ( $comment->mUserID ) {
			$usertext = $comment->mUserText;
		} else {
			$usertext = wfMsgForContent( 'wikilog-comment-anonsig',
				$comment->mUserText, ''/*talk*/, $comment->mAnonName
			);
		}
		if ( $this->mSingleItem ) {
			$title = wfMsgForContent( 'wikilog-comment-feed-title1',
				$comment->mID, $usertext
			);
		} else {
			$title = wfMsgForContent( 'wikilog-comment-feed-title2',
				$comment->mID, $usertext, $comment->mItem->mName
			);
		}

		# Create new syndication entry.
		$entry = new WlSyndicationEntry(
			self::makeEntryId( $comment ),
			$title,
			$comment->mUpdated,
			$comment->getCommentArticleTitle()->getFullUrl()
		);

		# Comment text.
		if ( $comment->mCommentRev ) {
			list( $article, $parserOutput ) = WikilogUtils::parsedArticle( $comment->mCommentTitle, true );
			$content = Sanitizer::removeHTMLcomments( $parserOutput->getText() );
			if ( $content ) {
				$entry->setContent( new WlTextConstruct( 'html', $content ) );
			}
		}

		# Author.
		$usertitle = Title::makeTitle( NS_USER, $comment->mUserText );
		$useruri = $usertitle->exists() ? $usertitle->getFullUrl() : null;
		$entry->addAuthor( $usertext, $useruri );

		# Timestamp
		$entry->setPublished( $comment->mTimestamp );

		return $entry;
	}

	/**
	 * Performs the database query that returns the syndication feed entries
	 * and store the result wrapper in $this->mResult.
	 */
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

	/**
	 * Returns the keys for the timestamp and feed output in the object cache.
	 */
	function getCacheKeys() {
		if ( ( $item = $this->mQuery->getItem() ) ) {
			$title = $item->mTitle;
		} else {
			$title = null;
		}
		$id = $title ? 'id:' . $title->getArticleId() : 'site';
		$ft = 'show:' . $this->mQuery->getModStatus() .
			':limit:' . $this->mLimit;
		return array(
			wfMemcKey( 'wikilog', $this->mFormat, $id, 'timestamp' ),
			wfMemcKey( 'wikilog', $this->mFormat, $id, $ft )
		);
	}

	/**
	 * Creates an unique ID for a feed entry. Tries to use $wgTaggingEntity
	 * if possible in order to create an RFC 4151 tag, otherwise, we use the
	 * page URL.
	 */
	public static function makeEntryId( WikilogComment $comment ) {
		global $wgTaggingEntity;
		if ( $wgTaggingEntity ) {
			$qstr = wfArrayToCGI( array( 'wk' => wfWikiID(), 'id' => $comment->getID() ) );
			return "tag:{$wgTaggingEntity}:/MediaWiki/Wikilog/comment?{$qstr}";
		} else {
			return $comment->getCommentArticleTitle()->getFullUrl();
		}
	}
}
