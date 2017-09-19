<?php

namespace Discussions;

class ForumDumper {

	const TABLE_PAGE = 'page';
	const TABLE_COMMENTS = 'comments_index';
	const TABLE_REVISION = 'revision';
	const TABLE_TEXT = 'text';
	const TABLE_VOTE = 'page_vote';
	const TABLE_PAGE_WIKIA_PROPS = 'page_wikia_props';

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
		"comment",
		"raw_content",
		"content",
	];

	const COLUMNS_VOTE = [
		"page_id",
		"user_identifier",
		"timestamp",
	];

	const FORUM_NAMEPSACES = [
		NS_WIKIA_FORUM_BOARD,
		NS_WIKIA_FORUM_BOARD_THREAD,
	];

	private $pages = [];
	private $revisions = [];
	private $votes = [];

	public function addPage( $id, $data ) {
		// There are cases when the page appears twice; one marked as deleted in comments_index
		// and one where its not marked deleted in comments_index.  This might represent a move.
		// If this is the case, prefer the un-deleted version.
		if ( !empty( $this->pages[$id] ) && $data["deleted_ind"] == 1 ) {
			return;
		}

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

		$display_order = 0;
		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )->SELECT( "page.*, comments_index.*, IF(pp.props is NULL,concat('i:', page.page_id, ';'), pp.props) as idx" )
			->FROM( self::TABLE_PAGE )
			->LEFT_JOIN( self::TABLE_COMMENTS )
			->ON( 'page_id', 'comment_id' )
			->LEFT_JOIN( self::TABLE_PAGE_WIKIA_PROPS )
			->AS_( 'pp' )
			->ON( 'page.page_id', 'pp.page_id' )
			->AND_( 'propname', WPP_WALL_ORDER_INDEX )
			->WHERE( 'page_namespace' )
			->IN( self::FORUM_NAMEPSACES )
			->ORDER_BY( 'idx' )
			->runLoop( $dbh, function ( &$pages, $row ) use ( &$display_order ) {
				// A few of these properties were removed and do not appear on some wikis
				foreach ( [ 'sticky', 'locked', 'protected' ] as $prop ) {
					if ( !property_exists( $row, $prop ) ) {
						$row->$prop = 0;
					}
				}

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
					"comment_timestamp" => $row->last_touched,
					"display_order" => $display_order ++,
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
		( new \WikiaSQL() )->SELECT_ALL()
			->FROM( self::TABLE_REVISION )
			->JOIN( self::TABLE_TEXT )
			->ON( 'rev_text_id', 'old_id' )
			->WHERE( 'rev_page' )
			->IN( $pageIds )
			->runLoop( $dbh, function ( &$revisions, $row ) {
				list( $parsedText, $plainText, $title ) = $this->getTextAndTitle( $row->rev_page );

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
					"content" => $parsedText,
				] );
			} );

		return $this->revisions;
	}

	public function getTextAndTitle( $textId ) {
		$articleComment = \ArticleComment::newFromId( $textId );
		$articleComment->load();

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

		// Truncate the strings if they are too big
		if ( strlen( $parsedText ) > self::MAX_CONTENT_SIZE ) {
			$parsedText = substr( $parsedText, 0, self::MAX_CONTENT_SIZE );
		}
		if ( strlen( $rawText ) > self::MAX_CONTENT_SIZE ) {
			$rawText = substr( $rawText, 0, self::MAX_CONTENT_SIZE );
		}

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

	public function getVotes() {
		if ( !empty( $this->votes ) ) {
			return $this->votes;
		}

		$pageIds = array_keys( $this->getPages() );

		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )->SELECT_ALL()
			->FROM( self::TABLE_VOTE )
			->WHERE( 'article_id' )
			->IN( $pageIds )
			->runLoop( $dbh, function ( &$pages, $row ) {

				$this->addVote( [
					"page_id" => $row->article_id,
					"user_identifier" => $row->user_id,
					"timestamp" => $row->time,
				] );
			} );

		return $this->votes;
	}

	public function getFollows() {
		$threadsNamesToIds = $this->getThreadNamesToIds();
		$finder = new FollowsFinder( wfGetDB( DB_SLAVE ), $threadsNamesToIds );

		return $finder->findFollows();
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

}
