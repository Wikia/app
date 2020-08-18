<?php

namespace Discussions;

use DumpUtils;
use Title;
use \Wikia\Logger\WikiaLogger;

class ForumDumper {

	const TABLE_PAGE = 'page';
	const TABLE_COMMENTS = 'comments_index';
	const TABLE_REVISION = 'revision';
	const TABLE_TEXT = 'text';
	const TABLE_VOTE = 'page_vote';
	const TABLE_PAGE_WIKIA_PROPS = 'page_wikia_props';
	const TABLE_WALL_RELATED_PAGES = 'wall_related_pages';

	const CONTRIBUTOR_TYPE_USER = "user";
	const CONTRIBUTOR_TYPE_IP = "ip";
	const CONTRIBUTOR_TYPE_DELETED = "[deleted]";
	const CONTRIBUTOR_TYPE_UNKNOWN = "[unknown]";

	// Discussions uses TEXT columns for content, which are limited to 2**16 bytes.  Also
	// subtracting 16 bytes from the max size since going right up to the limit still causes
	// MySQL to fail the insert.
	const MAX_CONTENT_SIZE = 65520;

	// A very loose interpretation of markup favoring false positives for markup.  Match
	// alphanumerics, anything in a basic URL and punctuation.  If any character in the text
	// doesn't match, assume there is wiki text and parse it.
	const REGEXP_MATCH_HAS_MARKUP = '/[^a-zA-Z0-9\.\/:\?&%"\' ]/';

	const COLUMNS_PAGE = [
		"page_id",
		"namespace",
		"raw_title",
		"is_redirect",
		"is_new",
		"touched",
		"latest_revision_id",
		"length",
		"parent_page_id",
		"parent_comment_id",
		"last_child_comment_id",
		"archived_ind",
		"deleted_ind",
		"removed_ind",
		"locked_ind",
		"protected_ind",
		"sticky_ind",
		"first_revision_id",
		"last_revision_id",
		"comment_timestamp",
		"display_order",
	];

	const COLUMNS_REVISION = [
		"revision_id",
		"page_id",
		"page_namespace",
		"title",
		"user_type",
		"user_identifier",
		"timestamp",
		"is_minor_edit",
		"is_deleted",
		"length",
		"parent_id",
		"text_flags",
		"raw_content",
		"content",
		"creation_timestamp",
		"creation_user",
	];

	const COLUMNS_VOTE = [
		"page_id",
		"user_identifier",
		"timestamp",
	];

	const COLUMNS_TOPICS = [
		"topic_id",
		"page_id",
		"article_id",
		"article_title",
		"relative_url"
	];

	const FORUM_NAMEPSACES = [
		NS_WIKIA_FORUM_BOARD,
		NS_WIKIA_FORUM_BOARD_THREAD,
	];

	const ANON_WROTE_SELECTOR = "/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3} wrote/";
	const ANON_WROTE_REPLACEMENT = "Quote";

	const QUOTE_SELECTOR = "/<div class=\\\"quote\\\">(.*?)<\/div>/s";
	const QUOTE_REPLACEMENT = "<div class=\"quote\"><i>$1</i></div><br>";

	private $titles = [];
	private $pages = [];
	private $bulk;
	private $debug;

	public function __construct($bulk = false, $debug = false) {
		$this->bulk = $bulk;
		$this->debug = $debug;
	}

	public function addPage( $id, $data ) {
		// There are cases when the page appears twice; one marked as deleted in comments_index
		// and one where its not marked deleted in comments_index.  This might represent a move.
		// If this is the case, prefer the un-deleted version.
		if ( !empty( $this->pages[$id] ) && $data["deleted_ind"] == 1 ) {
			return;
		}

		$this->pages[$id] = $data;
	}

	public function addTitle( $id, $title ) {
		$this->titles[$id] = $title;
	}

	public function removeTitle( $id ) {
		unset( $this->titles[ $id ] );
	}

