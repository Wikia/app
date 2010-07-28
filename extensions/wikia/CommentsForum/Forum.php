<?php
// GLOBAL VIDEO NAMESPACE REFERENCE
define( 'NS_COMMENT_FORUM', 100 );

// default setup for displaying sections
$wgForumPageDisplay['leftcolumn'] = true;
$wgForumPageDisplay['rightcolumn'] = true;
$wgForumPageDisplay['author'] = true;
$wgForumPageDisplay['author_articles'] = true;
$wgForumPageDisplay['recent_editors'] = true;
$wgForumPageDisplay['recent_voters'] = true;
$wgForumPageDisplay['left_ad'] = true;
$wgForumPageDisplay['popular_articles'] = true;
$wgForumPageDisplay['in_the_news'] = true;
$wgForumPageDisplay['comments_of_day'] = true;
$wgForumPageDisplay['games'] = true;
$wgForumPageDisplay['new_articles'] = true;

$wgHooks['ArticleFromTitle'][] = 'wfForumFromTitle';

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['CommentsForum'] =  "$dir/Forum.i18n.php";

$wgExtensionCredits['other'][] = array(
	'name' => 'CommentsForum',
	'url' => 'http://www.wikia.com' ,
	'descriptionmsg' => 'commentsforum-desc',
);

// ArticleFromTitle
// Calls BlogPage instead of standard article
function wfForumFromTitle( &$title, &$article ) {
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgMessageCache, $wgStyleVersion,
	$wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories, $wgParser;

	if ( NS_COMMENT_FORUM == $title->getNamespace()  ) {
		$wgParser->disableCache();
		$wgOut->enableClientCache( false );

		if ( !$wgRequest->getVal( "action" ) ) {
			$wgSupressPageTitle = true;
		}

		$wgSupressSubTitle = true;
		$wgSupressPageCategories = true;

		require_once( "$IP/extensions/wikia/CommentsForum/ForumPage.php" );
		$wgOut->addScript( "<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/CommentsForum/ForumPage.css?{$wgStyleVersion}\"/>\n" );

		$article = new ForumPage( $wgTitle );
	}

	return true;
}
