<?php
//GLOBAL VIDEO NAMESPACE REFERENCE
define( 'NS_BLOG', 500 );

//default setup for displaying sections
$wgBlogPageDisplay['leftcolumn'] = true;
$wgBlogPageDisplay['rightcolumn'] = true;
$wgBlogPageDisplay['author'] = true;
$wgBlogPageDisplay['author_articles'] = true;
$wgBlogPageDisplay['recent_editors'] = true;
$wgBlogPageDisplay['recent_voters'] = true;
$wgBlogPageDisplay['left_ad'] = true;
$wgBlogPageDisplay['popular_articles'] = true;
$wgBlogPageDisplay['in_the_news'] = true;
$wgBlogPageDisplay['comments_of_day'] = true;
$wgBlogPageDisplay['games'] = true;
$wgBlogPageDisplay['new_articles'] = true;


$wgHooks['ArticleFromTitle'][] = 'wfBlogFromTitle';
$wgExtensionMessagesFiles['Blog'] = dirname(__FILE__).'/Blog.i18n.php';

//ArticleFromTitle
//Calls BlogPage instead of standard article
function wfBlogFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgMessageCache, $wgStyleVersion, $wgParser,
	$wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories;

	if ( NS_BLOG == $title->getNamespace()  ) {
		if( !$wgRequest->getVal("action") ){
			$wgSupressPageTitle = true;
		}

		$wgSupressSubTitle = true;
		$wgSupressPageCategories = true;

		//this will supress in SkinTemplate Skin
		global $wgHooks;
		$wgHooks["SkinTemplateOutputPageBeforeExec"][] = "wfSuppressCategoryLinks";

		$wgOut->enableClientCache(false);
		$wgParser->disableCache();

		wfLoadExtensionMessages( 'Blog' );

		require_once( "BlogPage.php" );
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/BlogPage/BlogPage.css?{$wgStyleVersion}\"/>\n");

		$article = new BlogPage($wgTitle);
	}

	return true;
}

$wgExtensionFunctions[] = "wfFixRHTML";

function wfFixRHTML() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "rhtml", "FixRHTML" );
}

function FixRHTML(){
	return "";
}