	/**
	 * Page
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | Field             | Type                | Null | Key | Default        | Extra          |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | page_id           | int(10) unsigned    | NO   | PRI | NULL           | auto_increment |
	 * | page_namespace    | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * | page_title        | varchar(255)        | NO   |     | NULL           |                |
	 * | page_restrictions | tinyblob            | NO   |     | NULL           |                |
	 * | page_is_redirect  | tinyint(3) unsigned | NO   | MUL | 0              |                |
	 * | page_is_new       | tinyint(3) unsigned | NO   |     | 0              |                |
	 * | page_random       | double unsigned     | NO   | MUL | NULL           |                |
	 * | page_touched      | binary(14)          | NO   |     |                |                |
	 * | page_latest       | int(10) unsigned    | NO   |     | NULL           |                |
	 * | page_len          | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 *
	 * Comments_index
	 * +-----------------------+------------------+------+-----+---------------------+-------+
	 * | Field                 | Type             | Null | Key | Default             | Extra |
	 * +-----------------------+------------------+------+-----+---------------------+-------+
	 * | parent_page_id        | int(10) unsigned | NO   | PRI | NULL                |       |
	 * | comment_id            | int(10) unsigned | NO   | PRI | NULL                |       |
	 * | parent_comment_id     | int(10) unsigned | NO   | MUL | 0                   |       |
	 * | last_child_comment_id | int(10) unsigned | NO   |     | 0                   |       |
	 * | archived              | tinyint(1)       | NO   |     | 0                   |       |
	 * | deleted               | tinyint(1)       | NO   |     | 0                   |       |
	 * | removed               | tinyint(1)       | NO   |     | 0                   |       |
	 * | first_rev_id          | int(10) unsigned | NO   |     | 0                   |       |
	 * | created_at            | datetime         | NO   |     | 0000-00-00 00:00:00 |       |
	 * | last_rev_id           | int(10) unsigned | NO   |     | 0                   |       |
	 * | last_touched          | datetime         | NO   | MUL | 0000-00-00 00:00:00 |       |
	 * +-----------------------+------------------+------+-----+---------------------+-------+
	 *
	 * Page_wikia_props
	 * +----------+---------+------+-----+---------+-------+
	 * | Field    | Type    | Null | Key | Default | Extra |
	 * +----------+---------+------+-----+---------+-------+
	 * | page_id  | int(10) | NO   | MUL | NULL    |       |
	 * | propname | int(10) | NO   | MUL | NULL    |       |
	 * | props    | blob    | NO   |     | NULL    |       |
	 * +----------+---------+------+-----+---------+-------+
	 */
	public function getPages( $fh = null, $pageIdsFixed = [], $minIndex = -1 ) {
		if ( $fh == null || !empty( $this->pages ) ) {
			return $this->pages;
		}

		$pageIdsToOrder = $this->getPageIdsDisplayOrder( $pageIdsFixed, $minIndex );

		$pageIds = array_keys( $pageIdsToOrder );
		$pageIdsChunks = array_chunk( $pageIds, 500 );

		foreach ( $pageIdsChunks as $part ) {
			$inserts = [];
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			$dbh->ping();
			( new \WikiaSQL() )->SELECT( "page.page_id, page.page_namespace, page.page_title,
			 page.page_is_redirect, page.page_is_new, page.page_touched, page.page_latest, page.page_len, 
			 comments_index.parent_page_id, comments_index.comment_id, comments_index.parent_comment_id, 
			 comments_index.last_child_comment_id, comments_index.archived, comments_index.deleted, 
			 comments_index.removed, comments_index.created_at, comments_index.last_touched, 
			 comments_index.first_rev_id" )
				->FROM( self::TABLE_PAGE )
				->LEFT_JOIN( self::TABLE_COMMENTS )
				->ON( 'page_id', 'comment_id' )
				->WHERE( 'page_id' )
				->IN( $part )
				->runLoop(
					$dbh,
					function ( $result ) use ( $pageIdsToOrder, $dbh, $fh, &$inserts ) {

						while ( $row = $result->fetchObject() ) {
							// A few of these properties were removed and do not appear on some wikis
							foreach ( [ 'sticky', 'locked', 'protected' ] as $prop ) {
								if ( !property_exists( $row, $prop ) ) {
									$row->$prop = 0;
								}
							}

							$this->addPage(
								$row->page_id,
								[
									"page_id" => $row->page_id,
									"namespace" => $row->page_namespace,
									"raw_title" => $row->page_title,
									"latest_revision_id" => $row->page_latest,
									"first_revision_id" => $row->first_rev_id,
									"deleted_ind" => $row->deleted
								]
							);

							$insert = DumpUtils::createInsert(
									'import_page',
									self::COLUMNS_PAGE,
									[
										"page_id" => $row->page_id,
										"namespace" => $row->page_namespace,
										"raw_title" => $row->page_title,
										"is_redirect" => $row->page_is_redirect,
										"is_new" => $row->page_is_new,
										"touched" => $row->page_touched,
										"latest_revision_id" => $row->page_latest,
										"length" => $row->page_len,
										"parent_page_id" => $row->parent_page_id,
										"parent_comment_id" => $row->parent_comment_id,
										"last_child_comment_id" => $row->last_child_comment_id,
										"archived_ind" => $row->archived ?: 0,
										"deleted_ind" => $row->deleted ?: 0,
										"removed_ind" => $row->removed ?: 0,
										"locked_ind" => $row->locked ?: 0,
										"protected_ind" => $row->protected ?: 0,
										"sticky_ind" => $row->sticky ?: 0,
										"first_revision_id" => $row->page_latest, //we want just one revision
										"last_revision_id" => $row->page_latest,
										"comment_timestamp" => $row->last_touched,
										"display_order" => $pageIdsToOrder[$row->page_id],
									]
								) . "\n";

							$inserts[] = $insert;

							if ( !$this->bulk ) {
								fwrite( $fh, $insert );
								fflush( $fh );
							}

							$this->addTitle( $row->page_id, Title::newFromRow( $row ) );
						}

						$dbh->freeResult( $result );
					},
					[],
					false
				);

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );

			if ( $this->bulk && !empty( $inserts )) {
				$chunks = array_chunk( $inserts, 50);
				foreach ( $chunks as $chunk ) {
					$multiInsert = DumpUtils::createMultiInsert('import_page',
							self::COLUMNS_PAGE, $chunk) . "\n";
					fwrite( $fh, $multiInsert );
					fflush( $fh );
					unset( $multiInsert );
				}
			}

			unset( $inserts );
		}

		return $this->pages;
	}

