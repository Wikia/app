<?php
/**
 * Dumps the content of a post given by a post ID or a Thread:XXXX URL.  Examples:
 *
 *   # Dump the post and any replies for post with ID 3364 on golden girls (city ID 2619)
 *   SERVER_ID=2619 php dumpForumPostContent.php 3364
 *
 *   # Same thing but using a thread URL (note SERVER ID unecessary here):
 *   php dumpForumPostContent.php http://goldengirls.wikia.com/wiki/Thread:3364
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

$NO_SERVER = false;
$serverId = getenv("SERVER_ID");
if ( !$serverId ) {
	$NO_SERVER = true;
	putenv( "SERVER_ID=177" );
}

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/ForumDumper.php' );

class DumpForumPostContent extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dump the text of the comment and any replies';
	}

	public function execute() {
		$id = 0;
		$identifier = $this->getArg(0);
		$commentIdx = $this->getArg(1);

		global $NO_SERVER;
		if ( $NO_SERVER ) {
			$this->handleNoServer( $identifier, $commentIdx );
			exit(0);
		}

		if ( preg_match( "/Thread:([0-9]+)/", $identifier, $matches ) ) {
			$id = $matches[1];
		} elseif ( preg_match( "/^([0-9]+)$/", $identifier, $matches ) ) {
			$id = $matches[1];
		}

		if ( ! $id ) {
			echo "Could not find thread for $identifier (tried ID=$id)\n";
			exit(1);
		}

		$articleComment = $this->getArticleComment( $id );
		$replies = $this->getReplies( $articleComment );

		if ( $commentIdx ) {
			$commentIdx--;
			if ( $commentIdx >= count( $replies ) ) {
				echo "Reply $commentIdx does not exist\n";
				exit(1);
			}

			$articleComment = $this->getReplyComment( $commentIdx, $replies );
		}

		$rawText = $articleComment->getRawText();
		$renderedText = $articleComment->getText();

		echo "\n--- Raw content START ---\n$rawText\n--- END ---\n";
		echo "\n--- Rendered content START ---\n$renderedText\n--- END ---\n";

		$commentList = \ArticleCommentList::newFromTitle( $articleComment->getTitle() );
		$commentPages = $commentList->getAllCommentPages();

		usort( $commentPages, [DumpForumPostContent::class, "sort_comments"]);

		echo "\nComments\n";
		$idx = 0;
		/** @var \ArticleComment $comment */
		foreach ( $commentPages as $comment ) {
			$idx++;
			echo "$idx) <" . $comment->getTitle()->getArticleID() . "> " .
			     $comment->getTitle()->getBaseText()."\n";
		}
	}

	public function handleNoServer( $identifier, $index ) {
		// http://goldengirls.wikia.com/wiki/Thread:3364
		$regex = "/([^\\/\\.]+)\\.([^\\.]+\\.wikia-dev|wikia)\\.(us|pl|com)/";
		if ( preg_match( $regex, $identifier, $matches)	) {
			$wikiName = $matches[1];
			$wikiId = WikiFactory::DomainToID( "$wikiName.wikia.com" );

			$stack = debug_backtrace();
			$firstFrame = $stack[count($stack) - 1];
			$initialFile = $firstFrame['file'];

			$php = PHP_BINARY;
			passthru("SERVER_ID=$wikiId $php $initialFile $identifier $index");
		} else {
			echo "Without full URL, SERVER_ID=XXX must be used\n";
			exit(1);
		}
	}

	public function getArticleComment( $id ) {
		$articleComment = \ArticleComment::newFromId( $id );
		$articleComment->load();
		return $articleComment;
	}

	/**
	 * @param ArticleComment $comment
	 * @return array[ArticleComment]
	 */
	public function getReplies( ArticleComment $comment ) {
		$commentList = \ArticleCommentList::newFromTitle( $comment->getTitle() );
		$commentPages = $commentList->getAllCommentPages();
		usort( $commentPages, [DumpForumPostContent::class, "sort_comments"]);
		return array_values( $commentPages );
	}

	public function getReplyComment( $index, $replies ) {
		/** @var ArticleComment $reply */
		$reply = $replies[$index];
		$replyId = $reply->getTitle()->getArticleID();
		return $this->getArticleComment( $replyId );
	}

	/**
	 * @param ArticleComment $a
	 * @param ArticleComment $b
	 *
	 * @return int
	 */
	public static function sort_comments( $a, $b ) {
		$aId = $a->getTitle()->getArticleID();
		$bId = $b->getTitle()->getArticleID();

		return $aId <=> $bId;
	}
}

$maintClass = DumpForumPostContent::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
