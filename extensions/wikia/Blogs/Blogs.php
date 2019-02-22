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
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/Blogs",
	"author" => array( '[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]', 'Piotr Molski', 'Adrian Wieczorek', '[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]' )
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

$wgExtensionNamespacesFiles[ 'Blogs' ] = __DIR__ . "/Blogs.namespaces.php";

wfLoadExtensionNamespaces( 'Blogs', array( NS_BLOG_LISTING, NS_BLOG_LISTING_TALK, NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ) );

/**
 * setup function
 */
$wgAutoloadClasses[ "BlogArticle" ] = __DIR__ . '/BlogArticle.php';
$wgAutoloadClasses[ "WikiaApiBlogs" ] = __DIR__ . "/api/WikiaApiBlogs.php";

global $wgAPIModules;
$wgAPIModules[ "blogs" ] = "WikiaApiBlogs";

/**
 * messages file
 */
$wgExtensionMessagesFiles['Blogs'] = __DIR__ . '/Blogs.i18n.php';
$wgExtensionMessagesFiles['BlogsAliases'] = __DIR__ . '/Blogs.alias.php';
$wgExtensionMessagesFiles['BlogsMagic'] = __DIR__ . '/Blogs.i18n.magic.php';

// special pages
$wgAutoloadClasses['CreateBlogListingPage'] = __DIR__ . '/SpecialCreateBlogListingPage.php';
$wgSpecialPages['CreateBlogListingPage'] = 'CreateBlogListingPage';

$wgAutoloadClasses['SpecialBlogPage'] = __DIR__ . '/SpecialBlogPage.php';
$wgAutoloadClasses['CreateBlogPage'] = __DIR__ . '/SpecialCreateBlogPage.php';
$wgSpecialPages['CreateBlogPage'] = 'CreateBlogPage';
$wgSpecialPages['Myblog'] = 'SpecialMyblog';
$wgAutoloadClasses['SpecialMyblog'] = __DIR__ . '/SpecialMyblog.php';
$wgAutoloadClasses['BlogsHelper'] = __DIR__ . '/BlogsHelper.class.php';

$wgSpecialPageGroups['CreateBlogPage'] = 'wikia';
$wgSpecialPageGroups['CreateBlogListingPage'] = 'wikia';

/**
 * ajax functions
 */
$wgAjaxExportList[] = "CreateBlogListingPage::axBlogListingCheckMatches";

/**
 * hooks
 */
$wgHooks[ 'AlternateEdit' ][] = 'BlogArticle::alternateEditHook';
$wgHooks[ 'ArticleFromTitle' ][] = 'BlogArticle::ArticleFromTitle';
$wgHooks[ 'onSkinTemplateNavigation' ][] = 'BlogArticle::skinTemplateTabs';
$wgHooks[ 'UnwatchArticleComplete' ][] = 'BlogArticle::UnwatchBlogComments';
$wgHooks[ 'AfterCategoriesUpdate'][] = 'BlogArticle::clearCountCache';
$wgHooks[ 'SpecialSearchProfiles' ][] = 'BlogsHelper::OnSpecialSearchProfiles';
$wgHooks[ 'ParserBeforeInternalParse' ][] = 'BlogsHelper::OnParserBeforeInternalParse';
$wgHooks[ 'ArticleInsertComplete' ][] = 'BlogsHelper::OnArticleInsertComplete';
$wgHooks[ 'TitleMoveComplete' ][] = 'BlogsHelper::onTitleMoveComplete';
$wgHooks[ 'PageHeaderActionButtonShouldDisplay' ][] = 'BlogsHelper::onPageHeaderActionButtonShouldDisplay';

// Usages of images on blogs on file pages
$wgHooks['FilePageImageUsageSingleLink'][] = 'BlogsHelper::onFilePageImageUsageSingleLink';

// Checking that user is permitted to delete blog articles
$wgHooks['BeforeDeletePermissionErrors'][] = 'BlogLockdown::onBeforeDeletePermissionErrors';

// SUS-260: Prevent moving pages into or out of Forum namespaces
$wgHooks['AbortMove'][] = 'BlogsHelper::onAbortMove';

$wgHooks['AfterPageHeaderButtons'][] = 'BlogsHelper::onAfterPageHeaderButtons';

$wgHooks['WantedPages::getExcludedNamespaces'][] = 'BlogsHelper::onWantedPagesGetExcludedNamespaces';

// load other parts
$wgAutoloadClasses['BlogTemplateClass'] = __DIR__ . '/BlogTemplate.php';
$wgAutoloadClasses['BlogArticle'] = __DIR__ . '/BlogArticle.php';
$wgAutoloadClasses['BlogLockdown'] =  __DIR__ . "/BlogLockdown.php";
$wgAutoloadClasses['BlogListingController'] = __DIR__ . '/BlogListingController.class.php';

$wgAjaxExportList[] = "BlogTemplateClass::axShowCurrentPage";
/* register as a parser function {{BLOGTPL_TAG}} and a tag <BLOGTPL_TAG> */
$wgHooks['ParserFirstCallInit'][] = "BlogTemplateClass::setParserHook";
$wgHooks['userCan'][] = 'BlogLockdown::userCan';

define ( "BLOGS_TIMESTAMP", "20081101000000" );
define ( "BLOGS_XML_REGEX", "/\<(.*?)\>(.*?)\<\/(.*?)\>/si" );
define ( "BLOGS_DEFAULT_LENGTH", "400" );
define ( "BLOGS_HTML_PARSE", "/(<.+?>)?([^<>]*)/s" );
define ( "BLOGS_ENTITIES_PARSE", "/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i" );
define ( "BLOGS_CLOSED_TAGS", "/^<\s*\/([^\s]+?)\s*>$/s" );
define ( "BLOGS_OPENED_TAGS", "/^<\s*([^\s>!]+).*?>$/s" );