	/**
	 * Revision
	 * +----------------+---------------------+------+-----+----------------+----------------+
	 * | Field          | Type                | Null | Key | Default        | Extra          |
	 * +----------------+---------------------+------+-----+----------------+----------------+
	 * | rev_id         | int(10) unsigned    | NO   | PRI | NULL           | auto_increment |
	 * | rev_page       | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * | rev_text_id    | int(10) unsigned    | NO   |     | NULL           |                |
	 * | rev_comment    | tinyblob            | NO   |     | NULL           |                |
	 * | rev_user       | int(10) unsigned    | NO   | MUL | 0              |                |
	 * | rev_user_text  | varchar(255)        | NO   | MUL |                |                |
	 * | rev_timestamp  | binary(14)          | NO   | MUL |                |                |
	 * | rev_minor_edit | tinyint(3) unsigned | NO   |     | 0              |                |
	 * | rev_deleted    | tinyint(3) unsigned | NO   |     | 0              |                |
	 * | rev_len        | int(10) unsigned    | YES  |     | NULL           |                |
	 * | rev_parent_id  | int(10) unsigned    | YES  |     | NULL           |                |
	 * | rev_sha1       | varbinary(32)       | NO   |     |                |                |
	 * +----------------+---------------------+------+-----+----------------+----------------+
	 *
	 * Text
	 * +-----------+------------------+------+-----+---------+----------------+
	 * | Field     | Type             | Null | Key | Default | Extra          |
	 * +-----------+------------------+------+-----+---------+----------------+
	 * | old_id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
	 * | old_text  | mediumblob       | NO   |     | NULL    |                |
	 * | old_flags | tinyblob         | NO   |     | NULL    |                |
	 * +-----------+------------------+------+-----+---------+----------------+
	 */
	public function getRevisions( $fh ) {
		$revIds = [];

		foreach ( $this->getPages() as $id => $data ) {
			$revIds[] = [$data['latest_revision_id'], $data['first_revision_id']];
		}

		$chunks = array_chunk($revIds, 500);
		$chunksNumber = count( $chunks );

		$currentBatch = 1;

		foreach ($chunks as $part) {

			WikiaLogger::instance()->info( "Batch " . $currentBatch . " of " . $chunksNumber );
			$currentBatch++;

			$tries = 3;
			$queryResult = null;

			do {
				$firstRevIds = [];
				foreach ( $part as $ids ) {
					$firstRevIds[] = $ids[1];
				}

				$firstRevsData = $this->getFirstRevsData( $firstRevIds );

				$latestRevIds = [];
				foreach ( $part as $ids ) {
					$latestRevIds[] = $ids[0];
				}

				$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
				$dbh->ping();
				$inserts = [];
				( new \WikiaSQL() )->SELECT( "revision.*, text.*" )
					->FROM( self::TABLE_REVISION )
					->JOIN( self::TABLE_TEXT )
					->ON( 'rev_text_id', 'old_id' )
					->WHERE( 'rev_id' )
					->IN( $latestRevIds )
					->runLoop(
						$dbh,
						function ( $result ) use ( $dbh, $fh, &$inserts, &$firstRevsData ) {

							while ($row = $result->fetchObject()) {

								if ( $this->debug ) {
									WikiaLogger::instance()->info( "Getting revision info for rev id: " .
																   $row->rev_id . " in thread: " . $row->rev_page,
										[$row->rev_id, $row->rev_page] );
								}

								$rev = \Revision::newFromRow( $row );

								list(
									$parsedText, $plainText, $title
									) =
									$this->getTextAndTitle( $row->rev_page, $row->rev_id, $rev );

								$pages = $this->getPages();
								$curPage = $pages[$row->rev_page];

								$firstRevData = array_key_exists( $row->rev_page, $firstRevsData ) ?
									$firstRevsData[$row->rev_page] : [];

								$insert = DumpUtils::createInsert(
									'import_revision',
									self::COLUMNS_REVISION,
									[
										"revision_id" => $row->rev_id,
										"page_id" => $row->rev_page,
										"page_namespace" => $curPage['namespace'],
										"title" => $title,
										"user_type" => $this->getContributorType( $row ),
										"user_identifier" => $row->rev_user,
										"timestamp" => $row->rev_timestamp,
										"is_minor_edit" => $row->rev_minor_edit,
										"is_deleted" => $row->rev_deleted,
										"length" => $row->rev_len,
										"parent_id" => $row->rev_parent_id,
										"text_flags" => $row->old_flags,
										"raw_content" => $plainText,
										"content" => $parsedText,
										"creation_timestamp" => empty($firstRevData) ? $row->rev_timestamp :
											$firstRevData['rev_timestamp'],
										"creation_user" => empty($firstRevData) ? $row->rev_user : $firstRevData['rev_user']
									]
								) . "\n";

								$inserts[] = $insert;

								if ( !$this->bulk ) {
									fwrite( $fh, $insert) ;
									fflush( $fh );
								}
							}

							$dbh->freeResult( $result );
						},
						false, false
					);

				$dbh->closeConnection();
				wfGetLB( false )->closeConnection( $dbh );

				if ( $this->bulk && !empty( $inserts )) {
					$chunks = array_chunk( $inserts, 10 );
					foreach ( $chunks as $chunk ) {
						$multiInsert = DumpUtils::createMultiInsert('import_revision',
								self::COLUMNS_REVISION, $chunk) . "\n";
						fwrite( $fh, $multiInsert );
						fflush( $fh );
						unset( $multiInsert );
					}
				}

				unset( $inserts );

				if ( $queryResult === false && $tries > 0 ) {
					WikiaLogger::instance()->info( "Retry used! (rev batch load) - ".( $tries - 1 )." left" );
				}

			} while ($queryResult === false && $tries-- > 0);

		}
	}

