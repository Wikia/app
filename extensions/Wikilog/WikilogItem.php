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
 * Wikilog article database entry.
 */
class WikilogItem
{
	/**
	 * General data about the article.
	 */
	public    $mID          = null;		///< Article ID.
	public    $mName        = null;		///< Article title text (as in DB).
	public    $mTitle       = null;		///< Article Title object.
	public    $mParent      = null;		///< Parent wikilog article ID.
	public    $mParentName  = null;		///< Parent wikilog title text.
	public    $mParentTitle = null;		///< Parent wikilog Title object.
	public    $mPublish     = null;		///< Article is published.
	public    $mPubDate     = null;		///< Date the article was published.
	public    $mUpdated     = null;		///< Date the article was last updated.
	public    $mAuthors     = array();	///< Array of authors.
	public    $mTags        = array();	///< Array of tags.
	public    $mNumComments = null;		///< Cached number of comments.

	/**
	 * Constructor.
	 */
	public function __construct( ) {
	}

	/**
	 * Returns the wikilog article id.
	 */
	public function getID() {
		return $this->mID;
	}

	/**
	 * Checks for the existence of the article in the database.
	 */
	public function exists() {
		return $this->getID() != 0;
	}

	/**
	 * Returns whether the article is published.
	 */
	public function getIsPublished() {
		return $this->mPublish;
	}

	/**
	 * Returns the publication date of the article.
	 */
	public function getPublishDate() {
		return $this->mPubDate;
	}

	/**
	 * Returns the last update date of the article.
	 */
	public function getUpdatedDate() {
		return $this->mUpdated;
	}

	/**
	 * Returns the number of comments in the article.
	 */
	public function getNumComments() {
		$this->updateNumComments();
		return $this->mNumComments;
	}

