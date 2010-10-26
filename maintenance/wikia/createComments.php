<?php
/*
 * Create test/bogus blog comments for testing purposes
 */

print("Bootstrapping ... ");

putenv("SERVER_ID=79860");
$argv[] = '--conf';
$argv[] = '/usr/wikia/docroot/wiki.factory/LocalSettings.php';

$wikia_base = dirname(dirname( __FILE__ ));

$bootstrap_file = $wikia_base . '/commandLine.inc';
if( is_file( $bootstrap_file ) ) {
    require_once( $bootstrap_file );
} else {
    error_log("Can't find command line include file '$bootstrap_file'");
}

print("done\n");

$article_id = $argv[0];
$title = Title::newFromID( $article_id );
if ( ! $title instanceof Title ) {
	die("Could not make new comment from article ID '$article_id'");
}

createComment($title, $argv[1], $argv[2]);

/**
* clear comments cache for this article
*/
$title->invalidateCache();
$title->purgeSquid();
$listing = BlogArticle::getOwnerTitle( $title );
if( $listing ) {
	$listing->invalidateCache();
	$listing->purgeSquid();
}

$key = $title->getPrefixedDBkey();
$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );

$clist = BlogCommentList::newFromTitle( $title );
$clist->getCommentPages( true );


function createComment($title = null, $commenter = null, $text = null) {
	global $wgTitle;

	$text = $text ? $text : 'The quick brown fox jumps over the lazy dog';
	$commentTitle = Title::newFromText(sprintf("%s/%s-%s",
												$title->getText(),
												$commenter,
												wfTimestampNow()
									   ),
									   NS_BLOG_ARTICLE_TALK
									  );
	$wgTitle = $commentTitle;

	/**
	 * add article using EditPage class (for hooks)
	*/
	$result   = null;
	$article  = new Article( $commentTitle, 0 );
	$editPage = new EditPage( $article );
	$editPage->edittime = $article->getTimestamp();
	$editPage->textbox1 = $text;
	$retval = $editPage->internalAttemptSave( $result );
	Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

	return array( $retval, $article );
}

?>