	/**
	 * Wall_related_pages
	 * +-------------+------------------+------+-----+-------------------+-----------------------------+
	 * | Field       | Type             | Null | Key | Default           | Extra                       |
	 * +-------------+------------------+------+-----+-------------------+-----------------------------+
	 * | comment_id  | int(10) unsigned | NO   | PRI | NULL              |                             |
	 * | page_id     | int(10) unsigned | NO   | PRI | NULL              |                             |
	 * | order_index | int(10) unsigned | NO   |     | NULL              |                             |
	 * | add_at      | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
	 * | last_update | timestamp        | YES  |     | NULL              |                             |
	 * +-------------+------------------+------+-----+-------------------+-----------------------------+
	 */
	public function getTopics( $fh ) {

		$pageIds = array_keys( $this->getPages() );
		$pageIdsChunks = array_chunk($pageIds, 500);
		$topicsNumber = 0;

		foreach ($pageIdsChunks as $part) {
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			$dbh->ping();
			$inserts = [];
			$queryResult = ( new \WikiaSQL() )->SELECT( "wall_related_pages.comment_id, wall_related_pages.page_id" )
				->FROM( self::TABLE_WALL_RELATED_PAGES )
				->JOIN( self::TABLE_PAGE )
				->AS_( 'p' )
				->ON( 'comment_id', 'p.page_id' )
				->WHERE( 'comment_id' )
				->IN( $part )
				->runLoop(
					$dbh,
					function ( $result ) use ( $dbh, $fh, &$topicsNumber, &$inserts ) {

						while ($row = $result->fetchObject()) {
							list( $title, $url ) = $this->getRelatedArticleData( $row->page_id );

							if ( $title && $url ) {
								$topicsNumber++;
								$id = $topicsNumber;

								$insert = DumpUtils::createInsert(
									'import_topics',
									self::COLUMNS_TOPICS,
									[
										"topic_id" => $id,
										"page_id" => $row->comment_id,
										"article_id" => $row->page_id,
										"article_title" => $title,
										"relative_url" => $url
									]
								) . "\n";

								$inserts[] = $insert;

								if ( !$this->bulk ) {
									fwrite( $fh, $insert) ;
									fflush( $fh );
								}
							}
						}

						$dbh->freeResult( $result );
					}, [], false
				);

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );

			if ( $this->bulk && !empty( $inserts )) {
				$chunks = array_chunk( $inserts, 100 );
				foreach ( $chunks as $chunk ) {
					$multiInsert = DumpUtils::createMultiInsert('import_topics',
							self::COLUMNS_TOPICS, $chunk) . "\n";
					fwrite( $fh, $multiInsert );
					fflush( $fh );
					unset( $multiInsert );
				}
			}

			unset( $inserts );
		}
	}

	public function getTextAndTitle( $textId, $revId, $rev ) {
		$tries = 3;
		$articleComment = false;
		do {
			$articleComment = \ArticleComment::newFromTitle( $this->titles[$textId] );
			if ( $articleComment === false && $tries > 0 ) {
				WikiaLogger::instance()->info( "Retry used! (article build) - ".( $tries - 1 )." left" );
			}
		} while( $articleComment === false && $tries-- > 0);

		$articleComment->mFirstRevision = $rev;
		$articleComment->mLastRevision = $rev;
		$articleComment->mLastRevId = $revId;
		$articleComment->mFirstRevId = $revId;

		$loadTries = 3;
		$loadStatus = false;
		do {
			$loadStatus = $articleComment->load();

			if ($loadStatus && !$articleComment->getRawText()) {
				WikiaLogger::instance()->info( "Revision text missing." );
				$loadStatus = false;
			}

			if ( $loadStatus === false && $loadTries > 0 ) {
				WikiaLogger::instance()->info( "Retry used! (article load) - ".( $loadTries - 1 )." left" );
			}

		} while( $loadStatus === false && $loadTries-- > 0 );

		$rawText = $this->getRawText( $articleComment );
		$title = $articleComment->getMetadata( 'title', '' );
		$parsedText = $this->getParsedText( $articleComment );

		if ( empty( $parsedText ) ) {
			// If there's nothing to parse, use rawText as the default
			$parsedText = $rawText;
		} else {
			// If there is parsed text, use the tag stripped version as rawText so it can
			// be the plaintext version (otherwise its full of wikitext)
			$rawText = strip_tags( $parsedText );
		}

		if ( $rawText && $parsedText ) {
			$rawText = preg_replace( self::ANON_WROTE_SELECTOR, self::ANON_WROTE_REPLACEMENT, $rawText );
			$parsedText = preg_replace( self::ANON_WROTE_SELECTOR, self::ANON_WROTE_REPLACEMENT, $parsedText );
			$parsedText = preg_replace( self::QUOTE_SELECTOR, self::QUOTE_REPLACEMENT, $parsedText );
		}

		// Truncate the strings if they are too big
		if ( strlen( $parsedText ) > self::MAX_CONTENT_SIZE ) {

			if ( $this->debug ) {
				WikiaLogger::instance()->info( "Truncate parsed text of " . $revId .
						" revision - " . strlen( $parsedText ) . " bytes.", [$revId] );
			}

			$parsedText = mb_strcut( $parsedText, 0, self::MAX_CONTENT_SIZE );

			if ( $this->debug ) {
				WikiaLogger::instance()->info( "Parsed text truncated to " . strlen( $parsedText ) .
					" bytes.", [] );
			}
		}
		if ( strlen( $rawText ) > self::MAX_CONTENT_SIZE ) {

			if ( $this->debug ) {
				WikiaLogger::instance()->info( "Truncate raw text of " . $revId .
											   " revision - " . strlen( $rawText ) . " bytes.", [$revId] );
			}

			$rawText = mb_strcut( $rawText, 0, self::MAX_CONTENT_SIZE );

			if ( $this->debug ) {
				WikiaLogger::instance()->info( "Raw text truncated to " . strlen( $rawText ) .
											   " bytes.", [] );
			}
		}

		$this->removeTitle( $textId );

		return [ $parsedText, $rawText, $title ];
	}

	private function getRawText( \ArticleComment $articleComment ) {
		$rawText = strip_tags( $articleComment->getRawText() );

		// There are some bogus characters in our data.  Strip them out
		return filter_var( $rawText, FILTER_UNSAFE_RAW,
			FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH );
	}

	private function getParsedText( \ArticleComment $articleComment ) {
		$wikiText = $articleComment->getRawText();

		// If this text appears not to have any markup, just return the text as is.
		if ( !preg_match( self::REGEXP_MATCH_HAS_MARKUP, $wikiText ) ) {
			return "";
		}

		$formattedText = $articleComment->getText();
		$formattedText = $this->updateLazyImages( $formattedText );
		$formattedText = $this->removeACMetadata( $formattedText );

		return $formattedText;
	}

	/**
	 * Matches lazy load image tags and de-lazifies them.  For example, this image tag:
	 *
	 *  <img
	 *     src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"
	 *     alt="Joker laughing"
	 *     class="lzy lzyPlcHld "
	 *     data-image-key="Joker_laughing.gif"
	 *     data-image-name="Joker laughing.gif"
	 *     data-src="http://vignette.wikia.nocookie.net/wonderland-org/images/d/d0/Joker_laughing.gif/revision/latest/scale-to-width-down/200?cb=20150901041046"
	 *     width="200"
	 *     height="154"
	 *     onload="if(typeof ImgLzy==='object'){ImgLzy.load(this)}"
	 *  >
	 *
	 * would match and update to:
	 *
	 *  <img
	 *     src="http://vignette.wikia.nocookie.net/wonderland-org/images/d/d0/Joker_laughing.gif/revision/latest/scale-to-width-down/200?cb=20150901041046"
	 *     alt="Joker laughing"
	 *     width="200"
	 *     height="154"
	 *  >
	 *
	 * @param $text
	 *
	 * @return mixed
	 */
	private function updateLazyImages( $text ) {
		return preg_replace( "/<img +[^>]+ +data-src=[^>]+><noscript>(<img[^>]+>)<\\/noscript>/",
			"$1", $text );
	}

	private function removeACMetadata( $text ) {
		return preg_replace( "#(<|&lt;)ac_metadata.+/ac_metadata(>|&gt;)#", '', $text );
	}

	public function getContributorType( $row ) {
		if ( empty( $row->rev_user_text ) ) {
			return self::CONTRIBUTOR_TYPE_UNKNOWN;
		}

		if ( $row->rev_deleted & \Revision::DELETED_USER ) {
			return self::CONTRIBUTOR_TYPE_DELETED;
		}

		if ( \IP::isIPv4( $row->rev_user_text ) ) {
			return self::CONTRIBUTOR_TYPE_IP;
		}

		return self::CONTRIBUTOR_TYPE_USER;
	}

	/**
	 * Page_vote
	 * +------------+-----------------+------+-----+---------+-------+
	 * | Field      | Type            | Null | Key | Default | Extra |
	 * +------------+-----------------+------+-----+---------+-------+
	 * | article_id | int(8) unsigned | NO   | PRI | NULL    |       |
	 * | user_id    | int(5) unsigned | NO   | PRI | NULL    |       |
	 * | time       | datetime        | NO   |     | NULL    |       |
	 * +------------+-----------------+------+-----+---------+-------+
	 */
	public function getVotes( $fh ) {

		$pageIds = array_keys( $this->getPages() );
		$pageIdsChunks = array_chunk($pageIds, 500);

		foreach ($pageIdsChunks as $part) {
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			$dbh->ping();
			$inserts = [];
			( new \WikiaSQL() )->SELECT_ALL()
				->FROM( self::TABLE_VOTE )
				->WHERE( 'article_id' )
				->IN( $part )
				->runLoop( $dbh, function ( $result ) use ( $dbh, $fh, &$inserts ) {

					while ($row = $result->fetchObject()) {
						$insert = DumpUtils::createInsert(
							'import_vote',
							self::COLUMNS_VOTE,
							[
								"page_id" => $row->article_id,
								"user_identifier" => $row->user_id,
								"timestamp" => $row->time,
							]
						) . "\n";

						$inserts[] = $insert;

						if ( !$this->bulk ) {
							fwrite( $fh, $insert) ;
							fflush( $fh );
						}
					}

					$dbh->freeResult( $result );
				}, [], false );

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );

			if ( $this->bulk && !empty( $inserts )) {
				$chunks = array_chunk( $inserts, 200 );
				foreach ( $chunks as $chunk ) {
					$multiInsert = DumpUtils::createMultiInsert('import_vote',
							self::COLUMNS_VOTE, $chunk) . "\n";
					fwrite( $fh, $multiInsert );
					fflush( $fh );
					unset( $multiInsert );
				}
			}

			unset( $inserts );
		}
	}

	public function getFollows( $fh ) {
		$threadsNamesToIds = $this->getThreadNamesToIds();

		$finder = new FollowsFinder( $threadsNamesToIds, $this->bulk );
		$finder->findFollows( $fh );
	}

	public function getWallHistory( $fh ) {
		$pageIdsInNamespace = $this->getPagesIds( NS_WIKIA_FORUM_BOARD );

		$dumper = new WallHistoryFinder( $pageIdsInNamespace, $this->bulk );
		$dumper->find( $fh );
	}

	private function getPagesIds($namespace) {
		$ids = [];

		foreach ( $this->getPages() as $id => $page ) {
			if ( $page["namespace"] == $namespace ) {
				$ids[] = $id;
			}
		}

		return $ids;
	}

	private function getThreadNamesToIds() {
		$threadsNamesToIds = [];
		foreach ( $this->getPages() as $id => $page ) {
			if ( $page["namespace"] == NS_WIKIA_FORUM_BOARD_THREAD ) {
				$threadsNamesToIds[$page["raw_title"]] = $id;
			}
		}
		return $threadsNamesToIds;
	}

	private function getRelatedArticleData( $textId ) {
		$title  = Title::newFromID( $textId );

		if ( !$title ) {
			return [null, null];
		}

		return [ $title->getText(), $title->getLocalURL() ];
	}

	private function getPageIdsDisplayOrder( array $pageIdsFixed, int $minIndex ) {
		$pageIdsToOrder = [];

		if ( $pageIdsFixed == null || empty( $pageIdsFixed ) || $minIndex == -1 ) {
			$display_order = 0;
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			( new \WikiaSQL() )->SELECT( "page.page_id, IF(pp.props is NULL,concat('i:', page.page_id, ';'), pp.props) as idx" )
				->FROM( self::TABLE_PAGE )
				->LEFT_JOIN( self::TABLE_PAGE_WIKIA_PROPS )
				->AS_( 'pp' )
				->ON( 'page.page_id', 'pp.page_id' )
				->AND_( 'propname', WPP_WALL_ORDER_INDEX )
				->WHERE( 'page_namespace' )
				->IN( self::FORUM_NAMEPSACES )
				->ORDER_BY( 'idx' )
				->runLoop( $dbh, function ( &$pages, $row ) use ( &$display_order, &$pageIdsToOrder ) {
					$pageIdsToOrder[$row->page_id] = $display_order ++;
				} );

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );
		} else {
			$display_order = $minIndex;
			foreach ( $pageIdsFixed as $pageId ) {
				$pageIdsToOrder[$pageId] = $display_order ++;
			}
		}

		return $pageIdsToOrder;
	}

	private function getFirstRevsData( $revIds = [] ) {
		$data = [];

		$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
		$dbh->ping();
		( new \WikiaSQL() )->SELECT( "r.rev_page, r.rev_user, r.rev_timestamp" )
			->FROM( self::TABLE_REVISION )
			->AS_( 'r' )
			->WHERE( 'r.rev_id' )
			->IN( $revIds )
			->runLoop(
				$dbh,
				function ( $result ) use ( $dbh, &$data ) {

					while ($row = $result->fetchObject()) {
						$data[$row->rev_page] = [
							"rev_user" => $row->rev_user,
							"rev_timestamp" => $row->rev_timestamp
						];
					}

					$dbh->freeResult( $result );
				},
				false, false
			);

		$dbh->closeConnection();
		wfGetLB( false )->closeConnection( $dbh );

		return $data;
	}

	public function getFirstRevCreatorByLatestRevision( $fh = null, $pageIdsFixed = [] ) {

		$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
		$dbh->ping();
		$inserts = [];
		( new \WikiaSQL() )->SELECT( "p.page_latest, r.rev_user_text, r.rev_deleted, r.rev_user" )
			->FROM( self::TABLE_PAGE )
			->AS_( 'p' )
			->LEFT_JOIN( self::TABLE_COMMENTS )
			->AS_( 'c' )
			->ON( 'p.page_id', 'c.comment_id' )
			->LEFT_JOIN( self::TABLE_REVISION )
			->AS_( 'r' )
			->ON( 'c.first_rev_id', 'r.rev_id' )
			->WHERE( 'p.page_id' )
			->IN( $pageIdsFixed )
			->runLoop(
				$dbh,
				function ( $result ) use ( $dbh, $fh ) {

					while ($row = $result->fetchObject()) {

						$dump = $row->page_latest . ';' . $row->rev_user . ';' . $this->getContributorType( $row ) . "\n";
						fwrite( $fh, $dump );
					}

					$dbh->freeResult( $result );
				},
				false, false
			);

		$dbh->closeConnection();
		wfGetLB( false )->closeConnection( $dbh );
	}

	public function getCreationDateByPageId( $fh = null, $pageIdsFixed = [] ) {

		$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
		$dbh->ping();
		$inserts = [];
		( new \WikiaSQL() )->SELECT( "p.page_id, p.page_touched, r.rev_timestamp" )
			->FROM( self::TABLE_PAGE )
			->AS_( 'p' )
			->LEFT_JOIN( self::TABLE_COMMENTS )
			->AS_( 'c' )
			->ON( 'p.page_id', 'c.comment_id' )
			->LEFT_JOIN( self::TABLE_REVISION )
			->AS_( 'r' )
			->ON( 'c.first_rev_id', 'r.rev_id' )
			->WHERE( 'p.page_id' )
			->IN( $pageIdsFixed )
			->runLoop(
				$dbh,
				function ( $result ) use ( $dbh, $fh ) {

					while ($row = $result->fetchObject()) {

						$timestamp = empty($row->rev_timestamp) ? $row->page_touched : $row->rev_timestamp;
						$dump = $row->page_id . ';' . "`site_id`" . ';' . $timestamp . "\n";
						fwrite( $fh, $dump );
					}

					$dbh->freeResult( $result );
				},
				false, false
			);

		$dbh->closeConnection();
		wfGetLB( false )->closeConnection( $dbh );
	}
}
