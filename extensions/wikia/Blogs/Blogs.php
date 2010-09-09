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
	"descriptionmsg" => "blogs-desc",
	"url" => "http://help.wikia.com/wiki/Help:Blog_article",
	"svn-date" => '$LastChangedDate$',
	"svn-revision" => '$LastChangedRevision$',
	"author" => array('[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]', 'Piotr Molski', 'Adrian Wieczorek', '[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

//namespaces
define( "NS_BLOG_ARTICLE", 500 );
define( "NS_BLOG_ARTICLE_TALK", 501 );
define( "NS_BLOG_LISTING", 502 );
define( "NS_BLOG_LISTING_TALK", 503 );
define( "BLOGTPL_TAG", "bloglist" );

$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE_TALK ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING_TALK ] = true;

$wgExtensionNamespacesFiles[ 'BlogArticles' ] = dirname(__FILE__) . '/Blogs.namespaces.php';

wfLoadExtensionNamespaces( 'BlogArticles', array(
	NS_BLOG_ARTICLE,
	NS_BLOG_ARTICLE_TALK,
	NS_BLOG_LISTING,
	NS_BLOG_LISTING_TALK
) );

/**
 * setup function
 */
$wgAutoloadClasses[ "BlogArticle" ] = dirname(__FILE__) . '/BlogArticle.php';
$wgAutoloadClasses[ "WikiaApiBlogs" ] = dirname(__FILE__) . "/api/WikiaApiBlogs.php";

global $wgAPIModules;
$wgAPIModules[ "blogs" ] = "WikiaApiBlogs";


$wgHooks['ArticleFromTitle'][] = "BlogArticle::setup";

/**
 * messages file
 */
$wgExtensionMessagesFiles['Blogs'] = dirname(__FILE__) . '/Blogs.i18n.php';
$wgExtensionAliasesFiles['Blogs'] = dirname(__FILE__) . '/Blogs.alias.php';

/**
 * permissions (eventually will be moved to CommonSettings.php)
 */
$wgAvailableRights[] = 'blog-comments-toggle';
$wgAvailableRights[] = 'blog-comments-delete';
$wgAvailableRights[] = 'blog-articles-edit';
$wgAvailableRights[] = 'blog-articles-move';
$wgAvailableRights[] = 'blog-articles-protect';
$wgAvailableRights[] = 'blog-auto-follow';

$wgGroupPermissions['*'][ 'blog-comments-toggle' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-toggle' ] = true;

$wgGroupPermissions['*'][ 'blog-comments-delete' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-delete' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-edit' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-edit' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-edit' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-edit' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-move' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-move' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-move' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-move' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-protect' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-protect' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-protect' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-protect' ] = true;

$wgGroupPermissions['*'][ 'blog-auto-follow' ] = false;
$wgGroupPermissions['sysop'][ 'blog-auto-follow' ] = false;
$wgGroupPermissions['staff'][ 'blog-auto-follow' ] = true;
$wgGroupPermissions['helper'][ 'blog-auto-follow' ] = false;

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
include( dirname( __FILE__ ) . "/SpecialBlogPage.php");
include( dirname( __FILE__ ) . "/BlogTemplate.php");
include( dirname( __FILE__ ) . "/BlogArticle.php");
include( dirname( __FILE__ ) . "/BlogLockdown.php");

/**
 * add task
 */
if( function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask( dirname(__FILE__)."/BlogTask.php", "blog", "BlogTask" );
}
