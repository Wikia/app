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
	"svn-date" => '$LastChangedDate$',
	"svn-revision" => '$LastChangedRevision$',
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

// $wgExtensionFunctions[] = array('BlogArticle', 'createCategory');

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

// initialize blogs special pages (BugId:7604)
$wgHooks['BeforeInitialize'][] = 'wfBlogsOnBeforeInitialize';

function wfBlogsOnBeforeInitialize( &$title, &$article, &$output, User $user, $request, $mediaWiki ) {
	global $wgAutoloadClasses;

	// this line causes initialization of the skin
	// title before redirect handling is passed causing BugId:7282 - it will be fixed in "AfterInitialize" hook
	$skinName = get_class( $user->getSkin() );

	if ( $skinName == 'SkinMonoBook' ) {
		$wgAutoloadClasses['CreateBlogPage'] = __DIR__ . '/monobook/SpecialCreateBlogPage.php';
	}

	return true;
}

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
$wgHooks[ 'EditPage::showEditForm:checkboxes' ][] = 'BlogArticle::editPageCheckboxes';
$wgHooks[ 'LinksUpdate' ][] = 'BlogArticle::linksUpdate';
$wgHooks[ 'UnwatchArticleComplete' ][] = 'BlogArticle::UnwatchBlogComments';
$wgHooks[ 'AfterCategoriesUpdate'][] = 'BlogArticle::clearCountCache';
$wgHooks[ 'SpecialSearchProfiles' ][] = 'BlogsHelper::OnSpecialSearchProfiles';
$wgHooks[ 'ParserBeforeInternalParse' ][] = 'BlogsHelper::OnParserBeforeInternalParse';
$wgHooks[ 'ArticleInsertComplete' ][] = 'BlogsHelper::OnArticleInsertComplete';
$wgHooks[ 'TitleMoveComplete' ][] = 'BlogsHelper::onTitleMoveComplete';

// Usages of images on blogs on file pages
$wgHooks['FilePageImageUsageSingleLink'][] = 'BlogsHelper::onFilePageImageUsageSingleLink';

// Checking that user is permitted to delete blog articles
$wgHooks['BeforeDeletePermissionErrors'][] = 'BlogLockdown::onBeforeDeletePermissionErrors';

/**
 * load other parts
 */
include( __DIR__ . "/BlogTemplate.php" );
include( __DIR__ . "/BlogArticle.php" );
include( __DIR__ . "/BlogLockdown.php" );
