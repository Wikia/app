<?php

namespace Discussions;

class ForumDumper {

	const TABLE_PAGE = 'page';
	const TABLE_COMMENTS = 'comments_index';
	const TABLE_REVISION = 'revision';
	const TABLE_TEXT = 'text';
	const TABLE_VOTE = 'page_vote';

	const CONTRIBUTOR_TYPE_USER = "user";
	const CONTRIBUTOR_TYPE_IP = "ip";
	const CONTRIBUTOR_TYPE_DELETED = "[deleted]";
	const CONTRIBUTOR_TYPE_UNKNOWN = "[unknown]";

	// Discussions uses TEXT columns for content, which are limited to 2**16 bytes.  Also
	// subtracting 16 bytes from the max size since going right up to the limit still causes
	// MySQL to fail the insert.
	const MAX_CONTENT_SIZE = 65520;

	const REGEXP_MATCH_TITLE = '/<ac_metadata.*title="([^"]*)".*>.*<\/ac_metadata>/';

	// A very loose interpretation of markup favoring false positives for markup.  Match
	// alphanumerics, anything in a basic URL and punctuation.  If any character in the text
	// doesn't match, assume there is wiki text and parse it.
	const REGEXP_MATCH_HAS_MARKUP = '/[^a-zA-Z0-9\.\/:\?&%" ]/';

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
		"comment_timestamp"
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
		"comment",
		"raw_content",
		"content"
	];

	const COLUMNS_VOTE = [
		"page_id",
		"user_identifier",
		"timestamp",
	];

	private $pages = [];
	private $revisions = [];
	private $votes = [];

	private $dummyTitle;
	private $parserOptions;

	public function __construct() {
		$this->dummyTitle = \Title::newFromText( "Dummy" );
		$this->parserOptions = new \ParserOptions();
		$this->parserOptions->setEditSection( false );
	}

	private function getForumNamespaces() {
		return [
			NS_WIKIA_FORUM_BOARD,
			NS_WIKIA_FORUM_BOARD_THREAD
		];
	}

	public function addPage( $id, $data ) {
		$this->pages[$id] = $data;
	}

	public function addRevision( $data ) {
		$this->revisions[] = $data;
	}

	public function addVote( $data ) {
		$this->votes[] = $data;
	}

	public function getPages() {
		if ( !empty( $this->pages ) ) {
			return $this->pages;
		}

		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::TABLE_PAGE )
			->LEFT_JOIN( self::TABLE_COMMENTS )->ON( 'page_id', 'comment_id' )
			->WHERE( 'page_namespace' )->IN( $this->getForumNamespaces() )
			->runLoop( $dbh, function ( &$pages, $row ) {
				$this->addPage( $row->page_id, [
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
						"first_revision_id" => $row->first_rev_id,
						"last_revision_id" => $row->last_rev_id,
						"comment_timestamp" => $row->last_touched
					] );
			} );

		return $this->pages;
	}

	public function getRevisions() {
		if ( !empty( $this->revisions ) ) {
			return $this->revisions;
		}
		
		$pageIds = array_keys( $this->getPages() );

		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::TABLE_REVISION )
			->JOIN( self::TABLE_TEXT )->ON( 'rev_text_id', 'old_id' )
			->WHERE( 'rev_page' )->IN( $pageIds )
			->runLoop( $dbh, function ( &$revisions, $row ) {
				$textId = $row->old_text;
				list( $parsedText, $plainText, $title ) = $this->getTextAndTitle( $textId );

				$pages = $this->getPages();
				$curPage = $pages[$row->rev_page];
				
				$this->addRevision( [
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
					"comment" => $row->rev_comment,
					"raw_content" => $plainText,
				    "content" => $parsedText
				] );
			} );

		return $this->revisions;
	}

	public function getTextAndTitle( $textId ) {
		$rawText = $this->getRawText( $textId );

		// There are some bogus characters in our data.  Strip them out
		$rawText = filter_var(
			$rawText,
			FILTER_UNSAFE_RAW,
			FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH
		);

		// The title is included within the text as an ac_metadata tag
		$title = $this->getTitle( $rawText );

		// Parse the wiki text
		$parsedText = $this->getParsedText( $rawText );

		// Get a plain text version as well
		$plainText = strip_tags( $parsedText );

		// Truncate the strings if they are too big
		if ( strlen($parsedText) > self::MAX_CONTENT_SIZE ) {
			$parsedText = substr( $parsedText, 0, self::MAX_CONTENT_SIZE );
		}
		if ( strlen($plainText) > self::MAX_CONTENT_SIZE ) {
			$plainText = substr( $plainText, 0, self::MAX_CONTENT_SIZE );
		}

		return [ $parsedText, $plainText, $title ];
	}

	private function getRawText( $textId ) {
		$text = \ExternalStore::fetchFromURL( $textId );
		return gzinflate( $text );
	}

	private function getParsedText( $wikiText ) {
		// If this text appears not to have any markup, just return the text as is.
		if ( !preg_match( self::REGEXP_MATCH_HAS_MARKUP, $wikiText ) ) {
			return $wikiText;
		}

		$parserOut = \F::app()->wg->Parser->parse(
			$wikiText,
			$this->dummyTitle,
			$this->parserOptions
		);
		return $parserOut->getText();
	}

	private function getTitle( $text ) {
		$title = '';

		if ( preg_match( self::REGEXP_MATCH_TITLE, $text, $matches ) ) {
			$title = $matches[1];
		}

		return $title;
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

	public function getVotes() {
		if ( !empty( $this->votes ) ) {
			return $this->votes;
		}

		$pageIds = array_keys( $this->getPages() );

		$dumper = $this;
		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::TABLE_VOTE )
			->WHERE( 'article_id' )->IN( $pageIds )
			->runLoop( $dbh, function ( &$pages, $row ) {

				$this->addVote( [
					"page_id" => $row->article_id,
					"user_identifier" => $row->user_id,
					"timestamp" => $row->time
				] );
			} );

		return $this->votes;
	}
}