	/**
	 * Saves article data in the database.
	 */
	public function saveData() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->replace(
			'wikilog_posts',
			'wlp_page',
			array(
				'wlp_page'    => $this->mID,
				'wlp_parent'  => $this->mParent,
				'wlp_title'   => $this->mName,
				'wlp_publish' => $this->mPublish,
				'wlp_pubdate' => $this->mPubDate ? $dbw->timestamp( $this->mPubDate ) : '',
				'wlp_updated' => $this->mUpdated ? $dbw->timestamp( $this->mUpdated ) : '',
				'wlp_authors' => serialize( $this->mAuthors ),
				'wlp_tags'    => serialize( $this->mTags ),
			),
			__METHOD__
		);
	}

	/**
	 * Deletes article data from the database.
	 */
	public function deleteData() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'wikilog_posts', array( 'wlp_page' => $this->getID() ), __METHOD__ );
	}

	/**
	 * Updates the number of article comments.
	 */
	public function updateNumComments( $force = false ) {
		if ( $force || is_null( $this->mNumComments ) ) {
			$dbw = wfGetDB( DB_MASTER );

			# Retrieve estimated number of comments
			$count = $dbw->selectField( 'wikilog_comments', 'COUNT(*)',
				array( 'wlc_post' => $this->getID() ), __METHOD__ );

			# Update wikilog_posts cache
			$dbw->update( 'wikilog_posts',
				array( 'wlp_num_comments' => $count ),
				array( 'wlp_page' => $this->getID() ),
				__METHOD__
			);

			$this->mNumComments = $count;
		}
	}

	/**
	 * Resets the article id.
	 */
	public function resetID( $id ) {
		$this->mTitle->resetArticleID( $id );
		$this->mID = $id;
	}

	/**
	 * Returns an array with common header and footer system message
	 * parameters.
	 */
	public function getMsgParams( $extended = false, $pout = null ) {
		global $wgContLang, $wgWikilogEnableTags;

		$authors = array_keys( $this->mAuthors );
		$authorsFmt = WikilogUtils::authorList( $authors );
		$commentsFmt = WikilogUtils::getCommentsWikiText( $this );

		$categories = array();
		$categoriesFmt = '';
		$tags = array();
		$tagsFmt = '';

		if ( $extended ) {
			if ( $pout !== null ) {
				$categories = $pout->getCategoryLinks();
				if ( count( $categories ) > 0 ) {
					$categoriesFmt = wfMsgExt( 'wikilog-summary-categories',
						array( 'content', 'parsemag' ),
						count( $categories ),
						WikilogUtils::categoryList( $categories )
					);
				} else {
					$categoriesFmt = wfMsgExt( 'wikilog-summary-uncategorized',
						array( 'content', 'parsemag' )
					);
				}
			}
			if ( $wgWikilogEnableTags ) {
				$tags = array_keys( $this->mTags );
				$tagsFmt = WikilogUtils::tagList( $tags );
			}
		}

		list( $date, $time, $tz ) = WikilogUtils::getLocalDateTime( $this->mPubDate );

		/*
		 * This is probably the largest amount of parameters to a
		 * system message in MediaWiki. This is the price of allowing
		 * the user to customize the presentation of wikilog articles.
		 */
		return array(
			/* $1  */ $this->mParentTitle->getPrefixedURL(),
			/* $2  */ $this->mParentName,
			/* $3  */ $this->mTitle->getPrefixedURL(),
			/* $4  */ $this->mName,
			/* $5  */ count( $authors ),
			/* $6  */ ( count( $authors ) > 0 ? $authors[0] : '' ),
			/* $7  */ $authorsFmt,
			/* $8  */ $date,
			/* $9  */ $time,
			/* $10 */ $commentsFmt,
			/* $11 */ count( $categories ),
			/* $12 */ $categoriesFmt,
			/* $13 */ count( $tags ),
			/* $14 */ $tagsFmt,
			/* $15 */ $tz
		);
	}

	/**
	 * Creates a new wikilog article object from a database row.
	 * @param $row Row from database.
	 * @return New WikilogItem object.
	 */
	public static function newFromRow( $row ) {
		$item = new WikilogItem();
		$item->mID          = intval( $row->wlp_page );
		$item->mName        = strval( $row->wlp_title );
		$item->mTitle       = Title::makeTitle( $row->page_namespace, $row->page_title );
		$item->mParent      = intval( $row->wlp_parent );
		$item->mParentName  = str_replace( '_', ' ', $row->wlw_title );
		$item->mParentTitle = Title::makeTitle( $row->wlw_namespace, $row->wlw_title );
		$item->mPublish     = intval( $row->wlp_publish );
		$item->mPubDate     = $row->wlp_pubdate ? wfTimestamp( TS_MW, $row->wlp_pubdate ) : null;
		$item->mUpdated     = $row->wlp_updated ? wfTimestamp( TS_MW, $row->wlp_updated ) : null;
		$item->mNumComments = $row->wlp_num_comments;
		$item->mAuthors     = unserialize( $row->wlp_authors );
		$item->mTags        = unserialize( $row->wlp_tags );
		if ( !is_array( $item->mAuthors ) ) {
			$item->mAuthors = array();
		}
		if ( !is_array( $item->mTags ) ) {
			$item->mTags = array();
		}
		return $item;
	}

	/**
	 * Creates a new wikilog article object from an existing article id.
	 * Data is fetched from the database.
	 * @param $id Article id.
	 * @return New WikilogItem object, or NULL if article doesn't exist.
	 */
	public static function newFromID( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$row = self::loadFromID( $dbr, $id );
		if ( $row ) {
			return self::newFromRow( $row );
		}
		return null;
	}

	/**
	 * Creates a new wikilog article object from a wikilog info object.
	 * Data is fetched from the database.
	 * @param $wi WikilogItem object.
	 * @return New WikilogItem object, or NULL if article doesn't exist.
	 */
	public static function newFromInfo( WikilogInfo &$wi ) {
		$itemTitle = $wi->getItemTitle();
		if ( $itemTitle ) {
			return self::newFromID( $itemTitle->getArticleID() );
		} else {
			return null;
		}
	}

	/**
	 * Load information about a wikilog article from the database given a set
	 * of conditions.
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
	 * Load information about a wikilog article from the database given an
	 * article id.
	 * @param $dbr Database connection object.
	 * @param $id Article id.
	 * @return Database row, or false.
	 */
	private static function loadFromID( $dbr, $id ) {
		return self::loadFromConds( $dbr, array( 'wlp_page' => $id ) );
	}

	/**
	 * Return the list of database tables required to create a new instance
	 * of WikilogItem.
	 */
	public static function selectTables( $dbr = null ) {
		if ( !$dbr ) $dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		return array(
			'tables' => array(
				'wikilog_posts',
				"{$page} AS w",
				"{$page} AS p"
			),
			'join_conds' => array(
				"{$page} AS w" => array( 'LEFT JOIN', 'w.page_id = wlp_parent' ),
				"{$page} AS p" => array( 'LEFT JOIN', 'p.page_id = wlp_page' )
			)
		);
	}

	/**
	 * Return the list of post fields required to create a new instance of
	 * WikilogItem.
	 */
	public static function selectFields() {
		return array(
			'wlp_page',
			'wlp_parent',
			'w.page_namespace AS wlw_namespace',
			'w.page_title AS wlw_title',
			'p.page_namespace AS page_namespace',
			'p.page_title AS page_title',
			'wlp_title',
			'wlp_publish',
			'wlp_pubdate',
			'wlp_updated',
			'wlp_authors',
			'wlp_tags',
			'wlp_num_comments'
		);
	}
}
