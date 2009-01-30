<?php

/**
 * loader for blog articles
 * @package MediaWiki
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Piotr Molski <moli@wikia-inc.com>
 * @author Adrian Wieczorek <adi@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
	"name" => "BlogArticles",
	"description" => "Blog Articles",
	"url" => "http://help.wikia.com/wiki/Help:Blog_article",
	"version" => preg_replace( '/^.* (\d\d\d\d-\d\d-\d\d).*$/', '\1', '$Id: WikiFactory.php 13985 2008-06-16 15:20:38Z eloy $' ),
	"author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)], Piotr Molski, Adrian Wieczorek"
);

define( "NS_BLOG_ARTICLE", 500 );
define( "NS_BLOG_ARTICLE_TALK", 501 );
define( "NS_BLOG_LISTING", 502 );
define( "NS_BLOG_LISTING_TALK", 503 );
define( "BLOGTPL_TAG", "bloglist" );


$wgExtraNamespaces[ NS_BLOG_ARTICLE ] = "User_blog";
$wgExtraNamespaces[ NS_BLOG_ARTICLE_TALK ] = "User_blog_comment";
$wgExtraNamespaces[ NS_BLOG_LISTING ] = "Blog";
$wgExtraNamespaces[ NS_BLOG_LISTING_TALK ] = "Blog_talk";

$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE_TALK ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING_TALK ] = true;

/**
 * localized blog ns - proof of concept aka quick hack
 *
 * @see SMW includes/SMW_GlobalFunctions.php::smwfInitNamespaces
 * FIXME generalize
 */
if ('de' == $wgLanguageCode) {
	// make en ns point (alias) to "main ns" - at this point themselves
	foreach (array(500, 501, 502, 503) as $ns) {
		$wgNamespaceAliases[$wgExtraNamespaces[$ns]] = $ns;
	}
	// translate "main ns" into de
	$wgExtraNamespaces[500] = 'Benutzer_Blog';
	$wgExtraNamespaces[501] = 'Benutzer_Blog_Kommentare';
	$wgExtraNamespaces[502] = 'Blog';
	$wgExtraNamespaces[503] = 'Blog_Diskussion';
	// the end: de name is the "main ns", en is just an alias (redirect)
}

/**
 * setup function
 */
$wgAutoloadClasses[ "BlogArticle" ] = dirname(__FILE__) . '/BlogArticle.php';
$wgExtensionFunctions[] = "BlogArticle::setup";

/**
 * messages file
 */
$wgExtensionMessagesFiles["Blogs"] = dirname(__FILE__) . '/Blogs.i18n.php';

/**
 * permissions (eventually will be moved to CommonSettings.php)
 */
$wgAvailableRights[] = 'blog-comments-toggle';
$wgAvailableRights[] = 'blog-comments-delete';

$wgGroupPermissions['*'][ 'blog-comments-toggle' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-toggle' ] = true;

$wgGroupPermissions['*'][ 'blog-comments-delete' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-delete' ] = true;

$wgGroupPermissions['*'][ "blog-articles-edit" ] = false;
$wgGroupPermissions['sysop'][ "blog-articles-edit" ] = true;
$wgGroupPermissions['staff'][ "blog-articles-edit" ] = true;
$wgGroupPermissions['helper'][ "blog-articles-edit" ] = true;

/**
 * Special pages
 */
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogPage.php', 'CreateBlogPage', 'CreateBlogPage');
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogListingPage.php', 'CreateBlogListingPage', 'CreateBlogListingPage');

$wgSpecialPageGroups['CreateBlogPage'] = 'wikia';
$wgSpecialPageGroups['CreateBlogListingPage'] = 'wikia';

/**
 * ajax functions
 */
$wgAjaxExportList[] = "CreateBlogListingPage::axBlogListingCheckMatches";

/**
 * hooks
 */
$wgHooks['AlternateEdit'][] = 'SpecialBlogPage::alternateEditHook';

/**
 * load other parts
 */
if (empty($wgWikiaEnableUserMasthead)) {
	$wgWikiaEnableUserMasthead = true;
}
include( dirname( __FILE__ ) . "/SpecialBlogPage.php");
include( dirname( __FILE__ ) . "/BlogTemplate.php");
include( dirname( __FILE__ ) . "/BlogArticle.php");
include( dirname( __FILE__ ) . "/BlogComments.php");
include( dirname( __FILE__ ) . "/BlogLockdown.php");

/**
 * add task
 */
if( function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask( dirname(__FILE__)."/BlogTask.php", "blog", "BlogTask" );
}
